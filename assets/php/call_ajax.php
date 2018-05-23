<?php require '../../sys/core/inc/config.php';?>
<?php require '../../sys/core/inc/function.php';?>
<?php
  
  if ($_POST) {


  	$send_list=explode('||', $_POST['send_list']);
  	$name_data=[]; $adds_data=[];
  	for ($i=0; $i <count($send_list) ; $i++) { 
  		$send_one=explode(',', $send_list[$i]);
        array_push($name_data, $send_one[0]);
        array_push($adds_data, $send_one[1]);
  	}
    
    $body_data='
    <table border="1" cellpadding="5" cellspacing="0">
		<tbody>
			<tr>
				<td>姓名</td>
				<td>'.$_POST['name'].'</td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td>'.$_POST['mail'].'</td>
			</tr>
			<tr>
				<td>聯絡電話</td>
				<td>'.$_POST['phone'].'</td>
			</tr>
			<tr>
				<td>問題類別</td>
				<td>'.$_POST['question'].'</td>
			</tr>
			<tr>
				<td>主旨</td>
				<td>'.$_POST['subject'].'</td>
			</tr>
			<tr>
				<td>內容</td>
				<td>'.nl2br($_POST['msg']).'</td>
			</tr>
		</tbody>
	</table>';

  	send_Mail($_POST['case_name'].'系統', 'server@srl.tw', $_POST['case_name'].'-網站回信', $body_data, $name_data, $adds_data);
    
    $subject=empty($_POST['subject']) ? '':$_POST['subject'];
    $param=[
     'Tb_index'=>'car'.date('YmdHis').rand(0,99),
     'case_id'=>$_POST['case_id'],
     'set_time'=>date('Y-m-d H:i:s'),
     'use_name'=>$_POST['name'],
     'use_mail'=>$_POST['mail'],
     'phone'=>$_POST['phone'],
     'q_type'=>$_POST['question'],
     'call_title'=>$subject,
     'call_content'=>$_POST['msg']
    ];
  	pdo_insert('call_record_tb', $param);

  }
  else{
  	echo "Error...";
  }
?>