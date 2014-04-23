<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $userid = $_SESSION["userid"];
    $id = $_GET["id"];
    $date_id = $_GET["did"];

    $recordstatus = 1;
    $datecreated = "NOW()";

 if (isset($_POST['submit'])) {
        $query  = "INSERT INTO quotes SET ";
            if (!empty($_POST['creator'])) {
                $query .= "creator_id = '{$_POST['creator']}', ";
            } else {
                $query .= "creator_id = '{$_POST['user']}', ";}
            }
            if (!empty($_POST['routing_date'])) {
                $query .= "date_id = '{$_POST['routing_date']}', ";}
            if (!empty($_POST['venue'])) {
                $query .= "venue_id = '{$_POST['venue']}', ";}
    		if (!empty($_POST['capacity'])) {
    			$query .= "capacity = '{$_POST['capacity']}', ";}
            if (!empty($_POST['face_value'])) {
                $query .= "face_value = '{$_POST['face_value']}', ";}
            if (!empty($_POST['guarantee'])) {
                $query .= "guarantee = '{$_POST['guarantee']}', ";}                                
            if (!empty($_POST['date'])) {
                $time = date_parse_from_format("n-j-Y", $_POST['date']);
                    $date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
                    $query .= "date = '{$date}', ";
            }
		      $query .= "campaign_id = {$id}, ";
              $query .= "recordstatus = '1', datecreated = NOW() ";

    		$result = mysqli_query($connection, $query) or die ("nope");
            $insid = mysqli_insert_id($connection);

            $counter = sizeof($_POST['levels'])/4;
            for ($i=1; $i <= $counter ; $i++) {
                if ($i == 1) {
                    $j = "";
                } else {
                    $j = $i - 1;
                } 
                $output = "INSERT INTO quote_pricing SET ";
                $output .= " quote_id = {$insid} ";
                $output .= ", description = '{$_POST['levels']['pricename'.$j]}' ";
                $output .= ", min_price = {$_POST['levels']['min_value'.$j]} " ;
                $output .= ", max_price = {$_POST['levels']['max_value'.$j]} " ;
                $output .= ", capacity = {$_POST['levels']['cap'.$j]}, ";
                $output .= "recordstatus = 1, datecreated = NOW()";
                mysqli_query($connection, $output);
            }

        		if ($result && mysqli_affected_rows($connection) >= 0) {
        			 //Success
                    $cit = mysqli_query($connection, "SELECT r.city, u.firstname, u.lastname FROM routing AS r JOIN quotes AS q ON r.id = q.date_id JOIN users AS u ON q.creator_id = u.id WHERE q.id = {$insid} ") or die("Nein");
                    $city = mysqli_fetch_row($cit);
                    $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Submitted', actionid = 5, identifier = '{$city[0]} ({$city[1]} {$city[2]})', identifierid = {$insid}, recordstatus = 1, datecreated = NOW()";
                    mysqli_query($connection, $query);
        			$_SESSION["message"] = "Quote added.";
        			header("Location: ../quotes.php?id={$id}&did={$date_id}");
        		} else {
        			 //Failure
                    header("Location: ../quotes.php?id={$id}&did={$date_id}");
        			$_SESSION["message"] = "Quote failed.";
        		}
ob_flush();

?>