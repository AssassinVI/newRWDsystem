<?php include("../../core/page/header01.php");//載入頁面heaer01?>
<style type="text/css">
	#sel_com{ padding: 5px; margin-right: 5px; }
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

   $com_id=empty($_GET['com_id']) ? '':$_GET['com_id'];

   $sql=$pdo->prepare("SELECT Tb_index, aTitle, OrderBy, OnLineOrNot, version FROM build_case WHERE com_id LIKE :com_id ORDER BY OrderBy DESC, Tb_index DESC");
   $sql->execute( ['com_id'=>'%'.$com_id.'%'] );

   
}

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary"><?php echo $page_name['MT_Name']?> 列表</h2>
		<p>本頁面條列出所有的文章清單，如需檢看或進行管理，請由每篇文章右側 管理區進行，感恩</p>
	   <div class="new_div">

       
	  </div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
			 <div class="ibox-title">
			 	<h5><?php echo $page_name['MT_Name']?>列表 </h5>
			 	<div class="ibox-tools">
			 		        <select id="sel_com">
			 		        	<option value="all">全部</option>
			 		        	<?php
                                   $sql_com=$pdo->prepare("SELECT * FROM company ORDER BY Tb_index ASC");
                                   $sql_com->execute();
                                   while ($row_com=$sql_com->fetch(PDO::FETCH_ASSOC)) {
                                   	echo '<option value="'.$row_com['Tb_index'].'">'.$row_com['com_name'].'</option>';
                                   }
			 		        	?>

			 		        </select>
			 		        <button id="sort_btn" type="button" class="btn btn-default">
			 		        <i class="fa fa-sort-amount-desc"></i> 更新排序</button>

			 			    <a href="manager.php?MT_id=<?php echo $_GET['MT_id'];?>">
			 		        <button type="button" class="btn btn-success">
			 		        <i class="fa fa-plus" aria-hidden="true"></i> 新增</button>
			 		        </a>
			 	</div>
			 </div>
			<div class="ibox-content">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th>#</th>
								<th class="none_420">ID</th>
								<th>專案名稱</th>
								<th class="none_420">排序</th>
								<th class="none_420">啟用/停用</th>
								<th class="none_420">版本</th>
								<th class="text-right">管理</th>

							</tr>
						</thead>
						<tbody id="case_tb">

						<?php $i=1; while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {

                              $OnLineOrNot=$row['OnLineOrNot']=='1' ? '啟用' : '停用';

                              switch ($row['version']) {
                              	case '1':
                              	  $version='正常版';
                              		break;
                              	case '0':
                              	  $version='簡易版';
                              		break;
                                case '3':
                              	  $version='特殊版';
                              		break;
                              }
							?>
							<tr>
								<td><?php echo $i?></td>
								<td class="none_420"><?php echo $row['Tb_index'];?></td>
								<td style="font-size: 1.5em;"><?php echo $row['aTitle'];?></td>
								<td class="none_420"><input type="number" class="sort_in" name="OrderBy" Tb_index="<?php echo $row['Tb_index'];?>" value="<?php echo $row['OrderBy'] ?>"></td>
								<td class="none_420"><?php echo $OnLineOrNot;?></td>
								<td class="none_420"><?php echo $version;?></td>

								<td class="text-right">

								<a class="none_420 btn btn-info btn-sm" href="case_fun_box.php?Tb_index=<?php echo $row['Tb_index'];?>"><i class="fa fa-cubes"></i> 功能區塊</a>
                                
                                <a class="btn btn-default btn-sm iframe_box" href="catch_web.php?Tb_index=<?php echo $row['Tb_index'];?>"><i class="fa fa-globe"></i> 網址</a>
                                
                                <a class="btn btn-default btn-sm" href="#"><i class="fa fa-line-chart"></i> 分析</a>
                                
								<a class="none_420 btn btn-default btn-sm" href="manager.php?MT_id=<?php echo $_GET['MT_id']?>&Tb_index=<?php echo $row['Tb_index'];?>" ><i class="fa fa-pencil-square" aria-hidden="true"></i>編輯</a>
								
								<a class="none_420 btn btn-danger btn-sm" href="admin.php?MT_id=<?php echo $_GET['MT_id']?>&Tb_index=<?php echo $row['Tb_index'];?>" 
								   onclick="if (!confirm('確定要刪除 [<?php echo $row['aTitle']?>] ?')) {return false;}"><i class="fa fa-trash" aria-hidden="true"></i>刪除</a>

					
								</td>
							</tr>
						<?php $i++; }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>
<script type="text/javascript">
	$(document).ready(function() {

		 $(".iframe_box").fancybox({
		 	'padding'               :'0',
            'type'                  : 'iframe'
		 });
      
      //-------------- 排序 ---------------
		$("#sort_btn").click(function(event) {
		        
        var arr_OrderBy=new Array();
        var arr_Tb_index=new Array();

          $(".sort_in").each(function(index, el) {
             
             arr_OrderBy.push($(this).val());
             arr_Tb_index.push($(this).attr('Tb_index'));
          });

          var data={ 
                        OrderBy: arr_OrderBy,
                       Tb_index: arr_Tb_index 
                      };
             ajax_in('admin.php', data, 'no', 'no');

          alert('更新排序');
         location.replace('admin.php?MT_id=<?php echo $_GET['MT_id'];?>');
		});

     
     //----------------- 選公司 ------------------
		$('#sel_com').change(function(event) {
			$.ajax({
				url: 'admin_ajax.php',
				type: 'POST',
				dataType: 'json',
				data: {
					com_id: $(this).val(),
					type:'company'
			    },
				success:function (data) {
			     $('#case_tb').html('');
	 			   var x=1;
	 			   var txt='';
	 		   	  $.each(data, function() {

	 		   	  	var OnLineOrNot=this['OnLineOrNot']=='1' ? '啟用' : '停用';

	 		   	  	switch(this['version']){
	 		   	  		case '1':
	 		   	  		 var version='正常版';
	 		   	  		 break;
	 		   	  		case '0':
	 		   	  		 var version='簡易版';
	 		   	  		 break;
	 		   	  		case '3':
	 		   	  		 var version='特殊版';

	 		   	  	}
	 				    txt+='<tr>';
						txt+=' <td>'+x+'</td>';
						txt+=' <td>'+this['Tb_index']+'</td>';
						txt+=' <td style="font-size: 1.5em;">'+this['aTitle']+'</td>';
						txt+=' <td><input type="number" class="sort_in" name="OrderBy" Tb_index="'+this['Tb_index']+'" value="'+this['OrderBy']+'"></td>';
						txt+=' <td>'+OnLineOrNot+'</td>';
						txt+=' <td>'+version+'</td>';
						txt+=' <td class="text-right">';
						txt+='    <a class="btn btn-info btn-sm" href="case_fun_box.php?Tb_index='+this['Tb_index']+'"><i class="fa fa-cubes"></i> 功能區塊</a>｜';
						txt+='    <a class="btn btn-default btn-sm iframe_box" href="catch_web.php?Tb_index='+this['Tb_index']+'"><i class="fa fa-globe"></i> 網址</a>｜';
						txt+='    <a class="btn btn-default btn-sm" href="#"><i class="fa fa-line-chart"></i> 分析</a>｜';
						txt+='    <a class="btn btn-default btn-sm" href="manager.php?MT_id=site2017111611004594&Tb_index='+this['Tb_index']+'" ><i class="fa fa-pencil-square" aria-hidden="true"></i>編輯</a>｜';
						txt+='    <a class="btn btn-danger btn-sm" href="admin.php?MT_id=site2017111611004594&Tb_index='+this['Tb_index']+'" onclick="if (!confirm(\'確定要刪除 ['+this['aTitle']+'] ?\')) {return false;}"><i class="fa fa-trash" aria-hidden="true"></i>刪除</a>｜';
						txt+=' </td>';
						txt+='</tr>';
				       x++;
	 			   });

	 			$('#case_tb').append(txt);
				}
			});
			
		});
	});
</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
