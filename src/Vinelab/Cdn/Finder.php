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

    public function __construct()
    {
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
    public function read(PathsInterface $paths)
    {
        // include the included directories
        $this->in($paths->getIncludedDirectories());

        // include files with this extensions
        foreach($paths->getIncludedExtensions() as $extension){
            $this->name('*'.$extension);
        }

        // include patterns
        foreach($paths->getIncludedPatterns() as $pattern){
            $this->name($pattern);
        }


        // exclude ignored directories
        $this->exclude($paths->getExcludedDirectories());

        // add or ignore hidden directories
        $this->ignoreDotFiles($paths->getExcludeHidden());

        // exclude ignored files
        foreach($paths->getExcludedFiles() as $name){
            $this->notName($name);
        }

        // exclude files with this extensions
        foreach($paths->getExcludedExtensions() as $extension){
            $this->notName('*'.$extension);
        }

        // exclude the regex pattern
        foreach($paths->getExcludedPatterns() as $pattern){
            $this->notName($pattern);
        }

        // printing user message
        echo 'The following files will be uploaded:' . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;

        // get all allowed paths and store them in an array
        $allowed_paths = [];

        foreach ($this->files() as $file) {
            $path = $file->getRealpath();
            // print the result for the user
            echo  $path . PHP_EOL;

            $allowed_paths[] = $path;
        }

        // store all allowed paths in the $paths object as collection
        $paths->setAllowedPaths(new Collection($allowed_paths));

        return $paths;
    }



//TODO: will be removed from this class
    /**
     * convert the array of files paths to an an array of the files path and it's URL.
     * The url is built form the configuration provided in the config file
     */
    public function pathToUrlConverter()
    {

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