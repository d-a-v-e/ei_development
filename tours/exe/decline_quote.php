<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php
ob_start();

    $campaign_id = $_GET["id"];
    $quote_id = $_GET["qid"];
    $date_id = $_GET["did"];

if ($m01s04 == 1) {
	header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");
	$_SESSION['message'] = "invalid permissions";
}

	mysqli_query($connection, "UPDATE quotes SET accepted = 0 WHERE date_id = {$date_id} ") or die();
	
	$cit = mysqli_query($connection, "SELECT city FROM routing WHERE id = {$date_id} ") or die();
	$city = mysqli_fetch_row($cit);
	$query = "INSERT INTO history SET campaignid = {$campaign_id}, actiondate = NOW(), action = 'Quote Declined', actionid = 6, identifier = '{$city[0]}', identifierid = {$quote_id}, recordstatus = 1, datecreated = NOW()";
    mysqli_query($connection, $query);

    header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");

ob_flush();

?>
