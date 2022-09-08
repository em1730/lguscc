<?php

session_start();


include('../config/credentials.php');

$docno = '';








?>

<!DOCTYPE html>
<html>



<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> DOCTRACK | Archived Document</title>
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

        <div class="card ">
          <div class="card-header bg-dark">
            <h4>Archived Documents</h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="archived" class="table table-bordered table-striped">

              <thead>
                <tr>
                  <th>Document No.</th>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Particulars</th>
                  <th>Origin</th>
                  <th>Status</th>
                  <th>Remarks</th>
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


      </section>
    </div>

    <?php include('footer.php') ?>
  </div>

  <?php include('scripts.php') ?>


  <script>
    $(document).ready(function() {
      var office = $('#department').val();
      var dataTable = $('#archived').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
          url: "track_archived.php", // json datasource
          data: {
            office: office
          },
          type: "post", // method  , by default get
          error: function() { // error handling
            $("#archived-error").html("");
            $("#archived").append('<tbody class="archived-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
            $("#archived_processing").css("display", "none");

          }
        },
        "columnDefs": [{
          "targets": -1,
          "data": null,
          "defaultContent": '<button class=\"pdf btn btn-outline-success btn-xs \" ><i class="fa fa-file-pdf-o" aria-hidden= "true"></i></button>'


        }],
      });

      $('#archived tbody').on('click', 'button.pdf', function() {
        // alert ('hello');
        // var row = $(this).closest('tr');
        var table = $('#archived').DataTable();
        var data = table.row($(this).parents('tr')).data();
        //  alert (data[0]);
        //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
        var docno = data[0];
        window.open("view_pdf.php?docno=" + docno, '_blank');
        //  var table = $('#users').DataTable();
        //   if ($(this).hasClass('selected')){
        //       $(this).removeClass('selected');

        //   }else{
        //     table.$('tr.selected').removeClass('selected');
        //     $(this).addClass('selected');

        //   var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
        //   var docno = data[0];
        //   window.open("receive_incoming.php?docno=" + docno,'_parent');
        // alert(docno);
        //    }
      });
    });
    $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
      event.preventDefault();

      var user_id = ($(this).data('id'));

      $('#user_id').val(user_id);
      $('#deleteuser_Modal').modal('toggle');

    })
  </script>

</body>

</html>