<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php

ob_start();

	$campaign_id = $_GET['id']; 
	$user_id = $_GET['uid'];

$que = "SELECT companyid FROM users WHERE id = {$user_id}";
$da = mysqli_query($connection, $que) 
		or die(mysql_error());
		$da = mysqli_fetch_row($da);
		$comp_id = $da[0];

$que = "SELECT name FROM company WHERE id = {$comp_id}";
$da = mysqli_query($connection, $que) 
		or die();
		$da = mysqli_fetch_row($da);
		$user_company = $da[0];


$que = "SELECT name, artist, company  FROM campaigns WHERE id = {$campaign_id}";
$da = mysqli_query($connection, $que) 
		or die(mysql_error());

                   $camps = mysqli_fetch_row($da);

                   $campaign = $camps[0];
                   $artist = $camps[1];
                   $label = $camps[2];

$query = "SELECT firstname, lastname FROM users WHERE id = {$user_id}";
$da = mysqli_query($connection, $query) 
		or die();
$nam = mysqli_fetch_row($da);
$username = $nam[0] . " " . $nam[1];

$promos = "";

$query = "SELECT date_id, promoter_id, id, invited FROM routing_promoters WHERE campaign_id = {$campaign_id}";
$data = mysqli_query($connection, $query) 
		or die();

$sql = "SELECT * FROM requirements WHERE campaign_id = {$campaign_id}";
                $dat = mysqli_query($connection, $sql) 
                    or die();
                   $requirements = mysqli_fetch_row($dat);

 $requirements_table = '<table style="font-family:lato;padding:20px;border-top-left-radius:10px; border-top-right-radius:10px; background-color: #bdc3c7; width: 600px;"><tbody style="color:#000;"><div style="border-top-left-radius:2em; border-top-right-radius:2em; background-color: #fff;"><tr style="color:#16a085;"><td><h3>Requirements</h3></td></tr></div>'; 		
 $requirements_table .= '<tr><td><p><strong>Start Date: </strong></p></td>' ;
 $requirements_table .= '<td><p>' . $requirements[3] . '</p></td><td><p><strong>End Date: </strong></p></td>';
 $requirements_table .= '<td><p>' . $requirements[4] . '</p></td></tr><tr><td><p><strong>Base Currency:</strong></p></td><td><p>' . $requirements[7] . '</p></td><td><p><strong>Avg FV: </strong></p></td><td><p>' . $requirements[8] . '</p></td></tr><tr><td><p><strong>Region: </strong></p></td><td><p>' . $requirements[6] . '</p></td><td><p></p></td><td><p></p></td></tr><tr><td><p><strong>Avg Capacity: </strong></p></td><td><p>' . $requirements[5] . '</p></td><td><p><strong>Seating: </strong></p></td><td><p>' . $requirements[10] . '</p></td></tr><tr><td><p><strong>Guarantee: </strong></p></td><td><p>' . $requirements[9] . '</p></td><td><p><strong>Notes: </strong></p></td><td><p>' . $requirements[11] . '</p></td></tr></tbody></table>' ;

$headers = "From: welcome@entertainment-intelligence.com" . "\r\n";
$headers  .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


		while ($dates = mysqli_fetch_row($data)) {
			$routing_promoter_id = $dates[2];
			$is_invited = $dates[3];

			if (!empty($dates[0])){

			// JUST NEED PROMOTER NAME

					$que = "SELECT company.name, office.office_name, users.firstname, users.lastname FROM company, office, users WHERE company.id = $dates[1]";
					$d = mysqli_query($connection, $que) 
					or die();
					$name = mysqli_fetch_row($d);


						$que = "SELECT firstname, lastname, email, id FROM users WHERE companyid = $dates[1]";
					$quang = mysqli_query($connection, $que) 
					or die();
					$user = mysqli_fetch_row($quang);

					$mail =	'<!DOCTYPE html><html lang="en"><body><div style="font-family:lato;padding:20px;border-radius:10px; border: 2px solid black; width: 600px; margin: 0 auto;"><div style="font-family:lato;padding:0px;border-radius:10px;"><div><img src="http://www.entertainment-intelligence.com/prototype/web/images/logo-inline.png" alt="Logo" /></div><h2>Hello ' . $user[0] . ' (' . $name[0] . '),</h2><p>You have been invited by ' . $username . ' (' . $user_company . ') to promote dates for ' . $artist .': ' . $campaign .', by ' . $label . '.</p></div>' . $requirements_table . '<table cellpadding="5" style="font-family:lato;padding:20px; border-bottom-left-radius:10px; border-bottom-right-radius:10px; background-color: #bdc3c7; width: 600px;"><tbody style="color:#000;"><tr style="color:#16a085;"><td><h3>Dates</h3></td></tr><tr><td><strong>City</strong></td><td><strong>Location</strong></td><td><strong>Timeframe</strong></td><td><strong>Flexibility</strong></td></tr>';

						$dates = rtrim($dates[0], ',');
						$dates = explode(",", $dates);
						foreach ($dates as $key => $value) {

							$quer = "SELECT routing.city, routing.date, routing.flexibility, countries.name FROM routing";
							$quer .= " INNER JOIN `countries` on countries.code = routing.country\n";
							$quer .= " WHERE id = {$value}";

							$dat = mysqli_query($connection, $quer);
							$route = mysqli_fetch_row($dat);

							$date = $route[1];
							$date = date("d/m/Y", strtotime($date));
							
							switch ($route[2]) {
								case 0:
									$route[2] = "None";
									break;
								case 1:
									$route[2] = "1 Day";
									break;
								case 2:
									$route[2] = "3 Days";
									break;
								case 3:
									$route[2] = "1 Week";
									break;
								case 4:
									$route[2] = "2 Weeks";
									break;
								default:
									$route[2] = "N/A";
									break;
							}
							$mail .= "<tr><td>" . $route[0] . "</td><td>" . $route[3] . "</td><td>" . $date . "</td><td>" . $route[2] . "</td></tr>"; 
						}

						//$link = "<a href='http://entertainment-intelligence.com/prototype/invitation/new_promoter.php?id=" . $user[3] . "&cid=" . $campaign_id . " '>Click here to view online</a>";
						$link = "<a href='http://127.0.0.1:8888/proto/invitation/new_promoter.php?id=" . $user[3] . "&cid=" . $campaign_id . " '>Click here to view online</a>";
						$mail .= '<br></tbody></table><br><p>' . $link . '</div></body></html><br>';
						$mail_to = $user[2];

					$subject = 'Invite to promote an Ei campaign for '. $user[0] . " " . $user[1] ;
					
					if (is_null($is_invited)) {
					$promos .= $user[0] . ' ' . $name[0] . '), ';
					//mail($mail_to, $subject, $mail, $headers);
					echo $mail . "<br>" ;
					echo $link . "<br>" ;
					}
					$sq = "UPDATE campaigns SET personnel = CONCAT(personnel, ', {$user[3]}') WHERE id = {$campaign_id}";
					mysqli_query($connection, $sq);
					mysqli_query($connection, "UPDATE routing_promoters SET invited = NOW() WHERE id = {$routing_promoter_id}");
					}
				}
	$query = "INSERT INTO history SET campaignid = {$campaign_id}, actiondate = NOW(), action = 'Promoters Invited', actionid = 14, identifier = '{$promos}', identifierid = {$campaign_id}, recordstatus = 1, datecreated = NOW()";
	mysqli_query($connection, $query);
$_SESSION['message'] = "Promoters invited";
//header("Location: index.php?id={$campaign_id}");
ob_flush();