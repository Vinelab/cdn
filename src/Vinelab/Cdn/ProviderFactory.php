<?php namespace Vinelab\Cdn;
/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Illuminate\Support\Facades\App;
use Vinelab\Cdn\Exceptions\UnsupportedProviderException;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Provider\AwsS3Provider;

/**
 * Read configurations then create and return the Provider object
 * @package Vinelab\Cdn
 */
class ProviderFactory implements ProviderFactoryInterface{


    /**
     * Create and return an instance of the corresponding provider class
     * after reading the configurations of the default provider
     *
     * @param array $configurations
     *
     * @return null|AwsS3Provider
     * @throws Exceptions\UnsupportedProviderException
     */
    public function create($configurations = array())
    {
        // TODO: use merger as replacement for the isset

        // to work with short names in this function, I store the array in local vars
        $default_provider = $configurations['default'];
        $url              = $configurations['url'];

        switch ($default_provider == 'aws.s3')
        {
            case 'aws.s3':

                $credentials = $configurations['providers']['aws']['s3']['credentials'];
                $buckets     = $configurations['providers']['aws']['s3']['buckets'];

                return App::make('Vinelab\Cdn\Provider\AwsS3Provider')->init($credentials, $url, $buckets);
                break;

            case 'cloudfront':
                // ...
                break;

            default:
                throw new UnsupportedProviderException("CDN provider not ($this->provider_name) supported");
                return null;
        }

    }




}
