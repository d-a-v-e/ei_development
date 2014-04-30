<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php 
	$result = mysqli_query($connection, "SELECT firstname FROM users");
	$items = array();
		while ($value = mysqli_fetch_row($result)) {
			$items[] = $value[0];
		}
	$result = mysqli_query($connection, "SELECT * FROM venue");
    	while ($info = mysqli_fetch_row($result)) {
    		$i = 1;
    		$sql = "INSERT INTO company SET name = '{$info[2]}', companytypeid = 5, description = '{$info[17]}', recordstatus = 1, datecreated = NOW() ";
    		mysqli_query($connection, $sql);
    		echo $sql . "<br>";
    		$insid = mysqli_insert_id($connection);
    		$sql = "INSERT INTO office SET companyid = {$insid}, office_name = '{$info[2]}', town = '{$info[3]}', country = '{$info[4]}', address3 = '{$info[5]}', recordstatus = 1, datecreated = NOW() ";
    		mysqli_query($connection, $sql);
    		$insid2 = mysqli_insert_id($connection);
    		echo $sql . "<br>";
    		$name = substr($info[2], 0, 5);
    		$fname = array_rand($items);
    		$firstname = $items[$fname];
    		$sql = "INSERT INTO user SET companyid = {$insid}, officeid = {$insid2}, firstname = '{$firstname}', lastname = '{$name}', email = 'bigvenue1@entertainment-intelligence.com', recordstatus = 1, datecreated = NOW() ";
    		echo $sql . "<br>";
    		mysqli_query($connection, $sql);
    		$i++;
		}
?>