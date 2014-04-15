<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $campaign_id = $_GET["id"];
    $date_id = $_GET["did"];


	   mysqli_query($connection, "UPDATE routing SET recordstatus = 2 WHERE id = {$date_id}") or die();


    header("Location: ../routing.php?id=$campaign_id");

ob_flush();

?>
