<?php include '../inc/db_connection.php'; ?>
<?php include '../inc/functions.php'; ?>
<?php include '../inc/permissions.php'; ?>
<?php include '../inc/config.php'; ?>
<?php include '../inc/template_start.php'; ?>

            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                    <h3>Client Invite</h3>
                    <p>Enter the name and email of the client you would like to invite...</p>
                    <form action="invite.php" method="post" class="form">
                        <div>
                            <div class="form-group">
                                <input type="text" name="firstname" class="form-control" placeholder="First Name" required value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" placeholder="Email" required value="" />
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary btn-hg" role="button" value="Send">
                        </div>
                    </form>
                </div>
            </div>
    </div>

<?php include '../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../js/pages/login.js"></script>
<script>$(function(){ Login.init(); });</script>

<?php include '../inc/template_end.php'; ?>