<?php
namespace App\controller;

use App\Core\Abstract\AbstractController;
use App\core\App;
use App\service\CitoyenService;

class CitoyenController extends AbstractController{
    private  CitoyenService $citoyenService;
        
        public function __construct(){
            parent::__construct();
            $this->citoyenService=App::getDependencie('citoyenservice');
            
        }
        
       public function findByNci(string $nci)
    {
        header('Content-Type: application/json');
        $citoyen = $this->citoyenService->findByNci($nci);

        if ($citoyen) {
            http_response_code(200);
            echo json_encode([
                'data' => [
                    'nci' => $citoyen->getNci(),
                    'nom' => $citoyen->getNom(),
                    'prenom' => $citoyen->getPrenom(),
                    'date_naissance' => $citoyen->getLieu_naissance(),
                    'lieu_naissance' => $citoyen->getLieu_naissance(),
                    'url_copie_carte_identite' => $citoyen->getUrl_Copie_Carte_Identite(),
                ],
                'statut' => 'success affaire yi diall na bay',
                'code' => 200,
                'message' => "Le numéro de carte d'identité a été retrouvé"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'data' => null,
                'statut' => 'error lii bakhoulll wayyyy',
                'code' => 404,
                'message' => "Le numéro de carte d'identité non retrouvé"
            ]);
        }
    }


    public function findAll()
    {
        header('Content-Type: application/json');
        $citoyens = $this->citoyenService->findAll();

        if ($citoyens) {
            http_response_code(200);
            echo json_encode([
                'data' => array_map(fn($citoyen) => $citoyen->toArray(), $citoyens),
                'statut' => 'success',
                'code' => 200,
                'message' => "Liste des citoyens récupérée avec succès"
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => "Aucun citoyen trouvé"
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