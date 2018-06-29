<?php

/**
 * Connexion à la base de données
 */
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
        'mysql:host=' . $host . ';dbname=' . $dbname,
        $user,
        $password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
    );
    $oConnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die('Connection failed or database cannot be selected : ' . $e->getMessage());
}
