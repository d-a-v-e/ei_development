<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $response_id = $_GET["rid"];
    $discussion_id = $_GET["id"];
    $campaign_id = $_GET["cid"];


	   mysqli_query($connection, "UPDATE discussion_responses SET recordstatus = 2 WHERE id = {$response_id}");


    header("Location: ../discussion.php?id=$discussion_id&cid=$campaign_id");

ob_flush();

?>
