<?php

include 'includes/session.php';

if (isset($_POST['add'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $empID= $_POST['idno'];
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $committee = $_POST['committee'];
    $subcommittee = $_POST['subcommittee'];

    $currentDir = getcwd();
    $uploadDirectory = "../dist/pic/";

    $errors = [];

    $fileExtensions = ['png','jpg','jpeg'];

    $fileName = $_FILES['myFiles']['name'];
    $fileSize = $_FILES['myFiles']['size'];
    $fileTmpName = $_FILES['myFiles']['tmp_name'];
    $fileType = $_FILES['myFiles']['type'];
    $target_file = $uploadDirectory . basename($_FILES['myFiles']['name']);
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
       <div class="table-bordered">
           <i class="icon fa fa-success"></i>
           File has been uploaded
       </div>     
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';


        } else {
            $alert_msg1 .= ' 
       <div class="alert alert-warning alert-dismissible"">
           <i class="icon fa fa-warning"></i>
           An Error Occured;
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


   
    $insert_spmember_sql = "INSERT INTO sp_members SET 
        objid               = :code,
        fullname            = :fullname,
        contactno           = :contactno,
        email               = :email,
        location            = :filename,
        committee           = :committee,
        subcommittee        = :subcommittee";

    $spmember_data = $con->prepare($insert_spmember_sql);
    $spmember_data->execute([
        ':code'             => $empID, 
        ':fullname'         => $fullName,
        ':contactno'        => $contact_number,
        ':email'            => $email,
        ':filename'         => $fileName,
        ':committee'        => implode(" , ", $committee),
        ':subcommittee'     => implode(" , ", $subcommittee)
        
        ]);

        $_SESSION['success'] = "<i class='icon fa fa-check'></i>SP Member added successfully";
    
    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    
}
    header('location: sp_member.php');


?>