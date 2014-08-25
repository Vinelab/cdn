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
    protected $included_directories;
    /**
     * @var Array
     */
    protected $excluded_directories;
    /**
     * @var Array
     */
    protected $excluded_files;
    /**
     * @var Array
     */
    protected $excluded_extensions;
    /**
     * @var Array
     */
    protected $excluded_patterns;
    /*
     * Allowed paths for upload (found in included_directories)
     *
     * @var Collection
     */
    protected $allowed_paths;

    /**
     * @param $configurations
     *
     * @return $this (Paths)
     */
    public function parse($configurations)
    {
        $this->included_directories  = $configurations['include'];
        $this->excluded_directories  = $configurations['exclude']['directories'];
        $this->excluded_files        = $configurations['exclude']['files'];
        $this->excluded_extensions   = $configurations['exclude']['extensions'];
        $this->excluded_patterns     = $configurations['exclude']['patterns'];

        return $this;
    }


    /**
     * @param $attr
     *
     * @return null
     */
    public function __get($attr)
    {
        return isset($this->$attr) ? $this->$attr : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->$key = $value;
    }

}