<?php
namespace Vinelab\Cdn\Validators\Contracts;

/**
 * Interface ProviderValidatorInterface
 * @package Vinelab\Cdn\Validators\Contracts
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface ProviderValidatorInterface
{

    public function validate($configuration, $required);

} 
