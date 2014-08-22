<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface DirectoryManagerInterface {

    public function directoryReader(Array $included_directories, $ignored_patterns);

} 