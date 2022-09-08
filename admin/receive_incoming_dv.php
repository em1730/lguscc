<?php


session_start();




if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];



$alert_msg = '';
$docno = $doc_no = $prevyear = $new_obr =  $pr_no = $po_no =  $etal = $date = $type = $particulars = $origin = $destination = $obr_no = $account = $dv_no = $cheque_no = $acct_no  = $payee =  $status = $date_received = $remarks = $user_name = '';
$amount = '0';
$btnNew = 'disabled';
$btnPrint = 'disabled';
$btnStatus = '';

$now = new DateTime();


include('../config/db_config.php');
// include('insert_received_dv.php');
//include('update_documents_dv.php');
// include('update_settings.php');

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
  $user_name = $result['username'];
  $department = $result['department'];
}

if (isset($_GET['docno'])) {
  $docno = $_GET['docno'];
  //select all incoming documents
  $get_all_incoming_sql = "SELECT * FROM tbl_documents where docno = :doc"; // and destination = '$department'";
  $get_all_incoming_data = $con->prepare($get_all_incoming_sql);
  $get_all_incoming_data->execute([':doc' => $docno]);
  while ($result = $get_all_incoming_data->fetch(PDO::FETCH_ASSOC)) {
    $doc_no = $result['docno'];
    $date = $result['date'];
    $type = $result['type'];
    $prevyear = $result['prevyear'];
    $obr_no = $result['obrno'];
    $new_obr = $result['newobr'];
    $prno = $result['prno'];
    $pono = $result['pono'];
    $account = $result['acctype'];
    $dv_no = $result['dvno'];
    $account_no = $result['acctno'];
    $cheque_no = $result['chequeno'];
    $payee = $result['payee'];
    $etal = $result['etal'];
    $particulars = $result['particulars'];
    $origin = $result['origin'];
    $amount = $result['amount'];
    $status = $result['status'];
    $remarks = $result['remarks'];
  }
}


//select all incoming documents
$get_all_doctype_sql = "SELECT * FROM document_type";
$get_all_doctype_data = $con->prepare($get_all_doctype_sql);
$get_all_doctype_data->execute();





//select all departments
$get_all_dept_sql = "SELECT * FROM tbl_department";
$get_all_dept_data = $con->prepare($get_all_dept_sql);
$get_all_dept_data->execute();

//select all payee
$get_all_payee_sql = "SELECT code, name_supplier from tbl_suppliers 
UNION
select objid, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_joborder 
UNION
select employeeno, CONCAT(firstname, ' ', middlename, ' ', lastname) from tbl_employee
ORDER BY name_supplier";


$get_all_payee_data = $con->prepare($get_all_payee_sql);
$get_all_payee_data->execute();


//select all account type
$get_all_account_sql = "SELECT * FROM tbl_accounts";
$get_all_account_data = $con->prepare($get_all_account_sql);
$get_all_account_data->execute();


$get_all_settings_sql = "SELECT * FROM tbl_settings";
$get_all_settings_data = $con->prepare($get_all_settings_sql);
$get_all_settings_data->execute();
$get_all_settings_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result = $get_all_settings_data->fetch(PDO::FETCH_ASSOC)) {
  $settings_obr =  $result['obrno'];
  $settings_prevobr = $result['prevobrno'];
  $settings_dv = $result['dvno'];
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DOCTRACK | Receive Document</title>
  <?php include('heading.php') ?>

  <style>
    .field_set {
      border-color: green;
      border-style: solid;

      width: 115%;


    }

    #padd {
      padding-left: 20px;
    }

    #padd2 {
      padding-left: 10px;
    }

    #fieldset {
      color: #31A231;
      width: 12%;
      padding: 10px 10px;

    }

    #fieldset_verify {
      color: #31A231;
      width: 9%;
      padding: 5px 10px;

    }
  </style>

</head>


<body class="hold-transition sidebar-mini ">
  <div class="wrapper">


    <?php include('sidebar.php') ?>

    <div class="content-wrapper">
      <div class="content-header"></div>





      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-8">

              <section class="content">
                <div class="card">
                  <div class="card-header bg-success">
                    <h4>Receive Document</h4>
                  </div>
                  <div class="card-body">
                    <form role="form" method="post" action="insert_received_dv.php">

                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <label>Document No.:</label>
                        </div>
                        <div class="col-md-3">
                          <input type="text" readonly class="form-control" id="doc_no" name="doc_no" placeholder="Document Number" value="<?php echo $doc_no; ?>" required>
                        </div>

                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <label>Date:</label>
                        </div>
                        <div class="col-md-4">
                          <!-- Date -->
                          <div class="form-group">
                            <!-- <label>Date:</label> -->
                            <div class="input-group date" data-provide="datepicker">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker" name="date" placeholder="Date Created" value="<?php echo $now->format('m/d/Y');; ?>">
                            </div>
                          </div>
                        </div>
                      </div><br>

                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <!-- <div class="form-group"> -->
                          <label>Document Type:</label>
                        </div>
                        <div class="col-md-9">
                          <select class="form-control select2" id="select_type" readonly style="width: 100%;" name="type" value="<?php echo
                                                                                                                                  $type; ?>">
                            <option>Please select...</option>
                            <?php while ($get_doctype = $get_all_doctype_data->fetch(PDO::FETCH_ASSOC)) { ?>

                              <?php
                              //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                              //if equals, put 'selected' sa option
                              $selected = ($type == $get_doctype['objid']) ? 'selected' : '';

                              ?>

                              <option <?= $selected; ?> value="<?php echo $get_doctype['objid']; ?>"><?php echo $get_doctype['description']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div><br>

                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <!-- <div class="form-group"> -->

                          <label>Payee:</label>
                        </div>
                        <div class="col-md-7">

                          <select class="form-control select2" readonly required style="width: 100%;" id="payee" name="payee" value="<?php echo $origin; ?>">
                            <option>Please select...</option>
                            <?php while ($get_payee = $get_all_payee_data->fetch(PDO::FETCH_ASSOC)) { ?>

                              <?php
                              //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                              //if equals, put 'selected' sa option
                              $selected = ($payee == $get_payee['name_supplier']) ? 'selected' : '';

                              ?>

                              <option <?= $selected; ?> value="<?php echo $get_payee['name_supplier']; ?>"><?php echo ucwords(strtolower($get_payee['name_supplier'])); ?></option>
                            <?php } ?>
                          </select>
                          <!-- <p>NOTE: <code>Search first the name of payee. If "No Results Found", Click the ADD Button</code>
                          <code> to register NEW payee and click REFRESH once done. Check the et Al. for multiple payees. </code>
                          </p>               
                        -->
                        </div>
                        <div class="col-md-.1">
                          <div class="input-group input-group-sm">
                            <span class="input-group-append">
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"> ADD </button>
                              <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="add_suppliers.php" target="_blank">Supplier</a></li>
                                <!-- <li class="dropdown-item"><a href="add_joborder.php" target="_blank">Job Order</a></li> -->
                                <!-- <li class="dropdown-item"><a href="add_joborder.php" target="_blank">Regular Employee</a></li> -->
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item" id="refresh">Refresh</li>
                              </ul>
                            </span>
                          </div>
                        </div>
                        <div class="form-check">
                          &nbsp; &nbsp;<input <?php if ($etal == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="exampleCheck1" name="etc" value="etal">
                          <label class="form-check-label" for="exampleCheck1">et Al.</label>
                        </div>

                      </div><br>

                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <label>Particulars:</label>
                        </div>
                        <div class="col-md-9">
                          <textarea rows="3" class="form-control" name="particulars" placeholder="Subject/Particulars" required><?php echo $particulars; ?></textarea>
                        </div>
                      </div><br>


                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <label>Amount:</label>
                        </div>
                        <div class="col-md-3">
                          <input required type="text" class="form-control" id="amount" name="amount" placeholder="Amount" value="<?php echo number_format($amount, 2); ?>" required>
                        </div>
                        <p>NOTE: <code>Numbers & decimal point only, do not use comma (,)</code></p>
                      </div><br>


                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <!-- <div class="form-group"> -->
                          <label>Originating Office:</label>
                        </div>

                        <div class="col-md-9">
                          <select class="form-control select2" readonly style="width: 100%;" name="origin" value="<?php echo $origin; ?>">
                            <option>Please select...</option>
                            <?php while ($get_dept = $get_all_dept_data->fetch(PDO::FETCH_ASSOC)) { ?>

                              <?php
                              //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                              //if equals, put 'selected' sa option
                              $selected = ($origin == $get_dept['objid']) ? 'selected' : '';

                              ?>

                              <option <?= $selected; ?> value="<?php echo $get_dept['objid']; ?>"><?php echo $get_dept['department']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div><br>

                      <div class="row">
                        <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                          <label>Remarks:</label>
                        </div>
                        <div class="col-md-9">
                          <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks" value="<?php echo $remarks; ?>" required>
                        </div>
                      </div><br>




                      <div class="box-footer" align="center">
                        <!-- <input type="submit" <?php echo $btnNew; ?> name="add" class="btn btn-success" value="New"> -->
                        <input type="submit" <?php echo $btnStatus; ?> name="insert_received" class="btn btn-success" value="Receive">
                        <!-- <a href="../plugins/TCPDF/User/routing.php?docno=<?php echo $docno; ?>" target="blank">
                          <input type="button" <?php echo $btnPrint; ?> name="print" class="btn btn-success" value="Print">
                        </a> -->
                        <a href="list_incoming.php">
                          <input type="button" name="cancel" class="btn btn-danger" value="Cancel">
                        </a>
                      </div>


                      <div class="col-md-10">
                        <input type="hidden" id="department" readonly class="form-control" name="department" placeholder="Department" value="<?php echo
                                                                                                                                              $department; ?>">
                      </div>

                      <div class="col-md-10">
                        <input type="hidden" readonly class="form-control" id="username" name="username" placeholder="username" value="<?php echo
                                                                                                                                        $user_name; ?>" required>
                      </div>






                    </form>


                  </div>
                </div>
              </section>

            </div>
            <div class="col-md-4">

              <section class="content">

                <!-- bac card -->
                <div <?php if ($department == 'BAC') { ?> class="card card-success" <?php } else { ?> class="card" <?php } ?>>
                  <div class="card-header bg-success">
                    <h4 class="m-0">BAC</h4>
                  </div>
                  <div class="card-body">

                    <!-- for PR -->
                    <div class="row">
                      <!-- <div class="col-md-4" style="text-align: right;padding-top: 3px;"> -->
                      <label>PR No.:</label>
                      <!-- </div> -->
                      <div class="col-md-8" style="width: 100;">
                        <input <?php if ($department != 'BAC') { ?> readonly <?php } ?> type="text" class="form-control" id="pr_no" name="pr_number" placeholder="PR Number" value="<?php echo
                                                                                                                                                                                    $pr_no; ?>">
                      </div>
                    </div></br>
                    <!-- for PR -->

                    <!-- for PO -->
                    <div class="row">
                      <!-- <div class="col-md-4" style="text-align: right;padding-top: 3px;"> -->
                      <label>PO No.:</label>
                      <!-- </div> -->
                      <div class="col-md-8">
                        <input <?php if ($department != 'BAC') { ?> readonly <?php } ?> type="text" class="form-control" id="po_no" name="po_number" placeholder="PO Number" value="<?php echo
                                                                                                                                                                                    $po_no; ?>">
                      </div>
                    </div>
                    <!-- for PO -->

                  </div>
                </div>
                <!-- end of bac card -->

                <!-- budget card -->
                <div <?php if ($department == 'CBO') { ?> class="card card-success" <?php } else { ?> class="card " <?php } ?>>
                  <div class="card-header bg-success">
                    <h4 class="m-0">BUDGET</h4>

                  </div>
                  <div class="card-body">

                    <!-- for PR -->
                    <div class="row">

                      <!-- <div class="col-md-8" style="text-align: right;padding-top: 5px;"> -->
                      <div class="col-md-6">
                        <div class="form-check">
                          &nbsp; &nbsp;<input <?php if ($department != 'CBO') { ?> disabled <?php } ?> <?php if ($prevyear == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="prev_year" name="prev_year" value="prevyear">
                          <label class="form-check-label" for="prev_year">Previous Year?</label>
                        </div>
                      </div></br>

                      <div class="col-md-6  ">
                        <div class="form-check">
                          &nbsp; &nbsp;<input <?php if ($department != 'CBO') { ?> disabled <?php } ?> <?php if ($new_obr == 1) echo 'checked="checked"'; ?> type="checkbox" class="form-check-input" id="new_obr" name="new_obr" value="prevyear">
                          <label class="form-check-label" for="exampleCheck1">New OBR No.?</label>
                        </div>

                      </div></br>
                    </div></br>

                    <div class="row">
                      <!-- <div class="col-md-4" style="text-align: right;padding-top: 5px;"> -->
                      <label>OBR No.:</label>
                      <!-- </div> -->
                      <div class="col-md-8">
                        <input type="text" readonly class="form-control" id="obr_no" name="obr_number" placeholder="OBR Number" value="<?php echo $obr_no; ?>" required>
                      </div>
                    </div>
                    <!-- for PR -->

                  </div>
                </div>
                <!-- end of budget card -->


                <!-- accounting card -->
                <div <?php if ($department == 'ACCTG') { ?> class="card card-success" <?php } else { ?> class="card " <?php } ?>>
                  <div class="card-header bg-success">
                    <h4>ACCOUNTING</h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <label>Fund:</label>
                      <div class="col-md-8">
                        <select <?php if ($department != 'ACCTG') { ?> disabled <?php } ?> class="form-control select2" style="width: 100%;" id="select_account" name="account" value="<?php echo $account; ?>">
                          <option>Please select...</option>
                          <?php while ($get_account = $get_all_account_data->fetch(PDO::FETCH_ASSOC)) { ?>

                            <?php
                            //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                            //if equals, put 'selected' sa option
                            $selected = ($account == $get_account['code']) ? 'selected' : '';

                            ?>

                            <option <?= $selected; ?> value="<?php echo $get_account['code']; ?>"><?php echo $get_account['account']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div><br>

                    <div class="row">

                      <label>DV No.:</label>

                      <div class="col-md-8">
                        <input <?php if ($department != 'ACCTG') { ?> readonly <?php } ?> type="text" class="form-control" id="dv_no" name="dv_number" placeholder="DV Number" value="<?php echo $dv_no; ?>">
                      </div>
                    </div>



                  </div>
                </div>
                <!-- end of accounting -->




                <div <?php if ($department == 'CTO') { ?> class="card card-success" <?php } else { ?> class="card " <?php } ?>>
                  <div class="card-header bg-success">
                    <h4>TREASURER</h>
                  </div>
                  <div class="card-body">



                    <!-- Account Number & Cheque No. -->
                    <div class="row">
                      <!-- <div class="col-md-4" style="text-align: right;padding-top: 5px;"> -->
                      <label>Account No.:</label>
                      <!-- </div> -->
                      <div class="col-md-8">
                        <input type="text" <?php if ($department != 'CTO') { ?> readonly <?php } ?> class="form-control" id="dv_no" name="acct_number" placeholder="DV Number" value="<?php echo
                                                                                                                                                                                      $acct_no; ?>" required>
                      </div>
                    </div><br>

                    <div class="row">
                      <!-- <div class="col-md-4" style="text-align: right;padding-top: 5px;"> -->
                      <label>Cheque No.:</label>
                      <!-- </div> -->
                      <div class="col-md-8">
                        <input <?php if ($department != 'CTO') { ?> readonly <?php } ?> type="text" readonly class="form-control" id="cheque_no" name="cheque_number" placeholder="Cheque Number" value="<?php echo
                                                                                                                                                                                                          $cheque_no; ?>" required>
                      </div>
                    </div>

                    <!-- Account Number & Cheque No. -->

                  </div>
                </div>





              </section>


            </div>


          </div>


        </div>




      </section><br><br>








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


  <script>
    $('#update_obr').on('change', function() {

      // function receive(){
      var obr = document.getElementById("update_obr").value;

      //  alert (docno);

      $.ajax({
        type: 'POST',
        data: {
          obr: obr
        },
        url: 'update_obr.php',
        success: function(data) {
          var result = $.parseJSON(data);
          alert(data)
          //  document.getElementById('lblDate').innerHTML = result.date;
          //  document.getElementById('lblTime').innerHTML = result.time;
          //  document.getElementById('lblType').innerHTML = result.type;
          //  document.getElementById('lblParticulars').innerHTML = result.particulars;
          //  document.getElementById('lblOrigin').innerHTML = result.origin;
          //  document.getElementById('lblDestination').innerHTML = result.destination;
          //  document.getElementById('lblRemarks').innerHTML = result.remarks;
          //  document.getElementById('lblMessage').innerHTML = result.message;

        }

      });

      // document.getElementById('scan_track').focus();
      // document.getElementById('scan_track').select();

      //

      location.reload();
    });

    $('#update_prevobr').on('change', function() {

      // function receive(){
      var obr = document.getElementById("update_prevobr").value;

      //  alert (docno);

      $.ajax({
        type: 'POST',
        data: {
          obr: obr
        },
        url: 'update_prevobr.php',
        success: function(data) {
          var result = $.parseJSON(data);
          alert(data)
          //  document.getElementById('lblDate').innerHTML = result.date;
          //  document.getElementById('lblTime').innerHTML = result.time;
          //  document.getElementById('lblType').innerHTML = result.type;
          //  document.getElementById('lblParticulars').innerHTML = result.particulars;
          //  document.getElementById('lblOrigin').innerHTML = result.origin;
          //  document.getElementById('lblDestination').innerHTML = result.destination;
          //  document.getElementById('lblRemarks').innerHTML = result.remarks;
          //  document.getElementById('lblMessage').innerHTML = result.message;

        }

      });

      // document.getElementById('scan_track').focus();
      // document.getElementById('scan_track').select();

      //

      location.reload();
    });

    $('#update_dv').on('change', function() {

      // function receive(){
      var dv = document.getElementById("update_dv").value;

      //  alert (docno);

      $.ajax({
        type: 'POST',
        data: {
          dv: dv
        },
        url: 'update_dv.php',
        success: function(data) {
          var result = $.parseJSON(data);
          alert(data)
          //  document.getElementById('lblDate').innerHTML = result.date;
          //  document.getElementById('lblTime').innerHTML = result.time;
          //  document.getElementById('lblType').innerHTML = result.type;
          //  document.getElementById('lblParticulars').innerHTML = result.particulars;
          //  document.getElementById('lblOrigin').innerHTML = result.origin;
          //  document.getElementById('lblDestination').innerHTML = result.destination;
          //  document.getElementById('lblRemarks').innerHTML = result.remarks;
          //  document.getElementById('lblMessage').innerHTML = result.message;

        }

      });

      // document.getElementById('scan_track').focus();
      // document.getElementById('scan_track').select();

      //
      location.reload();

    });


    $('#prev_year').click(function() {
      var office = $('#department').val();

      if (this.checked && office == 'CBO') {
        checkPrevYear();
      } else if (!this.checked && office == 'CBO') {
        checkCurrentYear();
      }
    });

    $('#new_obr').click(function() {
      if (this.checked) {
        generateNewOBR();
      } else {
        location.reload();
      }
    });


    $('#select_account').on('change', function() {
      var checkBox = document.getElementById("prev_year");

      if (checkBox.checked == true) {
        var account = $(this).val();
        var type = $('#select_type').val();
        var office = $('#department').val();
        var dvno = $('#dv_no').val();
        var user = $('#username').val();
        // alert (user);

        $.ajax({
          type: 'POST',
          data: {
            account: account,
            office: office,
            type: type,
            dv: dvno,
            user: user
          },
          url: 'generate_dv.php',
          success: function(data) {
            $('#dv_no').val(data);
          }
        });
      } else {
        var account = $(this).val();
        var type = $('#select_type').val();
        var office = $('#department').val();
        var dvno = $('#dv_no').val();
        var user = $('#username').val();
        // alert (user);


        $.ajax({
          type: 'POST',
          data: {
            account: account,
            office: office,
            type: type,
            dv: dvno,
            user: user
          },
          url: 'generate_dv.php',
          success: function(data) {
            $('#dv_no').val(data);


          }

        });

      }
    });



    // $('#select_type').on('change',function(){
    //      var type = $(this).val();
    //     //  $('#doc_no').val(type);


    //     $.ajax({
    //       type:'POST',
    //       data:{type:type},
    //       url:'generate_serial.php',
    //        success:function(data){
    //      $('#doc_no').val(data);


    //     } 

    //         });           

    //               });

    function checkYear() {
      var checkBox = document.getElementById("prev_year");

      if (checkBox.checked == true) {

        var type = $('#select_type').val();
        var docno = $('#doc_no').val();
        var office = $('#department').val();
        var obr = $('#obr_no').val();
        var dvno = $('#dv_no').val();
        // document.getElementById('obr_no').value="";



        $.ajax({
          type: 'POST',
          data: {
            type: type,
            office: office,
            obr: obr,
            dv: dvno,
            docno: docno
          },
          url: 'generate_prevobr.php',
          success: function(data) {
            // var result = $.parseJSON(data);
            // $('#doc_no').val(result.docno);

            $('#obr_no').val(data);

          }


        });



      } else if (checkBox.checked == false) {

        var type = $('#select_type').val();
        var docno = $('#doc_no').val();
        var office = $('#department').val();
        var obr = $('#obr_no').val();
        var dvno = $('#dv_no').val();




        $.ajax({
          type: 'POST',
          data: {
            type: type,
            office: office,
            obr: obr,
            dv: dvno,
            docno: docno
          },
          url: 'generate_obr.php',
          success: function(data) {
            // var result = $.parseJSON(data);
            // $('#doc_no').val(result.docno);

            $('#obr_no').val(data);

          }


        });

        var account = $(this).val();
        var type = $('#select_type').val();
        var office = $('#department').val();
        var dvno = $('#dv_no').val();


        $.ajax({
          type: 'POST',
          data: {
            account: account,
            office: office,
            type: type,
            dv: dvno
          },
          url: 'generate_dv.php',
          success: function(data) {
            $('#dv_no').val(data);


          }

        });



      }
    }

    function checkPrevYear() {

      var type = $('#select_type').val();
      var docno = $('#doc_no').val();
      var office = $('#department').val();
      var obr = $('#obr_no').val();
      var dvno = $('#dv_no').val();
      // document.getElementById('obr_no').value="";



      $.ajax({
        type: 'POST',
        data: {
          type: type,
          office: office,
          obr: obr,
          dv: dvno,
          docno: docno
        },
        url: 'generate_prevobr.php',
        success: function(data) {
          // var result = $.parseJSON(data);
          // $('#doc_no').val(result.docno);

          $('#obr_no').val(data);;
        }
      });
    }

    function checkCurrentYear() {

      var type = $('#select_type').val();
      var docno = $('#doc_no').val();
      var office = $('#department').val();
      var obr = "";
      var dvno = $('#dv_no').val();
      // document.getElementById('obr_no').value="";



      $.ajax({
        type: 'POST',
        data: {
          type: type,
          office: office,
          obr: obr,
          dv: dvno,
          docno: docno
        },
        url: 'generate_obr.php',
        success: function(data) {
          // var result = $.parseJSON(data);
          // $('#doc_no').val(result.docno);

          $('#obr_no').val(data);

        }
      });
    }

    function generateNewOBR() {

      var type = $('#select_type').val();
      var docno = $('#doc_no').val();
      var office = $('#department').val();
      var obr = "";
      var dvno = $('#dv_no').val();
      // document.getElementById('obr_no').value="";



      $.ajax({
        type: 'POST',
        data: {
          type: type,
          office: office,
          obr: obr,
          dv: dvno,
          docno: docno
        },
        url: 'generate_newobr.php',
        success: function(data) {
          // var result = $.parseJSON(data);
          // $('#doc_no').val(result.docno);

          $('#obr_no').val(data);

        }
      });
    }




    $(function() {


      //checkYear();
      //  var checkBox = document.getElementById("prev_year");

      //  if (checkBox.checked == true) {

      //   var type = $('#select_type').val();
      //   var docno = $('#doc_no').val();
      //   var office = $('#department').val();
      //   var obr = $('#obr_no').val();
      //   var dvno = $('#dv_no').val();
      //   document.getElementById('obr_no').value="";



      //     $.ajax({
      //     type:'POST',
      //     data:{type:type,office:office,obr:obr,dv:dvno,docno:docno},
      //     url:'generate_prevobr.php',
      //     success:function(data1){
      //       // var result = $.parseJSON(data);
      //      // $('#doc_no').val(result.docno);

      //       $('#obr_no').val(data1);
      //       alert (data1);
      //     }


      //   });

      // } else {

      var type = $('#select_type').val();
      var docno = $('#doc_no').val();
      var office = $('#department').val();
      var obr = $('#obr_no').val();
      var dvno = $('#dv_no').val();

      $.ajax({
        type: 'POST',
        data: {
          type: type,
          office: office,
          obr: obr,
          dv: dvno,
          docno: docno
        },
        url: 'generate_obr.php',
        success: function(data) {
          // var result = $.parseJSON(data);
          // $('#doc_no').val(result.docno);

          $('#obr_no').val(data);
          //       alert (data);
        }
      });



      // }




    
    })
  </script>

</body>

</html>