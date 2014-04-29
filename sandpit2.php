<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php 
	$result = mysqli_query($connection, "SELECT * FROM venue");
    while ($info = mysqli_fetch_row($result)) {
    echo "<pre>";
    print_r($info);
    echo "<pre>";
}
?>