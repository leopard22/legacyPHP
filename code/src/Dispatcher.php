<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/06/18
 * Time: 11:33
 */

namespace App;


use App\Polyfill\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response\TextResponse;

class Dispatcher
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function dispatch($request, RequestHandlerInterface $handler)
    {
        try {
            return $handler->handle($request);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage(), $exception->getTrace());
            return new TextResponse('An error occurred', 500);
        }
    }
}