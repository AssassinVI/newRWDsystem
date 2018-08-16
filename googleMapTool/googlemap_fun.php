

<?php 
 

 if ($_GET) {
   $place_loc=$_GET['place_loc'];
   $keyword=$_GET['keyword'];
   $type=$_GET['type'];
   $radius=$_GET['radius'];
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
    body{ font-family: Microsoft JhengHei; background: url("img/place_back.png"); margin: 0px; height: 750px;}
    #map{ width: 100%;height: 700px; margin-top: 45px; margin-bottom: 20px;}
    #detial{ width: 98%; margin: auto; }
    #title{ text-align: center; background-color: #373737; padding: 10px 0px; font-size: 20px; color: #fff; position: fixed; top: 0px; width: 100%; z-index: 1000;  box-shadow: 0px 2px 10px rgba(0,0,0,0.67);}

    .del_div{ width: 98%;  display: inline-block; text-align: center; margin: 0px 0px 0px 10px;     background-color: #ffffff; color: #483c37; text-decoration: none; }

        .del_div a{ display: inline-block; padding: 12px 45px; margin: 15px 11px; background: #b39c94; text-decoration: none; color: #5f4f49; font-size: 20px; font-weight: 700; border-radius: 4px; box-shadow: 2px 1px 3px rgba(0, 0, 0, 0.2);}

        .del_div a img{ width: 20px; height: 20px; }
        .no_ptxt{ margin:15px 10px; }

    .no_photo{margin: 0px; width: 100%; height: 250px; background: #736059; }
    .no_photo img{ width:100%; max-height:250px; }

    #back_btn{ position: fixed; bottom: 60px; right: 0px; text-decoration: none; background-color: rgba(255, 255, 255, 0.65); padding: 10px 21px; color: #483c37; font-size: 20px; border-radius: 30px 0px 0px 30px; font-weight: 600;  box-shadow: 1px 3px 4px rgba(0, 0, 0, 0.35);}
    #back_btn img{ width: 18px; }

    .footer_tool_div{ background-color: #efefef; display: flex; align-items: center; justify-content: space-around; width: 98%; margin: 0px 10px;}
    .footer_tool_div a{ padding: 10px 15px; color: #473c37; text-decoration: none; }
    .footer_tool_div img{ width: 20px; }

    .map_img_div{ width:98%; height:300px; margin: 10px 0px 0px 10px; }

    .map_a_div{ display: inline-block; width: 100%; margin-bottom: 10px;}
    .map_a_div h1 p{ font-size: 18px; margin: 0 10px; vertical-align: middle; display: inline-block; }

    .life_item_div{ width: 33%; display: inline-block; }


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
   #map{ height: 350px; display: none;}
   #title{ padding:0px; font-size: 16px; line-height: 2.9em; }
   #detial{ margin-top: 45px; }
   
   .del_div{ text-align: left; margin-top: 0px;}
   .del_div h1{ display: inline-block; vertical-align: top; font-size: 45px; font-weight: 300; margin: 20px 0px;margin-left: 15px; width: 18%;}
   .del_div div{ display: inline-block; width: 70%; margin-left: 20px; margin-bottom: 15px; }
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
    <?php echo $_GET['case_name'].' 附近-娛樂'?> 
</div>

<div id="map"></div>


<div id="detial">
  



</div>


<!-- <a id="back_btn" href="javascript:history.back()"><img src="img/back1.svg"> 返回</a> -->


<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd8Sh2hJ_40P92vt8sOyZwPvVTh867DmU&libraries=places"></script>

<script type="text/javascript" src="../assets/js/plugins/fancybox/jquery.fancybox.min.js"></script>


<script type="text/javascript">
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


service = new google.maps.places.PlacesService(map);//地方資訊庫



//-- 抓取自訂 樂 座標 --
$.ajax({
  url: 'googlemap_fun_ajax.php',
  type: 'POST',
  dataType: 'json',
  data: {case_id: '<?php echo $_GET['case_id'];?>'},
  success:function (json) {
    console.log(json['fun_loc']);
    var fun_loc=json['fun_loc'].split('|');
    var fun_name=json['fun_name'].split('|');
    var num=0;
    var timeout;
    timeout=window.setInterval(function () {
         
          if (num < fun_loc.length) {
            
               custom_loc(num,fun_loc, fun_name);
          }else{
               window.clearInterval(timeout);
          }
          num++;
       },400);


    // =========================== 地點搜尋 ==================================
     setTimeout(function () {
       service.nearbySearch({
        location: pyrmont,
        radius: '<?php echo $radius;?>',
        keyword:'<?php echo $keyword?>',
        type: ['<?php echo $type;?>'] //百貨商店    
      }, callback);
     },fun_loc.length*500);
    
  }
});


//================================ 自訂地點 =================================
function custom_loc(i,fun_loc, fun_name) {
  
  var loc=fun_loc[i].split(',');
  var lat_num=parseFloat(loc[0]);
  var lng_num=parseFloat(loc[1]);
  var request = {
      query: fun_name[i],
      fields: ['formatted_address', 'name', 'rating', 'geometry', 'place_id'],
      locationBias: {lat: lat_num, lng: lng_num}
    }
    service.findPlaceFromQuery(request, callback_get);
}

//================================ 自訂地點建立marker =================================
function callback_get(results, status) {
  console.log(status);
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

  
  

// =========================== 地點搜尋建立marker ==================================
function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {

    var num=0;
       
       console.log(status);
       var timeout2;
           timeout2=window.setInterval(function () {
         
          if (num < results.length) {
          	
               createMarker(results[num]); 
          }else{
               window.clearInterval(timeout2);
          }
          num++;
       },300);
  }
}


//-- 建立詳細資料 --
function createMarker(place) {

  var infowindow = new google.maps.InfoWindow({
    content: '<table>'+
             '<tr>'+
               '<td>'+
                 '<h3>'+place.name+'</h3>'+
               '</td>'+
             '</tr>'+
          '</table>'
  });
	
  var placeLoc = place.geometry.location;
  // =================== 導航網址 =========================
  var place_url='https://www.google.com/maps/dir/'+latLng[0]+','+latLng[1]+'/'+placeLoc+'/@'+placeLoc+',17z?hl=zh-TW'; 
  var marker = new google.maps.Marker({
    map: map,
    animation: google.maps.Animation.DROP,
    position: placeLoc
  });

  //infowindow.open(map, marker);

  marker.addListener('click', function() {
    infowindow.open(map, marker);
  });
  
  // ====================== 詳細方塊 ============================= 
  service.getDetails({placeId: place.place_id}, function (det,status){
    if ((status === google.maps.places.PlacesServiceStatus.OK)){

       var name=place.name.length>=10 ? place.name.substr(0,9)+'...' : place.name;
       var adds=det.formatted_address.length>=30 ? det.formatted_address.substr(0,29)+'...' : det.formatted_address;
       
       var del_txt= '<div class="life_item_div">';
       del_txt=del_txt+'<div class="map_a_div"> <a href="googlemap_place_one.php?placeId='+place.place_id+'&place_loc=<?php echo $place_loc;?>&type=<?php echo $type;?>" class="del_div rippleria">';
       //-- 評價 --
       var rating_txt= place.rating==undefined ? '<h1><p>評價</p>-</h1>': '<h1><p>評價</p>'+place.rating+'</h1>';
       del_txt=del_txt+rating_txt;
       del_txt=del_txt+'<div>';
       del_txt=del_txt+'<h3>'+name+'</h3>';
       del_txt=del_txt+'<p class="no_ptxt">'+adds+'</p>';
       //-- 電話 --
       var phone_txt=det.formatted_phone_number!=undefined ? '<p class="no_ptxt">'+det.formatted_phone_number+'</p>' : '<p class="no_ptxt">　</p>';
       del_txt=del_txt+phone_txt;
       del_txt=del_txt+'</div>';
       del_txt=del_txt+'</a>';
       del_txt=del_txt+'<div class="footer_tool_div">';
       del_txt=del_txt+'<a href="tel:'+det.formatted_phone_number+'" class="place_btn" ><img src="img/phone.svg"> 電話</a>';
       del_txt=del_txt+'<a target="_blank" href="'+place_url+'"><img src="img/navigation.svg"> 導航</a>';
       del_txt=del_txt+'</div>';
       del_txt=del_txt+'</div>';
       del_txt=del_txt+'</div>';
       
       $("#detial").append(del_txt);
    }
  });
   
}



</script>
</body>
</html>