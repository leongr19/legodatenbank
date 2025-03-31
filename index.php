<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/database-4941301_1280.png" type="image">
    <title>Lego Datenbank</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&family=Itim&family=Playwrite+AU+SA:wght@100..400&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

        * {
            font-family: "Itim", serif;
            /*user-select: none;*/
        }

        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            /* min-height: 100vh; */
        }

        header {
            width: 100%;
            display: flex;
            justify-content: space-around;
            align-items: center;
            user-select: none;
        }

        .menuButtonDiv {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: absolute;
            left: 10px;
            cursor: pointer;
            z-index: 1;
            flex-direction: column;
        }

        .menuButtonDiv span {
            display: block;
            background-color: black;
            margin: 5px;
            user-select: none;
            height: 35px;
            width: 2px;
        }

        .menu {
            background-color: yellow;
            width: 0;
            max-width: 250px;
            height: 100%;
            position: absolute;
            display: flex;
            justify-content: start;
            align-items: center;
            flex-direction: column;
            overflow: hidden;
            transition: width 0.5s ease-in-out;
        }

        .placeholderDiv {
            display: block;
            height: 60px;
            width: 100%;
        }

        .menuButtonDiv span {
            display: block;
            width: 35px;
            height: 5px;
            background-color: black;
            margin: 5px;
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }

        .menuButtonDiv.open .menuButton1 {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .menuButtonDiv.open .menuButton2 {
            transform: rotate(-45deg) translate(5px, -5px);
        }

        .menuButtonDiv.open .menuButton3 {
            opacity: 0;
            transform: rotate(-45deg);
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 70%;
            background-color: yellow;
            margin: auto;
            margin-top: 16px;
            flex-direction: column;
            padding: 8px;
            margin-bottom: 20px;
            flex: 1;
        }
        
        footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: yellow;
        }

        footer p {
            margin: 16px;
            margin-left: 32px;
            margin-right: 32px;
        }

        .menu a {
            color: black;
            text-decoration: none;
            padding: 8px;
            margin: 4px;
            display: flex;
            align-items: center;
            width: 90%;
            user-select: none;
        }
        
        .menu a:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .inputDiv, .submitButtonDiv {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .inputDiv input, .inputDiv select {
            margin: 8px;
            width: 250px;
            border: none;
            border-radius: 5px;
            padding: 8px;
            cursor: pointer;
        }

        .inputDiv input {
            cursor: auto;
        }
        
        .inputDiv input:focus, .inputDiv select:focus {
            outline: none;
        }

        .submitButtonDiv button {
            margin-top: 10px;
            margin: 5px;
        }

        /* Chrome, Safari, Edge, Opera */
        .inputDiv input::-webkit-outer-spin-button,
        .inputDiv input::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0;
        }

        /* Firefox */
        .inputDiv input[type=number] {
            appearance: textfield !important;
        }

        table {
            width: 70%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f2f2f2;
        }

        th, td {
            border: 1px solid black; /* Umrandung für bessere Sichtbarkeit */
            padding: 8px;
            text-align: center;
        }

        /*tr:nth-child(even) {
            background-color: #f9f9f9; /* Abwechselnde Farben für bessere Lesbarkeit 
        }*/

        table a {
            text-decoration: none;
            color: black;
            cursor: pointer;
        }
        
        .deleteButton {
            color: rgb(255, 0, 0);
            text-decoration: none;
        }
        
        .deleteButton:hover {
            color: rgba(255, 0, 0, 0.7);
            text-decoration: none;
        }

        .editButton:hover {
            color: rgba(0, 0, 0, 0.7);
        }

        .missingPartsTr a:hover {
            color: rgba(0, 0, 0, 0.7);
        }

        .missingPartsButtons {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .missingPartsButtons a {
            text-decoration: none;
            color: black;
            background-color: rgb(164, 164, 164);
            padding: 8px;
            margin: 16px;
        }

        .missingPartsButtons a:hover {
            background-color: rgb(82, 82, 82);
        }

    </style>
</head>
<body>
    <header>
        <div onclick="menu()" id="menuButtonDiv" class="menuButtonDiv">
            <span id="menuButton1" class="menuButton1"></span>
            <span id="menuButton2" class="menuButton2"></span>
            <span id="menuButton3" class="menuButton3"></span>
        </div>
        <h1>Lego Datenbank</h1>
    </header>

    <div id="menu" class="menu">
        <div class="placeholderDiv"></div>
        <a href="index.php?page=start">Start</a>
        <a href="index.php?page=addSet">Set&nbsp;hinzufügen</a>
        <a href="index.php?page=sets">Sets</a>
    </div>
    <main>
        <?php
            $headline = 'Herzlich Willkommen';
            $dbname = 'legodatabase';
            $username = 'root';
            $password = '1902';
            $server = 'mysql:host=localhost;dbname=' . $dbname . '';

            try {
                $connection = new PDO($server, $username, $password);

                $sqlTabelleErstellen = '
                CREATE TABLE IF NOT EXISTS sets(
                
                    id_sets INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    setnumber INT NOT NULL,
                    themeworld VARCHAR(225) NOT NULL,
                    kathegory VARCHAR(225) NOT NULL, 
                    buildingStatus VARCHAR(255) NOT NULL,
                    completeness VARCHAR(255) NOT NULL,
                    set_description VARCHAR(255)
                );
                ';

                $sqlTabelleFehlendeTeileErstellen = '
                CREATE TABLE IF NOT EXISTS missingparts (
                    id_parts INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    id_sets INT NOT NULL,
                    teilnummer INT NOT NULL,
                    farbe VARCHAR(50) NOT NULL,
                    kategorie VARCHAR(255) NOT NULL,
                    anzahl INT NOT NULL,
                    missingParts_description VARCHAR(255)
                );
                ';

                $tabelleErstellen = $connection->prepare($sqlTabelleErstellen);
                $sqlTabelleFehlendeTeileErstellen = $connection->prepare($sqlTabelleFehlendeTeileErstellen);
                $tabelleErstellen->execute();
                $sqlTabelleFehlendeTeileErstellen->execute();

            }
            catch (PDOException $fehler) {
                print $fehler->getMessage();
            }

            if(isset($_GET['page'])) {
                if($_GET['page'] == 'sets') {
                    $headline = 'Sets';
                } elseif ($_GET['page'] == 'addSet') {
                    $headline = 'Set Hinzufügen';
                } elseif ($_GET['page'] == 'setAdded') {
                    $headline = 'Set Hinzugefügt';
                } elseif ($_GET['page'] == 'delete') {
                    $headline = 'Löschvorgang';
                } elseif ($_GET['page'] == 'edit') {
                    $headline = 'Bearbeiten';
                } elseif ($_GET['page'] == 'description') {
                    $headline = 'Beschreibung';
                } elseif ($_GET['page'] == 'missingParts') {
                    $headline = 'Fehlende Teile';
                } elseif ($_GET['page'] == 'missingPartsAdd') {
                    $headline = 'Fehlende Teile Hinzufügen';
                } elseif ($_GET['page'] == 'missingPartsShow') {
                    $headline = 'Fehlende Teile Anzeigen';
                } else if ($_GET['page'] == 'partsDescription') {
                    $headline = 'Beschreibung der Fehlenden Teile';
                } else if ($_GET['page'] == 'editMissingParts') {
                    $headline = 'Bearbeiten';
                }
                
            }

            echo '<h2>' . $headline . '</h2>';

            if(isset($_GET['page']) && $_GET['page'] == 'sets') {
                $sqlCommandShowTable = 'SELECT * FROM sets;';
                $query = $connection->prepare($sqlCommandShowTable);
                $query->execute();
                $output = $query->fetchAll();

                echo "<table>";
                echo "<thead> <tr> <td>Setnummer</td> <td>Themenwelt</td> <td>Kategorie</td> <td>Status</td> <td>Vollständigkeit</td> </tr> </thead>";

                foreach ($output as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['setnumber'] . "</td>";
                    echo "<td>" . $row['themeworld'] . "</td>";
                    echo "<td>" . $row['kathegory'] . "</td>";
                    echo "<td>" . $row['buildingStatus'] . "</td>";
                    echo "<td>" . $row['completeness'] . "</td>";
                    echo "<td><a class='editButton' href='index.php?page=description&id_sets=" . $row['id_sets'] . "'>Beschreibung</a></td>";
                    echo "<td><a class='deleteButton' href='index.php?page=delete&id_sets=" . $row['id_sets'] . "'>Löschen</a></td>";
                    echo "<td><a class='editButton' href='index.php?page=edit&id_sets=" . $row['id_sets'] . "'>Bearbeiten</a></td>";
                    echo "</tr>"; // Hier das schließende </tr> richtig setzen
                
                    $id_sets = $row['id_sets'];
                    $sqlCommandAnzahlDerFahlendenTeile = $connection->prepare("SELECT COUNT(id_sets) as anzahl FROM missingparts WHERE id_sets= :id_sets");
                    $sqlCommandAnzahlDerFahlendenTeile->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);

                    try {
                        $sqlCommandAnzahlDerFahlendenTeile->execute();
                        $number = $sqlCommandAnzahlDerFahlendenTeile->fetch();
                    } catch (PDOExeption $e) {
                        echo "Fehler";
                    }

                    // Zusätzliche Zeile für "Fehlende Teile", aber ohne rowspan, da es eine eigene Zeile ist
                    echo "<tr class='missingPartsTr'><td colspan='5'><a href='index.php?page=missingParts&id_sets=" . $row['id_sets'] . "'>Fehlende Teile anzeigen</a><br>Anzahl: <span> " . $number['anzahl'] . "</span></td></tr>";
                }
                

                    //" . $row['set_description'] . "

                echo "</table>";

            } elseif (isset($_GET['page']) && $_GET['page'] == 'addSet') {
                echo '<p>Set hinzufügen:</p>';

                echo '
                <form action="index.php?page=addSet" method="post">
                    <div class="inputDiv">
                        <input type="number" placeholder="Setnummer" name="setnumber">
                        <select name="themeworld">
                            <option value="" disabled selected>Themenwelt auswählen</option>
                            <option value="City">City</option>
                            <option value="Creator">Creator</option>
                            <option value="Technik">Technik</option>
                        </select>

                        <select name="kathegory">
                            <option value="" disabled selected>Kategorie auswählen</option>
                            <option value="Feuerwehr">Feuerwehr</option>
                            <option value="Polizei">Polizei</option>
                            <option value="Baustelle">Baustelle</option>
                            <option value="Auto">Auto</option>
                            <option value="Stadt">Stadt</option>
                            <option value="Anderes">Anderes</option>
                        </select>

                        <select name="buildingStatus">
                            <option value="" disabled selected>Status auswählen</option>
                            <option value="Zusammengebaut">Zusammengebaut</option>
                            <option value="Zusammengesucht">Zusammengesucht</option>
                            <option value="Aufgebaut">Aufgebaut</option>
                        </select>

                        <select name="completeness">
                            <option value="" disabled selected>Vollständigkeit auswählen</option>
                            <option value="Unvollständig">Unvollständig</option>
                            <option value="Vollständig">Vollständig</option>
                        </select>

                        <textarea name="set_description" id="" maxlength="255" placeholder="Beschreibung" rows="6" cols="42"></textarea>

                    </div>

                    <div class="submitButtonDiv">
                        <button name="submit">Set Hinzufügen</button>
                    </div>
                    
                </form>
                ';

                if($_SERVER["REQUEST_METHOD"] == 'POST') {
                    if(isset($_POST['setnumber'], $_POST['themeworld'], $_POST['kathegory'], $_POST['buildingStatus'], $_POST['completeness'])) {
                        $setnumber = $_POST['setnumber'];
                        $themeworld = $_POST['themeworld'];
                        $kathegory = $_POST['kathegory'];
                        $buildingStatus = $_POST['buildingStatus'];
                        $completeness = $_POST['completeness'];
                        $set_description = $_POST['set_description'];

                        $sqlCommand = "INSERT INTO `legodatabase` . `sets` (`setnumber`, `themeworld`, `kathegory`, `buildingStatus`, `completeness`, `set_description`) VALUES ('$setnumber', '$themeworld', '$kathegory', '$buildingStatus', '$completeness', '$set_description');";

                        $queryInput = $connection->prepare($sqlCommand);
                        $queryInput->execute();

                        echo "<script>window.location.href='index.php?page=sets';</script>";
                        exit();

                    } else {
                        echo '<p>Du hast nicht alle Angaben gemacht</p>';
                    }
                }

            } elseif (isset($_GET['page']) && $_GET['page'] == 'delete') {
                echo "<p>Löschen</p>";

                if (isset($_GET['id_sets'])) {
                    $id_sets = intval($_GET['id_sets']);  // Sicherheitsmaßnahme gegen SQL-Injection
                
                    // Prepared Statement für sicheres Löschen
                    $stmt = $connection->prepare("DELETE FROM sets WHERE id_sets = :id_sets");
                    $stmt->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);
                    
                    if ($stmt->execute()) {
                        echo "Datensatz wurde erfolgreich gelöscht.";
                    } else {
                        echo "Fehler beim Löschen: " . $stmt->errorInfo()[2];
                    }

                    $stmt2 = $connection->prepare("DELETE FROM missingparts WHERE id_sets = :id_sets");
                    $stmt2->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);

                    if ($stmt2->execute()) {
                        echo "Daten erfolgreich gelöscht";
                    } else {
                        echo "Fehler beim Löschen" . $stmt2->errorInfo()[2];
                    }
                }
        
                
                echo "<script>window.location.href='index.php?page=sets';</script>";
                exit();                

            } elseif (isset($_GET['page']) && $_GET['page'] == 'edit') {
                echo '<p>Bearbeiten</p>';

                if (isset($_GET['id_sets'])) {
                    $id_sets = intval($_GET['id_sets']);

                    $sqlCommandEdit = $connection->prepare("SELECT * FROM sets WHERE id_sets = :id_sets");
                    $sqlCommandEdit->bindparam(":id_sets", $id_sets, PDO::PARAM_INT);
                    $sqlCommandEdit->execute();
                    $set = $sqlCommandEdit->fetch(PDO::FETCH_ASSOC);

                    if ($set) {
                        echo '
                        <form action="index.php?page=edit&id_sets=' . $id_sets . '" method="post">
                            <div class="inputDiv">
                                <input type="number" name="setnumber" value="' . htmlspecialchars($set['setnumber']) . '" required>
                                <select name="themeworld">
                                    <option value="City" ' . ($set['themeworld'] == "City" ? "selected" : "") . '>City</option>
                                    <option value="Creator" ' . ($set['themeworld'] == "Creator" ? "selected" : "") . '>Creator</option>
                                    <option value="Technik" ' . ($set['themeworld'] == "Technik" ? "selected" : "") . '>Technik</option>
                                </select>

                                <select name="kathegory">
                                    <option value="Feuerwehr" ' . ($set['kathegory'] == "Feuerwehr" ? "selected" : "") . '>Feuerwehr</option>
                                    <option value="Polizei" ' . ($set['kathegory'] == "Polizei" ? "selected" : "") . '>Polizei</option>
                                    <option value="Baustelle" ' . ($set['kathegory'] == "Baustelle" ? "selected" : "") . '>Baustelle</option>
                                    <option value="Auto" ' . ($set['kathegory'] == "Auto" ? "selected" : "") . '>Auto</option>
                                    <option value="Stadt" ' . ($set['kathegory'] == "Stadt" ? "selected" : "") . '>Stadt</option>
                                    <option value="Anderes" ' . ($set['kathegory'] == "Anderes" ? "selected" : "") . '>Anderes</option>
                                </select>

                                <select name="buildingStatus">
                                    <option value="Zusammengebaut" ' . ($set['buildingStatus'] == "Zusammengebaut" ? "selected" : "") . '>Zusammengebaut</option>
                                    <option value="Zusammengesucht" ' . ($set['buildingStatus'] == "Zusammengesucht" ? "selected" : "") . '>Zusammengesucht</option>
                                    <option value="Aufgebaut" ' . ($set['buildingStatus'] == "Aufgebaut" ? "selected" : "") . '>Aufgebaut</option>
                                </select>

                                <select name="completeness">
                                    <option value="Unvollständig" ' . ($set['completeness'] == "Unvollständig" ? "selected" : "") . '>Unvollständig</option>
                                    <option value="Vollständig" ' . ($set['completeness'] == "Vollständig" ? "selected" : "") . '>Vollständig</option>
                                </select>

                                <textarea name="set_description" maxlength="255" rows="6" cols="42">' . htmlspecialchars($set['set_description']) . '</textarea>
                            </div>

                            <div class="submitButtonDiv">
                                <button name="submit">Änderungen speichern</button>
                            </div>
                        </form>
                        ';
                    } else {
                        echo '<p>Set nicht gefunden.</p>';
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['setnumber'], $_POST['themeworld'], $_POST['kathegory'], $_POST['buildingStatus'], $_POST['completeness'])) {
                        $setnumber = $_POST['setnumber'];
                        $themeworld = $_POST['themeworld'];
                        $kathegory = $_POST['kathegory'];
                        $buildingStatus = $_POST['buildingStatus'];
                        $completeness = $_POST['completeness'];
                        $set_description = $_POST['set_description'];
                
                        $sqlUpdate = "UPDATE sets SET 
                            setnumber = :setnumber,
                            themeworld = :themeworld,
                            kathegory = :kathegory,
                            buildingStatus = :buildingStatus,
                            completeness = :completeness,
                            set_description = :set_description
                            WHERE id_sets = :id_sets";
                
                        $stmt = $connection->prepare($sqlUpdate);
                        $stmt->bindParam(":setnumber", $setnumber, PDO::PARAM_INT);
                        $stmt->bindParam(":themeworld", $themeworld, PDO::PARAM_STR);
                        $stmt->bindParam(":kathegory", $kathegory, PDO::PARAM_STR);
                        $stmt->bindParam(":buildingStatus", $buildingStatus, PDO::PARAM_STR);
                        $stmt->bindParam(":completeness", $completeness, PDO::PARAM_STR);
                        $stmt->bindParam(":set_description", $set_description, PDO::PARAM_STR);
                        $stmt->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);
                
                        if ($stmt->execute()) {
                            echo "<script>window.location.href='index.php?page=sets';</script>";
                            exit();
                        } else {
                            echo '<p>Fehler beim Aktualisieren!</p>';
                        }
                    }

                }

                
                
            } elseif (isset($_GET['page']) && $_GET['page'] == 'description') {
                echo "<p>Beschreibung</p>";

                if (isset($_GET['id_sets'])) {
                    $id_sets = intval($_GET['id_sets']);

                    $sqlCommandSelectDescription = $connection->prepare("SELECT set_description FROM sets WHERE id_sets = :id_sets");
                    $sqlCommandSelectDescription->bindparam(":id_sets", $id_sets, PDO::PARAM_INT);
                    $sqlCommandSelectDescription->execute();
                    $descriptionOutput = $sqlCommandSelectDescription->fetch(PDO::FETCH_ASSOC);

                    if($descriptionOutput) {
                        echo "<p>" .htmlspecialchars($descriptionOutput['set_description']) . "</p>";
                    }
                }

                //SELECT set_description FROM sets WHERE id_sets = ''
            } elseif (isset($_GET['page']) && $_GET['page'] == 'missingPartsShow') {
                echo "<p>Fehlende Teile</p>";

                if (isset($_GET['id_sets'])) {
                    $id_sets = intval($_GET['id_sets']);

                    $sqlCommandSchowMissingPars = $connection->prepare("SELECT * FROM `missingparts` WHERE id_sets = :id_sets");
                    $sqlCommandSchowMissingPars->bindparam(":id_sets", $id_sets, PDO::PARAM_INT);
                    $sqlCommandSchowMissingPars->execute();
                    $missing = $sqlCommandSchowMissingPars->fetchAll();

                    echo "<table>";
                    echo "<thead> <tr> <td>Teilnummer</td> <td>Farbe</td> <td>Kategorie</td> <td>Anzahl</td> </tr> </thead>";

                    foreach($missing as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['teilnummer'] . "</td>";
                        echo "<td>" . $row['farbe'] . "</td>";
                        echo "<td>" . $row['kategorie'] . "</td>";
                        echo "<td>" . $row['anzahl'] . "</td>";
                        echo "<td><a class='editButton' href='index.php?page=partsDescription&id_parts=" . $row['id_parts'] . "'>Beschreibung</a></td>"; // beschreibung Überarbeiten 26.03.2025
                        echo "<td><a class='deleteButton' href='index.php?page=deleteParts&id_parts=" . $row['id_parts'] . "&id_sets=" . $id_sets ."'>Löschen</a></td>";
                        echo "<td><a class='editButton' href='index.php?page=editMissingParts&id_parts=" . $row['id_parts'] . "&id_sets=" . $id_sets . "'>Bearbeiten</a></td>";
                        echo "</tr>";
                    }

                    echo "</table>";

                }
            } elseif (isset($_GET['page']) && $_GET['page'] == 'missingParts') {
                echo "<p>Fehlende Teile</p>";

                if (isset($_GET['id_sets'])) {
                    echo "
                        <div class='missingPartsButtons'>
                            <a href='index.php?page=missingPartsAdd&id_sets=" . $_GET['id_sets'] . "'>Hinzufügen</a>
                            <a href='index.php?page=missingPartsShow&id_sets=" . $_GET['id_sets'] . "'>Anzeigen</a>
                        </div>
                    ";
                }

                
            } elseif (isset($_GET['page']) && $_GET['page'] == 'missingPartsAdd') {
                echo "<p>Fehlende Teile</p>";

                echo '
                    <form action="index.php?page=missingPartsAdd&id_sets=' . $_GET['id_sets'] . '" method="post">
                        <div class="inputDiv">
                            <input type="number" placeholder="Teilnummer" name="teilnummer">
                            <input type="text" placeholder="Farbe" name="farbe">

                            <select name="kategorie">
                                <option value="" disabled selected>Wähle die Kategorie</option>
                                <option value="Platten">Platten</option>
                                <option value="Steine">Steine</option>
                                <option value="Fliesen">Fliesen</option>
                                <option value="Scharniere">Scharniere</option>
                                <option value="Achsen">Achsen</option>
                                <option value="Kupplungen">Kupplungen</option>
                                <option value="Zahnräder">Zahnräder</option>
                                <option value="Motoren/Elektronik">Motoren/Elektronik</option>
                                <option value="Minifiguren">Minifiguren</option>
                                <option value="Werkzeuge">Werkzeuge</option>
                                <option value="Tiere">Tiere</option>
                                <option value="Pflanzen">Pflanzen</option>
                                <option value="Fenster/Türen">Fenster/Türen</option>
                                <option value="Räder/Ketten">Räder/Ketten</option>
                                <option value="Aufkleber/Bedruckte Steine">Aufkleber/Bedruckte Steine</option>
                                <option value="Andere">Andere</option>
                                <option value="Weiß ich nicht">Weiß ich nicht</option>
                            </select>

                            <input type="number" placeholder="Anzahl" name="anzahl">

                            <textarea name="missingParts_description" id="" maxlength="255" placeholder="Beschreibung" rows="6" cols="42"></textarea>

                        </div>

                        <div class="submitButtonDiv">
                            <button name=submit>Fehlendes Teil Hinzufügen</button>
                        </div>

                    </form>
                ';

                if (!isset($_GET['id_sets'])) {
                    die("Fehlende ID des Sets!");
                }
                $id_sets = intval($_GET['id_sets']);

                if($_SERVER["REQUEST_METHOD"] == 'POST') {
                    if(isset($_POST['teilnummer'], $_POST['farbe'], $_POST['kategorie'], $_POST['anzahl'])) {
                        $teilnummer = intval($_POST['teilnummer']);
                        $farbe = htmlspecialchars($_POST['farbe']);
                        $kategorie = htmlspecialchars($_POST['kategorie']);
                        $anzahl = intval($_POST['anzahl']);
                        $missingParts_description = $_POST['missingParts_description'];


                        if ($teilnummer <= 0 || $anzahl <= 0 || empty($farbe) || empty($kategorie)) {
                            echo '<p>Ungültige Eingaben. Bitte überprüfen Sie die Daten.</p>';
                        } else {

                        
                        $sqlCommandInsertInTableMissingParts = "
                            INSERT INTO `legodatabase`.`missingparts` 
                            (`id_sets`, `teilnummer`, `farbe`, `kategorie`, `anzahl`, `missingParts_description`) 
                            VALUES (:id_sets, :teilnummer, :farbe, :kategorie, :anzahl, :missingParts_description);
                        ";

                        try {
                            $stmt = $connection->prepare($sqlCommandInsertInTableMissingParts);
                            $stmt->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);
                            $stmt->bindParam(":teilnummer", $teilnummer, PDO::PARAM_INT);
                            $stmt->bindParam(":farbe", $farbe, PDO::PARAM_STR);
                            $stmt->bindParam(":kategorie", $kategorie, PDO::PARAM_STR);
                            $stmt->bindParam(":anzahl", $anzahl, PDO::PARAM_INT);
                            $stmt->bindParam(":missingParts_description", $missingParts_description, PDO::PARAM_STR);

                            if ($stmt->execute()) {
                                echo "<script>window.location.href='index.php?page=missingParts&id_sets=" . $id_sets . "';</script>";
                                exit();
                            } else {
                                echo '<p>Fehler beim Hinzufügen des fehlenden Teils.</p>';
                            }
                        } catch (PDOException $e) {
                            echo '<p>Datenbankfehler: ' . $e->getMessage() . '</p>';
                        }

                    }
                        
                        

                        echo "<script>window.location.href='index.php?page=missingPartsShow&id_sets=" . $id_sets . "';</script>";
                    } else {
                        echo '<p>Du hast nicht alle Angaben gemacht</p>';
                    }
                }


            } elseif (isset($_GET['page']) && $_GET['page'] == 'deleteParts') { //löschen überarbeiten
                echo "<p>Löschen</p>";

                if (isset($_GET['id_parts']) && isset($_GET['id_sets'])) {
                    $id_parts = intval($_GET['id_parts']);
                    $id_sets = intval($_GET['id_sets']);

                    $sqlCommandDeleteMissingParts = $connection->prepare("DELETE FROM missingparts WHERE id_parts = :id_parts");
                    $sqlCommandDeleteMissingParts->bindParam(":id_parts", $id_parts, PDO::PARAM_INT);

                    if ($sqlCommandDeleteMissingParts->execute()) {
                        echo "Datensatz wurde erfolgreich gelöscht.";
                    } else {
                        echo "Fehler beim Löschen: " . $sqlCommandDeleteMissingParts->errorInfo()[2];
                    }
                }

                echo "<script>window.location.href='index.php?page=missingPartsShow&id_sets=" . $id_sets . "';</script>";
                exit();
            } else if (isset($_GET['page']) && $_GET['page'] == 'partsDescription') {
                echo "<p>Beschreibung</p>";

                if (isset($_GET['id_parts'])) {
                    $id_parts = intval($_GET['id_parts']);

                    $sqlCommandSelectPartDescription = $connection->prepare("SELECT missingParts_description FROM missingparts WHERE id_parts = :id_parts");
                    $sqlCommandSelectPartDescription->bindparam(":id_parts", $id_parts, PDO::PARAM_INT);
                    $sqlCommandSelectPartDescription->execute();
                    $partDescriptionOutput = $sqlCommandSelectPartDescription->fetch(PDO::FETCH_ASSOC);

                    if (!empty($partDescriptionOutput['missingParts_description'])) {
                        echo "<p>" . htmlspecialchars($partDescriptionOutput['missingParts_description']) . "</p>";
                    } else {
                        echo "<p>Dazu gibt es keine Beschreibung</p>";
                    }
                }

                //Beschreibung mit SQL Statement aufrufen
            } else if (isset($_GET['page']) && $_GET['page'] == 'editMissingParts') {
                echo "<p>Bearbeiten</p>";

                if(isset($_GET['id_sets'])) {
                    $id_sets = intval($_GET['id_sets']);
                } else {
                    echo "keine ID";
                }

                if (isset($_GET['id_parts'])) {
                    $id_parts = intval($_GET['id_parts']);

                    $sqlCommandEditMissingParts = $connection->prepare("SELECT * FROM missingparts WHERE id_parts = :id_parts");
                    $sqlCommandEditMissingParts->bindparam(":id_parts", $id_parts, PDO::PARAM_INT);
                    $sqlCommandEditMissingParts->execute();
                    $parts = $sqlCommandEditMissingParts->fetch(PDO::FETCH_ASSOC);

                    if ($parts) {
                        //index.php?page=missingPartsAdd&id_sets=' . $_GET['id_sets'] . '
                        echo '
                            <form action="index.php?page=editMissingParts&id_parts=' . $id_parts . '&id_sets=' . $id_sets . '" method="post"> 
                                <div class="inputDiv">
                                    <input type="number" placeholder="Teilnummer" name="teilnummer" value="' . htmlspecialchars($parts['teilnummer']) . '">
                                    <input type="text" placeholder="Farbe" name="farbe" value="' . htmlspecialchars($parts['farbe']) . '">

                                    <select name="kategorie">
                                        <option value="" disabled selected>Wähle die Kategorie</option>
                                        <option value="Platten" ' . ($parts['kategorie'] == "Platten" ? "selected" : "") . '>Platten</option>
                                        <option value="Steine" ' . ($parts['kategorie'] == "Steine" ? "selected" : "") . '>Steine</option>
                                        <option value="Fliesen" ' . ($parts['kategorie'] == "Fliesen" ? "selected" : "") . '>Fliesen</option>
                                        <option value="Scharniere" ' . ($parts['kategorie'] == "Scharniere" ? "selected" : "") . '>Scharniere</option>
                                        <option value="Achsen" ' . ($parts['kategorie'] == "Achsen" ? "selected" : "") . '>Achsen</option>
                                        <option value="Kupplungen" ' . ($parts['kategorie'] == "Kupplungen" ? "selected" : "") . '>Kupplungen</option>
                                        <option value="Zahnräder" ' . ($parts['kategorie'] == "Zahnräder" ? "selected" : "") . '>Zahnräder</option>
                                        <option value="Motoren/Elektronik" ' . ($parts['kategorie'] == "Motoren/Elektronik" ? "selected" : "") . '>Motoren/Elektronik</option>
                                        <option value="Minifiguren" ' . ($parts['kategorie'] == "Minifiguren" ? "selected" : "") . '>Minifiguren</option>
                                        <option value="Werkzeuge" ' . ($parts['kategorie'] == "Werkzeuge" ? "selected" : "") . '>Werkzeuge</option>
                                        <option value="Tiere" ' . ($parts['kategorie'] == "Tiere" ? "selected" : "") . '>Tiere</option>
                                        <option value="Pflanzen" ' . ($parts['kategorie'] == "Pflanzen" ? "selected" : "") . '>Pflanzen</option>
                                        <option value="Fenster/Türen" ' . ($parts['kategorie'] == "Fenster/Türen" ? "selected" : "") . '>Fenster/Türen</option>
                                        <option value="Räder/Ketten" ' . ($parts['kategorie'] == "Räder/Ketten" ? "selected" : "") . '>Räder/Ketten</option>
                                        <option value="Aufkleber/Bedruckte Steine" ' . ($parts['kategorie'] == "Aufkleber/Bedruckte Steine" ? "selected" : "") . '>Aufkleber/Bedruckte Steine</option>
                                        <option value="Andere" ' . ($parts['kategorie'] == "Andere" ? "selected" : "") . '>Andere</option>
                                        <option value="Weiß ich nicht" ' . ($parts['kategorie'] == "Weiß ich nicht" ? "selected" : "") . '>Weiß ich nicht</option>
                                    </select>

                                    <input type="number" placeholder="Anzahl" name="anzahl" value="' . htmlspecialchars($parts['anzahl']) . '">

                                    <textarea name="missingParts_description" id="" maxlength="255" placeholder="Beschreibung" rows="6" cols="42">' . htmlspecialchars($parts['missingParts_description']) . '</textarea>

                                </div>

                                <div class="submitButtonDiv">
                                    <button name=submit>Aktualliesieren</button>
                                </div>

                            </form>
                        ';

                        
                    } else {
                        echo "<p>Set nicht gefunden</p>";
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['teilnummer'], $_POST['farbe'], $_POST['kategorie'], $_POST['anzahl'])) {
                        $teilnummer = $_POST['teilnummer'];
                        $farbe = $_POST['farbe'];
                        $kategorie = $_POST['kategorie'];
                        $anzahl = $_POST['anzahl'];
                        $missingParts_description = $_POST['missingParts_description'];

                        $sqlUpdateMissingParts = "UPDATE `legodatabase`.`missingparts` SET
                            teilnummer = :teilnummer,
                            farbe = :farbe,
                            kategorie = :kategorie,
                            anzahl = :anzahl,
                            missingParts_description = :missingParts_description
                            WHERE id_parts = :id_parts";


                        $sqlCommandUpdateMissingParts = $connection->prepare($sqlUpdateMissingParts);
                        //$sqlCommandUpdateMissingParts->bindParam(":id_sets", $id_sets, PDO::PARAM_INT);
                        $sqlCommandUpdateMissingParts->bindParam(":id_parts", $id_parts, PDO::PARAM_INT);
                        $sqlCommandUpdateMissingParts->bindParam(":teilnummer", $teilnummer, PDO::PARAM_INT);
                        $sqlCommandUpdateMissingParts->bindParam(":farbe", $farbe, PDO::PARAM_STR);
                        $sqlCommandUpdateMissingParts->bindParam(":kategorie", $kategorie, PDO::PARAM_STR);
                        $sqlCommandUpdateMissingParts->bindParam(":anzahl", $anzahl, PDO::PARAM_INT);
                        $sqlCommandUpdateMissingParts->bindParam(":missingParts_description", $missingParts_description, PDO::PARAM_STR);

                        if ($sqlCommandUpdateMissingParts->execute()) {
                            if (isset($id_sets)) {
                                echo "<script>window.location.href='index.php?page=missingPartsShow&id_sets=" . $id_sets . "';</script>";
                            } else {
                                echo "<p>Fehler: ID fehlt!</p>";
                            }
                            
                            //echo "Weiterleitung zu: index.php?page=missingPartsShow&id_sets=" . $id_sets;
                            // echo "<script>window.location.href='index.php?page=missingParts&id_sets=" . $_GET['id_sets'] . "';</script>";
                            //exit();
                        } else {
                            echo "<p>Fehler beim Aktualisieren!</p>";
                        }
                    }
                    //id_sets in die URL übergeben fertig machen 27.03.2025
                }
            }

            // wenn man ein Set löscht soll sich auch die Fehlenden Teile Löschen
        ?>

    </main>

    <footer>
        <p>Developed by:<br>leon_gr19<p>
        <p>(c) 2025<p>
    </footer>
    
</body>
<script>
    function menu() {
        const menu = document.getElementById('menu');
        const menuButtonDiv = document.getElementById('menuButtonDiv');

        if (menu.style.width === "200px") {
            // Menü schließen
            menu.style.width = "0";
            menuButtonDiv.classList.remove("open");
        } else {
            // Menü öffnen
            menu.style.width = "200px";
            menuButtonDiv.classList.add("open");
        }
    }


</script>
</html>