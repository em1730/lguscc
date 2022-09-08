<?php
session_start();


$response = array();


  
    $response[] = array{
      "docno" =>"hello",
      "text" =>"hi"
    };

  }
  // while ($row = $mysqli_fetch_array($fetchData)){
  //     $data[] = array("docno"=>$row['docno']);


    echo json_encode($response);
    exit();
    
    // die();
    
?>