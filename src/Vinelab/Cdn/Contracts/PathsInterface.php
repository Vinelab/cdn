<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface PathsInterface {

    public function init($configurations);

    public function getIncludedDirectories();
    public function getIncludedExtensions();
    public function getIncludedPatterns();

    public function getExcludedDirectories();
    public function getExcludedFiles();
    public function getExcludedExtensions();
    public function getExcludedPatterns();

    public function getExcludeHidden();

    public function getAllowedPaths();
    public function setAllowedPaths($allowed_paths);

} 