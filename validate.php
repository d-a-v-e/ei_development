<?php require_once("inc/session.php"); ?>
<?php require_once("inc/db_connection.php"); ?>
<?php require_once("inc/functions.php"); ?>
<?php 
    
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    
    //$email = stripslashes($email);
    //$password = stripslashes($password);
    //$email = mysql_real_escape_string($email);
    //$password = mysql_real_escape_string($password);  
    

    $sql = "SELECT id, firstname, lastname, password FROM users WHERE email LIKE '%{$email}%'";
                $data = mysqli_query($connection, $sql) 
                    or die("Nope");
            $info = mysqli_fetch_row($data);

            $existing_hash = $info[3];

$match = password_check($password, $existing_hash) ; 

if ($match == TRUE) {
    // go to home page
        $_SESSION['userid'] = $info[0] ;
        $_SESSION['firstname'] =  $info[1] ;
        $_SESSION['lastname'] = $info[2];
        $_SESSION['fullname'] = $info[1] . ' ' . $info[2];
           header("Location: index.php");
       
} else {
       header("Location: login.php");
        $_SESSION['message'] = "Login failed";
}

?>

