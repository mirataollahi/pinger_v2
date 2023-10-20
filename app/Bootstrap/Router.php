<?php

namespace App\Bootstrap;

use App\Exceptions\HttpNotFoundException;

class Router
{
    protected string $routesFile = __DIR__ . "/../../routes/web.php";

    /**
     * The application defined routes in routes.php file
     *
     * @var array
     */
    protected array $appRoutes = [];

    /**
     * Current application route get by current request uri
     *
     * @var array|null
     */
    public array|null $currentRoute = null ;

    /**
     * Construct App Router class and register application routes
     *
     * @param Request $request The application base request class
     * @throws HttpNotFoundException
     */
    public function __construct(Request $request)
    {
        $this->setAppRoutes();
        $this->setCurrentRoute($request);
    }

    /**
     * Load application routes base on route.php file in config directory
     *
     * @return void
     */
    public function setAppRoutes(): void
    {
        $filePath = $this->routesFile;
        $routesArray =  file_exists($filePath)
            ? include($filePath)
            : die('application routes files not exist');


        $this->appRoutes = $routesArray;
    }



    /**
     * Find current route base on current request uri
     *
     * @param Request $request
     * @return mixed
     * @throws HttpNotFoundException
     */
    public function setCurrentRoute(Request $request): bool
    {
        foreach ($this->appRoutes as $route) {
            if ($route['uri'] === $request->uri()) {
                $this->currentRoute = $route;
                return true;
            }
        }

        throw new HttpNotFoundException();
    }

    /**
     * Get current route set with class constructor method
     *
     * @return array|null
     */
    public function getCurrentRoute(): ?array
    {
        return $this->currentRoute;
    }
}