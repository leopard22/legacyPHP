<?php

namespace App\Action;

use App\Polyfill\RequestHandlerInterface;
use App\Repository\CollectionRepository;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

final class Collection extends AbstractAction implements RequestHandlerInterface
{
    /**
     * @var PDO
     */
    private $dbConnection;
    /**
     * @var CollectionRepository
     */
    private $collectionRepository;

    public function __construct(CollectionRepository $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function handle(ServerRequestInterface $request)
    {
        return new Response\HtmlResponse($this->render('collection.php', [
            'dbConnection' => $this->dbConnection
        ]));
    }
}