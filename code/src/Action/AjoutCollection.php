<?php

namespace App\Action;

use App\Polyfill\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class AjoutCollection extends AbstractAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request)
    {
        return new Response\HtmlResponse(require dirname(dirname(dirname(__FILE__))) . '/include/ajout_collection.php');
    }
}