<?php
namespace App\repository;

use App\core\abstract\AbstractRepository;
use App\entity\Client;

class ClientRepository extends AbstractRepository {
    private static ?ClientRepository $instance = null;
    private $table = 'client';

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function findByNumeroCompteur(string $numero_compteur): ?Client {
        $sql = "SELECT * FROM $this->table WHERE numero_compteur = :numero_compteur";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['numero_compteur' => $numero_compteur]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $data ? Client::toObject($data) : null;
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

}
