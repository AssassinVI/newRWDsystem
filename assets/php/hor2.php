  <!-- navbar 選單 -->
  <?php require '../../assets/php/navbar-hor.php';?>

   <!-- bottom 工具欄 -->
   <div class="bottom_tool">
    
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', 'phone_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/007-phone-receiver.svg); background-size: 64%; background-color: #808080;"></span><br>電話
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
   	 	<span style="background-image: url(../../img/svg/3point.svg); background-size: 60%; background-color: #808080;"></span><br>更多
   	 </a>

     <div class="more_tool_div">
       <a id="link_btn" class="more_tool_btn" href="#link_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: #808080;"></span><br>連結
       </a>
       <a id="qr_btn" class="more_tool_btn" href="#qr_code_div" data-fancybox onclick="ga('send', 'event', '連結分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: #808080;"></span><br>QR
       </a>
     </div>

   	 
     
     <!-- QR code -->
     <div id="qr_code_div" style="display: none;">
       <img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=<?php echo $URL;?>&chld=H|0" alt="">
     </div>
     <!-- 連結 -->
     <div id="link_div" style="display: none;">
       <a href="<?php echo $URL;?>"><?php echo $URL;?></a>
     </div>

   </div>