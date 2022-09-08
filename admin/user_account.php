<?php


$user_id = $_SESSION['id'];


// $db_first_name = $db_middle_name = $db_last_name = $db_email_ad
// = $db_department = $db_user_name = '';

if (!isset($_SESSION['id'])) {
    header('location:../login..php');
} else {


}

$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {
  $db_first_name = $result['first_name'];
  $db_middle_name = $result['middle_name'];
  $db_last_name = $result['last_name'];
  $db_email_ad = $result['email'];
  $db_contact_number = $result['contact_no'];
  $db_user_name = $result['username'];
  $db_department = $result['department'];
  
}




?>