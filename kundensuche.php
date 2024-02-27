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

$sql = 'SELECT * FROM arbeit where (? is null or kundeId = ?) and (? is null or start = ?) and (? is null or ende = ?)';

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

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    foreach ($res as $entry) {
        $return .= '<trid="' . $entry["id"] . '">';
        $return .= '<td>' . $entry["kundeId"] . '</td>';
        $return .= '<td>' . $entry["titel"] . '</td>';
        $return .= '<td>' . $entry["beschreibung"] . '</td>';
        $return .= '<td>' . $entry["start"] . '</td>';
        $return .= '<td>' . $entry["ende"] . '</td>';
        $return .= '</tr>';
    }

    mysqli_stmt_close($stmt);
}

echo $return;

exit();
