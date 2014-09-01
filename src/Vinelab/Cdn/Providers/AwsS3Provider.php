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
        // Instantiate the S3 client using your credential profile
        $this->s3_client = S3Client::factory(array(
                'includes' => array('_aws'),
                'services' => array(
                    'default_settings' => array(
                        'params' => array(
                            'key'    => $this->key,
                            'secret' => $this->secret,
                            // OR: 'profile' => 'my_profile',
//                        'region' => 'us-west-2'
                        )
                    )
                )
            ));

    }


    /**
     * Upload assets
     */
    public function upload($assets)
    {

        // connect before uploading
        $this->connect();

        var_dump('Uploading..');


        foreach($assets as $asset){
            var_dump($asset);
            sleep(1);
        }
        exit;
        // Upload a publicly accessible file. The file size, file type, and MD5 hash
        // are automatically calculated by the SDK.
        try {
            $this->s3_client->putObject(array(
                    'Bucket' => 'my-bucket',
                    'Key'    => 'my-object',
                    'Body'   => fopen('/path/to/file', 'r'),
                    'ACL'    => 'public-read',
                ));
        } catch (S3Exception $e) {
            echo "There was an error uploading the file.\n";
        }

    }



} 
