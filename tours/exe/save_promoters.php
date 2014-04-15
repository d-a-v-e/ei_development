<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 
ob_start();

$promoter_id = $_GET['id'];
$id = $_POST['campaign_id'];
$dates = "";
foreach ($_POST as $key => $value) {
	if ($value == 1) {
	$dates .= $key . ", ";
	}
}


$query = "UPDATE routing_promoters SET "
	.	"date_id = '{$dates}' "
	. "WHERE promoter_id = {$promoter_id} ";

	
    mysqli_query($connection, $query) 
        or die("mysql_error()");
			$_SESSION['message'] = "Dates saved...";
			$_SESSION['alert'] = "success";

			header("Location: ../promoters.php?id=$id");

ob_flush();
?>