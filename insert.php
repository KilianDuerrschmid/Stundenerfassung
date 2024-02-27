<?php
require "inc/db-connect.php";

if (!empty($_POST)) {

    $projekt = '';
    if (isset($_POST['projekt'])) {
        $projekt = $_POST['projekt'];

    }
    $datumstart = '';
    if (isset($_POST['datumstart'])) {
        $datumstart = $_POST['datumstart'];
    }

    $datumende = '';
    if (isset($_POST['datumende'])) {
        $datumende = $_POST['datumende'];
    }

    $taetigkeiten = '';
    if (isset($_POST['taetigkeiten'])) {
        $taetigkeiten = $_POST['taetigkeiten'];
    }

    $mitarbeiter = '';
    if (isset($_POST['mitarbeiter'])) {
        $mitarbeiter = $_POST['mitarbeiter'];
    }

            $stmt = $pdo->prepare('INSERT INTO tblzeiten (fkProjekt, fkTaetigkeit, fkMitarbeiter, Start, Ende) VALUES (:projekt, :taetigkeiten, :mitarbeiter, :datumstart, :datumende)'); 
    
            $stmt->bindValue('projekt', $projekt);
            $stmt->bindValue('taetigkeiten', $taetigkeiten);
            $stmt->bindValue('mitarbeiter', $mitarbeiter);
            $stmt->bindValue('datumstart', $datumstart);
            $stmt->bindValue('datumende', $datumende);
            $stmt->execute();
      
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    ?>

