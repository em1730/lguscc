<?php


session_start();

$objid = $type = $description = $status  = $doc_code = $idno2 = $idno = '';
$btnNew = 'disabled';
$btnStatus = '';

if (!isset($_SESSION['id'])) {
  header('location:../index');
}
$user_id = $_SESSION['id'];

include('../config/db_config.php');
// include('insert_document.php');

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


if (isset($_GET['idno'])) {
  $idno = $_GET['idno'];

  $get_suppliers_sql = "SELECT * FROM document_type WHERE idno = :idno";
  $suppliers_data = $con->prepare($get_suppliers_sql);
  $suppliers_data->execute([':idno' => $idno]);
  while ($result = $suppliers_data->fetch(PDO::FETCH_ASSOC)) {
    $idno2 = $result['idno'];
    $objid = $result['objid'];
    $type = $result['type'];
    $description = $result['description'];
    // $status = $result['status'];
  }
}

?>
<!DOCTYPE html>
<html>


<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DOCTRACK | Update Document</title>
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
            <h4>Update Document Type</h4>
          </div>
          <div class="card-body">

            <form role="form" method="post" action="update_documenttype.php">
              <div class="box-body">

                <div class="row" hidden>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>ID #: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" readonly class="form-control" name="idno" id="idno" placeholder="ID Number" value="<?php echo $idno2 ?>">
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Code: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="doc_code" id="doc_code" onblur="checkCode()" placeholder="Document Code" value="<?php echo $objid ?>">
                    <!-- <span style="font-style: italic; font-size:13px ; color:red">( Streeet / Lot #, City, Province, Country )</span> -->
                    <div id="status"></div>
                  </div>
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Type: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-3">
                    <input type="text" class="form-control" name="type" id="type" placeholder="Document Type" value="<?php echo $type ?>">
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Description: <span id="required">*</span></label>
                  </div>
                  <div class="col-md-8">
                    <textarea rows="5" class="form-control" name="description" id="description" placeholder="Description"><?php echo $description ?></textarea>
                  </div>
                </div><br>

                <!-- <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Status</label>
                  </div>
                  <div class="col-md-3">

                    <select class="form-control select2" style="width: 100%;" name="status" value="<?php echo $status; ?>">
                      <option>Please select...</option>
                      <option <?php if ($status == 'Active') echo 'selected'; ?> value="Active">Active </option>
                      <option <?php if ($status == 'Inactive') echo 'selected'; ?> value="Inactive">Inactive </option>

                    </select>
                  </div>
                </div><br> -->


                <div class="box-footer" align="center">
                  <!-- <input type="submit" <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New"> -->
                  <!-- <input type="submit" <?php echo $btnStatus; ?> name="insert_document" class="btn btn-primary" value="Save"> -->
                  <button type="submit" id="btnSubmit" <?php echo $btnStatus; ?> name="update_documenttype" class="btn btn-success">
                    <h5>Update</h5>
                  </button>

                  <!-- <a href="committee">
                  <input type="button" name="cancel" class="btn btn-default" value="Cancel">
                </a> -->
                </div>


              </div>

              <!-- footer -->


            </form>
          </div>
        </div><br>





      </section>


    </div>



    <?php include('footer.php') ?>
  </div>


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


  <script type="text/javascript">
    function checkCode() {
      var doc_code = $('#doc_code').val();
      if (doc_code.length >= 2) {
        $("#status").html('<img src="loader.gif" /> Checking availability...');
        $.ajax({
          type: 'POST',
          data: {
            doc_code: doc_code
          },
          url: 'check_code.php',
          success: function(data) {
            $("#status").html(data);

          }
        });
      }
    }
  </script>


</body>

</html>