<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.md-skin .navbar-static-side, .border-bottom, body.fixed-sidebar .navbar-static-side, body.canvas-menu .navbar-static-side{display: none;}
	#page-wrapper{ margin:0px;  }

	.ibox-tools a{ color: #626262; }
  .color_bar{ padding: 15px 25px; display: inline-block; }
	
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 

if($_POST){

    // ======================== 刪除 ===========================
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    
        //----------------------- 多檔刪除 -------------------------------
        $sel_where=['Tb_index'=>$_POST['fun_id']];
        $otr_file=pdo_select('SELECT show_img FROM slideshow_tb WHERE Tb_index=:Tb_index', $sel_where);
        $otr_file=explode(',', $otr_file['show_img']);
        for ($i=0; $i <count($otr_file)-1 ; $i++) { //比對 
           if ($otr_file[$i]!=$_POST['show_img']) {
            $new_file.=$otr_file[$i].',';
           }else{
             unlink('../../../product_html/'.$_POST['case_id'].'/img/'.$_POST['show_img']);
           }
        }
        $param=['show_img'=>$new_file];
            $where=['Tb_index'=>$_POST['fun_id']];
            pdo_update('slideshow_tb', $param, $where);
      
       exit();
    }
  
  //----------------- 新增 ----------------------------------------------

  if(empty($_GET['fun_id'])){

    $Tb_index='ss'.date('YmdHis').rand(0,99);
   
    //-------------- 圖檔新增 ------------------
    if (!empty($_FILES['show_img'])){

          for ($i=0; $i <count($_FILES['show_img']['name']) ; $i++) { 

               $type=explode('.', $_FILES['show_img']['name'][$i]);
               $show_img.=$Tb_index.'_slider_'.$i.'.'.$type[count($type)-1].',';
               more_fire_upload('show_img', $i, $Tb_index.'_slider_'.$i.'.'.$type[count($type)-1], $_GET['Tb_index']);
             
          }
    }
    else{
      $show_img='';
    }

    $OnLineOrNot=empty($_POST['OnLineOrNot'])? 0 : 1;

    //---- 更新關聯資料表 -----
    pdo_update('Related_tb', ['fun_id'=>$Tb_index, 'OnLineOrNot'=>$OnLineOrNot], ['Tb_index'=>$_GET['rel_id']]);
    
    $param=[
       'Tb_index'=>$Tb_index,
       'case_id'=>$_GET['Tb_index'],
       'play_speed'=>$_POST['play_speed'],
       'show_img'=>$show_img,
       'StartDate'=>date('Y-m-d H:i:s'),
       'OnLineOrNot'=>$OnLineOrNot
    ];
    pdo_insert('slideshow_tb', $param);
    location_up('iframe_show.php?Tb_index='.$_GET['Tb_index'].'&fun_id='.$Tb_index, '功能已成功新增');
  }

  //----------------- 修改 ----------------------------------------------

  else{

    $Tb_index=$_GET['fun_id'];
    
    //-------------- 圖檔修改 ------------------

    if (!empty($_FILES['show_img'])) {
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

            if(!empty($_FILES['show_img']['name'][$i])){
               $type=explode('/', $_FILES['show_img']['type'][$i]);
               $show_img.=$Tb_index.'_slider_'.($file_num+$i).'.'.$type[1].',';
               more_fire_upload('show_img', $i, $Tb_index.'_slider_'.($file_num+$i).'.'.$type[1], $_GET['Tb_index']);

                unlink('../../../product_html/'.$_GET['Tb_index'].'/img/'.$_POST['old_file'][$i]);
            }
            else{
              $show_img.=$_POST['old_file'][$i].',';
            }
        }
         
        $show_img_param=['show_img'=>$show_img];
        $show_img_where=['Tb_index'=>$Tb_index];
        pdo_update('slideshow_tb', $show_img_param, $show_img_where);
      }
    //-------------- 圖檔修改-END ------------------


      $OnLineOrNot=empty($_POST['OnLineOrNot'])? 0:1;
      $param=[
       'play_speed'=>$_POST['play_speed'],
       'OnLineOrNot'=>$OnLineOrNot
    ];
    pdo_update('slideshow_tb', $param, ['Tb_index'=>$Tb_index]);

    //---- 更新關聯資料表 -----
    pdo_update('Related_tb', ['OnLineOrNot'=>$OnLineOrNot], ['fun_id'=>$Tb_index]);
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
                <span >單位：毫秒</span>
              </div>
              
            </div>
             <div class="form-group">
              <label class="col-sm-1 control-label" >圖片</label>
              <div class="col-sm-11">
               <button type="button" id="new_OtherFile" class="btn btn-info"><i class="fa fa-plus"></i> 新增檔案</button><br>
                <span class="text-danger">順序由左至右，由上到下</span>
              </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label" ></label>

              <div class="col-md-10">
                <ul class="sortable-list connectList agile-list ui-sortable OtherFile_div" >

                  <?php 
                       if(!empty($row['show_img'])){
                                  $show_img=explode(',', $row['show_img']);
                                   for ($i=0; $i <count($show_img)-1 ; $i++) { 
                                     $img_txt='<li class="oneFile_div">
                                                   <span class="mark_num">'.($i+1).'</span>
                                                   <div class="">
                                                     <input type="file" name="show_img[]" class="form-control" id="show_img" onchange="file_viewer_load_new(this, \'#other_div'.$i.'\')">
                                                     <button type="button" class="btn btn-danger one_del_div">x</button>
                                                   </div>
                                                   <div id="other_div'.$i.'" class="other_div"></div>
                                                   <div class="old_file" style="background: url(../../../product_html/'.$_GET['Tb_index'].'/img/'.$show_img[$i].') center; background-size: cover;"><p>目前圖檔</p> </div>
                                                   <input type="hidden" name="old_file[]" value="'.$show_img[$i].'">
                                                 </li>';
                                                 echo $img_txt;
                                              }
                                           }
                  ?>

                </ul>
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
        

      $('#save_btn').click(function(event) {
         $('#fun_form').submit();
      });

      //------------------------------ 刪圖檔 ---------------------------------
          $(".one_del_file").click(function(event) { 
      if (confirm('是否要刪除檔案?')) {
       var data={
                      case_id:'<?php echo $_GET['Tb_index'];?>',
                      fun_id: '<?php echo $_GET['fun_id'];?>',
                       show_img: $(this).next().next().val(),
                            type: 'delete'
                };  
               ajax_in('iframe_show.php', data, '成功刪除', 'no');
               $(this).parent().html('');
      }
    });



          //-- 多檔刪除 --
      $('.OtherFile_div').on('click', '.one_del_div', function(event) {
        event.preventDefault();

        if (confirm('是否要刪除檔案?')){
        
          if ($(this).parent().next().next().next().length>0) {
             $.ajax({
             url: 'iframe_show.php',
             type: 'POST',
             data: {
               fun_id: '<?php echo $_GET['fun_id'];?>',
               case_id: '<?php echo $_GET['Tb_index'];?>',
               show_img: $(this).parent().next().next().next().val(),
               type: 'delete'
             }

            });
          }
        $(this).parent().parent().remove();
      }
      });


       // 新增多檔
       var otherfile_num=$('[name="show_img[]"]').length;
       $('#new_OtherFile').click(function(event) {

         var otherfile_txt='<li class="oneFile_div">'
                           +'<span class="mark_num">'+(otherfile_num+1)+'</span>'
                           +'<div class="">'
                             + '<input type="file"  name="show_img[]" class="form-control" id="OtherFile" onchange="file_viewer_load_new(this, \'#other_div'+otherfile_num+'\')">'
                              +'<button type="button"  class="btn btn-danger one_del_div">x</button>'
                          +'</div>'
                             +'<div id="other_div'+otherfile_num+'" class="other_div">'
                             +'</div>'
                             +'<input type="hidden" name="old_file[]" value="">'
                          +'</li>';

         $('.OtherFile_div').append(otherfile_txt);
         otherfile_num++;
       });

      
      // 拖曳多圖檔
       $(".OtherFile_div").sortable({
         connectWith: ".OtherFile_div",
         update: function( event, ui ) {

              var OtherFile_arr = $( ".OtherFile_div" ).sortable( "toArray" );
         }
      }).disableSelection();


	});
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>