<?php namespace Vinelab\Cdn;
/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\PathsInterface;

/**
 * Class Paths used to parse and store all directories and paths related data and configurations
 * @package Vinelab\Cdn
 */
class Paths implements PathsInterface{

    /**
     * @var Array
     */
    public $included_directories;
    /**
     * @var Array
     */
    public $included_files;
    /**
     * @var Array
     */
    public $included_extensions;
    /**
     * @var Array
     */
    public $included_patterns;

    /**
     * @var Array
     */
    public $excluded_directories;
    /**
     * @var Array
     */
    public $excluded_files;
    /**
     * @var Array
     */
    public $excluded_extensions;
    /**
     * @var Array
     */
    public $excluded_patterns;
    /*
     * Allowed paths for upload (found in included_directories)
     *
     * @var Collection
     */
    public $allowed_paths;

    /**
     * @param $configurations
     *
     * @return $this (Paths)
     */
    public function init($configurations)
    {
        // TODO: check if empty {validate if exist configs else take defaults}
        $this->included_directories  = $configurations['include']['directories'];
        $this->included_files        = $configurations['include']['files'];
        $this->included_extensions   = $configurations['include']['extensions'];
        $this->included_patterns     = $configurations['include']['patterns'];

        $this->excluded_directories  = $configurations['exclude']['directories'];
        $this->excluded_files        = $configurations['exclude']['files'];
        $this->excluded_extensions   = $configurations['exclude']['extensions'];
        $this->excluded_patterns     = $configurations['exclude']['patterns'];

        return $this;
    }

    /**
     * @return Array
     */
    public function getIncludedDirectories()
    {
        return $this->included_directories;
    }
    /**
     * @return Array
     */
    public function getIncludedFiles()
    {
        return $this->included_files;
    }
    /**
     * @return Array
     */
    public function getIncludedExtensions()
    {
        return $this->included_extensions;
    }
    /**
     * @return Array
     */
    public function getIncludedPatterns()
    {
        return $this->included_patterns;
    }
    /**
     * @return Array
     */
    public function getExcludedDirectories()
    {
        return $this->excluded_directories;
    }
    /**
     * @return Array
     */
    public function getExcludedFiles()
    {
        return $this->excluded_files;
    }
    /**
     * @return Array
     */
    public function getExcludedExtensions()
    {
        return $this->excluded_extensions;
    }
    /**
     * @return Array
     */
    public function getExcludedPatterns()
    {
        return $this->excluded_patterns;
    }

    /**
     * @return mixed
     */
    public function getAllowedPaths()
    {
        return $this->allowed_paths;
    }

    /**
     * @param mixed $allowed_paths
     */
    public function setAllowedPaths($allowed_paths)
    {
        $this->allowed_paths = $allowed_paths;
    }


}