<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();
    $username = $_SESSION["name"];
    $userid = $_SESSION["userid"];
    $id = $_GET["id"];

 if (isset($_POST['submit'])) {

            $query  = "INSERT INTO routing SET  ";
            $query .= "campaign_id = '{$id}', ";
            $query .= "creator_id = '{$userid}', ";
        if (!empty($_POST['city'])) {
            $query .= "city = '{$_POST['city']}', ";}
        if (!empty($_POST['country'])) {
            if ($_POST['country'] == 'UK') { $_POST['country'] = 'GB' ;}
            $query .= "country = '{$_POST['country']}', ";}
         if (!empty($_POST['lat'])) {
             $query .= "lat = '{$_POST['lat']}', ";}
        if (!empty($_POST['long'])) {
            $query .= "`long` = '{$_POST['long']}', ";}
        if (!empty($_POST['time_zone'])) {
            $query .= "time_zone = '{$_POST['time_zone']}', ";}
        if (!empty($_POST['date'])) {
            $time = date_parse_from_format("n/j/Y", $_POST['date']);
            $date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
            $query .= "date = '{$date}', ";}
            //$query .= "date = '{$_POST['date']}', ";}
        if (!empty($_POST['flexibility'])) {
            $query .= "flexibility = '{$_POST['flexibility']}', ";}
            $query .= "recordstatus = '1', datecreated = NOW() ";
    echo $query . "<br>";
        $result = mysqli_query($connection, $query) or die ("nope");
        $insid = mysqli_insert_id($connection);
        $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Date Added', actionid = 3, identifier = '{$_POST['city']}', identifierid = {$insid}, recordstatus = 1, datecreated = NOW()";
        mysqli_query($connection, $query);
        echo $query;
        if ($result && mysqli_affected_rows($connection) >= 0) {
            header("Location: ../routing.php?id=$id");
        } else {
            header("Location: ../adddate.php?id=$id");
        }
    
    }
 
ob_flush();

?>