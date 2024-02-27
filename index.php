<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stunden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>

    <div class="container text-center">

        <h2>Eingabe</h2>
        <form id="neuer_eintrag">
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
                        <label for="titel" class="form-label">Titel</label>
                        <input type="text" class="form-control" name="titel" id="titel" value="Titel" placeholder="Titel">
                    </div>


                    <div class="mb-3">
                        <label for="beschreibung" class="form-label">Beschreibung</label>
                        <input type="text" class="form-control" name="beschreibung" id="beschreibung" value="Beschreibung" placeholder="beschreibung">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="start" class="form-label">Start</label>
                        <input type="datetime-local" class="form-control" name="start" id="start" value="2024-01-05T23:59:60Z">
                    </div>


                    <div class="mb-3">
                        <label for="ende" class="form-label">Ende</label>
                        <input type="datetime-local" class="form-control" name="ende" id="ende" value="2024-01-08T23:59:60Z">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mb-3">Speichern</button>
                    <a class="btn btn-secondary mb-3" href="ausgabe.php">Arbeitszeitausgabe</a>
                    <div class="alert alert-success" id="success-alert">
                        <strong>Speichern erfolgreich!</strong>
                    </div>
                </div>
        </form>
    </div>
    </div>
    </div>

    <script>

        $(document).ready(function() {

            $("#success-alert").hide();

            $('#neuer_eintrag').submit(function(event) {
                event.preventDefault();
                console.log($('#kundeSelect').find("option:selected").val())
                $.ajax({
                    url: "insert_entry.php",
                    method: "post",
                    data: {
                        kunde: $('#kundeSelect').find("option:selected").val(),
                        titel: $('#titel').val(),
                        beschreibung: $('#beschreibung').val(),
                        start: $('#start').val(),
                        ende: $('#ende').val()
                    },
                    error: function(err) {
                        alert("Es ist ein Fehler aufgetreten: " + err.status + " " + err.statusText);
                    }
                });

                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });


            })
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>