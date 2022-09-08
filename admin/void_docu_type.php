<?php
session_start();

$alert_msg = '';

include('../config/db_config.php');

if (isset($_POST['void_docu_type'])) {



    // $get_date_register          = date('Y-m-d', strtotime($_POST['date_register']));
    $get_doc_id         = $_POST['void_doc_id'];
    $get_username       = $_POST['void_username'];   
    $get_status         = "VOID";

    $update_status_sql = "UPDATE document_type SET  
        void_username    = :username,
        status           = :status
        WHERE idno =  :entity ";

    $add_status_data = $con->prepare($update_status_sql);
    $add_status_data->execute([
        ':username'           => $get_username,
        ':idno'               => $get_doc_id,
        ':status'             => $get_status
    ]);


    if ($add_status_data) {

        $_SESSION['status'] = "Void Succesfully!";
        $_SESSION['status_code'] = "error";

        header('location: list_document_type.php');
    } else {
        $_SESSION['status'] = "Void Unsuccesful!";
        $_SESSION['status_code'] = "error";

        header('location: list_document_type.php');
    }
    
}
