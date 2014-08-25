<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use File;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;
use Symfony\Component\Finder\Finder;

class DirectoryManager implements DirectoryManagerInterface{

    /**
     * An instance of the Symfony Finder class
     *
     * @var \Symfony\Component\Finder\Finder
     */
    protected $finder;

    /**
     * @param Finder $finder
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Build and return an array of the full paths of files found
     * in the included directories except all ignored
     * (directories, patterns, extensions and files)
     *
     * @param array $include
     * @param array $ignore
     *
     * @return array
     */
    public function directoryReader(Array $include, Array $ignore){

        $directories = [];

        // include the included directories
        $this->finder->in($include);
        //  ignored directories
        $this->finder->exclude($ignore['directories']);
        // exclude files with this extensions
        foreach($ignore['extensions'] as $ext){
            $this->finder->notName('*'.$ext);
        }
        // exclude the regex pattern
        $this->finder->notName($ignore['pattern']);


        foreach ($this->finder->files() as $file) {
//            echo $file->getRealpath() . PHP_EOL;
            $directories[] =  $file->getRealpath();
        }

        return $directories;
    }




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