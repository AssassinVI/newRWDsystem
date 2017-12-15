<?php  include("../../core/page/header01.php");//載入頁面heaer01?>
<meta name="google-signin-client_id" content="466826388971-alj2mf5lmgjq4bt0af2rog0pulp81nn1.apps.googleusercontent.com">
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/analytics.readonly">
<style type="text/css">
	.sortable-list{ padding: 0px;  }
</style>
<?php include("../../core/page/header02.php");//載入頁面heaer02?>
<?php 
// if ($_POST) {
//    // -- 更新排序 --
//   for ($i=0; $i <count($_POST['OrderBy']) ; $i++) { 
//     $data=["OrderBy"=>$_POST['OrderBy'][$i]];
//     $where=["Tb_index"=>$_POST['Tb_index'][$i]];
//     pdo_update('FunBox', $data, $where);
//   }
// }


   // if (!empty($_GET['Tb_index'])) {//刪除

   //  $where=['Tb_index'=>$_GET['Tb_index']];

   // 	 pdo_delete('FunBox', $where);
   // }
   
   $pdo=pdo_conn();
   $sql=$pdo->prepare("SELECT Tb_index, aTitle, google_view_code FROM build_case WHERE google_view_code!='' ORDER BY Tb_index ASC");
   $sql->execute();


?>

<!-- The Sign-in button. This will run `queryReports()` on success. -->
<p class="g-signin2"></p>

<!-- The API response will be printed here. -->
<textarea cols="80" rows="20" id="query-output"></textarea>



<div class="wrapper wrapper-content animated fadeInRight">
	<div class="col-lg-12">
		<h2 class="text-primary">Google分析更新</h2>
		<p>更新後即可看到最新分析資訊，請確認是否有填入"檢視編碼"，否則無法更新</p>
	   <div class="new_div">

        <!-- <button id="sort_btn" type="button" class="btn btn-default">
        <i class="fa fa-sort-amount-desc"></i> 更新排序</button> -->

	    <a href="manager.php">
        <button type="button" class="btn btn-default">
        <i class="fa fa-plus" aria-hidden="true"></i> 全部更新</button>
        </a>
	  </div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>專案ID</th>
								<th>專案名稱</th>
								<th>更新日期</th>
								<th class="text-right">管理</th>

							</tr>
						</thead>
						<tbody>

						<?php $i=1; while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
                             $row_update=pdo_select("SELECT set_time FROM google_analytics WHERE Tb_index=:Tb_index", ['Tb_index'=>$row['Tb_index']]);
							?>
							<tr>
								<td><?php echo $i?></td>
								<td><?php echo $row['Tb_index'] ?></td>
								<td><?php echo $row['aTitle'] ?></td>
								<td><?php echo $row_update['set_time']?></td>
								

								<td class="text-right">
							 	  <button type="button" onclick="google_an_all('<?php echo $row['google_view_code'];?>')" class="btn btn-info ">更新</button>
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

<!-- google 分析資料暫存 -->
<input type="hidden" name="week_user">

</div><!-- /#page-content -->
<?php  include("../../core/page/footer01.php");//載入頁面footer01.php?>

<!-- Load the JavaScript API client and Sign-in library. -->
<script src="https://apis.google.com/js/client:platform.js"></script>

<!-- 撈取分析資料 -->
<script type="text/javascript" src="google_an.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
		
	});



</script>
<?php  include("../../core/page/footer02.php");//載入頁面footer02.php?>
