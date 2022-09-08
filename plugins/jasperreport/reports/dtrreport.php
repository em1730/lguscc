<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("PHPJasperXML.inc.php");
include_once ('setting.php');

$empno= $_GET['empno'];
$date = $_GET['year'];
$days = $_GET['days'];
$server = 'localhost';
$user = 'root';
$pass = '1234';
$db = 'pmis';


$PHPJasperXML = new PHPJasperXML();
// $PHPJasperXML->debugsql=true;
// $PHPJasperXML->arrayParameter=array("employeeNo"=>'12345678');
        if($days =='31'){
        $xml = $PHPJasperXML->load_xml_file("dtrreport.jrxml");
        }
        if($days =='30'){
        $xml = $PHPJasperXML->load_xml_file("dtrreport30.jrxml");
         }
        if($days =='29'){
        $xml = $PHPJasperXML->load_xml_file("dtrreport29.jrxml");
        }
        if($days =='28'){
        $xml = $PHPJasperXML->load_xml_file("dtrreport28.jrxml");
        }
// $PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->sql ="
SELECT CONCAT(e.lastName,', ',e.firstName,', ',LEFT(e.middleName, 1),'.')  AS fullName,
d.inAM,d.outAM,d.inPM,d.outPM,d.otIn,d.otOut,e.supervisor,DATE_FORMAT(d.Date,'%d')as day,
DATE_FORMAT(d.Date,'%M,%Y')AS month,
TIME_FORMAT(d.late,'%H:%i') as late,
TIME_FORMAT(d.undertime,'%H:%i') as undertime,
(SELECT TIME_FORMAT(ADDTIME(SEC_TO_TIME(SUM(TIME_TO_SEC(late))),SEC_TO_TIME(SUM(TIME_TO_SEC(undertime)))),'%H:%i')  FROM bioinfo e 
INNER JOIN dailytimerecord d ON e.employeeNo = d.employeeNo WHERE e.employeeNo = ".$empno." 
AND d.Date LIKE '".$date."')as total 
FROM bioinfo e 
INNER JOIN dailytimerecord d ON e.employeeNo = d.employeeNo WHERE e.employeeNo = ".$empno." 
AND d.Date LIKE '".$date."'
GROUP BY Date";
// $PHPJasperXML->sql = "CALL spPrintDtr('12345678','2019-10-01','2019-10-31')";
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>
