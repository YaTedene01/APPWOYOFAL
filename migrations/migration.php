<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__.'/../app/config/env.php';

$dbname= DB_NAME;
$dbuser=DB_USER;
$dbpassword=DB_PASSWORD;
$webroute=WEB_ROUTE;
try{ 
    //connexion server
    $pdo= new \PDO("pgsql:host=localhost;port=5434;dbname=appdb",$dbuser,$dbpassword);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    //connexion base de donnees
    $pdo->exec("DROP DATABASE IF EXISTS $dbname");
    $pdo->exec("CREATE DATABASE $dbname");
    echo"Base de données '$dbname' créee.\n";
    //reconnexion
    $pdo= new \PDO("pgsql:host=localhost;port=5434;dbname=appdb",$dbuser,$dbpassword);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    //requete sql
    $sql = <<<SQL
    --table
    CREATE TABLE citoyen (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    lieu_naissance VARCHAR(150) NOT NULL,
    date_naissance DATE NOT NULL,
    url_copie_carte_identite VARCHAR(255),
    nci VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE journal (
    id SERIAL PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    localisation VARCHAR(150),
    adresse_ip VARCHAR(45),
    statut VARCHAR(50)
);

SQL;

    // Exécution
    $pdo->exec($sql);
    echo "Tables et types créés avec succès.\n";

} catch (PDOException $e) {
    echo " Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
