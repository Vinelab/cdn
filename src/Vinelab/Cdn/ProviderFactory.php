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
 * This class is responsible of creating objects from the default
 * provider found in the config file.
 *
 * Class ProviderFactory
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
     * @return
     * @internal param $
     */
    public function create($configurations = array())
    {
        // get the default provider name
        $default_provider = $configurations['default'];

        if( $default_provider )
        {
            switch ($default_provider == 'aws.s3')
            {
                case 'aws.s3':
                    // first call the provider supplier function to render the configuration and return an array of the
                    // relevant configurations for this provider then create an instance of this provider,
                    // finally call the init function of this provider object to read and process the configuration
                    return App::make('Vinelab\Cdn\Providers\AwsS3Provider')->init($this->awsS3Supplier($configurations));
                    break;

                case 'cloudfront':
                    // ...
                    break;

                default:
                    throw new UnsupportedProviderException("CDN provider ($this->provider_name) is not supported");
            }
        }
        else
        {
            throw new MissingConfigurationException("Missing Configurations: Default Provider");
        }
    }


    /**
     * Read the configuration and prepare an array with the relevant configurations
     * for the (AWS S3) provider.
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

        // TODO: to be removed to a function of common configurations between call providers
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
