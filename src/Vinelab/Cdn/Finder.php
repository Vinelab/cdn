<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use File;
use Vinelab\Cdn\Contracts\FinderInterface;
use Symfony\Component\Finder\Finder as SymfonyFinder;
use Vinelab\Cdn\Contracts\PathsInterface;
use Illuminate\Support\Collection;

class Finder extends SymfonyFinder implements FinderInterface{

    protected $finder_helper;

    public function __construct(SymfonyFinder $finder_service)
    {
        $this->finder_service = $finder_service;
        Parent::__construct();
    }

    /**
     * Build and return an array of the full paths of files found
     * in the included directories except all ignored
     * (directories, patterns, extensions and files)
     *
     * @param Contracts\PathsInterface $paths
     *
     * @internal param $
     * @return array
     */
    public function read(PathsInterface $paths){

        // include the included directories
        $this->finder_service->in($paths->included_directories);
        // exclude ignored directories
        $this->finder_service->exclude($paths->excluded_directories);

        // exclude ignored files
        // TODO: exclude this $paths->excluded_files

        // exclude files with this extensions
        foreach($paths->excluded_extensions as $extension){
            $this->finder_service->notName('*'.$extension);
        }
        // exclude the regex pattern
        foreach($paths->excluded_patterns as $pattern){
            $this->finder_service->notName($pattern);
        }

        // get all allowed paths and store them in an array
        $allowed_paths = [];
        foreach ($this->finder_service->files() as $file) {
//            echo $file->getRealpath() . PHP_EOL;
            $allowed_paths[] =  $file->getRealpath();
        }

        // store all allowed paths in the $paths object as collection
        $paths->allowed_paths = new Collection($allowed_paths);

        return $paths;
    }



//TODO: will be removed from this class
    /**
     * convert the array of files paths to an an array of the files path and it's URL.
     * The url is built form the configuration provided in the config file
     */
    public function pathToUrlConverter(){

        /**
         * read the array example:
         * [
         *    'public/assets/js/my-script.js'
         *    'public/assets/css/my-style.css'
         * ]
         *
         * if 'urls' is not empty, then multiple URL's is enabled
         * thus check every file path if it belongs to any of the directories
         * of the 'urls' and if it does then add the url next to it to be it's url.
         * else if nothing found then add the 'default_url' to be its url
         *
         *
         *
         */

    }




}