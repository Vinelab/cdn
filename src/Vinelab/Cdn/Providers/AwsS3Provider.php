<?php namespace Vinelab\Cdn\Provider;

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
     * @param $credentials
     * @param $url
     * @param $buckets
     * @param $acl
     * @param $threshold
     *
     * @throws \Vinelab\Cdn\Exceptions\MissingConfigurationException
     * @return $this
     */
    public function init($credentials, $url, $buckets, $acl, $threshold)
    {
        // required fields
        $this->key = isset($credentials['key']) ? $credentials['key'] : null;
        $this->secret = isset($credentials['secret']) ? $credentials['secret'] : null;
        $this->buckets = isset($buckets) ? $buckets : null;
        // optional fields
        $this->acl = isset($acl) ? $acl : $this->acl;
        $this->threshold = isset($threshold) ? $threshold : $this->threshold;

        // check if any required field is missed
        if( ! $this->key || ! $this->secret || ! $url || ! $buckets || ! count($buckets) > 1 )
        {
            $fields = ['(key)' => $this->key,
                       '(secret)' => $this->secret,
                       '(url)' => $url,
                       '(bucket)' => key($buckets),
                       'missed' => ' '
                      ];
            // check which field is missed
            foreach ($fields as $key => $value) {
                if (empty($value)){
                    $fields['missed'] .= $key;
                }
            }

            throw new MissingConfigurationException("Missing Configurations:" . $fields['missed'] );
        }

        return $this;
    }

    /**
     * Connect to the CDN
     */
    public function connect()
    {
        // Instantiate an S3 client
        $this->s3_client = S3Client::factory( array(

                    'key'    => $this->key,
                    'secret' => $this->secret,

                )

            );


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



} 
