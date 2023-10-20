<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\NoReturn;

class HttpNotFoundException extends Exception
{
    #[NoReturn] public function __construct()
    {
        parent::__construct();
        die('404 : Current route do not defined');
    }
}