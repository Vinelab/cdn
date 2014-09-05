<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnHelperInterface;
use Vinelab\Cdn\Exceptions\MissingConfigurationException;
use Vinelab\Cdn\Exceptions\MissingConfigurationFileException;

/**
 * Helper class containing shared functions
 *
 * Class CdnHelper
 * @package Vinelab\Cdn
 */
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
        $this->configurations = $configurations;
    }

    /**
     * Check if the config file exist and return it or
     * throw an exception
     */
    public function getConfigurations()
    {
        $configurations = $this->configurations->get('cdn::cdn');

        if ( ! $configurations) {
            throw new MissingConfigurationFileException('CDN Configurations file not found');
        }

        return $configurations;
    }



    /**
     * Checks for any required configuration is missed
     *
     * @param $configuration
     * @param $required
     *
     * @throws \Vinelab\Cdn\Exceptions\MissingConfigurationException
     */
    public function validate($configuration, $required)
    {
        // search for any null or empty field to throw an exception
        $missing = '';
        foreach ($configuration as $key => $value) {

            if (in_array($key, $required) &&
                (empty($value) || $value == null || $value == ''))
            {
                $missing .= ' ' . $key;
            }
        }

        if ($missing)
            throw new MissingConfigurationException("Missed Configuration:" . $missing);

    }



}
