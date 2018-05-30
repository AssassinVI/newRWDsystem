<?php 
 

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
 	case 'shopping_mall':  //樂
 		$type_name='娛樂購物';
 		break;
  }
 }


?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>附近景點</title>
  <link rel="stylesheet" type="text/css" href="../assets/js/plugins/fancybox/jquery.fancybox.min.css">
	<style type="text/css">
    body{ font-family: Microsoft JhengHei; background: url("img/place_back.png"); margin: 0px; }
		#map{ width: 100%;height: 800px; margin-top: 45px; }
    #detial{ width: 98%; margin: auto; }
    #title{ text-align: center; background-color: #373737; padding: 10px 0px; font-size: 20px; color: #fff; position: fixed; top: 0px; width: 100%; z-index: 1000;  box-shadow: 0px 2px 10px rgba(0,0,0,0.67);}

		.del_div{ width: 32%;  display: inline-block; text-align: center; margin: 10px 0px 0px 10px;     background-color: #ffffff; color: #483c37; text-decoration: none; }

        .del_div a{ display: inline-block; padding: 12px 45px; margin: 15px 11px; background: #b39c94; text-decoration: none; color: #5f4f49; font-size: 20px; font-weight: 700; border-radius: 4px; box-shadow: 2px 1px 3px rgba(0, 0, 0, 0.2);}

        .del_div a img{ width: 20px; height: 20px; }
        .no_ptxt{ margin:15px 10px; }

    .no_photo{margin: 0px; width: 100%; height: 250px; background: #736059; }
    .no_photo img{ width:100%; max-height:250px; }

    #back_btn{ position: fixed; bottom: 60px; right: 0px; text-decoration: none; background-color: rgba(255, 255, 255, 0.65); padding: 10px 21px; color: #483c37; font-size: 20px; border-radius: 30px 0px 0px 30px; font-weight: 600;  box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.35);}
    #back_btn img{ width: 18px; }



@media only screen and (max-width:1024px){
   .del_div h3{ font-size: 16px; }
   .del_div{ width: 48%; }
}

@media only screen and (max-width:768px){
  #detial{ width: 100%; }
   .del_div { width: 100%; margin: 10px 0px 0px 0px; }
   .del_div h3{ font-size: 16px; }
}

@media only screen and (max-width:420px){
   #map{ height: 350px; display: none;}
   #title{ padding:0px; font-size: 16px; line-height: 2.9em; }
   #detial{ margin-top: 40px; }
   
   .del_div{ text-align: left; margin-top: 1px;}
   .del_div h1{ display: inline-block; vertical-align: top; font-size: 45px; font-weight: 300; margin: 25px 0px;margin-left: 15px; width: 18%;}
   .del_div div{ display: inline-block; width: 70%; margin-left: 20px; margin-bottom: 15px; }
   .del_div h3{ font-size: 25px; margin: 10px 0px; font-weight: 300;}
   .del_div p{ margin: 5px 0px; font-size: 14px; }
}
</style>
</head>
<body>
<div id="title">
    <?php echo $_GET['case_name'].' 附近景點 ('.$type_name.')'?> 
</div>

<div id="map"></div>


<div id="detial"></div>




<a id="back_btn" href="javascript:history.back()"><img src="img/back1.svg"> 返回</a>


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmcZ9YTd68k4QYur5nowITqcI_kGZO5Ks&libraries=places"></script>

<script type="text/javascript" src="../assets/js/plugins/fancybox/jquery.fancybox.min.js"></script>


<script type="text/javascript">
var type ='<?php echo $type;?>'; //導航類型
var map;
var infowindow;
var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');//指定視窗物件

var latLng='<?php echo $place_loc?>';
   latLng=latLng.split(',');
// ============================= 專案座標 ==============================
  var pyrmont = {lat: parseFloat(latLng[0]), lng: parseFloat(latLng[1])};

  map = new google.maps.Map(document.getElementById('map'), {
    center: pyrmont,
    zoom: <?php echo $zoom;?>
  });

  infowindow = new google.maps.InfoWindow();

    var cen_mark=new google.maps.Marker({
    position: pyrmont,
    map: map,
    icon:'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|ffeb3b',
  });

    google.maps.event.addListener(cen_mark, 'click', function() {
    infowindow.setContent('<?php echo $_GET['case_name'];?>');
    infowindow.open(map, this);
  });


// =========================== 地點搜尋 ==================================
var service = new google.maps.places.PlacesService(map); //地方資訊庫
  service.nearbySearch({
    location: pyrmont,
    radius: '<?php echo $radius;?>',
    keyword:'<?php echo $keyword?>',
    type: ['<?php echo $type;?>'] //百貨商店    
  }, callback);

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


function createMarker(place) {
	
  var placeLoc = place.geometry.location;
  // =================== 導航網址 =========================
  var place_url='https://www.google.com/maps/dir/'+latLng[0]+','+latLng[1]+'/'+placeLoc+'/@'+placeLoc+',17z?hl=zh-TW'; 
  var marker = new google.maps.Marker({
    map: map,
    animation: google.maps.Animation.DROP,
    position: placeLoc
  });
   

service.getDetails({placeId: place.place_id}, function (det,status) {
  
 if ((status === google.maps.places.PlacesServiceStatus.OK)) {
    // ====================== 詳細方塊 ============================= 

    if (place.name.length>=10) {
      var name=place.name.substr(0,9)+'...';
    }else{
      var name=place.name;
    }

    if (det.formatted_address.length>=30) {
      var adds=det.formatted_address.substr(0,29)+'...';
    }else{
      var adds=det.formatted_address;
    }

    var del_txt= '<a href="googlemap_place_one.php?placeId='+place.place_id+'&place_loc=<?php echo $place_loc;?>&type=<?php echo $type;?>" class="del_div rippleria">';
    /*del_txt=del_txt+'<div style="width:100%; height:250px; background: url(\''+place.photos[0].getUrl({'maxWidth': 700, 'maxHeight': 700})+'\') no-repeat center;"></div>';*/
    if (place.rating==undefined) {
      del_txt=del_txt+'<h1>-</h1>';
    }else{

      del_txt=del_txt+'<h1>'+place.rating+'</h1>';
    }
    
    del_txt=del_txt+'<div>';

    <?php 
        if ($_GET['type']=='bus_station') {
          echo "del_txt=del_txt+'<h3>'+name+'站</h3>';";
        }
        else{
          echo "del_txt=del_txt+'<h3>'+name+'</h3>';";
        }
      ?>
    

    del_txt=del_txt+'<p class="no_ptxt">'+adds+'</p>';

    if (det.formatted_phone_number!=undefined) {
      del_txt=del_txt+'<p class="no_ptxt">'+det.formatted_phone_number+'</p>';
    }
    else{
      del_txt=del_txt+'<p class="no_ptxt">　</p>';
    }
    
    del_txt=del_txt+'</div>';
    /*del_txt=del_txt+'<a href="detial_place.php?place='+placeLoc+'&place_name='+place.name+'&case_loc='+latLng[0]+','+latLng[1]+'&case_name=<?php //echo $row["case_name"];?>" class="place_btn" ><img src="../images/svg/googlemap_btn/googlemap_btn-svg/gps2.svg"> 位置</a>';
    del_txt=del_txt+'<a href="'+place_url+'"><img src="../images/svg/googlemap_btn/googlemap_btn-svg/navigation.svg"> 導航</a>';*/
    del_txt=del_txt+'</a>';

     $("#detial").append(del_txt);
   


  }
});
   
}


$(document).ready(function() {
  
  /* ================================= 環景燈箱 ======================================= */
          // $(".place_btn").fancybox({
          //      'padding'               :'0',
          //      'width'                 : '800px',
          //      'height'               : '800px',
          //      'autoScale'               : false,
          //      'transitionIn'          : 'none',
          //      'transitionOut'          : 'none',
          //      'type'                    : 'iframe'
          // });


});


</script>
</body>
</html>