<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnHelperInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationFileException;

class CdnHelper implements CdnHelperInterface{

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
        $this->configurations       = $configurations;
    }

    /**
     * Check if the config file exist and return it or
     * throw an exception
     */
    public function getConfigurations()
    {
        $configurations = $this->configurations->get('cdn::cdn');

        if(!$configurations){
            throw new MissingConfigurationFileException('CDN Configurations file not found');
        }

        return $configurations;
    }

}
