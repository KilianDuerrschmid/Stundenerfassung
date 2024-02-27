<?php
    $id = $_POST["kunde"];
    $titel = $_POST["titel"];
    $beschreibung = $_POST["beschreibung"];
    $start = $_POST["start"];
    $ende = $_POST["ende"];

    try {

        require_once('config.php');

        $sql = 'INSERT INTO arbeitszeit 
        (kundeId, titel, beschreibung, start, ende) 
        VALUES (?, ?, ?, ?, ?)';

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param(
                $stmt,
                "issss",
                $id,
                $titel,
                $beschreibung,
                $start,
                $ende
            );



            if (!mysqli_stmt_execute($stmt))
                echo "Oops! Something went wrong. Please try again later.";
        }
    } catch (PDOException $ex) {
        error_log("Write error - " . $ex . "\r\n", 3, "../logs/db-error.txt");
        exit();
    }
    exit();

