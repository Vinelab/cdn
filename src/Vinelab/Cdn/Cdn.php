<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;
use \Illuminate\Config\Repository;

class Cdn implements CdnInterface{

    /**
     * An instance of the class responsible of reading directories
     *
     * @var Contracts\DirectoryManagerInterface
     */
    protected $directory_manager;


    protected $config;

    /**
     * The default web service provider (found in the config file)
     *
     * @var string
     */
    protected $default_provider;

    /**
     * @param DirectoryManagerInterface $directory_manager
     * @param Repository $config
     */
    public function __construct(DirectoryManagerInterface $directory_manager,
                                Repository $config)
    {
        $this->directory_manager = $directory_manager;

        $this->config = $config;

        $this->configuration_reader();
    }

    /**
     * Read the default configurations from the config file and store them as
     * properties of this class.
     */
    public function configuration_reader(){

        // read the default CDN provider from the configuration file
        $this->default_provider = $this->config->get('cdn::cdn.default');

    }

    /**
     * Run the CDN
     */
    public function push(){

        $included_dir = $this->config->get('cdn::cdn.include');
        $excluded_dir = $this->config->get('cdn::cdn.exclude');

        $directories = $this->directory_manager->directoryReader($included_dir, $excluded_dir);

        dd($directories);



//        $cdn_credentials = $this->config->get('cdn::cdn.providers.'.$this->default_provider);
//        $this->web_service->connect($cdn_credentials);


//        $this->establishConnection($default_provider);



            /**
             * 1.
             * 2. call directory reader
             * 3. call convert path to url
             * 4. call upload files to cdn
             */

    }










}