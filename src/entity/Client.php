<?php
namespace App\entity;

use App\core\abstract\AbstractEntity;
class Client extends AbstractEntity{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $numero_compteur;


    public function __construct(int $id=0,string $nom='',string $prenom='',string $numero_compteur=''){
        $this->id=$id;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->numero_compteur=$numero_compteur;
    }
    

        public function getId()
        {
                return $this->id;
        }

        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

       
        public function getNom()
        {
                return $this->nom;
        }

       
        public function setNom($nom)
        {
                $this->nom = $nom;

                return $this;
        }

        public function getPrenom()
        {
                return $this->prenom;
        }

        
        public function setPrenom($prenom)
        {
                $this->prenom = $prenom;

                return $this;
        }

       
        public function getNumeroCompteur()
        {
                return $this->numero_compteur;
        }
        public function setNumeroCompteur($numero_compteur)
        {
                $this->numero_compteur = $numero_compteur;

                return $this;
        }
    public static function toObject($data): static{

        return new static(
            $data['id'],
            $data['nom'],
            $data['prenom'],
            $data['numero_compteur']
           

        );  
        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($client, (int)$data['id']);
        }

        return $client;
        
    }
    public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'numero_compteur' => $this->getNumeroCompteur()
           
        ];
    }
}
