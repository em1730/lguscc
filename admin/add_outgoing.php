<?php

session_start();

include('../config/credentials.php');
//document type masterlist
include('../masterlisting/list_doctype.php');
//department masterlist
include('../masterlisting/list_department.php');

if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}


$docno = $date  = $type = $particulars = $origin = $btnStatus =
  $destination = $amount = $status    = $remarks = $btnNew = $get_docno =
  $get_particular = $get_remarks = $btnPrint = $get_docu =  $get_dept ='';

$btnStatus = '';
// if(!empty($_POST['type'])) {
//   $list_doctype = $_POST['type'];

// }

if (isset($_GET['docno'])) {

  $docno = $_GET['docno'];


  $get_barangaydata_sql = "SELECT * FROM tbl_ledger


  WHERE docno = :docno";
  $barangay_data = $db_dts->prepare($get_barangaydata_sql);
  $barangay_data->execute([':docno' => $docno]);
  while ($result = $barangay_data->fetch(PDO::FETCH_ASSOC)) {
    $get_docno   = $result['docno'];
    $get_particular = $result['particulars'];
    $get_remarks =  $result['remarks'];
    $get_dept = $result['destination'];
    $get_docu =  $result['type'];
  }
}





$now = new DateTime();


// include('insert_outgoing.php');






?>



<!DOCTYPE html>
<html>



<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> DOCTRACK | Forward Document</title>
  <?php include('heading.php'); ?>
</head>


<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php include('sidebar.php') ?>


    <div class="content-wrapper">

      <div class="content-header"></div>

      <section class="content">
        <div class="card">
          <div class="card-header bg-dark">
            <h4>Forward Documents</h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="insert_outgoing.php">
              <div class="box-body">

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Document No.:</label>
                  </div>
                  <div class="col-md-4">
                    <input type="text" readonly class="form-control" id="doc_no" name="doc_number" placeholder="Document Number" value="<?php echo $get_docno; ?>">
                  </div>

                  <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                    <label>Date:</label>
                  </div>

                  <div class="col-md-3">
                    <!-- Date -->
                    <div class="form-group">
                      <!-- <label>Date:</label> -->
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" readonly class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo $now->format('m/d/Y'); ?>">
                      </div>
                    </div>
                  </div>

                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <!-- <div class="form-group"> -->
                    <label>Document Type:</label>
                  </div>

                  <div class="col-md-8">
                    <select class="form-control select2" id="select_type" style="width: 100%;" name="type" value="">
                      <option selected="selected">Please select...</option>
                      <?php foreach ($list_doctype as $doctype) { ?>
                        <option value="<?php echo $doctype['objid']; ?>" <?php if ($get_docu == $doctype['objid']) echo 'selected="selected"'; ?>><?php echo $doctype['type']; ?></option>
                      <?php } ?>

                    </select>
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Subject/Particulars:</label>
                  </div>
                  <div class="col-md-8">
                    <textarea rows="5" class="form-control" id="particulars" name="particulars" style=" text-transform: uppercase;" placeholder="Subject/Particulars"><?php echo $get_particular; ?></textarea>
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <!-- <div class="form-group"> -->
                    <label>Forwarded To:</label>
                  </div>

                  <div class="col-md-8">
                    <select class="form-control select2" readonly id="receiver" style="width: 100%;" name="receiver" value="<?php echo $destination; ?>">
                      <option selected="selected">Please select...</option>
                      <?php foreach ($list_department as $department) { ?>

                        <option value="<?php echo $department['objid']; ?>" <?php if ($get_dept == $department['objid']) echo 'selected="selected"'; ?>><?php echo $department['department']; ?></option>

                      <?php  }   ?>
                    </select>
                  </div>
                </div><br>

                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>Remarks:</label>
                  </div>

                  <div class="col-md-8">
                    <textarea rows="5" style=" text-transform: uppercase;" class="form-control" name="remarks" id="remarks" placeholder="Remarks"><?php echo $get_remarks; ?></textarea>
                  </div>
                </div><br>


                <div class="box-footer" align="center">
                  <input type="button" <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
                  <!-- <input type="submit" <?php echo $btnStatus; ?> name="insert_outgoing" class="btn btn-primary" value="Save"> -->

                  <input type="submit" <?php echo $btnStatus; ?> id="btn_submit" name="insert_outgoing" class="btn btn-success" value="Submit">
                    <!-- <h6>Submit</h6> -->
               

                  <a href="../plugins/TCPDF/User/routing.php?docno=<?php echo $get_docno; ?>" target="blank">
                    <input type="button" <?php echo $btnPrint; ?> name="print" class="btn btn-primary" value="Print">
                  </a>



                  <!-- <a href="list_outgoing">
                    <input type="button" name="cancel" class="btn btn-default" value="Cancel">
                  </a> -->
                </div>

                <div class="col-md-10">
                  <input type="hidden" id="department" readonly class="form-control" name="department" placeholder="Department" value="<?php echo $db_department; ?>">
                </div>
                <div class="col-md-10">
                  <input type="hidden" readonly class="form-control" name="username" placeholder="username" value="<?php echo $db_user_name; ?>">
                </div>
              </div><br>

              <!-- /.box-body -->

            </form>
          </div>
        </div>

      </section>
      <br>

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


<script>
  $('#select_type').on('change', function() {
    var type = $(this).val();
    var office = $('#department').val();
    //  $('#doc_no').val(type);
    if (type == "DV" || type == "OBR" || type == "DWP" || type == "PYL" || type == "LR" || type == "RIS" || type == "PO" || type == "PR") {
      window.open("add_outgoing_dv.php?type=" + type, '_parent');

    } else {

      $.ajax({
        type: 'POST',
        data: {
          type: type,
          office: office
        },
        url: 'generate_serial.php',
        success: function(data) {
          $('#doc_no').val(data);

        }


      });
    }
  });

  $("#btn_submit").click(function() {

    var doctype = $('#select_type :selected').text();
    var receiver = $('#receiver :selected').text();

    var particulars = $('#particulars').val();
    var particularscount = particulars.length;

    var remarks = $('#remarks').val();
    var remarkscount = remarks.length;

    if (doctype == 'Please select...') {
      alert("Select Type of Document!");
      $('#select_type').select2('open');
      return false;
    } else if (particularscount == 0) {
      alert("Fill up the particulars or description of the document!");
      $('#particulars').focus();
      return false;
    } else if (receiver == 'Please select...') {
      alert("Select any department to forward the document!");
      $('#receiver').select2('open');
      return false;
    } else if (remarkscount == 0) {
      alert("Please fill up the remarks!");
      $('#remarks').focus();
      return false;
    }


  });
</script>