<?php
namespace App\entity;

use App\core\abstract\AbstractEntity;
class Citoyen extends AbstractEntity{
    private int $id;
    private string $nom;
    private string $prenom;
    private string $lieu_naissance;
    private string $date_naissance;
    private string $url_copie_carte_identite;
    private string $nci;


    public function __construct(int $id=0,string $nom='',string $prenom='',string $lieu_naissance='',string $date_naissance='',string $url_copie_carte_identite='',string $nci='')
    {
        $this->id=$id;
        $this->nom=$nom;
        $this->prenom=$prenom;
        $this->lieu_naissance=$lieu_naissance;
        $this->date_naissance=$date_naissance;
        $this->url_copie_carte_identite=$url_copie_carte_identite;
        $this->nci=$nci;


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

       
        public function getLieu_naissance()
        {
                return $this->lieu_naissance;
        }

        
        public function setLieu_naissance($lieu_naissance)
        {
                $this->lieu_naissance = $lieu_naissance;

                return $this;
        }

   
    public function getDate_naissance()
    {
        return $this->date_naissance;
    }

    
    public function setDate_naissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    
    public function getUrl_copie_carte_identite()
    {
        return $this->url_copie_carte_identite;
    }

    
    public function setUrl_copie_carte_identite($url_copie_carte_identite)
    {
        $this->url_copie_carte_identite = $url_copie_carte_identite;

        return $this;
    }

    
    public function getNci()
    {
        return $this->nci;
    }

    
    public function setNci($nci)
    {
        $this->nci = $nci;

        return $this;
    }
    public static function toObject($data): static{

        return new static(
            $data['id'],
            $data['nom'],
            $data['prenom'],
            $data['lieu_naissance'],
            $data['date_naissance'],
            $data['url_copie_carte_identite'],
            $data['nci'],

        );  
        if (isset($data['id'])) {
            $reflection = new \ReflectionClass(self::class);
            $property = $reflection->getProperty('id');
            $property->setAccessible(true);
            $property->setValue($citoyen, (int)$data['id']);
        }

        return $citoyen;
        
    }
    public  function toArray(): array{
        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'lieu_naissance' => $this->getLieu_naissance(),
            'date_naissance' => $this->getDate_naissance(),
            'url_copie_carte_identite' => $this->getUrl_copie_carte_identite(),
            'nci' => $this->getNci(),
           
        ];
    }
}
