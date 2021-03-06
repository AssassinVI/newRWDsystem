<?php
include "../../core/inc/config.php"; //載入基本設定
include "../../core/inc/function.php"; //載入基本function
include "../../core/inc/security.php"; //載入安全設定
?>
<?php
$company = pdo_select("SELECT * FROM company_base WHERE webLang='tw'", 'no');

$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
$URL = $protocol.'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//-- 阻擋無權限進入 --
if ($_SESSION['admin_per']!='admin') {
   if (strpos($URL, 'Dashboard')===false && strpos($URL, 'catch_web')===false && !in_array($_GET['MT_id'], $_SESSION['group'])) {
       location_up('back', '抱歉，您無使用權限!!');
   }
}
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $company['name'] ?> | ADMIN</title>
     <link rel="shortcut icon" href="/favicon.ico" />

    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../css/animate.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
     <link href="../../css/msism.css" rel="stylesheet">
     <!-- C3 Chart -->
     <link rel="stylesheet" type="text/css" href="../../css/plugins/c3/c3.min.css">

     <!-- DataTables -->
     <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.css">

     <!-- FancyBox -->
     <link rel="stylesheet" type="text/css" href="../../js/plugins/fancyBox/jquery.fancybox.css">

     <!-- 漂亮拉bar -->
     <link rel="stylesheet" type="text/css" href="../../js/plugins/mCustomScrollbar/jquery.mCustomScrollbar.css">

     <style type="text/css">
        body, div, h1, h2, h3, h4, h5, p, a, li, span{ font-family: Microsoft JhengHei; }
     	.close_btn{ position: absolute; bottom: 0px; right: 15px; border: 0px; }
        .new_div{ position: absolute; right: 15px; bottom: 0px; }
        .twzipcode{ display: inline-block; }
        .twzipcode input, .twzipcode select ,.adds{ font-size: 14px; padding: 5px; border: 1px solid #d6d6d6; }
        .adds{ width: 300px; }
            #one_img{ height: 130px; border:1px solid #d6d6d6; padding: 3px;}
            #one_del_img, .one_del_img, #one_del_file,.one_del_file,#one_del_video, .one_del{ position: absolute; border: 0px; background-color: #ff243b; color: #fff; box-shadow: 1px 1px 2px rgba(0,0,0,0.5); z-index: 1;}
        .img_check{ position: absolute; top: 40px; left: 75px; background: rgba(26,179,148,1); padding: 7px 10px; border-radius: 50px; font-size: 15px; color: #ffffff; display:none; }
        .sort_in{ padding: 3px 5px; width: 40px; border-radius: 3px; border: 1px solid #b6b6b6; }
        .img_div{ float: left; }
        .img_div p, .file_div p ,#video_div p{ margin: 0px; padding: 3px; text-align: center; background: #d6d6d6; }
        .old_img_div{ display: inline-block; text-align: center; border: 1px solid #cfcfcf; padding-bottom: 5px; }
        .old_img_div p{ background-color: #b8b8b8; color: #fff; font-size: 15px; }
        .checkbox{ width: 16px; height: 16px; }
        .file_div{ display: inline-block; overflow: hidden; height: 150px; }

        .page{ font-size: 18px; text-align: center; padding: 10px 0px;}
        .page span{ padding: 2px 8px; margin-left: 3px; background: #009587; color: #fff; }
        .page a{ padding: 2px 8px; color: #009688; margin-left: 3px; border: 1px solid #e1e1e1; }
        
        .agile-list li.default-element{ border-left: 3px solid #818181; }
        .agile-list li.warning-element{ background: #fef6dd; }
        .agile-list li.success-element{ background: #d6fff3; }
        .agile-list li.info-element{ background: #ddeffd; }
        .agile-list li.danger-element{ background: #fce3ec; }
        

        /*多圖檔*/
        .oneFile_div{ float: left; position: relative; margin: 5px; border: 1px solid #ccc; }
        .one_del_div{ position: absolute; top: 0; right: 0; }
        .other_div{ float: left; }
        .old_file{ width: 200px;  height: 130px; float: left;}
        .old_file p{ text-align: center; background: #ccc; }
        .mark_num{ position: absolute; top: 0; left: 0; padding: 1px 5px; background: #fff; border: 1px solid #e5e5e5; }

        audio{ height: 52px; }

        @media (max-width: 420px){
           .none_420{ display: none; }
        }
     </style>