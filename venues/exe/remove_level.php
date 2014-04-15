<?php include '../../inc/db_connection.php'; ?>
<?php include '../../inc/permissions.php'; ?>
<?php

ob_start();

    $id = $_GET["id"];
    $venue_id = $_GET["vid"];

       mysqli_query($connection, "UPDATE venue_levels SET recordstatus = 2 WHERE id = {$id}") or die();

    header("Location: ../levels.php?id=$venue_id");

ob_flush();

?>