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
$password = "0Fd8xWc1anuE";
$entity_no = $_GET['entity_no'];
$date_from =   date('Y-m-d', strtotime( $_GET['datefrom']));
$date_to =  date('Y-m-d', strtotime( $_GET['dateto']));
$PHPJasperXML = new PHPJasperXML();
// $PHPJasperXML->debugsql=true;
// $PHPJasperXML->arrayParameter=array("employeeNo"=>'12345678');
$xml = $PHPJasperXML->load_xml_file("individual_history.jrxml");
// $PHPJasperXML->xml_dismantle($xml);
// $PHPJasperXML->sql = "SELECT r.trace_no,r.date,t.fullname from tbl_tracehistory r inner join tbl_individual t on t.entity_no = r.trace_no where  r.entity_no ='" . $entity_no . "'";

$PHPJasperXML->sql = "Select * FROM
(
    SELECT date, time, t.entity_no, t.trace_no, i.fullname, CONCAT(i.street, ', ', i.barangay) as details, i.mobile_no FROM `tbl_tracehistory` t
inner join tbl_individual i on i.entity_no = t.entity_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'

UNION

SELECT date, time, t.entity_no, t.trace_no, i.fullname, CONCAT(i.street, ', ', i.barangay) as details, i.mobile_no FROM `tbl_tracehistory` t
inner join tbl_individual i on i.entity_no = t.trace_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'
    
UNION

SELECT date, time, t.entity_no, t.trace_no, j.org_name, CONCAT(j.street, ', ', j.barangay) as details, j.mobile_no FROM `tbl_tracehistory` t
inner join tbl_juridical j on j.entity_no = t.entity_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'

UNION

SELECT date, time, t.entity_no, t.trace_no, j.org_name, CONCAT(j.street, ', ', j.barangay) as details, j.mobile_no FROM `tbl_tracehistory` t
inner join tbl_juridical j on j.entity_no = t.trace_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'

UNION

SELECT date, time, t.entity_no, t.trace_no, l.vehicle_name, l.plate_no, l.mobile_no FROM `tbl_tracehistory` t
inner join tbl_landtranspo l on l.entity_no = t.entity_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'
    
UNION

SELECT date, time, t.entity_no, t.trace_no, l.vehicle_name, l.plate_no, l.mobile_no FROM `tbl_tracehistory` t
inner join tbl_landtranspo l on l.entity_no = t.trace_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'
    
UNION

SELECT date, time, t.entity_no, t.trace_no, s.vessel_name, s.voyage_no, s.mobile_no FROM `tbl_tracehistory` t
inner join tbl_seatranspo s on s.entity_no = t.entity_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'
    
UNION

SELECT date, time, t.entity_no, t.trace_no, s.vessel_name, s.voyage_no, s.mobile_no FROM `tbl_tracehistory` t
inner join tbl_seatranspo s on s.entity_no = t.trace_no  WHERE t.entity_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."' or t.trace_no = '" . $entity_no . "' AND t.date between '".$date_from."' and '".$date_to."'
    
) dum
WHERE fullname NOT IN (Select fullname from tbl_individual where entity_no = '" . $entity_no . "'
)
ORDER BY date DESC, time DESC";

$PHPJasperXML->transferDBtoArray($host, $username, $password, $db_name);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file



?>