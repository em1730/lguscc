<?php
if (isset($_POST['delete_user'])) {

    $delete_user_id = $_POST['user_id'];
    $delete_user_sql = "DELETE FROM tbl_users WHERE user_id = :id";
    $delete_user_data = $con->prepare($delete_user_sql);
    $delete_user_data->execute([':id'=>$delete_user_id]);

    header('location: users.php');
    
}

?>