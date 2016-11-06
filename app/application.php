<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Application
{
    /**
     * Url Matcher
     *
     * @var \Symfony\Component\Routing\Matcher\UrlMatcherInterface
     */
    protected $matcher;

    /**
     * Controller Resolver
     * @var \Symfony\Component\HttpKernel\Controller\ControllerResolverInterface
     */
    protected $controllerResolver;

    /**
     * @var \Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface
     */
    protected $argumentResolver;

    /**
     * @param \Symfony\Component\Routing\Matcher\UrlMatcherInterface                 $matcher
     * @param \Symfony\Component\HttpKernel\Controller\controllerResolverInterface   $controllerResolver
     * @param Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;     $argumentResolver
     */
    public function __construct(
        UrlMatcherInterface $matcher,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver
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

