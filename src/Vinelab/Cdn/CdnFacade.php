<?php namespace Vinelab\Cdn;

use Vinelab\Cdn\Exceptions\MissingConfigurationFileException;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use \Illuminate\Config\Repository;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

/**
 * Class CdnFacade
 * @package Vinelab\Cdn
 */
class CdnFacade implements CdnFacadeInterface{

    /**
     * @var instance of the default's provider object
     */
    protected $provider;

    /**
     * An object of the 'Repository' class that allows reading the laravel config files
     *
     * @var \Illuminate\Config\Repository
     */
    protected $configurations;

    /**
     * Calls the provider initializer
     *
     * @param Repository $configurations
     * @param ProviderFactoryInterface $provider_factory
     */
    public function __construct(Repository $configurations,
                                ProviderFactoryInterface $provider_factory)
    {
        $this->configurations       = $configurations;
        $this->provider_factory     = $provider_factory;

        $this->init();
    }

    /**
     * This function will be called from the 'views' using the
     * 'Cdn' facade {{Cdn::asset('')}} to convert the path into
     * it's CDN url
     *
     * @param $path
     *
     * @return string
     */
    public function asset($path)
    {
        // remove slashes from begging and ending of the path then call the
        // url generator of the provider
        return $this->provider->urlGenerator(rtrim(ltrim($path, '/'), '/'));
    }

    /**
     * Read the configuration file and pass it to the provider factory
     * to return an object of the default provider specified in the
     * config file
     *
     */
    private function init()
    {
        // return the configurations from the config file
        $configurations = $this->getConfigurations();

        // return an instance of the corresponding Provider concrete according to the configuration
        $this->provider = $this->provider_factory->create($configurations);
    }



// TODO: remove this function to a HELPER class to be used b
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
