<style type="text/css">
    @media (max-width: 768px){
     .navbar{ background-color: #000; }
     .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after{ background-color: #fff; }
     .txt_big_btn a, .ch_tool_btn a{ color: #fff; }
     .ch_tool_btn a:nth-child(1){ color: #000; }
     .ch_tool_btn a span{ background-color: #fff; }

     .bottom_tool{ background-color: #000; }
     .bottom_tool a{ color: #fff; text-align: center; }
     .more_tool_div{ background-color: #505050; }
   }
</style>
<script type="text/javascript" >
  $(document).ready(function() {
        $('.ch_tool_btn a').click(function(event) {

          $('.ch_tool_btn a').css('color', '#fff');

          if ($(this).find('span').height()=='0') {
             $('.ch_tool_btn a span').css('height', '0%');
                   TweenMax.to( $(this).find('span'), 0.2, {height:'100%'});
                   TweenMax.to( $(this), 0.2, {color:'#000'});
          } 

        });
  });
</script>

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
        <a id="case_btn" href="javascript:;"><i class="fa fa-th-large"></i> <?php echo $case['aTitle'];?> <span style="height: 100%;"></span></a>
        <a id="news_btn" href="javascript:;"><i class="fa fa-newspaper-o"></i> 媒體報導 <span></span></a>
      </div>

      <div class="txt_big_btn">
        <a href="javascript:;"><i class="fa fa-search-plus"></i></a>
      </div>
    </div>
  </nav>


   <!-- bottom 工具欄 -->
   <div class="bottom_tool">
    
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', 'phone_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_phone.png); background-size: 90%; background-color: rgba(0,0,0,0);"></span><br>TEL
   	 </a>
   	 <a target="_blank" href="<?php echo $line_txt;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_line.png); background-size: 99%; background-color: rgba(0,0,0,0);"></span><br>LINE
   	 </a>
   	 <a target="_blank" href="<?php echo $fb_txt;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_fb.png);  background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>FB
   	 </a>
   	 <a id="life_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/new_live.png); background-size: 100%; background-color: rgba(0,0,0,0);"></span><br>Life
   	 </a>
   	<!--  <a target="_blank" href="https://www.google.com/maps/dir//<?php //echo $map_txt;?>/@<?php //echo $map_txt;?>,17z?hl=zh-TW" onclick="ga('send', 'event', 'map_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new); background-size: 99%;"></span><br>地圖
   	 </a> -->
   	 <a id="more_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/new_more.png); background-size: 110%; background-color: rgba(0,0,0,0);"></span><br>more
   	 </a>

     <div class="more_tool_div">
       <a id="link_btn" class="more_tool_btn" href="#link_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>連結
       </a>
       <a id="qr_btn" class="more_tool_btn" href="#qr_code_div" data-fancybox onclick="ga('send', 'event', '連結分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>QR
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