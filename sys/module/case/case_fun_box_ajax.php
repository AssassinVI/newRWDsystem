<?php 
 require '../../core/inc/config.php';
 require '../../core/inc/function.php';

 if ($_POST) {
 	
 	//------- 新增功能區塊關聯 ------
 	if($_POST['type']=='insert'){

 	  $Tb_index='re'.date('YmdHis').rand(0,99);

 	  $OrderBy_num=pdo_select("SELECT OrderBy FROM Related_tb WHERE case_id=:case_id ORDER BY OrderBy DESC LIMIT 0,1", ['case_id'=>$_POST['case_id']]);

      $param=[
           'Tb_index'=>$Tb_index,
           'case_id'=>$_POST['case_id'],
           'funbox_id'=>$_POST['funbox_id'],
           'OrderBy'=>(int)$OrderBy_num['OrderBy']+1
      ];
      pdo_insert('Related_tb', $param);

      echo $Tb_index;
 	}
    //------- 撈取功能區塊關聯 ------
 	elseif($_POST['type']=='select'){
      
      $pdo=pdo_conn();
      $sql=$pdo->prepare("SELECT * FROM Related_tb WHERE case_id=:case_id ORDER BY OrderBy ASC");
      $sql->execute(['case_id'=>$_POST['case_id']]);
      $row=$sql->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($row);
 	}
    //------- 撈取功能區塊 ------
 	elseif($_POST['type']=='sel_funbox'){
      
      $FunBox=pdo_select("SELECT * FROM FunBox WHERE Tb_index=:Tb_index", ['Tb_index'=>$_POST['funbox_id']]);
      echo json_encode($FunBox);
 	}
  //------- 更新功能區塊排序 ------
 	elseif($_POST['type']=='update'){
       
       for ($i=0; $i <count($_POST['related_id_array']) ; $i++) { 
       	 pdo_update('Related_tb', ['OrderBy'=>($i+1)], ['Tb_index'=>$_POST['related_id_array'][$i]]);
       	//echo $_POST['related_id_array'][$i].'\n';
       }
 	}
  //------- 刪除功能區塊 ------
  elseif($_POST['type']=='delete'){
    
    $row=pdo_select("SELECT fun_id, funbox_id FROM Related_tb WHERE Tb_index=:Tb_index", ['Tb_index'=>$_POST['related_id']]);

    if(empty($row['fun_id'])){
       //-- 刪除關聯 --
       pdo_delete('Related_tb', ['Tb_index'=>$_POST['related_id']]);
    }
    else{
       
       //-- 功能資料表 --
       $funBox_row=pdo_select("SELECT fun_tb FROM FunBox WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['funbox_id']]);


       //----------- 刪除功能區塊所有檔案 -------------

       if($funBox_row['fun_tb'=='slideshow_tb']){

          $show_row=pdo_select("SELECT show_img, case_id FROM slideshow_tb WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['fun_id']]);
          $show_img=explode(',', $show_row['show_img']);
          for ($i=0; $i <count($show_img)-1 ; $i++) { 
            unlink('../../../product_html/'.$show_row['case_id'].'/img/'.$show_img[$i]);
          }
       }
       elseif($funBox_row['fun_tb'=='youtube_tb']){

         $you_row=pdo_select("SELECT video_file, case_id FROM youtube_tb WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['fun_id']]);
         unlink('../../../product_html/'.$you_row['case_id'].'/video/'.$you_row['video_file']);

       }

       //-- 刪除關聯 --
       pdo_delete('Related_tb', ['Tb_index'=>$_POST['related_id']]);
       //-- 刪除功能區塊 --
       pdo_delete($funBox_row['fun_tb'], ['Tb_index'=>$row['fun_id']]);
       //-- (未完) --
    }
  }
 }
?>