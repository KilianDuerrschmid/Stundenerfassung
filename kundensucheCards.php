<?php
require_once('config.php');

$kunde = $_POST["kunde"];
$start = $_POST["start"];
$ende = $_POST["ende"];
$return = "";
if ($ende == "0000-00-00" || $ende == '') $ende = null;
if ($start == "0000-00-00" || $start == '') $start = null;
if ($kunde == "") $kunde = null;


require_once('config.php');
?>
<script>
    console.log(<?= json_encode($start); ?>);
</script>
<?php
    
$sql = "SELECT * FROM arbeitszeit where (? is null or kundeId = ?) and (? is null or DATE(start) >= ?) and (? is null or DATE(ende) >= ?)";

if ($stmt = mysqli_prepare($link, $sql)) {

    mysqli_stmt_bind_param(
        $stmt,
        "iissss",
        $kunde,
        $kunde,
        $start,
        $start,
        $ende,
        $ende
    );

    ?>
<script>
    console.log(<?= json_encode($ende); ?>);
</script>
<?php

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    foreach ($res as $entry) {
        $color = "";

        switch ($entry["kundeId"]) {
            case "1":
                $color = "bg-danger";
                break;
            case "2":
                $color = "bg-success";
                break;

            case "3":
                $color = "bg-info";
                break;
            default:
                $color = "bg-secondary";
                break;
        }

        $return .= '<div class="col-md-4 mb-3">';
        $return .= '<div class="card ' . $color . ' text-white">';
        $return .= '<div class="card-body">';
        $return .= '<h5 class="card-title">' . $entry["titel"] . '</h5>';
        $return .= '<p class="card-text">' . $entry["beschreibung"] . '</p>';
        $return .= '<p class="card-text">' . $entry["start"] . '</p>';
        $return .= '<p class="card-text">' . $entry["ende"] . '</p>';
        $return .= '<p class="card-text">' . $entry["kundeId"] . '</p>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
    }

    mysqli_stmt_close($stmt);
}

echo $return;

exit();
