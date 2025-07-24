<?php
namespace App\service;

use App\core\App;
use App\entity\Citoyen;
use App\repository\CitoyenRepository;
class CitoyenService{
    private CitoyenRepository $citoyenRepository ;
    private static ?CitoyenService $instance=null;
    private  function __construct(){
      
      $this->citoyenRepository = App::getDependencie("citoyenrepository");
    }
    public static function getInstance(){
      if(is_null (self::$instance)){
           self::$instance=new self();

        }
        return self::$instance;
    }
        public function findByNci(string $nci): ?Citoyen
    {
        return $this->citoyenRepository->findByNci($nci);
    }



    
    public function findAll(): array
    {
        return $this->citoyenRepository->findAll();
    }
}