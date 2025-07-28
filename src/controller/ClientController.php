<?php
namespace App\controller;

use App\core\abstract\AbstractController;
use App\core\App;
use App\service\ClientService;
use App\service\ReçuService;

class ClientController extends AbstractController {
    private ClientService $clientService;
    private ReçuService $reçuService;

    public function __construct() {
        parent::__construct();
        $this->clientService = App::getDependencie('clientservice');
        $this->reçuService = App::getDependencie('reçuservice');
    }

    public function acheterWoyofal() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $numero_compteur = $data['numero_compteur'] ?? '';
        $montant = floatval($data['montant'] ?? 0);

        // Validation des données
        if (empty($numero_compteur) || $montant <= 0) {
            http_response_code(400);
            echo json_encode([
                'statut' => 'error',
                'message' => 'Numéro de compteur et montant requis',
                'code' => 400
            ]);
            return;
        }

        // Effectuer l'achat
        $recu = $this->clientService->acheterWoyofal($numero_compteur, $montant);

        if ($recu) {
            // Sauvegarder le reçu
            $this->reçuService->sauvegarderRecu($recu);
            
            http_response_code(200);
            echo json_encode([
                'statut' => 'success',
                'message' => 'Achat effectué avec succès',
                'code' => 200,
                'data' => [
                    'nomClient' => $recu->getNomClient(),
                    'prenomClient' => $recu->getPrenomClient(),
                    'numero_compteur' => $recu->getNumeroCompteur(),
                    'codeRecharge' => $recu->getCodeRecharge(),
                    'date' => $recu->getDate(),
                    'prix' => $recu->getPrix(),
                    'tranche' => $recu->getTranche()
                ]
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'statut' => 'error',
                'message' => 'Numéro de compteur invalide',
                'code' => 404
            ]);
        }
    }
     public function index(){
    }
    public function create(){
    }
    public function show(){
    }
    public function update(){
    }
    public function destroy(){
    }
    public function store(){
    }
    public function edit(){
    }
}