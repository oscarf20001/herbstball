<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$basePath = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) 
    ? $_SERVER['DOCUMENT_ROOT'] . '/Metis/herbstball_25' 
    : $_SERVER['DOCUMENT_ROOT']; 

$basePath = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) 
    ? $_SERVER['DOCUMENT_ROOT'] . '/Metis/herbstball_25' 
    : $_SERVER['DOCUMENT_ROOT']; 

require $basePath . '/server/php/db_connection.php';

$result = [];

$stmt = $conn->prepare("SELECT age, COUNT(*) AS count FROM person GROUP BY age ORDER BY age ASC;");

$stmt->execute();
$stmt->bind_result($age, $anzahl);

while ($stmt->fetch()) {
    $result[] = [
        'age' => $age,
        'anzahl' => (int)$anzahl
    ];
}

$stmt->close();

// JSON-Ausgabe
echo json_encode($result, JSON_UNESCAPED_UNICODE);

$conn->close();