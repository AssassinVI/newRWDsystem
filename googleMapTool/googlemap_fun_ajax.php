<?php require '../sys/core/inc/config.php';?>
<?php require '../sys/core/inc/function.php';?>
<?php
  if ($_POST) {
  	 
  	 $row=pdo_select("SELECT * FROM life_tb WHERE case_id=:case_id", ['case_id'=>$_POST['case_id']]);
  	 
  	 echo json_encode($row);
  }
?>