<?php

session_start();


include('../config/credentials.php');



if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}




?>



<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> DOCTRACK | Dashboard </title>

  <?php include('heading.php'); ?>


</head>


<body class="hold-transition sidebar-mini">

  <div class="wrapper">
    <?php include('sidebar.php') ?>


    <div class="content-wrapper">

      <div class="content-header"></div>

      <section class="content">

        <?php include('dashboard.php') ?>

        <div class="col-md-20">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Inbox</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fa fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->

                <!-- /.btn-group -->

                <div class="float-right">

                  <div class="btn-group">

                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php while ($messages_data = $get_all_messages1_data->fetch(PDO::FETCH_ASSOC)) { ?>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td class="mailbox-star"><a href="#"><i class="fa fa-star text-warning"></i></a></td>
                        <td class="mailbox-name"><a href="read-mail.php?objid=<?php echo $messages_data['objid']; ?>"><?php echo $messages_data['sender']; ?></a></td>
                        <td class="mailbox-subject"><?php echo $messages_data['subject']; ?>
                        </td>
                        <td class="mailbox-attachment"></td>
                        <td class="mailbox-date"><?php echo $messages_data['date']; ?></td>
                      </tr>

                    <?php } ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>








      </section>

      
      <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Print Routing Slip</h4>
            </div>
            <form method="POST" action="<?php htmlspecialchars("PHP_SELF") ?>">
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label>Please enter Document Number:</label>
                    <input type="text" name="modal_docno" id="modal_docno" class="form-control" value="<?php echo  $docno; ?>" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                <a href="javascript:;" onclick="this.href='../plugins/TCPDF/User/routing.php?docno=' + document.getElementById('modal_docno').value" target="blank">
                  <input type="button" name="delete_user" class="btn btn-danger" value="Yes">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php include('footer.php') ?>

  </div>







  <!-- <aside class="control-sidebar control-sidebar-dark">
    <div class="modal-header">
      <h4 class="modal-title">SETTINGS</h4>
    </div>
    <div class="modal-body">
      <div class="box-body">
        <div class="form-group" <?php if ($department != 'CBO') { ?> style="display:none" <?php } ?>>
          <h6 class="modal-title">Update OBR No:</h6>
          <input type="text" name="update_obr" id="update_obr" class="form-control" value="<?php echo $settings_obr; ?>" required>
        </div>
        <div class="box-body">
          <div class="form-group" <?php if ($department != 'ACCTG') { ?> style="display:none" <?php } ?>>
            <h6 class="modal-title">Update DV No:</h6>
            <input type="text" name="update_dv" id="update_dv" class="form-control" value="<?php echo $settings_dv; ?>" required>
          </div>
        </div>
      </div>
  </aside> -->



  <?php include('scripts.php') ?>

  <script>
    // $('#scan_track').on('change',function(){

    //   // function receive(){
    //              var docno = document.getElementById("scan_track").value;

    //             //  alert (docno);

    //             $.ajax({
    //               type:'POST',
    //               data:{docno:docno},
    //               url:'scan_track.php',
    //                success:function(data){
    //                 var result = $.parseJSON(data);
    //                 // alert(result.type)
    //                  document.getElementById('lblDate').innerHTML = result.date;
    //                  document.getElementById('lblTime').innerHTML = result.time;
    //                  document.getElementById('lblType').innerHTML = result.type;
    //                  document.getElementById('lblParticulars').innerHTML = result.particulars;
    //                  document.getElementById('lblOrigin').innerHTML = result.origin;
    //                  document.getElementById('lblDestination').innerHTML = result.destination;
    //                  document.getElementById('lblRemarks').innerHTML = result.remarks;
    //                  document.getElementById('lblMessage').innerHTML = result.message;

    //                }

    //                 });   

    //                 document.getElementById('scan_track').focus();
    //                 document.getElementById('scan_track').select();

    //                 //


    //     });

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


    });
  </script>
</body>

</html>