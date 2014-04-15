<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<style type="text/css">
    #overlay { visibility: hidden; }
</style>
<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-brush"></i>Blank<br><small>A clean page to help you start!</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="">Blank</a></li>
    </ul>
    <!-- END Blank Header -->

    <!-- Example Block -->
    <div class="block">
        <!-- Example Title -->
        <div class="block-title">
            <h2>(Optional) Add date details</h2>
        </div>
        <div>
        <button>Add extra fields</button>
        </div>
        <!--a href="http://www.bandsintown.com/pond" class="bit-widget-initializer" data-artist="pond">Bandsintown</a-->
        <form action="exe/add_date.php?id=<?php echo $id; ?>" method="post" class="form-horizontal" >
                    <div class="form-group tog" style="display: none">
                    <legend></legend>
                        <label class="col-md-3 control-label" for="country">Promoter</label>
                        <div class="col-md-9">
                            <input type="text" id="promoter" class="form-control">
                        </div>
                    </div>
                    <div class="form-group tog" style="display: none">
                        <label class="col-md-3 control-label" for="country">Venue</label>
                        <div class="col-md-9">
                            <input type="text" id="venue" class="form-control">
                        </div>
                    </div>
                </form>
    </div>
    <!-- END Example Block -->
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<script type='text/javascript' src='http://www.bandsintown.com/javascripts/bit_widget.js'></script>
<script>
$( "button" ).click(function() {
  $( ".tog" ).toggle("fast");
});
</script>
<?php include 'inc/template_end.php'; ?>