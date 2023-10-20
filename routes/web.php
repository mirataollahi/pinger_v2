<?php


/*
 * Application routes define here
 */



return [

    [
        'uri' => '/api/ping' ,
        'name' => 'admin.ping' ,
        'request_method' => 'GET' ,
        'controller' => \App\Controllers\Admin\AdminController::class ,
        'method' => 'ping' ,
    ],

    [
        'uri' => '/' ,
        'name' => 'admin.dashboard' ,
        'request_method' => 'GET' ,
        'controller' => \App\Controllers\Admin\AdminController::class ,
        'method' => 'dashboard' ,
    ],


];