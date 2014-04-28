<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php
ob_start();

    $quote_id = $_GET["id"];

	$sql = "SELECT u.firstname, u.lastname, u.email, c.name AS campaign, c.artist, v.name, r.city, q.`date`, q.capacity, q.face_value, q.guarantee\n"
	. "FROM quotes AS q \n"
	. "JOIN users AS u ON q.creator_id = u.id \n"
	. "JOIN routing AS r ON q.date_id = r.id\n"
	. "JOIN venue AS v ON q.venue_id = v.id\n"
	. "JOIN campaigns AS c ON r.campaign_id = c.id\n"
	. "WHERE q.id = {$quote_id} ";

	$result = mysqli_query($connection, $sql);
	$info = mysqli_fetch_row($result);

	$random_hash = md5(date('r', time())); 

	$name = $info[0] . " " . $info[1];
	$campaign = $info[3] . " (" . $info[4] . ")";
	$to = $info[2];
	$subject = 'Quote accepted'; 
	$message = "Dear {$name},\r\nThis email is to notify you that your quote on {$campaign} has been accepted.\n";
	$message .= "Please click the link below to validate this and notify venue.\n";
	$message .= "<a href='http://entertainment-intelligence.com/eitp/tours/exe/promo_accept.php?id={$quote_id}'>Confirm Acceptance</a>\n";
	$message .= "<a href='http://127.0.0.1:8888/eitp/tours/exe/promo_accept.php?id={$quote_id}'>Confirm Acceptance</a>";
	$headers = "From: welcome@entertainment-intelligence.com\r\nReply-To: welcome@entertainment-intelligence.com";
	$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 

	echo $message;
	// mail( $to, $subject, $message, $headers );
 	//header("Location: ../quotes.php?id={$campaign_id}&did={$date_id}");

ob_flush();

?>