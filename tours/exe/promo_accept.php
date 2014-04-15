<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 

    $id = $_GET["id"];

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

	$query = "INSERT INTO history SET campaignid = {$campaignid}, actiondate = NOW(), action = '{$promoname} has acknowledged that their quote has been accepted', actionid = 6, identifier = '{$identifier}', identifierid = {$id}, recordstatus = 1, datecreated = NOW()";
	mysqli_query($connection, $query);

	header("Location: ../tour.php?id={$campaignid}");
?>