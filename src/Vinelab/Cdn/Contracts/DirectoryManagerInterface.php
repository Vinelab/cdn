<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface DirectoryManagerInterface {

    public function directoryReader(Array $include, Array $ignore);

} 