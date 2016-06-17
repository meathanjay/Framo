<?php
error_reporting(1);
// framework/front.php
require_once __DIR__.'/../vendor/autoload.php';
//require_once __DIR__.'/../init.php';

use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$request = Request::createFromGlobals();
$routes = include __DIR__.'/../src/app.php';

$response = new Response();
//$routes = new RouteCollection();
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
    return new Response(ob_get_clean());
}

try {

    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);

} catch (Routing\Exception\ResourceNotFoundException $e) {

    $response = new Response('Not Found', 404);

} catch (Exception $e) {

    $response = new Response('An error occurred', 500);
}


$response->send();