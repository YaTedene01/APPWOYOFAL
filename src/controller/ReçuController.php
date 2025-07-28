<?php
namespace App\controller;

use App\core\abstract\AbstractController;
use App\core\App;
use App\service\ReçuService;

class ReçuController extends AbstractController {
    private ReçuService $reçuService;

    public function __construct() {
        parent::__construct();
        $this->reçuService = App::getDependencie('reçuservice');
    }

    public function genererRecu() {
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents('php://input'), true);
        $numero_compteur = $data['numero_compteur'] ?? '';
        $montant = floatval($data['montant'] ?? 0);

        if (empty($numero_compteur) || $montant <= 0) {
            http_response_code(400);
            echo json_encode([
                'statut' => 'error',
                'message' => 'Numéro de compteur et montant requis',
                'code' => 400
            ]);
            return;
        }

        $recu = $this->reçuService->genererRecu($numero_compteur, $montant);

        if ($recu) {
            http_response_code(200);
            echo json_encode([
                'statut' => 'success',
                'message' => 'Reçu généré avec succès',
                'code' => 200,
                'data' => $recu->toArray()
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