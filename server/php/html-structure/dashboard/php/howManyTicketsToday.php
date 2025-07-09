<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$basePath = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) 
    ? $_SERVER['DOCUMENT_ROOT'] . '/Metis/herbstball_25' 
    : $_SERVER['DOCUMENT_ROOT']; 

require $basePath . '/server/php/db_connection.php';

$result = [];
$count = 0;

$stmt = $conn->prepare("SELECT SUM(tickets) FROM kaeufer WHERE DATE(submited) = CURDATE();");
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

echo json_encode($result[] = [
    "count" => $count
]);
$stmt->close();