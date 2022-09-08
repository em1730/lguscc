<?php


session_start();

$objid = $department =  $status  = $fname = $last = $middle = $idnumber = $control = $rate = '';
$btnNew = 'disabled';
$btnStatus = '';

if (!isset($_SESSION['id'])) {
  header('location:../index');
}
$user_id = $_SESSION['id'];

include('../config/db_config.php');
// include('insert_jobOrder.php');

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
$get_all_department_sql = "SELECT * FROM tbl_department";
$get_all_department_data = $con->prepare($get_all_department_sql);
$get_all_department_data->execute();

// $get_all_status_sql = "SELECT * FROM tbl_status";
// $get_all_status_data = $con->prepare($get_all_status_sql);
// $get_all_status_data->execute(); 

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DOCTRACK | Add Job Order</title>
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
            <h4>Add Job Order</h4>
          </div>
          <div class="card-body">
            <form role="form" method="post" action="insert_jobOrder.php">
              <div class="box-body">


                <!-- <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                   <label>Job Order ID:</label>
                  </div>
                  <div class="col-md-10">
                      <input type="text" class="form-control" name="idnumber" placeholder="Job Order ID" value="<?php echo $idnumber; ?>" required>
                  </div>
                </div><br> -->
                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Control Number: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="controlNumber" name="controlNumber" onkeyup="this.value = this.value.toUpperCase();" placeholder="Type N/A if not applicable!" value="<?php echo $control; ?>">
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>First Name: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $fname; ?>" required>
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Rate Per Day: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="rate" name="rate" placeholder="Rate Per Day" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $rate; ?>">
                  </div>

                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Middle Name: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $middle; ?>">
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Last Name: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $last; ?>" required>
                  </div>

                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <!-- <div class="form-group"> -->
                    <label>Department/Office: <span id="required">*</span></label>
                  </div>

                  <div class="col-md-5">
                    <select class="form-control select2" readonly style="width: 100%;" id="department" name="department" onkeyup="this.value = this.value.toUpperCase();" value="<?php echo $department; ?>">
                      <option selected>Please Select Department</option>
                      <?php while ($get_dept = $get_all_department_data->fetch(PDO::FETCH_ASSOC)) { ?>

                        <?php
                        //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                        //if equals, put 'selected' sa option
                        $selected = ($department == $get_dept['objid']) ? 'selected' : '';

                        ?>

                        <option <?= $selected; ?> value="<?php echo $get_dept['objid']; ?>"><?php echo $get_dept['department']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div><br>


                <!-- /.box-body -->
                <div class="box-footer" align="center">
                  <!-- <input type="submit" <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New"> -->
                  <!-- <input type="submit" <?php echo $btnStatus; ?> name="insert_jobOrder" class="btn btn-primary" value="Save"> -->

                  <button type="submit" id="btnSubmit" <?php echo $btnStatus; ?> name="insert_document" class="btn btn-success">
                    <h5>Submit Form</h5>
                  </button>


                  <!-- <a href="department">
                    <input type="button" name="cancel" class="btn btn-default" value="Cancel">
                  </a> -->
                </div>
            </form>
          </div>
        </div>

      </section>
    </div>



    <?php include('footer.php') ?>
  </div>



</body>

</html>



<?php include('scripts.php') ?>


<SCript>
  $("#btnSubmit").click(function() {

    var controlno = $('#controlNumber').val();
    var count_controlno = controlno.length;


    var firstname = $('#firstname').val();
    var count_firstname = firstname.length;

    var rate = $('#rate').val();
    var count_rate = rate.length;


    var middlename = $('#middlename').val();
    var count_middlename = middlename.length;

    var lastname = $('#lastname').val();
    var count_lastname = lastname.length;

    var depart = $('#department :selected').text();


    if (count_controlno == 0) {
      alert("Please input Control Number!");
      $('#controlNumber').focus();
      return false;
    } else if (count_firstname == 0) {
      alert("Please input Firstname!");
      $('#firstname').focus();
      return false;
    } else if (count_rate == 0) {
      alert("Please input JO Rate!");
      $('#rate').focus();
      return false;
    } else if (count_middlename == 0) {
      alert("Please input Middlename!");
      $('#middlename').focus();
      return false;
    } else if (count_lastname == 0) {
      alert("Please input Lastname!");
      $('#lastname').focus();
      return false;
    } else if (depart == 'Please Select Department') {
      alert("Please select Department!");
      $('#department').focus();
      return false;
    }



  });
</SCript>