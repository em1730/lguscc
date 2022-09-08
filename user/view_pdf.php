<?php

session_start();

include ('../config/db_config.php');


if (!isset($_SESSION['id'])) {
    header('location:../index');
}
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

$user_id = $_SESSION['id'];


if (isset($_GET['docno'])) {

    //select filemname
    $docno = $_GET['docno'];
    $get_documents_sql = "SELECT * FROM tbl_documents where docno = :docno";
    $get_documents_data = $con->prepare($get_documents_sql);
    $get_documents_data->execute([':docno' => $docno]);
    while ($result = $get_documents_data->fetch(PDO::FETCH_ASSOC)) {
        $get_file = $result['Filenames'];

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
    }

    $file = '../upload_doctrack/'. $get_file;

    $filename = $get_file;


    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename = "' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    echo file_get_contents($file);
    @readfile($file);
}


?>

