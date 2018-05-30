<?php 
require 'googlePlace/GooglePlaces.php';
require 'googlePlace/GooglePlacesClient.php';
/*require_once 'config.php';
 
$pdo=pdo_conn();
$sql_q=$pdo->prepare("SELECT case_name FROM build_case WHERE case_id=:case_id");
$sql_q->bindparam(":case_id", $_GET['case_id']);
$sql_q->execute();
$row=$sql_q->fetch(PDO::FETCH_ASSOC);


 if ($_GET) {
   $place_loc=$_GET['place_loc'];
   $keyword=$_GET['keyword'];
   $type=$_GET['type'];
   $radius=$_GET['radius'];
   $zoom=$_GET['zoom'];

    switch ($type) {
 	case 'food': //食
 		$type_name='美食餐廳';
 		break;
    case 'doctor': //醫
 		$type_name='醫療院所';
 		break;
 	case 'bus_station': //行
 		$type_name='公車站牌';
 		break;
 	case 'school':  //育
 		$type_name='鄰近學區';
 		break;
 	case 'store':  //樂
 		$type_name='娛樂購物';
 		break;
  }
 }
*/

 $google_places = new joshtronic\GooglePlaces('AIzaSyBmepW8dB3LSwH6Ny-jd4bHUnVEvpvNL8s');

 $google_places->placeid = $_GET['placeId']; 
 $details = $google_places->details();
 $rand=rand(0, count($details['result']['photos'])-1);
 $photo_url= 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=800&photoreference='.$details['result']['photos'][$rand]['photo_reference'].'&key=AIzaSyBmcZ9YTd68k4QYur5nowITqcI_kGZO5Ks';

?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>附近景點</title>
  <link rel="stylesheet" type="text/css" href="../assets/js/plugins/fancybox/jquery.fancybox.min.css">
  <link rel="stylesheet" type="text/css" href="../assets/js/plugins/swiper/swiper.min.css">
  <link rel="stylesheet" type="text/css" href="../css/jquery.rippleria.css">
	<style type="text/css">
    body{ font-family: Microsoft JhengHei; background-color: #fff; margin: 0px; }
		#map{ width: 100%;height: 500px; margin-top: 93px; }
    #detial{ width: 98%; margin: auto; height: 100vh;}
    #title{ text-align: center; background-color: #373737; padding: 10px 0px; font-size: 20px; color: #fff; position: fixed; top: 0px; width: 100%; z-index: 1000;  box-shadow: 0px 2px 10px rgba(0,0,0,0.67);}

		.del_div{ width: 32%;  display: inline-block; text-align: center; margin: 10px 0px 0px 10px;  color: #fff; }

        .del_div a{ display: inline-block; padding: 12px 45px; margin: 15px 11px; background: #b39c94; text-decoration: none; color: #5f4f49; font-size: 20px; font-weight: 700; border-radius: 4px; box-shadow: 2px 1px 3px rgba(0, 0, 0, 0.2);}

        .del_div a img{ width: 20px; height: 20px; }
        .no_ptxt{ margin:15px 10px; }

    .no_photo{margin: 0px; width: 100%; height: 250px; background: #736059; }
    .no_photo img{ width:100%; max-height:250px; }

    
    #back_btn{ position: fixed; bottom: 60px; right: 0px; text-decoration: none; background-color: rgba(255, 255, 255, 0.65); padding: 10px 21px; color: #483c37; font-size: 20px; border-radius: 30px 0px 0px 30px; font-weight: 600;  box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.35); z-index: 100;}
    #back_btn img{ width: 18px; }

    .footer_btn a img{ width: 20px; height: 20px; }
    .photo_div{ height: 50vh; }

    .swiper-container{ width: 100%; }

    .swiper-button-prev, .swiper-button-next{  width: 35px; background-color: rgba(0, 0, 0, 0.5); }
    .swiper-button-next { right: 0px; background-image: url(img/right1.svg)}
    .swiper-button-prev { left: 0px; background-image: url(img/left1.svg);}
    

/* ======================== 電腦版畫面 ============================ */
@media only screen and (min-width:1024px){
  #title{padding: 2px 0px;}
  #title a{ display: none; }

    #map{ width: 50%; height: 85%; display: inline-block; margin-top: 110px; }
   .del_div{ vertical-align: top; width: 48%; margin: 110px 0px 0px 10px; text-align: left; }
   .del_div h3{ margin: 10px 0px; font-size: 40px; color: #483c37;}
   .del_div h2{ text-align: center; font-size: 60px; margin: 10px 0px; background-color: rgba(0, 0, 0, 0.07); color: #483c37;}
   .del_div h2 small{ font-size: 20px; color: #483c37;}
   .del_div p{ margin-left: 0px; font-size: 20px; color: #483c37;}

   .footer_btn{     
    position: absolute;
    top: 0px;
    right: 0px;
    z-index: 1000;
    font-size: 20px;
    margin: 33px 20px; 
    }

    .footer_btn a{     
    color: #483c37;
    text-decoration: none;
    padding: 15px 30px;
    background: #fff;
    border: 1px solid; }
}

/* ======================== 小電腦版畫面 ============================ */
@media only screen and (max-width:1024px){
   .del_div h3{ font-size: 16px; }
   .del_div{ width: 48%; }


}

/* ======================== 平板畫面 ============================ */
@media only screen and (max-width:768px){
  #detial{ width: 100%; }
   .del_div { width: 100%; margin: 10px 0px 0px 0px; }
   .del_div h3{ font-size: 16px; }

   #map{ position: absolute; height: 81%; left: 100%; margin-top: 130px;}
   #detial{position: absolute; top: 0px; background: #fff; overflow: hidden;}
   .del_div{ margin-top: 127px; position: relative; text-align: left; color:#483c37; }
   .del_div h3{ font-size: 40px; margin: 20px; }
   .del_div h2{ font-size: 60px; padding-bottom: 10px; margin:30px 20px; font-weight: 300; text-align: right; border-bottom: 1px solid #bcbcbc }
   .del_div p{ font-size: 20px; margin: 15px 20px;}
   
   #title{ padding:0px; font-size: 16px; line-height: 3.2em; }
   #title h2{ font-size: 30px; margin: 10px 0px;}
   #title a{ position: relative; width: 50%; display: inline-block; color: #fff; text-decoration: none; font-size: 25px;}

  #title #info_btn p, #title #map_btn p{
    margin: 0px;
    height: 4px;
    background: #fff;
    width: 100%;
  }

  #title #map_btn p{ width: 0%; }
 

   .footer_btn a{ 
    display: inline-block;
    text-align: center;
    text-decoration: none;
    border-radius: 0px;
    margin: 0px;
    padding: 0px;
    width: 33%;
    line-height: 2.6em;
    border: 1px solid;
    background: #f5f4f3;
    color: #483c37;
    font-weight: 400;
    font-size: 25px;
   }
   .footer_btn{ position: absolute; bottom: 0px; width: 100%; z-index: 100; }
   .footer_btn a img{ width: 25px; height: 20px; }

   .photo_div{ height: 45vh; }
}

/* ======================== 手機版畫面 ============================ */
@media only screen and (max-width:420px){
   #map{ position: absolute; height: 500px; left: 100%; margin-top: 93px;}
   #detial{position: absolute; top: 0px; background: #fff; overflow: hidden;}
   .del_div{ margin-top: 93px; }
   .del_div h3{ font-size: 23px; margin:20px 10px; }
   .del_div h2{    font-size: 35px; padding-bottom: 10px; margin: 10px; font-weight: 300; text-align: right; border-bottom: 1px solid #bcbcbc }
   .del_div p{ font-size: 15px; margin:15px 10px;  }
   #title{ padding:0px; font-size: 16px; line-height: 2.2em; }
   #title h2{ font-size: 16px;}
   #title a{ font-size: 15px;}

  #title #info_btn p, #title #map_btn p{
    margin: 0px;
    height: 2px;
    background: #fff;
    width: 100%;
  }

  #title #map_btn p{ width: 0%; }
  
  #back_btn{    
    z-index: 1000;
    position: fixed;

    padding: 7px 15px;
    color: #483c37;
    font-size: 15px;
    font-weight: 600;}
    #back_btn img{ width: 13px; }
 
   .footer_btn a{ 
    display: inline-block;
    text-align: center;
    text-decoration: none;
    border-radius: 0px;
    margin: 0px;
    padding: 0px;
    width: 32.7%;
    line-height: 2.6em;
    border: 1px solid;
    background: #f5f4f3;
    color: #483c37;
    font-weight: 400;
    font-size: 16px;
   }
   .footer_btn{ position: absolute; bottom: 0px; width: 100%; }
   .footer_btn a img{ width: 15px; height: 15px; }

   .photo_div{ height: 41vh; }
  

}
</style>
</head>
<body>
<!-- 抬頭名稱 -->
<div id="title">
 <h2></h2>
 <a id="info_btn"  href="#">資訊<p></p></a><a id="map_btn"  href="#">地圖<p></p></a>
</div>



<div id="detial">
  <!-- 地圖 -->
  <div id="map"></div>
</div>

<a id="back_btn" href="javascript:history.back()"><img src="img/back1.svg"> 返回</a>


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd8Sh2hJ_40P92vt8sOyZwPvVTh867DmU&libraries=places"></script>

<script type="text/javascript" src="../assets/js/plugins/fancybox/jquery.fancybox.min.js"></script>

<!-- 幻燈片 -->
<script type="text/javascript" src="../assets/js/plugins/swiper/swiper.min.js"></script>

<!-- 超強動畫庫 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>

<script type="text/javascript" src="../js/jquery.rippleria.js"></script>

<script type="text/javascript">
var type ='<?php echo $_GET['type'];?>'; //導航類型
var map;
var infowindow;
var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');//指定視窗物件

var latLng='<?php echo $_GET['place_loc'];?>';
   latLng=latLng.split(',');
// ============================= 專案座標 ==============================
  var pyrmont = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};

  map = new google.maps.Map(document.getElementById('map'), {
    center: pyrmont,
    zoom: 14
  });

  infowindow = new google.maps.InfoWindow();

    var cen_mark=new google.maps.Marker({
    position: pyrmont,
    map: map,
    icon:'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|ffeb3b',
  });

    google.maps.event.addListener(cen_mark, 'click', function() {
    infowindow.setContent('建案');
    infowindow.open(map, this);
  });




// =========================== 地點搜尋 ==================================
var service = new google.maps.places.PlacesService(map); //地方資訊庫
  /*service.nearbySearch({
    location: pyrmont,
    radius: '<?php //echo $radius;?>',
    keyword:'<?php //echo $keyword?>',
    type: ['<?php //echo $type;?>'] //百貨商店    
  }, callback);*/

   createMarker('<?php echo $_GET['placeId'];?>'); 

var num=0;
// =========================== 建立marker ==================================
function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
       
       
       var timeout;
           timeout=window.setInterval(function () {
         
          if (num < results.length) {
          	
               createMarker(results[num]); 
          }else{
               window.clearInterval(timeout);
          }
          num++;
       },300);
  }
}


function createMarker(placeId) {
	
service.getDetails({placeId: placeId}, function (det,status) {

  var placeLoc = det.geometry.location;
  // =================== 導航網址 =========================
  var place_url='https://www.google.com/maps/dir/'+latLng[0]+','+latLng[1]+'/'+placeLoc+'/@'+placeLoc+',17z?hl=zh-TW'; 
  var marker = new google.maps.Marker({
    map: map,
    animation: google.maps.Animation.DROP,
    position: placeLoc
  });


  <?php 
  if($_GET['type']=='bus_station'){
     echo "var new_name=det.name+'站';";
  }
  else{
    echo "var new_name=det.name;";
  }
  ?>
   
  


 //======================= 抬頭名稱 =============================
 $('#title h2').html(new_name);
  
 if ((status === google.maps.places.PlacesServiceStatus.OK)) {

  if (det.opening_hours!=undefined) {
   
    var open_time=det.opening_hours.periods[1].open.time;
        open_time=open_time.substr(0,2)+" : "+open_time.substr(2,2);
    var close_time=det.opening_hours.periods[1].close.time;
        close_time=close_time.substr(0,2)+" : "+close_time.substr(2,2);
    }

    // ====================== 詳細方塊 ============================= 
   if (det.photos!=undefined){


    var phone=det.formatted_phone_number==undefined ? '':det.formatted_phone_number;
    var openTime=open_time==undefined ? '':open_time;
    var closeTime=close_time==undefined ? '':close_time;
    var rating=det.rating==undefined ? '-':det.rating;

    var del_txt= '<div class="del_div">';


    del_txt=del_txt+'<h3>'+new_name+'</h3>';
    del_txt=del_txt+'<p class="no_ptxt">地址：'+det.formatted_address+'</p>';
    del_txt=del_txt+'<p class="no_ptxt">電話：'+phone+'</p>';

    if (det.opening_hours!=undefined){
    del_txt=del_txt+'<p class="no_ptxt">營業時間：'+openTime+' ~ '+closeTime+'</p>';
    }

    del_txt=del_txt+'<h2><small>評價 : </small>'+rating+'</h2>';


    //----------------------- 圖片輪播 -------------------------
    //----------------------- 圖片輪播 -------------------------
    //----------------------- 圖片輪播 -------------------------

    // del_txt=del_txt+'<div class="photo_div" style="width:100%; background: url(\''+det.photos[0].getUrl({'maxWidth': 700, 'maxHeight':700})+'\') no-repeat center; background-size: cover"> </div>';
    del_txt=del_txt+'<div class="swiper-container photo_div">';
    del_txt=del_txt+'<div class="swiper-wrapper">';
    for (var i = 0; i < det.photos.length; i++) {
      del_txt=del_txt+'<div class="swiper-slide photo_div" style="width:100%; background: url(\''+det.photos[i].getUrl({'maxWidth': 700, 'maxHeight':700})+'\') no-repeat center; background-size: cover"></div>';
    }
    del_txt=del_txt+'</div>';
    del_txt=del_txt+'<div class="swiper-button-prev"></div>';
    del_txt=del_txt+'<div class="swiper-button-next"></div>';
    del_txt=del_txt+'</div>';
    

    del_txt=del_txt+'</div>';

    del_txt=del_txt+'<div class="footer_btn">';

    if (det.formatted_phone_number!=undefined) {
      del_txt=del_txt+'<a target="_block" href="tel:'+det.formatted_phone_number+'"><img src="img/phone.svg"> 電話</a>';
    }
    if (place_url!=undefined) {
      del_txt=del_txt+'<a target="_block" href="'+place_url+'"><img src="img/navigation.svg"> 導航</a>';
    }
    if (det.website!=undefined) {
      del_txt=del_txt+'<a target="_block" href="'+det.website+'"><img src="img/website.svg"> 網站</a>';
    }
    
    del_txt=del_txt+'</div>';

     $("#detial").append(del_txt);
   }
   else{

    var phone=det.formatted_phone_number==undefined ? '':det.formatted_phone_number;
    var openTime=open_time==undefined ? '':open_time;
    var closeTime=close_time==undefined ? '':close_time;
    var rating=det.rating==undefined ? '-':det.rating;

    var del_txt='<div class="del_div">';

    del_txt=del_txt+'<h3>'+new_name+'</h3>';
    del_txt=del_txt+'<p class="no_ptxt">地址：'+det.formatted_address+'</p>';
    del_txt=del_txt+'<p class="no_ptxt">電話：'+phone+'</p>';
    del_txt=del_txt+'<p class="no_ptxt">營業時間：'+openTime+' ~ '+closeTime+'</p>';
    del_txt=del_txt+'<h2><small>評價:</small>'+rating+'</h2>';

    
    if (type=='bus_station') {
      del_txt=del_txt+'<p class=no_photo style="background-color:#5391ba;"><img src="img/bus.jpg"></p>';
    }else if(type=='doctor'){
      del_txt=del_txt+'<p class=no_photo><img src="img/medical1.svg"></p>';
    }else if(type=='food'){
      del_txt=del_txt+'<p class=no_photo><img src="img/restaurant1.svg"></p>';
    }else if(type=='school'){
      del_txt=del_txt+'<p class=no_photo><img src="img/school1.svg"></p>';
    }else if(type=='store'){
      del_txt=del_txt+'<p class=no_photo><img src="img/shop2.svg"></p>';
    }

    del_txt=del_txt+'</div>';


    del_txt=del_txt+'<div class="footer_btn">';
    
    if (det.formatted_phone_number!=undefined) {
      del_txt=del_txt+'<a target="_block" href="tel:'+det.formatted_phone_number+'"><img src="img/phone.svg"> 電話</a>';
    }
    if (place_url!=undefined) {
      del_txt=del_txt+'<a target="_block" href="'+place_url+'"><img src="img/navigation.svg"> 導航</a>';
    }
    if (det.website!=undefined) {
      del_txt=del_txt+'<a target="_block" href="'+det.website+'"><img src="img/website.svg"> 網站</a>';
    }

    del_txt=del_txt+'</div>';

     $("#detial").append(del_txt);
   }

  }
});

   
  //=================================== marker點擊監聽事件 ===========================================
  		/*google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name+'<br><a href="'+place_url+'">導航指定位置</a>');
           infowindow.open(map, this);

     });*/
}


$(document).ready(function() {

  $('#info_btn').click(function(event) {
    
      TweenMax.to(".del_div", 0.5, {"left":'0%'});
      TweenMax.to("#map", 0.5, {"left":'100%'});
      TweenMax.to("#info_btn p", 0.7, {"width":'100%'});
      TweenMax.to("#map_btn p", 0.2, {"width":'0%'});

     
  });

  $('#map_btn').click(function(event) {
     
      TweenMax.to(".del_div", 0.5, {"left":'-100%'});
      TweenMax.to("#map", 0.5, {"left":'0%'});
      TweenMax.to("#map_btn p", 0.7, { "width":'100%'}); 
      TweenMax.to("#info_btn p", 0.2, {"width":'0%'});
     
  });
  

  $(".fancybox").fancybox();

  

});

$(window).load(function() {
	/* ===================================== 幻燈片 ======================================== */
   var mySwiper = new Swiper ('.swiper-container', {
    loop: true,
    
   // 如果需要前进后退按钮
   navigation: {
     nextEl: ".swiper-button-next",
     prevEl: ".swiper-button-prev",
   }
  });
});


</script>
</body>
</html>