<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


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
     * @param $credentials
     * @param $url
     * @param $buckets
     *
     * @throws \Vinelab\Cdn\Exceptions\MissingConfigurationException
     */
    public function __construct($credentials, $url, $buckets)
    {
        $this->key = isset($credentials['key']) ? $credentials['key'] : null;
        $this->secret = isset($credentials['secret']) ? $credentials['secret'] : null;
        $this->buckets = isset($credentials['buckets']) ? $credentials['buckets'] : null;

        // check if any configuration is missed
        if( ! $this->key || ! $this->secret || ! $url || ! $buckets || ! count($buckets) > 1 )
        {
            throw new MissingConfigurationException("Missing Configuration");
        }

    }


    /**
     * Connect to the CDN
     */
    public function connect()
    {
        var_dump('Connecting..');

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

        var_dump('Start uploader..');

        // upload each asset file to the CDN
        foreach($assets as $file){

            var_dump( 'Uploading: ' . $file->getRealpath() );

            try {
                $result = $this->s3_client->putObject( array(

                        'Bucket'    =>      key($this->buckets), // the bucket name
                        'Key'       =>      $file->GetPathName(), // the path of the file on the server (CDN)
                        'Body'      =>      fopen($file->getRealpath(), 'r'), // the path of the path locally
                        'ACL'       =>      $this->acl, // the permission of the file

                    ));

                var_dump( 'Uploaded successfully to: ' . $result->get('ObjectURL') );

            } catch (S3Exception $e) {
                echo "There was an error uploading this file ($file->getRealpath()).\n";
            }

        }
    }



} 
