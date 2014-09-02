<?php namespace Vinelab\Cdn;

use Vinelab\Cdn\Contracts\CdnFacadeInterface;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

class CdnFacade implements CdnFacadeInterface{


    public function asset($path){

        dd('Converting: ' . $path);

    }



}
