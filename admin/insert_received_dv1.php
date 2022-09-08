 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_received'])) {

    //        echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $docno = $_POST['doc_no'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s');
    $type = $_POST['type'];
    $obr_no = $_POST['obr_number'];
    $account = $_POST['account'];
    $dv_no = $_POST['dv_number'];
    $cheque_no = $_POST['cheque_number'];
    $acct_no = $_POST['acct_number'];
    $amount = doubleval($_POST['amount']);
    $payee= $_POST['payee'];
    $particulars = $_POST['particulars'];
    $origin = $_POST['origin'];
    $creator = $_POST['origin'];
    $department = $_POST['department'];
   // $amount = $_POST['amount'];
    $destination = $_POST['department'];
    $remarks = $_POST['remarks'];
    $user_name = $_POST['username'];
   // $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $status = 'RECEIVED';
    $print = 0;
     
    if(empty($_POST['etc'])){
        $etal = 0;
    }else{            
        $etal = 1;
        };
    
    if(empty($_POST['prev_year'])){
        $prevyear = 0;
        }else{            
        $prevyear = 1;
        };
    
    if(empty($_POST['new_obr'])){
            $new_obr = 0;
            }else{            
            $new_obr = 1;
            };
    
    
        $finalparticulars = 
        $obr_no.'
        '.$pr_no.'
        '.$po_no.'
        '.$dv_no.'
        '.$acct_no.'
        '.$cheque_no.'
        '.$payee." ". $etal.'
        '.$particulars.'
        '.$amount;
       
        $update_dv_sql = "INSERT INTO tbl_documents SET 
               docno           = :code,
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
               creator         = :creator,
               amount          = :amount,
               status          = :stat, 
               origin          = :orig,
               destination     = :dest,     
               remarks         = :rem";

                    
$update_dv_data = $con->prepare($update_dv_sql);
$update_dv_data->execute([
    ':date'             =>$date,
    ':type'             =>$type,
    ':prevyear'         =>$prevyear,
    ':obrno'            =>$obr_no,
    ':newobr'           =>$new_obr,
    ':prno'             =>$pr_no,
    ':pono'             =>$po_no,
    ':acctype'          =>$account,
    ':dvno'             =>$dv_no,
    ':acctno'           =>$acct_no,
    ':chequeno'         =>$cheque_no,
    ':payee'            =>$payee,
    ':etal'             =>$etal,
    ':particulars'      =>$particulars,
    ':creator'          => $creator,
    ':amount'           =>str_replace(',','',$amount),
    ':stat'             =>$status,
    ':orig'             =>$origin,
    ':dest'             =>$department,
    ':rem'              =>$remarks,
    ':code'             =>$docno
 
   
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
            receiver           = :username"
        ;
            
        
        
        
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
            ':username'         => $user_name
           
     
        
         
           
            ]);
        $alert_msg .= ' 
        <div class="new-alert new-alert-success alert-dismissible">
            <i class="icon fa fa-success"></i>
            Data Inserted
        </div>     
    ';
    


    $btnStatus = 'disabled';
    $btnNew = 'enabled';
    $btnPrint = 'enabled';
    
        }


?>