<?php

session_start();


if (!isset($_SESSION['id'])) {
  header('location:../index.php');
}

$user_id = $_SESSION['id'];

include('../config/db_config.php');
// include('delete.php');


$get_user_sql = "SELECT * FROM tbl_users WHERE user_id = :id";
$get_user_data = $con->prepare($get_user_sql);
$get_user_data->execute([':id' => $user_id]);
while ($result = $get_user_data->fetch(PDO::FETCH_ASSOC)) {

  $user_name = $result['username'];
  $GLOBALS['department'] = $result['department'];
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
  <title> DOCTRACK | Job Order </title>

  <?php include('heading.php'); ?>

</head>


<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include('sidebar.php') ?>
    <div class="content-wrapper">
      <div class="content-header"></div>


      <section class="content">
        <div class="card">
          <div class="card-header bg-success">
            <h4>Job Order

              <a href="add_joborder.php" id="add_individual" style="float:right;" type="button" class="btn btn-success bg-gradient-success" style="border-radius: 0px;">
                <i class="nav-icon fa fa-plus-square fa-lg"></i></a>
            </h4>
          </div>

          <div class="card-body">
            <div class="box">
              <div class="box-body">
                <div class="table-responsive">
                  <table id="users" name="user" class="table table-bordered table-striped">
                    <thead align="center">

                      <th>ID #</th>
                      <th>Control No.</th>
                      <th>Full Name</th>
                      <th>Rate</th>
                      <th>Department/Office</th>
                      <th>Options</th>


                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>

      </section><br><br>

    </div>

    <?php include('footer.php') ?>
  </div>




  <?php include('scripts.php') ?>

  <script>
    $(document).ready(function() {


      // var office = $('#department2').val();
      var dataTable = $('#users').DataTable({

        page: true,
        stateSave: true,
        processing: true,
        serverSide: true,
        scrollX: false,
        ajax: {
          url: "track_joborder.php",
          // data: {
          //   office: office
          // },
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
            defaultContent: '<button class="btn btn-outline-success btn-sm editIndividual" style = "margin-right:10px;"  id = "button_receive" data-placement="top" title="Edit Individual"> <i class="fa fa-edit"></i></button> ' +
              ' ',
          },

        ],
      });
    });



    $('#users tbody').on('click', 'button.edit', function() {
      // alert ('hello');
      // var row = $(this).closest('tr');
      var table = $('#users').DataTable();
      var data = table.row($(this).parents('tr')).data();
      //  alert (data[0]);
      //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
      var objid = data[0];


      window.open("update_joborder.php?objid=" + objid, '_parent');

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