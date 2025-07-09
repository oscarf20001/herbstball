<?php

// Inkludiere das ausgelagerte Script
require('server/php/html-structure/extract_part-URL.php');

// Speichere die Ausgabe des Scripts in einer Variablen
$outputURLEnding = getOutputURLEnding();

// Mach die Variable global
$GLOBALS['outputURLEnding'] = $outputURLEnding;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herbstball des MCG 2025 - Powered by Metis</title>
    <link rel="stylesheet" href="client/styles/barStyles.css">
    <link rel="stylesheet" href="client/styles/form.css">
    <link rel="stylesheet" href="client/styles/inputFields.css">
    <script src="https://kit.fontawesome.com/b9446e8a7d.js" crossorigin="anonymous"></script>
    <script type="module" src="client/scripts/main.js"></script>
    <script type="module" src="client/scripts/finances.js"></script>
    <script type="module" src="client/scripts/dataTicket.js" defer></script>
    <script type="module" src="client/scripts/checks.js" defer></script>
    <script type="module" src="client/scripts/denied.js" defer></script>
    <!--<script src="client/scripts/analytics.js"></script>-->
    <script type="module" src="client/scripts/displayMessages.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
</head>
<body>

    <!-- div für das Displayen der Nachrichten aus js -->
    <div id="display">
        <?php
            require('server/php/html-structure/displayMessages.php');
        ?>
    </div>

    <header id="header">
        <?php
            require('server/php/html-structure/header.php');
        ?>
    </header>
    
    <div id="sidebar">
        <?php
            require('server/php/html-structure/sidebar.php');
        ?>
    </div>

    <div id="logo">
        <?php
            require('server/php/html-structure/logo.php');
        ?>
    </div>

    <div id="mainContainer">
        <form action="" method="post" id="form">

            <!-- HEADER TICKETS: AUSWAHL EINER ANZAHL DER TICKETS-->
            <div id="headerTickets">
                <label for="cntTickets">Anzahl an Tickets:</label>
                <div id="cntTickets-optionGroup">
                    <button type="button" class="ticketCountOption selectiveButton" data-value="1">1</button>
                    <button type="button" class="ticketCountOption selectiveButton active" data-value="2">2</button>
                    <button type="button" class="ticketCountOption selectiveButton" data-value="3">3</button>
                    <button type="button" class="ticketCountOption selectiveButton" data-value="4">4</button>
                    <button type="button" class="ticketCountOption selectiveButton" data-value="5">5</button>
                </div>

                <input type="hidden" name="cntTickets" id="ticketCountInput" required>

                <!--<button type="button" id="subtractTicketButton" class="button selectiveButton">
                    <i class="fa-solid fa-minus"></i>
                </button>-->
            </div>

            <!-- SAMPLE TICKET: DISPLAYING OF THE TICKETS-->
            <div id="ticketsContainer">
               <!-- 
                <div id="ticket-01" class="ticket">
                    <div class="input-field name">
                        <input type="text" id="name-01" name="nachname-01" required="">
                        <label for="name-01">Nachname:<sup>*</sup></label>
                    </div>
                    <div class="input-field vorname">
                        <input type="text" id="vorname-01" name="vorname-01" required="">
                        <label for="vorname-01">Vorname:<sup>*</sup></label>
                    </div>
                    <div class="input-field email">
                        <input type="email" id="email-01" name="email-01" required="">
                        <label for="email-01">Email-Adresse:<sup>*</sup></label>
                    </div>
                    <div class="age">
                        <label id="ageLabel-01" class="ageLabel" for="ageInput-01">Alter:<sup>*</sup></label>
                        <div id="age-optionGroup-01" class="age-optionGroup">
                            <button type="button" class="ageOption selectiveButton buttonNeedsBorder active" data-age="16">16</button>
                            <button type="button" class="ageOption selectiveButton buttonNeedsBorder" data-age="17">17</button>
                            <button type="button" class="ageOption selectiveButton buttonNeedsBorder" data-age="18+">18+</button>
                        </div>
                        <input type="hidden" name="age-01" id="ageInput-01" required="" value="16">
                    </div>
                    <div class="school">
                        <label id="schoolLabel-01" class="schoolLabel" for="schoolInput-01">Schule:<sup>*</sup></label>
                        <div id="school-optionGroup-01" class="school-optionGroup">
                            <button type="button" class="schoolOption selectiveButton buttonNeedsBorder active" data-school="MCG">MCG</button>
                            <button type="button" class="schoolOption selectiveButton buttonNeedsBorder" data-school="FFR">FFR</button>
                            <button type="button" class="schoolOption selectiveButton buttonNeedsBorder" data-school="andere">andere</button>
                        </div>
                        <input type="hidden" name="school-01" id="schoolInput-01" required="" value="MCG">
                    </div>
                </div>
            -->
            </div>

            <!-- END OF TICKET-SECTION: BUYING AND SUBMITTING OF THE TICKETS! -->
            <div id="downerTickets">
                <button type="button" id="takeReservationButton">Tickets vorbestellen</button>
                <button type="button" id="addTicketButton" class="button selectiveButton">Weiteres Ticket</button>
                <div id="shoppingCart" class="button">
                    <p id="">Gesamt: <span id="shoppingCartIndex"></span>€</p>
                </div>
            </div>
        </form>
    </div>

    <footer id="footer">
        <?php
            require('server/php/html-structure/footer.php');
        ?>
    </footer>
</body>
</html>