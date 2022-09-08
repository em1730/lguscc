<?php
ob_start();
session_start();

require_once('tcpdf_include.php');
include('../../../config/db_config.php');


// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('LguSCC Record Management Sytem');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$docno = $_GET['docno'];


$pdf->SetFont('dejavusans', '', 10);
$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

//$pdf->Cell(0, 0, 'CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9', 0, 1);
$pdf->write1DBarcode($docno, 'C39', '', '', '', 18, 0.4, $style, 'N');

$pdf->Ln();

$pdf->AddPage('P');



$html = '<h1>Document No.:' . $docno .'</h1>';  




$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';

$html .= '


<thead>
         
<tr>
  <th>Division</th>
  <th>Destination</th>
  <th>Printed Name</th>
  <th>Signature</th>
  <th>Date</th>
  <th>Time</th>
  <th>Action Taken</th>
  <th>Remarks</th>

</tr>
</thead>
';



//select all users
$get_document_sql = "SELECT * FROM tbl_ledger WHERE docno = :docno";
$get_document_data = $con->prepare($get_document_sql);
$get_document_data->execute([':docno'=>$docno]);
while ($result = $get_document_data->fetch(PDO::FETCH_ASSOC)) {

// $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
// $email = $result['email'];
// $contact_number = $result['contact_number'];
$docno = $result['docno'];
$origin = $result['origin'];
$destination = $result['destination'];
$receiver = $result['receiver'];
$date = $result['txndate'];
$time = $result['time'];
$action = $result['status'];
$remarks = $result['remarks'];


$html .= '



    <tbody>
        <tr>
        <td>'. $origin .'</td>
        <td>'. $destination .'</td>
        <td>'. $receiver .'</td>
        <td></td>
        <td>'. $date .'</td>
        <td>'. $time  .'</td>
        <td>'. $action .'</td>
        <td>'. $remarks .'</td>
        <td></td>
       
        </tr>
                    
                                     
                 





                </tbody>
            ';
}

$html .= '</table>';


$pdf->writeHTML($html, true, false, true, false, '');
    


$pdf->lastPage();

ob_end_clean();

$pdf->Output('Plain.pdf', 'I');

