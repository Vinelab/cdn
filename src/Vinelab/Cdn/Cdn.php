<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\CdnInterface;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;
use Vinelab\Cdn\WebServices\Contracts\AmazonWebServiceInterface;

class Cdn implements CdnInterface{


    protected $aws;

    protected $directory_manager;

    public function __construct(AmazonWebServiceInterface $aws,
                                DirectoryManagerInterface $directory_manager
                                )
    {
        $this->aws = $aws;
        $this->directory_manager = $directory_manager;
    }


    /**
     * Run the CDN
     */
    public function make(){
        dd('MAKE');

            /**
             * 1. read the config file
             * 2. call directory reader
             * 3. call convert path to url
             * 4. call upload files to cdn
             */

    }






}