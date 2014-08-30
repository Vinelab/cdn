<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use File;
use Vinelab\Cdn\Contracts\FinderInterface;
use Symfony\Component\Finder\Finder as SymfonyFinder;

use Symfony\Component\Console\Output\ConsoleOutput;

use Vinelab\Cdn\Contracts\PathHolderInterface;
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
     * @param Contracts\PathHolderInterface $path_holder
     *
     * @internal param $
     * @return \Vinelab\Cdn\Contracts\PathHolderInterface
     */
    public function read(PathHolderInterface $path_holder)
    {
        /**
         * add the included directories and files
         */
        $this->includeThis($path_holder);
        /**
         * exclude the ignored directories and files
         */
        $this->excludeThis($path_holder);

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

        // store all allowed paths in the $path_holder object as collection
        $path_holder->setAllowedPaths(new Collection($allowed_paths));

        return $path_holder;
    }


    /**
     * add the included directories and files
     *
     * @param Contracts\PathHolderInterface $path_holder
     *
     * @internal param $
     */
    private function includeThis(PathHolderInterface $path_holder){

        // include the included directories
        $this->in($path_holder->getIncludedDirectories());

        // include files with this extensions
        foreach($path_holder->getIncludedExtensions() as $extension){
            $this->name('*'.$extension);
        }

        // include patterns
        foreach($path_holder->getIncludedPatterns() as $pattern){
            $this->name($pattern);
        }

        // exclude ignored directories
        $this->exclude($path_holder->getExcludedDirectories());

    }

    /**
     *  exclude the ignored directories and files
     *
     * @param Contracts\PathHolderInterface $path_holder
     *
     * @internal param $
     */
    private function excludeThis(PathHolderInterface $path_holder){

        // add or ignore hidden directories
        $this->ignoreDotFiles($path_holder->getExcludeHidden());

        // exclude ignored files
        foreach($path_holder->getExcludedFiles() as $name){
            $this->notName($name);
        }

        // exclude files with this extensions
        foreach($path_holder->getExcludedExtensions() as $extension){
            $this->notName('*'.$extension);
        }

        // exclude the regex pattern
        foreach($path_holder->getExcludedPatterns() as $pattern){
            $this->notName($pattern);
        }
    }


}
