<?php

session_start();

include ('../config/db_config.php');


if (!isset($_SESSION['id'])) {
    header('location:../index');
}
echo "<pre>";
print_r($_POST);
echo "</pre>";

$user_id = $_SESSION['id'];


if (isset($_GET['resno'])) {

     //select filename
     $resolutionno = $_GET['resno'];
     $get_resolutions_sql = "SELECT * FROM resolutions where ResolutionNumber = :res";
     $get_resolutions_data = $con->prepare($get_resolutions_sql);
     $get_resolutions_data->execute([':res' => $resolutionno]);
     while ($result = $get_resolutions_data->fetch(PDO::FETCH_ASSOC)) {
         $update_reno = $result['resolutionNo'];
         $get_reTitle = $result['resolutionTitle'];
         $get_dateAdopted = $result['DateAdopted'];
         $get_dateApprovelce = $result['DateApprovedlce'];
         $get_author = $result['Author']; //author fullname
         $get_coauthors = $result['CoAuthor'];
         $get_category = $result['Category'];
         $get_file = $result['Filenames'];

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }

    $file = '../upload/' . $get_file;

    $filename = $get_file;


    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename = "' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    echo file_get_contents($file);
    @readfile($file);
}
?>

