<?php namespace Vinelab\Cdn\Validators;

/**
 * @author Mahmoud Zalt <mahmoud@vinelab.com>
 */

use Vinelab\Cdn\Exceptions\EmptyInputException;
use Vinelab\Cdn\Validators\Contracts\ValidatorInterface;

/**
 * Main Validator Class
 *
 * Class Validator
 * @package Vinelab\Cdn\Validators
 */
class Validator implements ValidatorInterface{


    public function checkIfEmpty($string)
    {
        if ( ! $string || empty($string))
            throw new EmptyInputException('Input does not exist.');
    }


}
