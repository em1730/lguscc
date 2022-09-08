 <?php

    include('../config/db_config.php');
    //include('import_pdf.php');
    session_start();
     date_default_timezone_set('Asia/Manila');



    if (isset($_POST['insert_received'])) {


        $docno = $_POST['doc_no'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $time =  date('H:i:s');
        $type = $_POST['type'];
        $particulars = $_POST['particulars'];
        $origin = $_POST['origin'];
        $department = $_POST['department'];
    
        $remarks = $_POST['remarks'];
        $user_name = $_POST['username'];
        $status = 'RECEIVED';
        $print = 0;
  

        $check_start_sql = "select end_time from tbl_ledger where docno = :docno and end_time < now() ORDER BY end_time DESC limit 1";
        $check_start_data = $con->prepare($check_start_sql);
        $check_start_data->execute([
            ':docno' => $docno
        ]);

        while ($result = $check_start_data->fetch(PDO::FETCH_ASSOC)) {
            $start_time = $result['end_time'];
        }

        $check_now_sql =  "select now() as time";
        $check_now_data = $con->prepare($check_now_sql);
        $check_now_data->execute([]);
        while ($result = $check_now_data->fetch(PDO::FETCH_ASSOC)) {
            $now_time = $result['time'];
        }

        $insert_ledger_sql = "INSERT INTO tbl_ledger SET 
        docno              = :code,
        txndate            = :txndate,
        time                =:time,
        type               = :type,
        particulars        = :particular,
        origin             = :orig,
        destination        = :destination,
        status             = :stat,
        remarks            = :rem,
        receiver           = :username,
        start_time         = :start_time,
        end_time           = :end_time";


        $insert_ledger_data = $con->prepare($insert_ledger_sql);
        $insert_ledger_data->execute([
            ':code'             => $docno,
            'txndate'           => $date,
            ':time'             => $time,
            ':type'             => $type,
            ':particular'       => $particulars,
            ':orig'             => $origin,
            ':destination'      => $department,
            ':stat'             => $status,
            ':rem'              => $remarks,
            ':username'         => $user_name,
            ':start_time'       => $start_time,
            ':end_time'         => $now_time
        ]);


        $update_documents_sql = "UPDATE tbl_documents SET 
            status          = :stat, 
            origin          = :orig,
            destination     = :dest,
            particulars     = :part,
            remarks         = :rem,
            print           = :print
            where docno     = :code";

        $update_documents_data = $con->prepare($update_documents_sql);
        $update_documents_data->execute([
            ':stat'             => $status,
            ':orig'             => $origin,
            ':dest'             => $department,
            ':part'             => $particulars,
            ':rem'              => $remarks,
            ':print'            => $print,
            ':code'             => $docno

        ]);


       $tnxhistory_sql = "INSERT INTO tbl_tnxhistory SET 
                ref        = :ref ,
                date        = :date ,
                docno        = :docno ,
            
                username     = :username,
                activity     = :activity


            ";


        $tnxhistory_data = $con->prepare($tnxhistory_sql);
        $tnxhistory_data->execute([

            ':ref'                    => "ref:" . $docno,
            ':date'                   => $date . ' - ' . $time,
            ':docno'              => $docno,

            ':username'               => $user_name,
            ':activity'               => "RECEIVED ". $type . " DOCUMENT FROM ". $origin



        ]);




        if ($insert_ledger_data && $update_documents_data) {

            $_SESSION['status'] = "Received Document Succesfully!";
            $_SESSION['status_code'] = "success";

            header('location: list_incoming.php');
        } else {
            $_SESSION['status'] = "Received Document Unsuccessful!!";
            $_SESSION['status_code'] = "error";

            header('location: list_incoming.php');
        }
    }
