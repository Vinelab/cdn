<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\FinderInterface;
use Vinelab\Cdn\Contracts\AssetHolderInterface;
use Vinelab\Cdn\Contracts\ProviderHolderInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationFileException;

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
     * The object that will hold the assets configurations
     * and the paths of the assets
     *
     * @var Contracts\AssetHolderInterface
     */
    protected $asset_holder;

    /**
     * @param Repository $config
     * @param FinderInterface $finder
     * @param AssetHolderInterface $asset_holder
     * @param ProviderHolderInterface $provider_holder
     */
    public function __construct(Repository $config,
                                FinderInterface $finder,
                                AssetHolderInterface $asset_holder,
                                ProviderHolderInterface $provider_holder
                                )
    {
        $this->config               = $config;
        $this->finder               = $finder;
        $this->asset_holder         = $asset_holder;
        $this->provider_holder      = $provider_holder;

    }


    /**
     * Will be called from the Vinelab\Cdn\PushCommand class on Fire()
     */
    public function push(){

        // return the configurations from the config file
        $configurations = $this->getConfig();

        // Initialize an instance of the asset holder
        // call the read function in the reader class, to return all the allowed
        // assets to store them in the instance of the asset holder as collection of paths
        $this->asset_holder->setAssets($this->finder->read($this->asset_holder->init($configurations)));

        // TODO: to continue from here..
//        $this->provider_holder->upload($configurations);

    }


    /**
     * Check if the config file exist and return it or
     * throw an exception
     */
    private function getConfig()
    {
        $configs = $this->config->get('cdn::cdnx');

        if(!$configs){
            throw new MissingConfigurationFileException('CDN Config file not found');
        }

        return $configs;
    }




}
