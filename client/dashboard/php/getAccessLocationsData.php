<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require '../../../server/php/db_connection.php';
$result = [];

$stmt = $conn->prepare("SELECT city, COUNT(city) AS Zugriffe
FROM analytics
GROUP BY city
ORDER BY Zugriffe DESC;");

$stmt->execute();
$stmt->bind_result($city, $anzahl);

while ($stmt->fetch()) {
    $result[] = [
        'city' => $city,
        'anzahl' => (int)$anzahl
    ];
}

$stmt->close();

// JSON-Ausgabe
echo json_encode($result, JSON_UNESCAPED_UNICODE);