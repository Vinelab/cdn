<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;

class AwsS3Provider extends Provider implements ProviderInterface{

    /**
     * @var Array
     */
    protected $buckets;
    /**
     * @var Boolean
     */
    protected $multiple_buckets;


    public function __construct($credentials, $url, $buckets)
    {

        $this->key = isset($credentials['key']) ? $credentials['key'] : null;
        $this->secret = isset($credentials['secret']) ? $credentials['secret'] : null;

        // check if any configuration is missed
        if(! $this->key || ! $this->secret || ! $url || ! $buckets || ! count($buckets) > 1)
        {
            throw new MissingConfigurationException("Missing Configuration");
        }


    }




} 
