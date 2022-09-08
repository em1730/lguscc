 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_ordinance'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $ordinance = $_POST['ordinance_no'];
    $title = $_POST['ordinance_title'];
    $public_hearing = date('Y-m-d', strtotime($_POST['public_hearing']));
    $date_enacted = date('Y-m-d', strtotime($_POST['date_enacted']));
    $date_lce = date('Y-m-d', strtotime($_POST['date_lce']));
    $date_province = date('Y-m-d', strtotime($_POST['date_province']));
    $author = $_POST['author'];
    $co_authors = $_POST['coauthor'];
    $category = $_POST['category'];


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
    $ordinance_data->execute([':ordinanceNo' => $ordinance, ':ordinanceTitle' => $title,
        ':dateHearing' => $public_hearing, ':dateEnacted' => $date_enacted, ':dateLCE' =>
        $date_lce, ':dateProvince' => $date_province,
        // ':dateNow'              => now() ,
        ':author' => $author, ':coauthors' => implode(",", $co_authors), ':category' =>
        $category, ':filenames' => $fileName]);
    $alert_msg .= ' 
          <div class="new-alert new-alert-success alert-dismissible">
              <i class="icon fa fa-success"></i>
              Data Inserted
          </div>     
      ';

    $btnStatus = 'disabled';
    $btnNew = 'enabled';

}

?>