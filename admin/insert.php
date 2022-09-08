<?php
  include('../config/db_config.php');

  $alert_msg = '';     

  //if button insert clicked

  if (isset($_POST['insert'])) {

    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    //length of $contact_number
    $con_number = strlen($contact_number);
    
    if ($con_number != 11) {
      $alert_msg .= ' 
          <div class="new-alert new-alert-warning alert-dismissible">
              <i class="icon fa fa-warning"></i>
              Contact Number must be 11 digit.
          </div>     
      ';
    }
    else {

      //hash the password
      $hashed_password  = password_hash($upass, PASSWORD_DEFAULT);
      //insert user to database
      $register_user_sql = "INSERT INTO tbl_users SET 
        first_name     = :fname,
        middle_name    = :mname,
        last_name      = :lname,
        email          = :email,
        contact_number = :contact_number,
        username       = :uname,
        userpass       = :upass,
        account_type   = :account_type";

      $register_data = $con->prepare($register_user_sql);
      $register_data->execute([
        ':fname'          => $fname,
        ':mname'          => $mname,
        ':lname'          => $lname,
        ':email'          => $email,
        ':contact_number' => $contact_number,
        ':uname'          => $uname,
        ':upass'          => $hashed_password,
        ':account_type'   => 2
      ]);

      $alert_msg .= ' 
          <div class="new-alert new-alert-success alert-dismissible">
              <i class="icon fa fa-success"></i>
              Data Inserted
          </div>     
      ';
     // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';

     $btnStatus = 'disabled';
     $btnNew = 'enabled';
    }

  }

 

 
?>