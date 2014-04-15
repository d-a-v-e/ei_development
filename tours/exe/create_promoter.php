<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 

ob_start();
    $id = $_GET['id'];


if(isset($_POST['submit'])){
 
    $query = "INSERT INTO company SET ";
    if (isset($_POST['company'])) {
    $query .= "name = '{$_POST['company']}', "; }
        if (isset($_POST['nickname'])) {
    $query .= "nickname = '{$_POST['nickname']}', "; }
        if (isset($_POST['description'])) {
    $query .= "description = '{$_POST['description']}', "; }
    $query .= "companytypeid = 2, recordstatus = 1, datecreated = NOW() ";


    mysqli_query($connection, $query) or die("no");

  $pro_id = mysqli_insert_id($connection);


	$query = "INSERT INTO routing_promoters SET "
	.	"campaign_id = {$id}, "
	.	"promoter_id = {$pro_id}, "
	.   "recordstatus = 1, datecreated = NOW()";
    mysqli_query($connection, $query) 
        or die("mysql_error()");


    $query = "INSERT INTO office SET " ;
    $query .= "companyid = {$pro_id}, ";
    if (isset($_POST['office'])) {
    $query .= "office_name = '{$_POST['office']}', "; }



    if (isset($_POST['country'])) {
    $query .= "country = '{$_POST['country']}', "; }
    $query .= "recordstatus = 1, datecreated = NOW()";
    mysqli_query($connection, $query) 
  or die("Office table not updated");

    $office_id =  mysqli_insert_id($connection);


     $query = "INSERT INTO users SET " ;
    $query .= "officeid = {$office_id}, ";
    $query .= "companyid = {$pro_id}, ";
    if (isset($_POST['firstname'])) {
    $query .= "firstname = '{$_POST['firstname']}', "; }
    if (isset($_POST['lastname'])) {
    $query .= "lastname = '{$_POST['lastname']}', "; }
    if (isset($_POST['email'])) {
    $query .= "email = '{$_POST['email']}', "; }
    $query .= "recordstatus = 1, datecreated = NOW()";
    mysqli_query($connection, $query) 
        or die("users table not updated");

    $user_id =  mysqli_insert_id($connection);

    $name = $_POST['firstname'] . " " . $_POST['lastname'];


    // NB - this is the permissions schema for promoter and the 1 for m01s04 switches off all the buttons they cant see...
    $query = "INSERT into permissions values (NULL, {$user_id}, '{$name}',0,0,0,0,0,0,0,0,1,0,0,0,0,1,NOW(),NULL,NULL);";

    mysqli_query($connection, $query) 
        or die("could not update permissions");

			$_SESSION['message'] = "Promoter added...";

		
}

header("Location: ../promoters.php?id=$id");
ob_flush();

?>