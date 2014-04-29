<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php
	
	$id = $_GET['id'];
	$result = mysqli_query($connection, "SELECT * FROM venue_acknowledge WHERE quote_id = {$id}");
    $info = mysqli_num_rows($result);

    if ($info <= 1) {

		$sql = "SELECT u.firstname, u.lastname, u.email, c.name AS campaign, c.artist, v.id, r.city, DATE_FORMAT(q.`date`, '%d/%m/%Y'), q.capacity, q.face_value, q.guarantee, c.id, v.name \n"
	    . "FROM quotes AS q \n"
	    . "JOIN routing AS r ON q.date_id = r.id \n"
	    . "JOIN venue AS v ON q.venue_id = v.id \n"
	    . "JOIN company AS co ON co.name = v.name\n"
	    . "JOIN users AS u ON co.id = u.companyid \n"
	    . "JOIN campaigns AS c ON r.campaign_id = c.id \n"
	    . "WHERE q.id = {$id}";

	    echo $sql;
	 
	    $result = mysqli_query($connection, $sql) ;
	    $info = mysqli_fetch_row($result);
	    echo "<pre>";
	    print_r($info);
	    echo "</pre>";
	    $campaignid = $info[11];
	    $venueid = $info[5];
	    $venue = $info[12];
	    $identifier = $info[6] . " " . $info[7]  . " - " . $info[10];
		$query = "INSERT INTO venue_acknowledge SET venue_id = {$venueid}, quote_id = {$id}, acknowledged = NOW(), recordstatus = 1, datecreated = NOW()";
	    //mysqli_query($connection, $query);
	    $query = "INSERT INTO history SET campaignid = {$campaignid}, actiondate = NOW(), action = '{$venue} has acknowledged that their quote has been accepted', actionid = 6, identifier = '{$identifier}', identifierid = {$id}, recordstatus = 1, datecreated = NOW()";
		//mysqli_query($connection, $query);

	}
	//header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");

 ?>
