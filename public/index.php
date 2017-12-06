<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Auryn\Injector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

/** @var RouteCollection $routes */
$routes = require_once __DIR__ . '/../config/routes.php';
/** @var Injector $injector */
$injector = require_once __DIR__ . '/../config/dependencies.php';

/** @var Request $request */
$request = $injector->make(Request::class);
$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

$parameters = $matcher->match($request->getPathInfo());
$request->attributes->add($parameters);

$controllerClass = $parameters['_controller'];
$action = $parameters['_action'];

$controller = $injector->make($controllerClass);
/** @var Response $response */
$response = $controller->$action($request);

$response->send();
