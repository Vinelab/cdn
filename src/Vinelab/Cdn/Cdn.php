<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;

class Cdn implements CdnInterface{

    /**
     * An instance of the class responsible of reading directories
     *
     * @var Contracts\DirectoryManagerInterface
     */
    protected $directory_manager;

    /**
     * this allow to access the config file
     *
     * @var \Illuminate\Config\Repository
     */
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
     * Will be called from the Vinelab\Cdn\PushCommand class on Fire()
     *
     * It call the directory reader (to read allowed files for upload)
     * It call ... (to generate a URL for each path)
     * It call ... (to upload files to the CDN)
     *
     */
    public function push(){

        $included_dir = $this->config->get('cdn::cdn.include');
        $excluded_dir = $this->config->get('cdn::cdn.exclude');

        $directories = $this->directory_manager->directoryReader($included_dir, $excluded_dir);

        // TODO: to continue from here..
        dd($directories);


//        $cdn_credentials = $this->config->get('cdn::cdn.providers.'.$this->default_provider);
//        $this->web_service->connect($cdn_credentials);

//        $this->establishConnection($default_provider);

    }

}