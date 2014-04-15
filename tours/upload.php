<?php include 'inc/db_connection.php'; ?>
<?php include 'inc/permissions.php'; ?>
<?php 
    
    $id = $_GET["id"];
    $userid = $_SESSION['userid'];
    
    $sql = "SELECT name, artist, company FROM campaigns WHERE id = {$id}";
                $data = mysqli_query($connection, $sql) or die();
                $info = mysqli_fetch_row($data);

            $filepath = "../img/tours/" . $id . "/" ;

            $upload_errors = array(
                UPLOAD_ERR_OK           => "",
                UPLOAD_ERR_INI_SIZE     => "Larger than upload_max_filesize.",
                UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
                UPLOAD_ERR_PARTIAL      => "Partial upload.",
                UPLOAD_ERR_NO_FILE      => "No file.",
                UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
                UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
                UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
                );

            if (isset($_POST['submit'])) {
                $error = $_FILES['file_upload']['error'];
                $message = $upload_errors[$error];

                $tmp_file = $_FILES['file_upload']['tmp_name'];
                $target_file = basename($_FILES['file_upload']['name']);
                $ext = pathinfo($target_file, PATHINFO_EXTENSION);

                        if (!file_exists($filepath)) {
                         mkdir($filepath, 0777, true);    }

                        $upload_dir = $filepath ;

                        if (isset($_POST['file_name'])) {
                            $filesendname = $_POST['file_name'] . "." . $ext;
                        } else {
                            $filesendname = $target_file;
                        }

                        if (move_uploaded_file($tmp_file, $upload_dir."/".$filesendname)) {
                            $message = "File uploaded succesfully.";

                                 $query  = "INSERT INTO documents SET  ";
                                 $query .= "campaign_id = '{$id}', ";
                                 if ($_POST['file_name']) {
                                        $name = $_POST['file_name'] . "." . $ext ;
                                    $query .= "name = '{$name}', ";
                                 } else {
                                    $query .= "name = '{$target_file}', ";
                                 }
                                 $query .= "file_path = '{$filepath}', ";
                                 $query .= "recordstatus = '1', datecreated = NOW() ";
                                
                            $result = mysqli_query($connection, $query) or die ();
                                    $insid = mysqli_insert_id($connection);
                                    $query = "INSERT INTO history SET campaignid = {$id}, actiondate = NOW(), action = 'Document Uploaded', actionid = 10, identifier = '{$name}', identifierid = {$insid}, recordstatus = 1, datecreated = NOW()";
                                    mysqli_query($connection, $query);
                        } else {
                            $error = $_FILES['file_upload']['error'];
                            $message = $upload_errors[$error];
                        }
            }

           header("Location: documents.php?id=$id");
?>