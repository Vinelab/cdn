<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Contracts\PathsInterface;

interface FinderInterface {

    public function read(PathsInterface $paths);

}