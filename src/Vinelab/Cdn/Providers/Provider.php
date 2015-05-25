<?php
namespace Vinelab\Cdn\Providers;

use Vinelab\Cdn\Providers\Contracts\ProviderInterface;

/**
 * Class Provider
 *
 * @category Drivers Abstract Class
 * @package  Vinelab\Cdn\Providers
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
abstract class Provider implements ProviderInterface
{

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
