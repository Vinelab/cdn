<?php namespace Vinelab\Cdn\Providers\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface ProviderInterface{

    public function init($configurations);

    public function upload($assets);

    public function urlGenerator($path);

    public function getUrlDomain();

    public function getUrlScheme();

    public function getUrl();

    public function getBuckets();

} 
