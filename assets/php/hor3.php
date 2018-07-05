<?php
  $life_type=isset($li_row['type']) ? $li_row['type']: 0;
?>

  <!-- navbar 選單 -->
  <?php require '../../assets/php/navbar-hor.php';?>

   <!-- bottom 工具欄 -->
   <div class="bottom_tool">
    
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', '撥打手機', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/007-phone-receiver.svg); background-size: 64%; background-color: #000;"></span><br>電話
   	 </a>
   	 <a target="_blank" href="<?php echo $line_txt;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/006-line.svg); background-size: 75%; background-color: #000;"></span><br>LINE
   	 </a>
   	 <a target="_blank" href="<?php echo $fb_txt;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/facebook-logo.svg); background-color: #000; background-size: 92%;"></span><br>FB
   	 </a>
   	 <a id="life_btn<?php echo $life_type;?>" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/004-smiling-emoticon-square-face.svg); background-size: 55%; background-color: #000;"></span><br>生活
   	 </a>
   	 <a target="_blank" href="https://www.google.com/maps/dir//<?php echo $map_txt;?>/@<?php echo $map_txt;?>,17z?hl=zh-TW" onclick="ga('send', 'event', 'google 導航', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/map.svg); background-color: #000; background-size: 63%;" ></span><br>地圖
   	 </a>
   	 <a id="more_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/3point.svg); background-size: 60%; background-color: #000;"></span><br>更多
   	 </a>


   	 
     
     <!-- QR code -->
     <div id="qr_code_div" style="display: none;">
       <h3><?php echo $case['aTitle'];?> QR Code</h3>
       <img id="qr_img" src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=<?php echo $URL;?>&chld=H|0" alt="">
       <p class="qa_txt">掃描上面的QR Code，連結到<?php echo $case['aTitle'];?></p>
     </div>
     <!-- 連結 -->
     <div id="link_div" style="display: none;">
       <a href="<?php echo $URL;?>"><?php echo $URL;?></a>
     </div>

   </div>


       <!-- 更多 -->
      <div class="more_tool_div">
       <a id="link_btn" class="more_tool_btn" data-clipboard-text="<?php echo $URL;?>" href="javascript:;" onclick="ga('send', 'event', '連結分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: #000;"></span><br>連結
       </a>
       <a id="qr_btn" class="more_tool_btn" href="#qr_code_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: #000;"></span><br>QR
       </a>
     </div>

     <!-- 食醫住行 -->
     <div class="life_tool_div">
       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=food&keyword=<?php echo $life_keyword[0];?>&radius=<?php echo $life_range[0];?>&zoom=<?php echo $life_zoom[0];?>&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '食')">
        <span style="background-image: url(../../img/svg/mapTool/food.svg); background-size: 60%; background-color: #000;"></span><br>食
       </a>

       <a class="more_tool_btn"  data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=doctor&keyword=<?php echo $life_keyword[1];?>&radius=<?php echo $life_range[1];?>&zoom=<?php echo $life_zoom[1];?>&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '醫')">
        <span style="background-image: url(../../img/svg/mapTool/hospital.svg); background-size: 60%; background-color: #000;"></span><br>醫
       </a>

       <a  class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=lodging&keyword=<?php echo $life_keyword[2];?>&radius=<?php echo $life_range[2];?>&zoom=<?php echo $life_zoom[2];?>&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '住')">
        <span style="background-image: url(../../img/svg/mapTool/home.svg); background-size: 60%; background-color: #000;"></span><br>住
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_traffic.php?place_loc=<?php echo $life_location;?>&case_id=<?php echo $case_id;?>&zoom=<?php echo $traffic_zoom;?>&case_name=<?php echo $case['aTitle'];?> " href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '行')">
        <span style="background-image: url(../../img/svg/mapTool/traffic.svg); background-size: 60%; background-color: #000;"></span><br>行
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=school&keyword=<?php echo $life_keyword[3];?>&radius=<?php echo $life_range[3];?>&zoom=<?php echo $life_zoom[3];?>&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '育')">
        <span style="background-image: url(../../img/svg/mapTool/school.svg); background-size: 60%; background-color: #000;"></span><br>育
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=shopping_mall&keyword=<?php echo $life_keyword[4];?>&radius=<?php echo $life_range[4];?>&zoom=<?php echo $life_zoom[4];?>&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '樂')">
        <span style="background-image: url(../../img/svg/mapTool/shop.svg); background-size: 60%; background-color: #000;"></span><br>樂
       </a>

       <a id="life_more_btn" class="more_tool_btn" href="javascript:;" >
        <span style="background-image: url(../../img/svg/3point.svg); background-size: 60%; background-color: #000;"></span><br>更多
       </a>

     </div>