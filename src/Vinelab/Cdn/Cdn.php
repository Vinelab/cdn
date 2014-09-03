<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\FinderInterface;
use Vinelab\Cdn\Contracts\AssetHolderInterface;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
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
    protected $configurations;

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
     * @param Repository $configurations
     * @param FinderInterface $finder
     * @param AssetHolderInterface $asset_holder
     * @param ProviderFactoryInterface $provider_factory
     */
    public function __construct(Repository $configurations,
                                FinderInterface $finder,
                                AssetHolderInterface $asset_holder,
                                ProviderFactoryInterface $provider_factory
    )
    {
        $this->configurations       = $configurations;
        $this->finder               = $finder;
        $this->asset_holder         = $asset_holder;
        $this->provider_factory     = $provider_factory;
    }


    /**
     * Will be called from the Vinelab\Cdn\PushCommand class on Fire()
     */
    public function push()
    {
        // return the configurations from the config file
        $configurations = $this->getConfigurations();

        // Initialize an instance of the asset holder to read the config    urations
        // then call the read(), to return all the allowed assets as a collection of files objects
        $assets = $this->finder->read($this->asset_holder->init($configurations));
        // store the returned assets in the instance of the asset holder as collection of paths
        $this->asset_holder->setAssets($assets);

        // return an instance of the corresponding Provider concrete according to the configuration
        $provider = $this->provider_factory->create($configurations);

        $provider->upload($this->asset_holder->getAssets());
    }


    /**
     * Check if the config file exist and return it or
     * throw an exception
     */
    private function getConfigurations()
    {
        $configurations = $this->configurations->get('cdn::cdn');

        if(!$configurations){
            throw new MissingConfigurationFileException('CDN Configurations file not found');
        }

        return $configurations;
    }




}
