<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use File;
use Symfony\Component\Finder\Finder as SymfonyFinder;
use Symfony\Component\Console\Output\ConsoleOutput;
use Vinelab\Cdn\Contracts\AssetInterface;
use Vinelab\Cdn\Contracts\FinderInterface;
use Illuminate\Support\Collection;


class Finder extends SymfonyFinder implements FinderInterface{

    protected $console;

    public function __construct(ConsoleOutput $console)
    {
        $this->console = $console;

        parent::__construct();
    }


    /**
     * Build and return an array of the full paths of assets found
     * in the included directories except all ignored
     * (directories, patterns, extensions and files)
     *
     * @param Contracts\AssetInterface $asset_holder
     *
     * @internal param $
     * @return \Vinelab\Cdn\Contracts\AssetInterface
     */
    public function read(AssetInterface $asset_holder)
    {
        /**
         * add the included directories and files
         */
        $this->includeThis($asset_holder);
        /**
         * exclude the ignored directories and files
         */
        $this->excludeThis($asset_holder);

        // user terminal message
        $this->console->writeln('<fg=red>Files to upload:</fg=red>');

        // get all allowed 'for upload' files objects (assets) and store them in an array
        $assets = [];
        foreach ($this->files() as $file)
        {
            // user terminal message
            $this->console->writeln('<fg=cyan>'.$file->getRealpath().'</fg=cyan>');

            $assets[] = $file;
        }

        return new Collection($assets);
    }


    /**
     * add the included directories and files
     *
     * @param Contracts\AssetInterface $asset_holder
     *
     * @internal param $
     */
    private function includeThis(AssetInterface $asset_holder){

        // include the included directories
        $this->in($asset_holder->getIncludedDirectories());

        // include files with this extensions
        foreach($asset_holder->getIncludedExtensions() as $extension){
            $this->name('*'.$extension);
        }

        // include patterns
        foreach($asset_holder->getIncludedPatterns() as $pattern){
            $this->name($pattern);
        }

        // exclude ignored directories
        $this->exclude($asset_holder->getExcludedDirectories());

    }

    /**
     *  exclude the ignored directories and files
     *
     * @param Contracts\AssetInterface $asset_holder
     *
     * @internal param $
     */
    private function excludeThis(AssetInterface $asset_holder){

        // add or ignore hidden directories
        $this->ignoreDotFiles($asset_holder->getExcludeHidden());

        // exclude ignored files
        foreach($asset_holder->getExcludedFiles() as $name){
            $this->notName($name);
        }

        // exclude files with this extensions
        foreach($asset_holder->getExcludedExtensions() as $extension){
            $this->notName('*'.$extension);
        }

        // exclude the regex pattern
        foreach($asset_holder->getExcludedPatterns() as $pattern){
            $this->notName($pattern);
        }
    }


}
