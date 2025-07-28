<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../app/config/env.php';

$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpassword = DB_PASSWORD;
$dbhost = DB_HOST;
$dbport = DB_PORT;

try {
    // Première connexion à PostgreSQL
    $pdo = new \PDO("pgsql:host=$dbhost;port=$dbport;dbname=postgres", $dbuser, $dbpassword);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    // Fermer les connexions existantes
    $sql = "SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '$dbname' AND pid <> pg_backend_pid()";
    $pdo->exec($sql);
    
    // Recréer la base de données
    $pdo->exec("DROP DATABASE IF EXISTS $dbname");
    $pdo->exec("CREATE DATABASE $dbname");
    echo "Base de données '$dbname' créée.\n";
    
    // Fermer la première connexion
    $pdo = null;
    
    // Attendre un peu avant de se reconnecter
    sleep(1);
    
    // Nouvelle connexion à la base créée
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
    echo "Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
