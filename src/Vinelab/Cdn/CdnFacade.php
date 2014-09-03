<?php namespace Vinelab\Cdn;

use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use Vinelab\Cdn\Contracts\CdnHelperInterface;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

/**
 * Class CdnFacade
 * @package Vinelab\Cdn
 */
class CdnFacade implements CdnFacadeInterface{

    /**
     * @var instance of the default provider object
     */
    protected $provider;

    /**
     * @var instance of the CdnHelper class
     */
    protected $helper;

    /**
     * Calls the provider initializer
     *
     * @param ProviderFactoryInterface $provider_factory
     * @param Contracts\CdnHelperInterface $helper
     *
     * @internal param \Vinelab\Cdn\Repository $configurations
     */
    public function __construct(ProviderFactoryInterface $provider_factory,
                                CdnHelperInterface $helper
    )
    {
        $this->provider_factory     = $provider_factory;
        $this->helper               = $helper;

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
        $configurations = $this->helper->getConfigurations();

        // return an instance of the corresponding Provider concrete according to the configuration
        $this->provider = $this->provider_factory->create($configurations);
    }



}
