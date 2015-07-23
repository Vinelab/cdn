<?php

namespace Vinelab\Cdn\Providers;

use Vinelab\Cdn\Providers\Contracts\ProviderInterface;

/**
 * Class Provider.
 *
 * @category Drivers Abstract Class
 *
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
    protected $region;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Instance of the console object
     */
    public $console;

    abstract public function upload($assets);
}
