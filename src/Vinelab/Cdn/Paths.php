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
     * default [include] configurations
     *
     * @var array
     */
    private $original_include = [
        'directories'   => ['public'],
        'extensions'    => [''],
        'patterns'      => [''],
    ];

    /**
     * default [exclude] configurations
     *
     * @var array
     */
    private $original_exclude =  [
        'directories'   => [''],
        'files'         => [''],
        'extensions'    => [''],
        'patterns'      => [''],
        'hidden'        => true,
    ];

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
     * @var boolean
     */
    public $exclude_hidden;

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
        $this->checkAndFix($configurations);

        $this->included_directories  = $this->original_include['directories'];
        $this->included_extensions   = $this->original_include['extensions'];
        $this->included_patterns     = $this->original_include['patterns'];

        $this->excluded_directories  = $this->original_exclude['directories'];
        $this->excluded_files        = $this->original_exclude['files'];
        $this->excluded_extensions   = $this->original_exclude['extensions'];
        $this->excluded_patterns     = $this->original_exclude['patterns'];
        $this->exclude_hidden        = $this->original_exclude['hidden'];

        return $this;
    }


    /**
     * Check if the config file has any missed attribute, and if any attribute
     * is missed will be overridden by a default attribute defined in this class.
     *
     * @param $configurations
     *
     */
    public function checkAndFix($configurations)
    {
        $this->original_include = isset($configurations['include']) ? array_merge($this->original_include, $configurations['include']) : $this->original_include;
        $this->original_exclude = isset($configurations['exclude']) ? array_merge($this->original_exclude, $configurations['exclude']) : $this->original_exclude;
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

    /**
     * @return mixed
     */
    public function getExcludeHidden()
    {
        return $this->exclude_hidden;
    }


}