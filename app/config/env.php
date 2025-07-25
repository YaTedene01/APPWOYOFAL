<?php
require_once __DIR__.'/../../vendor/autoload.php';

use Dotenv\Dotenv;

$envPath = realpath(__DIR__ . '/../../');
if (!$envPath) {
    throw new Exception("Impossible de trouver le chemin racine");
}

$dotenv = Dotenv::createImmutable($envPath);
$dotenv->load();

define('DSN',$_ENV['DSN']);
define('DB_USER',$_ENV['DB_USER']);
define('DB_PASSWORD',$_ENV['DB_PASSWORD']);
define('WEB_ROUTE',$_ENV['WEB_ROUTE']);
define('DB_NAME',$_ENV['DB_NAME']);
define('DB_HOST',$_ENV['DB_HOST']);
define('DB_PORT',$_ENV['DB_PORT']);
define('PUBLIC_KEY',$_ENV['PUBLIC_KEY']);
define('CLOUD_NAME',$_ENV['CLOUD_NAME']);
define('PRIVATE_KEY',$_ENV['PRIVATE_KEY']);





