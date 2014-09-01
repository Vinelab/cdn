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


    abstract function connect();

    abstract function upload($assets);

} 
