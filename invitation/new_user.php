<?php require_once("../web/includes/session.php"); ?>
<?php require_once("../web/includes/db_connection.php"); ?>
<?php require_once("../web/includes/functions.php"); ?>
<?php 
        $id =   $_GET['id'];


$sql = "SELECT firstname FROM users WHERE id ={$id} ";
                $data = mysqli_query($connection, $sql) 
                    or die(mysql_error());
            $info = mysqli_fetch_row($data);

	$name = $info[0];


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
                    <form action="pw_create.php?id=<?php echo $id; ?>" method="post" class="form">
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