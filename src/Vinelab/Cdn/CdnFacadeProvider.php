<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\CdnFacadeProviderInterface;
use Vinelab\Cdn\Contracts\DirectoryManagerInterface;

class CdnFacadeProvider implements CdnFacadeProviderInterface{

    protected $directory_manager;

    /**
     * @param DirectoryManagerInterface $directory_manager
     */
    public function __construct(DirectoryManagerInterface $directory_manager)
    {
        $this->directory_manager = $directory_manager;
    }


    public function load(){
        dd('TESTING');
    }


}