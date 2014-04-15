<?php require_once("../web/includes/session.php"); ?>
<?php require_once("../web/includes/db_connection.php"); ?>
<?php require_once("../web/includes/functions.php"); ?>
<?php 
session_destroy();

		$user_id = $_GET['id'];
		$campaign_id = $_GET['cid'];

		if (isset($_POST['submit'])){
					ob_start();

					session_start();
					$password = $_POST['password'];
					$hash = password_encrypt($password) ;

						$query = "UPDATE users SET ";
						$query .= "password = '{$hash}'";
						$query .= " WHERE id = '{$user_id}'";
						$query .= " LIMIT 1";

						mysqli_query($connection, $query); 
						
						header("Location: ../web/_routing/index.php?id=$campaign_id");

					ob_flush();
			}

		$que = "SELECT firstname, password FROM users WHERE id = {$user_id}";
		$quang = mysqli_query($connection, $que) 
		or die(mysql_error());
		$user = mysqli_fetch_row($quang);

		$name = $user[0];
		if (!is_null($user[1])) {
			header("Location: ../web/_routing/index.php?id=$campaign_id");
			session_start();
			$_SESSION['name'] = $name;
			$_SESSION['userid'] = $user_id;

		}

    mysqli_query($connection, "UPDATE campaigns SET personnel = CONCAT(personnel,', {$user_id}') WHERE id = {$campaign_id};");

//        header("Location: new_user.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Ei | New user</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="../web/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="../web/css/flat-ui.css" rel="stylesheet">

     <link href="../web/css/main.css" rel="stylesheet">

    <link rel="../shortcut icon" href="../web/images/favicon.ico">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
<div class="wrapping">
        <header>    
            <div>
                <nav class="navbar navbar-default navbar-static-top"> 
                    <ul class="nav">
                        <li><a href="#home"><img class="head-logo" src="../web/images/logo-inline.png"></a></li>
                    </ul>
                </nav>
                </nav>
            </div>
        </header>

    <div class="container">          
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                <div class="jumbotron">
                    <h3>Create password</h3>
                    <p><?php echo "Hello " . $name . ". Please enter a secure password below." ; ?></p>
                    <form action="new_promoter.php?id=<?php echo $user_id . '&cid=' . $campaign_id; ?>" method="post" class="form">
                        <div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required value="" />
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-hg" role="button" value="Send">
                        </div>
                    </form>
                </div>
            </div>
    </div>
    <!-- /.container -->
<?php require_once("../web/includes/footer.php"); ?>
</div>
    <!-- Load JS here for greater good =============================-->
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <script src="js/flatui-checkbox.js"></script>
    <script src="js/flatui-radio.js"></script>
    <script src="js/jquery.tagsinput.js"></script>
    <script src="js/jquery.placeholder.js"></script>
  </body>
</html>