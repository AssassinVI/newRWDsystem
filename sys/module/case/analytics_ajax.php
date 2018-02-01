<?php 
 require '../../core/inc/config.php';
 require '../../core/inc/function.php';

 if ($_POST) {
 	
 	//-- 姓別 --
 	if ($_POST['type']=='sex') {
 		
 	  $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT sex FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['sex'];
 	}

    // -- 年齡 --
 	elseif($_POST['type']=='old'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT years FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['years'];
 	}

 	// -- 使用的媒體 --
 	elseif($_POST['type']=='media'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT media FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['media'];
 	}

 	// -- 使用的功能鈕 --
 	elseif($_POST['type']=='tool_btn'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT event FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['event'];
 	}

 	// -- 來源流量 --
 	elseif($_POST['type']=='src_num'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT src FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['src'];
 	}

 	// -- 地區使用人數 --
 	elseif($_POST['type']=='city'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT city FROM google_analytics WHERE Tb_index=:Tb_index', $where);
      
      $city=explode('|', $row['city']);
      $city_name=explode(',', $city[0]);
      $city_num=explode(',', $city[1]);

      $total_num=count($city_name);

 	  for ($i=0; $i <$total_num ; $i++) {

 	    $tw_name=explode(' ', $city_name[$i]); 
 	  	
 	  	$taiwan_name=pdo_select("SELECT tw_name FROM taiwan_area WHERE en_name=:en_name LIMIT 0,1", ['en_name'=>$tw_name[0]]);
 	  	if (!empty($taiwan_name['tw_name']) && $city_num[$i]>5) {
 	  		$city_name[$i]=$taiwan_name['tw_name'];
 	  	}
 	  	else{
 	  		unset($city_name[$i]);
 	  		unset($city_num[$i]);
 	  	}
 	  }

 	  $city=implode(',', $city_name).'|'.implode(',', $city_num);
 	  
 	  echo $city;
 	}

 	// -- 齡層平均停留網站時間 --
 	elseif($_POST['type']=='timeOnSite'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT timeOnSite_years FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  $timeOnSite_years=explode('|', $row['timeOnSite_years']);
 	  $timeOnSite_years_name=explode(',', $timeOnSite_years[0]);
 	  $timeOnSite_years_num=explode(',', $timeOnSite_years[1]);

 	  for ($i=0; $i <count($timeOnSite_years_name) ; $i++) { 
 	  	
 	  	$timeOnSite_years_name[$i]=$timeOnSite_years_name[$i].'歲';
 	  	$timeOnSite_years_num[$i]=round((int)$timeOnSite_years_num[$i]/60, 2);
 	  }

 	  $timeOnSite_years=implode(',', $timeOnSite_years_name).'|'.implode(',', $timeOnSite_years_num);
 	  echo $timeOnSite_years;
 	}

 	// -- 每日使用人數 --
 	elseif($_POST['type']=='data_use'){
      
      $where=['Tb_index'=>$_POST['Tb_index']];
 	  $row=pdo_select('SELECT user_date FROM google_analytics WHERE Tb_index=:Tb_index', $where);	
 	  echo $row['user_date'];
 	}
 }
?>