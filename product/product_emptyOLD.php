<?php
include 'caseId.php';
include '../../assets/php/data.php';
require_once '../../assets/php/check_phone.php'; //判斷手機
?>

<?php

// -- 抓取建案 --
$case = select_case($case_id);
//-- 抓取功能ID --
$fun_id = select_rel($case_id);
//-- 更改顏色 --
$color = select_color($case_id);
//-- 更改CSS --
$css = changeCSS($case_id);

/* ================= 地圖(食醫住行育樂) ===================== */
$map_life_btn = select_map_btn($case_id);
/* ================= 推播 =================== */
$webPush =is_webPush($case_id);
$Push_key=webPush_key($case_id);

//建案說明
$other = html_entity_decode($case['other'], ENT_QUOTES, "UTF-8");
//目前網址

$protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
$URL = $protocol.'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

//-- 手機功能-地圖 --

for ($i = 0; $i < count($fun_id); $i++) {
	$sel_fun = substr($fun_id[$i], 0, 2);
	if ($sel_fun == 'gm') {
		$map_ps = select_map($fun_id[$i]);
	}
}

//-- 刊頭 --
for ($i = 0; $i < count($fun_id); $i++) {
	$sel_fun = substr($fun_id[$i], 0, 2);

	if ($sel_fun == 'bs') {
		$bs_img1 = $fun_id[$i] . "_1.jpg";
	} elseif ($sel_fun == 'vt') {
		//-------- 影片刊頭 -----------
		$video_title = sel_video_title($fun_id[$i]);
	}
}

// -- LINE 分享 或 加LINE群組 --
if ($case['line_tool'] == "line_plus") {
	$bu_line = $case['bu_line'];
} elseif ($case['line_tool'] == "line_share") {

	if (strpos($case['bu_line'], 'http')) {
		$bu_line = "http://line.me/R/msg/text/?" . $case['bu_line'];
	} else {
		$bu_line = "http://line.me/R/msg/text/?" . $case['bu_line'] . $URL;
	}
}

// -- facebook 分享 或 紛絲團 --
if (empty($case['bu_fb'])) {
	//分享

	$bu_fb = 'https://www.facebook.com/dialog/feed?app_id=563666290458260&display=popup&link=' . $URL . '&redirect_uri=https://www.facebook.com/';
} else {

	$bu_fb = $case['bu_fb'];
}

?>



<!DOCTYPE html>

<!--[if IE 8]>      <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>      <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<!--FACEBOOK Open Graph 標記語言-->

<html xmlns:og='http://ogp.me/ns#'>

<!--<![endif]-->

<head itemscope itemtype="http://schema.org/Product">

    <meta charset="utf-8" />
    <title itemprop="name"><?php echo $case['case_name']; ?></title>
    <!-- FACEBOOK 分享資訊 -->
    <meta property="og:title" content="<?php echo $case['case_name']; ?>" />
    <meta property="og:description" content="<?php echo $other; ?>" />
    <meta property="og:url" content="<?php echo $URL; ?>" />

    <!-- 分享主圖 -->
    <?php if(empty($case['case_logo'])){?>
    <meta itemprop="image" property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/product_html/<?php echo $case_id ?>/assets/images/<?php echo $bs_img1; ?>" />
    <?php }else{?>
    <meta itemprop="image" property="og:image" content="http://<?php echo $_SERVER['HTTP_HOST'];?>/Static_Seed_Project/img/case_logo/<?php echo $case['case_logo']; ?>" />
    <?php }?>
    <meta property="og:type" content="website" />
    <meta name="description" content="<?php echo $other; ?>" />
    <meta name="Author" content="聯創數位整合" />
    <meta name="keywords" content="<?php echo $case['KeyWord']; ?>" />
    <!-- mobile settings -->
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
    <!-- CORE CSS -->
    <link  href="../../assets/js/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/js/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/css/superslides.css" rel="stylesheet" type="text/css" />
    <!-- REVOLUTION SLIDER -->
    <link  href="../../assets/js/plugins/revolution-slider/css/settings.css" rel="stylesheet" type="text/css" />
    <!-- THEME CSS -->
    <link  href="../../assets/css/essentials.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/css/layout.css" rel="stylesheet" type="text/css" />
    <link  href="../../assets/css/layout-responsive.css" rel="stylesheet" type="text/css" />
    <!-- 觸控式幻燈片 -->
    <link  rel="stylesheet" type="text/css" href="../../assets/css/swiper.min.css">
    <!-- 黑色Layout -->
    <!--<link id="css_dark_skin" href="assets/css/layout-dark.css" rel="stylesheet" type="text/css" />-->
    <!-- 換色必要Layout -->
    <link  rel="stylesheet" type="text/css" href="../../assets/css/RWD_doc-layout1.css?<?php echo date('His');?>">
    <!-- 白色Layout -->
    <link  rel="stylesheet" type="text/css" href="../../assets/css/RWD_white_layout.css?<?php echo date('His');?>">
    
    <!-- 燈箱(fancyBox) -->
    <link  rel="stylesheet" type="text/css" href="../../assets/js/source/jquery.fancybox.css">
    <link  rel="stylesheet" type="text/css" href="../../assets/js/source/helpers/jquery.fancybox-thumbs.css">
    <!-- STYLESWITCHER - REMOVE ON PRODUCTION/DEVELOPMENT -->
    <link  href="../../assets/js/plugins/styleswitcher/styleswitcher.css" rel="stylesheet" type="text/css" />
    
    <!-- Loading -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/loading.css">

    <!-- 影片刊頭 -->
    <?php if (!empty($video_title)) {?>
     <link  rel="stylesheet" type="text/css" href="../../assets/css/video_title_Lay.css">
    <?php }?>


   <!-- 新工具欄 new_toolBar -->
   <?php
if ($map_life_btn['btn_style'] == '0') {

	$var = '';
} else {

	$var = '2';
}
echo '<link  rel="stylesheet" type="text/css" href="../../assets/css/new_toolBar' . $var . '.css">';

?>
  
  <!-- 自定義CSS -->
  <link  rel="stylesheet" type="text/css" href="case_css.css">

    <!-- 更改新顏色 -->
    <style type="text/css">
    #bar_qr_code{ display: none; }

      .content h1{
        color: <?php echo $color['h1_color']; ?>; /* 主標 */
       }
      .content h2, .h2_txt p{
        color: <?php echo $color['h2_color']; ?>;/* 副標 */
       }
      .content .p_txt ,ol li,ul li, .p_txt p{
        color: <?php echo $color['p_color']; ?>;/* 內文 */
       }
      .marquee_box{
        color: <?php echo $color['marquee']; ?>;/* 跑馬燈 */
       }
       .big_txt b{
        color: <?php echo $color['top_txt']; ?>;/* 錨點文字 */
       }
       .big_txt b:hover{
        color: <?php echo $color['h1_color']; ?>;
       }
       .big_txt b:after{ background-color: <?php echo $color['h1_color']; ?> }
       header#topNav{
        background-color: <?php echo $color['top_bar']; ?>;/* 導航欄 */
        border-color: <?php echo $color['top_bar']; ?>;
        box-shadow: none;
       }
       #nav_ul{ position: relative; background: <?php echo $color['top_bar']; ?>; }
      body #wrapper{
        background-color: <?php echo $color['back_color']; ?>;/* 背景 */
       }

       #gm_food_btn{
          background-color: <?php echo $map_life_btn['map_food']; ?>;
       }
       #gm_phl_btn{
          background-color: <?php echo $map_life_btn['map_hospital']; ?>;
       }
       #gm_home_btn{
          background-color: <?php echo $map_life_btn['map_home']; ?>;
       }
       #gm_work_btn{
          background-color: <?php echo $map_life_btn['map_traffic']; ?>;
       }
       #gm_school_btn{
          background-color: <?php echo $map_life_btn['map_school']; ?>;
       }
       #gm_fun_btn{
          background-color: <?php echo $map_life_btn['map_fun']; ?>;
       }
       
  
       <?php
       //--- 更改CSS --- 
       echo $css['css'];
       ?>

      @media only screen and (max-width:800px) {
         .big_txt b{
            color: #fff;

          }
        }
        @media only screen and (max-width:768px){
          #nav_ul #bar_qr_code{ display: block; width: 100px; margin: auto; }
        }

    </style>
</head>
<body>

    <!-- Available classes for body: boxed , pattern1...pattern10 . Background Image - example add: data-background="assets/images/boxed_background/1.jpg"  -->



    <!-- WRAPPER -->
    <div id="wrapper">

        <div id="all">

  <?php if (!empty($video_title)) {?>
     <!-- ==========================影片刊頭 ==================================-->
        <div id="logo_div">
             <div>
                <?php echo $video_title['content'] ?>
             </div>
             <video src="http://rwd.srl.tw/product_html/<?php echo $case_id;?>/assets/images/<?php echo $video_title['video'] ?>" autoplay loop ></video>
          </div>
    <?php if (!empty($video_title['ph_video_img'])) {?>
          <div id="ph_logo" class="base_div">
             <img src="http://rwd.srl.tw/product_html/<?php echo $case_id;?>/assets/images/<?php echo $video_title['ph_video_img']; ?>" alt="">
          </div>
    <?php }?>

  <?php }?>


    <!-- TOP NAV -->
    <header id="topNav" class=" nopadd">
        <!-- remove class="topHead" if no topHead used! -->
        <div class="container ">
            <!-- 背景音樂 -->
            <audio id="myaudio" autoplay preload loop></audio>
            <!-- Mobile Menu Button -->
            <button class="btn-mobile pull-left  " data-toggle="collapse" data-target=".nav-main-collapse">
                <span style="color: #fff; font-size: 20px;" class="glyphicon glyphicon-align-justify"></span>
            </button>
            <!-- 跑馬燈 -->
            <!--<div class="marquee_lay"></div>-->
            <marquee class="ph_mar marquee_box"><?php echo $case['marquee'] ?></marquee>
            <!-- 背景音樂按鈕 -->
    <?php
if (!empty($case['activity_song'])) {
	echo '<button type="button" class="song_btn pull-right"><span class="glyphicon glyphicon-volume-off"></span></button>';
}
?>
            <!-- Top Nav -->
            <div id="nav_btn" class=" navbar-collapse nav-main-collapse collapse pull-right">
            <!-- 跑馬燈 -->
            <!--<div class="marquee_lay"></div>-->
            <marquee class="pc_mar marquee_box"><?php echo $case['marquee'] ?></marquee>
                <nav class="nav-main mega-menu ">
                    <ul id="nav_ul" class="nav nav-pills nav-main scroll-menu" id="topMain">
                    </ul>
                    <!--<div id="bar_qr_code">
                      <img src="http://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=<?php echo $URL;?>&chld=H|0" alt="">
                    </div>-->
                </nav>
            </div>
            <!-- /Top Nav -->
        </div>
    </header>
        <span id="header_shadow"></span>
        <!-- 支撐方塊 -->
        <div id="nav_box" style="height: 81px; display: none;"></div>
    <!-- /TOP NAV -->

  <!-- ** 提前載入按鈕 ** -->
  <div style="display: none;">
  <?php 
   require '../../assets/php/old_life_btn.php';
  ?>
  </div>
    

  <!-- ============================ 主文 ====================================-->
            <div class="content">



           <?php require '../../assets/php/tool_content.php'; //頁面內容?>



            </div>
        </div>
    </div>
    <!-- /WRAPPER -->
    <!-- FOOTER -->
    <footer class="dom_index">


  <!-- =============================== Loading ========================================= -->
  <div id="loading_div">
    <div id="loading">
      <img class="ld ld-cycle" src="../../assets/images/loading.png"><!--<i class="fa fa-spinner fa-spin"></i>-->
       <h2 class="loading_txt">0%</h2>
    </div>
  </div>

        <!-- ===============================手機功能欄 (食衣住行育樂)========================================= -->
<?php
if ((empty($map_life_btn)) OR ($map_life_btn['is_use'] == '0')) {
//原版
	require '../../assets/php/old_life_btn.php'; //因為要重複帶入
} else {
	//新版
	require '../../assets/php/map_life_btn.php';
}
?>


        <!-- LINE按鈕 -->
        <!--<a href="<?php //echo $bu_line; ?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')"><img  class="LINE_tool" src="../../assets/images/svg/line.svg" alt=""></a>-->

        <!-- FB按鈕 class="FB_tool" -->
        <a href="<?php echo $bu_fb; ?>" target="_blank" onclick="ga('send', 'event', 'facebook分享', 'click', 'tool_bar')"><img  class="LINE_tool" src="../../assets/images/svg/FB.svg" alt=""></a>

        <!-- ====================== 回官網按鈕 ======================= -->
        <!--<div class="back_home">
            <a href="http://xy168.com.tw/xy/"><i class="fa fa-home"></i></a>
        </div>-->

        <!-- ====================== TOP按鈕 ======================= -->
        <div class="scor_top">
            <span class="glyphicon glyphicon-chevron-up " aria-hidden="true"></span>
        </div>

        <!-- ====================== 文字放大鏡 ======================= -->
        <button id="magn_txt" type="button"><span class="glyphicon glyphicon-zoom-in " aria-hidden="true"></span>
            <p>100%</p>
        </button>

        <!-- footer content -->
  <?php 
      $footer_href=($_GET['adv'] == 'cu') ? 'http://srl.tw/RWD/HTML/Default_cu.html' : 'http://srl.tw/RWD/HTML/Default2.html';
  ?>
        <a target="_blank" href="<?php echo $footer_href?>">
        <div class="footer-content">
            <div class="container">
                <div class="row">
                    <!-- FOOTER CONTACT INFO -->
                    <div class="column col-md-12">
                        <ul id="address_ul">
                            <li>

                                <?php echo $case['case_name'] ?>

                            </li>
                            <li>
                                <span class="glyphicon glyphicon-home"></span>　<?php echo $case['format'] ?>
                            </li>
                                <li>
                                    <span class="glyphicon glyphicon-home"></span>　接待會館：<?php echo $case['build_adds'] ?>
                                </li>
                                <li>
                                    <span class="glyphicon glyphicon-earphone"></span>　禮賓專線：<?php echo $case['bu_phone'] ?>
                                </li>
                                <?php
  if ($_GET['adv'] == 'cu') {
  require_once '../../assets/php/logo_b.php';
} else {
  require_once '../../assets/php/logo_a.php';
}

?>
                        </ul>
                    </div>
                    <!-- /FOOTER CONTACT INFO -->
                </div>
            </div>
        </div>
     </a>
        <!-- footer content -->
    </footer>

    <!-- /FOOTER -->
    <!-- JAVASCRIPT FILES -->
    <script  type="text/javascript" src="../../assets/js/plugins/jquery-2.1.4.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/jquery.easing.1.3.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/jquery.cookie.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/jquery.appear.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/jquery.isotope.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/masonry.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/stellar/jquery.stellar.min.js"></script>
    <!--<script type="text/javascript" src="../../assets/js/plugins/knob/js/jquery.knob.js"></script>-->
    <script  type="text/javascript" src="../../assets/js/plugins/jquery.backstretch.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/superslides/dist/jquery.superslides.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/styleswitcher/styleswitcher.js"></script>
    <!-- STYLESWITCHER - REMOVE ON PRODUCTION/DEVELOPMENT -->
    <!--<script type="text/javascript" src="../../assets/js/plugins/mediaelement/build/mediaelement-and-player.min.js"></script>-->
    <!-- REVOLUTION SLIDER -->
    <script  type="text/javascript" src="../../assets/js/plugins/revolution-slider/js/jquery.themepunch.tools.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/plugins/revolution-slider/js/jquery.themepunch.revolution.min.js"></script>
    <script  type="text/javascript" src="../../assets/js/slider_revolution.js"></script>
    <script  type="text/javascript" src="../../assets/js/scripts.js"></script>-->
    <!-- 觸控式幻燈片 -->
    <script  type="text/javascript" src="../../assets/js/swiper.jquery.min.js"></script>
    <!-- 燈箱(fancyBox) -->
    <script  type="text/javascript" src="../../assets/js/source/jquery.fancybox.js"></script>
    <script  type="text/javascript" src="../../assets/js/source/helpers/jquery.fancybox-thumbs.js"></script>
    <!-- 滾輪動畫 -->
    <script  type="text/javascript" src="../../assets/js/scrollReveal.js"></script>
    <!-- GOOGLE MAP 外掛 -->
    <script  type="text/javascript" src="../../assets/js/jquery.googlemap.js"></script>
    <script  type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBmcZ9YTd68k4QYur5nowITqcI_kGZO5Ks"></script>

    <!-- Morenizr -->
    <script  type="text/javascript" src="../../assets/js/plugins/modernizr.min.js"></script>

    <!-- 顏色十六進制轉HSL -->
    <script  type="text/javascript" src="../../assets/js/color_exchange.js"></script>
    <!-- 瀑布流工具 -->
    <script  type="text/javascript" src="../../assets/js/minigrid.js"></script>
    <!-- 超強動畫庫 -->
    <script  src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
    <!-- 圖片牆特效 -->
    <script  src="../../assets/js/imgwall_move.js"></script>
    <!-- 數字滾動特效 -->
    <script  src="../../assets/js/runMath.js"></script>

    <!-- 新工具欄 -->
    <?php
if ($map_life_btn['btn_style'] == '0') {

	$var = '';
} else {

	$var = '2';
}
echo '<script type="text/javascript" src="../../assets/js/new_toolBar' . $var . '.js"></script>';


//------------------------------------- 網頁推播 ---------------------------------------------
if (!empty($webPush)) {
  echo '<script type="text/javascript" src="../../assets/js/webPush/webPush.js"></script>';
}
?>


   <!-- 延遲載入 -->
   <script  type="text/javascript" src="../../assets/js/jquery.lazyload.min.js"></script>

   <script  type="text/javascript" src="../../assets/js/wow.min.js"></script>





<!-- ****************************** 讀取功能區塊 ************************************* -->

   <script type="text/javascript">

  //延遲載入
   $("img").lazyload({
            effect : "fadeIn",
            placeholder : "../../assets/images/grey.gif"
  });

   

       $(document).ready(function() {


//================================== 網頁推播-訂閱 ====================================
<?php if (!empty($webPush)){ ?>
  //========================= 判斷是否支援推播 =============================
if ('serviceWorker' in navigator && 'PushManager' in window) {
  console.log('Service Worker and Push is supported');
  
  //------------- 啟用service worker -------------
  navigator.serviceWorker.register('webPush/sw.js') 
  .then(function(swReg) {
    //console.log('Service Worker is registered', swReg);
    swRegistration = swReg;
    
    //---- 判斷推播是否已允許 ----
    if (Notification.permission!='granted') {
      subscribeUser('<?php echo $case_id;?>', '<?php echo $Push_key['publicKey'];?>'); //訂閱

    }
  })
  .catch(function(error) {
    console.error('Service Worker Error', error);
  });

  } else {
    console.warn('Push messaging is not supported');
  }
<?php }?>










<?php

for ($i = 0; $i < count($fun_id); $i++) {

	$fun_name = substr($fun_id[$i], 0, 2);

	/* ================================== google MAP ======================================= */
	if ($fun_name == 'gm') {

		$map_html = 'var mapoption = {';
		$map_html .= 'mapTypeControl: false,';
		$map_html .= 'streetViewControl: false,';
		$map_html .= 'zoomcontrol: true,';
		$map_html .= 'scaleControl: true,';
		$map_html .= 'center: new google.maps.LatLng(' . $map_all['map_position'] . '),';
		$map_html .= 'zoom: 16';
		$map_html .= '};';

		/* MAP物件 */
		$map_html .= 'var map = new google.maps.Map(document.getElementById("' . $fun_id[$i] . 'map"), mapoption);';

		/* 標記物件 */
		$map_html .= 'var marker = new google.maps.Marker({ map: map, position: map.getCenter() });';

		$map_html .= 'var info_txt = "<b>' . $case['case_name'] . '</b><br><b> ' . $map_all['mark_txt'] . '</b>";';

		/* 說明視窗物件 */
		$map_html .= 'var info = new google.maps.InfoWindow();';
		$map_html .= 'info.setContent(info_txt);';
		$map_html .= 'info.open(map, marker);';
		$map_html .= 'google.maps.event.addListener(marker, "click", function() { info.open(map, marker); });';

		echo $map_html;


// ================================== 錨點 ===========================================
	} elseif ($fun_name == 'an') {

		$an_name = select_anchor($fun_id[$i]);
		$an_txt = '<li class="dropdown ">';
		$an_txt .= '<a id="' . $fun_id[$i] . '_btn" class="dropdown-toggle" href="#">';
		$an_txt .= '<span class="big_txt "><b>' . $an_name . '</b> </span>';
		$an_txt .= '</a>';
		$an_txt .= '</li>';
		echo "$('#nav_ul').append('" . $an_txt . "');";

//================================= 圖片牆 ======================================    
	} elseif ($fun_name == 'iw') {

		$iw_txt = "minigrid('.grid', '.grid-item', 6, null, null);";
		$iw_txt .= "window.addEventListener('resize', function(){
                              minigrid('.grid', '.grid-item');
                         });";
		echo $iw_txt;
	}
}

?>
       }); //jquery-end

   </script>




    <script type="text/javascript">


    //---------- 顯示工具紐 -------------
    function show_scor() {
      if ($(window).width()<=768) {
        t_show=setTimeout('show_scor()',1000);
        TweenMax.to(".scor_top", 0.2, { right:10,opacity:1});
        TweenMax.to("#magn_txt", 0.2, { opacity:1});
        TweenMax.to(".back_home", 0.2, { opacity:1});

        var $before_top=document.body.scrollTop+$(window).height();
        var $document_bottom = $(document).height()-$before_top-100;
        if ($document_bottom>0) {
          TweenMax.to(".tool_box", 0.5, { bottom:0});
          TweenMax.to(".tool_box_btn", 0.5, {bottom:0});
        }
       }
      }


   // 生成随机数
    var random = function(min, max){
            return Math.floor(Math.random() * (max - min + 1) + min);
     };

    
    //---------- 讀取進度動態 ------------
    var num=1;
     function loading_fun() {
       
       var timeout=random(20,100);

       var t=setTimeout(function () {


         if(window.loaded){

           $('.loading_txt').html('100%');
           TweenMax.to("#loading_div", 1, { opacity: 0, "z-index":0});
           return;
         }

         num+=1;

         if (num>99) {
           num=99;
         }

         $('.loading_txt').html(num+'%');

         loading_fun();

       },timeout);
     }

    $(function() {

     //------ 執行跑進度 -----
     loading_fun();

     //-------------- 讀取畫面 -----------------
      $(window).load(function() {
         window.loaded = true;
         //$('#loading_div').hide('1000');
         //TweenMax.to("#loading_div", 1, { opacity:0, 'z-index':0});
      });
      

      show_scor();
      
        window.scrollReveal = new scrollReveal();
        $(window).load(function() {


            $(window).bind('scroll resize', function() {

                var $this = $(this);
                var $this_Top = $this.scrollTop();
                //-- 下拉後視窗TOP位置 --
               

                //---------- 隱藏工具紐 -------------
               if ($(window).width()<=768) {
                 TweenMax.to(".scor_top", 0.2, { right:50, opacity:0});
                 TweenMax.to("#magn_txt", 0.2, { opacity:0});
                 TweenMax.to(".back_home", 0.2, { opacity:0});

                 TweenMax.to(".tool_box", 0.5, { bottom:-70});
                 TweenMax.to(".tool_box_btn", 0.5, {bottom:-70});

                 TweenMax.to(".tool_lay", 0.5, { rotation: 0, opacity:0, 'left': '44%', 'bottom':'0px'});
               }else{
                 //當高度小於100時 隱藏區塊

                if ($this_Top < 100) {
                    TweenMax.to(".scor_top", 0.5, { right:50, opacity:0});
                }
                //當高度大於400時，顯示區塊
                else if ($this_Top > 400) {
                    TweenMax.to(".scor_top", 0.5, { right:20, opacity:1});
                }

               }
                
 
                




//---------------------- 影片刊頭 ------------------------

<?php if (!empty($video_title)) {?>
              if ($(window).width()>768){ //手機不顯示
                 if ($this_Top<390) {
                  $("#topNav").css( 'position', 'relative' );
                  $("#nav_box").css('display', 'none');
                }
                else if($this_Top>390){
                  $("#topNav").css( 'position', 'fixed' );
                  $("#nav_box").css('display', 'block');
                }
              }
<?php }?>



            }).scroll();
        });
         



        /* ============================ Top 按鈕 ================================= */

        var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
        //指定視窗物件

       $(".scor_top").click(function() {
            $body.animate({
                scrollTop: 0
            }, 1000);
        });


 //====================================== 錨點 ===================================
<?php
$pdo=pdo_conn();
$sql=$pdo->prepare("SELECT fun_id FROM anchor_tb WHERE case_id=:case_id");
$sql->execute(array(':case_id'=>$case_id));
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {

	$funId = $row['fun_id'];
	$top_txt = '$("#' . $funId . '_btn").click(function(event) {';
	$top_txt .= 'event.preventDefault();';
	$top_txt .= '$body.animate({ scrollTop: $("#' . $funId . '").offset().top - 50  }, 1000);';
	$top_txt .= '});';

	echo $top_txt;

}
$pdo=NULL;

//close_nav
$top_qr_code='<li id="bar_qr_code" class="dropdown"><img src="https://chart.apis.google.com/chart?cht=qr&chs=100x100&chl= '.$URL.'&chld=H|0" alt=""></li>';
echo "$('#nav_ul').append('" . $top_qr_code . "');";

$close_top = '<li id="close_top" class="dropdown"><span  style="color: #fff;font-size: 30px;margin-top:15px;" class="glyphicon glyphicon-remove-sign"></span></li>';

echo "$('#nav_ul').append('" . $close_top . "');";

?>


//=================================== 錨點Hover ============================



        /* ================================ 背景音樂開關 =========================================== */


        $(".song_btn").click(function() {
            var myaudio = document.getElementById("myaudio");
            if (myaudio.paused) {
                myaudio.play();
                $(".song_btn").find("span").removeClass('glyphicon-volume-up');
                $(".song_btn").find("span").addClass('glyphicon-volume-off');

            } else {
                myaudio.pause();
                $(".song_btn").find("span").removeClass('glyphicon-volume-off');
                $(".song_btn").find("span").addClass('glyphicon-volume-up');
            }
        });



        /* ====================================== p文字放大鏡 ========================================= */

        var amgn_index = 1;
        $("#magn_txt").click(function() {
            var p_size = $(".p_txt").css('fontSize');

            if (p_size!=undefined) {
              var p_size = parseInt(p_size.substr(0, 2));
            }


            var h2_size = $("h2").css('fontSize');

            if (h2_size!=undefined) {
              var h2_size = parseInt(h2_size.substr(0, 2));
            }

            if (amgn_index % 3 == 1) {

                var p_big = p_size + 5;
                var h2_big= h2_size+5;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("h2").css('fontSize', h2_big + 'px');

                $("#magn_txt").find('p').html('120%');

            } else if (amgn_index % 3 == 2) {

                var p_big = p_size + 5;
                var h2_big= h2_size+5;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("h2").css('fontSize', h2_big + 'px');
                $("#magn_txt").find('span').removeClass('glyphicon-zoom-in');
                $("#magn_txt").find('span').addClass('glyphicon-zoom-out');
                $("#magn_txt").find('p').html('150%');

            } else if (amgn_index % 3 == 0) {

                var p_big = p_size - 10;
                var h2_big= h2_size -10;
                $(".p_txt").css('fontSize', p_big + 'px');
                $("h2").css('fontSize', h2_big + 'px');
                $("#magn_txt").find('span').removeClass('glyphicon-zoom-out');
                $("#magn_txt").find('span').addClass('glyphicon-zoom-in');
                $("#magn_txt").find('p').html('100%');

            }

            amgn_index = amgn_index + 1;

        });



        /* ======================= 幻燈片初始化 ============================== */

        var myswiper = new Swiper('.swiper-container', {
            speed: 1200,

        <?php

if (!empty($show_all['play_speed'])) {
	echo 'autoplay: ' . $show_all['play_speed'] . ' ,';
}
?>
            loop: true,

            /* 分頁器 */
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
        });



        /* ============================== 燈箱(fancyBox) ============================== */

        var act_img='<?php echo $case["activity_img"]; ?>';

        if (act_img!="") {
        $.fancybox({

            href: "http://rwd.srl.tw/product_html/<?php echo $case_id;?>/assets/images/activ_img.jpg",
             'padding':'0',
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $.fancybox.open();
        }

/* ================================= 環景燈箱 ======================================= */
          $(".img_div").find('a').fancybox({
               'padding'               :'0',
               'width'                 : '100%',
               'height'               : '100%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });


/* ================================= 功能按鈕燈箱 ======================================= */
          $(".nw_btn").fancybox({
               'padding'               :'0',
               'width'                 : '350px',
               'height'               : '100%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'iframe'
          });

/* ================================= 圖片牆燈箱 ======================================= */
          $(".imgwall").fancybox({
               'padding'               :'0',
               'width'                 : '100%',
               'height'               : '100%',
               'autoScale'               : false,
               'transitionIn'          : 'none',
               'transitionOut'          : 'none',
               'type'                    : 'image',
               helpers  : {
                thumbs  : {
                  width : 80,
                  height  : 80
                }
              }
          });



        /* ============================== 手機網頁自動播歌 ============================== */

        var audioEl = document.getElementById('myaudio');

        // 可以自动播放时正确的事件顺序是
        // loadstart
        // loadedmetadata
        // loadeddata
        // canplay
        // play
        // playing
        //
        // 不能自动播放时触发的事件是
        // iPhone5  iOS 7.0.6 loadstart
        // iPhone6s iOS 9.1   loadstart -> loadedmetadata -> loadeddata -> canplay

        audioEl.addEventListener('loadstart', function() {
            log('loadstart');
        }, false);

        audioEl.addEventListener('loadeddata', function() {
            log('loadeddata');
        }, false);

        audioEl.addEventListener('loadedmetadata', function() {
            log('loadedmetadata');
        }, false);

        audioEl.addEventListener('canplay', function() {
            log('canplay');
        }, false);

        audioEl.addEventListener('play', function() {
            log('play');
            // 当 audio 能够播放后, 移除这个事件
            window.removeEventListener('touchstart', forceSafariPlayAudio, false);
        }, false);

        audioEl.addEventListener('playing', function() {
            log('playing');
        }, false);

        audioEl.addEventListener('pause', function() {
            log('pause');
        }, false);

        // 由于 iOS Safari 限制不允许 audio autoplay, 必须用户主动交互(例如 click)后才能播放 audio,
        // 因此我们通过一个用户交互事件来主动 play 一下 audio.

        window.addEventListener('touchstart', forceSafariPlayAudio, false);

        <?php
if (!empty($case['activity_song'])) {
	echo "audioEl.src = 'music/activity_song.mp3';";
}
?>

        function log(info) {
            console.log(info);
        }

        function forceSafariPlayAudio() {

            audioEl.load(); // iOS 9   还需要额外的 load 一下, 否则直接 play 无效
            audioEl.play(); // iOS 7/8 仅需要 play 一下
        }






      //顏色轉換(back_caseName)
       var color16="<?php echo $color['back_color']; ?>";
       var case_HSL=color_hsl(color16);
       var case_S=new Number(case_HSL[1]*100);

       if (case_HSL[2]>0.7) {
        var case_L=new Number(case_HSL[2]-0.3);
            case_L=case_L*100;
       }
       else{
        var case_L=new Number(case_HSL[2]+0.3);
            case_L=case_L*100;
       }

           case_S=case_S.toFixed(0);
           case_L=case_L.toFixed(0);
       var newHSL="hsl("+case_HSL[0]+","+case_S+"%,"+case_L+"%)";
      // var newHSLA="hsla("+case_HSL[0]+","+case_S+"%,"+case_L+"%, 0.4)";

       $(".back_caseName").css('color', newHSL);
        $(".back_hr").css('borderColor', newHSL);
       // $(".tool_box").css('backgroundColor', newHSLA);

  <?php
if (!empty($map_life_btn['who_other'])) {

	switch ($map_life_btn['who_other']) {
	case 'other_food':
		echo '$("#gm_food_btn").click(function(event)';
		break;

	case 'other_hospital':
		echo '$("#gm_phl_btn").click(function(event)';
		break;

	case 'other_home':
		echo '$("#gm_home_btn").click(function(event)';
		break;

	case 'other_traffic':
		echo '$("#gm_work_btn").click(function(event)';
		break;

	case 'other_school':
		echo '$("#gm_school_btn").click(function(event)';
		break;

	case 'other_fun':
		echo '$("#gm_fun_btn").click(function(event)';
		break;
	}
	echo '{
         event.preventDefault();
         $(".other_div").css(\'backgroundColor\', $(this).css(\'backgroundColor\'));
         $(".other_div").slideToggle(\'500\');
       });';
}

?>



    }); //JQUERY END***************************************************************************************

//---------------------------- 過場動畫 ----------------------------------
var wow = new WOW({ boxClass: 'wow', animateClass: 'animated', offset: 0, mobile: false, live: true });
 wow.init();




    </script>
<!--
    <script type="text/javascript">

    /* ======================================== 輪播跑馬燈 ================================================= */


    $(document).ready(function() {
        //timer_out();
    });

    var marquee = "桃園之心-超群絕倫，高速網路-縱橫交織，綠色能量-絕版密境";
    var txt = marquee.split("，");
    var i = 0;
    var t;

    function timer_out() {
        $(".marquee_lay").slideDown('1500').delay(5000).html(txt[i]).fadeOut('1500');
        var index = txt.length - 1;
        if (i >= index) {
            i = i - index;
        } else {
            i = i + 1;
        }
        t = setTimeout("timer_out()", 6000);
    }


    </script>
-->

    <script>
  /* ================================= GOOGLE分析(追蹤碼) ==================================== */
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $case["google_code"]; ?>', 'auto');
  ga('require', 'displayfeatures');  //客層分析
  ga('send', 'pageview');
    </script>
</body>
</html>

