<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use Vinelab\Cdn\Contracts\CdnHelperInterface;
use Vinelab\Cdn\Validators\CdnFacadeValidator;

/**
 * Class CdnFacade
 * @package Vinelab\Cdn
 */
class CdnFacade implements CdnFacadeInterface{

    /**
     * @var Contracts\ProviderFactoryInterface
     */
    protected $provider_factory;

    /**
     * @var instance of the default provider object
     */
    protected $provider;

    /**
     * @var instance of the CdnHelper class
     */
    protected $helper;

    /**
     * @var Validators\CdnFacadeValidator
     */
    protected $cdn_facade_validator;

    /**
     * Calls the provider initializer
     *
     * @param ProviderFactoryInterface $provider_factory
     * @param Contracts\CdnHelperInterface $helper
     * @param Validators\CdnFacadeValidator $cdn_facade_validator
     *
     * @internal param \Vinelab\Cdn\Repository $configurations
     */
    public function __construct(
        ProviderFactoryInterface $provider_factory,
        CdnHelperInterface $helper,
        CdnFacadeValidator $cdn_facade_validator
    ) {
        $this->provider_factory     = $provider_factory;
        $this->helper               = $helper;
        $this->cdn_facade_validator = $cdn_facade_validator;

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
        // validate is $path exist or throw Exception
        $this->cdn_facade_validator->checkIfEmpty($path);

        // remove slashes from begging and ending of the path then call the
        // url generator of the provider
        return $this->provider->urlGenerator($this->cleanPath($path));

    }

    /**
     * remove any extra slashes '/' from the path
     *
     * @param $path
     *
     * @return string
     */
    private function cleanPath($path)
    {
        return rtrim(ltrim($path, '/'), '/');
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
