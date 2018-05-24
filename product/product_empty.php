<?php 
  require '../../sys/core/inc/config.php';
  require '../../sys/core/inc/function.php';
  
  $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $Tb_index=explode('/', $_SERVER['REQUEST_URI']);
  $case_id='case'.$Tb_index[2];
  $case=pdo_select('SELECT * FROM build_case WHERE Tb_index=:Tb_index', ['Tb_index'=>$case_id] );
  //廣告製作
  $ad_making=$case['ad_making']=='j' ?  ['聯創數位', 'http://srl.tw/RWD/HTML/Default2.html'] : ['元際數位', 'http://srl.tw/RWD/HTML/Default_cu.html'];
  //LINE分享或群組
  $line_txt=strpos($case['line_txt'], 'line.me/R/ti')===false ? 'http://line.me/R/msg/text/?'.$case['line_txt']: $case['line_txt'];
  //FB分享或粉絲團
  $fb_txt=empty($case['fb_txt']) ? 'https://www.facebook.com/dialog/feed?app_id=563666290458260&display=popup&link=' . $URL . '&redirect_uri=https://www.facebook.com/' : $case['fb_txt'];
  //導航連結
  $gps_row=pdo_select('SELECT location FROM googlemap_tb WHERE case_id=:case_id', ['case_id'=>$case_id] );
  $map_txt= empty($gps_row['location']) ? $case['build_adds'] : $gps_row['location'];

  // 功能區塊
  $fun_block_id=pdo_select('SELECT fun_id FROM Related_tb WHERE case_id=:case_id ORDER BY OrderBy ASC' , ['case_id'=>$case_id] );
  $fun_block_id_num=count($fun_block_id);
 

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title><?php echo $case['aTitle'];?></title>
	<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
  <!-- FACEBOOK 分享資訊 -->
  <meta property="og:title" content="<?php echo $case['aTitle'];?>"/>
  <meta property="og:description" content="<?php echo $case['description'];?>" />
  <meta property="og:url" content="<?php echo $URL;?>" />
  <meta itemprop="image" property="og:image" content="<?php echo $URL.'img/'.$case['aPic'];?>" />
  <meta property="og:type" content="website" />
  <meta name="description" content="<?php echo $case['description'];?>" />
  <meta name="Author" content="<?php echo $ad_making[0];?>" />
  <meta name="keywords" content="<?php echo $case['KeyWord'];?>" />
  
  <script type="text/javascript" src="../../assets/js/jquery-3.3.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/hamburgers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Swiper -->
    <link rel="stylesheet" type="text/css" href="../../assets/js/plugins/swiper/swiper.min.css">
    <!-- FancyBox -->
    <link rel="stylesheet" type="text/css" href="../../assets/js/plugins/fancybox/jquery.fancybox.min.css">
    <!-- animate.css -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/animate.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/horizontal.css">

<style type="text/css">

<?php
 //-------- 更改顏色 ----------
$row_color=pdo_select("SELECT * FROM color WHERE Tb_index=:Tb_index", ['Tb_index'=>$case_id]);

$h1_color= empty($row_color['h1_color']) ? '': '.no-gutters .con_txt h1 {color: '.$row_color['h1_color'].';}';
$h2_color= empty($row_color['h2_color']) ? '': '.no-gutters .con_txt h2 p {color: '.$row_color['h2_color'].';}';
$p_color= empty($row_color['p_color']) ? '': '.no-gutters .con_txt p {color: '.$row_color['p_color'].';}';
$top_txt= empty($row_color['top_txt']) ? '': '.navbar-light .navbar-nav .nav-link {color: '.$row_color['top_txt'].';}';
$top_bar= empty($row_color['top_bar']) ? '': '#top_navbar {color: '.$row_color['top_bar'].';}';
$back_color= empty($row_color['back_color']) ? '': '#case_div {background-color: '.$row_color['back_color'].';}';

echo $h1_color;
echo $h2_color;
echo $p_color;
echo $top_txt;
echo $top_bar;
echo $back_color;

 //--------- 自訂CSS ----------
 $row_css=pdo_select("SELECT css FROM change_css WHERE Tb_index=:Tb_index", ['Tb_index'=>$case_id]);
  echo $row_css['css'];
?> 

</style>

</head>

<body>
   <!-- Top按鈕 -->
   <a id="top_arrow" href="javascript:;" style="background-image: url(../../img/svg/up-arrow.svg); "></a>

  <!-- 橫式遮罩 -->
  <div class="landscape_div">
    <div>
      <!-- <i class="fa fa-mobile landscape"></i> -->
      <i class="fa fa-mobile portrait"></i>
     <p>畫面不支援，請改用直式</p> 
    </div>
  </div>
    
    <!-- navbar 選單 -->
	<nav id="top_navbar" class="navbar navbar-expand-lg navbar-light ">
	  
    <div class="container">
	  <button id="ph_nav_btn" class="hamburger hamburger--slider" type="button">
	    <span class="hamburger-box">
	      <span class="hamburger-inner"></span>
	    </span>
	  </button>

	  <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
	    <div class="navbar-nav">
      <?php
       for ($i=0; $i < $fun_block_id_num ; $i++) { 
        $fun_block_type=substr($fun_block_id[$i]['fun_id'], 0,2);
         if ($fun_block_type=='an') {
            $row_an=pdo_select("SELECT anchor_name FROM anchor_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
            echo '<a class="nav-item nav-link" href="javascript:;" anchor="'.$fun_block_id[$i]['fun_id'].'" >'.$row_an['anchor_name'].'</a>';
         }
       }
      ?>
	    </div>
	  </div>

	  <div class="ch_tool_btn">
	  	<a id="case_btn" href="javascript:;"><?php echo $case['aTitle'];?> <span style="height: 100%;"></span></a>
	  	<a id="news_btn" href="javascript:;">媒體報導 <span></span></a>
	  </div>

	  <div class="txt_big_btn">
	  	<a href="javascript:;"><i class="fa fa-search-plus"></i></a>
	  </div>
  </div>

	</nav>
   
   <!-- bottom 工具欄 -->
   <div class="bottom_tool">
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', 'phone_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/007-phone-receiver.svg); background-size: 64%; background-color: #FFC107;"></span><br>電話
   	 </a>
   	 <a target="_blank" href="<?php echo $line_txt;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/006-line.svg); background-size: 75%; background-color: #52CB34;"></span><br>LINE
   	 </a>
   	 <a target="_blank" href="<?php echo $fb_txt;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/facebook-logo.svg); background-color: #576ba8; background-size: 92%;"></span><br>FB
   	 </a>
   	 <a id="life_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/004-smiling-emoticon-square-face.svg); background-size: 55%; background-color: #FFC107;"></span><br>生活
   	 </a>
   	 <a target="_blank" href="https://www.google.com/maps/dir//<?php echo $map_txt;?>/@<?php echo $map_txt;?>,17z?hl=zh-TW" onclick="ga('send', 'event', 'map_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/003-google.svg); background-size: 99%;"></span><br>地圖
   	 </a>
   	 <a id="more_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/3point.svg); background-size: 60%; background-color: #FFC107;"></span><br>更多
   	 </a>

   	 <a id="link_btn" class="more_tool_btn" href="#link_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: #FFC107;"></span>
   	 </a>
   	 <a id="qr_btn" class="more_tool_btn" href="#qr_code_div" data-fancybox onclick="ga('send', 'event', '連結分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: #FFC107;"></span>
   	 </a>
     
     <!-- QR code -->
     <div id="qr_code_div" style="display: none;">
       <img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=<?php echo $URL;?>&chld=H|0" alt="">
     </div>
     <!-- 連結 -->
     <div id="link_div" style="display: none;">
       <a href="<?php echo $URL;?>"><?php echo $URL;?></a>
     </div>

   </div>
    
    <!-- 建案資訊 -->
    <div id="case_div" class="container-fluid">
    	<div class="row no-gutters">

        <?php require '../../assets/php/case_content.php';?>


     <!-- Footer -->
      <div class="col-md-12">
      	 <div class="footer_div">
    	    <span><?php echo $case['aTitle'];?> </span>
    	    <span><i class="fa fa-home"></i> <?php echo $case['format'];?></span>
    	    <span><i class="fa fa-home"></i> 接待會館：<?php echo $case['build_adds'];?></span>
    	    <span><i class="fa fa-phone"></i> 禮賓專線：<?php echo $case['phone'];?></span>
          <p class="footer_adv">
            廣告製作：<a href="<?php echo $ad_making[1];?>"><?php echo $ad_making[0];?> <img src="../../img/svg/footer_btn.svg" alt=""></a>
          </p>
    	  </div>
      </div>


    

    	</div>
    </div>




    <!-- 新聞內容 -->
    <div id="news_div" class="container-fluid ">
      <div class="row no-gutters">
        <div class="col-md-12">
          <img src="img/LOGO.jpg" alt="">
        </div>
        <div class="col-md-12 news_list">
          <ul>

          <?php 
            $news_row=pdo_select("SELECT * FROM case_news WHERE case_id=:case_id", ['case_id'=>$case_id]);
            $news_row_num=count($news_row);
            
            for ($i=0; $i <$news_row_num ; $i++) { 

              $date=explode('-', $news_row[$i]['StartDate']);
              $month=date('M', strtotime($date[1]));
              echo '
            <li>
              <div class="row">
                <div class="col-2"><span>'.$month.'<br><b>'. $date[2].'</b><br>'.$date[0].'</span></div>
                <div class="col-10">
                  <h4><a href="'.$news_row[$i]['aUrl'].'">'.$news_row[$i]['aTitle'].'</a></h4>
                  <p>來源：'.$news_row[$i]['source'].'</p>
                  <p>'.$news_row[$i]['aAbstract'].' <a href="'.$news_row[$i]['aUrl'].'">More</a></p>
                </div>
              </div>
            </li>';
            }
          ?>
           
          </ul>
        </div>
      </div>
    </div>
	


<script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
<!-- 超強動畫庫 -->
<script  src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
<!-- Swiper -->
<script type="text/javascript" src="../../assets/js/plugins/swiper/swiper.min.js"></script>
<!-- isotope -->
<script type="text/javascript" src="../../assets/js/plugins/isotope/isotope.pkgd.min.js"></script>
<!-- FancyBox -->
<script type="text/javascript" src="../../assets/js/plugins/fancybox/jquery.fancybox.min.js"></script>
<!-- Google Map -->
<script type="text/javascript" src="../../assets/js/plugins/tinyMap/jquery.tinyMap.js"></script>
<!-- wow.js -->
<script type="text/javascript" src="../../assets/js/wow.js"></script>

<script type="text/javascript" src="../../assets/js/horizontal.js"></script>
</body>
</html>