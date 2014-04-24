<?php include 'inc/config.php'; ?>
<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php include 'inc/template_start.php'; ?>
<?php include 'inc/page_head.php'; ?>
<?php 

    $id = $_GET['id'];
    $userid = $_SESSION["userid"];

    $sql = "SELECT campaigns.name, campaigns.artist, campaigns.company FROM campaigns WHERE id = {$id} ";
                $data = mysqli_query($connection, $sql) 
                    or die();
    $info = mysqli_fetch_row($data);

    $sql = "SELECT discussions.id, subject, participants, discussions.datecreated, discussions.datechanged, users.firstname, users.lastname FROM discussions\n"
    . "JOIN users ON discussions.discussion_creator_id = users.id\n"
    . "WHERE discussions.campaignid = {$id} AND discussions.recordstatus = 1";
    $data = mysqli_query($connection, $sql);
?>
<!-- Page content -->
<div id="page-content">
    <div class="content-header content-header-media">
        <div class="header-section">
            <img src="../img/placeholders/avatars/avatar2.jpg" alt="Avatar" class="pull-right img-circle">
            <h1><strong>Discussions</strong></h1><br>
            <h1><?php echo $info[1] ?> - <?php echo $info[0] ?><br><small><?php echo $info[2] ?></small></h1>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="../img/placeholders/headers/profile_header.jpg" <?php /* Put URL in here ( echo '../img/campaigns/' . $campaign_id . '/' . $image_name ;) ... */ ?> alt="header image" class="animation-pulseSlow">
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="tour.php?id=<?php echo $id ?>">Tour</a></li>
        <li>Discussions</li>
    </ul>

    <!-- Forum Block -->
    <div class="block">
    <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="new_desc.php?id=<?php echo $id; ?>" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="New"><i class="fa fa-plus"></i></a>
                    </div>
                    <h2><strong>Discussions</strong></h2>
                </div>
            <!-- Topics -->
            <div class="tab-pane-active" id="forum-topics">
                <table id="datatable" class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th colspan="2">Subject</th>
                            <th class="text-center hidden-xs hidden-sm" style="width: 100px;">Replies</th>
                            <th class="text-center hidden-xs hidden-sm" style="width: 100px;">Contributers</th>
                            <th class="hidden-xs hidden-sm" style="width: 200px;">Last Post</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    while ($dis = mysqli_fetch_row($data)) {
                        $dis[3] = date("d/m/Y", strtotime($dis[3]));    
                                $d = mysqli_query($connection, "SELECT COUNT(id) FROM discussion_responses WHERE discussion_id = $dis[0] AND recordstatus = 1 ");
                                $count = mysqli_fetch_row($d);

                                $sql = "SELECT u.firstname, u.lastname, d.response, DATE_FORMAT(d.datecreated, \"%D %M %Y at %r\") FROM discussion_responses AS d\n"
                                    . "JOIN users AS u ON d.contributer_id = u.id\n"
                                    . "WHERE d.datecreated = (SELECT MAX(datecreated) FROM discussion_responses WHERE discussion_id = {$dis[0]})\n"
                                    . "AND d.recordstatus = 1 ";
                                $daat = mysqli_query($connection, $sql);
                                $dat = mysqli_fetch_row($daat);
                        echo 
                        '<tr>
                            <td colspan="2">
                                <h4><a href="discussion.php?cid=' . $id . '&id='. $dis[0] .'"><strong>' . $dis[1] . '</strong></a> <br><small>' . $dis[5] . ' ' . $dis[6] . ' on <em>' . $dis[3] . '</em></small></h4>
                            </td>
                            <td class="text-center hidden-xs hidden-sm"><a href="javascript:void(0)">' . $count[0] . '</a></td>
                            <td class="text-center hidden-xs hidden-sm"><a href="javascript:void(0)">' . count(explode(",", $dis[2])) . '</a></td>
                            <td class="hidden-xs hidden-sm"><a href="page_ready_user_profile.php">' . $dis[4] . '</a><br> by '.$dat[0].' '.$dat[1].'<p><small>on '.$dat[3].'</small></p></td>
                            <td class="hidden-xs hidden-sm">
                                <div class="btn-group btn-group-xs" >
                                    <a href="exe/delete_disc.php?id=' . $id . '&did=' . $dis[0] . '" class="btn btn-danger" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

</div>
<?php include 'inc/page_footer.php'; ?>
<?php include 'inc/template_scripts.php'; ?>
<?php include 'inc/template_end.php'; ?>