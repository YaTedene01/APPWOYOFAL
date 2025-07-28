<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../app/config/env.php';

$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpassword = DB_PASSWORD;
$dbhost = DB_HOST;
$dbport = DB_PORT;

try {
    // Connect to postgres database first
    $pdo = new \PDO("pgsql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpassword);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    // Close all connections to the database
    $sql = "SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '$dbname'";
    $pdo->exec($sql);
    
    // Now drop and recreate
    $pdo->exec("DROP DATABASE IF EXISTS $dbname");
    $pdo->exec("CREATE DATABASE $dbname");
    echo "Base de données '$dbname' créée.\n";
    
    // Reconnect to the new database
    $pdo = new \PDO("pgsql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpassword);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    //requete sql
    $sql = <<<SQL
    CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    numero_compteur VARCHAR(50) UNIQUE NOT NULL
);


   CREATE TABLE recu (
    id SERIAL PRIMARY KEY,
    nom_client VARCHAR(100) NOT NULL,
    prenom_client VARCHAR(100) NOT NULL,
    numero_compteur VARCHAR(50) NOT NULL,
    code_recharge VARCHAR(100) NOT NULL,
    date TIMESTAMP NOT NULL,
    prix NUMERIC(10,2) NOT NULL,
    tranche VARCHAR(50) NOT NULL
);

SQL;

    // Exécution
    $pdo->exec($sql);
    echo "Tables et types créés avec succès.\n";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
