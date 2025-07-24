<?php
namespace App\repository;

use App\core\abstract\AbstractRepository;
use App\entity\Citoyen;

class CitoyenRepository extends AbstractRepository{

private static ?CitoyenRepository $instance=null;
    private $table = 'citoyen';
    private function __construct(){
        parent::__construct();
    }
    public static function getInstance(){
        if(is_null (self::$instance)){
           self::$instance=new self();

        }
        return self::$instance;

    }
     public function findByNci(string $nci): ?Citoyen
    {
        $sql = "SELECT * FROM $this->table  WHERE nci = :nci";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nci' => $nci]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? Citoyen::toObject($data) : null;
    }



    
    public function findAll(): array
    {
        $sql = "SELECT * FROM $this->table";
            $stmt = $this->pdo->query($sql);
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return array_map(fn($item) => Citoyen::toObject($item), $data);
        }
        

    public function save(Citoyen $citoyen): bool
    {
        $sql = "INSERT INTO citoyen (nci, nom, prenom, date_naissance, lieu_naissance, url_copie_carte_identite)
                VALUES (:nci, :nom, :prenom, :date_naissance, :lieu_naissance, :url_copie_carte_identite)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nci' => $citoyen->getNci(),
            'nom' => $citoyen->getNom(),
            'prenom' => $citoyen->getPrenom(),
            'date_naissance' => $citoyen->getLieu_naissance(),
            'lieu_naissance' => $citoyen->getLieu_naissance(),
            'url_copie_carte_identite' => $citoyen->getUrl_Copie_Carte_Identite(),
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
    


}