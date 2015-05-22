<?php
namespace Vinelab\Cdn;

use Illuminate\Support\Facades\App;
use Vinelab\Cdn\Contracts\ProviderFactoryInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Vinelab\Cdn\Exceptions\UnsupportedProviderException;
use Vinelab\Cdn\Provider\AwsS3Provider;

/**
 * Class ProviderFactory
 * This class is responsible of creating objects from the default
 * provider found in the config file.
 *
 * @category Factory
 * @package Vinelab\Cdn
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class ProviderFactory implements ProviderFactoryInterface
{

    /**
     * Create and return an instance of the corresponding
     * Provider concrete according to the configuration
     *
     * @param array $configurations
     *
     * @return mixed
     * @throws Exceptions\UnsupportedProviderException
     * @throws Exceptions\MissingConfigurationException
     */
    public function create($configurations = array())
    {
        // get the default provider name
        $provider = isset($configurations['default']) ? $configurations['default'] : null;

        if ($provider) {
            switch ($provider == 'aws.s3') {
                case 'aws.s3':
                    // create an instance of aws s3 provider, then
                    // call the init function to read and parse the configuration
                    return App::make('Vinelab\Cdn\Providers\AwsS3Provider')->init($configurations);
                    break;
                case 'cloudfront':
                    // ...
                    break;
                default:
                    throw new UnsupportedProviderException("CDN provider ($this->provider_name) is not supported");
            }
        } else {
            throw new MissingConfigurationException("Missing Configurations: Default Provider");
        }
    }

}
