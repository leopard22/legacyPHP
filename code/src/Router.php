<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/06/18
 * Time: 11:25
 */

namespace App;


use App\Polyfill\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Router
{
    private $routes;

    private $defaultPage;

    public function __construct(array $config)
    {
        $this->routes = $config['routes'];
        $this->defaultPage = $config['default_page_handler_key'] ?
            $config['default_page_handler_key'] : 'homepage';
    }

    /**
     * @param ServerRequestInterface $request
     * @return String
     */
    public function handlerForRequest(ServerRequestInterface $request)
    {
        $page =$request->getQueryParams()['page'];

        if (!$page) {
            $page = $this->defaultPage;
        }

        if (substr($page,-4) === '.php') {
            $page = substr($page, 0, -4);
        }

        if (!isset($this->routes[$page])) {
            throw new \RuntimeException("No route found for that URL: {$page}");
        }

        return $page;
    }
}