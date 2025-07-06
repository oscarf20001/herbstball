<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // JSON-Daten vom Body lesen
    $input = file_get_contents('php://input');

    // JSON-String in ein PHP-Array oder Objekt umwandeln
    $data = json_decode($input, true); // `true` = assoziatives Array

    // Zugriff auf die Werte
    $id = $data['ID'];
    $method = $data['Methode'];
    $geld = $data['Geld'];
    date_default_timezone_set('Europe/Berlin');
    $timestamp = date('Y-m-d H:i:s'); // Format für SQL: '2025-07-05 14:23:45'

    $stmt = $conn->prepare("UPDATE kaeufer SET paid_charges = paid_charges + ?, method = ?, d_paid = ? WHERE person_id = ?");
    $stmt->bind_param('dssi', $geld, $method, $timestamp, $id);

    $response = [
        'status' => 'fail',
    ];

    if($stmt->execute()){
        $response = [
            'status' => 'success',
        ];
    }
    $stmt->close();

    include 'checkOpenUnderOrEvenZero.php';
    $logHandle = fopen(__DIR__ . '/kosten_beglichen.log', 'a'); // oder anderer Pfad
    checkIfOpenIsZero($conn, $id, $logHandle);

    // Prüfen, ob die offene Summe gleich oder unter null ist
    $conn->close();
    echo json_encode($response);
}