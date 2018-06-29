<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/06/18
 * Time: 11:01
 */

namespace App;


use App\DependencyInjection\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use App\Router;
use App\Dispatcher;

class Application
{
    private $router;
    private $dispatcher;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(Router $router, Dispatcher $dispatcher, ContainerInterface $container)
    {
        $this->router = $router;
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public static function createFromConfig($config)
    {
        $container = new Container($config);
        $router = $container->get('router');
        $dispatcher = $container->get('dispatcher');
        return new self($router, $dispatcher, $container);
    }

    public function run()
    {
        $request = ServerRequestFactory::fromGlobals();
        //route
        $handlerName = $this->router->handlerForRequest($request);
        $handler = $this->container->get($handlerName);
        //dispatch
        /* @var $response ResponseInterface */
        return $this->dispatcher->dispatch($request, $handler);
    }
}