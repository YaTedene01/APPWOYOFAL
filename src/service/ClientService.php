<?php
namespace App\service;

use App\core\App;
use App\entity\Client;
use App\entity\Reçu;
use App\repository\ClientRepository;

class ClientService {
    private ClientRepository $clientRepository;
    private static ?ClientService $instance = null;

    private function __construct() {
        $this->clientRepository = App::getDependencie("clientrepository");
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function acheterWoyofal(string $numero_compteur, float $montant): ?Reçu {
        // Vérifier si le client existe
        $client = $this->clientRepository->findByNumeroCompteur($numero_compteur);
        
        if (!$client) {
            return null;
        }

        // Créer le reçu
        $recu = new Reçu();
        $recu->setNomClient($client->getNom())
             ->setPrenomClient($client->getPrenom())
             ->setNumeroCompteur($numero_compteur)
             ->setPrix($montant)
             ->setDate(date('Y-m-d H:i:s'))
             ->setCodeRecharge($this->genererCodeRecharge())
             ->setTranche($this->determinerTranche($montant));

        return $recu;
    }

    private function genererCodeRecharge(): string {
        return strtoupper(uniqid());
    }

    private function determinerTranche(float $montant): string {
        if ($montant <= 5000) return "T1";
        if ($montant <= 10000) return "T2";
        return "T3";
    }
}