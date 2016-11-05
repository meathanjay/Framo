<?php
error_reporting(1);
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$response = new Response();
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$resolver = new ControllerResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $resolver->getController($request);

    $arguments = $resolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);

} catch (Routing\Exception\ResourceNotFoundException $e) {

    $response = new Response('Not Found', 404);

} catch (Exception $e) {

    $response = new Response('An error occurred', 500);
}

// send response back to the browser
$response->send();
