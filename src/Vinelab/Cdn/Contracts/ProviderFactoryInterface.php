<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface ProviderFactoryInterface {

    public function create($configurations);
}
