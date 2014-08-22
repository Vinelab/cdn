<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\CdnFacadeProviderInterface;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;
use Vinelab\Cdn\WebServices\Contracts\AmazonWebServiceInterface;

class CdnFacadeProvider implements CdnFacadeProviderInterface{


    protected $aws;

    protected $directory_manager;

    public function __construct(AmazonWebServiceInterface $aws,
                                DirectoryManagerInterface $directory_manager
                                )
    {
        $this->aws = $aws;
        $this->directory_manager = $directory_manager;
    }


    public function load(){
        dd('LOADDD 2222');
    }






}