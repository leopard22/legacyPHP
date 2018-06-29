<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/06/18
 * Time: 10:02
 */

namespace App\DependencyInjection\Exception;
use RuntimeException;
use Throwable;

class InvalidConfigurationException extends RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}