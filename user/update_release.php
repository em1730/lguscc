 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['update_release'])) {

    //     echo "<pre>";
    //     print_r($_POST);
    // echo "</pre>";
    $origin = $_POST['origin'];
    $type = $_POST['type'];
    $date_from = date('Y-m-d', strtotime($_POST['date']));
    $date_to = date('Y-m-d', strtotime($_POST['date']));
    $origin = $_POST['origin'];
    $status = 'RELEASED';
   
    $update_outgoing_sql = "UPDATE tbl_documents SET 
    status = :stat, 
    where docno = :code";
            
    $update_data = $con->prepare($update_outgoing_sql);
    $update_data->execute([
        ':stat'             => $status,
        ':orig'             => $origin,
        ':dest'             => $department,
        ':code'             => $docno 
       
        ]);
    }

?>