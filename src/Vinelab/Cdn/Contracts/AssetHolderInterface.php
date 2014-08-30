<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface AssetHolderInterface {

    public function init($configurations);
    public function parseAndFillConfiguration($configurations);

    public function getIncludedDirectories();
    public function getIncludedExtensions();
    public function getIncludedPatterns();

    public function getExcludedDirectories();
    public function getExcludedFiles();
    public function getExcludedExtensions();
    public function getExcludedPatterns();

    public function getExcludeHidden();

    public function getAssets();
    public function setAssets($assets);

} 
