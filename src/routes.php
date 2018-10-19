<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/controller[/{name}]', AppController\IndexController::class . ':Index');

$app->get('/index[/{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});

$app->get('/api/v1/dev', 'IndexController:Api');