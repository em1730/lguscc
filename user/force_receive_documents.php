<?php
session_start();

include ('../config/db_config.php');

$numberofrecords = 10;
// define ($servername,"localhost");
// define ($username,"root");
// define ($password,"");
// define ($dbname,"scc_doctrack");

// $mysqli = new mysqli($servername, $username, $password, $dbname);
// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (!isset($_POST['searchTerm'])){
    $stmt = $con->prepare("SELECT * FROM tbl_documents order by docno LIMIT :limit");
    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $usersList = $stmt->fetchAll();
    // $fetchData = mysqli_query($con,  "SELECT * FROM tbl_documents order by docno LIMIT 10" );
}else{
    $search = $_POST['searchTerm'];

    $stmt = $con->prepare("SELECT * FROM tbl_documents where docno like :name order by docno LIMIT :limit");
    $stmt->bindValue(':name', '%'.$search.'%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', (int)$numberofrecords, PDO::PARAM_INT);
    $stmt->execute();
    $usersList = $stmt->fetchAll();
    // $fetchData = mysqli_query($con,  "SELECT * FROM tbl_documents where docno like '%".$_GET['q']."%' order by docno LIMIT 10" );
}

// $sql = "SELECT * FROM tbl_documents where docno like '%".$_GET['q']."%' order by docno LIMIT 10";

// $result = $mysqli->query($sql);
// $query=mysqli_query($conn, $sql) or die("forcereceive.php");

// $json = [];

$response = array();
  // while ($row = $result->fetch_assoc()){
  //   $json[] = ['docno'=>$result['docno'];
  //   }

  foreach ($usersList as $user){
    $response[] = array(
      "id" =>$user['docno'],
      "text" =>$user['docno']
    );

  }
  // while ($row = $mysqli_fetch_array($fetchData)){
  //     $data[] = array("docno"=>$row['docno']);


    echo json_encode($response);
    exit();
    
    // die();
    
?>