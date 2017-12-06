<?php

use CursoPHP\Controller\ContatosController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$listarContatosRoute = new Route('/contatos', ['_controller' => ContatosController::class, '_action' => 'listarAction']);
$listarContatosRoute->setMethods('GET');
$routes->add('listar_contatos', $listarContatosRoute);

$inserirContatoRoute = new Route(
    '/contatos/novo',
    ['_controller' => ContatosController::class, '_action' => 'novoContatoAction']
);
$inserirContatoRoute->setMethods('POST');
$routes->add('novo_contato', $inserirContatoRoute);

return $routes;
