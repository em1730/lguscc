<?php

$host = "localhost";
$db_name = "scc_doctrack";
$username = "root";
$password = "";

try {
    //database connection
    $db_dts = new PDO("mysql:host=$host; dbname=$db_name", $username, $password);
    //initialize and error exception
    $db_dts->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch (PDOEXCEPTION $error) {

    echo "Connection Error: " . $error->getMessage();

}


?>