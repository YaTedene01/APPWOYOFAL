<?php
namespace App\core;

class Router {
    public static function resolve(array $routes): void 
    {
        // Start output buffering if not already started
        if (ob_get_level() == 0) {
            ob_start();
        } else {
            // Clean any existing output
            ob_clean();
        }
        
        try {
            header('Content-Type: application/json');
            
            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestMethod = $_SERVER['REQUEST_METHOD'];
    
            foreach ($routes as $route) {
                [$method, $pattern, $handler] = $route;
    
                // Convert /api/citoyen/{nci} to regex
                $regex = preg_replace('#\{[^/]+\}#', '([^/]+)', $pattern);
                $regex = "#^" . $regex . "$#";
    
                if ($method === $requestMethod && preg_match($regex, $requestUri, $matches)) {
                    array_shift($matches);
                    [$controllerClass, $controllerMethod] = $handler;
                    
                    if (class_exists($controllerClass) && method_exists($controllerClass, $controllerMethod)) {
                        $controller = new $controllerClass();
                        $controller->$controllerMethod(...$matches);
                        ob_end_flush();
                        return;
                    }
                    
                    // Controller or method not found
                    self::sendError(500, 'Contrôleur ou méthode non trouvée');
                    return;
                }
            }
    
            // No route matched
            self::sendError(404, 'Endpoint non trouvé');
            
        } catch (\Exception $e) {
            self::sendError(500, $e->getMessage());
        }
    }

    private static function sendError(int $code, string $message): void 
    {
        http_response_code($code);
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ]);
        ob_end_flush();
    }
}