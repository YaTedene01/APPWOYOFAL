<?php
namespace App\core;
class Router{
    public static function resolve(array $routes): void
    {
        ob_clean(); // Nettoie tout buffer existant
        header('Content-Type: application/json');
        
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
  
        foreach ($routes as $route) {
            [$method, $pattern, $handler] = $route;

            // Convertit /api/citoyen/{nci} en regex
            $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
            $regex = "#^" . $regex . "$#";
            
            // var_dump($pattern); die();


            if ($method === $requestMethod && preg_match($regex, $requestUri, $matches)) {
                array_shift($matches); // Retire le match complet
                [$controllerClass, $controllerMethod] = $handler;
                if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                    $controller = new $controllerClass();
                    $controller->$controllerMethod(...$matches);
                    return;
                }
                // Contrôleur ou méthode non trouvée
                http_response_code(500);
                echo json_encode([
                    'data' => null,
                    'statut' => 'error',
                    'code' => 500,
                    'message' => 'Contrôleur ou méthode non trouvée'
                ]);
                return;
            }
        }

 

        // 404 si aucune route ne correspond
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'code' => 404,
            'message' => 'Endpoint non trouvé'
        ]);
    }
}