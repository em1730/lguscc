<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("PHPJasperXML.inc.php");



// $server = 'http://localhost:8888';
// $user = 'root';
// $pass = '1234';
// $db = 'sccdrrmo';


$host = "127.0.0.1";
$db_name = "sccdrrmo";
$username = "root";
$password = "I0nvNUWNXoYI";

// $host = "localhost";
// $db_name = "sccdrrmo";
// $username = "root";
// $password = "";
$barangay = $_GET['barangay1'];
$description = $_GET['description'];
$dose = $_GET['dose'];
$type = $_GET['type'];


// $entity_no = $_GET['entity_no'];
// $date_from =   date('Y-m-d', strtotime($_GET['datefrom']));
// $date_to =  date('Y-m-d', strtotime($_GET['dateto']));
$PHPJasperXML = new PHPJasperXML();
// $PHPJasperXML->debugsql=true;
// $PHPJasperXML->arrayParameter=array("employeeNo"=>'12345678');
$xml = $PHPJasperXML->load_xml_file("vaccinated_list.jrxml");
// $PHPJasperXML->xml_dismantle($xml);
// $PHPJasperXML->sql = "SELECT r.trace_no,r.date,t.fullname from tbl_tracehistory r inner join tbl_individual t on t.entity_no = r.trace_no where  r.entity_no ='" . $entity_no . "'";

$PHPJasperXML->sql = "SELECT CONCAT(lastname,', ',middlename,' ',firstname) as fullname,
category,sinovac,vaccinemanufacturer,1stdose,2nddose FROM tbl_vaccine r
inner join tbl_assessment t on t.entity_no = r.entity_no
where barangay = '" .$barangay . "' and Category = '" .$description . "'
and 1stdose = '" .$dose . "' and vaccinemanufacturer = '" .$type . "' order by fullname asc";

$PHPJasperXML->transferDBtoArray($host, $username, $password, $db_name);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
