<?php include 'includes/session.php'; ?>
<?php include 'insert_resolution.php'; ?>

<?php include 'includes/header.php'; ?>

 <body class="hold-transition sidebar-mini">
 <div class="wrapper">

 <!-- sidebar activity -->
 <?php
$sb_dashboard = "";
$sb_manage_records ="menu-open";
$sb_ordinances = "";
$sb_resolutions = "active";
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
       <h1 class="m-0 text-dark">Add Resolution</h1>
      </div>
      <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- Content Header End -->

                <!-- Main content -->
                <section class="content animationIN">

                    <div class="row animationOUT">
                       <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card card-outline card-primary">
                                <div class="card-header with-border">
                                    <h3 class="card-title">Details</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                <form role="form" enctype="multipart/form-data" method="post" action="<?php htmlspecialchars("PHP_SELF"); ?>">
                                    <div class="card-body">

                                                         <div>
                                                            <?php echo $alert_msg; ?>
                                                            <?php echo $alert_msg1; ?>
                                                            <?php echo $alert_msg2; ?>
                                                         </div>

                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Resolution Number</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="resolution_no" placeholder="Resolution Number" value="<?php echo $resolution; ?>" required>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Resolution Title</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea type="text" class="form-control" name="resolution_title" placeholder="Resolution Title" required><?php echo $reTitle;?></textarea>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Date Adopted</label>
                                            </div>
                                            <div class="col-md-10">
                                                <!-- Date -->
                                                <div class="form-group">
                                                    <!-- <label>Date:</label> -->

                                                    <div class="input-group date mb-3" data-provide="datepicker" >
                                                        <div class="input-group-addon input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date_adopted" placeholder="Date Adopted" value="<?php echo $dateadopted; ?>">
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

                                                    <div class="input-group date mb-3" data-provide="datepicker" >
                                                        <div class="input-group-addon input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control pull-right" id="datepicker" name="date_approvedlce" placeholder="Date Approved by LCE" value="<?php echo $dateapprovelce; ?>">                                                
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

                                            <select class="form-control select2" id ="author" style="width: 100%;" name="author"; ?>">
                                             <option>Please select...</option>   
                                             <?php while ($author1 = $get_employee_data->fetch(PDO::FETCH_ASSOC)) { ?>
                                             <?php $selected = ($author == $author1['fullname'])? 'selected':''; ?>
                                             <option <?=$selected;?> value="<?php echo $author1['fullname']; ?>"><?php echo $author1['fullname']; ?></option>
                                             <?php } ?>
                                         </select>
                                            </div>
                                        </div><br>
                                        
                                        <div class="row">
                                            <div class="col-md-2" style="text-align: right;padding-top: 5px;">
                                                <label>Co-Authors</label>
                                            </div>
                                             <div class="col-md-10">
                                                 <div class="form-group">
                                                 <select class="form-control select2"  style="width: 100%" multiple="" name="coauthor[]" value="<?php echo $coauthors; ?>">
                                                <?php while ($author2 = $get_employee_data1->fetch(PDO::FETCH_ASSOC)) {
                                                    if( in_array($author2['fullname'], $new_coauthors2) ){
                                                        $selected = 'selected';
                                                    }
                                                    else{
                                                        $selected = '';
                                                    } ?>
                                                     <option <?= $selected ?> value="<?php echo $author2['fullname']; ?>"><?php echo $author2['fullname']; ?></option>
                                                   <?php } ?>

                                             </select>
                                                 </div>
                                             </div>
                                        </div><br>

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
                                                     </div>
                                                 </div>
                                         </div>
                                     </div>  
                                
                                        <!-- /.box-body -->
                                     <div class="card-footer">
                                            <input type="submit"  <?php echo $btnNew; ?> name="add" class="btn btn-primary" value="New">
                                            <input type="submit"  <?php echo $btnStatus; ?> name="insert_resolution" class="btn btn-primary" value="Save">
                                            <a href="resolutions">
                                                <input type="button" name="cancel" class="btnOUT btn btn-default" value="Cancel">       
                                            </a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                       </div>
                    </div> 
                       <div class="col-md-1"></div>
                       </div>

                </section>
    <!-- Main Content End -->

   </div> 
   <!-- Content-Wrapper End -->


 <?php include 'includes/footer.php'; ?>
 </div>
 <!-- Wrapper End -->

 <?php include 'includes/scripts.php'; ?>

</body>
</html>

