<?php include 'includes/session.php'; ?>
<?php include 'insert_update_ordinance.php'; ?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- sidebar activity -->
  <?php
$sb_dashboard = "";
$sb_manage_records ="menu-open";
$sb_ordinances = "active";
$sb_resolutions = "";
$sb_main_navigation = "";
$sb_sp_members = "";
$sb_committees = "";
$sb_account_settings = "";
$sb_my_profile = "";
?>

 <?php include 'includes/navbar.php'; ?>
 <?php include 'includes/sidebar.php'; ?>



   <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
       <div class="container-fluid">
         <div class="row mb-2">
           <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Ordinances  </h1>

           </div>

           
           <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             </ol>
           </div>
         </div>
       </div>
     </div>

                 <!-- Main content -->
                 <section class="content">

                     <div class="row">
                         <div class="col-md-1"></div>
                         <div class="col-md-10">
                             <div class="animationIN card card-outline card-primary">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Details</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                 <form role="form" enctype="multipart/form-data" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                 
                                 <div class="card-body">

                                        <?php if (empty($fileName)){$btnhidden = "";}else{$btnhidden = "hidden";};?>
                                        <div <?php echo $btnhidden ?>  class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <i class="icon fa fa-warning"></i>
                                        Please Upload the pdf file
                                         </div>
                                         
                                     <?php echo $alert_msg; ?> 
                                     <?php echo $alert_msg1; ?> 
                                     <?php
                                            if(isset($_SESSION['error'])){
                                            echo "
                                            <div class='alert alert-danger alert-dismissible'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                ".$_SESSION['error']."
                                            </div>
                                            ";
                                            unset($_SESSION['error']);
                                            }
                                            if(isset($_SESSION['success'])){
                                            echo "
                                            <div class='alert alert-success alert-dismissible'>
                                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                ".$_SESSION['success']."
                                            </div>
                                            ";
                                            unset($_SESSION['success']);
                                        }
                                        ?>
                                     
                                    

                                     <input hidden type="text" class="form-control" readOnly=true id = "orno2" name="ordinance_no2" value="<?php echo $ordinance; ?>">

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                             <label>Ordinance Number</label>
                                         </div>
                                         <div class="col-md-10">
                                              <input <?php echo $readonly;?> type="text" class="form-control" id = "orno" name="ordinance_no" placeholder="Ordinance Number" value="<?php echo $ordinance; ?>" required>
                                         </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                 <label>Ordinance Title</label>
                                         </div>
                                         <div class="col-md-10">
                                                 <textarea type="text" class="form-control" name="ordinance_title" placeholder="Ordinance Title" required ><?php echo $title;?></textarea>
                                         </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Public Hearing</label>
                                         </div>
                                            <div class="col-md-10">
                                                <!-- Date -->
                                                 <div class="form-group">
                                                    <!-- <label>Date:</label> -->

                                                     <div class="input-group date mb-3" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-today-btn="linked"> 
                                                         <div class="input-group-addon input-group-prepend">
                                                             <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                             <input type="text" class="form-control pull-right" id="datepicker" name="public_hearing" placeholder="Date of Public Hearing" value="<?php echo $public_hearing; ?>">
                                                     </div>
                                                 </div>
                                             </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                 <label>Date Enacted</label>
                                         </div>
                                         <div class="col-md-10">
                                                <!-- Date -->
                                             <div class="form-group">
                                                    <!-- <label>Date:</label> -->

                                                 <div class="input-group date mb-3" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-today-btn="linked">
                                                         <div class="input-group-addon input-group-prepend">
                                                             <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                         </div>
                                                             <input type="text" class="form-control pull-right" id="datepicker" name="date_enacted" placeholder="Date of Enactment" value="<?php echo $date_enacted; ?>">
                                                 </div>
                                             </div>
                                         </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Date Approved</label>
                                         </div>
                                         <div class="col-md-10">
                                                <!-- Date -->
                                             <div class="form-group">
                                                    <!-- <label>Date:</label> -->
                                                 <div class="input-group date mb-3" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-today-btn="linked">
                                                     <div class="input-group-addon input-group-prepend">
                                                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                     </div>
                                                         <input type="text" class="form-control pull-right" id="datepicker" name="date_lce" placeholder="Date Approved by the LCE" value="<?php echo $date_lce; ?>">
                                                 </div>
                                              </div>
                                         </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                             <label>Date Approved</label>
                                         </div>
                                         <div class="col-md-10">
                                                 <!-- Date -->
                                             <div class="form-group">
                                                 <!-- <label>Date:</label> -->
                                                 <div class="input-group date mb-3" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-today-btn="linked">
                                                     <div class="input-group-addon input-group-prepend">
                                                         <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                     </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date_province" placeholder="Date Approved by the Province" value="<?php echo $date_province; ?>">
                                                 </div>
                                             </div>
                                         </div>
                                     </div><br>

                                     <div class="row">
                                         <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <!-- <div class="form-group"> -->
                                             <label>Author</label>
                                         </div>
                                         <div class="col-md-10">
                                             <select class="form-control select2" id ="author" style="width: 100%"; name="author"; ?>">
                                                 <option>Please select...</option>
                                                     <?php while ($author1 = $get_employee_data->fetch(PDO::FETCH_ASSOC)) { ?>
                                                     <?php
                                                        //if $get_author naa value, check nato if equals sa $get_author1['fullname']
                                                        //if equals, put 'selected' sa option
                                                        $selected = ($author == $author1['fullname'])? 'selected':'';
                                                     ?>
                                                 <option <?=$selected;?> value="<?php echo $author1['fullname']; ?>"><?php echo $author1['fullname']; ?></option>
                                                     <?php } ?>
                                             </select>
                                         </div>
                                     </div><br>
                                        <!-- /.col -->

                                        <div class="row">
                                     <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                         <label>Co-Authors</label>
                                     </div>
                                     <div class="col-md-10">
                                         <div class="form-group">
                                                <select class="form-control select2"  style="width: 100%" multiple="" name="coauthor[]">
                                                <?php while ($author2 = $get_employee_data1->fetch(PDO::FETCH_ASSOC)) {
                                                    if( in_array($author2['fullname'], $new_coauthors) ){
                                                        $selected = 'selected';
                                                    }
                                                    else{
                                                        $selected = '';
                                                    }

                                                ?>
                                                     <option <?= $selected ?> value="<?php echo $author2['fullname']; ?>"><?php echo $author2['fullname']; ?></option>
                                                   <?php } ?>

                                             </select>

                                         </div>
                                     </div>
                                 </div><br>

                                         <!-- /.box-header -->

                                 <div class="row">
                                     <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                             <!-- <div class="form-group"> -->
                                         <label>Category</label>
                                     </div>
                                     <div class="col-md-10">
                                         <select class="form-control select2" id ="category" style="width: 100%;" name="category"; ?>">
                                             <option>Please select...</option>   
                                             <?php while ($category1 = $get_category_data->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <?php $selected = ($category == $category1['category'])? 'selected':''; ?>
                                             <option <?=$selected;?> value="<?php echo $category1['category']; ?>"><?php echo $category1['category']; ?></option>
                                             <?php } ?>
                                         </select>
                                     </div>
                                 </div><br> 
                                   
                                         <div class="card-body">
                                    
                                             <div class="row">
                                                 <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                    <label>Upload File</label>
                                                 </div>
                                                 <div class="col-md-10">
                                                     <input type ="file" name="myFile" id="fileToUpload">
                                                             <p class="help-block">Upload .pdf file only.</p>
                                                        <!-- <input type="submit" name="submit" class="btn btn-default" value="Upload">        -->
                                                 </div>
                                             </div>
                                         </div>
                                                    
                                 </div><br>   
                                
                                        <!-- /.box-body -->
                                 <div class="card-footer">
                                   
                                     <input type="submit"   name="insert_update_ordinance" class="btn btn-primary" value="Save">
                                     <a href="ordinances">
                                             <input type="button" name="cancel" class="btn btn-default" value="Cancel">       
                                     </a>
                                 </div>
                                 </form>
                           
                             </div>
                            <!-- /.box -->
                         </div>
                         </div>
                             <div class="col-md-1"></div>
                             </div>
                     </div>
                 </section>
                <!-- /.content -->
 </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

</body>
</html>
 