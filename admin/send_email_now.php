<?php

$alert_msg = ''; 
$contact_number = $sender = $message = '';

include('../config/db_config.php');
// require('../bower_components/PHPMailer/PHPMailerAutoload.php');

if (isset($_POST['send_message'])) {

    $sender_name = $_POST['sender_fullname'];
    $sender_email = $_POST['sender_email'];
    $receiver = $_POST['receiver_email'];
    // $receiver_email = $_POST['this_receiver_email'];
    $message = $_POST['message'];
    $subject = $_POST['email_subject'];

    if ($receiver == 'Choose recipient') {

        $alert_msg .= ' 
            <div class="new-alert new-alert-warning alert-dismissible">
                <i class="icon fa fa-warning"></i>
                Please choose recipient.
            </div>     
        ';
        
    }
    else {

        $send_email_sql = "INSERT INTO tbl_message SET 
        date            = now(),
        sender          = :sender,
        sender_email    = :sender_email,
        receiver        = :receiver,
  
        subject         = :subject,
        message         = :message";
        
         // $mail = new PHPMailer();
         // $mail->IsSMTP ();
         // $mail->Host = 'smtp.gmail.com'; // we use gmail for smtp Simple Mail Transfer Protocol
         // $mail->SMTPAuth = true;

         // //sender credentials
         // $mail->Username = $sender_email;
         // $mail->Password = 'yokim@shu_073084';
        
         // $mail->SMTPSecure = 'tsl';
         // $mail->Port = 587;

         // //receiver 
         // // $mail->From = $sender_name; //you can change this whatever you like
         // // $mail->From = 'Admin'; //you can change this whatever you like
         // $mail->FromName = 'PHP Project'; //you can change this whatever you like
         // $mail->addAddress($receiver_email);

         // $mail->isHTML(true);
         // $mail->Subject = $subject;
         // $mail->Body = $message;



        $email_data = $con->prepare($send_email_sql);
        $email_data->execute([
     
        ':sender'             => $sender_name, 
        ':sender_email'       => $sender_email,
        ':receiver'           => $receiver,
        // ':receiver_email'     => $receiver_email,
        ':subject'            => $subject,
        ':message'            => $message
        
        ]);
          
            $alert_msg .= ' 
                <div class="new-alert new-alert-success alert-dismissible">
                    <i class="icon fa fa-warning"></i>
                    Email successfully sent.
                </div>     
            ';
        }

    }

    



?>