<?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
$alert_msg2 = '';
if (isset($_POST['insert_ordinance'])) {

    $ordinance = $_POST['ordinance_no'];
    $title = $_POST['ordinance_title'];
    $public_hearing = date('Y-m-d', strtotime($_POST['public_hearing']));
    $date_enacted = date('Y-m-d', strtotime($_POST['date_enacted']));
    $date_lce = date('Y-m-d', strtotime($_POST['date_lce']));
    $date_province = date('Y-m-d', strtotime($_POST['date_province']));
    $author = $_POST['author'];
    $category = $_POST['category'];

    // catch error for empty array select2
    if(empty($_POST['coauthor'])){
        $co_authors = "";
    }else{
        $co_authors  =  implode(",", $_POST['coauthor']);
    };

    // upload image
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

    // check if ordinance number is available to avoid duplciation
    $check_ordinance_no_sql = "SELECT * FROM ordinances where OrdinanceNumber = :ordinanceno";
        
    $ordinance_no_data = $con->prepare($check_ordinance_no_sql);
    $ordinance_no_data ->execute([
      ':ordinanceno' => $ordinance
    ]);

    if ($ordinance_no_data->rowCount() > 0){
        $alert_msg2 = ' 
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="icon fa fa-warning"></i>
            Ordinance Number already exist!
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

    $insert_ordinance_sql = "INSERT INTO ordinances SET 
        OrdinanceNumber     = :ordinanceNo,
        OrdinanceTitle      = :ordinanceTitle,
        DatePHearing        = :dateHearing,
        DateEnacted         = :dateEnacted,
        DateLCE             = :dateLCE,
        DateProvince        = :dateProvince,
        DateAdded           = now(),
        Author              = :author,
        CoAuthor            = :coauthors,
        Category            = :category,
        Filenames           = :filenames";

    $ordinance_data = $con->prepare($insert_ordinance_sql);
    $ordinance_data->execute([
        ':ordinanceNo'      => $ordinance, 
        ':ordinanceTitle'   => $title,
        ':dateHearing'      => $public_hearing,
        ':dateEnacted'      => $date_enacted,
        ':dateLCE'          => $date_lce, 
        ':dateProvince'     => $date_province,
        // ':dateNow'              => now() ,
        ':author'           => $author,
        ':coauthors'        => $co_authors,
        ':category'         => $category,
        ':filenames'        => $fileName
    ]);
   

    $alert_msg .= ' 
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i>
    New Ordinance has been added!
    </div>   
      ';

    $btnStatus = 'disabled';
    $btnNew = 'enabled';

}}

?>

