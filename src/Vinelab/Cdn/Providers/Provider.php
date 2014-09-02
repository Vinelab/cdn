<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Providers\Contracts\ProviderInterface;

abstract class Provider implements ProviderInterface{

    /**
     * @var string
     */
    protected $key;
    /**
     * @var string
     */
    protected $secret;
    /**
     * @var string
     */
    protected $url;

    /**
     * @var Instance of the console object
     */
    public $console;


    abstract function upload($assets);

} 
