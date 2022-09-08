<?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_update_ordinance'])) {

        // echo "<pre>";
        // print_r($_POST);
    // echo "</pre>";
    $ordinance2 = $_POST['ordinance_no2'];
    $ordinance = $_POST['ordinance_no'];
    $title = $_POST['ordinance_title'];
    $public_hearing = date('Y-m-d', strtotime($_POST['public_hearing']));
    $date_enacted = date('Y-m-d', strtotime($_POST['date_enacted']));
    $date_lce = date('Y-m-d', strtotime($_POST['date_lce']));
    $date_province = date('Y-m-d', strtotime($_POST['date_province']));
    $author = $_POST['author'];
    $coauthors = $_POST['coauthor'];
    $category = $_POST['category'];

    // catch error for empty array select2
    if(empty($_POST['coauthor'])){
        $coauthors = "";
    }else{
        $coauthors  =  implode(",", $_POST['coauthor']);
    };        

    if ($_FILES["myFile"]["error"] == 4){

        $insert_update_ordinance_sql = "UPDATE ordinances SET 
        OrdinanceNumber     = :ordinanceNo,
        OrdinanceTitle      = :ordinanceTitle,
        DatePHearing        = :dateHearing,
        DateEnacted         = :dateEnacted,
        DateLCE             = :dateLCE,
        DateProvince        = :dateProvince,
        -- DateAdded           = now(),
        Author              = :author,
        CoAuthor            = :coauthors,
        Category            = :category
                
        WHERE OrdinanceNumber  = :ordinanceNo2";

    $ordinance_data = $con->prepare($insert_update_ordinance_sql);
    $ordinance_data->execute([
        ':ordinanceNo'      => $ordinance,
        ':ordinanceTitle'   => $title,
        ':dateHearing'      => $public_hearing,
        ':dateEnacted'      => $date_enacted,
        ':dateLCE'          => $date_lce,
        ':dateProvince'     => $date_province,
        // ':dateNow'       => now() ,
        ':author'           => $author,
        ':coauthors'        => $coauthors,
        ':category'         => $category,
        
        ':ordinanceNo2'      => $ordinance2
          ]);

          $alert_msg .= ' 
          <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fa fa-check"></i>
          Ordinance has been updated!
          </div>     
            ';

     
            
            

    }else{

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
            <div class="alert alert-check alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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

    $insert_update_ordinance_sql = "UPDATE ordinances SET 
        OrdinanceNumber     = :ordinanceNo,
        OrdinanceTitle      = :ordinanceTitle,
        DatePHearing        = :dateHearing,
        DateEnacted         = :dateEnacted,
        DateLCE             = :dateLCE,
        DateProvince        = :dateProvince,
        -- DateAdded           = now(),
        Author              = :author,
        CoAuthor            = :coauthors,
        Category            = :category,
        Filenames           = :filenames
        
        WHERE OrdinanceNumber  = :ordinanceNo2";

    $ordinance_data = $con->prepare($insert_update_ordinance_sql);
    $ordinance_data->execute([
        ':ordinanceNo'      => $ordinance,
        ':ordinanceTitle'   => $title,
        ':dateHearing'      => $public_hearing,
        ':dateEnacted'      => $date_enacted,
        ':dateLCE'          => $date_lce,
        ':dateProvince'     => $date_province,
        // ':dateNow'       => now() ,
        ':author'           => $author,
        ':coauthors'        => $coauthors,
        ':category'         => $category,
        ':filenames'        => $fileName,

        ':ordinanceNo2'      => $ordinance2
          ]);

    $alert_msg .= ' 
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    Ordinance has been updated!
    </div>     
      ';


      }

     
    }
?>

