<?php

namespace App\Bootstrap;


class BaseController
{
    /**
     * The response class
     * @var Response
     */
    protected Response $response;

    /**
     * Add response class as self property to return in controllers methods
     *
     */
    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Set response data value and return response instance
     *
     * @param mixed $data
     * @return $this
     */
    public function response(mixed $data = []): static
    {
        $this->response->json($data);
        return $this;
    }

}