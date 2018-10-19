<?php
// DIC configuration
$container = $app->getContainer();

//     MANEJADOR DE ERRORES 404     ##########################
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withJson(['status'=>'error', 'message'=>'Page Not Found'], 404);
    };
};
//############################################################

//     MANEJADOR DE LOS MËTODOS NO PERMITIDOS     #############
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $response->withJson([
            'status'=>'error',
            'message'=> 'Method not allowed, must be one of: ' . implode(', ', $methods),
            'allow'=>implode(', ', $methods)
        ], 405);
    };
};
//############################################################

//     JWT     ###############################################
// en la variable 'jwt0 de container.
$container['jwt'] = function ($c) {
    return $c->get('settings')['jwt'];
};
//############################################################

//     DB con Eloquent     ###################################
// en la variable 'db' del container
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container->get('settings')['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($c) use ($capsule) {
    return $capsule;
};
//############################################################

// Renderizador de vistas en la variable 'view' del container
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};


/*
 *  AGREGAR AQUI LAS DEPENDENCIAS DE LOS CONTROLADORES
 */
$container[IndexController::class] = function ($c) {
    return new AppController\IndexController($c);
};