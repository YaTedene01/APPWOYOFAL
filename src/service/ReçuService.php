<?php
namespace App\service;

use App\core\App;
use App\entity\Reçu;
use App\repository\ReçuRepository;

class ReçuService {
    private ReçuRepository $reçuRepository;
    private static ?ReçuService $instance = null;

    // Constants for pricing tiers
    const TRANCHE_1_LIMIT = 150;
    const TRANCHE_2_LIMIT = 250;
    const TRANCHE_1_PRICE = 91.17;
    const TRANCHE_2_PRICE = 136.49;
    const TRANCHE_3_PRICE = 149.06;

    private function __construct() {
        $this->reçuRepository = App::getDependencie("reçurepository");
    }

    public static function getInstance(): ReçuService {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function determinerTranche(string $numero_compteur): string {
        $debut_mois = date('Y-m-01 00:00:00');
        $fin_mois = date('Y-m-t 23:59:59');
        
        // Calculer la consommation totale du mois
        $consommation_mois = $this->calculerConsommationMensuelle($numero_compteur, $debut_mois, $fin_mois);
        
        if ($consommation_mois <= self::TRANCHE_1_LIMIT) {
            return "T1 (0-150 kWh)";
        } elseif ($consommation_mois <= self::TRANCHE_2_LIMIT) {
            return "T2 (151-250 kWh)";
        } else {
            return "T3 (>250 kWh)";
        }
    }

    private function calculerConsommationMensuelle(string $numero_compteur, string $debut, string $fin): float {
        $sql = "SELECT SUM(prix) as total FROM recu 
                WHERE numero_compteur = :numero_compteur 
                AND date BETWEEN :debut AND :fin";
        
        return $this->reçuRepository->getSommeConsommation($numero_compteur, $debut, $fin);
    }

    public function handleApiResponse($response): array {
        try {
            $decodedResponse = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
            return [
                'success' => true,
                'data' => $decodedResponse
            ];
        } catch (\JsonException $e) {
            return [
                'success' => false,
                'error' => 'Invalid JSON response',
                'message' => $e->getMessage()
            ];
        }
    }

    public function genererRecu(string $numero_compteur, float $montant): ?Reçu {
        try {
            $tranche = $this->determinerTranche($numero_compteur);
            $code_recharge = $this->genererCodeRecharge();
            
            $recu = new Reçu();
            $recu->setNumeroCompteur($numero_compteur)
                 ->setPrix($montant)
                 ->setDate(date('Y-m-d H:i:s'))
                 ->setCodeRecharge($code_recharge)
                 ->setTranche($tranche);

            if ($this->reçuRepository->save($recu)) {
                return $recu;
            }
            return null;
        } catch (\Exception $e) {
            // Log error and return null
            error_log("Error generating receipt: " . $e->getMessage());
            return null;
        }
    }

    private function genererCodeRecharge(): string {
        $prefix = 'RCG' . date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $random;
    }
}