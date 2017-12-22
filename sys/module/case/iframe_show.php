<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.md-skin .navbar-static-side, .border-bottom{display: none;}
	#page-wrapper{ margin:0px;  }

	.ibox-tools a{ color: #626262; }
  .color_bar{ padding: 15px 25px; display: inline-block; }
	
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 

if($_POST){

    // ======================== 刪除(未完) ===========================
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    
        //----------------------- 多檔刪除 -------------------------------
        $sel_where=['Tb_index'=>$_POST['Tb_index']];
        $otr_file=pdo_select('SELECT show_img FROM slideshow_tb WHERE Tb_index=:Tb_index', $sel_where);
        $otr_file=explode(',', $otr_file['show_img']);
        for ($i=0; $i <count($otr_file)-1 ; $i++) { //比對 
           if ($otr_file[$i]!=$_POST['show_img']) {
            $new_file.=$otr_file[$i].',';
           }else{
             unlink('../../../product_html/'.$_POST['Tb_index'].'/img/'.$_POST['show_img']);
           }
        }
        $param=['show_img'=>$new_file];
            $where=['Tb_index'=>$_POST['Tb_index']];
            pdo_update('slideshow_tb', $param, $where);
      
       exit();
    }
  
  //----------------- 新增 ----------------------------------------------

  if(empty($_GET['fun_id'])){

    $Tb_index='ss'.date('YmdHis').rand(0,99);
   
    //-------------- 圖檔新增 ------------------
    if (!empty($_FILES['show_img']['name'][0])){

          for ($i=0; $i <count($_FILES['show_img']['name']) ; $i++) { 

             if (test_img($_FILES['show_img']['name'][$i])){

               $type=explode('/', $_FILES['show_img']['type'][$i]);
               $show_img.=$Tb_index.'_slider_'.$i.'.'.$type[1].',';
               more_fire_upload('show_img', $i, $Tb_index.'_slider_'.$i.'.'.$type[1], $_GET['Tb_index']);
             }
             else{
               location_up('admin.php?MT_id='.$_POST['mt_id'],'檔案錯誤!請上傳正確檔案');
               exit();
             }
          }
        }

    //---- 更新關聯資料表 -----
    pdo_update('Related_tb', ['fun_id'=>$Tb_index], ['case_id'=>$_GET['Tb_index']]);
    
    $param=[
       'Tb_index'=>$Tb_index,
       'case_id'=>$_GET['Tb_index'],
       'play_speed'=>$_POST['play_speed'],
       'show_img'=>$show_img,
       'StartDate'=>date('Y-m-d H:i:s')
    ];
    pdo_insert('slideshow_tb', $param);
    location_up('iframe_show.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index, '功能已成功新增');
  }

  //----------------- 修改 ----------------------------------------------

  else{

    $Tb_index=$_GET['fun_id'];
    
    //-------------- 圖檔修改 ------------------

    if (!empty($_FILES['show_img']['name'][0])) {
        $sel_where=['Tb_index'=>$Tb_index];
        $now_file =pdo_select("SELECT show_img FROM slideshow_tb WHERE Tb_index=:Tb_index", $sel_where);
        if (!empty($now_file['show_img'])) {
           $sel_file=explode(',', $now_file['show_img']);
           $file_num=explode('_', $sel_file[count($sel_file)-2]);
           $file_num=explode('.', $file_num[2]);
           $file_num=(int)$file_num[0]+1;
        }else{
           $file_num=0;
        }
        for ($i=0; $i <count($_FILES['show_img']['name']) ; $i++) { 

           if (test_img($_FILES['show_img']['name'][$i])){

               $type=explode('/', $_FILES['show_img']['type'][$i]);
               $show_img.=$Tb_index.'_slider_'.($file_num+$i).'.'.$type[1].',';
               more_fire_upload('show_img', $i, $Tb_index.'_slider_'.($file_num+$i).'.'.$type[1], $_GET['Tb_index']);
           }
           else{

            location_up('admin.php?MT_id='.$_POST['mt_id'],'檔案錯誤!請上傳正確檔案');
            exit();
           }
        }

        $show_img=$now_file['show_img'].$show_img;
         
        $show_img_param=['show_img'=>$show_img];
        $show_img_where=['Tb_index'=>$Tb_index];
        pdo_update('slideshow_tb', $show_img_param, $show_img_where);
      }

    //-------------- 圖檔修改-END ------------------

      $param=[
       'play_speed'=>$_POST['play_speed'],
       'show_img'=>$show_img
    ];
    pdo_update('slideshow_tb', $param, ['Tb_index'=>$Tb_index]);
    location_up('iframe_show.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index, '功能已更新');
  }
  
}//-- POST END --


  $row_case=pdo_select("SELECT aTitle FROM build_case WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']]);

  $Tb_id=substr($_GET['Tb_index'], 4);

  $row=pdo_select("SELECT * FROM slideshow_tb WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['fun_id']]);
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary"><?php echo $row_case['aTitle'];?>-圖片輪播</h2>
      
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
			 <div class="ibox-title">
			 	
			 	<div class="ibox-tools">
			 		<button id="save_btn" type="button" class="btn btn-primary">儲存</button>      
			 	</div>
			 </div>
			<div class="ibox-content">
				<form id="fun_form" action="#" method="POST" class="form-horizontal" enctype='multipart/form-data'>
				   <div class="form-group">
              <label class="col-sm-2 control-label" for="play_speed">延遲時間</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="play_speed" name="play_speed" value="<?php echo $row['play_speed'];?>">
              </div>
              
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="show_img">圖片</label>
              <div class="col-sm-6">
                <input type="file" class="form-control" id="show_img" name="show_img[]" multiple onchange="file_viewer_load_new(this,'#img_box')">
              </div>
              
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label" ></label>
               <div id="img_box" class="col-md-10">
                
              </div>

              <div class="col-md-10">
        <?php if(!empty($row['show_img'])){
                                  
                          $show_img=explode(',', $row['show_img']);
                          for ($i=0; $i <count($show_img)-1 ; $i++) { 
                             $other_txt='<div class="file_div" >
                                          <p>目前檔案</p>
                                           <button type="button" class="one_del_file"> X </button>
                                           <img id="one_img" src="../../../product_html/'.$_GET['Tb_index'].'/img/'.$show_img[$i].'" alt="">
                                           <input type="hidden" value="'.$show_img[$i].'">
                                         </div>';
                             echo $other_txt;
                          }
                        }
          ?>
                  </div>

            </div>
            
         
				</form>
			</div>
		</div>
	</div>
</div>


</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>
<script type="text/javascript">
	$(document).ready(function() {
        

      $('#save_btn').click(function(event) {
         $('#fun_form').submit();
      });

      //------------------------------ 刪圖檔 ---------------------------------
          $(".one_del_file").click(function(event) { 
      if (confirm('是否要刪除檔案?')) {
       var data={
                Tb_index: '<?php echo $_GET['fun_id'];?>',
                       show_img: $(this).next().next().val(),
                            type: 'delete'
                };  
               ajax_in('iframe_show.php', data, '成功刪除', 'no');
               $(this).parent().html('');
      }
    });
	});
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
