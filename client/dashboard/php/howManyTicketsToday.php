<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require '../../../server/php/db_connection.php';
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