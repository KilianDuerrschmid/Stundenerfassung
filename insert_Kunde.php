<?php
require "inc/db-connect.php";

if (!empty($_POST)) {

    $name = '';
    if (isset($_POST['name'])) {
        $name = $_POST['name'];

    }
    $farbe = '';
    if (isset($_POST['farbe'])) {
        $farbe = $_POST['farbe'];
    }

    $email = '';
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    $strasse = '';
    if (isset($_POST['strasse'])) {
        $strasse = $_POST['strasse'];
    }

    $plz = '';
    if (isset($_POST['plz'])) {
        $plz = $_POST['plz'];
    }

    $ort = '';
    if (isset($_POST['ort'])) {
        $ort = $_POST['ort'];
    }
        
            $stmt = $pdo->prepare('INSERT INTO tblKunden (KundenName, Farbe, email, strasse, plz, ort) VALUES (:name, :farbe, :email, :strasse, :plz, :ort)'); 
    
            $stmt->bindValue('name', $name);
            $stmt->bindValue('farbe', $farbe);
            $stmt->bindValue('email', $email);
            $stmt->bindValue('strasse', $strasse);
            $stmt->bindValue('plz', $plz);
            $stmt->bindValue('ort', $ort);
            $stmt->execute();
      
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    ?>

