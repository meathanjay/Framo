<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('welcomepage', new Route('/', [
    '_controller' => "Controllers\\Controller::index"
]));

# TO-DO: How to make the parameter part mandatory
$routes->add('hello', new Route('/hello/{name}', [
    'name' => 'World',
    '_controller' => 'Controllers\\Controller::hello'
]));

$routes->add('bye', new Route('/bye', [
    '_controller' => 'Controllers\\Controller::bye'
]));

// Route will not work
$routes->add('debug', new Route('/dump',[
    '_controller' => 'Controllers\\Controller::debug',
    'title' => 'My awesome title',
]));

$routes->add('leap_year', new Route('/leap_year/{year}?', [
    'year' => null,
    '_controller' => 'Controllers\\Controller::leapYear'
]));

return $routes;
