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

// $map = array(
//     '/' => 'index',
//     '/bye'   => 'bye',
// );

// $path = $request->getPathInfo();

// if (isset($map[$path])) {
// 	ob_start();
// 	extract($request->query->all());
//     require sprintf(__DIR__.'/../src/pages/%s.php',$map[$path]);
//     //$response = new Response(ob_get_clean());
//     $response->setContent(ob_get_clean());
// } else {
//     $response = new Response('Not Found',404);
// }

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);
    $response->setContent(ob_get_clean());
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (Exception $e) {
    $response = new Response('An error occurred', 500);
}


$response->send();