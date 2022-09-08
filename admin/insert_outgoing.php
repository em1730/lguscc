 <?php



    session_start();


    include('../config/credentials.php');


    date_default_timezone_set('Asia/Manila');


    if (isset($_POST['insert_outgoing'])) {

        //     echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";
        $docno = $_POST['doc_number'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $time =  date('H:i:s');

        //save selected array (document type)
        if (!empty($_POST['type'])) {
            $type = $_POST['type'];
        }

        $type = $_POST['type'];
        $particulars = $_POST['particulars'];
        $department = $_POST['department'];
        $creator = $_POST['department'];

        //save selected array (reciever)
        if (!empty($_POST['receiver'])) {
            $destination = $_POST['receiver'];
        }

        $status = 'CREATED';
        $remarks = $_POST['remarks'];
        $user_name = $_POST['username'];
        $host_name = "";
        // $start_time = $date .' ' . $time;
        // $end_time = $date .' ' . $time;

        $check_start_sql = "select end_time from tbl_ledger where docno = :docno and end_time < now() ORDER BY end_time DESC limit 1";
        $check_start_data = $db_dts->prepare($check_start_sql);
        $check_start_data->execute([
            ':docno' => $docno
        ]);
        while ($result = $check_start_data->fetch(PDO::FETCH_ASSOC)) {
            $start_time = $result['end_time'];
        }

        $check_now_sql =  "select now() as time";
        $check_now_data = $db_dts->prepare($check_now_sql);
        $check_now_data->execute([]);
        while ($result = $check_now_data->fetch(PDO::FETCH_ASSOC)) {
            $now_time = $result['time'];
        }


        $insert_outgoing_sql = "INSERT INTO tbl_documents SET 
        docno              = :code,
        date               = :datecreated,
        date_time          = :timey,
        type               = :type,
        particulars        = :particular,
        creator            = :creator,
        origin             = :orig,
        destination        = :destination,
        status             = :stat,
        remarks            = :rem";

        $outgoing_data = $db_dts->prepare($insert_outgoing_sql);
        $outgoing_data->execute([
            ':code'             => $docno,
            ':timey'            => $date . ' ' . $time,
            ':datecreated'      => $date,
            ':type'             => $type,
            ':particular'       => $particulars,
            ':creator'          => $creator,
            ':orig'             => $department,
            ':destination'      => $destination,
            ':stat'             => $status,
            ':rem'              => $remarks
        ]);


        $insert_ledger_sql = "INSERT INTO tbl_ledger SET 
        docno              = :code,
        txndate            = :datecreated,
        time                =:time,
        type               = :type,
        particulars        = :particular,
        origin             = :orig,
        destination        = :destination,
        -- amount             = :amount,
        status             = :stat,
        remarks            = :rem,
        receiver           = :username,
        machineid          = :host,
        start_time         = :start_time,
        end_time           = :end_time";

        $ledger_data = $db_dts->prepare($insert_ledger_sql);
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
            ':username'         => $user_name,
            ':host'             => $host_name,
            ':start_time'       => $now_time,
            ':end_time'         => $now_time

        ]);



        $tnxhistory_sql = "INSERT INTO tbl_tnxhistory SET 
                ref        = :ref ,
                date        = :date ,
                docno        = :docno ,
                department   = :dept,
            
                username     = :username,
                activity     = :activity


            ";


        $tnxhistory_data = $db_dts->prepare($tnxhistory_sql);
        $tnxhistory_data->execute([

            ':ref'                    => "ref:" . $docno,
            ':date'                   => $date . ' - ' . $time,
            ':docno'                  => $docno,
            ':dept'                   => $db_department,
            ':username'               => $user_name,
            ':activity'               => "FORWARD " . $type . " DOCUMENT TO " . $destination



        ]);


   
        if ($ledger_data && $outgoing_data && $tnxhistory_data) {

            $_SESSION['status'] = "Forward Document Succesfully!";
            $_SESSION['status_code'] = "success";


            header('location: add_outgoing.php?docno=' . $docno);
            
            $btnNew = 'enabled';
            $btnStatus ='disabled';
            $btnPrint = 'enabled';
           
        } else {
            $_SESSION['status'] = "Forward Document Unsuccessfull!";
            $_SESSION['status_code'] = "error";

            header('location: add_outgoing.php?docno=' . $docno);
        }
     
    }






    ?>