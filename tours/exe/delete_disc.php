<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $campaign_id = $_GET["id"];
    $discussion_id = $_GET["did"];

   mysqli_query($connection, "UPDATE discussions SET recordstatus = 2 WHERE id = {$discussion_id}");
   mysqli_query($connection, "UPDATE discussion_responses SET recordstatus = 2 WHERE discussion_id = {$discussion_id}");

    header("Location: ../discussions.php?id=$campaign_id");

ob_flush();

?>
