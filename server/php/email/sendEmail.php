<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require 'db_connection.php';

class EmpfaengerPerson {
    public ?int $id = null;
    public string $vorname;
    public string $nachname;
    public string $email;

    public function __construct(array $data) {
        $this->vorname = $data['vorname'];
        $this->nachname = $data['nachname'];
        $this->email = $data['email'];
        $this->id = getIdForMail($conn, $this->vorname, $this->nachname, $this->email);
    }
}

function getIdForMail($conn, $vorname, $nachname, $email){
    $getIdgetIdStmt = $conn->prepare("SELECT k.id FROM kaeufer k JOIN person p ON k.person_id = p.id WHERE p.vorname = ?, p.nachme = ?, p.email = ?");
    if (!$stmt) return null;
    $getIdStmt->bind_param('sss', $vorname, $nachname, $email);

    if (!$getIdStmt->execute()) {
        $getIdStmt->close();
        return null;
    }

    $getIdStmt->bind_result($kaeuferId);
    if ($getIdStmt->fetch()) {
        $getIdStmt->close();
        return $kaeuferId;
    }

    $getIdStmt->close();
    return null;

    echo json_encode([
        'status' => 'finished',
        'results' => $EmpfaengerPerson->id
    ]);
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);
$results = [];

if (!is_array($data) || count($data) < 1) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Leere oder ungültige JSON']);
    exit;
}

$empfaengerData = $data[0];
$empfaengerPerson = new EmpfaengerPerson($empfaengerData);