<?php 
 require '../../core/inc/config.php';
 require '../../core/inc/function.php';
 if ($_POST) {
   if ($_POST['type']=='insert') {

     //---------------- 查詢重複QRcode --------------
     $pdo=pdo_conn();
   	 $sql=$pdo->prepare("SELECT * FROM QRcode_tb WHERE case_id=:case_id");
   	 $sql->execute(['case_id'=>$_POST['case_id']]);
   	 while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
   	 	if (array_search($_POST['QRcode_url'], $row)) {
   	 		echo "0";
   	 		exit();
   	 	}
   	 }

   	 	$param=[
   	 	      'Tb_index'=>'qr'.date('YmdHis').rand(0,99),
   	 	      'case_id'=>$_POST['case_id'],
   	 	      'QRcode_pic'=>$_POST['QRcode_pic'],
   	 	      'QRcode_url'=>$_POST['QRcode_url'],
   	 	      'source'=>$_POST['source'],
   	 	      'media'=>$_POST['media'],
   	 	      'event_name'=>$_POST['event_name']
   	 	 	];
   	 	 	pdo_insert('QRcode_tb', $param);
   	 	 	echo "1";

   }
   elseif($_POST['type']=='select'){
   	 $pdo=pdo_conn();
   	 $sql=$pdo->prepare("SELECT * FROM QRcode_tb WHERE case_id=:case_id");
   	 $sql->execute(['case_id'=>$_POST['case_id']]);
   	 $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   	 echo json_encode($row);
   }
 }
?>