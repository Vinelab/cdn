<?php namespace Vinelab\Cdn;

use Vinelab\Cdn\Exceptions\UnsupportedProviderException;
use Vinelab\Cdn\Contracts\CdnFacadeInterface;
use \Illuminate\Config\Repository;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

class CdnFacade implements CdnFacadeInterface{

    protected $provider_name;

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
     */
    public function __construct(Repository $configurations)
    {
        $this->configurations = $configurations;

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
        // todo: clean every value before building the url
        return $this->url_builder['protocol'] . '://' . $this->url_builder['bucket'] . '.' . $this->url_builder['domain'] . '/' . $path;
    }

    /**
     * Initialize this class by reading the configurations
     * from the config file
     */
    private function init()
    {
        $this->provider_name = $this->configurations->get('cdn::cdn.default');

        switch($this->provider_name)
        {
            case 'aws.s3':
                    $this->awsS3Initializer();
                break;

            default:
                throw new UnsupportedProviderException("CDN provider ($this->provider_name) not supported");

        }

    }


    private function awsS3Initializer()
    {
        $protocol = $this->configurations->get('cdn::cdn.protocol');
        $domain = $this->configurations->get('cdn::cdn.domain');

        $buckets = $this->configurations->get('cdn::cdn.providers.aws.s3.buckets');
        // TODO: validate not empty
        $this->url_builder = [
                'protocol' => $protocol,
                'domain' => $domain,
                'bucket' => key($buckets),
        ];

    }

}
