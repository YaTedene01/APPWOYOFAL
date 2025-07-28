<?php
namespace App\routes;

use App\controller\CitoyenController;
use App\controller\ReçuController;
use App\controller\ClientController;

return $routes = [
    
    // Méthode, URI, [Contrôleur, méthode]
    ['POST', '/api/recu/generer', [ReçuController::class, 'genererRecu']],
    ['POST', '/api/client/achat-woyofal', [ClientController::class, 'acheterWoyofal']],
    ['POST', '/api/client/acheter', [ClientController::class, 'acheter']],
];
