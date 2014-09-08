<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface CdnHelperInterface{

    public function getConfigurations();

    public function validate($configuration, $required);

    public function parseUrl($url);

}
