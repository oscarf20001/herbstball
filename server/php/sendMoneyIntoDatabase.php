<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'fail',
        'message' => 'Kein eingeloggter User gefunden'
    ]);
    exit;
}

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

    // alten Geldbetrag holen (später für logging wichtig)
    $oldCost = $conn->prepare("SELECT paid_charges FROM kaeufer WHERE person_id = ?");
    $oldCost->bind_param('i', $id);
    $oldCost->execute();
    $oldCost->bind_result($paid_charges);
    $oldCost->fetch();
    $oldMoney = $paid_charges;
    $oldCost->close();

    $stmt = $conn->prepare("UPDATE kaeufer SET paid_charges = paid_charges + ?, method = ?, d_paid = ? WHERE person_id = ?");
    $stmt->bind_param('dssi', $geld, $method, $timestamp, $id);

    $response = [
        'status' => 'fail',
    ];

    if($stmt->execute()){
        // Logging des Payments
        if(logPayment($conn, $id, $oldMoney, $geld)){
            $response = [
                'status' => 'success'
            ];
        }else{
            echo json_encode($reponse);
        }
    }
    $stmt->close();

    include 'checkOpenUnderOrEvenZero.php';
    $logHandle = fopen(__DIR__ . '/kosten_beglichen.log', 'a'); // oder anderer Pfad
    checkIfOpenIsZero($conn, $id, $logHandle);

    // Prüfen, ob die offene Summe gleich oder unter null ist
    $conn->close();
    echo json_encode($response);
}

function logPayment($conn, $kaeufer_id, $oldMoney, $newMoney){
   $log = $conn->prepare("INSERT INTO payments (user_id, kaeufer_id, old_cost, added) VALUES (?,?,?,?)");

    if (!$log) {
        $response = [
                'status' => 'fail',
                'message' => 'Fehler beim Prepare: ' . $conn->error
        ];
        return false;
    }

    if (!$log->bind_param('iidd', $_SESSION['user_id'], $kaeufer_id, $oldMoney, $newMoney)) {
        $response = [
                'status' => 'fail',
                'message' => 'Fehler beim Bind: ' . $log->error
        ];
        return false;
    }

    if (!$log->execute()) {
        $response = [
                'status' => 'fail',
                'message' => 'Fehler beim Execute: ' . $log->error
        ];
        return false;
    }
    $log->close();
    return true;
}