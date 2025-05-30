<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Instanciar base de datos (solo una vez)
$bd = require __DIR__ . '/../src/config/bd.php';

// Crear la app Slim
$app = AppFactory::create();

// Registrar rutas y pasar $bd
(require __DIR__ . '/../src/routes/equipos.php')($app, $bd);
(require __DIR__ . '/../src/routes/jugadores.php')($app, $bd);

$app->run();