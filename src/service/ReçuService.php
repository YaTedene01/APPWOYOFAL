<?php
namespace App\service;

use App\core\App;
use App\entity\Reçu;
use App\repository\ReçuRepository;

class ReçuService {
    private ReçuRepository $reçuRepository;
    private static ?ReçuService $instance = null;

    private function __construct() {
        $this->reçuRepository = App::getDependencie("reçurepository");
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function verifierCompteur(string $numero_compteur): bool {
        $recu = $this->reçuRepository->findByCompteur($numero_compteur);
        return $recu !== null;
    }

    public function genererRecu(string $numero_compteur, float $montant): ?Reçu {
        if (!$this->verifierCompteur($numero_compteur)) {
            return null;
        }

        $recu = new Reçu();
        $recu->setNumeroCompteur($numero_compteur)
             ->setPrix($montant)
             ->setDate(date('Y-m-d H:i:s'))
             ->setCodeRecharge($this->genererCodeRecharge())
             ->setTranche($this->determinerTranche($montant));

        if ($this->reçuRepository->save($recu)) {
            return $recu;
        }
        return null;
    }

    public function sauvegarderRecu(Reçu $recu): bool {
        return $this->reçuRepository->save($recu);
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