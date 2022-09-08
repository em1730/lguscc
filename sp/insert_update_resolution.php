<?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_update_resolution'])) {

        // echo "<pre>";
        // print_r($_POST);
    // echo "</pre>";
    $resolution2 = $_POST['resolution_no2'];
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
   


    if ($_FILES["myFile"]["error"] == 4){

        $insert_update_resolution_sql = "UPDATE resolutions SET 

        ResolutionNumber = :resolutionNo,
        resolutionTitle = :retitle,
        DateAdopted     = :dateAdopted,
        DateApprovedLCE = :dateapprovelce,
        -- DateAdded    = now(),
        Author          = :author,
        CoAuthor        = :coauthor,
        Category        = :category
        
        WHERE ResolutionNumber = :resolutionNo2";
            
    $update_resolution_data = $con->prepare($insert_update_resolution_sql);
    $update_resolution_data->execute([

        ':resolutionNo'      => $resolution,
        ':retitle'           => $reTitle,
        ':dateAdopted'       => $dateadopted,
        ':dateapprovelce'    => $dateapprovelce,
         // ':dateNow'       => now() ,
        ':author'            => $author,
        ':coauthor'          => $coauthors,
        ':category'          => $category,
      
        ':resolutionNo2'      => $resolution2
     ]);

    $alert_msg .= ' 
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Resolution has been updated!
    </div>     
      ';
      

     } else {

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
       
        if (!in_array($fileExtension, $fileExtensions)) {
            $errors[] = "This file extension is not allowed.";
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
                echo $error . "These are the errors" . "\n";
            }
        }

    $insert_update_resolution_sql = "UPDATE resolutions SET 

        ResolutionNumber = :resolutionNo,
        resolutionTitle = :retitle,
        DateAdopted     = :dateAdopted,
        DateApprovedLCE = :dateapprovelce,
        -- DateAdded    = now(),
        Author          = :author,
        CoAuthor        = :coauthor,
        Category        = :category,
        Filenames       = :fname

        WHERE ResolutionNumber = :resolutionNo2";
            
    $update_resolution_data = $con->prepare($insert_update_resolution_sql);
    $update_resolution_data->execute([

        ':resolutionNo'      => $resolution,
        ':retitle'           => $reTitle,
        ':dateAdopted'       => $dateadopted,
        ':dateapprovelce'    => $dateapprovelce,
         // ':dateNow'       => now() ,
        ':author'            => $author,
        ':coauthor'          => $coauthors,
        ':category'          => $category,
        ':fname'             => $fileName,
      
        ':resolutionNo2'      => $resolution2
     ]);

    $alert_msg .= ' 
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Resolution has been updated!
    </div>     
      ';
      
      }
    }
?>

