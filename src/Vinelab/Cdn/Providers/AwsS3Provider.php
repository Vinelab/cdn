<?php namespace Vinelab\Cdn\Providers;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Guzzle\Batch\BatchBuilder;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

/**
 * Class AwsS3Provider
 * @package Vinelab\Cdn\Provider
 */
class AwsS3Provider extends Provider implements ProviderInterface{


    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $protocol;

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
    protected $acl = 'public-read';

    /**
     * @var integer
     */
    protected $threshold = 10;

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
     * @param \Symfony\Component\Console\Output\ConsoleOutput $console
     */
    public function __construct(ConsoleOutput $console)
    {
        $this->console = $console;
    }

    /**
     * assign configurations to the class and check if required fields exist
     *
     * @param $supplier
     *
     * @return $this
     */
    public function init($supplier)
    {
        $this->domain       = $supplier['domain'];
        $this->protocol     = $supplier['protocol'];
        $this->url          = $supplier['url'];
        $this->key          = $supplier['key'];
        $this->secret       = $supplier['secret'];
        $this->acl          = $supplier['acl'];
        $this->threshold    = $supplier['threshold'];
        $this->buckets      = $supplier['buckets'];

        return $this;
    }

    /**
     * Create a cdn instance and create a batch builder instance
     */
    public function connect()
    {
        // Instantiate an S3 client
        $this->s3_client = S3Client::factory( array(
                    'key'    => $this->key,
                    'secret' => $this->secret,
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
     */
    public function upload($assets)
    {
        // connect before uploading
        $this->connect();

        // user terminal message
        $this->console->writeln('<fg=red>Start Uploading...</fg=red>');

        // upload each asset file to the CDN
        foreach($assets as $file)
        {

            // user terminal message
            $this->console->writeln('<fg=green>File:   ' . $file->getRealpath() . '</fg=green>');

            try {
                $this->batch->add($this->s3_client->getCommand('PutObject', [

                            'Bucket'    =>      key($this->buckets), // the bucket name
                            'Key'       =>      $file->GetPathName(), // the path of the file on the server (CDN)
                            'Body'      =>      fopen($file->getRealpath(), 'r'), // the path of the path locally
                            'ACL'       =>      $this->acl, // the permission of the file

                        ]));
            } catch (S3Exception $e) {
                echo "There was an error uploading this file ($file->getRealpath()).\n";
            }

        }

        // Execute batch.
        $commands = $this->batch->flush();

        foreach($commands as $command)
        {
            $result = $command->getResult();
            // user terminal message
            $this->console->writeln('<fg=black;bg=green>URL:    ' . $result->get('ObjectURL')  . '</fg=black;bg=green>');
        }

        // user terminal message
        $this->console->writeln('<fg=red>Upload completed successfully.</fg=red>');
    }


    public function urlGenerator($path)
    {   // todo: clean every value before building the url
        return $this->protocol . '://' . key($this->buckets) . '.' . $this->domain . '/' . $path;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return array
     */
    public function getBuckets()
    {
        return $this->buckets;
    }


}
