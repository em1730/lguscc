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
  <title> DOCTRACK | Incoming Documents</title>

  <?php include('heading.php'); ?>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include('sidebar.php') ?>

    <div class="content-wrapper">

      <div class="content-header">

      </div>


      <section class="content">
        <div class="card">
          <div class="card-header bg-dark">

            <h4>User Masterlists 

              <a href="add_user.php" style="float:right;" type="button" class="btn btn-dark bg-gradient-dark">
                <i class="nav-icon fa fa-plus-square"></i></a>
            </h4>
          </div>

          <div class="card-body">
            <div class="box">
              <div class="box-body">
                <div class="table-responsive">
                  <table id="users" name="user" class="table table-bordered table-striped">
                    <thead align="center">
                      <th>ID No.</th>
                      <th>Full Name</th>
                      <th>Username</th>
                      <th>Department</th>
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
      </section>







    </div>


   

    <?php include('footer.php') ?>
  </div>
</body>

</html>
<!-- END OF HTML -->




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
        url: "search_users.php",
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
          defaultContent: '<button class="btn btn-outline-success btn-sm editIndividual" style = "margin-right:10px;"  id = "button_receive" data-placement="top" title="Receive Document"> <i class="fa fa-check"></i></button> ' +
            ' ',
        },

      ],
    });




  });

  $(document).on('click', 'button[data-role=confirm_delete]', function(event) {
    event.preventDefault();

    var user_id = ($(this).data('id'));

    $('#user_id').val(user_id);
    $('#deleteuser_Modal').modal('toggle');

  })

  $('#docno').on('change', function() {

    // function receive(){
    var docno = document.getElementById("docno").value;

    // alert (docno);

    $.ajax({
      type: 'POST',
      data: {
        docno: docno
      },
      url: 'scan_receive.php',
      success: function(data) {
        var result = $.parseJSON(data);
        // alert(result.type)
        document.getElementById('lblDate').innerHTML = result.date;
        document.getElementById('lblType').innerHTML = result.type;
        document.getElementById('lblParticulars').innerHTML = result.particulars;
        document.getElementById('lblOrigin').innerHTML = result.origin;
        //  document.getElementById('lblRemarks').innerHTML = result.remarks;
        //  document.getElementById('lblMessage').innerHTML = result.message;

      }

    });

    document.getElementById('scan_receive').focus();
    document.getElementById('scan_receive').select();

    //


  });


  $('#change').on('click', function() {

    // function receive(){
    var type = document.getElementById("select_type").value;
    var docno = document.getElementById("docno").value;
    //  alert (docno);

    $.ajax({
      type: 'POST',
      data: {
        docno: docno,
        type: type
      },
      url: 'update_type.php',
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
</script>