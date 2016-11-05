<?php
//namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class Controller
{
	public function index(Request $request)
	{
		return new Response('Hello World');
	}

	public function bye()
	{
		return new Response('Goodbye!');
	}

	public function hello()
	{
		return new Response('Hello Method');
	}

	public function debug()
	{
		return new Response('Debug!');
	}

	public function leapYear($year)
	{
		return new Response($year);
	}
}
