<?php namespace Vinelab\Cdn\Exceptions;

class CdnException extends \RuntimeException {}


class MissingConfigurationFileException extends CdnException {}
class MissingConfigurationException extends CdnException {}
class UnsupportedProviderException extends CdnException {}
class EmptyPathException extends CdnException {}

