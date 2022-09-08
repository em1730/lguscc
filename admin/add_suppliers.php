<?php


session_start();

$objid = $code = $name_supplier = $owner  = $address = $contact_no = $contact_person = $fax_no = $telephone_no = $others = $product_lines = '';
$btnNew = 'disabled';
$btnStatus = '';

if (!isset($_SESSION['id'])) {
  header('location:..../login.php');
}
$user_id = $_SESSION['id'];

include('../config/db_config.php');

// include('insert_suppliers.php');

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


?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DOCTRACK | Add Supplier</title>
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


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header"></div>


      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header bg-success">
            <h4>Add Supplier</h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form role="form" method="post" action="insert_suppliers.php">
              <div class="box-body">

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Code: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="code" name="code" onkeyup="this.value = this.value.toUpperCase();" placeholder="Supplier Code">
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Name of Supplier: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="name_supplier" onkeyup="this.value = this.value.toUpperCase();" name="name_supplier" placeholder="Name of Supplier">
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Proprietor/Owner: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="owner" name="owner" onkeyup="this.value = this.value.toUpperCase();" placeholder="Proprietor/Owner">
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Product Line: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" class="form-control" id="product_line" name="product_line" onkeyup="this.value = this.value.toUpperCase();" placeholder="Product Line"></textarea>
                  </div>
                </div><br>



                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Address: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="2" class="form-control" id="address" name="address" placeholder="Business Address" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                    <span style="font-style: italic; font-size:13px ; color:red">( Streeet / Lot #, City, Province, Country )</span>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Authorized Representative: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Authorized Representative" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Mobile #: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Mobile Number" onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Telephone #: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" class="form-control" id="telephone_no" name="telephone_no" placeholder="Telephone Number" onkeyup="this.value = this.value.toUpperCase();">
                  </div>

                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Fax #: <span id="required">*</span> </label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="fax_no" name="fax_no" placeholder="Fax No." onkeyup="this.value = this.value.toUpperCase();">
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Others: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-9">
                    <textarea rows="3" class="form-control" id="others" name="others" placeholder="Others" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                  </div>
                </div><br>

                <!-- /.box-body -->
                <div class="box-footer" align="center">
                  <!-- <input type="submit" <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New"> -->
                  <!-- <input type="submit" <?php echo $btnStatus; ?> name="insert_suppliers" class="btn btn-success" value="Submit Form"> -->

                  <button type="submit" id="btnSubmit" <?php echo $btnStatus; ?> name="insert_suppliers" class="btn btn-success">
                    <h5>Submit Form</h5>
                  </button>
                  <!-- <a href="committee">
                    <input type="button" name="cancel" class="btn btn-default" value="Cancel">
                  </a> -->
                </div>
              </div>
            </form>

          </div>

        </div>
      </section><br>
    </div>



    <?php include('footer.php') ?>
  </div>


  <?php include('scripts.php') ?>

  <script>
    $('#users').DataTable({
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': true,
      'autoHeight': true
    })
  </script>

  <script type="text/javascript">
    $("#btnSubmit").click(function() {
      var code = $('#code').val();
      var count_code = code.length;

      var supplier = $('#name_supplier').val();
      var count_supplier = supplier.length;

      var owner = $('#owner').val();
      var count_owner = owner.length;

      var productline = $('#product_line').val();
      var count_productline = productline.length;

      var address = $('#address').val();
      var count_address = address.length;

      var contactperson = $('#contact_person').val();
      var count_contactperson = contactperson.length;

      var contact_no = $('#contact_no').val();
      var count_contactno = contact_no.length;

      var telephone_no = $('#telephone_no').val();
      var count_telephone = telephone_no.length;

      var fax_no = $('#fax_no').val();
      var count_faxno = fax_no.length;

      var others = $('#others').val();
      var count_others = others.length;

      if (count_code == 0) {
        alert("Please input the Supplier Code!");
        $('#code').focus();
        return false;
      } else if (supplier == 0) {
        alert("Please input the Name of Supplier!");
        $('#name_supplier').focus();
        return false;
      } else if (count_owner == 0) {
        alert("Please input the Proprietor/Owner of the Supplier!");
        $('#owner').focus();
        return false;
      } else if (count_productline == 0) {
        alert("Please input the Product Line!");
        $('#product_line').focus();
        return false;
      } else if (count_address == 0) {
        alert("Please input the Address of Supplier!");
        $('#address').focus();
        return false;
      } else if (count_contactperson == 0) {
        alert("Please input the Authorized Representative!");
        $('#contact_person').focus();
        return false;
      } else if (count_contactno != 10) {
        alert("Please input 10-Digit Mobile Number!");
        $('#contact_no').focus();
        return false;
      } else if (count_telephone == 0) {
        alert("Please input Telephone Number!");
        $('#telephone_no').focus();
        return false;
      } else if (count_faxno == 0) {
        alert("Please input Fax Number!");
        $('#fax_no').focus();
        return false;
      } else if (count_others == 0) {
        alert("Please input Others!");
        $('#others').focus();
        return false;
      }




    });
  </script>


</body>

</html>