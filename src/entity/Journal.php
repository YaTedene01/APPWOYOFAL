<?php
namespace App\entity;

use App\core\abstract\AbstractEntity;

class Journal extends  AbstractEntity{
   private int $id; 
   private string $date;
   private string $localisation;
   private string $adresse_ip;
   private string $statut;
   public function __construct(int $id=0,string $date='',string $localisation='',string $adresse_ip='',string $statut='')
    {
        $this->id=$id;
        $this->date=$date;
        $this->localisation=$localisation;
        $this->adresse_ip=$adresse_ip;
        $this->statut=$statut;

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

       
       
    public static function toObject($data): static{

        return new static(
            $data['id'],
            $data['date'],
            $data['localisation'],
            $data['adresse_ip'],
            $data['statut'],

        );  
        
    }
    public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'date' => $this->getDate(),
            'localisation' => $this->getLocalisation(),
            'adresse_ip' => $this->getAdresse_ip(),
            'statut' => $this->getStatut(),
           
        ];
    }

        public function getDate()
        {
                return $this->date;
        }

        
        public function setDate($date)
        {
                $this->date = $date;

                return $this;
        }

      
        public function getLocalisation()
        {
                return $this->localisation;
        }

        
        public function setLocalisation($localisation)
        {
                $this->localisation = $localisation;

                return $this;
        }

   
   public function getAdresse_ip()
   {
      return $this->adresse_ip;
   }

      public function setAdresse_ip($adresse_ip)
   {
      $this->adresse_ip = $adresse_ip;

      return $this;
   }

  
   public function getStatut()
   {
      return $this->statut;
   }

  
   public function setStatut($statut)
   {
      $this->statut = $statut;

      return $this;
   }
}