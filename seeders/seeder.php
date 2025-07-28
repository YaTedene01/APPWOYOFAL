<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/env.php';


try {
    $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vider les tables d'abord
    $pdo->exec("TRUNCATE TABLE recu CASCADE");
    $pdo->exec("TRUNCATE TABLE clients CASCADE");

    echo "Insertion de fausses données...\n";
    //client
   
    $stmt = $pdo->prepare(" 
    INSERT INTO clients (nom, prenom, numero_compteur) VALUES    
     (?, ?, ?)
    " );
    $stmt->execute(['Diop', 'Moussa', 'SN123456_1']);
    $stmt->execute(['Faye', 'Aminata', 'SN789012_1']);
    $stmt->execute(['Ndiaye', 'Cheikh', 'SN345678_1']);


    //reçu
    $stmt = $pdo->prepare("
    INSERT INTO recu (nom_client, prenom_client, numero_compteur, code_recharge, date, prix, tranche) VALUES   
    (?,?,?,?,?,?,?)
    ");
    
    // Utiliser le format correct pour les dates
    $stmt->execute(['Diop', 'Moussa', 'SN123456_1', 'RCG202507240001', '2025-07-10', 3500.00, '0-150KW']);
    $stmt->execute(['Faye', 'Aminata', 'SN789012_1', 'RCG202507240002', '2025-07-15', 5000.00, '151-250KW']);
    $stmt->execute(['Ndiaye', 'Cheikh', 'SN345678_1', 'RCG202507240003', '2025-07-19', 2000.00, '0-150KW']);


echo "Données insérées avec succès.\n";

} catch (PDOException $e) {
    echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}

