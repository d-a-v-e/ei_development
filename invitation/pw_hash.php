<?php require_once("../web/includes/db_connection.php"); ?>
<?php require_once("../web/includes/functions.php"); ?>
<?php


$password = isset($_GET['password']) ? $_GET['password'] : "";
$name = $_SESSION['name'];

?>
<?php 
/*
$password = "password" ;
$hash = password_encrypt($password) ;
$hash2 = crypt($password, $hash) ;
$hash3 = crypt($password, $hash2) ;
$match = password_check($password, $hash) ; 

if (crypt($password, $hash) === $hash) {
    echo "Yes, they are definitely equal";
} else {
    echo "No theyre not";
}
*/
?>