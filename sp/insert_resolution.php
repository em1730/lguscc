<?php

include ('../config/db_config.php');
//include('importpdf.php');

$alert_msg = '';
$alert_msg1 = '';
$alert_msg2 = '';
if (isset($_POST['insert_resolution'])) {

    //    echo "<pre>";
    //     print_r($_POST);
    //  echo "</pre>";
    $resolution = $_POST['resolution_no'];
    $reTitle = $_POST['resolution_title'];
    $dateadopted = date('Y-m-d', strtotime($_POST['date_adopted']));
    $dateapprovelce = date('Y-m-d', strtotime($_POST['date_approvedlce']));
    $author = $_POST['author'];
    $category = $_POST['category'];

    // catch error for empty array select2
    if(empty($_POST['coauthor'])){
        $coauthors = "";
    }else{
        $coauthors  =  implode(",", $_POST['coauthor']);
    };    

    $currentDir = getcwd();
    $uploadDirectory = "../upload/";

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

    $check_resolution_no_sql = "SELECT * FROM resolutions where ResolutionNumber = :resolutionno";
    $resolution_no_data = $con->prepare($check_resolution_no_sql);
    $resolution_no_data ->execute([
      ':resolutionno' => $resolution
    ]);

    if ($resolution_no_data->rowCount() > 0){
        $alert_msg2 = ' 
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-warning"></i>
            Resolution Number already exist!
        </div>     
    ';

    }else{

    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "Warning!";
    }

    if (empty($errors)) {
        $dipUpload = move_uploaded_file($fileTmpName, $uploadPath);


        if ($dipUpload) {
            $alert_msg1 .= ' 
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-check"></i>
            File has been uploaded
            </div>  
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';


        } else {
            $alert_msg1 .= ' 
            <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            An Error Occured
            </div>      
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';

            $btnStatus = 'disabled';
            $btnNew = 'disabled';
        }
    } else {
        foreach ($errors as $error) {
            $alert_msg1 .= "
            <div class='alert alert-warning alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <i class='icon fa fa-warning'></i>
            $error No pdf Uploaded \n
            </div>  "
            ;
        }
    }

    $insert_resolution_sql = "INSERT INTO resolutions SET 
        ResolutionNumber    = :resolutionNo,
        resolutionTitle     = :resolutionTitle,
        DateAdopted         = :dateAdopted,
        DateApprovedLCE     = :dateApprovelce,
        Author              = :author,
        DateAdded           = now(),
        CoAuthor            = :coauthors,
        Category            = :category,
        Filenames           = :filenames";

    $resolution_data = $con->prepare($insert_resolution_sql);
    $resolution_data->execute([
        ':resolutionNo'      => $resolution,
        ':resolutionTitle'   => $reTitle,
        ':dateAdopted'       => $dateadopted,
        ':dateApprovelce'    => $dateapprovelce, 
        // ':dateNow'              => now() ,
        ':author'            => $author,
        ':coauthors'         => $coauthors,
        ':category'          => $category, 
        ':filenames'         => $fileName
        ]);
    $alert_msg .= ' 
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    New Resolution has been added!
    </div>     
      ';

    $btnStatus = 'disabled';
    $btnNew = 'enabled';

}
}

?>