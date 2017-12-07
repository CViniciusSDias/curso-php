<?php

use CursoPHP\Controller\ContatosController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$listarContatosRoute = new Route(
    '/contatos',
    ['_controller' => ContatosController::class, '_action' => 'listarAction']
);
$listarContatosRoute->setMethods('GET');
$routes->add('listar_contatos', $listarContatosRoute);

$inserirContatoRoute = new Route(
    '/contatos',
    ['_controller' => ContatosController::class, '_action' => 'novoContatoAction']
);
$inserirContatoRoute->setMethods('POST');
$routes->add('novo_contato', $inserirContatoRoute);

$removerContatoRoute = new Route(
    '/contatos/{codigoContato}',
    ['_controller' => ContatosController::class, '_action' => 'removerContatoAction']
);
$removerContatoRoute->setMethods('DELETE');
$routes->add('remover_contato', $removerContatoRoute);

$atualizarContatoRoute = new Route(
    '/contatos/{codigoContato}',
    ['_controller' => ContatosController::class, '_action' => 'atualizarContatoAction']
);
$atualizarContatoRoute->setMethods('PUT');
$routes->add('atualizar_contato', $atualizarContatoRoute);

return $routes;
