<?php

use App\core\App;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/config/bootstrap.php';

// Add JSON API endpoint
if ($_SERVER['REQUEST_URI'] === '/api/data') {
    header('Content-Type: application/json');
    $reçuService = App::getDependencie('reçuservice');
    echo $reçuService->getAllReçusAsJson();
    exit;
}

try {
    $pdo = \App\Core\Database::getInstance();

    // echo "Connexion à la base de données réussie.<br>";

} catch (Exception $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}