 <?php

    include('../config/db_config.php');
    //include('import_pdf.php');

    session_start();
    
    $alert_msg = '';
    $alert_msg1 = '';
    if (isset($_POST['update_documenttype'])) {

        //     echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";
        $objid = $_POST['doc_code'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $idno2 = $_POST['idno'];
        // $status = $_POST['status'];

        $insert_doctype_sql = "UPDATE document_type SET 
        objid               = :code,
        type                = :type,
        description         = :desc
        -- status              = :status
        where idno          = :idno";

        $doctype_data = $con->prepare($insert_doctype_sql);
        $doctype_data->execute([
            ':idno'             => $idno2,
            ':code'             => $objid,
            ':type'             => $type,
            ':desc'             => $description
            // ':status'           => $status

        ]);


        if ($doctype_data) {

            $_SESSION['status'] = "Update Succesfully!";
            $_SESSION['status_code'] = "success";

            header('location: view_document.php?&idno=' . $idno2);
        } else {
            $_SESSION['status'] = "Update Unsuccessful!";
            $_SESSION['status_code'] = "error";

            header('location: view_document.php?&idno=' . $idno2);
        }
    }


    ?>