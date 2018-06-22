  <!-- navbar 選單 -->
  <style type="text/css">
        html{ font-size: 12px; }
        body, div, p, a, h1,h2,h3,h4,h5,h6,span{ font-family: Microsoft JhengHei; }
        button:focus{ outline: none; }
    #ph_nav_btn{ display: none; }
    

    @media (max-width: 768px){
          #ph_nav_btn{ display: block; padding: 5px 5px 0px 5px; width: 100%; margin-bottom: 10px;}
          .navbar{ padding: 0px; z-index: 10; position: fixed; background: #fff; width: 94%;}

          /*手機漢堡*/
          .hamburger-box{ width: 18px; height: 12px; }
         .hamburger-inner, .hamburger-inner::before, .hamburger-inner::after{ width: 18px; height: 2px; }
         .hamburger--slider .hamburger-inner::before{ top: 5px; }
         .hamburger--slider .hamburger-inner::after{ top:10px; }
         .hamburger--slider.is-active .hamburger-inner{ transform: translate3d(0, 5px, 0) rotate(45deg); }
         .hamburger--slider.is-active .hamburger-inner::after{ transform: translate3d(0, -10px, 0) rotate(-90deg); }

         /*手機MENU*/
         .collapse{ position: absolute; width: 100%; top: 34px; left: 0px; background: #ccc; }
         .navbar-nav{ padding: 0px 15px; }
         .ph_tool_div{  }
         .ch_tool_btn{ width: 100%; }
         .ch_tool_btn a{ padding: 8px 0px; width: 46.5vw; display: inline-block; text-align: center; color: #3c3c3c; letter-spacing: 0.1rem; position: relative; text-decoration: none;}
         .ch_tool_btn a span{ width: 100%; height: 0%; display: inline-block; position: absolute; bottom: 0; left: 0; background: #ffc105; z-index: -1; }
         /*.ch_tool_btn a::after { content: ""; position: absolute; width: 0%; height:100%; background: #FFC107; bottom: 0; left: 0; right: 0; margin: auto; transition: width 0.5s; z-index: -1;}
         .ch_tool_btn a:focus::after{ width: 100%; }*/
         .txt_big_btn a{ display: inline-block;  color: #3c3c3c; padding: 0px; font-size: 1rem; }

         /*bottom 工具欄*/
         .bottom_tool{ position: fixed; bottom: 0; left: auto; right: 0; z-index: 10; background: #fff; width: 50px; height: 100%; padding: 7px 0px 3px 0px; display: inline-block;}
         .bottom_tool a{ text-align: center;  color: #000; display: inline-block; width: 100%; margin-bottom: 10px;}
         .bottom_tool a span{ display: inline-block; width: 25px; height: 24px; background-color: #fff; border-radius: 4px; background-repeat: no-repeat; background-position: center;}
         .more_tool_btn { position: absolute; right: 5vw; bottom: 8vh; display: none;}


         /*內容*/
         .container-fluid{ padding: 0px; padding: 34px 0px 0px 0px; width: 94%; margin:0;}
         .row div img{ width: 100%; }
         .con_txt{ padding: 20px !important; text-align: center; }
         .con_txt h1{ font-size: 2.2rem; letter-spacing: 1.5px; line-height: 1.5em; margin-bottom: 15px; font-weight: 600; }
         .con_txt h2{ font-size: 1.4rem; margin-bottom: 15px; letter-spacing: 1.5px; line-height: 1.5; font-weight: 600; }
         .con_txt p{ font-size: 1.2rem; line-height: 1.8em; text-align: justify; }

         /*Footer*/
         .footer_div{ margin-bottom: 0px; }
         .footer_adv a img{ width: 35px; }
    }

        @media (max-width: 420px) {
            #top_arrow{ right: 3px; bottom: 25px; }

            .navbar{ width: 91%; }
            .ch_tool_btn a{ width: 45vw; }
            .bottom_tool{ width: 35px; }
            .container-fluid{ width: 91%; }
        }
  </style>


  <?php require '../../assets/php/navbar-ver.php';?>

   <!-- bottom 工具欄 -->
   <div class="bottom_tool">

  <button id="ph_nav_btn" class="hamburger hamburger--slider" type="button">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

   <div class="txt_big_btn">
   <a href="javascript:;">
     <span style="background-image: url(../../img/svg/block/zoom-in-block.svg); background-size: 63%; "></span>
   </a>
   </div>

    <a id="link_btn"  data-clipboard-text="<?php echo $URL;?>" href="javascript:;" onclick="ga('send', 'event', '連結分享', 'click', 'tool_bar')">
     <span style="background-image: url(../../img/svg/block/002-chain-links-block.svg); background-size: 60%; "></span>
    </a>

    <a id="qr_btn"  href="#qr_code_div" data-fancybox onclick="ga('send', 'event', 'QR code 分享', 'click', 'tool_bar')">
        <span style="background-image: url(../../img/svg/block/001-qr-code-block.svg); background-size: 60%; "></span>
    </a>

    <a target="_blank" href="https://www.google.com/maps/dir//<?php echo $map_txt;?>/@<?php echo $map_txt;?>,17z?hl=zh-TW" onclick="ga('send', 'event', 'google 導航', 'click', 'tool_bar')">
      <span style="background-image: url(../../img/svg/block/map-block.svg); background-size: 99%;"></span>
     </a>

     <a id="life_btn" href="javascript:;">
      <span style="background-image: url(../../img/svg/block/004-smiling-block.svg); background-size: 55%; "></span>
     </a>

     <a target="_blank" href="<?php echo $fb_txt;?>" onclick="ga('send', 'event', 'fb分享', 'click', 'tool_bar')">
      <span style="background-image: url(../../img/svg/block/facebook-logo-block.svg);  background-size: 92%;"></span>
     </a>

     <a target="_blank" href="<?php echo $line_txt;?>" onclick="ga('send', 'event', '加LINE或Line分享', 'click', 'tool_bar')">
      <span style="background-image: url(../../img/svg/block/line-block.svg); background-size: 75%; "></span>
     </a>
    
   	 <a href="tel:<?php echo $case['phone'];?>" onclick="ga('send', 'event', '撥打手機', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/block/007-phone-receiver-block.svg); background-size: 64%; "></span>
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