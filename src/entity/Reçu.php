<?php
namespace App\entity;
use App\core\abstract\AbstractEntity;
class Reçu extends AbstractEntity {
    private int $id;
    private string $nomClient;
    private string $prenomClient;
    private string $numero_compteur;
    private string $codeRecharge;
    private string $date;
    private float $prix;
    private string $tranche;
    private Array $client=[];

    public function __construct(int $id=0, string $nomClient='', string $prenomClient='', string $numero_compteur='', string $codeRecharge='', string $date='', float $prix=0.0, string $tranche='') {
        $this->id = $id;
        $this->nomClient = $nomClient;
        $this->prenomClient = $prenomClient;
        $this->numero_compteur = $numero_compteur;
        $this->codeRecharge = $codeRecharge;
        $this->date = $date;
        $this->prix = $prix;
        $this->tranche = $tranche;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function getNomClient() {
        return $this->nomClient;
    }
    public function setNomClient($nomClient) {
        $this->nomClient = $nomClient;
        return $this;
    }
    public function getPrenomClient() {
        return $this->prenomClient;
    }
    public function setPrenomClient($prenomClient) {
        $this->prenomClient = $prenomClient;
        return $this;
    }
    public function getNumeroCompteur() {
        return $this->numero_compteur;
    } 
    public function setNumeroCompteur($numeroCompteur) {
        $this->numero_compteur = $numeroCompteur;
        return $this;
    }
    public function getCodeRecharge() {
        return $this->codeRecharge;
    }
    public function setCodeRecharge($codeRecharge) {
        $this->codeRecharge = $codeRecharge;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    public function getPrix() {
        return $this->prix;
    }
    public function setPrix($prix) {
        $this->prix = $prix;
        return $this;
    }
    public function getTranche() {
        return $this->tranche;
    }
    public function setTranche($tranche) {
        $this->tranche = $tranche;
        return $this;
    }
    public function getClient() {
        return $this->client;
    }                                                                                                  

    public function addClient($client) {
        $this->client[] = $client;
        return $this;
    }
    public static function toObject($data): static {
        $reçu = new static(
            $data['id'],
            $data['nomClient'],
            $data['prenomClient'],
            $data['numero_compteur'],
            $data['codeRecharge'],
            $data['date'],
            $data['prix'],
            $data['tranche']
        );
        $reçu->client = array_map(fn($clien) => Client::toObject($clien), $data['client']);
        return $reçu;
    }
    public function toArray(): array {
        return [
            'id' => $this->getId(),
            'nomClient' => $this->getNomClient(),
            'prenomClient' => $this->getPrenomClient(),
            'numero_compteur' => $this->getNumeroCompteur(), 
            'codeRecharge' => $this->getCodeRecharge(),
            'date' => $this->getDate(),
            'prix' => $this->getPrix(),
            'tranche' => $this->getTranche(),
            'client' => array_map(fn($clien) => $clien->toArray(), $this->getClient())
        ];
    }

}
    