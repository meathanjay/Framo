<?php
// example.com/src/app.php
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;

function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }
    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new RouteCollection();

$routes->add('welcomepage', new Route('/', [
	'_controller' => function($request) {
		return new Response('Welcome to my awesome framework!');
	}
]));
# TO-DO: How to make the parameter part mandatory
$routes->add('hello', new Route('/hello/{name}', [
	'name' => 'World',
	'_controller' => function($request) {

		$request->attributes->set('title','My awesome framework title');
		$response = render_template($request);
		$response->headers->set('Content-Type','text/html');
		return $response;
	}	
]));
$routes->add('bye', new Route('/bye', [
	'_controller' => function($request) {
		return new Response('Good Bye!');
	}
]));

// Route will not work
$routes->add('debug', new Route('/dump',[
	'_controller' => function ($request) {
		echo '<pre>';
		$response = new Response(print_r($request,true));
		$response->headers->set('Content-Type','text/html');
		return $response;
	},
	'title'	=> 'My awesome title',
]));

$routes->add('leap_year', new Route('/leap_year/{year}', [
	'_controller' => function($request) {
		if(is_leap_year($request->attributes->get('year'))) {
			return new Response('Yes, this is a leap year');
		}
		return new Response('Its not a leap year');
	}
]));

return $routes;