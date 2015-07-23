<?php

namespace Vinelab\Cdn\Contracts;

/**
 * Interface CdnHelperInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface CdnHelperInterface
{
    public function getConfigurations();

    public function validate($configuration, $required);

    public function parseUrl($url);

    public function startsWith($haystack, $needle);

    public function cleanPath($path);
}
