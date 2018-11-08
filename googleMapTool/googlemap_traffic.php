

<?php 
 

 if ($_GET) {
   $place_loc=$_GET['place_loc'];
   $zoom=$_GET['zoom'];
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
    body{ font-family: Microsoft JhengHei; background: url("img/place_back.png"); margin: 0px; height: 850px;}
    h3 { margin:0; }
		#map{ width: 100%;height: 700px; margin-top: 45px; display: none;}
    #detial{ width: 98%; margin: auto; margin-top: 4rem;}
    #title{ text-align: center; background-color: #373737; padding: 10px 0px; font-size: 20px; color: #fff; position: fixed; top: 0px; width: 100%; z-index: 1000;  box-shadow: 0px 2px 10px rgba(0,0,0,0.67);}

		.del_div{ width: 98%;  display: inline-block; text-align: center; margin: 0px 0px 0px 10px;     background-color: #ffffff; color: #483c37; text-decoration: none; }

        .del_div a{ display: inline-block; padding: 12px 45px; margin: 15px 11px; background: #b39c94; text-decoration: none; color: #5f4f49; font-size: 20px; font-weight: 700; border-radius: 4px; box-shadow: 2px 1px 3px rgba(0, 0, 0, 0.2);}

        .del_div a img{ width: 20px; height: 20px; }

        .del_div h3{ padding: 10px; font-size: 25px;}
        .no_ptxt{ margin:15px 10px; }

    .no_photo{margin: 0px; width: 100%; height: 250px; background: #736059; }
    .no_photo img{ width:100%; max-height:250px; }

    #back_btn{ position: fixed; bottom: 60px; right: 0px; text-decoration: none; background-color: rgba(255, 255, 255, 0.65); padding: 10px 21px; color: #483c37; font-size: 20px; border-radius: 30px 0px 0px 30px; font-weight: 600;  box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.35);}
    #back_btn img{ width: 18px; }

    .footer_tool_div{ background-color: #efefef; display: flex; align-items: center; justify-content: space-around; width: 98%; margin: 0px 10px;}
    .footer_tool_div a{ padding: 10px 15px; color: #473c37; text-decoration: none; }
    .footer_tool_div img{ width: 20px; }

    .map_img_div{ width:98%; height:300px; margin: 10px 0px 0px 10px; }

    .map_a_div{ display: inline-block; width: 100%; }
    .map_a_div h1 p{ font-size: 18px; margin: 0 10px; vertical-align: middle; display: inline-block; }

    .life_item_div{ width: 33%; display: inline-block; margin-top: 10px;}


@media only screen and (max-width:1024px){
   .del_div h3{ font-size: 16px; }
   .del_div{ width: 48%; }

}

@media only screen and (max-width:768px){
  #detial{ width: 100%; }
   .del_div { width: 100%; margin: 10px 0px 0px 0px; }
   .del_div h3{ font-size: 16px; }
   .map_a_div{ width: 97.8%; margin-left: 5px; margin-bottom: 5px; }
   .life_item_div{  width: 100%; }
   .footer_tool_div{ width: 100%; margin: 0; }
}

@media only screen and (max-width:420px){
   
   #map{ height: 70%;  }
   #title{ padding:0px; font-size: 16px; line-height: 2.9em; }
   #detial{ margin-top: 5px; }
   
   .del_div{ text-align: left; margin-top: 0px;}
   .del_div h1{ display: inline-block; vertical-align: top; font-size: 45px; font-weight: 300; margin: 20px 0px;margin-left: 15px; width: 18%;}
   .del_div div{ display: inline-block; width: 100%;text-align: center;}
   .del_div h3{ font-size: 25px; margin: 10px 0px; font-weight: 300;}
   .del_div p{ margin: 5px 0px; font-size: 14px; }
   .map_a_div h1 p{ margin:0px; display: block;}

   .map_img_div{ display: block; margin: 5px; margin-bottom: 0; width: 97.8% !important;}
   .footer_tool_div{ display: flex; }


}
</style>
</head>
<body>
<div id="title">
    <?php echo $_GET['case_name'].' 附近景點 (交通)'?> 
</div>

<div id="map"></div>


<div id="detial">
  



</div>


<!-- <a id="back_btn" href="javascript:history.back()"><img src="img/back1.svg"> 返回</a> -->


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd8Sh2hJ_40P92vt8sOyZwPvVTh867DmU&libraries=places"></script>

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
    zoom: <?php echo $zoom;?>,
    streetViewControl: false,
    mapTypeControl:false
  });

  infowindow = new google.maps.InfoWindow();

    var cen_mark=new google.maps.Marker({
    position: pyrmont,
    map: map,
    icon:'https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home|ffeb3b',
  });

    google.maps.event.addListener(cen_mark, 'mouseover', function() {
    infowindow.setContent('<?php echo $_GET['case_name'];?>');
    infowindow.open(map, this);
  });


//-- 抓取自訂 行 座標 --
$.ajax({
  url: 'googlemap_traffic_ajax.php',
  type: 'POST',
  dataType: 'json',
  data: {case_id: '<?php echo $_GET['case_id'];?>'},
  success:function (json) {
    console.log(json['traffic_loc']);
    var traffic_loc=json['traffic_loc'].split('|');
    var traffic_name=json['traffic_name'].split('|');

    for (var i = 0; i < traffic_loc.length; i++) {

       var loc=traffic_loc[i].split(',');
       createMarker({lat: parseFloat(loc[0]), lng: parseFloat(loc[1])}, traffic_name[i], latLng, loc);
    }
    
  }
});



// =========================== 地點搜尋 ==================================
// var service = new google.maps.places.PlacesService(map); //地方資訊庫
//   service.nearbySearch({
//     location: pyrmont,
//     radius: '<?php //echo $radius;?>',
//     keyword:'<?php //echo $keyword?>',
//     type: ['<?php //echo $type;?>'] //百貨商店    
//   }, callback);

// var num=0;
// // =========================== 建立marker ==================================
// function callback(results, status) {
//   if (status === google.maps.places.PlacesServiceStatus.OK) {
       
       
//        var timeout;
//            timeout=window.setInterval(function () {
         
//           if (num < results.length) {
          	
//                createMarker(results[num]); 
//           }else{
//                window.clearInterval(timeout);
//           }
//           num++;
//        },300);
//   }
// }


function createMarker(place, name, case_loc,location) {


  var infowindow = new google.maps.InfoWindow({
    content: '<table>'+
             '<tr>'+
               '<td>'+
                 '<h3>'+name+'</h3>'+
               '</td>'+
             '</tr>'+
          '</table>'
  });
	
  var placeLoc = place;

  var marker = new google.maps.Marker({
    map: map,
    animation: google.maps.Animation.DROP,
    position: placeLoc
  });

  infowindow.open(map, marker);

  marker.addListener('mouseover', function() {
    infowindow.open(map, marker);
  });

  marker.addListener('mouseout', function() {
    infowindow.close();
  });
  
  $detail='<div class="life_item_div">'+
    '<div class="map_a_div">'+
    '<a href="javascript:;" class="del_div rippleria">'+
      '<div><h3>'+name+'</h3></div>'+
    '</a>'+
    '<div class="footer_tool_div">'+
      '<a target="_blank" href="https://www.google.com/maps/dir/'+case_loc+'/('+location+')/@('+location+'),17z?hl=zh-TW">'+
        '<img src="img/navigation.svg"> 導航</a>'+
      '</div>'+
     '</div>'+
   '</div>';

  $('#detial').append($detail);   
}



</script>
</body>
</html>