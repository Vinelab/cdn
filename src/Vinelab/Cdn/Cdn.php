<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\FinderInterface;
use Vinelab\Cdn\Contracts\PathHolderInterface;
use Vinelab\Cdn\Contracts\ProviderHolderInterface;

/**
 * Class Cdn is the manager and the main class of this package
 * @package Vinelab\Cdn
 */
class Cdn implements CdnInterface{

    /**
     * An object of the 'Repository' class that allows reading the laravel config files
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * An instance of the finder class
     *
     * @var Contracts\
     */
    protected $finder;

    /**
     * The object that will hold the directories configurations and the paths data
     *
     * @var Contracts\PathHolderInterface
     */
    protected $path_holder;

    /**
     * @param Repository $config
     * @param FinderInterface $finder
     * @param PathHolderInterface $path_holder
     * @param ProviderHolderInterface $provider_holder
     */
    public function __construct(Repository $config,
                                FinderInterface $finder,
                                PathHolderInterface $path_holder,
                                ProviderHolderInterface $provider_holder
                                )
    {
        $this->config               = $config;
        $this->finder               = $finder;
        $this->path_holder          = $path_holder;
        $this->provider_holder      = $provider_holder;

    }


    /**
     * Will be called from the Vinelab\Cdn\PushCommand class on Fire()
     */
    public function push(){

        // return the configurations from the config file
        $configurations = $this->getConfig();

        // get files to upload
        $assets = $this->getAssets($configurations);

        // TODO: to continue from here..
//        dd($assets);

    }


    /**
     * Check if the config file exist and return it or
     * throw an exception
     */
    private function getConfig()
    {
        $configs = $this->config->get('cdn::cdn');

        if(!$configs){
            // TODO: throw an exception
        }

        return $configs;
    }

    /**
     * Initialize an instance of the asset holder and pass it to the
     * read function in the reader class, to return all the allowed
     * assets for upload
     *
     * @param $configurations
     *
     * @return mixed
     */
    private function getAssets($configurations)
    {
        return $this->finder->read($this->path_holder->init($configurations));
    }



}
