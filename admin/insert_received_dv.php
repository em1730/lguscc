 <?php

    include('../config/db_config.php');
    //include('import_pdf.php');

    date_default_timezone_set('Asia/Manila');
    $alert_msg = '';
    $alert_msg1 = '';

    session_start();


    if (isset($_POST['insert_received'])) {

        //     echo "<pre>";
        //     print_r($_POST);
        // echo "</pre>";

        $docno = $_POST['doc_no'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $time =  date('H:i:s');
        $type = $_POST['type'];
        if (empty($_POST['obr_number'])) {
            $obr_no = '';
        } else {
            $obr_no = $_POST['obr_number'];
        }

        if (empty($_POST['pr_number'])) {
            $pr_no = '';
        } else {
            $pr_no = $_POST['pr_number'];
        }

        if (empty($_POST['po_number'])) {
            $po_no = '';
        } else {
            $po_no = $_POST['po_number'];
        }

        if (empty($_POST['account'])) {
            $account = '';
        } else {
            $account = $_POST['account'];
        }

        if (empty($_POST['dv_number'])) {
            $dv_no = '';
        } else {
            $dv_no = $_POST['dv_number'];
        }

        if (empty($_POST['cheque_number'])) {
            $cheque_no = '';
        } else {
            $cheque_no = $_POST['cheque_number'];
        }

        if (empty($_POST['acct_number'])) {
            $acct_no = '';
        } else {
            $acct_no = $_POST['acct_number'];
        }
        $amount = $_POST['amount'];
        $payee = $_POST['payee'];
        $particulars = $_POST['particulars'];
        $origin = $_POST['origin'];
        $department = $_POST['department'];
        // $amount = $_POST['amount'];
        $status = 'RECEIVED';
        $remarks = $_POST['remarks'];
        $user_name = $_POST['username'];
        $host_name = "";
        //$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        if (empty($_POST['etc'])) {
            $etal = 0;
        } else {
            $etal = 1;
        };

        if (empty($_POST['prev_year'])) {
            $prevyear = 0;
        } else {
            $prevyear = 1;
        };

        if (empty($_POST['new_obr'])) {
            $new_obr = 0;
        } else {
            $new_obr = 1;
        };


        $finalparticulars =
            $obr_no . '
    ' . $pr_no . '
    ' . $po_no . '
    ' . $dv_no . '
    ' . $acct_no . '
    ' . $cheque_no . '
    ' . $payee . " " . $etal . '
    ' . $particulars . '
    ' . $amount;



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



        $update_dv1_sql = "UPDATE tbl_documents SET 
                date            = :date,
                type            = :type,
                prevyear        = :prevyear,
                obrno           = :obrno,
                newobr          = :newobr,
                prno            = :prno,
                pono            = :pono,
                acctype         = :acctype,
                dvno            = :dvno,
                acctno          = :acctno,
                chequeno        = :chequeno,
                payee           = :payee,
                etal            = :etal,
                particulars     = :particulars,
                amount          = :amount,
                status          = :stat, 
                origin          = :orig,
                destination     = :dest,     
                remarks         = :rem
                where docno     = :code";

        $update_dv1_data = $con->prepare($update_dv1_sql);
        $update_dv1_data->execute([
            ':date'             => $date,
            ':type'             => $type,
            ':prevyear'         => $prevyear,
            ':obrno'            => $obr_no,
            ':newobr'           => $new_obr,
            ':prno'             => $pr_no,
            ':pono'             => $po_no,
            ':acctype'          => $account,
            ':dvno'             => $dv_no,
            ':acctno'           => $acct_no,
            ':chequeno'         => $cheque_no,
            ':payee'            => $payee,
            ':etal'             => $etal,
            ':particulars'      => $particulars,
            ':amount'           => str_replace(',', '', $amount),
            ':stat'             => $status,
            ':orig'             => $origin,
            ':dest'             => $department,
            ':rem'              => $remarks,
            ':code'             => $docno


        ]);








        $insert_ledgerdv_sql = "INSERT INTO tbl_ledger SET 
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
            machineid          = :host,
            start_time         = :start_time,
            end_time           = :end_time";




        $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
        $insert_ledgerdv_data->execute([
            ':code'             => $docno,
            'txndate'           => $date,
            ':time'             => $time,
            ':type'             => $type,
            ':particular'       => $finalparticulars,
            ':orig'             => $origin,
            ':destination'      => $department,
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
            
                username     = :username,
                activity     = :activity


            ";


        $tnxhistory_data = $con->prepare($tnxhistory_sql);
        $tnxhistory_data->execute([

            ':ref'                    => "ref:" . $docno,
            ':date'                   => $date . ' - ' . $time,
            ':docno'                  => $docno,

            ':username'               => $user_name,
            ':activity'               => "RECEIVED DOCUMENT FROM " . $origin



        ]);


        if ($update_dv1_data && $insert_ledgerdv_data && $tnxhistory_data) {

            $_SESSION['status'] = "Received Document Succesfully!";
            $_SESSION['status_code'] = "success";

            header('location: list_received.php');
        } else {
            $_SESSION['status'] = "Received Document Unsuccessfull!";
            $_SESSION['status_code'] = "error";

            header('location: list_received.php');
        }


        //     $alert_msg .= ' 
        //     <div class="alert alert-success alerSt-dismissible">
        //     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        //         <i class="fa fa-check"></i>
        //         <strong> Success ! </strong> Data Inserted.
        // </div>    
        //     ';

        // $btnStatus = 'disabled';
        // $btnNew = 'enabled';
        // $btnPrint = 'enabled';

        //  header('location: list_incoming.php');

    }
    ?>