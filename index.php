<?php


/*
 * Require package and libs autoloader
 */
require __DIR__ . '/vendor/autoload.php';

$privateKey = 'vULH97DM0jLm7HlWDoxYpzqLKRpnk5OJJLTM8UeIMmYIJxNMGMXvMbBNRiLO9jBF';






$response = \App\Bootstrap\Application::run();
$response?->terminate();