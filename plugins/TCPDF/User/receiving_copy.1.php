<?php
ob_start();
session_start();

require_once('tcpdf_include.php');
include('../../../config/db_config.php');
//include ('update_print.php');


$width = 10;
$height = 13;
$pageLayout = array($width, $height);

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF("PDF_PAGE_ORIENTATION", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
    'stretchtext' => 4
    
);

$pdf->AddPage('P');

$origin = $_GET['origin'];
$type = $_GET['type'];
$date_from = date('Y-m-d', strtotime($_GET['date_from']));
$date_to = date('Y-m-d', strtotime($_GET['date_to']));
$department = $_GET['department'];
$user = $_GET['user'];
$username = $_GET['username'];
$user = $_GET['user'];
$print = 1;


$html = '<h2>Date Range.:' . $_GET['date_from'] .' - '. $_GET['date_to'] .'</h2>';  





$html .= '<table border="1" width="100%" cellspacing="0" cellpadding="5">';

$html .= '



          <thead>
         
            <tr>
              <th>Document No.</th>
              <th>Office</th>
              <th>Destination</th> 
              <th>Particulars</th>  
              <th>Receiver</th>         
              <th>Date Received</th>

            </tr>
          </thead>
        ';



//select all users

if ($origin !="Please select..."){
    if ($type !="Please select..."){


        $get_document_sql = "SELECT DISTINCT * FROM tbl_documents d inner join tbl_ledger l on l.docno = d.docno WHERE d.type = :type and d.creator = :origin and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0 group by l.docno order by UNIX_TIMESTAMP(l.txndate),UNIX_TIMESTAMP(l.time)";
        $get_document_data = $con->prepare($get_document_sql);
        $get_document_data->execute(array(':type'=>$type,':origin'=>$origin));

        while ($result = $get_document_data->fetch(PDO::FETCH_ASSOC)) {

    // $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    // $email = $result['email'];
    // $contact_number = $result['contact_number'];
        $docno = $result['docno'];
        $creator = $result['creator'];
        $destination = $result['destination'];
        $receiver = $result['receiver'];
        $particulars = $result['particulars'];
        $date = $result['txndate'];
        $time = $result['time'];
        $action = $result['status'];
        $remarks = $result['remarks'];





    $html .= '

   

                <tbody>
                    <tr>
                    <td>'. $docno .'</td>
                    <td>'. $creator .'</td>
                    <td>'. $destination .'</td>
                    <td>'. $particulars .'</td>
                    <td></td>
                    <td></td>
                    </tr>

                    
                   
                  

                </tbody>
            ';
}


    }elseif ($type =="Please select..."){


        $get_document_sql = "SELECT DISTINCT * FROM tbl_documents d inner join tbl_ledger l on l.docno = d.docno WHERE d.creator = :origin and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0 group by l.docno order by UNIX_TIMESTAMP(l.txndate),UNIX_TIMESTAMP(l.time)";
        $get_document_data = $con->prepare($get_document_sql);
        $get_document_data->execute([':origin'=>$origin]);

        while ($result = $get_document_data->fetch(PDO::FETCH_ASSOC)) {

    // $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    // $email = $result['email'];
    // $contact_number = $result['contact_number'];
        $docno = $result['docno'];
        $creator = $result['creator'];
        $destination = $result['destination'];
        $receiver = $result['receiver'];
        $particulars = $result['particulars'];
        $date = $result['txndate'];
        $time = $result['time'];
        $action = $result['status'];
        $remarks = $result['remarks'];





    $html .= '

   

                <tbody>
                    <tr>
                    <td>'. $docno .'</td>
                    <td>'. $creator .'</td>
                    <td>'. $destination .'</td>
                    <td>'. $particulars .'</td>
                    <td></td>
                    <td></td>
                    </tr>

                    
                   
                  

                </tbody>
            ';
}

    }





}elseif ($origin =="Please select..."){
    if ($type !="Please select..."){


        $get_document_sql = "SELECT DISTINCT * FROM tbl_documents d inner join tbl_ledger l on l.docno = d.docno WHERE d.type = :type and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0 group by l.docno order by UNIX_TIMESTAMP(l.txndate),UNIX_TIMESTAMP(l.time)";
        $get_document_data = $con->prepare($get_document_sql);
        $get_document_data->execute([':type'=>$type]);

        while ($result = $get_document_data->fetch(PDO::FETCH_ASSOC)) {

    // $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    // $email = $result['email'];
    // $contact_number = $result['contact_number'];
        $docno = $result['docno'];
        $creator = $result['creator'];
        $destination = $result['destination'];
        $receiver = $result['receiver'];
        $particulars = $result['particulars'];
        $date = $result['txndate'];
        $time = $result['time'];
        $action = $result['status'];
        $remarks = $result['remarks'];





    $html .= '

   

                <tbody>
                    <tr>
                    <td>'. $docno .'</td>
                    <td>'. $creator .'</td>
                    <td>'. $destination .'</td>
                    <td>'. $particulars .'</td>
                    <td></td>
                    <td></td>
                    </tr>

                    
                   
                  

                </tbody>
            ';
}


    }elseif ($type =="Please select..."){


        $get_document_sql = "SELECT DISTINCT * FROM tbl_documents d inner join tbl_ledger l on l.docno = d.docno  WHERE l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0 group by l.docno order by UNIX_TIMESTAMP(l.txndate),UNIX_TIMESTAMP(l.time)";
        $get_document_data = $con->prepare($get_document_sql);
        $get_document_data->execute();

        while ($result = $get_document_data->fetch(PDO::FETCH_ASSOC)) {

    // $fullname = ucfirst($result['first_name']) . ' ' . ucwords($result['middle_name']) . ' ' . ucfirst($result['last_name']);
    // $email = $result['email'];
    // $contact_number = $result['contact_number'];
        $docno = $result['docno'];
        $creator = $result['creator'];
        $destination = $result['destination'];
        $receiver = $result['receiver'];
        $particulars = $result['particulars'];
        $date = $result['txndate'];
        $time = $result['time'];
        $action = $result['status'];
        $remarks = $result['remarks'];





    $html .= '

   

                <tbody>
                    <tr>
                    <td>'. $docno .'</td>
                    <td>'. $creator .'</td>
                    <td>'. $destination .'</td>
                    <td>'. $particulars .'</td>
                    <td></td>
                    <td></td>
                    </tr>

                    
                   
                  

                </tbody>
            ';
}

    }
 
}


$html .= '</table>';

$html .=  '<h4>Prepared by: </h4>';
  
$html .=  '<h3>'. $username.'</h3';  


$pdf->writeHTML($html, true, false, true, false, '');
    


$pdf->lastPage();

ob_end_clean();

$pdf->Output('Plain.pdf', 'I');



if ($origin !="Please select..."){
    if ($type !="Please select..."){
        $update_document_sql = "UPDATE tbl_documents d inner join tbl_ledger l on d.docno = l.docno set d.print = :print WHERE d.type = :type and creator = :origin and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0";
        
                
        $update_data = $con->prepare($update_document_sql);
        $update_data->execute([
            ':print'            => $print,
            ':type'             => $type,
            ':origin'           => $origin
            
           
            ]);
    }elseif ($type =="Please select..."){
        $update_document_sql = "UPDATE tbl_documents d inner join tbl_ledger l on d.docno = l.docno set d.print = :print WHERE creator = :origin and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0";
            
                    
        $update_data = $con->prepare($update_document_sql);
        $update_data->execute([
            ':print'            => $print,
            ':origin'           => $origin
            
           
            ]);
    }
}elseif ($origin =="Please select..."){
    if ($type !="Please select..."){
        $update_document_sql = "UPDATE tbl_documents d inner join tbl_ledger l on d.docno = l.docno set d.print = :print WHERE d.type = :type and l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0";
          
        $update_data = $con->prepare($update_document_sql);
        $update_data->execute([
            ':print'            => $print,
            ':type'             => $type
        
            ]);
        
    }elseif ($type =="Please select..."){
        $update_document_sql = "UPDATE tbl_documents d inner join tbl_ledger l on d.docno = l.docno set d.print = :print WHERE l.txndate between '$date_from' and '$date_to' and l.status in ('FORWARDED','CREATED') and d.status in ('FORWARDED','CREATED') and l.origin = '$department' and l.receiver = '$user' and d.print = 0";
        $update_data = $con->prepare($update_document_sql);
        $update_data->execute([
            ':print'  => $print
         
            
           
            ]);
    }
}



