<?

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Разрешен только GET.']);
    exit;
}

function connectDatabase(): PDO {
    $dsn = 'mysql:host=127.0.0.1;dbname=blog';
    $user = 'root';
    $password = '';
    try {
        return $pdo = new PDO($dsn, $user, $password);  
    } catch (PDOException $e) {
        die("Ошибка: " . $e->getMessage());
    }
}

$connection = connectDatabase();

$query = 'SELECT email 
          FROM email_table 
          WHERE id = :id';
$statement = $connection->query($query);
return $statement->fetch(PDO::FETCH_ASSOC) ?: null;