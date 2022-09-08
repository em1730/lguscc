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


if (isset($_GET['orno'])) {

    //select filemname
    $ordinanceno = $_GET['orno'];
    $get_ordinances_sql = "SELECT * FROM ordinances where OrdinanceNumber = :or";
    $get_ordinances_data = $con->prepare($get_ordinances_sql);
    $get_ordinances_data->execute([':or' => $ordinanceno]);
    while ($result = $get_ordinances_data->fetch(PDO::FETCH_ASSOC)) {
        $update_orno = $result['OrdinanceNumber'];
        $get_orTitle = $result['OrdinanceTitle'];
        $get_dateHearing = $result['DatePHearing'];
        $get_dateEnacted = $result['DateEnacted'];
        $get_dateLCE = $result['DateLCE'];
        $get_dateProvince = $result['DateProvince'];
        $get_dateAdded = $result['DateAdded'];
        $get_author = $result['Author'];
        $get_coauthor = $result['CoAuthor'];
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

