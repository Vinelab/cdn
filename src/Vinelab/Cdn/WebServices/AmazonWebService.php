<?php namespace Vinelab\Cdn\WebServices;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */
use Vinelab\Cdn\WebServices\Contracts\WebServiceInterface;

class AmazonWebService extends WebService implements WebServiceInterface{


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