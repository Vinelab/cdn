<?php namespace Vinelab\Cdn;
/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Illuminate\Support\Facades\App;
use Vinelab\Cdn\Exceptions\UnsupportedProviderException;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Provider\AwsS3Provider;

/**
 * Read configurations then create and return the Provider object
 * @package Vinelab\Cdn
 */

class ProviderFactory implements ProviderFactoryInterface{


    /**
     * Create and return an instance of the corresponding
     * Provider concrete according to the configuration
     *
     * @param array $configurations
     *
     * @throws Exceptions\UnsupportedProviderException
     * @throws Exceptions\MissingConfigurationException
     * @return null|AwsS3Provider
     */
    public function create($configurations = array())
    {
        $default_provider = $configurations['default'];

        if( $default_provider )
        {
            switch ($default_provider == 'aws.s3')
            {
                case 'aws.s3':

                    return App::make('Vinelab\Cdn\Providers\AwsS3Provider')->init($this->awsS3Supplier($configurations));
                    break;

                case 'cloudfront':
                    // ...
                    break;

                default:
                    throw new UnsupportedProviderException("CDN provider ($this->provider_name) not supported");
            }
        }
        else
        {
            throw new MissingConfigurationException("Missing Configurations: Default Provider");
        }
    }


    /**
     * Read the configuration and prepare an array for with
     * all the info need by it's provider (AWS S3 Provider)
     *
     * @param $configurations
     *
     * @throws MissingConfigurationException
     * @return array
     */
    public function awsS3Supplier($configurations)
    {

        // Aws s3 default configurations
        $default = [
            'protocol' => 'https',
            'domain' => null,
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

        // merge the received config array with the default configurations array to
        // fill missed keys with null or default values.
        $default = array_merge($default, $configurations);

        // search for any null or empty field to throw an exception
        $missing = '';
        foreach ( $default as $key => $value) {
            // Fix: needs to check for the sub arrays also
            if (empty($value) || $value == null || $value == '')
            {
                $missing .= $key;
            }
        }

        if($missing)
            throw new MissingConfigurationException("Missing Configurations:" . $missing );


        $threshold   = $default['threshold'];
        $protocol    = $default['protocol'];
        $domain      = $default['domain'];

        // aws s3 specific configurations
        $key         = $default['providers']['aws']['s3']['credentials']['key'];
        $secret      = $default['providers']['aws']['s3']['credentials']['secret'];
        $buckets     = $default['providers']['aws']['s3']['buckets'];
        $acl         = $default['providers']['aws']['s3']['acl'];

        $supplier = [
            'domain' => $domain,
            'protocol' => $protocol,
            'url' => $protocol . '://' . $domain,  // compose the url from the protocol and the domain
            'key' => $key,
            'secret' => $secret,
            'acl' => $acl,
            'threshold' => $threshold,
            'buckets' => $buckets,
        ];

        return $supplier;
    }


}
