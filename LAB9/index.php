<?php 

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    '/LAB9/' => 'home.php',
    '/LAB9/home' => 'home.php',
    '/LAB9/post.php' => 'post.php',
    '/LAB9/profile' => 'index.html',
    '/LAB9/create_post' => 'index.html',
    '/LAB9/api/new_post' => 'utils/new_post.php',
    '/LAB9/api/get_post' => 'utils/get_post.php',
    '/LAB9/api/edit_post' => 'utils/edit_post.php',
    '/LAB9/api/like_post' => 'utils/like_post.php'
];

if (isset($routes[$requestPath])) {
    include $routes[$requestPath];
} else {
    http_response_code(404);
    echo "Not found";
}
?>