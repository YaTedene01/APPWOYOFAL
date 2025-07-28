<?php
namespace App\repository;

use App\core\abstract\AbstractRepository;
use App\entity\Reçu;

class ReçuRepository extends AbstractRepository {
    private static ?ReçuRepository $instance = null;
    private $table = 'recu';

    private function __construct() {
        parent::__construct();
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function findByCompteur(string $numero_compteur): ?Reçu {
        $sql = "SELECT * FROM $this->table WHERE numero_compteur = :numero_compteur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero_compteur' => $numero_compteur]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? Reçu::toObject($data) : null;
    }

    public function save(Reçu $recu): bool {
        $sql = "INSERT INTO $this->table (nom_client, prenom_client, numero_compteur, code_recharge, date, prix, tranche)
                VALUES (:nom_client, :prenom_client, :numero_compteur, :code_recharge, :date, :prix, :tranche)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nom_client' => $recu->getNomClient(),
            'prenom_client' => $recu->getPrenomClient(),
            'numero_compteur' => $recu->getNumeroCompteur(),
            'code_recharge' => $recu->getCodeRecharge(),
            'date' => $recu->getDate(),
            'prix' => $recu->getPrix(),
            'tranche' => $recu->getTranche()
        ]);
    }
    public function selectAll(){ 

     }
     public function insert(){

     }
     public function update(){

     }
     public function delete(){

     }
     public function selectById(){

     }
     public function selectBy(Array $filtre){

     }
     public function getSommeConsommation(string $numero_compteur, string $debut, string $fin): float {
        $sql = "SELECT COALESCE(SUM(prix), 0) as total FROM recu 
                WHERE numero_compteur = :numero_compteur 
                AND date BETWEEN :debut AND :fin";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'numero_compteur' => $numero_compteur,
            'debut' => $debut,
            'fin' => $fin
        ]);
        
        return (float) $stmt->fetchColumn();
    }
}