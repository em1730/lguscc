<?php
ob_start();
session_start();

require_once('tcpdf_include.php');
include('../../../config/db_config.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// $pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor('Nicola Asuni');
// $pdf->SetTitle('PHP TUTORIAL TAGALOG: LESSON 5');
// $pdf->SetSubject('TCPDF Tutorial');
// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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


$pdf->SetFont('dejavusans', '', 10);


$pdf->AddPage('P');

$html = '<table border="1" width="100%" cellspacing="0" cellpadding="5">';

$html .= '
          <thead>
            <tr>
              <th>Fullname</th>
              <th>Email</th>
              <th>Contact Number</th>
            </tr>
          </thead>
        ';
//select all users
$get_all_users_sql = "SELECT * FROM tbl_documents WHERE docno != :docno";
$get_all_users_data = $con->prepare($get_all_users_sql);
$get_all_users_data->execute([':id'=>$_SESSION['id']]);
while ($result = $get_all_users_data->fetch(PDO::FETCH_ASSOC)) {

    $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    $email = $result['email'];
    $contact_number = $result['contact_number'];

    $html .= '

                <tbody>
                    <tr>
                        <td>' . $fullname . '</td>
                        <td>' . $email . '</td>
                        <td>' . $contact_number . '</td>
                    </tr>
                </tbody>
            ';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
    


$pdf->lastPage();

ob_end_clean();

$pdf->Output('Plain.pdf', 'I');

