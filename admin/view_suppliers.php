<?php


session_start();

$objid = $code = $name_supplier = $owner  = $address = $contact_no = $contact_person = $fax_no = $telephone_no = $others = $product_lines = '';
$btnNew = 'disabled';
$btnStatus = '';



if (!isset($_SESSION['id'])) {
  header('location:../index');
}
$user_id = $_SESSION['id'];

include('../config/db_config.php');
// include('update_for_suppliers.php');



//select user
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
}


// // count new messages
// $get_all_message_sql = "SELECT count(*) as total FROM tbl_message where receiver = $user_id and status = 'PENDING'";
// $get_all_message_data = $con->prepare($get_all_message_sql);
// $get_all_message_data->execute();
// while ($result1 = $get_all_message_data->fetch(PDO::FETCH_ASSOC)) {
//   $message_count =  $result1['total'];
// }

// // //select all messages for notification
// $get_all_messages_sql = "SELECT * FROM tbl_message where (receiver = $user_id or receiver = '0') and status = 'PENDING' ";
// $get_all_messages_data = $con->prepare($get_all_messages_sql);
// $get_all_messages_data->execute();

// // //select all messages for email
// $get_all_messages1_sql = "SELECT * FROM tbl_message where receiver = $user_id or receiver ='0'";
// $get_all_messages1_data = $con->prepare($get_all_messages1_sql);
// $get_all_messages1_data->execute();

if (isset($_GET['objid'])) {
  $objid = $_GET['objid'];

  $get_suppliers_sql = "SELECT * FROM tbl_suppliers WHERE objid = :objid";
  $suppliers_data = $con->prepare($get_suppliers_sql);
  $suppliers_data->execute([':objid' => $objid]);
  while ($result = $suppliers_data->fetch(PDO::FETCH_ASSOC)) {
    $objid = $result['objid'];
    $code = $result['code'];
    $name_supplier = $result['name_supplier'];
    $owner = $result['owner'];
    $product_lines = $result['product_lines'];
    $address = $result['address'];
    $contact_no = $result['contact_no'];
    $contact_person = $result['contact_person'];
    $telephone_no = $result['tel_no'];
    $fax_no = $result['fax_no'];
    $others = $result['others'];
  }
}

?>

<!DOCTYPE html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>DOCTRACK | Update Supplier</title>

<?php include('heading.php') ?>

<style>
  #required {
    color: red;
  }
</style>
</head>

<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php include('sidebar.php') ?>

    <div class="content-wrapper">
      <div class="content-header"></div>

      <section class="content">

        <div class="card">
          <div class="card-header bg-success">
            <h4>Update Supplier</h4>
          </div>

          <div class="card-body">
            <form role="form" method="post" action="update_for_suppliers.php">
              <div class="box-body">

                <div class="row" hidden>
                  <div class="col-md-3" style="text-align: right;padding-top: 5px;">
                    <label>Objid:</label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" readonly class="form-control" name="objid" placeholder="ID" value="<?php echo $objid; ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Code: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="code" placeholder="Supplier Code" value="<?php echo $code; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Name of Supplier: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="name_supplier" placeholder="Name of Supplier" value="<?php echo $name_supplier; ?>" required>
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Proprietor/Owner: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="owner" placeholder="Proprietor/Owner" value="<?php echo $owner; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Product Line: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" class="form-control" name="product_line" placeholder="Product Line" required><?php echo $product_lines; ?></textarea>
                  </div>
                </div><br>



                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Address: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="2" class="form-control" name="address" placeholder="Business Address" required><?php echo $address; ?></textarea>
                    <span style="font-style: italic; font-size:13px ; color:red">( Streeet / Lot #, City, Province, Country )</span>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Authorized Representative: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="contact_person" placeholder="Authorized Representative" value="<?php echo $contact_person; ?>" required>
                  </div>

                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Mobile #: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="contact_no" placeholder="Mobile Number" value="<?php echo $contact_no; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Telephone #: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="telephone_no" placeholder="Telephone Number" value="<?php echo $telephone_no; ?>" required>
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Fax #: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="fax_no" placeholder="Fax No." value="<?php echo $fax_no; ?>" required>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Others: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" class="form-control" name="others" placeholder="Others" required><?php echo $others; ?></textarea>
                  </div>
                </div><br>



                <!-- /.box-body -->
                <div class="box-footer" align="center">
                  <button type="submit" <?php echo $btnStatus; ?> name="update_suppliers" class="btn btn-success">
                    <h5>Submit Form</h5>
                  </button>

                </div>
              </div>
            </form>
          </div>
        </div>


      </section><br><br>
    </div>

    <?php include('footer.php') ?>
  </div>



</body>



</html>

<?php include('scripts.php') ?>

<?php

if (isset($_SESSION['status']) && $_SESSION['status'] != '') {

?>
  <script>
    swal({
      title: "<?php echo $_SESSION['status'] ?>",
      // text: "You clicked the button!",
      icon: "<?php echo $_SESSION['status_code'] ?>",
      button: "OK. Done!",
    });
  </script>

<?php
  unset($_SESSION['status']);
}
?>