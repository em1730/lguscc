<?php
    include('../config/db_config.php');


  $alert_msg = '';
    if (isset($_POST['update_profile'])){
         //to check if data are passed
       
    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $uname = $_POST['username'];
    $upass = $_POST['password'];
    $position = $_POST['position'];
    $department = $_POST['department'];
   // $account_type = $_POST['account_type'];

    //length of $contact_number
    $con_number = strlen($contact_number);
    
    if ($con_number != 11) {
      echo "Invalid contact number";
    }
    else {

        if (empty($upass)){
            //update tbl users do not include password
            $update_user_sql = "UPDATE tbl_users SET 
                first_name     = :fname,
                middle_name    = :mname,
                last_name      = :lname,
                email          = :email,
                contact_no     = :contact_number,
                username       = :uname,
                -- userpass       = :upass,
                position       = :position,
                department     = :department
                -- account_type   => :account_type 
                WHERE user_id  = :id";
    
          $update_data = $con->prepare($update_user_sql);
          $update_data->execute([
                ':fname'          => $fname,
                ':mname'          => $mname,
                ':lname'          => $lname,
                ':email'          => $email,
                ':contact_number' => $contact_number,
                ':uname'          => $uname,
               // ':upass'          => $hashed_password,
                ':position'       => $position,
                ':department'     => $department,
                // ': account_type'   => $account_type, 
                ':id'             => $user_id
          ]);
        }else{
            //update tbl users include password
        }
      //echo "valid number";
      // $register_user_sql = "INSERT INTO tbl_users(first_name, middle_name, last_name, email, contact_number,username, userpass, account_type) VALUES(:fname, :mname, :lname, :email, :contact_number, :uname, :upass, :account_type)";

      //hash the password
      $hashed_password  = password_hash($upass, PASSWORD_DEFAULT);
      //insert user to database
      $register_user_sql = "UPDATE tbl_users SET 
        first_name     = :fname,
        middle_name    = :mname,
        last_name      = :lname,
        email          = :email,
        contact_no = :contact_number,
        username       = :uname,
        userpass       = :upass,
        position       = :position,
        department     = :department
        -- account_type   => :account_type 
        -- account_type   = :account_type
        WHERE user_id = :id";
        

      $register_data = $con->prepare($register_user_sql);
      $register_data->execute([
        ':fname'          => $fname,
        ':mname'          => $mname,
        ':lname'          => $lname,
        ':email'          => $email,
        ':contact_number' => $contact_number,
        ':uname'          => $uname,
        ':upass'          => $hashed_password,
        ':position'       => $position,
        ':department'     => $department,
        // ': account_type'   => $account_type,
        // ':account_type'   => 2,
        ':id'             => $user_id
      ]);

      echo "Data Inserted";

    }
    }
        else if (isset($_POST['update_user'])){
          $new_user_password = $_POST['new_user_password'];
          $user_id_update = $_POST['user_id_update'];
          $new_firstname = $_POST['new_firstname'];
          $new_middlename = $_POST['new_middlename'];
          $new_lastname = $_POST['new_lastname'];
          $new_contact_number = $_POST['new_contact_number'];
          $new_email = $_POST['new_email'];
          $new_username = $_POST['new_username'];
          $new_position = $_POST['new_position'];
          $new_department = $_POST['new_department'];
          $new_account_type = $_POST['new_account_type'];
    
          //get the length of the contact_number
          $contact_value = strlen($new_contact_number);
    
          if ($contact_value != 11) {
    
            $alert_msg .= ' 
                <div class="new-alert new-alert-warning alert-dismissible">
                    <i class="icon fa fa-warning"></i>
                    Contact Number must be 11 digit.
                </div>     
            ';
          
          }    
          else {
            //empty $upass
            if (empty($new_user_password)) {
                //update tbl_users
                //do not include password
                $update_user_sql = "UPDATE tbl_users SET 
                    first_name     = :fname,
                    middle_name    = :mname,
                    last_name      = :lname,
                    email          = :email,
                    contact_no = :contact_number,
                    username       = :uname,
                    position       = :position,
                    department     = :department,
                    account_type   => :account_type 
                    WHERE user_id   = :id";
    
                $update_data = $con->prepare($update_user_sql);
                $update_data->execute([
                    ':fname'          => $new_firstname,
                    ':mname'          => $new_middlename,
                    ':lname'          => $new_lastname,
                    ':email'          => $new_email,
                    ':contact_number' => $new_contact_number,
                    ':uname'          => $new_username,
                    ': position'       => $position,
                    ': department'     => $department,
                    ': account_type'   => $account_type,
   
                    ':id'              => $user_id_update
                ]);                
            }
            else{
                //update tbl_users
                //include password
                
                //hash the password
                $hashed_password  = password_hash($upass, PASSWORD_DEFAULT);
    
                $update_user_sql = "UPDATE tbl_users SET 
                    first_name     = :fname,
                    middle_name    = :mname,
                    last_name      = :lname,
                    email          = :email,
                    contact_no = :contact_number,
                    username       = :uname,
                    userpass       = :upass,
                    position       = :position,
                    department     = :department,
                    account_type   => :account_type 
                    WHERE user_id   = :id";
    
                $update_data = $con->prepare($update_user_sql);
                $update_data->execute([
                    ':fname'          => $new_firstname,
                    ':mname'          => $new_middlename,
                    ':lname'          => $new_lastname,
                    ':email'          => $new_email,
                    ':contact_number' => $new_contact_number,
                    ':uname'          => $new_username,
                    ':uname'          => $new_user_password,
                    ': position'       => $position,
                    ': department'     => $department,
                    ': account_type'   => $account_type,
                    ':id'              => $user_id_update
                ]);        
            }
          }
    
            $alert_msg .= ' 
              <div class="new-alert new-alert-success alert-dismissible">
                  <i class="icon fa fa-success"></i>
                  Data Updated.
              </div>     
            ';


    }
?>