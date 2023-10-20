<?php

namespace App\Bootstrap;
use App\Exceptions\ControllerDoNotExistException;
use App\Exceptions\HttpNotFoundException;
use App\Exceptions\MethodDoNotExistException;

class Application
{

    /**
     * The application router class to find and check current route
     * Application routes array define in config/routes.php
     *
     * @var Router
     */
    protected Router $router;

    /**
     * The application base request class
     * @var Request
     */
    protected Request $request;

    /**
     * The current route base on request uri
     * If current route in null , means the entered uri do not defined in routes.php
     *
     * @var array|null
     */
    protected array|null $currentRoute;

    /**
     * The generated response class with related controller
     *
     * @var ?Response $response
     */
    public ?Response $response;


    /**
     * Create a new application instance statically and start app life cycle and make final response class
     *
     * @return Response|null Final application response class
     */
    public static function run(): Response|null
    {
        $app =  new self();
        return $app->response();
    }

    /**
     * Start life cycle of the application . register core service and make response data
     *
     * @throws HttpNotFoundException
     */
    private function __construct()
    {
        $this->setCoreServices();
        try {
            $this->boot();
        }
        catch (ControllerDoNotExistException|MethodDoNotExistException $e)
        {
            dd($e);
        }
    }

    /**
     * Add application service to app instance
     *
     * @return void
     * @throws HttpNotFoundException
     */
    public function setCoreServices(): void
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    /**
     * Boot application a generate response data value
     *
     * @throws MethodDoNotExistException
     * @throws ControllerDoNotExistException
     */
    public function boot(): void
    {
        $this->callController();
    }


    /**
     * Get current application route defined in routes.php file
     *
     * @return array|null
     */
    private function currentRoute(): ?array
    {
        return $this->router->getCurrentRoute();
    }

    /**
     * @throws ControllerDoNotExistException
     * @throws MethodDoNotExistException
     */
    public function callController(): void
    {
        $currentRoute = $this->router->getCurrentRoute();
        $controllerClass = $currentRoute['controller'];
        $methodName = $currentRoute['method'];
        if (!class_exists($controllerClass))
            throw new ControllerDoNotExistException($controllerClass);

        if (!method_exists($controllerClass , $methodName))
            throw new MethodDoNotExistException($controllerClass , $methodName);

        $controllerInstance = new $controllerClass;
        $controllerResult = $controllerInstance->$methodName();
        $this->response = $controllerResult;
    }

    /**
     * Get application response class
     *
     * @return Response|null
     */
    public function response(): ?Response
    {
        return $this->response;
    }
}