<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("PHPJasperXML.inc.php");



$server = 'localhost';
$user = 'root';
$pass = '1234';
$db = 'scc_doctrack';
$prno = $_GET['controlno'];

$PHPJasperXML = new PHPJasperXML();
// $PHPJasperXML->debugsql=true;
// $PHPJasperXML->arrayParameter=array("employeeNo"=>'12345678');
$xml = $PHPJasperXML->load_xml_file("pr_items2.jrxml");
// $PHPJasperXML->xml_dismantle($xml);
$PHPJasperXML->sql = "SELECT * FROM pr_items p inner join pr_info i on p.pr_info_controlno = i.pr_info_control_no  where p.pr_info_controlno =" . $prno . "";
$PHPJasperXML->transferDBtoArray($server, $user, $pass, $db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
