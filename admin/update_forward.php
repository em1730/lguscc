 <?php

    include('../config/db_config.php');
    //include('import_pdf.php');
    session_start();

 

    date_default_timezone_set('Asia/Manila');


    if (isset($_POST['update_forward'])) {

        //     echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";
        $docno = $_POST['doc_number'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $time =  date('H:i:s');
        $department = $_POST['department'];
        $type = $_POST['type'];
        $destination = $_POST['receiver'];
        $particulars = $_POST['particulars'];
        $remarks = $_POST['remarks'];
        $user_name = $_POST['username'];
        $status = 'FORWARDED';

        $update_outgoing_sql = "UPDATE tbl_documents SET 
                status = :stat, 
                date = :date,
                type = :type,
                origin = :dept,
                destination = :dest,
                particulars = :part,
                remarks = :rem
                where docno = :code";

        $update_data = $con->prepare($update_outgoing_sql);
        $update_data->execute([
            ':stat'             => $status,
            ':type'             => $type,
            ':date'             => $date,
            ':dept'             => $department,
            ':dest'             => $destination,
            ':part'             => $particulars,
            ':rem'              => $remarks,
            ':code'             => $docno
        ]);


        $insert_ledger_sql = "UPDATE tbl_ledger SET 
            txndate            = :datecreated,
            time                =:time,
            type               = :type,
            particulars        = :particular,
            origin             = :orig,
            destination        = :destination,
            -- amount             = :amount,
            status             = :stat,
            remarks            = :rem,
            receiver           = :username
            where docno = :code";

        $ledger_data = $con->prepare($insert_ledger_sql);
        $ledger_data->execute([
            ':code'             => $docno,
            ':datecreated'      => $date,
            ':time'             => $time,
            ':type'             => $type,
            ':particular'       => $particulars,
            ':orig'             => $department,
            ':destination'       => $destination,
            // ':amount'           => $amount,
            ':stat'             => $status,
            ':rem'              => $remarks,
            ':username'         => $user_name


        ]);








        $tnxhistory_sql = "INSERT INTO tbl_tnxhistory SET 
            ref        = :ref,
            date        = :date,
            docno        = :docno,
            username     = :username,
            activity     = :activity


        ";


        $tnxhistory_data = $con->prepare($tnxhistory_sql);
        $tnxhistory_data->execute([

            ':ref'                    => "ref:" . $docno,
            ':date'                   => $date . ' - ' . $time,
            ':docno'                  => $docno,

            ':username'               => $user_name,
            ':activity'               => "UPDATED " . $type . " DOCUMENT TO " . $destination



        ]);




        if ($update_data && $ledger_data && $tnxhistory_data) {

            $_SESSION['status'] = "Update Document Succesfully!";
            $_SESSION['status_code'] = "success";

            header('location: revert_document.php?docno=' . $docno);
        } else {
            $_SESSION['status'] = "Update Document Unsuccessful!!";
            $_SESSION['status_code'] = "error";

            header('location: revert_document.php?docno=' . $docno);
        }
    }

    ?>