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
     * Create and return an instance of the corresponding
     * Provider concrete according to the configuration
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
        $threshold        = $configurations['threshold'];
        $protocol         = $configurations['protocol'];
        $domain           = $configurations['domain'];

        // compose the url from the protocol and the domain
        $url = $protocol . '://' . $domain;

        switch ($default_provider == 'aws.s3')
        {
            case 'aws.s3':

                $credentials = $configurations['providers']['aws']['s3']['credentials'];
                $buckets     = $configurations['providers']['aws']['s3']['buckets'];
                $acl         = $configurations['providers']['aws']['s3']['acl'];

                return App::make('Vinelab\Cdn\Providers\AwsS3Provider')->init($credentials, $url, $buckets, $acl, $threshold);
                break;

            case 'cloudfront':
                // ...
                break;

            default:
                throw new UnsupportedProviderException("CDN provider ($this->provider_name) not supported");
        }

    }




}
