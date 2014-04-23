<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

    $userid = $_SESSION["userid"];
    $id = $_GET["id"];
    $quote_id = $_GET['qid'];

 if (isset($_POST['submit'])) {
        $query  = "UPDATE quotes SET ";
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
              $query .= "datechanged = NOW() WHERE id = {$quote_id}";

    		$result = mysqli_query($connection, $query);

            mysqli_query($connection, "DELETE FROM `quote_pricing` WHERE quote_id = {$quote_id}");
            foreach ($_POST['levels'] as $value) {
                $output = "INSERT INTO quote_pricing SET ";
                $output .= " quote_id = {$quote_id}, ";
                $output .= " description = '{$value['pricename']}', ";
                $output .= " min_price = {$value['min_value']}, " ;
                $output .= " max_price = {$value['max_value']}, " ;
                $output .= " capacity = {$value['cap']}, ";
                $output .= "recordstatus = 1, datecreated = NOW()";
                mysqli_query($connection, $output);
            }

         if ($result && mysqli_affected_rows($connection) >= 0) {
         	 //Success
                   $cit = mysqli_query($connection, "SELECT r.city, u.firstname, u.lastname, r.id FROM routing AS r JOIN quotes AS q ON r.id = q.date_id JOIN users AS u ON q.creator_id = u.id WHERE q.id = {$quote_id} ") or die("Nein");
                   $city = mysqli_fetch_row($cit);
                   $date_id = $city[3];
                   $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Changed', actionid = 5, identifier = '{$city[0]} ({$city[1]} {$city[2]})', identifierid = {$quote_id}, recordstatus = 1, datecreated = NOW()";
                   mysqli_query($connection, $query);
         	$_SESSION["message"] = "Quote added.";
         	header("Location: ../quotes.php?id={$id}&did={$date_id}");
         } else {
         	 //Failure
                 header("Location: ../quotes.php?id={$id}&did={$date_id}");
        		 	$_SESSION["message"] = "Quote failed.";
        		  }
            }
ob_flush();

?>