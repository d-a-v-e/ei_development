<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $quote_id = $_GET["qid"];
    $campaign_id = $_GET["id"];
    $date_id = $_GET["did"];


	   mysqli_query($connection, "UPDATE quotes SET recordstatus = 2 WHERE id = {$quote_id} LIMIT 1") or die();

	   mysqli_query($connection, "UPDATE quote_discussions SET recordstatus = 2 WHERE quote_id = {$quote_id} ") or die();



    header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");

ob_flush();

?>
