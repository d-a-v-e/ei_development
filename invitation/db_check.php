<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/functions.php'; ?>
<?php
 ob_start() ;

    $invitationid = isset($_GET['invitationid']) ? $_GET['invitationid'] : "";
    $email = isset($_GET['email']) ? $_GET['email'] : "";
    $userid = $_GET['uid'];

    $sql = "SELECT * FROM invitations WHERE email='$email' AND invitecode ='$invitationid' LIMIT 1";
                $data = mysqli_query($connection, $sql) 
                    or die(mysql_error());
            $info = mysqli_fetch_row($data);

     $sql = "SELECT id, firstname, password FROM users WHERE email='$email' LIMIT 1";
                $data = mysqli_query($connection, $sql) 
                    or die(mysql_error());
            $infoo = mysqli_fetch_row($data);

    //$userid = $infoo[0];
    $name = $infoo[1];
    $pw = $infoo[2];

    $recordstatus = 1;
    $datecreated = "NOW()";
    $sql = "INSERT into permissions values (NULL, '$userid', '$name',0,0,0,0,0,0,0,0,0,0,0,0,0,0,$datecreated,NULL,NULL)";
    mysqli_query($connection, $sql)  or die("SQL database Error (permissions)");
        
    if (!empty($info)){

        session_start();
            $_SESSION['userid'] = $userid ;
            $_SESSION['firstname'] =  $name ;

                if (!empty($pw))
                {
                header("Location: ../index.php");
                    echo "Password set";
                } else {
                header("Location: register.php?id=$userid");
                    echo "Password not set";
                }

    } else {
         header("Location: ../index.php");
        echo "invalid invite code";
    }

ob_end_flush() ;

?>

<html>
    <body>
        <h1>
            <?php print_r($info)?><br>
            <?php print_r($infoo)?>
            <?php echo "</br>The email is: " . $email; ?>
            <?php echo "</br>The id is: " . $_SESSION['userid']; ?>
            <?php echo "</br>Session name: " .  $_SESSION['name'] ; ?>
        </h1>
    </body>
</html>