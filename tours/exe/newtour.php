<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 

    $username = $_SESSION["name"];
    $userid = $_SESSION["userid"];

    if (isset($_POST["submit"])) {

        $personnel = explode(", ", $_POST['personnel']);
        foreach ($personnel as $value) {
        $sql = "SELECT id FROM users WHERE email IN ('{$value}') ";
        $data = mysqli_query($connection, $sql);
        $newids[] = implode ("", mysqli_fetch_row($data));
        }
        $personnel_id = implode(", ", $newids) . ", " . $userid;

        $query  = "INSERT INTO campaigns SET ";
        $query .= " creatorid = {$userid}, ";
        if (!empty($_POST['name'])){
            $query .= "name = '{$_POST['name']}', ";
        }
        if (!empty($_POST['artist'])){
            $query .= "artist = '{$_POST['artist']}', ";
        }
        if (!empty($_POST['company'])){
            $query .= "company = '{$_POST['company']}', ";
        }
        if (!empty($_POST['personnel'])){
            $query .= "personnel = '{$personnel_id}', ";
        }
        if (!empty($_POST['description'])){
            $query .= "description = '{$_POST['description']}', ";
        }
        $query .= " recordstatus = 1, datecreated = NOW() ";

        //mysqli_query($connection, $query) or die("Nope");

        //$campaign_id =  mysqli_insert_id($connection);

        $campaign_id = 1
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : "";
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : "";
        $capacity = isset($_POST['capacity']) ? $_POST['capacity'] : "";
        $region = isset($_POST['region']) ? $_POST['region'] : "";
        $face_value = isset($_POST['face_value']) ? $_POST['face_value'] : "";
        $currency = isset($_POST['currency']) ? $_POST['currency'] : "";
        $seating = isset($_POST['seating']) ? $_POST['seating'] : "";
        $notes = isset($_POST['notes']) ? $_POST['notes'] : "";
        $guarantee = isset($_POST['guarantee']) ? $_POST['guarantee'] : "";

        $time = date_parse_from_format("n-j-Y", $start_date);
        $start_date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;
        $time = date_parse_from_format("n-j-Y", $end_date);
        $end_date = $time['year'] . "-" . $time['day'] . "-" .$time['month'] ;


        // Create new table entry
        $recordstatus = 1;
        $datecreated = "NOW()";

        $query = "INSERT INTO requirements SET (campaign_id, creator_id, " ;

            if (!empty($_POST['start_date'])){
                $query .= "start_date, ";
            }
            if (!empty($_POST['end_date'])){
                $query .= "end_date, ";
            }
            if (!empty($_POST['capacity'])){
                $query .= "capacity, ";
            }
            if (!empty($_POST['region'])){
                $query .= "region, ";
            }
            if (!empty($_POST['face_value'])){
                $query .= "face_value, ";
            }
            if (!empty($_POST['currency'])){
                $query .= "currency, ";
            }
            if (!empty($_POST['seating'])){
                $query .= "seating, ";
            }
            if (!empty($_POST['guarantee'])){
                $query .= "guarantee, ";
            }
            if (!empty($_POST['notes'])){
            $query .= "notes, ";
            }

           $query .= "recordstatus, datecreated) VALUES ('$campaign_id', '$userid',";

            if (!empty($_POST['start_date'])){
                $query .= "'$start_date', ";
            }
            if (!empty($_POST['end_date'])){
                $query .= "'$end_date', ";
            }
            if (!empty($_POST['capacity'])){
                $query .= "'$capacity', ";
            }
            if (!empty($_POST['region'])){
                $query .= "'$region', ";
            }
            if (!empty($_POST['face_value'])){
                $query .= "'$face_value', ";
            }
            if (!empty($_POST['currency'])){
                $query .= "'$currency', ";
            }
            if (!empty($_POST['seating'])){
                $query .= "'$seating', ";
            }
            if (!empty($_POST['guarantee'])){
                $query .= "'$guarantee', ";
            }
            if (!empty($_POST['notes'])){
            $query .= "'$notes', ";
            }
            $query .= "'$recordstatus', {$datecreated} )";
        // mysqli_query($connection, $query) or die();

        //header("Location: index.php");
    }


?>