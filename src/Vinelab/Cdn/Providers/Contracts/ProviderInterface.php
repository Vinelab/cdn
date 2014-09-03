<?php namespace Vinelab\Cdn\Providers\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface ProviderInterface{

    public function upload($assets);

    public function urlGenerator($path);

    public function getDomain();

    public function getProtocol();

    public function getUrl();

    public function getBuckets();

} 
