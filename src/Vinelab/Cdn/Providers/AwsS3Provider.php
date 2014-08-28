<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */
use Vinelab\Cdn\Providers\Contracts\ProviderInterface;

class AwsS3Provider extends Provider implements ProviderInterface{


    public function __construct(){


    }

    /**
     * Connect to the CDN
     *
     * @param $credentials
     *
     * @internal param $providerName
     */
    public function connect($credentials){

        // TODO: connect to the CDN
        var_dump('I will connect using: ');
        var_dump($credentials);

    }



} 