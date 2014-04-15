<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    $id = $_GET["id"];
    $userid = $_SESSION["userid"];
    if ($_POST["link"] == "http://") {
        $_POST["link"] == "";
    }

    $sql = "SELECT location, country, lattitude, longitude FROM venue WHERE id = {$_POST['venue']}";
    $data = mysqli_query($connection, $sql) or die("Database error");
    $info = mysqli_fetch_row($data);
    $city = $info[0];
    $country = $info[1];
    $lat = $info[2];
    $long = $info[3];

if (isset($_POST['submit'])) {

        $query = "INSERT INTO routing SET ";
        $query .= "campaign_id = '{$id}', ";
        $query .= "creator_id = '{$userid}', ";
        $query .= "city = '{$city}', ";
        $query .= "country = '{$country}', ";
        $query .= "lat = {$lat}, ";
        $query .= "`long` = {$long}, ";
           $time = date_parse_from_format("n/j/Y", $_POST['date']);
           $date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
        $query .= "date = '{$date}', ";
        $query .= "flexibility = '0', ";
        $query .= "recordstatus = '1', datecreated = NOW() ";


        mysqli_query($connection, $query) or die ("nope1");

        $date_id = mysqli_insert_id($connection);

        $query = "INSERT INTO quotes SET ";
        $query .= "creator_id = '{$_POST['promoter']}', ";
        $query .= "date_id = '{$date_id}', ";
        $query .= "venue_id = '{$_POST['venue']}', ";                    
            $time = date_parse_from_format("n-j-Y", $_POST['date']);
            $date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
        $query .= "redeemoutletid = '{$_POST['outlet']}', ";
        $query .= "affiliatelink = '{$_POST['link']}', ";
        $query .= "campaign_id = {$id}, ";
        $query .= "date = '{$date}', ";
        $query .= "accepted = 1, ";
        $query .= "recordstatus = '1', datecreated = NOW() ";

    		$result = mysqli_query($connection, $query) or die ("nope2");
    		if ($result && mysqli_affected_rows($connection) >= 0) {
    			 //Success
                $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'QuickDate Added', actionid = 3, identifier = '{$city}', identifierid = {$date_id}, recordstatus = 1, datecreated = NOW()";
                mysqli_query($connection, $query);
    			$_SESSION["message"] = "Date added.";
    			header("Location: ../routing.php?id={$id}");
    		} else {
    			 //Failure
    			$message = "Date not added.";
    		}
}

ob_flush();

?>