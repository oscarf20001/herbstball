<?php

require '../php/db_connection.php';
require '../../vendor/autoload.php'; // Autoloader einbinden

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$logHandle = fopen(__DIR__ . '/mail.log', 'a'); // oder anderer Pfad

$sqlGetAllMails = "SELECT email, vorname FROM k150883_fruehlingsball.käufer WHERE id > 254 LIMIT 250";
//$sqlGetAllMails = "SELECT email, vorname FROM k150883_fruehlingsball.käufer WHERE id > 250 LIMIT 250";
$stmt = $conn->prepare($sqlGetAllMails);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $allMails[] = [
        'email' => $row['email'],
        'vorname' => $row['vorname']
    ];
}

for ($i=0; $i < count($allMails); $i++) { 
    //echo $allMails[$i]['vorname'] . "<br>";

    $nachricht = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Ticketreservierung Herbstball 2025 MCG-FFR</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 24px;
            border-radius: 8px;
        }
        h1 {
            font-size: 24px;
            color: #333;
        }
        p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .cta-button {
            display: inline-block;
            margin-bottom: 24px;
            padding: 12px 24px;
            font-size: 16px;
            color: white;
            background-color: #7F63F4;
            text-decoration: none;
            border-radius: 5px;
            color: #ffffff;
        }
        .qr-section {
            text-align: center;
            margin: 32px 0;
        }
        .footer {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>Hey " . $allMails[$i]['vorname'] . ",</h1>
        <p>
            der Frühling hat getanzt – jetzt tanzt der Herbst!<br>
            Nach eurem grandiosen Feedback zum Frühlingsball freuen wir uns riesig, euch zur nächsten großen Nacht einzuladen:<br><br>

            🌸 HERBSTBALL 2025 – Marie Curie meets Friedlieb Runge 🌸 <br><br>

            Ein Abend voller Beats, Bass und bester Stimmung wartet auf euch. Seid dabei, wenn wir am 17. Oktober 2025 im Friedrich-Wolf-Haus Lehnitz den Herbst zum Leuchten bringen!<br>
        </p>
        <p>
            ✨ Das erwartet euch:<br><br>

            Ein mitreißender DJ-Sound, der euch nicht stillstehen lässt<br>
            🍹 Fancy Drinks & coole Vibes<br>
            📸 Fotowand + Deko + Mega-Fotodrucker<br>
            💫 Ein Abend, den ihr nicht vergessen werdet
        </p>
        <br>
        <p>
            🎟️ TICKETPREISE:<br>

            Wie schon immer für 12€. Aber Achtung, Gordon braucht demnächst eine Gehaltserhöhung - deswegen werden wir die Preise in rund einem Monat für alle auf 13,50€ festlegen!
        </p>
        <p>
            <a href='https://curiegymnasium.de/' class='cta-button'>
                🎟️ Tickets holen
            </a>
        </p>
        <p>
            <strong>Hier sind alle wichtigen Infos:</strong><br><br>
            📅 Datum: 17.10.2025<br>
            🕓 Uhrzeit: Einlass ab 18:45 Uhr, Beginn um 20:00 Uhr, Ende: 01:00 Uhr<br>
            📍 Adresse: Friedrich-Wolf-Straße 31, Oranienburg<br>
            🔞 Ab 16 Jahren (mit gültigem Ausweis)<br>
            👗 Come as you are – oder einfach: Look fresh, feel fab<br>
        </p>
        <p style='color:#c0392b;'>
            <strong>Die Plätze sind limitiert – first come, first dance!</strong>
        </p>

        <p>
            Wir freuen uns, euch wiederzusehen – mit alter Crew, neuen Moves und jeder Menge Glitzer im Oktober!💕<br><br>
            Beste Grüße,<br>
            euer Gordon ✨
        </p>

        <div class='footer'>
            *Alle Angaben ohne Gewähr; Änderungen vorbehalten
        </div>
        ";

        try {
            $mail = new PHPMailer(true);
            
            // SMTP-Konfiguration
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['MAIL_PORT'];
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // Absender und Empfänger
            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Marie-Curie Gymnasium');
            $mail->addReplyTo('oscar-streich@t-online.de', 'Oscar');
            $mail->addAddress($allMails[$i]['email'], $allMails[$i]['vorname']);

            // E-Mail-Inhalt
            $mail->isHTML(true);
            $mail->Body = $nachricht;
            $mail->Subject = '🎉Save the Date: HERBSTBALL 2025 – Die Nacht, die du nicht verpassen willst!🍁🌙';
            $mail->AltBody = 'Hier Tickets für den Herbstball des MCG 2025 sichern: https://www.curiegymnasium.de/';

            // E-Mail senden
            // E-Mail senden und loggen
            if ($mail->send()) {
                writeToLog($logHandle, "ERFOLG: E-Mail an {$allMails[$i]["email"]} gesendet.");
            } else {
                writeToLog($logHandle, "FEHLER: E-Mail an {$allMails[$i]["email"]} nicht gesendet. Fehler: " . $mail->ErrorInfo);
            }

            // Empfänger und Anhänge leeren
            $mail->clearAddresses();
            $mail->clearAttachments();
            sleep(1);
        } catch (Exception $e) {
            writeToLog($logHandle, "FEHLER: E-Mail an {$allMails[$i]["email"]} nicht gesendet. Fehler: {$mail->ErrorInfo}");
        }
}

function writeToLog($handleOrPath, string $message): void {
    // Aktuelles Datum/Zeit im ISO-Format
    $timestamp = date('Y-m-d H:i:s');

    // Formatierte Logzeile
    $logLine = "[{$timestamp}] {$message}\n";

    // Falls ein Datei-Handle übergeben wurde
    if (is_resource($handleOrPath)) {
        fwrite($handleOrPath, $logLine);
    } 
    // Falls ein Dateipfad übergeben wurde
    elseif (is_string($handleOrPath)) {
        file_put_contents($handleOrPath, $logLine, FILE_APPEND | LOCK_EX);
    } 
    else {
        error_log("writeToLog: Ungültiger Parameter für Log-Ziel.");
    }
}