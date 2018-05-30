<?php include("../../core/page/header01.php");//載入頁面heaer01 ?>
<style type="text/css">
	.fb_fans{ display: none; }
	#ph_tool_type_exp img{ width: 100%; height: 750px; }

</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
if ($_POST) {
  // ======================== 刪除 ===========================
  	//----------------------- 代表圖刪除 -------------------------------
    if (!empty($_POST['type']) && $_POST['type']=='delete') { 
    	if ($_POST['col']=='aPic') {
    		$param=['aPic'=>''];
            $where=['Tb_index'=>$_POST['Tb_index']];
            pdo_update('build_case', $param, $where);
            unlink($_POST['data']);

    	}elseif($_POST['col']=='activity_song'){
            $param=['activity_song'=>''];
            $where=['Tb_index'=>$_POST['Tb_index']];
            pdo_update('build_case', $param, $where);
            unlink($_POST['data']);

    	}elseif($_POST['col']=='activity_img'){
            $param=['activity_img'=>''];
            $where=['Tb_index'=>$_POST['Tb_index']];
            pdo_update('build_case', $param, $where);
            unlink($_POST['data']);
    	}
       exit();
  	}

  	//-------------------------- 新增 -------------------------------
  	//-------------------------- 新增 -------------------------------
  	//-------------------------- 新增 -------------------------------

	if (empty($_POST['Tb_index'])) {//新增
		$Tb_index='case'.date('YmdHis').rand(0,99);


	 //--------------------------------------- 建立專案檔案 ----------------------------------
       create_dir('../../../product_html/'.$Tb_index);
       if ($_POST['version']=='1') { //-- 正常版 --
    		copy('../../../product/product_empty.php', '../../../product_html/' . $Tb_index . '/Default.php');
        }
    	elseif($_POST['version']=='0'){//-- 簡易版 --
    		copy('../../../product/product_easy.php', '../../../product_html/' . $Tb_index . '/Default.php');
    	}

     
     //===================== 專案LOGO ========================
      if (!empty($_FILES['aPic']['name'])){

      	 $type=explode('/', $_FILES['aPic']['type']);
      	 $aPic=$Tb_index.date('His').'.'.$type[1];
         fire_upload('aPic', $aPic, $Tb_index);
      }else{
      	$aPic='';
      }

     //===================== 活動圖片 ========================
      if (!empty($_FILES['activity_img']['name'])){

      	 $type=explode('/', $_FILES['activity_img']['type']);
      	 $activity_img=$Tb_index.date('His').'-ac.'.$type[1];
         fire_upload('activity_img', $activity_img, $Tb_index);
      }else{
      	 $activity_img='';
      }

      //===================== 背景音樂 ========================
      if (!empty($_FILES['activity_song']['name'])){

      	 $type=explode('/', $_FILES['activity_song']['type']);
      	 $activity_song=$Tb_index.date('His').'.'.$type[1];
         audio_upload('activity_song', $activity_song, $Tb_index);
      }else{
      	$activity_song='';
      }
     

	$param=  [          'Tb_index'=>$Tb_index,
			              'com_id'=>$_POST['com_id'],
			              'aTitle'=>$_POST['aTitle'],
			        'ph_tool_type'=>$_POST['ph_tool_type'],
			             'version'=>$_POST['version'],
			              'format'=>$_POST['format'],
			            'line_txt'=>$_POST['line_txt'],
			              'fb_txt'=>$_POST['fb_txt'],
			               'phone'=>$_POST['phone'],
			          'build_adds'=>$_POST['build_adds'],
			             'marquee'=>$_POST['marquee'],
			         'google_code'=>$_POST['google_code'],
			    'google_view_code'=>$_POST['google_view_code'],
			         'description'=>$_POST['description'],
			             'KeyWord'=>$_POST['KeyWord'],
			           'StartDate'=>date('Y-m-d'),
			         'OnLineOrNot'=>$_POST['OnLineOrNot'],
			                'aPic'=>$aPic,
			        'activity_img'=>$activity_img,
			       'activity_song'=>$activity_song,
			           'ad_making'=>$_POST['ad_making']
			         ];
	pdo_insert('build_case', $param);

	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功新增');
   }

    //-------------------------- 修改 -------------------------------
  	//-------------------------- 修改 -------------------------------
  	//-------------------------- 修改 -------------------------------
   else{  //修改
   	$Tb_index =$_POST['Tb_index'];

   	 //===================== 專案LOGO ========================
      if (!empty($_FILES['aPic']['name'])) {

      	unlink('../../../product_html/'.$Tb_index.'/img/'.$_POST['aPic_file']);

      	 $type=explode('/', $_FILES['aPic']['type']);
      	 $aPic=$Tb_index.date('His').'.'.$type[1];
         fire_upload('aPic', $aPic, $Tb_index);
        $aPic_param=['aPic'=>$aPic];
        $aPic_where=['Tb_index'=>$Tb_index];
        pdo_update('build_case', $aPic_param, $aPic_where);
        
      }

     //===================== 背景音樂 ========================
      if (!empty($_FILES['activity_song']['name'])) {

      	unlink('../../../product_html/'.$Tb_index.'audio/'.$_POST['activity_song_file']);

      	 $type=explode('/', $_FILES['activity_song']['type']);
      	 $activity_song=$Tb_index.date('His').'.'.$type[1];
         fire_upload('activity_song', $activity_song, $Tb_index);
        $activity_song_param=['activity_song'=>$activity_song];
        $activity_song_where=['Tb_index'=>$Tb_index];
        pdo_update('build_case', $activity_song_param, $activity_song_where);
        
      }

     //===================== 活動圖 ========================
      if (!empty($_FILES['activity_img']['name'])) {

      	unlink('../../../product_html/'.$Tb_index.'/img/'.$_POST['activity_img_file']);

      	 $type=explode('/', $_FILES['activity_img']['type']);
      	 $activity_img=$Tb_index.date('His').'-ac.'.$type[1];
         fire_upload('activity_img', $activity_img, $Tb_index);
        $activity_img_param=['activity_img'=>$activity_img];
        $activity_img_where=['Tb_index'=>$Tb_index];
        pdo_update('build_case', $activity_img_param, $activity_img_where);
        
      }
     
      	//--------------------------- END -----------------------------------

        if ($_POST['version']=='1') { //-- 正常版 --
     		copy('../../../product/product_empty.php', '../../../product_html/' . $Tb_index . '/Default.php');
         }
     	elseif($_POST['version']=='0'){//-- 簡易版 --
     		copy('../../../product/product_easy.php', '../../../product_html/' . $Tb_index . '/Default.php');
     	}
    
    
    $param=[  
			              'com_id'=>$_POST['com_id'],
			              'aTitle'=>$_POST['aTitle'],
			        'ph_tool_type'=>$_POST['ph_tool_type'],
			             'version'=>$_POST['version'],
			              'format'=>$_POST['format'],
			            'line_txt'=>$_POST['line_txt'],
			              'fb_txt'=>$_POST['fb_txt'],
			               'phone'=>$_POST['phone'],
			          'build_adds'=>$_POST['build_adds'],
			             'marquee'=>$_POST['marquee'],
			         'google_code'=>$_POST['google_code'],
			    'google_view_code'=>$_POST['google_view_code'],
			         'description'=>$_POST['description'],
			             'KeyWord'=>$_POST['KeyWord'],
			         'OnLineOrNot'=>$_POST['OnLineOrNot'],
			           'ad_making'=>$_POST['ad_making']
		          ];
    $where= ['Tb_index'=>$Tb_index] ;
	pdo_update('build_case', $param, $where);
	
	location_up('admin.php?MT_id='.$_POST['mt_id'],'成功更新');
   }
}
if ($_GET) {
 	$where=['Tb_index'=>$_GET['Tb_index']];
 	$row=pdo_select('SELECT * FROM build_case WHERE Tb_index=:Tb_index', $where);
 	$com_id=empty($row['com_id'])? '' : $row['com_id'];
}
?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<header>專案資料編輯
					</header>
				</div><!-- /.panel-heading -->
				<div class="panel-body">
					<form id="put_form" action="manager.php" method="POST" enctype='multipart/form-data' class="form-horizontal">
						<div class="form-group">
							<label class="col-md-2 control-label" >所屬公司</label>
							<div class="col-md-4">
								<select name="com_id" class="form-control">

								  <?php 
                                    $pdo=pdo_conn();
                                    $sql=$pdo->prepare("SELECT Tb_index, com_name FROM company ORDER BY OrderBy DESC, Tb_index ASC");
                                    $sql->execute();
                                    while ($row_com=$sql->fetch(PDO::FETCH_ASSOC)) {

                                        if ($com_id==$row_com['Tb_index']) {

                                        	echo '<option selected value="'.$row_com['Tb_index'].'">'.$row_com['com_name'].'</option>';
                                        }
                                        else{
                                        	echo '<option value="'.$row_com['Tb_index'].'">'.$row_com['com_name'].'</option>';
                                        }
                                    	
                                    }
                                  ?>
									
								</select>
							</div>
							<label class="col-md-2 control-label">版本</label>
							<div class="col-md-4">
								<select name="version" class="form-control">
									<option <?php echo $selected=$row['version']=='1' ? 'selected' : '';?> value="1">正常版</option>
									<option <?php echo $selected=$row['version']=='0' ? 'selected' : '';?> value="0">簡易版</option>
									<?php 
                                     if(!empty($row['Tb_index'])){
                                     	$selected=$row['version']=='3' ? 'selected' : '';
                                     	echo '<option '.$selected.' value="3">特殊版</option>';
                                     }
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="aTitle">專案名稱</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="aTitle" name="aTitle" value="<?php echo $row['aTitle'];?>">
							</div>
							<label class="col-md-2 control-label" for="ad_making">廣告製作</label>
							<div class="col-md-4">
								<select name="ad_making" class="form-control">
									<option <?php echo $selected=$row['ad_making']=='j' ? 'selected' : '';?> value="j">聯創數位</option>
									<option <?php echo $selected=$row['ad_making']=='c' ? 'selected' : '';?> value="c">元際數位</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="ph_tool_type">手機功能欄樣式</label>
							<div class="col-md-4">
								<select name="ph_tool_type" id="ph_tool_type" class="form-control">
									<option value="hor1">橫式造型1</option>
									<option value="hor2">橫式造型2</option>
									<option value="hor3">橫式造型3</option>
									<option value="hor4">橫式造型4</option>
									<option value="ver1">直式造型1</option>
									<option value="ver2">直式造型2</option>
									<option value="ver3">直式造型3</option>
									<option value="ver4">直式造型4</option>
									<option value="ver5">直式造型5</option>
									<option value="ver6">直式造型6</option>
								</select>
							</div>
							<label class="col-md-2 control-label" for="ad_making">造型參考</label>
							<div class="col-md-4">
								 <a href="#ph_tool_type_exp" class="btn btn-info fancybox">參考圖示</a>

								 <div style="display: none; " id="ph_tool_type_exp" class="row no-gutters">
								 	<div class="col-md-3">
								 		<h3>橫式造型1</h3>
								 		<img src="../../img/phToolType/hor1.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>橫式造型2</h3>
								 		<img src="../../img/phToolType/hor2.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>橫式造型3</h3>
								 		<img src="../../img/phToolType/hor3.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>橫式造型4</h3>
								 		<img src="../../img/phToolType/hor4.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型1</h3>
								 		<img src="../../img/phToolType/ver1.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型2</h3>
								 		<img src="../../img/phToolType/ver2.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型3</h3>
								 		<img src="../../img/phToolType/ver3.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型4</h3>
								 		<img src="../../img/phToolType/ver4.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型5</h3>
								 		<img src="../../img/phToolType/ver5.JPG" alt="">
								 	</div>
								 	<div class="col-md-3">
								 		<h3>直式造型6</h3>
								 		<img src="../../img/phToolType/ver6.JPG" alt="">
								 	</div>
								 </div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="aPic">專案LOGO</label>
							<div class="col-md-10">
								<input type="file" name="aPic" class="form-control" accept="image/*" id="aPic" onchange="file_viewer_load_new(this, '#img_box')">
							</div>
						</div>

						<div class="form-group">
						   <label class="col-md-2 control-label" ></label>
						   <div id="img_box" class="col-md-4">
								
							</div>
						<?php if(!empty($row['aPic'])){?>
							<div  class="col-md-4">
							   <div id="aPic" class="img_div" >
							    <p>目前圖檔</p>
								 <button type="button" class="one_del"> X </button>
								  <img id="one_img" src="../../../product_html/<?php echo $row['Tb_index'];?>/img/<?php echo $row['aPic'];?>" alt="請上傳代表圖檔">
								</div>
								<input type="hidden" name="aPic_file" value="<?php echo $row['aPic'];?>">
							</div>
						<?php }?>		
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="format">格局說明</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="format" name="format" value="<?php echo $row['format'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label text-info" >LINE 功能分享或加群組</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="line_txt" name="line_txt" value="<?php echo $row['line_txt'];?>">
								<span class="text-danger">請依需求填寫，系統會自動判斷是分享或加群組。 #勿同時輸入兩種</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label text-success" >Facebook 功能選擇</label>
							<div class="col-md-4">
								<select id="fb_sel" class="form-control">
									<option value="share">分享臉書</option>
									<option value="fans">臉書紛絲團</option>
								</select>
							</div>
							<label  class="col-md-2 control-label fb_fans" >臉書紛絲團</label>
							<div class="col-md-4 fb_fans">
								<input type="text" class="form-control" id="fb_txt" name="fb_txt" value="<?php echo $row['fb_txt'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="phone">電話</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone'];?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="build_adds">基地位置</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="build_adds" name="build_adds" value="<?php echo $row['build_adds'];?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="marquee">跑馬燈</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="marquee" name="marquee" value="<?php echo $row['marquee'];?>">
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="activity_song">背景音樂</label>
							<div class="col-md-10">
								<input type="file" name="activity_song" class="form-control" accept="audio/*" id="activity_song" onchange="audio_load(this, '#audio_box')">
							</div>
						</div>

						<div class="form-group">
						   <label class="col-md-2 control-label" ></label>
						   <div id="audio_box" class="col-md-4">
								
							</div>
						<?php if(!empty($row['activity_song'])){?>
							<div  class="col-md-4">
							   <div id="activity_song" class="img_div">
							    <p>目前音樂</p>
								 <button type="button" id="one_del_audio" class="one_del"> X </button>
								  <audio controls src="../../../product_html/<?php echo $row['Tb_index'];?>/audio/<?php echo $row['activity_song'];?>">音樂</audio>
								</div>
								 <input type="hidden" name="activity_song_file" value="<?php echo $row['activity_song'];?>">
							</div>
						<?php }?>		
						</div>



						<div class="form-group">
							<label class="col-md-2 control-label" for="activity_img">活動圖片</label>
							<div class="col-md-10">
								<input type="file" name="activity_img" class="form-control" accept="image/*" id="activity_img" onchange="file_viewer_load_new(this, '#img_box2')">
							</div>
						</div>

						<div class="form-group">
						   <label class="col-md-2 control-label" ></label>
						   <div id="img_box2" class="col-md-4">
								
							</div>
						<?php if(!empty($row['activity_img'])){?>
							<div  class="col-md-4">
							   <div id="activity_img" class="img_div">
							    <p>目前圖檔</p>
								 <button type="button" id="one_del_img" class="one_del"> X </button>
								  <img id="one_img" src="../../../product_html/<?php echo $row['Tb_index'];?>/img/<?php echo $row['activity_img'];?>" alt="請上傳代表圖檔">
								</div>
								<input type="hidden" name="activity_img_file" value="<?php echo $row['activity_img'];?>">
							</div>
						<?php }?>		
						</div>
 
                        <div class="form-group">
							<label class="col-md-2 control-label text-warning" for="google_code">Google分析追蹤碼</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="google_code" name="google_code" value="<?php echo $row['google_code'];?>">
								<span>例如:UA-12345678-1</span>
							</div>
							<label class="col-md-2 control-label text-warning" for="google_view_code">Google分析檢視碼</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="google_view_code" name="google_view_code" value="<?php echo $row['google_view_code'];?>">
								<span>例如:123456789，9碼</span>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-2 control-label" for="description">網站描述</label>
							<div class="col-md-10">
								<textarea style="height: 250px;" class="form-control" id="description" name="description" placeholder="網站描述"><?php echo $row['description'];?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" for="KeyWord">關鍵字</label>
							<div class="col-md-10">
								<textarea class="form-control" id="KeyWord" name="KeyWord" placeholder="關鍵字"><?php echo $row['KeyWord'];?></textarea>
								<span>請使用逗點隔開，例如:XXX建案,A,B,XX坪,XX建設</span>
							</div>
						</div>


						<div class="form-group">
							<label class="col-md-2 control-label" for="OnLineOrNot">是否上線</label>
							<div class="col-md-10">
								<input style="width: 20px; height: 20px;" id="OnLineOrNot" name="OnLineOrNot" type="checkbox" value="1" <?php echo $check=!isset($row['OnLineOrNot']) || $row['OnLineOrNot']==1 ? 'checked' : ''; ?>  />
							</div>
						</div>

						<input type="hidden" id="Tb_index" name="Tb_index" value="<?php echo $_GET['Tb_index'];?>">
						<input type="hidden" id="mt_id" name="mt_id" value="<?php echo $_GET['MT_id'];?>">
					</form>
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->




		</div>

		<div class="col-lg-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<header>儲存您的資料</header>
				</div><!-- /.panel-heading -->
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<button type="button" class="btn btn-danger btn-block btn-flat" data-toggle="modal" data-target="#settingsModal1" onclick="clean_all()">重設表單</button>
						</div>
						<div class="col-lg-6">
						<?php if(empty($_GET['Tb_index'])){?>
							<button type="button" id="submit_btn" class="btn btn-info btn-block btn-raised">儲存</button>
						<?php }else{?>
						    <button type="button" id="submit_btn" class="btn btn-info btn-block btn-raised">更新</button>
						<?php }?>
						</div>
					</div>
					
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div>
	</div>

</div><!-- /#page-content -->

<?php  include("../../core/page/footer01.php");//載入頁面footer02.php?>
<script type="text/javascript">
	$(document).ready(function() {

    <?php 
     if (!empty($row['ph_tool_type'])) {
       echo "$('#ph_tool_type [value=\"".$row['ph_tool_type']."\"]').prop('selected', true);";
     }
    ?>



          $("#submit_btn").click(function(event) {

          	 if ($('[name="aPic"]').val()!='' && $('[name="aPic"]').val().search(/(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i)==-1) {
          	 	alert('您的專案LOGO圖檔格式錯誤!!');
          	 	return;
          	 }

            if($('[name="activity_song"]').val()!='' && $('[name="activity_song"]').val().search(/(\.mp3)$/i)==-1){
               	alert('您的背景音樂檔格式錯誤!!');
               	return;
            }

             if($('[name="activity_img"]').val()!='' && $('[name="activity_img"]').val().search(/(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i)==-1){
                alert('您的活動圖檔格式錯誤!!');
                return;
            }

             $('#put_form').submit();
          	 
          });
    //------------------------------ 刪除 ---------------------------------
          $(".one_del").click(function(event) { 
			if (confirm('是否要刪除檔案?')) {
			 var data={
			 	        Tb_index: $("#Tb_index").val(),
                            data: $(this).next().attr('src'),
                            col:  $(this).parent().attr('id'),
                            type: 'delete'
			          };	
               ajax_in('manager.php', data, '成功刪除', 'no');
               $(this).parent().html('');
			}
		});
   

    //--------------------------- FB功能選擇 -------------------------
       $('#fb_sel').change(function(event) {
       	 if ($(this).val()=='fans') {
       	 	$('.fb_fans').css('display', 'block');
       	 }else{
       	 	$('.fb_fans').css('display', 'none');
       	 }
       });
      });
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>

