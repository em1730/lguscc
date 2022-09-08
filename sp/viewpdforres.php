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


if (isset($_GET['orresno'])) {

     //select filename
     $orresno = $_GET['orresno'];
     $get_orres_sql = "SELECT OrdinanceNumber, OrdinanceTitle, DateAdded, Filenames FROM ordinances
     WHERE OrdinanceNumber = :orres
     UNION ALL
     SELECT ResolutionNumber, resolutionTitle, DateAdded, Filenames FROM resolutions
     WHERE ResolutionNumber = :orres";
     $get_orres_data = $con->prepare($get_orres_sql);
     $get_orres_data->execute([':orres' => $orresno]);
     while ($result = $get_orres_data->fetch(PDO::FETCH_ASSOC)) {
         $update_orresno = $result['OrdinanceNumber'];
         $get_orresTitle = $result['OrdinanceTitle'];
         $get_orresdateadded = $result['DateAdded'];
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

