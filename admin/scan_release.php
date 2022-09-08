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
         $destination = $_POST['destination'];
         $remarks = $_POST['remarks'];
        

         $get_all_incoming_sql = "SELECT * FROM tbl_documents where docno = :doc and destination = '$department'";
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
          // $origin= $result['origin']; 
         // $destination= $result['destination'];
          $status = $result['status'];
          // $remarks = $result['remarks'];
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
            ':orig'             => $department,
            ':destination'      => $destination,
            ':stat'             => 'FORWARDED',
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
      ':stat'             => 'FORWARDED',
      ':orig'             => $department,
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
     'origin'      => $department,
     'status'      => $status,
     'remarks'     => $remarks,
     'message'     => "Document Forwarded!"
   );

   echo json_encode($data);
        
          }

    
          
        

     


}
?>



