<?php

require __DIR__ . '/../bootstrap.php';

use Code\Sistema\Entity\Cliente;
use Code\Sistema\Mapper\ClienteMapper;
use Code\Sistema\Service\ClienteService;

use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($em) {
    $clienteEntity = new Cliente();
    $clienteMapper = new ClienteMapper($em);
    $clienteService = new ClienteService($clienteEntity, $clienteMapper);

    return $clienteService;
};

$app->post('/api/clientes', function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $result = $app['clienteService']->insert($dados);

    return $app->json($result);
});

$app->post('/api/clientes/{id}', function($id, Request $request) use ($app){
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');

    $result = $app['clienteService']->update($id, $dados);

    return $app->json($result);
});

$app->delete('/api/clientes/{id}', function($id) use ($app){
   $result = $app['clienteService']->delete($id);

   return $app->json($result);
});

$app->run();