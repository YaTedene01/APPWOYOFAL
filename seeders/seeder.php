<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/env.php';


try {
    $dsn = "pgsql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Insertion de fausses données...\n";
    //client
   
    $stmt = $pdo->prepare(" 
    INSERT INTO clients (nom, prenom, numero_compteur) VALUES    
     (?, ?, ?)
    " );
    $stmt->execute(['Diop', 'Moussa', 'SN123456']);
    $stmt->execute(['Faye', 'Aminata', 'SN789012']);
    $stmt->execute(['Ndiaye', 'Cheikh', 'SN345678']);


    //reçu
    $stmt = $pdo->prepare("
    INSERT INTO recu (nom_client, prenom_client, numero_compteur, code_recharge, date, prix, tranche) VALUES   
    (?,?,?,?,?,?,?)

");
    $stmt->execute(['Diop', 'Moussa', 'SN123456', 'RCG202507240001', 10-07-2025, 3500.00, '0-150KW']);
    $stmt->execute(['Faye', 'Aminata', 'SN789012', 'RCG202507240002', 15-07-2025, 5000.00, '151-250KW']);
    $stmt->execute(['Ndiaye', 'Cheikh', 'SN345678', 'RCG202507240003', 19-07-2025, 2000.00, '0-150KW']);



echo "Données insérées avec succès.\n";

} catch (PDOException $e) {
    echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
    exit(1);
}

