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

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";


         $docno = $_POST['docno'];
        

         $get_all_incoming_sql = "SELECT * FROM tbl_ledger where docno = :doc order by txndate DESC, time DESC LIMIT 1";
         $get_all_incoming_data = $con->prepare($get_all_incoming_sql);
         $get_all_incoming_data->execute([':doc' => $docno]); 
         $row =$get_all_incoming_data->rowcount();

        if (empty($row)){

          
          $data = array(
            'date'        => "",
            'time'        => "",
            'type'        => "",
            'particulars' => "",
            'origin'      => "",
            'destination' => "",
            'status'      => "",
            'remarks'     => "",
            'message'     => "Document Not Found!"
          );
          echo json_encode($data);

        }else{

         while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
          $docno = $result['docno'];
          $date = $result['txndate'];
          $time = $result['time'];
          $type = $result['type']; 
          $particulars = $result['particulars']; 
          $origin= $result['origin']; 
          $destination= $result['destination'];
          $status = $result['status'];
          $remarks = $result['remarks'];
       
         }


         $data = array(
                'date'        => $date,
                'time'        => $time,
                'type'        => $type,
                'particulars' => $particulars,
                'origin'      => $origin,
                'destination' => $destination,
                'status'      => $status,
                'remarks'     => $remarks,
                'message'     => ""
   );

   echo json_encode($data);
        
  

    
          }
        

     


}
?>