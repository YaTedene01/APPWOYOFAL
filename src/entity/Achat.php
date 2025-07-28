<?php
namespace App\entity;

use App\core\abstract\AbstractEntity;

class Achat extends  AbstractEntity{
   private int $id; 
   private float $montant;
   private Array $client=[];
  
   public function __construct(int $id=0,float $montant=0)
    {
        $this->id=$id;
        $this->montant=$montant;
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
        public function getMontant()
        {
                return $this->montant;
        }
        public function setMontant($montant)
        {
                $this->montant = $montant;

                return $this;
        }
        public function getClient()
        {
                return $this->client;
        }
        public function addClient($client)
        {
                $this->client[] = $client;

                return $this;
        }
       
       
    public static function toObject($data): static{

        $achat=new static(
            $data['id'],
            $data['montant'],

        );  
        $achat->client = array_map(fn($clien) => Client::toObject($clien), $data['client']);
        return $achat;
    }
    public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'montant' => $this->getMontant(),
            'client' => array_map(fn($clien) => $clien->toArray(), $this->getClient())
        ];
    }

       
}