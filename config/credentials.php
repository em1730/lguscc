<?php


include('db_config_doctrack.php');
// include('db_config_vamos.php');


$user_id = $_SESSION['id'];




// $db_first_name = $db_middle_name = $db_last_name = $db_email_ad
// = $db_department = $db_user_name = $db_usermodule = $db_dtsmodule ='';


$get_user_sql = " SELECT * FROM tbl_users where user_id = :id";
$user_data = $db_dts->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {
  $db_first_name  = $result['first_name'];
  $db_middle_name  = $result['middle_name'];
  $db_last_name  = $result['last_name'];
  $db_user_name = $result['username'];
  $db_department = $result['department'];
  // $db_usermodule = $result['UserModule'];
  // $db_dtsmodule = $result['DoctrackModule'];
}


// $get_user_indi_sql = "SELECT * FROM scc_doctrack.tbl_users INNER JOIN sccdrrmo.`tbl_individual`
//                     ON scc_doctrack.tbl_users.`entityno` = sccdrrmo.`tbl_individual`.`entity_no`
//                     where scc_doctrack.tbl_users.user_id = :id";
// $user_indi_data = $db_vamos->prepare($get_user_indi_sql);
// $user_indi_data->execute([':id' => $user_id]);
// while ($result = $user_indi_data->fetch(PDO::FETCH_ASSOC)) {
//   $db_first_name = $result['firstname'];
//   $db_middle_name = $result['middlename'];
//   $db_last_name = $result['lastname'];
// }
