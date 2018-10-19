<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../views/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        // Configuración de base de datos con Eloquen
        'db' => [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'my_db_name',
            'username'  => 'my_db_user',
            'password'  => 'my_db_password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        ///////////////////////////////////////////////////////////

        // Configuración de los datos para generar JWT
        'jwt' => [
            'secret' => 'BPvfZW2^XPLhVjmAgDKp8t9M$LjC#aS#HRfzz%?d#NH%PfZLr$V97!gE9jpKmyLaYPUw+3-HuPXGmNGg*r+9jTpjU=6gG7@wr7%-4ERfqn3c7AKAmjK6ub%8rTL?38fh',
            'exp_days' => 14,
            'exp_min' => 0,
            'exp_sec' => 0,
            'algorithm' => 'HS256'
        ]
        ///////////////////////////////////////////////////////////
    ],
];
