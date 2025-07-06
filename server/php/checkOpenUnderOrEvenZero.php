<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require 'db_connection.php';
require __DIR__ . '/../../vendor/autoload.php'; // Autoloader einbinden

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$logHandle = fopen(__DIR__ . '/kosten_beglichen.log', 'a'); // oder anderer Pfad

function checkIfOpenIsZero($conn, $id, $logHandle) {
    // z. B. Update, Logik, zusätzliche Checks usw.
    $stmt = $conn->prepare("SELECT person.vorname, person.email, kaeufer.charges, kaeufer.paid_charges, kaeufer.open_charges
                            FROM kaeufer
                            JOIN person ON kaeufer.person_id = person.id
                            WHERE person_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($vorname, $email, $charges, $paid, $open);
    $stmt->fetch();
    $stmt->close();

    if ($open <= 0) {
        // Mail senden
        sendConfirmationMail($conn, $vorname, $email, $charges, $paid, $open, $logHandle);
    }
}

function sendConfirmationMail($conn, $vorname, $email, $charges, $paid, $open, $logHandle){
    $nachricht = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Ticketbestätigung Herbstball 2025 MCG-FFR</title>
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
        <h1>
            Hey " . $vorname . ",
        </h1>

        <p>
            Deine Kosten in Höhe von:<br><br>
            ". $charges . "€<br><br>
            wurden voll und ganz beglichen. Wie episch!<br>
            Wir werden dir zu einem späteren Zeitpunkt nochmal eine Mail mit deinem finalen Ticket und wichtigen Informationen schicken.<br>
            Wir haben Bock und freuen uns zusammen mit dir auf den 17.10.2025<br><br>
        </p>

        <p>
            Hier kannst du weitere Tickets bestellen:<br>
            <a href='https://curiegymnasium.de/' class='cta-button'>
                🎟️ Tickets holen
            </a>
            <br>
            <br>
            Bei Fragen oder Problemen wende dich bitte an: <code>oscar-streich@t-online.de</code>
        </p>

        <p>
            Mit freundlichen Grüßen,<br>Gordon!
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
            $mail->addAddress($email, $vorname);

            // E-Mail-Inhalt
            $mail->isHTML(true);
            $mail->Body = $nachricht;
            $mail->Subject = '🎉 Epische Ticketbestätigung: Herbstball MCG-FFR 2025 🍁🌙';
            $mail->AltBody = 'Deine Kosten wurden beglichen. Hier Tickets für den Herbstball des MCG 2025 sichern: https://www.curiegymnasium.de/';

            // E-Mail senden
            // E-Mail senden und loggen
            if ($mail->send()) {
                writeToLog($logHandle, "ERFOLG: E-Mail an {$email} gesendet.");
            } else {
                writeToLog($logHandle, "FEHLER: E-Mail an {$email} nicht gesendet. Fehler: " . $mail->ErrorInfo);
            }

            // Empfänger und Anhänge leeren
            $mail->clearAddresses();
            $mail->clearAttachments();
            sleep(1);
        } catch (Exception $e) {
            writeToLog($logHandle, "FEHLER: E-Mail an {$email} nicht gesendet. Fehler: {$mail->ErrorInfo}");
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