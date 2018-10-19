<?php
// Application middleware

// e.g:
// require __DIR__ . '/../src/middleware/EjemploMiddleware.php';

// Middleware de autenticación con JWT para toda la aplicación
$app->add(new \Tuupola\Middleware\JwtAuthentication([
    "secret"=> $container['jwt']['secret'],         // Obtiene el secret key
    'path' => [ '/api/v1' ],                           // Aplica a todas las rutas que contengan 'api'
    'ignore' => [ '/api/v1/login', '/api/v1/dev' ],  // Omite la autenticación en las rutas de /api/login
    'algorithm' => $container['jwt']['algorithm'],  // Algoritmo de encriptación
    "error" => function ($response, $arguments)  // Callback en caso de que ocurra un error
    {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response->withJson($data, 401);
    },
    "callback" => function ($request, $response, $arguments) use ($container) // Callback en caso de que se autentique correctamente
    {
        // Guarda los datos del token desencriptados para poder se usado en los controladores
        // con la propiedad auth de $container
        $container['auth'] = $arguments['decoded'];
    }
]));