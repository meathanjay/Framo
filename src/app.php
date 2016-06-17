<?php
error_reporting(1);
include_once __DIR__.'/../Controller.php';

//use Controller\Controller;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

$routes = new RouteCollection();

$routes->add('welcomepage', new Route('/', [
	'_controller' => "Controller::index"
]));

# TO-DO: How to make the parameter part mandatory
$routes->add('hello', new Route('/hello/{name}', [
	'name' => 'World',
	'_controller' => 'Controller::hello'	
]));

$routes->add('bye', new Route('/bye', [
	'_controller' => 'Controller::bye'
]));

// Route will not work
$routes->add('debug', new Route('/dump',[
	'_controller' => 'Controller::debug',
	'title'	=> 'My awesome title',
]));

$routes->add('leap_year', new Route('/leap_year/{year}?', [
	'year' => null,
	'_controller' => 'Controller::leapYear'
]));

return $routes;