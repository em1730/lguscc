 <?php

include ('../config/db_config.php');
//include('import_pdf.php');
date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_archive'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";


    $docno = $_POST['doc_number'];
    $date = date('Y-m-d', strtotime($_POST['date']));
//    // $origin = $_POST['origin'];
//     $department = $_POST['department'];
    $status = 'ARCHIVED';

    $currentDir = getcwd();
    $uploadDirectory = "../upload_doctrack/";

    $errors = [];

    $fileExtensions = ['pdf'];

    $fileName = $_FILES['myFile']['name'];
    $fileSize = $_FILES['myFile']['size'];
    $fileTmpName = $_FILES['myFile']['tmp_name'];
    $fileType = $_FILES['myFile']['type'];
    $target_file = $uploadDirectory . basename($_FILES['myFile']['name']);
    $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // $fileExtension = strtolower(end(explode('.',$fileName)));
    $uploadPath = $uploadDirectory . basename($fileName);

    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed.";
    }
    if (empty($errors)) {
        $dipUpload = move_uploaded_file($fileTmpName, $uploadPath);


        if ($dipUpload) {
            $alert_msg1 .= ' 
       <div class="new-alert new-alert-success alert-dismissible">
           <i class="icon fa fa-success"></i>
           File has been uploaded;
       </div>     
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';


        } else {
            $alert_msg1 .= ' 
       <div class="new-alert new-alert-success alert-dismissible">
           <i class="icon fa fa-success"></i>
           An Error Occured;
       </div>     
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';

            $btnStatus = 'disabled';
            $btnNew = 'disabled';
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "Thses are the errors" . "\n";

        }
    }

   
   
    $update_outgoing_sql = "INSERT INTO tbl_archive SET 
    docno       =     :docno
    Filenames   =     :file
    office      =     :office
    -- origin = :orig,
    -- destination = :dest
    where docno = :code";
            
    $update_data = $con->prepare($update_outgoing_sql);
    $update_data->execute([
        ':stat'             => $status,
        // ':orig'             => $origin,
        // ':dest'             => $department,
        ':file'             => $fileName,
        ':code'             => $docno 
       
        ]);

    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    $btnPrint = 'enabled';
    }



   
    


?>