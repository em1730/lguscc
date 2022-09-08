<?php

session_start();


include('../config/credentials.php');
if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}






?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> DOCTRACK | Received Documents Masterlisting</title>

  <?php include('heading.php'); ?>


</head>


<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include('sidebar.php') ?>

    <div class="content-wrapper">

      <div class="content-header">
        <?php include('dashboard.php'); ?>
      </div>

      <section class="content">

        <div class="card">
          <div class="card-header bg-dark">
            <h4>Received Documents</h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="users" class="table table-bordered table-striped">

              <thead>
                <tr>

                  <th>Document No.</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>OBR No.</th>
                  <th>DV No.</th>
                  <th>Payee</th>
                  <th>Particulars</th>
                  <th>Amount</th>
                  <th>Origin</th>
                  <th>Options</th>
                </tr>
              </thead>
              <tbody>


              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          </form>
        </div>
        <div class="col-md-10">
          <input type="hidden" id="department2" readonly class="form-control" name="department2" placeholder="Department2" value="<?php echo $department; ?>">
        </div>

      </section>


      <div class="modal fade" id="release_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirm Release</h4>
            </div>
            <form method="POST" action="<?php htmlspecialchars("PHP_SELF") ?>">
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label>Release Record?</label>
                    <input type="text" name="user_id" id="user_id" class="form-control">
                  </div>
                </div>
              </div>
              <div class="modal-footer"> &nbsp;

                <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
                <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
                <input type="submit" name="insert_forward" class="btn btn-danger" value="Yes">
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


    </div><br>

    <?php include('footer.php') ?>

  </div>
  <!-- ./wrapper -->

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
    $(document).ready(function() {
      var office = $('#department2').val();

      var dataTable = $('#users').DataTable({

        page: true,
        stateSave: true,
        processing: true,
        serverSide: true,
        scrollX: false,
        ajax: {
          url: "track_received.php",
          data: {
            office: office
          },
          type: "post",
          error: function(xhr, b, c) {
            console.log(
              "xhr=" +
              xhr.responseText +
              " b=" +
              b.responseText +
              " c=" +
              c.responseText
            );
          }
        },
        columnDefs: [{
            width: "200px",
            targets: -1,
            data: null,
            defaultContent: '<button class="release btn btn-outline-success btn-xs " ><i class="fa fa-share" aria-hidden= "true"></i></button>' + '&nbsp;' +
              '<button class="archive btn btn-outline-success btn-xs " ><i class="fa fa-archive" aria-hidden= "true"></i></button>',
          },

        ],
      });










      $('#users tbody').on('click', 'button.release', function() {
        // alert ('hello');
        // var row = $(this).closest('tr');
        var table = $('#users').DataTable();
        var data = table.row($(this).parents('tr')).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
        var type = data[2];
        var docno = data[0];

        if (type == "DV" || type == "OBR" || type == "DWP" || type == "PYL" || type == "LR" || type == "RIS" || type == "PO" || type == "PR") {
          window.open("release_document_dv.php?docno=" + docno, '_parent');
        } else {

          window.open("release_document.php?docno=" + docno, '_parent');
        }
        // alert(docno);

      });

      $("#users tbody").on("click", ".printlink", function() {
        // event.preventDefault();
        var currow = $(this).closest("tr");
        var docno = currow.find("td:eq(0)").text();
        $('.printlink').attr("href", "../plugins/jasperreport/routing.php?docno=" + docno, '_parent');
        // window.open("../plugins/jasperreport/entity_id.php?entity_no=" + entity, '_parent');

      });

      $("#users tbody").on("click", "#editDocument", function() {
        event.preventDefault();
        var currow = $(this).closest("tr");
        var docno = currow.find("td:eq(0)").text();
        // $('#viewIndividual').attr("href", "view_individual.php?&id=" + entity, '_parent');
        window.open("revert_document.php?&docno=" + docno, '_parent');

      });


      $('#users tbody').on('click', 'button.revert', function() {
        // alert ('hello');
        // var row = $(this).closest('tr');
        var table = $('#users').DataTable();
        var data = table.row($(this).parents('tr')).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
        var docno = data[0];
        window.open("revert_document.php?docno=" + docno, '_parent');
        // alert(docno);

      });
    });

    $('#scan_release').on('change', function() {

      // function receive(){
      var docno = document.getElementById("scan_release").value;
      var destination = document.getElementById("destination").value;
      var remarks = document.getElementById("remarks").value;

      if (remarks == "") {
        alert("Please enter remarks.");
        document.getElementById('remarks').select();
        document.getElementById('remarks').focus();

      } else {

        $.ajax({
          type: 'POST',
          data: {
            docno: docno,
            destination: destination,
            remarks: remarks
          },
          url: 'scan_release.php',
          success: function(data) {
            var result = $.parseJSON(data);
            // alert(result.type)
            document.getElementById('lblDate').innerHTML = result.date;
            document.getElementById('lblType').innerHTML = result.type;
            document.getElementById('lblParticulars').innerHTML = result.particulars;
            document.getElementById('lblOrigin').innerHTML = result.origin;
            //  document.getElementById('lblRemarks').innerHTML = result.remarks;
            document.getElementById('lblMessage').innerHTML = result.message;

          }

        });

        document.getElementById('scan_release').focus();
        document.getElementById('scan_release').select();

      } //


    });



    $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })

    $('div.dataTables_filter input').focus();

    $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })

    $(document).on('click', 'button[data-role=confirm_release]', function(event) {
      event.preventDefault();

      var docno = ($(this).data('id'));

      $('#user_id').val(docno);
      $('#release_Modal').modal('toggle');

    })
  </script>

</body>

</html>