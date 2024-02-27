<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zeitausgabe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>

    <div class="container text-center">
        <h2>Suchoptionen</h2>
        <form id="kundensuche">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">

                        <?php
                        include_once('config.php');

                        $query = $link->prepare('SELECT * FROM kunde');
                        $query->execute();
                        $res = $query->get_result();

                        if ($res->num_rows) {
                            echo '<label for="kundeSelect" class="form-label">Wählen Sie einen Kunden.</label>';
                            echo '<select name="kundeSelect" id="kundeSelect" class="form-control">';
                            foreach ($res as $entry) {
                                echo '<option value="' . $entry['id'] . '">' . $entry["nachname"] . '/' . $entry['id'] . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo "Keine Kunden gefunden";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="start" class="form-label">Start</label>
                        <input type="datetime-local" class="form-control" name="start" id="start" value="2024-01-05T23:59:60Z">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="ende" class="form-label">Ende</label>
                        <input type="datetime-local" class="form-control" name="ende" id="ende" value="2024-01-08T23:59:60Z">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mb-3">Suche</button>
                    <a class="btn btn-secondary mb-3" href="ausgabeCards.php">Kartenausgabe</a>
                    <a class="btn btn-secondary mb-3" href="index.php">Zeiterfassung</a>
                </div>

            </div>
        </form>





        <div class="row">
            <div class="col">
                <h2>Ausgabe</h2>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <table id="testTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kunde</th>
                            <th>Titel</th>
                            <th>Beschreibung</th>
                            <th>Startzeit</th>
                            <th>Endzeit</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        require_once('config.php');

                        try {
                            $query = $link->prepare('SELECT * from arbeitszeit');
                            $query->execute();
                            $res = $query->get_result();

                            foreach ($res as $entry) {
                                echo '<tr id="' . $entry["id"] . '">';
                                echo '<td>' . $entry["kundeId"] . '</td>';
                                echo '<td>' . $entry["titel"] . '</td>';
                                echo '<td>' . $entry["beschreibung"] . '</td>';
                                echo '<td>' . $entry["start"] . '</td>';
                                echo '<td>' . $entry["ende"] . '</td>';
                                echo '</tr>';
                            }
                        } catch (PDOException $ex) {
                            error_log('Fehler beim Laden der Spiele.');
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#kundensuche').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "kundensuche.php",
                    method: "post",
                    data: {
                        kunde: $('#kundeSelect').find("option:selected").val(),
                        start: $('#start').val(),
                        ende: $('#ende').val()
                    },
                    success: function(res) {
                        console.log($('#kunde').val());
                        console.log($('#start').val());
                        console.log($('#ende').val());


                        console.log(res);

                        $('#testTable tbody').html(res);
                    },
                    error: function(err) {
                        alert("Es ist ein Fehler aufgetreten: " + err.status + " " + err.statusText);
                    }
                });
            })
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>