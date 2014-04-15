<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/functions.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 
ob_start();
$password = $_POST['password'];
$userid = $_GET['id'];
$hash = password_encrypt($password) ;


	if (isset($_POST['submit'])) {
		$query = "UPDATE users SET ";
		$query .= "password = '{$hash}'";
		$query .= " WHERE id = '{$userid}'";
		$query .= " LIMIT 1";

		$sql = "SELECT firstname, lastname, password FROM users WHERE id = {$userid}";
            echo $sql;
                $data = mysqli_query($connection, $sql) 
                    or die("Nope");
            $info = mysqli_fetch_row($data);

             $_SESSION['userid'] = $userid ;
        $_SESSION['firstname'] =  $info[0] ;
        $_SESSION['lastname'] = $info[1];
        $_SESSION['fullname'] = $info[0] . ' ' . $info[1];

		 $result = mysqli_query($connection, $query);
	        if ($result && mysqli_affected_rows($connection) >= 0) {
	            header("Location: ../index.php");
	            $_SESSION['userid'] = $userid;
	        } else {
	        	header("Location: ../login.php");
	        }
	}
ob_flush();
?>