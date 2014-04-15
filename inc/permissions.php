<?php require_once("session.php"); ?>
<?php require_once("db_connection.php"); ?>
<?php
ob_start();
    $userid = $_SESSION['userid'];

    if (empty($userid)) {
        $_SESSION['message'] = "invalid user details";
        header("Location: login.php");
    }

    $sql = "SELECT * FROM permissions WHERE userid = '$userid'";
    $data = mysqli_query($connection, $sql) 
        or die(mysql_error());
        $info = mysqli_fetch_array( $data );

        $name = $info['name'];
        $m01 = $info['m01'];
        $m02 = $info['m02'];
        $m03 = $info['m03'];
        $m04 = $info['m04'];
        $m05 = $info['m05'];
        $m01s01 = $info['m01s01'];
        $m01s02 = $info['m01s02'];
        $m01s03 = $info['m01s03'];
        $m01s04 = $info['m01s04'];
        $m02s01 = $info['m02s01'];
        $m02s02 = $info['m02s02'];
        $m02s03 = $info['m02s03'];
        $m02s04 = $info['m02s04'];
ob_flush();      
?>
