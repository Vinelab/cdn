<?php namespace Vinelab\Cdn\Contracts;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

interface FinderInterface {

    public function read(AssetHolderInterface $paths);

}
