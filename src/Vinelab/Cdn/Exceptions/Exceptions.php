<?php
namespace Vinelab\Cdn\Exceptions;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

class CdnException extends \RuntimeException
{

}


class MissingConfigurationFileException extends CdnException
{

}


class MissingConfigurationException extends CdnException
{

}


class UnsupportedProviderException extends CdnException
{

}


class EmptyPathException extends CdnException
{

}

