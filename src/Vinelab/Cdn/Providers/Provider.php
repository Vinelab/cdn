<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

abstract class Provider{

    /**
     * @var String
     */
    protected $key;
    /**
     * @var String
     */
    protected $secret;
    /**
     * @var String
     */
    protected $url;





    public function upload()
    {

        $this->connect();

        // TODO: upload files to CDN

    }



    private function connect()
    {

        // TODO: connect to the CDN
        var_dump('Connecting..');


    }



} 
