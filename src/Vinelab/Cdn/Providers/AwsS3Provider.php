<?php namespace Vinelab\Cdn\Providers;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Validators\Contracts\ConfigurationsInterface;
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Vinelab\Cdn\Contracts\CdnHelperInterface;
use Aws\S3\Exception\S3Exception;
use Guzzle\Batch\BatchBuilder;
use Aws\S3\S3Client;

/**
 * Amazon (AWS) S3
 *
 * Class AwsS3Provider
 * @package Vinelab\Cdn\Provider
 */
class AwsS3Provider extends Provider implements ProviderInterface{

    /**
     * All the configurations needed by this class with the
     * optional configurations default values
     *
     * @var array
     */
    protected $default = [
        'url' => null,
        'threshold' => 10,
        'providers' => [
            'aws' => [
                's3' => [
                    'credentials' => [
                        'key'       => null,
                        'secret'    => null,
                    ],
                    'buckets' => null,
                    'acl' => 'public-read',
                ]
            ]
        ],
    ];

    /**
     * Required configurations (must exist in the config file)
     *
     * @var array
     */
    protected $rules = ['key', 'secret', 'buckets', 'url'];

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * the type of permission on the files on the CDN
     *
     * @var string
     */
    protected $acl;

    /**
     * @var integer
     */
    protected $threshold;

    /**
     * @var array
     */
    protected $buckets;
    /**
     * @var boolean
     */
    protected $multiple_buckets;

    /**
     * @var Instance of Aws\S3\S3Client
     */
    protected $s3_client;

    /**
     * @var Instance of Guzzle\Batch\BatchBuilder
     */
    protected $batch;

    /**
     * @var \Vinelab\Cdn\Contracts\CdnHelperInterface
     */
    protected $cdn_helper;

    /**
     * @var \Vinelab\Cdn\Validators\Contracts\ConfigurationsInterface
     */
    protected $configurations;

    /**
     * @param \Symfony\Component\Console\Output\ConsoleOutput $console
     * @param \Vinelab\Cdn\Validators\Contracts\ConfigurationsInterface $configurations
     * @param \Vinelab\Cdn\Contracts\CdnHelperInterface $cdn_helper
     */
    public function __construct(
        ConsoleOutput           $console,
        ConfigurationsInterface $configurations,
        CdnHelperInterface      $cdn_helper
    ) {
        $this->console          = $console;
        $this->configurations   = $configurations;
        $this->cdn_helper       = $cdn_helper;
    }

    /**
     * Assign configurations to the properties and return itself
     *
     * @param $configurations
     *
     * @return $this
     */
    public function init($configurations)
    {
        $supplier = $this->parse($configurations);

        $this->url          = $supplier['url'];
        $this->key          = $supplier['key'];
        $this->secret       = $supplier['secret'];
        $this->acl          = $supplier['acl'];
        $this->threshold    = $supplier['threshold'];
        $this->buckets      = $supplier['buckets'];

        return $this;
    }

    /**
     * Read the configuration and prepare an array with the relevant configurations
     * for the (AWS S3) provider.
     *
     * @param $configurations
     *
     * @return array
     */
    private function parse($configurations)
    {
        // merge the received config array with the default configurations array to
        // fill missed keys with null or default values.
        $this->default = array_merge($this->default, $configurations);

        // TODO: to be removed to a function of common configurations between call providers
        $threshold  = $this->default['threshold'];
        $url        = $this->default['url'];

        // aws s3 specific configurations
        $key        = $this->default['providers']['aws']['s3']['credentials']['key'];
        $secret     = $this->default['providers']['aws']['s3']['credentials']['secret'];
        $buckets    = $this->default['providers']['aws']['s3']['buckets'];
        $acl        = $this->default['providers']['aws']['s3']['acl'];

        $supplier = [
            'url'       => $url,
            'key'       => $key,
            'secret'    => $secret,
            'acl'       => $acl,
            'threshold' => $threshold,
            'buckets'   => $buckets,
        ];

        // check if any required configuration is missed
        $this->configurations->validate($supplier, $this->rules);

        return $supplier;
    }

    /**
     * Create a cdn instance and create a batch builder instance
     */
    private function connect()
    {
        // Instantiate an S3 client
        $this->s3_client = S3Client::factory( array(
                    'key'       => $this->key,
                    'secret'    => $this->secret,
                )
            );

        // Initialize the batch builder
        $this->batch = BatchBuilder::factory()
            ->transferCommands($this->threshold)
            ->autoFlushAt($this->threshold)
            ->build();
    }

    /**
     * Upload assets
     *
     * @param $assets
     */
    public function upload($assets)
    {
        // connect before uploading
        $this->connect();

        // user terminal message
        $this->console->writeln('<fg=yellow>Uploading in progress...</fg=yellow>');

        // upload each asset file to the CDN
        foreach ($assets as $file) {

            try {
                $this->batch->add($this->s3_client->getCommand('PutObject', [

                    'Bucket'    => key($this->buckets), // the bucket name
                    'Key'       => $file->GetPathName(), // the path of the file on the server (CDN)
                    'Body'      => fopen($file->getRealpath(), 'r'), // the path of the path locally
                    'ACL'       => $this->acl, // the permission of the file

                ]));
            } catch (S3Exception $e) {
                echo "There was an error uploading this file ($file->getRealpath()).\n";
            }

        }

        // Execute batch.
        $commands = $this->batch->flush();

        // Fix: in small threshold output is not available (batch related thing)
        foreach ($commands as $command) {
            $result = $command->getResult();
            // user terminal message
            $this->console->writeln('<fg=magenta>URL: ' . $result->get('ObjectURL') . '</fg=magenta>');
        }

        // user terminal message
        $this->console->writeln('<fg=green>Upload completed successfully.</fg=green>');
    }

    /**
     * This function will be called from the CdnFacade class when
     * someone use this {{ Cdn::asset('') }} facade helper
     *
     * @param $path
     *
     * @return string
     */
    public function urlGenerator($path)
    {
        $url = $this->cdn_helper->parseUrl($this->getUrl());

        return $url['scheme'] . '://' . $this->getBucket() . '.' . $url['host'] . '/' . $path;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return rtrim($this->url, "/") . '/';
    }


    /**
     * @return array
     */
    public function getBucket()
    {
        return rtrim(key($this->buckets), "/");
    }

}
