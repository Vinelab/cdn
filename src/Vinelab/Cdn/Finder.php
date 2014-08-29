<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use File;
use Vinelab\Cdn\Contracts\FinderInterface;
use Symfony\Component\Finder\Finder as SymfonyFinder;

use Symfony\Component\Console\Output\ConsoleOutput;

use Vinelab\Cdn\Contracts\PathsInterface;
use Illuminate\Support\Collection;


class Finder extends SymfonyFinder implements FinderInterface{

    protected $console;

    public function __construct(ConsoleOutput $console)
    {
        $this->console = $console;

        parent::__construct();
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
        /**
         * add the included directories and files
         */
        $this->includeThis($paths);
        /**
         * exclude the ignored directories and files
         */
        $this->excludeThis($paths);

        // terminal output for user
        $this->console->writeln('<fg=black;bg=green>The following files will be uploaded to the CDN:</fg=black;bg=green>');

        // get all allowed paths and store them in an array
        $allowed_paths = [];
        foreach ($this->files() as $file) {

            // get path of each the remaining files
            $path = $file->getRealpath();

            // terminal output for user
            $this->console->writeln('<fg=green>'.$path.'</fg=green>');

            $allowed_paths[] = $path;
        }

        // store all allowed paths in the $paths object as collection
        $paths->setAllowedPaths(new Collection($allowed_paths));

        return $paths;
    }


    /**
     * add the included directories and files
     *
     * @param PathsInterface $paths
     */
    private function includeThis(PathsInterface $paths){

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

    }

    /**
     *  exclude the ignored directories and files
     *
     * @param PathsInterface $paths
     */
    private function excludeThis(PathsInterface $paths){

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
    }


}
