 <?php
session_start();

include ('../config/db_config.php');
//include('import_pdf.php');

date_default_timezone_set('Asia/Manila');
$alert_msg = '';
$alert_msg1 = '';
$user_id = $_SESSION['id'];
$time =  date('H:i:s');
$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);


//fetch user from database
$get_user_sql = "SELECT * FROM tbl_users where user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {


    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_email_ad = $result['email'];
    $db_contact_number = $result['contact_no'];
    $db_user_name = $result['username'];
    $department = $result['department'];

}

if (isset($_POST['docno'])){

//         echo "<pre>";
//         print_r($_POST);
//     echo "</pre>";


         $docno = $_POST['docno'];
        

         $get_all_incoming_sql = "SELECT * FROM tbl_documents where docno = :doc and destination = '$department' and status in ('CREATED','FORWARDED')";
         $get_all_incoming_data = $con->prepare($get_all_incoming_sql);
         $get_all_incoming_data->execute([':doc' => $docno]); 
         $row =$get_all_incoming_data->rowcount();

        if (empty($row)){

          
          $data = array(
            'date'        => "",
            'type'        => "",
            'particulars' => "",
            'origin'      => "",
            'status'      => "",
            'remarks'     => "",
            'message'     => "Document Not Found!"
          );

          

          echo json_encode($data);
        }else{




         while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
          $docno = $result['docno'];
          $date = $result['date'];
          $type = $result['type']; 
          $particulars = $result['particulars']; 
          $origin= $result['origin']; 
          $destination= $result['destination'];
          $status = $result['status'];
          $remarks = $result['remarks'];
          $print = $result['print'];
         }

               

            $insert_ledgerdv_sql = "INSERT INTO tbl_ledger SET 
            docno              = :code,
            txndate            = now(),
            time                =:time,
            type               = :type,
            particulars        = :particular,
            origin             = :orig,
            destination        = :destination,
            status             = :stat,
            remarks            = :rem,
            receiver           = :username,
            machineid          = :host";

  $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
  $insert_ledgerdv_data->execute([
            ':code'             => $docno, 
            ':time'             => $time,
            ':type'             => $type,
            ':particular'       => $particulars,
            ':orig'             => $origin,
            ':destination'      => $destination,
            ':stat'             => 'RECEIVED',
            ':rem'              => $remarks,
            ':username'         => $db_user_name,
            ':host'             => $host_name
  ]);           

 
  $update_documents_sql = "UPDATE tbl_documents SET 
  status = :stat, 
  origin = :orig,
  destination = :dest,
  particulars = :part,
  remarks = :rem,
  print = :print
  where docno = :code";
          
  $update_documents_data = $con->prepare($update_documents_sql);
  $update_documents_data->execute([
      ':stat'             => 'RECEIVED',
      ':orig'             => $origin,
      ':dest'             => $destination,
      ':part'             => $particulars,
      ':rem'              => $remarks,
      ':print'            => 0,
      ':code'             => $docno
     
      ]);
    


 $data = array(
     'date'        => $date,
     'type'        => $type,
     'particulars' => $particulars,
     'origin'      => $origin,
     'status'      => $status,
     'remarks'     => $remarks,
     'message'     => "Successfully Received!"
   );

   echo json_encode($data);
        
  

    
          }
        

     

         //echo $type;
//         $date = date('Y-m-d', strtotime($_POST['date']));
//         $time =  date('h:i:s');
//         $type = $_POST['type'];
//         $obr_no = $_POST['obr_number'];
//         $account = $_POST['account'];
//         $dv_no = $_POST['dv_number'];
//         $cheque_no = $_POST['cheque_number'];
//         $acct_no = $_POST['acct_number'];
//         $amount =$_POST['amount'];
//         $payee= $_POST['payee'];
//         $particulars = $_POST['particulars'];
//         $origin = $_POST['origin'];
//         $department = $_POST['department'];
//         // $amount = $_POST['amount'];
//         $status = 'RECEIVED';
//         $remarks = $_POST['remarks'];
//         $user_name = $_POST['username'];
//         $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       
// $finalparticulars = 
// $obr_no.'
// '.$dv_no.'
// '.$acct_no.'
// '.$cheque_no.'
// '.$payee.'
// '.$particulars.'
// '.$amount;

//         $insert_ledgerdv_sql = "INSERT INTO tbl_ledger SET 
//             docno              = :code,
//             txndate            = :txndate,
//             time                =:time,
//             type               = :type,
//             particulars        = :particular,
//             origin             = :orig,
//             destination        = :destination,
//             status             = :stat,
//             remarks            = :rem,
//             receiver           = :username,
//             machineid          = :host";
            
    
    
        
//         $insert_ledgerdv_data = $con->prepare($insert_ledgerdv_sql);
//         $insert_ledgerdv_data->execute([
//             ':code'             => $docno, 
//             'txndate'           => $date,
//             ':time'             => $time,
//             ':type'             => $type,
//             ':particular'       => $finalparticulars,
//             ':orig'             => $origin,
//             ':destination'      => $department,
//             ':stat'             => $status,
//             ':rem'              => $remarks,
//             ':username'         => $user_name,
//             ':host'             => $host_name
//             ]);


        

//     $alert_msg .= ' 
//           <div class="new-alert new-alert-success alert-dismissible">
//               <i class="icon fa fa-success"></i>
//               Document Received!
//           </div>     
//       ';
    
//     $btnStatus = 'disabled';
//     $btnNew = 'enabled';
//     $btnPrint = 'enabled';
 


}
?>