<?php




include('../config/credentials.php');


$docno = '';


$get_noofdocs_sql = "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$db_department'";
$get_noofdocs_data = $db_dts->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}

//count incoming documents
$get_noofdocs_sql = "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status in ('CREATED','FORWARDED') and destination = '$db_department'";
$get_noofdocs_data = $db_dts->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $incoming_count =  $result1['total'];
}


//count incoming documents
$get_noofdocs_sql = "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status = 'RECEIVED' and destination = '$db_department'";
$get_noofdocs_data = $db_dts->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $received_count =  $result1['total'];
}

$get_noofdocs_sql = "SELECT COUNT(`docno`) as total FROM `tbl_documents` where origin = '$db_department'";
$get_noofdocs_data = $db_dts->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $outgoing_count =  $result1['total'];
}

$get_noofdocs_sql = "SELECT COUNT(`docno`) as total FROM `tbl_documents` WHERE status = 'ARCHIVED' and destination = '$db_department'";
$get_noofdocs_data = $db_dts->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {
  $archived_count =  $result1['total'];
}

// count new messages
$get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
$get_all_message_data = $db_dts->prepare($get_all_message_sql);
$get_all_message_data->execute();
while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
    $message_count =  $result1['total'];
}

// //select all messages for notification
$get_all_messages_sql = "SELECT * FROM tbl_message where (receiver = $user_id or receiver = '0') and status = 'PENDING' ";
$get_all_messages_data = $db_dts->prepare($get_all_messages_sql);
$get_all_messages_data->execute();

// //select all messages for email
$get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id or receiver ='0'";
$get_all_messages1_data = $db_dts->prepare($get_all_messages1_sql);
$get_all_messages1_data->execute();





?>


<div class="container-fluid">
  <!-- Info boxes -->
  <div class="row">
  
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-info-gradient">
        <span class="info-box-icon bg-info elevation-1"> <a href="list_incoming.php"> <i class="fa fa-arrow-circle-down"></i></a></span>
        <div class="info-box-content">
          <span class="info-box-text">Incoming</span>
          <span class="info-box-number">
            <?php echo $incoming_count ?>
          </span>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-danger-gradient">
        <span class="info-box-icon bg-danger elevation-1"> <a href="list_received.php"> <i class="fa fa-folder-open"></i></a></span>

        <div class="info-box-content">
          <span class="info-box-text">Received</span>
          <span class="info-box-number">
            <?php echo $received_count ?>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-success-gradient">
        <span class="info-box-icon bg-success elevation-1"><a href="list_outgoing.php"> <i class="fa fa-arrow-circle-up"></i></a></span>
        <div class="info-box-content">
          <span class="info-box-text">Outgoing</span>
          <?php echo $outgoing_count ?>
        </div>
      </div>
    </div>


    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-warning-gradient">
        <span class="info-box-icon bg-warning elevation-1"> <a href="list_archived.php"> <i class="fa fa-archive"></i></a></span>
        <div class="info-box-content">
          <span class="info-box-text">Archive</span>
          <?php echo $archived_count ?>
        </div>
      </div>
    </div>
  </div>
</div>