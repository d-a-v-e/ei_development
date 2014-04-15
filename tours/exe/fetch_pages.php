<?php include '../../inc/db_connection.php'; ?>
<?php include '../../inc/permissions.php'; ?>
<?php 
$themes = array ("", "fire", "night", "modern", "autumn", "amethyst", "flatie", "", "", "spring", "", "", "", "", "fancy");
$icons = array ("", "fa fa-suitcase", "fa fa-book", "gi gi-airplane", "fa fa-comment", "hi hi-usd", "fa fa-comment", "fa fa-comments", "", "", "hi hi-file", "", "", "", "gi gi-user");
$link = array ("", "tour", "requirements", "routing", "discussions", "quotes", "quotes", "quotes", "venue", "quotes", "documents", "venues", "venues", "venues", "quotes");

$id = $_POST["id"];
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$item_per_page = filter_var($_POST["items"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
//throw HTTP error if page number is not valid
if(!is_numeric($page_number)){
    header('HTTP/1.1 500 Invalid page number!');
    exit();
}
//get current starting point of records
$position = ($page_number * $item_per_page);

$sql = "SELECT h.id, h.action, DATE(h.actiondate), h.identifier, l.name, h.actionid, h.identifierid FROM history AS h JOIN lists AS l ON l.id = h.actionid WHERE campaignid = {$id} and l.listid = 3 ORDER BY h.actiondate DESC LIMIT {$position}, {$item_per_page}";
//Limit our results within a specified range. 
$results = mysqli_query($connection, $sql);

//output results from database
$counter = "";
while($row = mysqli_fetch_array($results)){
	$theme = $themes[$row[5]];
	$icon = $icons[$row[5]];
	$date = strtotime($row[2]);
	$row[2] = date('d/m/Y', $date);
	if ($counter == $row[5]) {
        echo '<div class="timeline-time"><small>'.$row[2].'</small></div>                                
                <div class="timeline-content">
                    <p class="push-bit"><strong>'.$row[1].': </strong> '.$row[3].'</p>';
		    if ($row[5] == '10') {
				$ext = pathinfo($row[3], PATHINFO_EXTENSION);
				if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
					echo '<div class="col-sm-6 col-md-4">
			                        <a href="../img/tours/'.$id.'/'.$row[3].'" data-toggle="lightbox-image">
			                            <img src="../img/tours/'.$id.'/'.$row[3].'" alt="image">
			                        </a>
			                    </div>
		                    <div class="row push"></div>';
		            } else {
		            	echo '<div class="col-sm-6 col-md-4">
			                        <a href="../img/tours/'.$id.'/'.$row[3].'" data-toggle="lightbox-image">
			                            <img src="../img/placeholders/avatars/avatar.jpg" alt="image">
			                        </a>
			                    </div>
		                    <div class="row push"></div>';
		            }
		       }
		echo '</div>';
	} else {
        echo '<li class="active" id="item_'.$row[0].'">
	        		<div class="timeline-icon themed-background-'.$theme.' themed-border-'.$theme.'"><i class="'.$icon.'"></i></div>
		            <div class="timeline-content">
			            <p class="push-bit"><a href="'.$link[$row[5]].'.php?id='.$id.'"><strong>'.$row[4].'</strong></a></p>
		            </div>
		            <div class="timeline-time"><small>'.$row[2].'</small></div>
		            <div class="timeline-content">
		                <p class="push-bit"><strong>'.$row[1].': </strong> '.$row[3].'</p>';
		    if ($row[5] == '10') {
				$ext = pathinfo($row[3], PATHINFO_EXTENSION);
				if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif'  || $ext == 'bmp') {
					echo '<div class="col-sm-6 col-md-4">
			                        <a href="../img/tours/'.$id.'/'.$row[3].'" data-toggle="lightbox-image">
			                            <img src="../img/tours/'.$id.'/'.$row[3].'" alt="image">
			                        </a>
			                    </div>
		                    <div class="row push"></div>';
		            } else {
		            	echo '<div class="col-sm-6 col-md-4">
			                        <a href="../img/tours/'.$id.'/'.$row[3].'" data-toggle="lightbox-image">
			                            <img src="../img/placeholders/avatars/avatar.jpg" alt="image">
			                        </a>
			                    </div>
		                    <div class="row push"></div>';
		            }
		       }
       }
		echo '</div>';
	if ($counter !== $row[5]) {
		echo '</li>';
	}
	$counter = $row[5];
}
?>
<?php include '../inc/template_scripts.php'; ?>