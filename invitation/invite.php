<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/functions.php'; ?>
<?php

$email = isset($_POST['email']) ? $_POST['email'] : "";
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : "";
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : "";


$_SESSION['email'] = $email ;
$_SESSION['firstname'] = $firstname ;
$_SESSION['lastname'] = $lastname ;

// Create random unique activation code:
$length = 20;
$invitecode = "";
$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
for ($p = 0; $p < $length; $p++) {
    $invitecode .= $characters[mt_rand(0, strlen($characters) - 1)];
}

// Create new table entry
$recordstatus = 1;
$datecreated = "NOW()";

if (!empty($_POST['submit'])) {
mysqli_query($connection, "INSERT INTO invitations (email, invitecode, recordstatus, datecreated) VALUES ('$email', '$invitecode', '$recordstatus', {$datecreated} )")
or die();

mysqli_query($connection, "INSERT INTO users (firstname, lastname, email, recordstatus, datecreated) VALUES ('$firstname', '$lastname', '$email', '$recordstatus', {$datecreated} )") or die();
$userid = mysqli_insert_id($connection);
}

//$link = 'http://www.entertainment-intelligence.com/eitp/invitation/db_check.php?email="' .$email. '&invitationid=' . $invitecode . '&uid=' . $userid  ;
// Providing link for the user (redirect to the db check script)
$link = "<a href='http://www.entertainment-intelligence.com/eitp/invitation/db_check.php?email=".$email."&invitationid=" . $invitecode . "&uid=" . $userid . "'>Click here</a>" ;
//$link = "<a href='http://127.0.0.1:8888/eitp/invitation/db_check.php?email=".$email."&invitationid=" . $invitecode . "&uid=" . $userid . ">Link</a>" ;
// Message
$mail_to = $email;
$subject = 'Invitation to join Entertainment Intelligence for '.$firstname . " " . $lastname ;
$message = "Hello ".$firstname."!\r\nYou have been invited to join Entertainment Intelligence.\r\nPlease click the link below to activate your account:\r\n"
    . $link ;
        // In case any of our lines are larger than 70 characters, we should use wordwrap()
        $message = wordwrap($message, 70, "\r\n");
$headers = "From: welcome@entertainment-intelligence.com";


// Send the email 
mail($mail_to, $subject, $message, $headers);

	    header("Location: ../index.php");

?>

                <h3>Email Preview:</h3>
                <p><?php echo $message; ?></p>
                <p><?php echo $email; ?></p>
                <p><?php echo $invitecode; ?></p>
                