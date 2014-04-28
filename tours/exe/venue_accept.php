<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php
	
	$id = $_GET['id'];

	$sql = "SELECT u.firstname, u.lastname, u.email, c.name AS campaign, c.artist, v.id, r.city, DATE_FORMAT(q.`date`, '%d/%m/%Y'), q.capacity, q.face_value, q.guarantee, c.id \n"
	. "FROM quotes AS q \n"
	. "JOIN users AS u ON q.creator_id = u.id \n"
	. "JOIN routing AS r ON q.date_id = r.id\n"
	. "JOIN venue AS v ON q.venue_id = v.id\n"
	. "JOIN campaigns AS c ON r.campaign_id = c.id\n"
	. "WHERE q.id = {$id} ";

    $result = mysqli_query($connection, $sql) ;
    $info = mysqli_fetch_row($result);
    $campaignid = $info[11];
    $venue = $info[5];

	echo "Write some code here to update venue acknowledgement table";

	$query = "INSERT INTO venue_acknowledge SET venue_id = {$venue}, quote_id = {$id}, acknowledged = NOW(), recordstatus = 1, datecreated = NOW()";
    //mysqli_query($connection, $query);
    echo $query

	//header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");

 ?>