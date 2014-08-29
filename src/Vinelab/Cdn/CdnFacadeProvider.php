<?php namespace Vinelab\Cdn;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\CdnFacadeProviderInterface;
use Vinelab\Cdn\Contracts\FinderInterface;

class CdnFacadeProvider implements CdnFacadeProviderInterface{

    protected $directory_manager;

    /**
     * @param FinderInterface $directory_manager
     */
    public function __construct(FinderInterface $directory_manager)
    {
        $this->directory_manager = $directory_manager;
    }


    public function load(){
        dd('TESTING');
    }


}