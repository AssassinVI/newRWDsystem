<?php 
 require '../../core/inc/config.php';
 require '../../core/inc/function.php';
 if ($_POST) {
   if ($_POST['type']=='company') {

     //---------------- 查詢專案 --------------
     $pdo=pdo_conn();

     if ($_POST['com_id']=='all') {
        $sql=$pdo->prepare("SELECT Tb_index, aTitle, version, OnLineOrNot, OrderBy FROM build_case ORDER BY OrderBy DESC, Tb_index DESC");
        $sql->execute();
     }
     else{
       $sql=$pdo->prepare("SELECT Tb_index, aTitle, version, OnLineOrNot, OrderBy FROM build_case WHERE com_id=:com_id ORDER BY OrderBy DESC, Tb_index DESC");
       $sql->execute(['com_id'=>$_POST['com_id']]);
     }
   	 
       $row=$sql->fetchAll(PDO::FETCH_ASSOC);
   	
      echo json_encode($row);
   }
  
 }
?>