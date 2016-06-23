<?php

require __DIR__ . '/../bootstrap.php';

use Code\Sistema\Service\ClienteService;

use Symfony\Component\HttpFoundation\Request;

$app['clienteService'] = function () use ($em) {
    $clienteService = new ClienteService($em);

    return $clienteService;
};

//Busca
$app->get('/api/clientes/search/{name}', function($name) use ($app){
   $result = $app['clienteService']->searchByName($name);

   return $app->json($result);
});

//Pagiação
$app->get('/api/clientes/page/{page}', function($page) use ($app){
    $result = $app['clienteService']->paginate($page, 5);

    return $app->json($result);
});

$app->post('/api/clientes', function (Request $request) use ($app) {
    $dados['nome'] = $request->get('nome');
    $dados['email'] = $request->get('email');
    $dados['rg'] = $request->get('rg');
    $dados['cpf'] = $request->get('cpf');

    $result = $app['clienteService']->insert($dados);

    $data['id'] = $result->getId();
    $data['nome'] = $result->getNome();
    $data['email'] = $result->getEmail();
    $data['rg'] = $result->getProfile()->getRg();
    $data['cpf'] = $result->getProfile()->getCpf();

    return $app->json($data);
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