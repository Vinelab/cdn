<?php namespace Vinelab\Cdn;

use Vinelab\Cdn\Exceptions\MissingConfigurationFileException;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use \Illuminate\Config\Repository;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

class CdnFacade implements CdnFacadeInterface{

    /**
     * @var instance of the default's provider object
     */
    protected $provider;

    /**
     * this array will hold all the info that generate the CDN url
     * depend on each CDN provider
     *
     * @var array
     */
    protected $url_builder;

    /**
     * An object of the 'Repository' class that allows reading the laravel config files
     *
     * @var \Illuminate\Config\Repository
     */
    protected $configurations;

    /**
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
        return $this->provider->urlGenerator($path);
    }

    /**
     * Read the configuration file and initialize an object
     * of the corresponding provider according to the default configuration
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
