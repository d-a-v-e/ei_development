<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();
	
    $promoter_id = $_GET["pid"];
    $campaign_id = $_GET["id"];

	   mysqli_query($connection, "DELETE FROM routing_promoters WHERE id = {$promoter_id}") or die();


    header("Location: ../promoters.php?id=$campaign_id");

ob_flush();

?>
