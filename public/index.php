<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

require_once __DIR__.'/../vendor/autoload.php';


$request = Request::createFromGlobals();
$routes = include __DIR__.'/../app/routes.php';

$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new Application($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();
