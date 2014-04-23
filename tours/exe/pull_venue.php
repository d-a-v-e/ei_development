<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php 
$q = $_GET['q'];
$sql="SELECT name FROM venue WHERE id = {$q} ";
$result = mysqli_query($connection, $sql);
$ven = mysqli_fetch_row($result);
$sql="SELECT name, seating, standing, mixed_seating, mixed_standing FROM venue_levels WHERE venueid = {$q} ";
$result = mysqli_query($connection, $sql);

if ($q != 0) {
echo '<div class="block">
        <div class="block-title clearfix">
            <h2 class="pull-right"><strong>Levels:</strong> ' . $ven[0] . '</h2>
        </div>
            <table class="table table-borderless table-striped">';
                if ($result && mysqli_affected_rows($connection) > 0) {
                        echo '
                                <thead>
                                    <tr  align="right">
                                        <td  align="left"><strong>Level</strong></td>
                                        <td><strong>Seated</strong></td>
                                        <td><strong>Standing</strong></td>
                                        <td><strong>Mixed <small>(Seats/Stand)</small></strong></td>
                                    </tr>
                                </thead>
                            <tbody>';

                        while ($levels = mysqli_fetch_row($result)) {
                            echo 
                                '
                                <tr>
                                    <td><strong>' . $levels[0] . '</strong></td>
                                    <td  align="right">' . $levels[1] . '</td>
                                    <td  align="right">' . $levels[2] . '</td>
                                    <td  align="center">' . $levels[3] . '/' . $levels[4] . '</td>
                                </tr>
                                ';
                        }
                    } else {
                        echo
                        '<h4>(None)</h4>
                        <strong><a href="../venues/levels.php?id=' . $q . '"> + Add</a></strong>';
                    }
                echo '</table>
                </div>';
}

?>
