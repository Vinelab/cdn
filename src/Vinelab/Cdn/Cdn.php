<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use \Illuminate\Config\Repository;
use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\FinderInterface;
use Vinelab\Cdn\Contracts\PathsInterface;

/**
 * Class Cdn is the manager and base class
 * @package Vinelab\Cdn
 */
class Cdn implements CdnInterface{

    /**
     * An object of the 'Repository' class that allows reading the laravel config files
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * An instance of the finder class
     *
     * @var Contracts\
     */
    protected $finder;

    /**
     * The object that will hold the directories configurations and the paths data
     *
     * @var Contracts\PathsInterface
     */
    protected $paths;

    /**
     * @param \Illuminate\Config\Repository $config
     * @param FinderInterface $finder
     * @param Contracts\PathsInterface $paths
     *
     * @internal param $
     */
    public function __construct(Repository $config,
                                FinderInterface $finder,
                                PathsInterface $paths
                                )
    {
        $this->finder   = $finder;
        $this->paths    = $paths;
        $this->config   = $config;
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

        // get configurations from the config file
        $configurations = $this->config->get('cdn::cdn');

        // build a path object that contains the directories related configurations
        $this->paths = $this->paths->init($configurations);

        // call the files finder to read files form the directories
        $paths = $this->finder->read($this->paths);

        // TODO: to continue from here..
        dd($paths);


//        $cdn_credentials = $this->config->get('cdn::cdn.providers.'.$this->default_provider);
//        $this->web_service->connect($cdn_credentials);

//        $this->establishConnection($default_provider);

    }

}