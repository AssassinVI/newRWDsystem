<?php
  $life_type=isset($li_row['type']) ? $li_row['type']: 0;
?>

<style type="text/css">
    @media (max-width: 768px){
     .navbar{ background-color: #000; }
     .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after{ background-color: #fff; }
     .txt_big_btn a, .ch_tool_btn a{ color: #fff; }
     .ch_tool_btn a:nth-child(1){ color: #000; }
     .ch_tool_btn a span{ background-color: #fff; }

     .bottom_tool{ background-color: #000; }
     .bottom_tool a{ color: #fff; text-align: center; }
     .more_tool_div, .life_tool_div{ background-color: #2f2f2f; }
     .bottom_tool a, .more_tool_div a, .life_tool_div a{ color: #fff; }

     /*下拉選單*/
     #navbarNavAltMarkup{ background-color: #000; }
     #navbarNavAltMarkup a{ border-bottom: 1px solid #646464; }
     .navbar-light .navbar-nav .nav-link{ color: #fff; }
   }
</style>
<script type="text/javascript" >
  $(document).ready(function() {

    // 巡覽列按鈕
    $('#ph_nav_btn').click(function(event) {
      if ($('#ph_nav_btn.is-active ').length<1) {
        $(this).addClass('is-active');
        $('.collapse').css('display', 'block');
        TweenMax.fromTo( '.collapse', 0.5, { opacity:0, top:70},{ opacity:1, top:34 });

        //-- 建案資訊 --
        if ($('#case_div').css('display')!='block') {

              $('#life_more_btn').css('display', 'inline-block');
               
               $('.ch_tool_btn a').css('color', '#fff');
               $('.ch_tool_btn a span').css('height', '0%');
               TweenMax.to( $('#case_btn').find('span'), 0.2, {height:'100%'});
               TweenMax.to( $('#case_btn'), 0.2, {color:'#000'});

              $('#news_div').css('z-index', '0');
              $('#case_div').css('z-index', '2');
              TweenMax.fromTo( $('#case_div'), 0.5, {display:'none', left:'-100%'},{display:'block', left:'0%' });
              TweenMax.to( $('#news_div'), 0.1, {display:'none',  delay:'0.5' });
              nowDiv='#case_div';
          }

      }
      else{
        $(this).removeClass('is-active');
        TweenMax.to( '.collapse', 0.5, { opacity:0, top:70});
        setTimeout("$('.collapse').css('display', 'none')", 500);
      }
    });
        

        // ===== 建案資訊 ====
        $('#case_btn').click(function(event) {
          if ($('#case_div').css('display')!='block') {
               
               $('.ch_tool_btn a').css('color', '#fff');
               $('.ch_tool_btn a span').css('height', '0%');
               TweenMax.to( $(this).find('span'), 0.2, {height:'100%'});
               TweenMax.to( $(this), 0.2, {color:'#000'});

              $('#news_div').css('z-index', '0');
              $('#case_div').css('z-index', '2');
              TweenMax.fromTo( $('#case_div'), 0.5, {display:'none', left:'-100%'},{display:'block', left:'0%' });
              TweenMax.to( $('#news_div'), 0.1, {display:'none',  delay:'0.5' });
              nowDiv='#case_div';
          }
        });

    // ===== 新聞內容 ====
        $('#news_btn').click(function(event) {
          if ($('#news_div').css('display')!='block') {
            
            $('.ch_tool_btn a').css('color', '#fff');
            $('.ch_tool_btn a span').css('height', '0%');
            TweenMax.to( $(this).find('span'), 0.2, {height:'100%'});
            TweenMax.to( $(this), 0.2, {color:'#000'});

            $('#news_div').css('z-index', '2');
            $('#case_div').css('z-index', '0');
            TweenMax.fromTo( $('#news_div'), 0.5, {display:'none', left:'-100%'},{display:'block', left:'0%'});
            TweenMax.to( $('#case_div'), 0.1, {display:'none',  delay:'0.5' });
            nowDiv='#news_div';
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
    
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', '撥打手機', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_phone.png); background-size: 90%; background-color: rgba(0,0,0,0);"></span><br>TEL
   	 </a>
   	 <a target="_blank" href="<?php echo $line_txt;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_line.png); background-size: 99%; background-color: rgba(0,0,0,0);"></span><br>LINE
   	 </a>
   	 <a target="_blank" href="<?php echo $fb_txt;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new_fb.png);  background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>FB
   	 </a>
   	 <a id="life_btn<?php echo $life_type;?>" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/new_live.png); background-size: 100%; background-color: rgba(0,0,0,0);"></span><br>Life
   	 </a>
   	<!--  <a target="_blank" href="https://www.google.com/maps/dir//<?php //echo $map_txt;?>/@<?php //echo $map_txt;?>,17z?hl=zh-TW" onclick="ga('send', 'event', 'map_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/new); background-size: 99%;"></span><br>地圖
   	 </a> -->
   	 <a id="more_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/new_more.png); background-size: 110%; background-color: rgba(0,0,0,0);"></span><br>more
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
        <span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>連結
       </a>
       <a id="qr_btn" class="more_tool_btn" href="#qr_code_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>QR
       </a>
     </div>

     <!-- 食醫住行 -->
     <div class="life_tool_div">
       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=food&keyword=餐廳&radius=1000&zoom=14&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '食')">
        <span style="background-image: url(../../img/svg/mapTool/food.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>食
       </a>

       <a class="more_tool_btn"  data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=doctor&radius=1000&zoom=14&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '醫')">
        <span style="background-image: url(../../img/svg/mapTool/hospital.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>醫
       </a>

       <a  class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=lodging&radius=1000&zoom=14&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '住')">
        <span style="background-image: url(../../img/svg/mapTool/home.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>住
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=bus_station&radius=500&zoom=16&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '行')">
        <span style="background-image: url(../../img/svg/mapTool/bus.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>行
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=school&radius=1000&zoom=14&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '育')">
        <span style="background-image: url(../../img/svg/mapTool/school.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>育
       </a>

       <a class="more_tool_btn" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc=<?php echo $life_location;?>&type=shopping_mall&keyword=&radius=2000&zoom=14&case_name=<?php echo $case['aTitle'] ;?>" href="javascript:;" onclick="ga('send', 'event', '食醫住行', 'click', '樂')">
        <span style="background-image: url(../../img/svg/mapTool/shop.svg); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>樂
       </a>

       <a id="life_more_btn" class="more_tool_btn" href="javascript:;" >
        <span style="background-image: url(../../img/svg/new_more.png); background-size: 60%; background-color: rgba(0,0,0,0);"></span><br>更多
       </a>

     </div>