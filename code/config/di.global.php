<?php

use App\Action\AjoutCollection;
use App\Action\Collection;
use App\DependencyInjection\Container;
use App\DependencyInjection\Exception\InvalidConfigurationException;
use App\Dispatcher;
use Gaufrette\Adapter;
use Gaufrette\Adapter\Local;
use Gaufrette\Filesystem;
use \App\DependencyInjection\Factory\Filesystem as FilesystemFactory;
use \App\DependencyInjection\Factory\FilesystemAdapter as FilesystemAdapter;
use Psr\Container\ContainerInterface;
use Psr\Log\NullLogger;

$dirname = dirname(__FILE__) . '/di.local.php';
$customParams = [];
if (is_file($dirname)) {
    $customParams = require $dirname;

    if (!$customParams) {
        $customParams = [];
    }
}

$baseParams = [
    'Filesystem' => new FilesystemFactory(),
    'Adapter' => new FilesystemAdapter(),
    'file_path' => function() {
        return isset($_ENV['FILE_PATH']) ? $_ENV['FILE_PATH'] : '/root/couverture';
    },
    'dispatcher' => function(ContainerInterface $container) {
        return new Dispatcher($container->get('logger'));
    },
    'router' => function(ContainerInterface $container) {
        return new \App\Router($container->get('config')['router']);
    },
    'config' => function() {
        return [
            'router' => [
                'routes' => [
                    'ajout_collection' => 'ajout_collection',
                    'collection' => 'collection',
                    'edition_ouvrage' => 'edition_ouvrage',
                    'identification' => 'identification',
                    'ouvrage' => 'ouvrage'
                ],
                'default_page_handler_key' => 'collection'
            ]
        ];
    },
    'ajout_collection' => function() {
        return new AjoutCollection();
    },
    'collection' => function(ContainerInterface $container) {
        return new Collection($container->get('db_connection'));
    },
    'db_connection' => function() {
        try {

            if (empty($_ENV['DB_HOST']) || !isset($_ENV['DB_HOST'])) {
                throw new Exception('DB is not configured as an environment var');
            }

            if (empty($_ENV['DB_USER']) || !isset($_ENV['DB_USER'])) {
                throw new Exception('DB is not configured as an environment var');
            }

            if (empty($_ENV['DB_PASS']) || !isset($_ENV['DB_PASS'])) {
                throw new Exception('DB is not configured as an environment var');
            }

            if (empty($_ENV['DB_NAME']) || !isset($_ENV['DB_NAME'])) {
                throw new Exception('DB is not configured as an environment var');
            }

            $host     = $_ENV['DB_HOST'];
            $user     = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASS'];
            $dbname   = $_ENV['DB_NAME'];

            $oConnexion = new PDO(
                "mysql:host={$host};dbname={$dbname}",
                $user,
                $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
            );
            $oConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $oConnexion;
        } catch (PDOException $exception) {
            throw new InvalidConfigurationException(
                "Connection failed or database cannot be selected : 
                {$exception->getMessage()}");
        }

    },
    'logger' => function() {
        return new NullLogger();
    },
    'looger_interface' => 'logger'
];

return Zend\Stdlib\ArrayUtils::merge($baseParams, $customParams);