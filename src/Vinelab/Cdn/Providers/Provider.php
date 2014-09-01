<?php namespace Vinelab\Cdn\Provider;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Symfony\Component\Console\Output\ConsoleOutputInterface;

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

    /**
     * @var Instance of the console object
     */
    public $console;


    public function __construct()
    {

    }

    abstract function connect();

    abstract function upload($assets);

} 
