<?php

namespace Vinelab\Cdn\Contracts;

/**
 * Interface AssetInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface AssetInterface
{
    public function init($configurations);

    public function getIncludedDirectories();

    public function getIncludedExtensions();

    public function getIncludedPatterns();

    public function getExcludedDirectories();

    public function getExcludedFiles();

    public function getExcludedExtensions();

    public function getExcludedPatterns();

    public function getExcludeHidden();

    public function getAssets();

    public function setAssets($assets);
}
