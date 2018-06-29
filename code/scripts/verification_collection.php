#!/usr/bin/php
<?php

/**
 * Ce script vérifie que les différentes collections sont valides et alertent les administrateurs dans le cas contraire.
 */

require dirname(dirname(__FILE__)) . '/vendor/autoload.php';

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

$bdd = mysql_connect($host, $user, $password);
mysql_set_charset("UTF8", $bdd);
mysql_select_db($dbname);

$result = mysql_query('SELECT * FROM collection;');

if (!$result) {
    file_put_contents(
        dirname(dirname(__FILE__)).'/logs/application.log',
        file_get_contents(dirname(dirname(__FILE__)).'/logs/application.log')."\nImpossible d'exécuter la requête dans la base : " . mysql_error()
    );
    exit;
}

if (mysql_num_rows($result) == 0) {
    file_put_contents(
        dirname(dirname(__FILE__)).'/logs/application.log',
        file_get_contents(dirname(dirname(__FILE__)))."\nAucune ligne trouvée, rien à afficher."
    );
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    if (!$row['description']) {
        file_put_contents(
            dirname(dirname(__FILE__)).'/logs/application.log',
            file_get_contents(dirname(dirname(__FILE__)).'/logs/application.log')."\n".time()."{$row['titre']} n'a pas de description"
        );
    }
}

mysql_free_result($result);

