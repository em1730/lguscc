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


// $host = "127.0.0.1";
// $db_name = "sccdrrmo";
// $username = "root";
// $password = "I0nvNUWNXoYI";

$host = "localhost";
$db_name = "sccdrrmo";
$username = "root";
$password = "";


// $entity_no = $_GET['entity_no'];
// $date_from =   date('Y-m-d', strtotime($_GET['datefrom']));
// $date_to =  date('Y-m-d', strtotime($_GET['dateto']));
$PHPJasperXML = new PHPJasperXML();
// $PHPJasperXML->debugsql=true;
// $PHPJasperXML->arrayParameter=array("employeeNo"=>'12345678');
$xml = $PHPJasperXML->load_xml_file("vaccine_sandoc.jrxml");
// $PHPJasperXML->xml_dismantle($xml);
// $PHPJasperXML->sql = "SELECT r.trace_no,r.date,t.fullname from tbl_tracehistory r inner join tbl_individual t on t.entity_no = r.trace_no where  r.entity_no ='" . $entity_no . "'";

$PHPJasperXML->sql = "SELECT
concat(firstname,' ',middlename,', ',lastname) as sinovac
from tbl_vaccine where employer_name like '%doctors%' and consent ='01_Yes' and sinovac = '01_Yes'";

$PHPJasperXML->transferDBtoArray($host, $username, $password, $db_name);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file



?>