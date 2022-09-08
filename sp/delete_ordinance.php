<?php
if (isset($_POST['delete_ordinance'])) {

    $delete_user_id = $_POST['user_id'];
    $delete_user_sql = "DELETE FROM ordinances WHERE OrdinanceNumber = :id";
    $delete_user_data = $con->prepare($delete_user_sql);
    $delete_user_data->execute([':id'=>$delete_user_id]);

    header('location: ordinances.php');
    
}

?>