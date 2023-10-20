<?php

namespace App\Exceptions;


use Exception;
use JetBrains\PhpStorm\NoReturn;
use Throwable;

class ControllerDoNotExistException extends Exception
{
    /**
     * @param string $controllerName
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[NoReturn] public function __construct(string $controllerName, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct();
        die("The {$controllerName} do not exist");
    }
}
