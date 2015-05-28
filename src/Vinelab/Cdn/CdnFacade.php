<?php
namespace Vinelab\Cdn;

use Illuminate\Support\Facades\Request;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use Vinelab\Cdn\Contracts\CdnHelperInterface;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Exceptions\EmptyPathException;
use Vinelab\Cdn\Validators\CdnFacadeValidator;

/**
 * Class CdnFacade
 *
 * @category
 * @package Vinelab\Cdn
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class CdnFacade implements CdnFacadeInterface
{

    /**
     * @var array
     */
    protected $configurations;

    /**
     * @var \Vinelab\Cdn\Contracts\ProviderFactoryInterface
     */
    protected $provider_factory;

    /**
     * instance of the default provider object
     *
     * @var \Vinelab\Cdn\Providers\Contracts\ProviderInterface
     */
    protected $provider;

    /**
     * @var \Vinelab\Cdn\Contracts\CdnHelperInterface
     */
    protected $helper;

    /**
     * @var \Vinelab\Cdn\Validators\CdnFacadeValidator
     */
    protected $cdn_facade_validator;

    /**
     * Calls the provider initializer
     *
     * @param \Vinelab\Cdn\Contracts\ProviderFactoryInterface $provider_factory
     * @param \Vinelab\Cdn\Contracts\CdnHelperInterface       $helper
     * @param \Vinelab\Cdn\Validators\CdnFacadeValidator      $cdn_facade_validator
     */
    public function __construct(
        ProviderFactoryInterface $provider_factory,
        CdnHelperInterface $helper,
        CdnFacadeValidator $cdn_facade_validator
    ) {
        $this->provider_factory = $provider_factory;
        $this->helper = $helper;
        $this->cdn_facade_validator = $cdn_facade_validator;

        $this->init();
    }

    /**
     * this function will be called from the 'views' using the
     * 'Cdn' facade {{Cdn::asset('')}} to convert the path into
     * it's CDN url
     *
     * @param $path
     *
     * @return mixed
     * @throws Exceptions\EmptyPathException
     */
    public function asset($path)
    {
        // if asset always append the public/ dir to the path (since the user should not add public/ to asset)
        return $this->generateUrl($path, 'public/');
    }


    /**
     * this function will be called from the 'views' using the
     * 'Cdn' facade {{Cdn::path('')}} to convert the path into
     * it's CDN url
     *
     * @param $path
     *
     * @return mixed
     * @throws Exceptions\EmptyPathException
     */
    public function path($path)
    {
        return $this->generateUrl($path);
    }

    /**
     * check if package is surpassed or not then
     * prepare the path before generating the url
     *
     * @param        $path
     * @param string $prepend
     *
     * @return mixed
     */
    private function generateUrl($path, $prepend = '')
    {
        // if the package is surpassed, then return the same $path
        // to load the asset from the localhost

        // Add version number

        $path = str_replace(
            "build",
            "build/" . $this->configurations['providers']['aws']['s3']['version'],
            $path
        );
        
        if (isset($this->configurations['bypass']) && $this->configurations['bypass']) {
            return Request::root() .'/'. $path;
        }

        if (!isset($path)) {
            throw new EmptyPathException('Path does not exist.');
        }


        // remove slashes from begging and ending of the path
        // and append directories if needed
        if ($this->configurations['providers']['aws']['s3']['cloudfront']['use'] === true) 
        {
             $clean_path = $this->helper->cleanPath($path);
        }
        else 
        {
             $clean_path = $prepend . $this->helper->cleanPath($path);
        }

        // call the provider specific url generator
        return $this->provider->urlGenerator($clean_path);
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
        $this->configurations = $this->helper->getConfigurations();

        // return an instance of the corresponding Provider concrete according to the configuration
        $this->provider = $this->provider_factory->create($this->configurations);
    }

}
