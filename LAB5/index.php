<?php 

$requestPath = $_SERVER['REQUEST_URI'];

$routes = [
    '/LAB5/' => 'home.php',
    '/LAB5/home' => 'home.php',
    '/LAB5/api' => 'api.php',
    '/LAB5/profile' => 'profile.html'
];

if (isset($routes[$requestPath])) {
    include $routes[$requestPath];
} else {
    http_response_code(404);
    echo "Not found";
}
?>