<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class MethodDoNotExistException extends Exception
{
    /**
     * @param string $controller
     * @param string $method
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[NoReturn] function __construct(string $controller , string $method , string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct();
        die("Method {$method} do not exist in {$controller} class");
    }
}