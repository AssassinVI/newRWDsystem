<?php include("../../core/page/header01.php");//載入頁面heaer01?>
<style type="text/css">
	#sel_fun{ padding: 5px 15px; margin-right: 5px; font-size: 15px; }
	.ibox-tools a{ color: #fff; }
  .loading{ display: block; position: absolute; top: 0; bottom: 0; left: 0; right: 0; height: 31px; margin: auto; }
  .md-skin .ibox-content{ position: relative; }
  .sk-spinner-three-bounce div{ background-color: #838383; }
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
$pdo=pdo_conn();//資料庫初始化

if ($_POST) {
   // -- 更新排序 --
  for ($i=0; $i <count($_POST['OrderBy']) ; $i++) { 
    $data=["OrderBy"=>$_POST['OrderBy'][$i]];
    $where=["Tb_index"=>$_POST['Tb_index'][$i]];
    pdo_update('build_case', $data, $where);
  }
}

if ($_GET) {

   if (!empty($_GET['Tb_index'])) {//刪除
    
    $param=['OnLineOrNot'=>'0'];
    $where=['Tb_index'=>$_GET['Tb_index']];

   	 pdo_update('build_case', $param, $where);
   }

   $case_id=empty($_GET['Tb_index']) ? '':$_GET['Tb_index'];

   $sql=$pdo->prepare("SELECT * FROM Related_tb WHERE case_id = :com_id ORDER BY OrderBy DESC");
   $sql->execute( ['case_id'=>$_GET['Tb_index']] );

   //-- 專案名稱 --
   $row_name=pdo_select("SELECT aTitle FROM build_case WHERE Tb_index=:Tb_index", ['Tb_index'=>$_GET['Tb_index']]);
}

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary">功能區塊列表</h2>
		<p class="text-danger">選擇一個功能區塊，開始編輯</p>
	   <div class="new_div">

	  </div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="ibox float-e-margins">
			 <div class="ibox-title">
			 	<h5> <?php echo $row_name['aTitle'];?> </h5>
			 	<div class="ibox-tools">
			 		        <select id="sel_fun">
			 		        	<option value="">-- 請選擇 --</option>
			 		        	<?php
                                   $sql_fun=$pdo->prepare("SELECT * FROM FunBox ORDER BY Tb_index ASC");
                                   $sql_fun->execute();
                                   while ($row_fun=$sql_fun->fetch(PDO::FETCH_ASSOC)) {
                                   	echo '<option value="'.$row_fun['Tb_index'].'">'.$row_fun['box_name'].'</option>';
                                   }
			 		        	?>

			 		        </select>
                  <a id="insert_fun" href="#" class="btn btn-primary"><i class="fa fa-plus"></i> 新增</a>

			 		        <a href="iframe_color.php?Tb_index=<?php echo $_GET['Tb_index']?>" class="iframe_box btn btn-success">更改顏色</a>
			 		        <a href="iframe_css.php?Tb_index=<?php echo $_GET['Tb_index']?>" class="iframe_box btn btn-success">自訂CSS</a>
			 		       <!--  <button id="sort_btn" type="button" class="btn btn-default">
			 		        <i class="fa fa-sort-amount-desc"></i> 更新排序</button>

			 			    <a href="manager.php?MT_id=<?php //echo $_GET['MT_id'];?>">
			 		        <button type="button" class="btn btn-success">
			 		        <i class="fa fa-plus" aria-hidden="true"></i> 新增</button>
			 		        </a> -->
			 	</div>
			 </div>
			  <div class="ibox-content">
				      
              <!-- ================功能區塊欄======================= -->

				          <ul class="sortable-list connectList agile-list ui-sortable" id="FunBox_ul">

                                <!-- <li class="warning-element" id="task9">
                                    <i class="fa fa-film"></i> 圖片輪播
                                    
                                    <a href="#" class="pull-right btn btn-xs btn-danger">刪除</a>
                                    <a style="margin-right:5px;" href="#" class="pull-right btn btn-xs btn-primary">編輯</a>
                                    <a style="margin-right:5px;" href="#" class="pull-right btn btn-xs btn-white">檢視</a>
                                </li> -->
                                
                  </ul>

                  <!-- =================== Loading ====================== -->
                  <div class="loading">
                  <div class="sk-spinner sk-spinner-three-bounce">
                      <div class="sk-bounce1"></div>
                      <div class="sk-bounce2"></div>
                      <div class="sk-bounce3"></div>
                  </div>
                  </div>
        </div>
		</div>
	</div>
</div>
</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>
<script type="text/javascript">
	$(document).ready(function() {
   
   //-- 撈取功能區塊 --
   funbox_all();
    

    //-- 新增功能區塊 --
    $("#insert_fun").click(function(event) {

      if($('#sel_fun').val()==''){
        alert('請選擇一個功能區塊');
      }
      else{
        
          $.ajax({
            url: 'case_fun_box_ajax.php',
            type: 'POST',
            data: {
              type:'insert',
              funbox_id: $('#sel_fun').val(),
              case_id: '<?php echo $_GET['Tb_index']?>'
              
            },
            success:function (data) {
              //-- 功能區塊 --
              var funbox=sel_FunBox($('#sel_fun').val());
              var txt='<li class="'+funbox['btn_type']+'" id="'+data+'">'
                           + '<i class="fa '+funbox['btn_icon']+'"></i> '+funbox['box_name']
                                                  
                           + '<a href="#" class="pull-right btn btn-xs btn-danger del_funbox">刪除</a>'
                           + '<a style="margin-right:5px;" href="'+funbox['aUrl']+'?Tb_index=" class="pull-right btn btn-xs btn-primary">編輯</a>'
                           + '<a style="margin-right:5px;" href="#" class="pull-right btn btn-xs btn-white">檢視</a>'
                       + '</li>';
              $('.sortable-list').append(txt);
            }
          });
      }

    	

    });


     //-- 功能區快-拖曳功能 --  
     $("#FunBox_ul").sortable({
         connectWith: ".connectList",
         update: function( event, ui ) {

              var FunBox_ul = $( "#FunBox_ul" ).sortable( "toArray" );
              //更新功能區塊排序
              $.ajax({
                url: 'case_fun_box_ajax.php',
                type: 'POST',
                data: {
                  type: 'update',
                  related_id_array: FunBox_ul
                }
                
              });
              
         }
     }).disableSelection();



  //------- 刪除功能區塊 ---------
  $('.sortable-list').on('click', '.del_funbox', function(event) {
     event.preventDefault();
     
     if (confirm("是否刪除 [ "+$(this).attr('title')+" ] ??")) {
       $.ajax({
         url: 'case_fun_box_ajax.php',
         type: 'POST',
         data: {
          type: 'delete',
          related_id: $(this).parent().attr('id')
        },
        success:function (data) {

          //-- 撈取功能區塊 --
          funbox_all();
        }
       });

     }
     else{
      
     }
    
  });

    
    $(".iframe_box").fancybox({
       'padding'               :'0',
       'type'                  : 'iframe',
       afterClose: function () {
         funbox_all();
         return;
       }
    });
     
	});
  
  //-- 查詢功能區塊外型 --
  function sel_FunBox(funbox_id) {
     var array=[];
     $.ajax({
       url: 'case_fun_box_ajax.php',
       async: false,
       type: 'POST',
       dataType: 'json',
       data: { 
          type: 'sel_funbox', 
          funbox_id: funbox_id
        },
       success:function (data) {
         array= data;
       }
     });
    return array;
  }


  //------ 撈取功能區塊 --------
  function funbox_all() {
    $.ajax({
         url: 'case_fun_box_ajax.php',
         type: 'POST',
         dataType: 'json',
         data: {
           type: 'select',
           case_id: '<?php echo $_GET['Tb_index']?>',
         },
         success:function (data) {
           $('.sortable-list').html('');
           $.each(data, function() {
              //-- 功能區塊 --
              var funbox=sel_FunBox(this['funbox_id']);

              var txt='<li class="'+funbox['btn_type']+'" id="'+this['Tb_index']+'">'
                          + '<i class="fa '+funbox['btn_icon']+'"></i> '+funbox['box_name']
                                                 
                          + '<a href="#" title="'+funbox['box_name']+'" class="pull-right btn btn-xs btn-danger del_funbox">刪除</a>'
                          + '<a style="margin-right:5px;" href="'+funbox['aUrl']+'?Tb_index='+this['case_id']+'&fun_id='+this['fun_id']+'" class="pull-right btn btn-xs btn-primary iframe_box">編輯</a>'
                          + '<a style="margin-right:5px;" href="#" class="pull-right btn btn-xs btn-white">檢視</a>'
                      + '</li>';
             $('.sortable-list').append(txt);

           });
         },
         beforeSend:function () {
            $('.loading').css('display', 'block');
          },
          complete:function () {
            $('.loading').css('display', 'none');
          }
       });
  }


 
 

</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
