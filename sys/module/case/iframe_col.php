<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.md-skin .navbar-static-side, .border-bottom, body.fixed-sidebar .navbar-static-side, body.canvas-menu .navbar-static-side{display: none;}
	#page-wrapper{ margin:0px;  }

	.ibox-tools a{ color: #626262; }
  .color_bar{ padding: 15px 25px; display: inline-block; }

  #txt_fadein_type{ display: none; }
  #img_fadein_type{ display: none; }
	
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 

if($_POST){

    // ======================== 刪除 ===========================
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 

      if (!empty($_POST['back_img'])) {
            $param=['back_img'=>''];
            $where=['Tb_index'=>$_POST['fun_id']];
            pdo_update('base_word', $param, $where);
            unlink('../../../product_html/'.$_POST['case_id'].'/img/'.$_POST['back_img']);
      }
      else{
    
        //----------------------- 多檔刪除 -------------------------------
        $sel_where=['Tb_index'=>$_POST['fun_id']];
        $otr_file=pdo_select('SELECT base_img FROM base_word WHERE Tb_index=:Tb_index', $sel_where);
        $otr_file=explode(',', $otr_file['base_img']);
        for ($i=0; $i <count($otr_file)-1 ; $i++) { //比對 
           if ($otr_file[$i]!=$_POST['base_img']) {
            $new_file.=$otr_file[$i].',';
           }else{
             unlink('../../../product_html/'.$_POST['case_id'].'/img/'.$_POST['base_img']);
           }
        }
        $param=['base_img'=>$new_file];
            $where=['Tb_index'=>$_POST['fun_id']];
            pdo_update('base_word', $param, $where);
      }
       exit();

    }
  
  //----------------- 新增 ----------------------------------------------

  if(empty($_GET['fun_id'])){

    $Tb_index='bs'.date('YmdHis').rand(0,99);

   
    //-------------- 圖檔新增 ------------------
    if (!empty($_FILES['base_img']['name'][0])){

          for ($i=0; $i <count($_FILES['base_img']['name']) ; $i++) { 

             if (test_img($_FILES['base_img']['name'][$i])){

               $type=explode('/', $_FILES['base_img']['type'][$i]);
               $base_img.=$Tb_index.'_base_'.$i.'.'.$type[1].',';
               more_fire_upload('base_img', $i, $Tb_index.'_base_'.$i.'.'.$type[1], $_GET['Tb_index']);
             }
             else{
               location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$_GET['fun_id'].'&rel_id='.$_GET['rel_id'],'檔案錯誤!請上傳正確檔案');
               exit();
             }
          }
        }

    //===================== 背景圖 ========================
      if (!empty($_FILES['back_img']['name'])){

        if (test_img($_FILES['back_img']['name'])) {
         $type=explode('/', $_FILES['back_img']['type']);
         $back_img=$Tb_index.'_back.'.$type[1];
         fire_upload('back_img', $back_img, $_GET['Tb_index']);
        }
        else{
         location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$_GET['fun_id'].'&rel_id='.$_GET['rel_id'],'檔案錯誤!請上傳正確檔案');
          exit();
        }
         
    }

    //---- 更新關聯資料表 -----
    pdo_update('Related_tb', ['fun_id'=>$Tb_index], ['Tb_index'=>$_GET['rel_id']]);

    $line_show=empty($_POST['line_show'])? 0 : 1;
    $OnLineOrNot=empty($_POST['OnLineOrNot'])? 0 : 1;
    
    $txt_fadein=empty($_POST['txt_fadein']) ? '' : $_POST['txt_fadein_type'];
    $img_fadein=empty($_POST['img_fadein']) ? '' : $_POST['img_fadein_type'];
    
    $param=[
       'Tb_index'=>$Tb_index,
       'case_id'=>$_GET['Tb_index'],
       'aTitle'=>$_POST['aTitle'],
       'Title_two'=>$_POST['Title_two'],
       'content'=>$_POST['content'],
       'base_img'=>$base_img,
       'back_img'=>$back_img,
       'txt_fadein'=>$txt_fadein,
       'img_fadein'=>$img_fadein,
       
       'line_show'=>$line_show,
       'OnLineOrNot'=>$OnLineOrNot,
       'StartDate'=>date('Y-m-d H:i:s')
    ];
    pdo_insert('base_word', $param);
    location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index, '功能已成功新增');
  }

  //----------------- 修改 ----------------------------------------------

  else{

    $Tb_index=$_GET['fun_id'];
    
    //-------------- 圖檔修改 ------------------

    if (!empty($_FILES['base_img']['name'][0])) {
        $sel_where=['Tb_index'=>$Tb_index];
        $now_file =pdo_select("SELECT base_img FROM base_word WHERE Tb_index=:Tb_index", $sel_where);
        if (!empty($now_file['base_img'])) {
           $sel_file=explode(',', $now_file['base_img']);
           $file_num=explode('_', $sel_file[count($sel_file)-2]);
           $file_num=explode('.', $file_num[2]);
           $file_num=(int)$file_num[0]+1;
        }else{
           $file_num=0;
        }
        for ($i=0; $i <count($_FILES['base_img']['name']) ; $i++) { 

           if (test_img($_FILES['base_img']['name'][$i])){

               $type=explode('/', $_FILES['base_img']['type'][$i]);
               $base_img.=$Tb_index.'_base_'.($file_num+$i).'.'.$type[1].',';
               more_fire_upload('base_img', $i, $Tb_index.'_base_'.($file_num+$i).'.'.$type[1], $_GET['Tb_index']);
           }
           else{

            location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index,'檔案錯誤!請上傳正確檔案');
            exit();
           }
        }

        $base_img=$now_file['base_img'].$base_img;
         
        $base_img_param=['base_img'=>$base_img];
        $base_img_where=['Tb_index'=>$Tb_index];
        pdo_update('base_word', $base_img_param, $base_img_where);
      }

    //-------------- 圖檔修改-END ------------------


    //===================== 背景圖 ========================

    if (!empty($_FILES['back_img']['name'])) {

        if (test_img($_FILES['back_img']['name'])){

         $type=explode('/', $_FILES['back_img']['type']);
         $back_img=$Tb_index.'_back'.date('His').'.'.$type[1];
         fire_upload('back_img', $back_img, $_GET['Tb_index']);
        $back_img_param=['back_img'=>$back_img];
        $back_img_where=['Tb_index'=>$Tb_index];
        pdo_update('base_word', $back_img_param, $back_img_where);

        }
        else{

         location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index,'檔案錯誤!請上傳正確檔案');
         exit();
        }
      }


      $line_show=empty($_POST['line_show'])? 0 : 1;
      $OnLineOrNot=empty($_POST['OnLineOrNot'])? 0 : 1;
      
      $txt_fadein=empty($_POST['txt_fadein']) ? '' : $_POST['txt_fadein_type'];
      $img_fadein=empty($_POST['img_fadein']) ? '' : $_POST['img_fadein_type'];

      $param=[
       'aTitle'=>$_POST['aTitle'],
       'Title_two'=>$_POST['Title_two'],
       'content'=>$_POST['content'],
       'txt_fadein'=>$txt_fadein,
       'img_fadein'=>$img_fadein,
       
       'line_show'=>$line_show,
       'OnLineOrNot'=>$OnLineOrNot
    ];
    pdo_update('base_word', $param, ['Tb_index'=>$Tb_index]);
    location_up('iframe_base.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index, '功能已更新');
  }
  
}//-- POST END --


  $row_case=pdo_select("SELECT aTitle FROM build_case WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']]);

  $Tb_id=substr($_GET['Tb_index'], 4);

  $row=pdo_select("SELECT * FROM base_word WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['fun_id']]);
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary"><?php echo $row_case['aTitle'];?>-多段圖文</h2>
      
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
              <label class="col-sm-2 control-label" for="aTitle">主標</label>
              <div class="col-sm-10">
                <input type="text" id="aTitle" name="aTitle[]" class="form-control" value="<?php echo $row['aTitle'];?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="Title_two">副標</label>
              <div class="col-sm-10">
                <input type="text" id="Title_two" name="Title_two[]" class="form-control" value="<?php echo $row['Title_two'];?>">
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="aPic">圖片上傳</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="aPic[]" name="aPic" onchange="file_viewer_load_new(this,'#back_box')">
              </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label" ></label>
               <div id="back_box" class="col-md-4">
                
              </div>
            <?php if(!empty($row['aPic'])){
               $aPic_url='../../../product_html/'.$_GET['Tb_index'].'/img/'.$row['aPic'];
              ?>
              <div  class="col-md-4">
                 <div id="img_div" >
                  <p>目前圖檔</p>
                 <button type="button" id="one_del_img"> X </button>
                  <img id="one_img" src="<?php echo $aPic_url;?>" alt="請上傳代表圖檔">
                  <input type="hidden" value="<?php echo $row['aPic'];?>">
                </div>
              </div>
            <?php }?>   
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="content">內容</label>
              <div class="col-sm-10">
                <textarea id="ckeditor1" name="content[]" class="form-control"><?php echo $row['content'];?></textarea>
              </div>
            </div>



            <!-- 關閉欄位 -->
            <!-- 關閉欄位 -->
            <!-- 關閉欄位 -->
            <div style="display: none;" class="form-group">
              <label class="col-sm-2 control-label" for="base_img">圖片</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" id="base_img" name="base_img[]" multiple onchange="file_viewer_load_new(this,'#img_box')">
              </div>
              
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label" ></label>
               <div id="img_box" class="col-md-10">
                
              </div>

              <div class="col-md-10">
        <?php if(!empty($row['base_img'])){
                                  
                          $base_img=explode(',', $row['base_img']);
                          for ($i=0; $i <count($base_img)-1 ; $i++) { 
                             $other_txt='<div class="file_div" >
                                          <p>目前檔案</p>
                                           <button type="button" class="one_del_file"> X </button>
                                           <img id="one_img" src="../../../product_html/'.$_GET['Tb_index'].'/img/'.$base_img[$i].'" alt="">
                                           <input type="hidden" value="'.$base_img[$i].'">
                                         </div>';
                             echo $other_txt;
                          }
                        }
          ?>
                  </div>

            </div>


           


            <div class="form-group">
              <label class="col-sm-2 control-label" for="">圖文動畫效果</label>
              <div class="col-sm-3">
                <input type="checkbox" id="txt_fadein" name="txt_fadein[]" value="1"> <label for="txt_fadein">文字特效</label><br>
                特效:
                <select id="txt_fadein_type" name="txt_fadein_type[]" onchange="animate_select('txt_fadein_type')">
                                     <optgroup label="跳入系列">
                                     <option value="bounceIn">跳入</option>
                                     <option value="bounceInDown">跳入(下)</option>
                                     <option value="bounceInLeft">跳入(左)</option>
                                     <option value="bounceInRight">跳入(右)</option>
                                     <option value="bounceInUp">跳入(上)</option>
                                   </optgroup>
                                   <optgroup label="飛入系列">
                                     <option value="fadeIn">飛入</option>
                                     <option value="fadeInDown">飛入(下)</option>
                                     <option value="fadeInLeft">飛入(左)</option>
                                     <option value="fadeInRight">飛入(右)</option>
                                     <option value="fadeInUp">飛入(上)</option>
                                   </optgroup>
                                   <optgroup label="3D翻轉系列">
                                     <option value="flip">360翻轉(水平)</option>
                                     <option value="flipInX">180翻轉(垂直)</option>
                                     <option value="flipInY">180翻轉(水平)</option>
                                   </optgroup>
                                   <optgroup label="平面旋轉系列">
                                     <option value="rotateIn">360旋轉</option>
                                     <option value="rotateInDownLeft">90度右下旋轉</option>
                                     <option value="rotateInDownRight">90度左下旋轉</option>
                                     <option value="rotateInUpLeft">90度右上旋轉</option>
                                     <option value="rotateInUpRight">90度左上旋轉</option>
                                   </optgroup>
                                   <optgroup label="放大系列">
                                     <option value="zoomIn">放大</option>
                                     <option value="zoomInDown">放大(下)</option>
                                     <option value="zoomInLeft">放大(左)</option>
                                     <option value="zoomInRight">放大(右)</option>
                                     <option value="zoomInUp">放大(上)</option>
                                   </optgroup>
                                   </select>
              </div>
              <div class="col-sm-3">
                <input type="checkbox" id="img_fadein" name="img_fadein[]" value="1"> <label for="img_fadein">圖片特效</label><br>
                特效:
                <select id="img_fadein_type" name="img_fadein_type[]" onchange="animate_select('img_fadein_type')">
                                   <optgroup label="跳入系列">
                                     <option value="bounceIn">跳入</option>
                                     <option value="bounceInDown">跳入(下)</option>
                                     <option value="bounceInLeft">跳入(左)</option>
                                     <option value="bounceInRight">跳入(右)</option>
                                     <option value="bounceInUp">跳入(上)</option>
                                   </optgroup>
                                   <optgroup label="飛入系列">
                                     <option value="fadeIn">飛入</option>
                                     <option value="fadeInDown">飛入(下)</option>
                                     <option value="fadeInLeft">飛入(左)</option>
                                     <option value="fadeInRight">飛入(右)</option>
                                     <option value="fadeInUp">飛入(上)</option>
                                   </optgroup>
                                   <optgroup label="3D翻轉系列">
                                     <option value="flip">360翻轉(水平)</option>
                                     <option value="flipInX">180翻轉(垂直)</option>
                                     <option value="flipInY">180翻轉(水平)</option>
                                   </optgroup>
                                   <optgroup label="平面旋轉系列">
                                     <option value="rotateIn">360旋轉</option>
                                     <option value="rotateInDownLeft">90度右下旋轉</option>
                                     <option value="rotateInDownRight">90度左下旋轉</option>
                                     <option value="rotateInUpLeft">90度右上旋轉</option>
                                     <option value="rotateInUpRight">90度左上旋轉</option>
                                   </optgroup>
                                   <optgroup label="放大系列">
                                     <option value="zoomIn">放大</option>
                                     <option value="zoomInDown">放大(下)</option>
                                     <option value="zoomInLeft">放大(左)</option>
                                     <option value="zoomInRight">放大(右)</option>
                                     <option value="zoomInUp">放大(上)</option>
                                   </optgroup>
                </select>
              </div>
              <div class="col-sm-4">
                <h1 id="Animate_txt" >Animate</h1>
                <div><button type="button" id="re_animate_btn" class="btn btn-default" onclick="animate_btn()">重播一次</button></div>
                <input type="hidden" id="re_animate">
              </div>
            </div>

            


            <div class="form-group">
              <label class="col-sm-2 control-label" for="OnLineOrNot">是否上線</label>
              <div class="col-sm-10">
                <input style="width: 20px; height: 20px;" id="OnLineOrNot" name="OnLineOrNot" type="checkbox" value="1" <?php echo $check=!isset($row['OnLineOrNot']) || $row['OnLineOrNot']==1 ? 'checked' : ''; ?>  />
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

    //----------- 文字動畫判斷 -------------
    <?php 
      if(!empty($row['txt_fadein'])){
    ?>
      $('#txt_fadein').prop('checked', true);
      $('#txt_fadein_type').css('display', 'block');
      $('#txt_fadein_type [value="<?php echo $row['txt_fadein']?>"]').prop('selected', true);
    <?php
      }
    ?>


    //----------- 圖片動畫判斷 -------------
    <?php 
      if(!empty($row['img_fadein'])){
    ?>
      $('#img_fadein').prop('checked', true);
      $('#img_fadein_type').css('display', 'block');
      $('#img_fadein_type [value="<?php echo $row['img_fadein']?>"]').prop('selected', true);
    <?php
      }
    ?>


      $('#save_btn').click(function(event) {
         $('#fun_form').submit();
      });


    //------------------------------ 刪背景圖 ---------------------------------
    $("#one_del_img").click(function(event) { 
      if (confirm('是否要刪除檔案?')) {
       var data={
                      case_id:'<?php echo $_GET['Tb_index'];?>',
                      fun_id: '<?php echo $_GET['fun_id'];?>',
                       back_img: $(this).next().next().val(),
                            type: 'delete'
                };  
               ajax_in('iframe_base.php', data, '成功刪除', 'no');
               $(this).parent().html('');
      }
    });

      //------------------------------ 刪圖檔 ---------------------------------
    $(".one_del_file").click(function(event) { 
      if (confirm('是否要刪除檔案?')) {
       var data={
                      case_id:'<?php echo $_GET['Tb_index'];?>',
                      fun_id: '<?php echo $_GET['fun_id'];?>',
                       base_img: $(this).next().next().val(),
                            type: 'delete'
                };  
               ajax_in('iframe_base.php', data, '成功刪除', 'no');
               $(this).parent().html('');
      }
    });


    //------------------------------ 啟用動態文字或圖片 ----------------------------
    $('#txt_fadein').change(function(event) {
       if($(this).prop('checked')==true){
          $('#txt_fadein_type').css('display', 'block');
       }else{
          $('#txt_fadein_type').css('display', 'none');
       }
    });

    $('#img_fadein').change(function(event) {
       if($(this).prop('checked')==true){
          $('#img_fadein_type').css('display', 'block');
       }else{
          $('#img_fadein_type').css('display', 'none');
       }
    });
	});

   //-------------------------------- 動畫展示 --------------------------------
 function animate_select(id) {
    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    var animate=$('#'+id).val();
    $('#Animate_txt').addClass('animated '+animate).on(animationEnd, function() {
         $('#Animate_txt').removeClass('animated '+animate);
         $('#re_animate').val(animate);
    });
 }

  function animate_btn() {
    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    var animate=$('#re_animate').val();
    $('#Animate_txt').addClass('animated '+animate).on(animationEnd, function() {
         $('#Animate_txt').removeClass('animated '+animate);
    });
 }
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
