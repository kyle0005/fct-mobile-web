<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 17-6-22
 * Time: 上午11:21
 */

namespace App\Exceptions;


class BusinessException extends \Exception
{
    protected $code = 404;
}