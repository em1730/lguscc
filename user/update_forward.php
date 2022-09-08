 <?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';
if (isset($_POST['insert_forward'])) {

        echo "<pre>";
        print_r($_POST);
    echo "</pre>";
    $docno = $_POST['doc_number'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time =  date('H:i:s p');
    $department = $_POST['department'];
    $type = $_POST['type'];
    $destination = $_POST['receiver'];
    $particulars = $_POST['particulars'];
    $remarks = $_POST['remarks'];
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
    
    }

?>