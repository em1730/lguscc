 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['type'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $origin = $_GET['origin'];
    $type = $_POST['type'];
    $date_from = date('Y-m-d', strtotime($_GET['date_from']));
    $date_to = date('Y-m-d', strtotime($_GET['date_to']));
    $department = $_GET['department'];
    $username = $_GET['username'];
    $print = 1;
   

    
if ($origin !="Please select..."){
    $update_document_sql = "UPDATE tbl_documents set print = :print WHERE type = :type and creator = :origin and date between '$date_from' and '$date_to' and status ='FORWARDED' or status = 'CREATED' and origin = '$department'";
    
            
    $update_data = $con->prepare($update_document_sql);
    $update_data->execute([
        ':print'            => $print,
        ':type'             => $type,
        ':origin'           => $origin,
        
       
        ]);
    }else if ($origin =="Please select..."){
        $update_document_sql = "UPDATE tbl_documents set print = :print WHERE type = :type and date between '$date_from' and '$date_to' and status ='FORWARDED' or status = 'CREATED' and origin = '$department'";
        
                
        $update_data = $con->prepare($update_document_sql);
        $update_data->execute([
            ':print'            => $print,
            ':type'             => $type,
            
            
           
            ]);
        }
    }
?>