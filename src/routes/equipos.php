<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
$bd = require __DIR__ . '/../config/bd.php';
use Slim\App;

//Solo registra equipos Punto A
return function (App $app) use ($bd) {
$app->post('/equipos', function (Request $request, Response $response) use ($bd) {
    $datos = $request->getParsedBody();
    if (!$datos) {
        $datos = json_decode($request->getBody()->getContents(), true);
    }

    $equipo = [
        'nombreEquipo' => $datos['nombreEquipo'] ?? null,
        'institucion' => $datos['institucion'] ?? null,
        'departamento' => $datos['departamento'] ?? null,
        'municipio' => $datos['municipio'] ?? null,
        'direccion' => $datos['direccion'] ?? null,
        'telefono' => $datos['telefono'] ?? null,
    ];

    $id = $bd->table('equipos')->insertGetId($equipo);
    $nuevo = $bd->table('equipos')->where('idEquipo', $id)->first();
    $response->getBody()->write(json_encode($nuevo));
    return $response->withHeader('Content-Type', 'application/json');
});
    //Solo muestra los equipos Punto B
    $app->get('/equipos', function (Request $request, Response $response) use ($bd) {
        $equipos = $bd->table('equipos')->get();
        $response->getBody()->write($equipos->toJson());
        return $response->withHeader('Content-Type', 'application/json');
    });
};