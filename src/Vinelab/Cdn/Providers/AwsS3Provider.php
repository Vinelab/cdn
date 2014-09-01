<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
/**
 * Class AwsS3Provider
 * @package Vinelab\Cdn\Provider
 */
class AwsS3Provider extends Provider implements ProviderInterface{

    /**
     * @var Array
     */
    protected $buckets;
    /**
     * @var Boolean
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
     * @param \Symfony\Component\Console\Output\ConsoleOutput $console
     */
    public function __construct(ConsoleOutput $console)
    {
        parent::__construct();

        $this->console = $console;
    }

    public function init($credentials, $url, $buckets)
    {

        $this->key = isset($credentials['key']) ? $credentials['key'] : null;
        $this->secret = isset($credentials['secret']) ? $credentials['secret'] : null;
        $this->buckets = isset($buckets) ? $buckets : null;

        // check if any configuration is missed
        if( ! $this->key || ! $this->secret || ! $url || ! $buckets || ! count($buckets) > 1 )
        {
            throw new MissingConfigurationException("Missing Configuration");
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
        foreach($assets as $file){

            // user terminal message
            $this->console->writeln('<fg=green>File:   ' . $file->getRealpath() . '</fg=green>');

            try {
                $result = $this->s3_client->putObject( array(

                        'Bucket'    =>      key($this->buckets), // the bucket name
                        'Key'       =>      $file->GetPathName(), // the path of the file on the server (CDN)
                        'Body'      =>      fopen($file->getRealpath(), 'r'), // the path of the path locally
                        'ACL'       =>      $this->acl, // the permission of the file

                    ));
                // user terminal message
                $this->console->writeln('<fg=black;bg=green>URL:    ' . $result->get('ObjectURL')  . '</fg=black;bg=green>');

            } catch (S3Exception $e) {
                echo "There was an error uploading this file ($file->getRealpath()).\n";
            }

        }
        // user terminal message
        $this->console->writeln('<fg=red>Upload completed successfully.</fg=red>');
    }



} 
