<?php require "inc/db-connect.php"; ?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbeitszeitaufzeichnung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    $stmt_kunden = $pdo->prepare("SELECT * FROM tblKunden");
    $stmt_kunden->execute();
    $kunden = $stmt_kunden->fetchAll(PDO::FETCH_ASSOC);

    $stmt_projekt = $pdo->prepare("SELECT * FROM tblProjekt");
    $stmt_projekt->execute();
    $projekte = $stmt_projekt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_taetigkeiten = $pdo->prepare("SELECT * FROM tbltaetigkeit");
    $stmt_taetigkeiten->execute();
    $taetigkeiten = $stmt_taetigkeiten->fetchAll(PDO::FETCH_ASSOC);

    $stmt_mitarbeiter = $pdo->prepare("SELECT * FROM tblmitarbeiter");
    $stmt_mitarbeiter->execute();
    $mitarbeiter = $stmt_mitarbeiter->fetchAll(PDO::FETCH_ASSOC);
    ?>


    <!-- Filter -->

    <div class="container mt-3">
        <form action="" method="POST" class="mb-5">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="mitarbeiterFilter" class="form-label">Mitarbeiter</label>
                    <select class="form-select" id="mitarbeiterFilter" name="mitarbeiterFilter">
                        <option value="">Alle</option>
                        <?php foreach ($mitarbeiter as $ma) : ?>
                            <option value="<?php echo $ma['MitarbeiterID']; ?>"><?php echo $ma['MitarbeiterName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="projektFilter" class="form-label">Projekt</label>
                    <select class="form-select" id="projektFilter" name="projektFilter">
                        <option value="">Alle</option>
                        <?php foreach ($projekte as $projekt) : ?>
                            <option value="<?php echo $projekt['ProjektID']; ?>"><?php echo $projekt['titel']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="kundeFilter" class="form-label">Kunde</label>
                    <select class="form-select" id="kundeFilter" name="kundeFilter">
                        <option value="">Alle</option>
                        <?php foreach ($kunden as $kunde) : ?>
                            <option value="<?php echo $kunde['KundenID']; ?>"><?php echo $kunde['KundenName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="startDatum" class="form-label">Startdatum</label>
                    <input type="date" class="form-control" id="startDatum" name="startDatum">
                </div>
                <div class="col-md-4">
                    <label for="endeDatum" class="form-label">Enddatum</label>
                    <input type="date" class="form-control" id="endeDatum" name="endeDatum">
                </div>
            </div>
        </form>
    </div>



    <div class="container mt-5" id="cards">
        <!-- Cards -->
    </div>

    <div class="container mt-5">
        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#beispielModal">
            Eintrag hinzufügen
        </button>

        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#kundeModal">
            Kunde hinzufügen
        </button>


        <button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#mitarbeiterModal">
            Mitarbeiter hinzufügen
        </button>


        <div class="container mt-5">
            <ul id="totalHours" class="list-group"></ul>
        </div>
    </div>


    <!-- Modal Zeiten -->
    <div class="modal fade" id="beispielModal" tabindex="-1" aria-labelledby="beispielModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="beispielModalLabel">Neuen Eintrag hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="insert.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="projekt" class="form-label">Projekt</label>
                            <select class="form-select" id="projekt" name="projekt">
                                <?php foreach ($projekte as $projekt) : ?>
                                    <option value="<?php echo $projekt['ProjektID']; ?>"><?php echo $projekt['titel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="datumstart">Start Datum/Zeit</label>
                            <input type="datetime-local" class="form-control" id="datumstart" name="datumstart" required>
                        </div>
                        <div class="form-group">
                            <label for="datumende">Ende Datum/Zeit</label>
                            <input type="datetime-local" class="form-control" id="datumende" name="datumende" required>
                        </div>
                        <div class="mb-3">
                            <label for="taetigkeiten" class="form-label">Tätigkeit</label>
                            <select class="form-select" id="taetigkeiten" name="taetigkeiten">
                                <?php foreach ($taetigkeiten as $taetigkeit) : ?>
                                    <option value="<?php echo $taetigkeit['TaetigkeitID']; ?>"><?php echo $taetigkeit['Taetigkeit']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mitarbeiter" class="form-label">Mitarbeiter</label>
                            <select class="form-select" id="mitarbeiter" name="mitarbeiter">
                                <?php foreach ($mitarbeiter as $mitarbeiter) : ?>
                                    <option value="<?php echo $mitarbeiter['MitarbeiterID']; ?>"><?php echo $mitarbeiter['MitarbeiterName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Kunde -->
    <div class="modal fade" id="kundeModal" tabindex="-1" aria-labelledby="kundeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kundeModalLabel">Neuen Kunden hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="insert_Kunde.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="Kundenname" required>
                        </div>
                        <div class="mb-3">
                            <label for="farbe" class="form-label">Farbe</label>
                            <input type="text" class="form-control" id="farbe" name="farbe" value="Red" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="test@test.test" required>
                        </div>
                        <div class="mb-3">
                            <label for="strasse" class="form-label">Straße</label>
                            <input type="text" class="form-control" id="strasse" name="strasse" value="Musterstrasse" required>
                        </div>
                        <div class="mb-3">
                            <label for="plz" class="form-label">PLZ</label>
                            <input type="text" class="form-control" id="plz" name="plz" value="4020" required>
                        </div>
                        <div class="mb-3">
                            <label for="ort" class="form-label">Ort</label>
                            <input type="text" class="form-control" id="ort" name="ort" value="Linz" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Mitarbeiter -->
    <div class="modal fade" id="mitarbeiterModal" tabindex="-1" aria-labelledby="mitarbeiterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mitarbeiterModalLabel">Neuen Mitarbeiter hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="insert_Mitarbeiter.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="Mitarbeitername" required>
                        </div>
                        <div class="mb-3">
                            <label for="farbe" class="form-label">Farbe</label>
                            <input type="text" class="form-control" id="farbe" name="farbe" value="Red" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="test@test.test" required>
                        </div>
                        <div class="mb-3">
                            <label for="strasse" class="form-label">Straße</label>
                            <input type="text" class="form-control" id="strasse" name="strasse" value="Musterstrasse" required>
                        </div>
                        <div class="mb-3">
                            <label for="plz" class="form-label">PLZ</label>
                            <input type="text" class="form-control" id="plz" name="plz" value="4020" required>
                        </div>
                        <div class="mb-3">
                            <label for="ort" class="form-label">Ort</label>
                            <input type="text" class="form-control" id="ort" name="ort" value="Linz" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </form>
    </div>
    </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <script>
        $(document).ready(function() {
            // Funktion zum Filtern der Karten
            function filterCards() {
                $.ajax({
                    url: 'cards.php',
                    type: 'POST',
                    data: {
                        kundeFilter: $('#kundeFilter').val(),
                        mitarbeiterFilter: $('#mitarbeiterFilter').val(),
                        projektFilter: $('#projektFilter').val(),
                        startDatum: $('#startDatum').val(),
                        endeDatum: $('#endeDatum').val()
                    },
                    success: function(response) {
                        $('#cards').html(response);
                        updateTotalHours(); // Update der Gesamtstunden nach jedem Filtervorgang
                    }
                });
            }

            // Funktion zum Aktualisieren der Gesamtstunden
            function updateTotalHours() {
                // Erstelle ein Objekt für die Daten, die gesendet werden sollen
                var data = {};
                if ($('#kundeFilter').val()) data.kundeFilter = $('#kundeFilter').val();
                if ($('#mitarbeiterFilter').val()) data.mitarbeiterFilter = $('#mitarbeiterFilter').val();
                if ($('#projektFilter').val()) data.projektFilter = $('#projektFilter').val();
                if ($('#startDatum').val()) data.startDatum = $('#startDatum').val();
                if ($('#endeDatum').val()) data.endeDatum = $('#endeDatum').val();

                $.ajax({
                    url: 'stunden.php',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        // Angenommen, du hast ein Div mit der ID 'totalHours' unter dem Button
                        $('#totalHours').html("Gesamtstunden: " + response);
                    }
                });
            }
            // Event-Handler für die Filter
            $('#kundeFilter, #mitarbeiterFilter, #projektFilter, #startDatum, #endeDatum').on('change', filterCards);

            // Initialer Aufruf, um beim Laden der Seite die Karten und Stunden anzuzeigen
            filterCards();
        });
    </script>
</body>

</html>