<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$bd = require __DIR__ . '/../config/bd.php';
use Slim\App;

//Solo Registra jugadores Punto C
return function (App $app, $bd) {
    $app->post('/jugadores', function (Request $request, Response $response) use ($bd) {
        $datos = $request->getParsedBody();
        if (!$datos) {
            $datos = json_decode($request->getBody()->getContents(), true);
        }

        $id = $bd->table('jugadores')->insertGetId([
            'nombres' => $datos['nombres'] ?? null,
            'apellidos' => $datos['apellidos'] ?? null,
            'fechaNacimiento' => $datos['fechaNacimiento'] ?? null,
            'genero' => $datos['genero'] ?? null,
            'posicion' => $datos['posicion'] ?? null,
            'idEquipo' => $datos['idEquipo'] ?? null
        ]);

        $jugador = $bd->table('jugadores')->where('idJugador', $id)->first();
        $response->getBody()->write(json_encode($jugador));
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    //Solo muestra jugadores pasandoles el id Punto D
    $app->get('/jugadores/{id}', function (Request $request, Response $response, $args) use ($bd) {
        $jugador = $bd->table('jugadores')->where('idJugador', $args['id'])->first();

        if (!$jugador) {
            $response->getBody()->write('Jugador no encontrado');
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($jugador));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
