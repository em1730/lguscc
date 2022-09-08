<?php
ob_start();
session_start();

require_once('tcpdf_include.php');
include('../../../config/db_config.php');
//include ('update_print.php');


$width = 10;
$height = 10;
$pageLayout = array($width, $height);

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('SP Document Tracking Sytem');
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


//$pdf->SetFont('dejavusans', '', 8);
$pdf->SetFont('dejavusans', '', 8);
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
    'stretchtext' => 4,
    'orientation'=> 'landscape'
);

$pdf->AddPage('L');

$resolutionno = $_GET['ResolutionNumber'];
$print = 1;



$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';

$html .= '



          <thead>
         
           <tr>
              <th><b>Resolution No.</b></th>
              <th><b>Resolution Title</b></th>
              <th><b>Date Adopted</b></th>
              <th><b>Date Approved LCE</b></th>
              <th><b>Date Added</b></th>
              <th><b>Author</b></th>
              <th><b>Co-Author</b></th>
              <th><b>Category</b></th>
            </tr>
          </thead>
        ';



//select all users


    if($resolutionno != "Please select..."){


        $get_all_resolutions_sql = "SELECT * FROM resolutions order by ResolutionNumber";
        $get_all_resolutions_data = $con->prepare($get_all_resolutions_sql);
        $get_all_resolutions_data->execute();

        
        
        while ($result = $get_all_resolutions_data->fetch(PDO::FETCH_ASSOC)) {


    // $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    // $email = $result['email'];
    // $contact_number = $result['contact_number'];
        $resolutionno = $result['ResolutionNumber'];
        $resolutiontitle =$result['resolutionTitle'];
        $dateadopted =$result['DateAdopted'];
        $dateapprovedlce =$result['DateApprovedLCE'];
        $dateadded =$result['DateAdded'];
        $authors =$result['Author'];
        $coauthor =$result['CoAuthor'];
        $category =$result['Category'];

        $html .= '

   

        <tbody>
            <tr>
            <td>'. $resolutionno .'</td>
            <td>'. $resolutiontitle .'</td>
            <td>'. $dateadopted .'</td>
            <td>'. $dateapprovedlce .'</td>
            <td> '. $dateadded.'</td>
            <td> '. $authors.'</td>
            <td>'.$coauthor.'</td>
            <td>'.$category.'</td>
            </tr>

            
           
          

        </tbody>
    ';

        }
    

    }
    
    $html .= '</table>'; 



$pdf->writeHTML($html, true, false, true, false, '');
    


$pdf->lastPage();

ob_end_clean();

$pdf->Output('Plain.pdf', 'I');




