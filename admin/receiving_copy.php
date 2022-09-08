<?php


session_start();


$alert_msg = '';
$origin = $date_from = $date_to = $type = $description = $status  = '';
$btnNew = 'disabled';
$btnPrint = 'disabled';
$btnStatus = 'enabled';
$btnStatus = '';



$now = new DateTime();

if (!isset($_SESSION['id'])) {
  header('location:../index');
}
$user_id = $_SESSION['id'];


include('../config/db_config.php');
include('update_print.php');


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
  $department = $result['department'];
}

//select all data type
$get_all_document_sql = "SELECT * FROM document_type";
$get_all_document_data = $con->prepare($get_all_document_sql);
$get_all_document_data->execute();

//select all departments
$get_all_departments_sql = "SELECT * FROM tbl_department";
$get_all_departments_data = $con->prepare($get_all_departments_sql);
$get_all_departments_data->execute();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DOCTRACK | Receiving Copy</title>
  <?php include('heading.php') ?>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <?php include('sidebar.php') ?>

    <div class="content-wrapper">
      <div class="content-header"></div>
      <section class="content">
        <div class="card">
          <div class="card-header bg-success">
            <h4>Receiving Copy</h4>
          </div>

          <div class="card-body">

            <form role="form" method="get" action="../plugins/TCPDF/User/receiving_copy.php?user=<?php echo $_GET['user']; ?>&username=<?php echo $_GET['username']; ?>&department=<?php echo $_GET['department']; ?>&origin=<?php echo $_GET['origin']; ?>&type=<?php echo $_GET['type']; ?>&date_from=<?php echo $_GET['date_from']; ?>&date_to=<?php echo $_GET['date_to']; ?>" target="blank" ; ?>
              <div class="box-body">
                <?php include('update_print.php'); ?>
                <?php echo $alert_msg; ?>





                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>From:</label>
                  </div>
                  <div class="col-md-10">
                    <!-- Date -->
                    <div class="form-group">
                      <!-- <label>Date:</label> -->
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" name="date_from" placeholder="Date Created" value="<?php echo
                                                                                                                                              $now->format('m/d/Y');; ?>">
                      </div>
                    </div>
                  </div>
                </div><br>


                <div class="row">
                  <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                    <label>To:</label>
                  </div>
                  <div class="col-md-10">
                    <!-- Date -->
                    <div class="form-group">
                      <!-- <label>Date:</label> -->
                      <div class="input-group date" data-provide="datepicker">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" name="date_to" placeholder="Date Created" value="<?php echo
                                                                                                                                            $now->format('m/d/Y');; ?>">
                      </div>
                    </div>
                  </div>
                </div><br>


                <input type="hidden" readonly class="form-control" name="department" placeholder="Department" value="<?php echo
                                                                                                                      $department; ?>" required>
              </div>

              <input type="hidden" readonly class="form-control" name="username" placeholder="Department" value="<?php echo
                                                                                                                  $db_first_name . ' ' . $db_middle_name . ' ' . $db_last_name; ?>" required>

              <input type="hidden" readonly class="form-control" name="user" placeholder="Department" value="<?php echo
                                                                                                              $db_user_name; ?>" required>



              <!-- /.box-body -->
              <div class="box-footer" align="center">
                <input type="submit" onclick="this.form.submit(); this.disabled=true;" name="update_print" class="btn btn-primary" value="PRINT">
                
              </div>
            </form>
          </div>

        </div>
      </section>
    </div>


    <?php include('footer.php') ?>

  </div>



  <?php include('scripts.php') ?>



  <script>
    function updatePrint() {
      var type = $('#select_type').val();
      //  $('#doc_no').val(type);


      $.ajax({
        url: 'update_print.php',
        type: 'POST',
        data: {
          type: type
        },
        success: function(data) {



        }

      });
    }
  </script>

</body>

</html>