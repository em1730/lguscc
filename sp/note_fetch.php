<?php 
	include 'includes/session.php';
  
  

	if(isset($_POST['id'])){
    
    
		$id = $_POST['id'];
		$get_id_sql = "SELECT * FROM notes WHERE noteid = :id";
    $get_id_data = $con->prepare($get_id_sql);
    $get_id_data->execute([':id'=>$id]);
    while ($result2 = $get_id_data->fetch(PDO::FETCH_ASSOC)) {

  $noteid    = $result2['noteid'];
  $title    = $result2['title'];
  $content  = $result2['content'];
  $date     = $result2['date'];
  
}



$row = array(
  'noteid'         => $noteid,
  'title'          => $title,
  'content'        => $content,
  'date'           => $date,
);
    echo json_encode($row);
    
	}
?>