<?php namespace Vinelab\Cdn;
/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Exceptions\UnsupportedProviderException;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;

/**
 * Class ProviderHolder used to parse and hold all server credentials and configuration info
 * @package Vinelab\Cdn
 */
class ProviderFactory{

    /**
     * @var String
     */
    protected $provider_name;
    /**
     * @var String
     */
    protected $url;
    /**
     * @var String
     */
    protected $key;
    /**
     * @var String
     */
    protected $secret;
    /**
     * @var Array
     */
    protected $buckets;
    /**
     * @var Boolean
     */
    protected $multiple_buckets;


    public function __construct()
    {

    }


    /**
     * build a ProviderHolder object that contains the provider related configurations
     *
     * @param array $configurations
     *
     * @return $this
     */
    public function init($configurations = array())
    {
          $this->parseAndFillConfiguration($configurations);
dd($this);
//        $this->included_directories  = $this->default_include['directories'];
//        $this->included_extensions   = $this->default_include['extensions'];
//        $this->included_patterns     = $this->default_include['patterns'];
//
//        $this->excluded_directories  = $this->default_exclude['directories'];
//        $this->excluded_files        = $this->default_exclude['files'];
//        $this->excluded_extensions   = $this->default_exclude['extensions'];
//        $this->excluded_patterns     = $this->default_exclude['patterns'];
//        $this->exclude_hidden        = $this->default_exclude['hidden'];

        return $this;
    }


    /**
     * Check if the config file has any missed attribute,
     * and store the configurations in this class attributes
     *
     * @param $configurations
     *
     * @throws Exceptions\UnsupportedProviderException
     * @throws Exceptions\MissingConfigurationException
     */
    public function parseAndFillConfiguration($configurations)
    {
        // to work with short names in this function, I store the array in local vars
        $provider_name  = $configurations['default'];
        $url            = $configurations['url'];
        $key            = $configurations['providers']['aws']['s3']['credentials']['key'];
        $secret         = $configurations['providers']['aws']['s3']['credentials']['secret'];
        $buckets        = $configurations['providers']['aws']['s3']['buckets'];

        // check if any configuration is missed
        if( ! $provider_name || ! $url || ! $key || ! $secret || ! $buckets || ! count($buckets) > 1)
        {
            throw new MissingConfigurationException("Missing Configuration");
        }

        // assign local variables to global variables
        $this->provider_name = $provider_name;
        $this->url           = $url;

        // for each provider assign the specific global variables
        switch ($this->provider_name)
        {
            case 'aws.s3':

                $this->key              = $key;
                $this->secret           = $secret;
                $this->buckets          = $buckets;
                $this->multiple_buckets = count($this->buckets) > 1 ? true : false;

                break;

            case 'cloudfront':
                // ...
                break;

            default:
                throw new UnsupportedProviderException("CDN provider not ($this->provider_name) supported");
        }

    }




}
