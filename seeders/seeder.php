<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/env.php';

use Cloudinary\Cloudinary;

class DatabaseSeeder {
    private PDO $pdo;
    private Cloudinary $cloudinary;

    public function __construct()
    {
        try {
            echo "🔄 Tentative de connexion à la base de données...\n";
            echo "Host: " . DB_HOST . "\n";
            echo "Port: " . DB_PORT . "\n";
            echo "Database: " . DB_NAME . "\n";
            
            $dsn = DSN;
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo "✅ Connecté à la base de données Railway avec succès\n";
            
            // Configuration Cloudinary
            $this->cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => CLOUD_NAME,
                    'api_key'    => PUBLIC_KEY,
                    'api_secret' => PRIVATE_KEY
                ]
            ]);
        } catch (PDOException $e) {
            die("❌ Erreur de connexion: " . $e->getMessage() . "\n");
        }
    }

    public function run()
    {
        try {
            echo "Insertion de fausses données avec upload Cloudinary...\n";

            $uploadPath = __DIR__ . '/../public/images/upload/';
            $utilisateurs = [
    ['diop', 'moussa', 'Thiès', '1992-03-10', 'cni.png', '0987654329'],
    ['faye', 'aminata', 'Dakar', '1994-07-15', 'cni1.png', '1773234568'],
    ['ndiaye', 'cheikh', 'Saint-Louis', '1990-01-22', 'cni09.png', '0762877544'],
    ['sow', 'fatou', 'Kaolack', '1996-05-08', 'cni3.png', '0781345679'],
    ['fall', 'ibrahima', 'Ziguinchor', '1991-11-30', 'cni4.png', '0763496790'],
    ['diouf', 'aissatou', 'Louga', '1993-04-17', 'cni6.png', '0797567891'],
    ['ba', 'omar', 'Tambacounda', '1989-12-25', 'cni5.png', '0705608902'],
    ['gaye', 'khady', 'Mbour', '1995-09-14', 'cni7.png', '0736789013'],
    ['sy', 'alioune', 'Podor', '1992-02-05', 'cni8.png', '0747889014'],
    ['mbaye', 'adama', 'Kolda', '1997-08-19', 'cni9.png', '0721990125'],
    ['seck', 'mariama', 'Fatick', '1998-06-27', 'cni0.png', '0713088126']
];

            $stmt = $this->pdo->prepare("
                INSERT INTO citoyen (nom, prenom, lieu_naissance, date_naissance, url_copie_carte_identite, nci)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            foreach ($utilisateurs as &$user) {
                $filename = $user[4];
                $localPath = $uploadPath . $filename;

                if ($filename && file_exists($localPath)) {
                    $upload = $this->cloudinary->uploadApi()->upload($localPath, [
                        'folder' => 'appdaf/cni'
                    ]);
                    $user[4] = $upload['secure_url'];
                    echo "✅ Upload réussi : {$upload['secure_url']}\n";
                } else {
                    echo "❌ Image introuvable : $filename\n";
                    $user[4] = null;
                }

                $stmt->execute([
                    $user[0], // nom
                    $user[1], // prenom
                    $user[2], // lieu_naissance
                    $user[3], // date_naissance
                    $user[4], // url_copie_carte_identite
                    $user[5]  // nci
                ]);
            }

            echo "✅ Données insérées avec succès.\n";

        } catch (PDOException $e) {
            echo "Erreur lors du seeding : " . $e->getMessage() . "\n";
            exit(1);
        }
    }
}

$seeder = new DatabaseSeeder();
$seeder->run();
