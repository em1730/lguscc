<?php

session_start();
include ('../config/db_config.php');
// ORDINANCE
$ordinance = $title = $public_hearing = $date_enacted = $date_lce = $date_province = $dateadded = $author = $coauthors = $category = $fileName = $new_coauthors = '';
//RESOLUTION
$resolution = $reTitle =$dateadopted = $dateapprovelce = '';
// SP MEMBER
$empID = $fullName = $contact_number = $committee = $email = $location ='';
// COMMITTEE
$comID =  $committee = $status =  '';
// SP PROFILE
$btnEdit = "";
//COMMITTEE
$update_committeeno = $get_committee = $get_status = $subcommittee = '';

$btnNew = 'disabled';
$btnStatus = "";
$disablebutton ="";
$btnhidden = "";
$btnhidden2 = "";

$user_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}




//fetch user from database
$get_user_sql = "SELECT * FROM tbl_users where user_id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {


    $db_first_name = $result['first_name'];
    $db_middle_name = $result['middle_name'];
    $db_last_name = $result['last_name'];
    $db_contact_number = $result['contact_no'];
    $db_position = $result['position'];
    $db_email_ad = $result['email'];
    $db_user_name = $result['username'];
    $db_department = $result['department'];
    $db_location = $result['location'];
    $db_accounttype = $result['account_type'];

}

// if not SP will be kick to log-in
if ($db_accounttype != '2') {
    header('location:../index.php');
} else {

}


// Enable delete button for authorized position
if ($db_position == "RMO III") {
     $disablebutton = '';
     $readonly = '';
 }else{
    $disablebutton = 'disabled';
    $readonly = 'readonly';
 }
    


if (isset($_GET['orno'])) {

    //select filename
    $ordinanceno = $_GET['orno'];
    $get_ordinances_sql = "SELECT * FROM ordinances where OrdinanceNumber = :or";
    $get_ordinances_data = $con->prepare($get_ordinances_sql);
    $get_ordinances_data->execute([':or' => $ordinanceno]);
    while ($result = $get_ordinances_data->fetch(PDO::FETCH_ASSOC)) {
        $ordinance = $result['OrdinanceNumber'];
        $title = $result['OrdinanceTitle'];
        $public_hearing = $result['DatePHearing'];
        $date_enacted = $result['DateEnacted'];
        $date_lce = $result['DateLCE'];
        $date_province = $result['DateProvince'];
        $dateadded = $result['DateAdded'];
        $author = $result['Author']; //author fullname
        $coauthors = $result['CoAuthor'];
        $category = $result['Category'];
        $fileName = $result['Filenames'];

    // separate co-authors by comma
    // result is array variable

    // when inserting new record, use implode function
    // when retrieving imploded data to array, use explode function

    // explode('since sa pag insert nag gamit kag comma, so comma pod diri', 'mao ni ang imploded data')
    // $new_coauthors is now a valid array
    $new_coauthors = explode(',', $coauthors);
    }
}

if (isset($_GET['comno'])) {

    //select filename
    $committeeno = $_GET['comno'];
    $get_committee_sql = "SELECT * FROM committee where objid = :comno";
    $get_committee_data = $con->prepare($get_committee_sql);
    $get_committee_data->execute([':comno' => $committeeno]);
    while ($result = $get_committee_data->fetch(PDO::FETCH_ASSOC)) {
        $update_committeeno = $result['objid'];
        $get_committee = $result['committee'];
        $get_status = $result['status'];

        
  
    }
}

if (isset($_GET['resno'])) {

    //select filename
    $resolutionno = $_GET['resno'];
    $get_resolutions_sql = "SELECT * FROM resolutions where ResolutionNumber = :res";
    $get_resolutions_data = $con->prepare($get_resolutions_sql);
    $get_resolutions_data->execute([':res' => $resolutionno]);
    while ($result = $get_resolutions_data->fetch(PDO::FETCH_ASSOC)) {

        $resolution = $result['ResolutionNumber'];
        $reTitle = $result['resolutionTitle'];
        $dateadopted = $result['DateAdopted'];
        $dateapprovelce = $result['DateApprovedLCE'];
        $author = $result['Author']; //author fullname
        $coauthors = $result['CoAuthor'];  //holds a comma separated data - imploded data
        $category = $result['Category'];
        $fileName = $result['Filenames'];

    // separate co-authors by comma
    // result is array variable

    // when inserting new record, use implode function
    // when retrieving imploded data to array, use explode function

    // explode('since sa pag insert nag gamit kag comma, so comma pod diri', 'mao ni ang imploded data')
    // $new_coauthors is now a valid array
        $new_coauthors2 = explode(',', $coauthors);
    }  
}


if (isset($_GET['objid'])) {
    $user_id = $_GET['objid'];

//fetch sp_member from database
$get_spmember_sql = "SELECT * FROM sp_members where objid = :id";
$get_spmember_data = $con->prepare($get_spmember_sql);
$get_spmember_data->execute([':id' => $user_id]);
while ($result = $get_spmember_data->fetch(PDO::FETCH_ASSOC)) {


    $empID= $result['objid'];
    $fullName = $result['fullname'];
    $email = $result['email'];
    $contact_number = $result['contactno'];
    $committee = $result['committee'];
    $subcommittee = $result['subcommittee'];
    $location =$result['location'];

    $new_committees = explode(' , ', $committee);
    $new_subcommittees = explode(' , ', $subcommittee);
    }
}



//select all users
$get_all_users_sql = "SELECT * FROM tbl_users WHERE user_id != :id";
$get_all_users_data = $con->prepare($get_all_users_sql);
$get_all_users_data->execute([':id' => $user_id]);

$user_name = $result['first_name'];

//select all users
$get_all_users_sql = "SELECT * FROM tbl_users";
$get_all_users_data = $con->prepare($get_all_users_sql);
$get_all_users_data->execute();

//select all ordinances
$get_all_ordinances_sql = "SELECT * FROM ordinances";
$get_all_ordinances_data = $con->prepare($get_all_ordinances_sql);
$get_all_ordinances_data->execute();

//select all ordinances and sp members
$get_all_orsp_sql = "SELECT * FROM ordinances o INNER JOIN sp_members sp ON sp.fullname = o.author";
$get_all_orsp_data = $con->prepare($get_all_orsp_sql);
$get_all_orsp_data->execute();

//select all ordinances and resolutions members
$get_all_orres_sql = "SELECT OrdinanceNumber, OrdinanceTitle, DateAdded, Filenames FROM ordinances
                      UNION ALL
                      SELECT ResolutionNumber, resolutionTitle, DateAdded, Filenames FROM resolutions";
$get_all_orres_data = $con->prepare($get_all_orres_sql);
$get_all_orres_data->execute();

//select all resolutions
$get_all_resolutions_sql = "SELECT * FROM resolutions";
$get_all_resolutions_data = $con->prepare($get_all_resolutions_sql);
$get_all_resolutions_data->execute();

//select all sp data
$get_commiteeno_sql = "SELECT * FROM sp_members WHERE committee ='Police Matters, Fire & Penology'";
$get_commiteeno_data = $con->prepare($get_commiteeno_sql);
$get_commiteeno_data->execute();

//select all resolutions
$get_all_user_sql = "SELECT * FROM tbl_users";
$get_all_user_data = $con->prepare($get_all_user_sql);
$get_all_user_data->execute();

//select all resolutions
$get_all_spmembers_sql = "SELECT * FROM sp_members";
$get_all_spmembers_data = $con->prepare($get_all_spmembers_sql);
$get_all_spmembers_data->execute();

//select all committee
$get_all_committee_sql = "SELECT * FROM committee";
$get_all_committee_data = $con->prepare($get_all_committee_sql);
$get_all_committee_data->execute();

$get_committee_sql = "SELECT * FROM committee where status = 'active'";
$committee_data = $con->prepare($get_committee_sql);
$committee_data->execute();

$get_committee1_sql = "SELECT * FROM committee where status = 'inactive'";
$committee1_data = $con->prepare($get_committee1_sql);
$committee1_data->execute();

//select all users
$get_employee_sql = "SELECT * FROM sp_members";
$get_employee_data = $con->prepare($get_employee_sql);
$get_employee_data->execute();

$get_employee_sql1 = "SELECT * FROM sp_members";
$get_employee_data1 = $con->prepare($get_employee_sql1);
$get_employee_data1->execute();

$get_category_sql = "SELECT * FROM category";
$get_category_data = $con->prepare($get_category_sql);
$get_category_data->execute();

//get all committee
$get_committee_sql = "SELECT * FROM committee";
$get_committee_data = $con->prepare($get_committee_sql);
$get_committee_data->execute();

$get_committee_sql2 = "SELECT * FROM committee";
$get_committee_data2 = $con->prepare($get_committee_sql2);
$get_committee_data2->execute();

$get_committee_sql3 = "SELECT * FROM committee";
$get_committee_data3 = $con->prepare($get_committee_sql3);
$get_committee_data3->execute();

$get_committee_sql4 = "SELECT * FROM committee";
$get_committee_data4 = $con->prepare($get_committee_sql4);
$get_committee_data4->execute();

//get selected committee
$get_committee1_sql = "SELECT * FROM committee where objid = :comid";
$get_committee1_data = $con->prepare($get_committee1_sql);
$get_committee1_data->execute([':comid' => $comID]);

?>