<?php
namespace App\service;

use App\core\App;
use App\entity\Reçu;
use App\repository\ReçuRepository;

class ReçuService {
    private ReçuRepository $reçuRepository;
    private static ?ReçuService $instance = null;

    // Constantes pour les tranches
    const TRANCHE_1_LIMIT = 150; // 0-150 kWh
    const TRANCHE_2_LIMIT = 250; // 151-250 kWh
    const TRANCHE_1_PRICE = 91.17; // Prix par kWh en FCFA
    const TRANCHE_2_PRICE = 136.49;
    const TRANCHE_3_PRICE = 149.06;

    private function __construct() {
        $this->reçuRepository = App::getDependencie("reçurepository");
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

    public function genererRecu(string $numero_compteur, float $montant): ?Reçu {
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
    }

    private function genererCodeRecharge(): string {
        $prefix = 'RCG' . date('Ymd');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return $prefix . $random;
    }
}