<?php

use Auryn\Injector;
use Symfony\Component\HttpFoundation\Request;

$injector = new Injector();

$injector->delegate(\PDO::class, function () {
    $pdo = new \PDO('sqlite:' . realpath(__DIR__ . '/../var/data/contatos.sqlite'));
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
});
$injector->delegate(Request::class, function () {
    return Request::createFromGlobals();
});

$injector->share(\PDO::class);
$injector->share(Request::class);

return $injector;
