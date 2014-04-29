<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 

    $id = $_GET["id"];

    $result = mysqli_query($connection, "SELECT * FROM promoter_acknowledge WHERE quote_id = {$id}");
    $info = mysqli_num_rows($result);

    if ($info <= 0) {

	    $sql = "SELECT u.firstname, u.lastname, u.email, c.name AS campaign, c.artist, v.name, r.city, DATE_FORMAT(q.`date`, '%d/%m/%Y'), q.capacity, q.face_value, q.guarantee, c.id \n"
		. "FROM quotes AS q \n"
		. "JOIN users AS u ON q.creator_id = u.id \n"
		. "JOIN routing AS r ON q.date_id = r.id\n"
		. "JOIN venue AS v ON q.venue_id = v.id\n"
		. "JOIN campaigns AS c ON r.campaign_id = c.id\n"
		. "WHERE q.id = {$id} ";

	    $result = mysqli_query($connection, $sql) ;
	    $info = mysqli_fetch_row($result);
	    $promoname = $info[0] . " " . $info[1];
	    $campaignid = $info[11];
	    $identifier = $info[6] . " " . $info[7]  . " - " . $info[10];
	    $venue = $info[5];

		$random_hash = md5(date('r', time())); 

		$name = $info[0] . " " . $info[1];
		$campaign = $info[3] . " (" . $info[4] . ")";
		$to = $info[2];
		$subject = 'Quote accepted'; 
		$message = "Dear {$name},\nThis email is to notify you that your venue {$venue} has been accepted as a route on {$campaign}.\n";
		$message .= "Please click the link below to validate this and notify the promoter ({$promoname}).\n";
		$message .= "<a href='http://entertainment-intelligence.com/eitp/tours/exe/promo_accept.php?id={$id}'>Confirm</a>\n";
		$message .= "<a href='http://127.0.0.1:8888/eitp/tours/exe/venue_accept.php?id={$id}'>Confirm</a>";
		$headers = "From: welcome@entertainment-intelligence.com\r\nReply-To: welcome@entertainment-intelligence.com";
		$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 

		$query = "INSERT INTO history SET campaignid = {$campaignid}, actiondate = NOW(), action = '{$promoname} has acknowledged that their quote has been accepted', actionid = 6, identifier = '{$identifier}', identifierid = {$id}, recordstatus = 1, datecreated = NOW()";
		mysqli_query($connection, $query);
		$query = "INSERT INTO promoter_acknowledge SET quote_id = {$id}, acknowledged = NOW(), recordstatus = 1, datecreated = NOW()";
		mysqli_query($connection, $query);

	} 
	header("Location: ../tour.php?id={$campaignid}");
?>