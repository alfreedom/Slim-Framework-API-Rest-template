<?php

namespace AppController;

use \Slim\Http\Response;
use \Slim\Http\Request;

class IndexController
{
    protected  $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function Index(Request $request, Response $response, array $args)
    {
        // Sample log message
        $this->container->logger->info("Slim-Skeleton '/' route");
        // Render index view
        return $this->container->view->render($response, 'index.phtml', $args);
    }

    public function Api(Request $request, Response $response, array $args)
    {
        // Sample log message
        $this->container->logger->info("Api Rest '/v1/api' route");
        // Render index view
        return $this->container->view->render($response, 'api.phtml', $args);
    }
}