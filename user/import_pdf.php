<?php

  include('../config/db_config.php');

  $alert_msg1 = '';   

 if (isset($_POST['submit'])){

    $ordinance = $_POST['ordinance_no'];
    $title = $_POST['ordinance_title'];
    $public_hearing = date('Y-m-d', strtotime($_POST['public_hearing']));
    $date_enacted = date('Y-m-d', strtotime($_POST['date_enacted']));
    $date_lce = date('Y-m-d', strtotime($_POST['date_lce']));
    $date_province = date('Y-m-d', strtotime($_POST['date_province']));
    $author = $_POST['author'];
    $co_authors = $_POST['coauthor'];
    $category =  $_POST['category'];

    // echo "<pre>";
    //    print_r($_POST);
    //  echo "</pre>";

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

         if (! in_array($fileExtension, $fileExtensions)){
             $errors[] = "This file extension is not allowed.";
         }
         if (empty($errors)){
            $dipUpload = move_uploaded_file($fileTmpName,$uploadPath);
         

         if($dipUpload) {
            $alert_msg1 .= ' 
            <div class="new-alert new-alert-success alert-dismissible">
                <i class="icon fa fa-success"></i>
                File has been uploaded;
            </div>     
        ';
       // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';
  
       $btnStatus = 'enabled';
       $btnNew = 'disabled';
       
            
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
 }
?>