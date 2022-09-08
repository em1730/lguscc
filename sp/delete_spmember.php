<?php

include 'includes/session.php';

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM sp_members WHERE objid = '$id'";
    if($con->query($sql)){
        $_SESSION['error'] = "<i class='icon fa fa-check'></i>SP Member deleted successfully";
    }
    else{
        $_SESSION['error'] = $con->error;
    }
}
else{
    $_SESSION['error'] = 'Select item to delete first';
}

header('location: sp_member.php');

?>