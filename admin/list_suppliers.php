<?php

session_start();


if (!isset($_SESSION['id'])) {
  header('location:../login.php');
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
  <title>DOCTRACK | List of Supplier</title>

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

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include('sidebar.php') ?>

    <div class="content-wrapper">
      <div class="content-header"></div>

      <section class="content">

        <div class="card">
          <div class="card-header bg-success">
            <h4>List of Supplier

              <a href="add_suppliers.php" id="add_individual" style="float:right;" type="button" class="btn btn-success bg-gradient-success" style="border-radius: 0px;">
                <i class="nav-icon fa fa-plus-square fa-lg"></i></a>
            </h4>
          </div>
          <div class="card-body">
            <div class="box">
              <div class="box-body">
                <div class="table-responsive">
                  <table id="users" class="table table-bordered table-striped">

                    <thead align="center">
                      <th>ID</th>
                      <th>Code</th>
                      <th>Supplier's Name</th>
                      <th>Owner</th>
                      <th>Address</th>
                      <th>Contact No.</th>
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
      </section><br>
    </div>


    <?php include('footer.php') ?>
  </div>




  <div class="modal fade" id="deleteuser_Modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirm Delete</h4>
        </div>
        <form method="POST" action="<?php htmlspecialchars("PHP_SELF") ?>">
          <div class="modal-body">
            <div class="box-body">
              <div class="form-group">
                <label>Delete Record?</label>
                <input type="text" name="user_id" id="user_id" class="form-control">
              </div>
            </div>
          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left bg-olive" data-dismiss="modal">No</button>
            <!-- <button type="submit" name="delete_user" class="btn btn-danger">Yes</button> -->
            <input type="submit" name="delete_user" class="btn btn-danger" value="Yes">
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
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
  $(document).ready(function() {


    var dataTable = $('#users').DataTable({

      page: true,
      stateSave: true,
      processing: true,
      serverSide: true,
      scrollX: false,
      ajax: {
        url: "track_supplier.php",
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
          // width: "270px",
          targets: -1,
          data: null,
          defaultContent: '<button class="btn btn-outline-success btn-sm editSupplier" style = "margin-right:10px;"  id = "editSupplier" data-placement="top" title="Edit Supplier"> <i class="fa fa-edit"></i></button>',

        },

      ],
    });


  });


  $('#users tbody').on('click', '#editSupplier', function() {
    // alert ('hello');
    // var row = $(this).closest('tr');
    var table = $('#users').DataTable();
    var data = table.row($(this).parents('tr')).data();
    //  alert (data[0]);
    //  var data = $('#users').DataTable().row('.selected').data(); //table.row(row).data().docno;
    var objid = data[0];


    window.open("view_suppliers.php?objid=" + objid, '_parent');

  });


  $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
    event.preventDefault();

    var user_id = ($(this).data('id'));

    $('#user_id').val(user_id);
    $('#deleteuser_Modal').modal('toggle');

  })
</script>