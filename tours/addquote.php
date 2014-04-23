<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<script>
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  console.log("yes 1");
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  console.log("yes 2");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("pullVenue").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","exe/pull_venue.php?q="+str,true);
console.log("yes 3");
xmlhttp.send();
console.log("yes 4");
}
</script>
<link rel="stylesheet" media="screen" type="text/css" href="../colorpicker/css/colorpicker.css" />
<?php 

    $id = $_GET["id"];
    $date_id = $_GET["did"];
    $userid = $_SESSION['userid'];

     $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company, requirements.* \n"
    . "FROM campaigns\n"
    . "JOIN requirements \n"
    . "ON campaigns.id = requirements.campaign_id WHERE campaigns.id = {$id}";
                $data = mysqli_query($connection, $sql) 
                    or die("problem with requirements");
                $info = mysqli_fetch_row($data);
               if (!empty($info)) {
                    switch ($info[6]) {
                        case "":
                            $info[6] = " - " ;
                            break;
                        case "0000-00-00":
                            $info[6] = " - " ;
                            break;
                        default:
                            $date = strtotime($info[6]);
                            $info[6] = date('d/m/Y', $date);
                            break;
                    }
                    switch ($info[7]) {
                        case "":
                            $info[7] = " - " ;
                            break;
                        case "0000-00-00":
                            $info[7] = " - " ;
                            break;
                        default:
                            $date = strtotime($info[7]);
                            $info[7] = date('d/m/Y', $date);
                            break;
                    }
                }
   
    $sql = "SELECT users.firstname, users.lastname, company.name, venue.name, quotes.date, quotes.capacity, quotes.face_value, quotes.guarantee, quotes.id, quotes.recordstatus, quotes.accepted, venue.id, quotes.datecreated, cast(quotes.datecreated as time), users.id \n"
    . "FROM quotes\n"
    . "JOIN venue ON quotes.venue_id = venue.id\n"
    . "JOIN users ON quotes.creator_id = users.id\n"
    . "JOIN company ON users.companyid = company.id\n"
    . "WHERE quotes.date_id = {$date_id} AND quotes.recordstatus = 1 ORDER BY company.name ";
    $quotes = mysqli_query($connection, $sql) or die();

    $sql = "SELECT city, countries.name, date, flexibility " 
     . " FROM routing "
     . " LEFT JOIN countries on routing.country = countries.code "
     . " WHERE id = {$date_id} ";

        $data = mysqli_query($connection, $sql) or die(mysql_error());
        $reqs = mysqli_fetch_row($data);
        $date = $reqs[2];
        $reqs[2] = date("d/m/Y", strtotime($date));

                            switch ($reqs[3]) {
                                case "0":
                                    $reqs[3] = "None" ;
                                    break;
                                case "1":
                                    $reqs[3] = "1 Day" ;
                                    break;
                                case "2":
                                    $reqs[3] = "3 Days" ;
                                    break;
                                case "3":
                                    $reqs[3] = "1 Week" ;
                                    break;
                                case "4":
                                    $reqs[3] = "2 Weeks" ;
                                    break;
                                default:
                                    $reqs[3] = "None" ;
                                    break;
                            }

        $seeq = mysqli_query($connection, "SELECT COUNT(id) FROM quotes WHERE date_id = {$date_id}");
        $count = mysqli_fetch_row($seeq);
        $count = $count[0];
?>
<!-- Page content -->
<div id="page-content">
    <!-- Table Responsive Header -->
   <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Quotes</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id; ?>"> Tour</a></li>
        <li><a href="routing.php?id=<?php echo $id; ?>"> Routing</a></li>
        <li><a href="quotes.php?id=<?php echo $id . '&did=' . $date_id ; ?>"> Quotes</a></li>
        <li>Add Quote</li>
    </ul>
    <!-- END Table Responsive Header -->

    <div class="row">
        <div class="col-md-6 col-lg-7">
        <div class="block">
                <!-- Horizontal Form Title -->
                <div class="block-title">
                    <h2><strong>Add</strong> Quote</h2>
                </div>
                <form action="exe/add_quote.php?id=<?php echo $id . '&did=' . $date_id ; ?>" method="post" class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-md-3 control-label"><span id="addFields" class="btn btn-xs btn-primary" title="Toggle optional fields"><i class="gi gi-circle_plus"></i></span></label>
                        <div class="col-md-9">
                            <p class="form-control-static">Quote already agreed? Add promoter...</p>
                        </div>
                    </div>
                    <div class="form-group tog" style="display: none">
                            <label class="col-md-3 control-label" for="creator">Promoter</label>
                                <div class="col-md-9">
                                    <select name="creator" class="select-chosen">
                                    <option value="0">Select a Promoter...</option>
                                                <?php 
                                                    $sq = "SELECT u.id, u.firstname, u.lastname, c.name, c.id FROM users AS u
                                                            JOIN company AS c ON u.companyid = c.id
                                                            WHERE companytypeid = 2";
                                                    $in = mysqli_query($connection, $sq);
                                                    while ($prom = mysqli_fetch_row($in))
                                                    echo '<option value="' . $prom[0] . '">' . $prom[1] . ' ' . $prom[2] . ' (' . $prom[3] . ')</option>';
                                                ?>
                                    </select>
                                    <span class="help-block">NB: This will create a confirmed quote</span>
                                </div>
                        </div>
                <div class="form-group">
                        <label class="col-md-3 control-label" for="venue">Venue</label>
                        <div class="col-md-9">
                            <select id="venue" name="venue" onchange="showUser(this.value)" class="select-chosen">
                                    <option value="0">Select a Venue...</option>
                                    <?php 
                                        $in = mysqli_query($connection, "SELECT id, name FROM venue ORDER BY name");
                                        while ($venue = mysqli_fetch_row($in))
                                        echo '<option value="' . $venue[0] . '">' . $venue[1] . '</option>';
                                    ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="col-md-3 control-label" for="date"></label>
                        <div class="col-md-9">
                        Not listed?
                            <a href="../venues/new.php" class="btn btn-xs btn-primary">Add New</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="date">Date</label>
                        <div class="col-md-9">
                            <input type="text" id="date" name="date" class="form-control input-datepicker" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="guarantee">Guarantee</label>
                        <div class="col-md-9">
                            <textarea type="text" id="guarantee" rows="2" name="guarantee" class="form-control"></textarea>
                        </div>
                    </div>
                    <legend></legend>
                    <div class="form-group">
                    <label class="col-md-3 control-label"><big>Price Breaks</big></label>
                        <div class="col-md-12">
                            <table class="table table-borderless table-striped">
                                    <tr>
                                        <th><small>Colour</small></th>
                                        <th><small>Description</small></th>
                                        <th><small>Face Value</small></th>
                                        <th><small>Capacity</small></th>
                                        <th></th>
                                    </tr>
                                <tbody id="breakAdd">
                                    <tr>
                                        <td><input id="colorPick" size="2"><input id="takeHex" size="2" hidden></td>
                                        <td><input size="20" name="levels[pricename]" required></td>
                                        <td><input size="5" name="levels[min_value]" required> to <input size="5" name="levels[max_value]" required></td>
                                        <td><input size="5" name="levels[cap]" required></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="btn-group">
                                <button id="AddMoreFileBox" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Add Field"><i class="gi gi-circle_plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <legend></legend>
                    <input class="form-control" value="<?php echo $id ; ?>" name="campaign" type="hidden"></input>
                    <input class="form-control" value="<?php echo $userid ; ?>" name="user" type="hidden"></input>
                    <input class="form-control" value="<?php echo $date_id ; ?>" name="routing_date" type="hidden"></input>
                    <div class="form-group form-actions">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="gi gi-chat"></i> Add</button>
                            <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 col-lg-5">
            <div id="pullVenue"></div>
            <div class="block">
                <!-- Block with Options Left Title -->
                <div class="block-title clearfix">
                    <h2 class="pull-right"><small><a href="javascript:void(0)" data-toggle="tooltip" title="Download requirements PDF"> <i class="fa fa-file-text text-primary"></i> PDF</a></small> &bull; <strong>Tender</strong> Request</h2>
                </div>
                <!-- END Block with Options Left Title -->

                <!-- Block with Options Left Content -->
                <!-- Info Content -->
                <table class="table table-borderless table-striped">
                    <tr>
                        <th><small>Timeframe</small></th>
                        <th><small>Location</small></th>
                        <th><small>Flexibility</small></th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><span><strong><?php echo $reqs[2] ?></strong></span></td>
                            <td><span><strong><?php echo $reqs[0] . ", " . $reqs[1]; ?></strong></span></td>
                            <td><span><strong><?php echo $reqs[3] ?></strong></span></td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Requirements Content -->
                <!-- END Block with Options Left Content -->
            </div>
            <div class="block">
                <!-- Reqs Title -->
                <div class="block-title">
                    <h2 class="pull-right"><strong>Tour</strong> Requirements</h2>
                </div>
                <table class="table table-borderless table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Timeframe: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[6] ?></strong> to <strong><?php echo $info[7] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Capacity: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[8] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><strong>Region: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[9] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Base Currency: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[10] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Avg. Face Value: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[11] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Seating: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[13] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td><strong>Guarantee: </strong></td>
                            <td><span class="pull-right"><strong><?php echo $info[12] ?></strong></span></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"><strong>Notes</strong></td>
                            <td><?php echo $info[14] ?></td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Requirements Content -->
            </div>
            <!-- END Requirements Block -->
        </div>
    </div>
</div>
<!-- END Page Content -->

<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<script type="text/javascript">
    $(function(){

        $( "#addFields" ).click(function() {
          $( ".tog" ).toggle("fast");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

var MaxInputs       = 8; //maximum input boxes allowed
var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
var AddButton       = $("#AddMoreFileBox"); //Add button ID

var x = InputsWrapper.length; //initlal text box count
var FieldCount=1; //to keep track of text box added

$(AddButton).click(function (e)  //on add input button click
{
        if(x <= MaxInputs){
            FieldCount++; //text box added increment
            var fieldIndex = FieldCount - 1;
            $('#breakAdd').append('<tr id="getRidOf" align="left"><td><input id="colorPick" size="2"><input id="takeHex" size="2" hidden></td><td><input size="20" name="levels[pricename'+fieldIndex+']" required></td><td><input size="5" name="levels[min_value'+fieldIndex+']" required> to <input size="5" name="levels[max_value'+fieldIndex+']" required><td><input size="5" name="levels[cap'+fieldIndex+']" required></td><td><button id="removeclass" class="btn btn-xs btn-default" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button></td></tr>');
            x++; //text box increment
        }
return false;
});
    $("body").on("click","#removeclass", function(e){ //user click on remove text
            if( x >= 1 ) {
                    $('#getRidOf').remove(); //remove text box
                    x--; //decrement textbox
            }
    return false;
    }) 
});
</script>
<script type="text/javascript" src="../colorpicker/js/colorpicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#colorPick').ColorPicker({
        color: '#0000ff',
    onShow: function (colpkr) {
        $(colpkr).fadeIn(500);
        return false;
    },
    onHide: function (colpkr) {
        $(colpkr).fadeOut(500);
        return false;
    },
    onChange: function (hsb, hex, rgb) {
        $('#colorPick').css('backgroundColor', '#' + hex);
        $('#takeHex').val('#' + hex);
        console.log(hex);
    }
    });
});
</script>
<?php include 'inc/template_end.php'; ?>