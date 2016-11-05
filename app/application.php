<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Application
{
    /**
     * Url Matcher
     *
     * @var \Symfony\Component\Routing\Matcher\UrlMatcher
     */
    protected $matcher;

    /**
     * Controller Resolver
     * @var \Symfony\Component\HttpKernel\Controller\ControllerResolver
     */
    protected $controllerResolver;

    /**
     * @var \Symfony\Component\HttpKernel\Controller\ArgumentResolver
     */
    protected $argumentResolver;

    /**
     * @param \Symfony\Component\Routing\Matcher\UrlMatcher                 $matcher
     * @param \Symfony\Component\HttpKernel\Controller\controllerResolver   $controllerResolver
     * @param Symfony\Component\HttpKernel\Controller\ArgumentResolver;     $argumentResolver
     */
    public function __construct(
        UrlMatcher $matcher,
        ControllerResolver $controllerResolver,
        ArgumentResolver $argumentResolver
    ) {
        $this->matcher = $matcher;

        $this->controllerResolver = $controllerResolver;

        $this->argumentResolver = $argumentResolver;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request     $request
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request)
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->controllerResolver->getController($request);

            $arguments = $this->argumentResolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {

            return new Response('Not Found', 404);

        } catch (\Exception $e) {

            return new Response('An error occurred', 500);

        }
    }
}

