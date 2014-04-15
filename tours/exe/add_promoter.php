<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php
ob_start();

$_SESSION['message'] = 'Promoter(s) already listed:<br>';
$_SESSION['alert'] = 'warning';

    $id = isset($_GET['id']) ? $_GET['id'] : "" ;
    $username = isset($_SESSION["name"]) ? $_SESSION["name"] : $_SESSION["firstname"];
    $userid = $_SESSION["userid"];

    foreach ($_POST as $key => $value) {
        if (is_int($key)) {
          $pro_id = $key;
            $select = "SELECT routing_promoters.*, company.name FROM routing_promoters JOIN company on company.id = routing_promoters.promoter_id WHERE campaign_id = {$id} AND promoter_id = {$pro_id}";
            $result = mysqli_query($connection, $select);
            $name = mysqli_fetch_row($result);
             if ($result && mysqli_affected_rows($connection) > 0) {
              $_SESSION['message'] .= "{$name[9]}<br>";
              continue;
      		} else {
      			$query = "INSERT INTO routing_promoters SET "
          	.	"campaign_id = {$id}, "
          	.	"promoter_id = {$pro_id}, "
          	.   "recordstatus = 1, datecreated = NOW()";
          mysqli_query($connection, $query) 
              or die("mysql_error()");
      		}
        }
    }

header("Location: ../promoters.php?id=$id");
ob_flush();
?>