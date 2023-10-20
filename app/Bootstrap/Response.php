<?php

namespace App\Bootstrap;

class Response
{
    /**
     * The result class json data
     *
     * @var mixed
     */
    protected mixed $jsonResponse ;

    protected string $type;

    /**
     * Application Response class constructor
     */
    function __construct(string $type = 'json')
    {
        $this->type = $type;
    }
    /**
     * Set json response data and return response instance
     *
     * @param array $arrayData
     * @return static
     */
    public function json(array $arrayData = []): static
    {
        $this->jsonResponse = json_encode($arrayData , true);
        return $this;
    }

    /**
     * Create new response class instance statically
     *
     * @return Response
     */
    public function create(): Response
    {
        return new self();
    }

    /**
     * Show final application response here
     *
     * @return void
     */
    public function terminate(): void
    {
        if ($this->type === 'json') {
            header('Content-Type: application/json; charset=utf-8');
            header('Access-Control-Allow-Origin: http://127.0.0.1:2000');
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type');
            echo $this->jsonResponse;
        }
    }
}