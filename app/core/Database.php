<?php
namespace App\Core;

use PDO;

class Database{
    
    private static ?Database $instance= null;
    private string $host;
    private string $port;
    private string $dbname;
    private string $user;
    private string $pwd;
    private string $dsn;


    private PDO $pdo;
    private function __construct()
    {
        $this->user=DB_USER;
        $this->pwd=DB_PASSWORD;
        $this->dsn=DSN;

    }
    
    public static function getInstance(){
        if (is_null(self::$instance)){
            self::$instance=new self();
        }
        return self::$instance;
    }
   public function getConnexion() {
    
    try {
        if (!isset($this->pdo)) {
            $this->pdo = new PDO($this->dsn, $this->user, $this->pwd);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->pdo;
    } catch (\PDOException $e) {
        throw new \PDOException("Connection failed: " . $e->getMessage());
    }
   }

 }