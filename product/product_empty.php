<?php 
  require '../../sys/core/inc/config.php';
  require '../../sys/core/inc/function.php';
  
  $URL='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $Tb_index=explode('/', $_SERVER['REQUEST_URI']);
  $case=pdo_select('SELECT * FROM build_case WHERE Tb_index=:Tb_index', ['Tb_index'=>$Tb_index[2]] );
?>

<!DOCTYPE html>
<html lang="zh-tw">
<head>
	<meta charset="UTF-8">
	<title><?php echo $Tb_index[2];?></title>
	<meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0" />
  <!-- FACEBOOK 分享資訊 -->
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:url" content="" />
  <meta itemprop="image" property="og:image" content="" />
  <meta property="og:type" content="website" />
  <meta name="description" content="" />
  <meta name="Author" content="聯創數位整合" />
  <meta name="keywords" content="" />

    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/hamburgers.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Swiper -->
    <link rel="stylesheet" type="text/css" href="../../assets/js/plugins/swiper/swiper.min.css">
    <!-- FancyBox -->
    <link rel="stylesheet" type="text/css" href="../../assets/js/plugins/fancybox/jquery.fancybox.min.css">

    <link rel="stylesheet" type="text/css" href="../../assets/css/horizontal.css">

</head>

<body>
   <!-- Top按鈕 -->
   <a id="top_arrow" href="javascript:;" style="background-image: url(../../img/svg/up-arrow.svg); "></a>

  <!-- 橫式遮罩 -->
  <div class="landscape_div">
    <div>
      <!-- <i class="fa fa-mobile landscape"></i> -->
      <i class="fa fa-mobile portrait"></i>
     <p>畫面不支援，請改用直式</p> 
    </div>
  </div>
    
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
	      <a class="nav-item nav-link" href="javascript:;" anchor="anchor1" index="">幸福建築</a>
	      <a class="nav-item nav-link" href="javascript:;" anchor="anchor2" index="">精彩南崁</a>
	      <a class="nav-item nav-link" href="javascript:;" anchor="anchor3" index="">繁華城市</a>
        <a class="nav-item nav-link" href="javascript:;" anchor="anchor4" index="">接待會館</a>
        <a class="nav-item nav-link" href="javascript:;" anchor="anchor5" index="">禮賓專線</a>
	    </div>
	  </div>

	  <div class="ch_tool_btn">
	  	<a id="case_btn" href="javascript:;">合雄星期天 <span style="height: 100%;"></span></a>
	  	<a id="news_btn" href="javascript:;">媒體報導 <span></span></a>
	  </div>

	  <div class="txt_big_btn">
	  	<a href="javascript:;"><i class="fa fa-search-plus"></i></a>
	  </div>
  </div>

	</nav>
   
   <!-- bottom 工具欄 -->
   <div class="bottom_tool">
   	 <a href="tel:033479656" onclick="ga('send', 'event', 'phone_btn', 'click', 'tool_bar')">
   	 	<span style="background-image: url(../../img/svg/007-phone-receiver.svg); background-size: 64%; background-color: #FFC107;"></span><br>電話
   	 </a>
   	 <a href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/006-line.svg); background-size: 75%; background-color: #52CB34;"></span><br>LINE
   	 </a>
   	 <a href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/facebook-logo.svg); background-color: #576ba8; background-size: 92%;"></span><br>FB
   	 </a>
   	 <a id="life_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/004-smiling-emoticon-square-face.svg); background-size: 55%; background-color: #FFC107;"></span><br>生活
   	 </a>
   	 <a href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/003-google.svg); background-size: 99%;"></span><br>地圖
   	 </a>
   	 <a id="more_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/3point.svg); background-size: 60%; background-color: #FFC107;"></span><br>更多
   	 </a>

   	 <a id="link_btn" class="more_tool_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/002-chain-links.svg); background-size: 60%; background-color: #FFC107;"></span>
   	 </a>
   	 <a id="qr_btn" class="more_tool_btn" href="javascript:;">
   	 	<span style="background-image: url(../../img/svg/001-qr-code.svg); background-size: 60%; background-color: #FFC107;"></span>
   	 </a>

   </div>
    
    <!-- 建案資訊 -->
    <div id="case_div" class="container-fluid">
    	<div class="row no-gutters">
    		<div class="col-md-12">
    			<img src="img/LOGO.jpg" alt="">
    		</div>
    		<div class="col-md-12 con_txt">
    			<h1>2015精彩在南崁</h1>
    			<h2>就地崛起的全民移居熱點 城市資源超豐厚，居家環境更優質</h2>
    			<p>
    				嶄新的桃園第六都，隨著城市升格促使各大資源湧入，統籌分配款增加，社會配套福利提升 重大建設更是陸續成型其中集合，交通、自然、消費、教育 等多項優質機能的南崁區域勢必將成為下一個全民矚目的移居新舞台！
    			</p>
    		</div>
        <span id="anchor1" class="anchor"></span>
    		<div class="col-md-12">
    			<img src="img/bs20160801002_1.jpg" alt="">
    		</div>
        
        <span id="anchor2" class="anchor"></span>
      <!-- swiper -->
        <div class="col-md-12">
          <div class="swiper-container">
              <div class="swiper-wrapper">
                  <div class="swiper-slide"><img src="img/slider1.jpg" alt=""></div>
                  <div class="swiper-slide"><img src="img/slider2.jpg" alt=""></div>
                  <div class="swiper-slide"><img src="img/slider3.jpg" alt=""></div>
                  <div class="swiper-slide"><img src="img/slider4.jpg" alt=""></div>
                  <div class="swiper-slide"><img src="img/slider5.jpg" alt=""></div>
              </div>
              
              <!-- 如果需要导航按钮 -->
              <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
              <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
             
          </div>
        </div>

      <!-- Youtube -->
      <div class="col-md-12 video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/EubkbKRKwKw?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
      </div>
      <span id="anchor3" class="anchor"></span>
      <!-- 圖片牆 -->
      <div class="col-md-12">
        <div class="grid">
          <div class="grid-sizer" ></div>
          <div class="grid-item grid-item--w-h2 " style="background-image: url(img/slider2.jpg);"><a href="img/slider2.jpg" data-fancybox="groups"></a></div>
          <div class="grid-item grid-item--width2" style="background-image: url(img/slider3.jpg);"><a href="img/slider3.jpg" data-fancybox="groups"></a></div>
          <div class="grid-item grid-item--height2" style="background-image: url(img/slider4.jpg);"><a href="img/slider4.jpg" data-fancybox="groups"></a></div>
          <div class="grid-item" style="background-image: url(img/slider5.jpg);"><a href="img/slider5.jpg" data-fancybox="groups"></a></div>
           <div class="grid-item grid-item--height2" style="background-image: url(img/slider6.jpg);"><a href="img/slider6.jpg" data-fancybox="groups"></a></div>
           <div class="grid-item" style="background-image: url(img/slider7.jpg);"><a href="img/slider7.jpg" data-fancybox="groups"></a></div>
           <div class="grid-item grid-item--width2" style="background-image: url(img/slider8.jpg);"><a href="img/slider8.jpg" data-fancybox="groups"></a></div>
           <div class="grid-item " style="background-image: url(img/slider1.jpg);"><a href="img/slider1.jpg" data-fancybox="groups"></a></div>
        </div>
      </div>

      <div class="col-md-12">
        <div id="google_life" index="" class="life_div row">
          <div id="gm_food_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/food_black.svg" alt=""><p>食</p></a></div>
          <div id="gm_hos_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/hospital_black.svg" alt=""><p>醫</p></a></div>
          <div id="gm_home_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/home_black.svg" alt=""><p>住</p></a></div>
          <div id="gm_work_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/bus_black.svg" alt=""><p>行</p></a></div>
          <div id="gm_school_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/school_black.svg" alt=""><p>育</p></a></div>
          <div id="gm_fun_btn" class="col-4"><a href="#"><img src="../../img/svg/mapTool/shop_black.svg" alt=""><p>樂</p></a></div>
        </div>
      </div>
     <span id="anchor4" class="anchor"></span>
     <!-- GoogleMap -->
      <div class="col-md-12">
        <div class="map"></div>
        <a target="_blank" class="map_placeholder" href="https://www.google.com/maps/dir//25.0386187,121.29350729999999/@ 25.0386187,121.29350729999999,17z/?hl=zh-TW">
          <img src="../../img/svg/gps.svg" alt=""> 導航-星晴天接待會館位置
        </a>
      </div>
      
      <span id="anchor5" class="anchor"></span>
      <!-- 聯絡我們 -->
      <div class="col-md-12">
        <div class="contact_us">
          <h1>聯絡我們</h1>
          <form>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">姓名：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  placeholder="name">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">電子郵件：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  placeholder="E-mail">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">電話：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  placeholder="Phone">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">問題類別：</label>
                <div class="col-sm-10">
                  <select class="form-control">
                    <option value="客戶意見留言">客戶意見留言</option>
                    <option value="建案相關">建案相關</option>
                    <option value="其他意見">其他意見</option>
                  </select>
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">主旨：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control"  placeholder="Subject">
                </div>
              </div>
               <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">內容：</label>
                <div class="col-sm-10">
                  <textarea class="form-control" placeholder="Message" style="height: 200px;"></textarea>
                </div>
              </div>
              <div class="form-group row no-gutters">
                <div class="col-sm-12 contact_btn_div" >
                  <button type="button" class="btn btn-info btn-lg">發送訊息</button>
                </div>
              </div>
          </form>
        </div>
      </div>


      <!-- 房貸試算 -->
      <div class="col-md-12">
      	<a href="#math_count" data-fancybox class="btn btn-info btn-lg btn-block open_math_btn">房貸試算</a>

        <div id="math_count" style="width: 700px; margin: auto; display: none;">
          <div class="form-group row no-gutters">
            <label  class="col-sm-3 col-form-label">貸款總額：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="total">
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-3 col-form-label">貸款年限：</label>
            <div class="col-sm-9">
              <select class="form-control " id="math_years">
                
              </select>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-3 col-form-label">第一年房貸利率：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control"  id="one_math" placeholder="百分比">
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-3 col-form-label">第二年房貸利率：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control"  id="two_math" placeholder="百分比">
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-3 col-form-label">第三年房貸利率：</label>
            <div class="col-sm-9">
              <input type="text" class="form-control"  id="three_math" placeholder="百分比">
            </div>
          </div>
          <div class="form-group row no-gutters">
            <div class="col-sm-12 text-right">
              <button id="enter_math" type="button" class="btn btn-info btn-lg ">試算</button>
            </div>
          </div>
        </div>

        <div id="math_result" style="width: 700px; margin: auto; display: none;">
          <h2>試算結果</h2>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">總還款金額:</label>
            <div class="col-sm-8">
              <p id="total_pay"></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">總還利息:</label>
            <div class="col-sm-8">
              <p id="interest" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">每期平均本金:</label>
            <div class="col-sm-8">
              <p id="avg_principal" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">每期平均利息:</label>
            <div class="col-sm-8">
              <p id="avg_interest" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">第一年平均本息金額: </label>
            <div class="col-sm-8">
              <p id="avg_total_pay1" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">第二年平均本息金額: </label>
            <div class="col-sm-8">
              <p id="avg_total_pay2" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <label  class="col-sm-4 col-form-label">第三年平均本息金額: </label>
            <div class="col-sm-8">
              <p id="avg_total_pay3" ></p>
            </div>
          </div>
          <div class="form-group row no-gutters">
            <div class="col-sm-12">
              <p class="math_ state" >*本表僅提供試算 <br> 實際貸款數字仍需以申貸銀行為準</p>
              <button id="reset_btn" type="button" class="btn btn-default btn-lg ">重新試算</button>
            </div>
          </div>
        </div>
      </div>

     

     <!-- Footer -->
      <div class="col-md-12">
      	 <div class="footer_div">
    	    <span>合雄星晴天 </span>
    	    <span><i class="fa fa-home"></i> 水岸花城 . 純住新樂園｜24~48坪</span>
    	    <span><i class="fa fa-home"></i> 接待會館：南福街187號 . 光明郵局旁</span>
    	    <span><i class="fa fa-phone"></i> 禮賓專線：03-222-8388</span>
    	  </div>
      </div>


    

    	</div>
    </div>





    <!-- 新聞內容 -->
    <div id="news_div" class="container-fluid ">
      <div class="row no-gutters">
        <div class="col-md-12">
          <img src="img/LOGO.jpg" alt="">
        </div>
        <div class="col-md-12 news_list">
          <ul>
            <li>
              <div class="row">
                <div class="col-2"><span>SEP<br><b>01</b><br>2018</span></div>
                <div class="col-10">
                  <h4><a href="https://tw.news.yahoo.com/">親戚合購房產 轉讓後協議仍有效</a></h4>
                  <p>居住在紐約的華裔民眾常常會眾多親屬一起集資購房，隨著近幾年房地產價格攀升，早一批購房的華裔逐漸將名下房產轉移給子女。布碌崙伍先生(化名)一家正是這種情況，但他們擔心轉移給子女後，當... <a href="https://tw.news.yahoo.com/">More</a></p>
                </div>
              </div>
            </li>
            <li>
              <div class="row">
                <div class="col-2"><span>SEP<br><b>01</b><br>2018</span></div>
                <div class="col-10">
                  <h4><a href="https://tw.news.yahoo.com/">親戚合購房產 轉讓後協議仍有效</a></h4>
                  <p>居住在紐約的華裔民眾常常會眾多親屬一起集資購房，隨著近幾年房地產價格攀升，早一批購房的華裔逐漸將名下房產轉移給子女。布碌崙伍先生(化名)一家正是這種情況，但他們擔心轉移給子女後，當... <a href="https://tw.news.yahoo.com/">More</a></p>
                </div>
              </div>
            </li>
            <li>
              <div class="row">
                <div class="col-2"><span>SEP<br><b>01</b><br>2018</span></div>
                <div class="col-10">
                  <h4><a href="https://tw.news.yahoo.com/">親戚合購房產 轉讓後協議仍有效</a></h4>
                  <p>居住在紐約的華裔民眾常常會眾多親屬一起集資購房，隨著近幾年房地產價格攀升，早一批購房的華裔逐漸將名下房產轉移給子女。布碌崙伍先生(化名)一家正是這種情況，但他們擔心轉移給子女後，當... <a href="https://tw.news.yahoo.com/">More</a></p>
                </div>
              </div>
            </li>
            <li>
              <div class="row">
                <div class="col-2"><span>SEP<br><b>01</b><br>2018</span></div>
                <div class="col-10">
                  <h4><a href="https://tw.news.yahoo.com/">親戚合購房產 轉讓後協議仍有效</a></h4>
                  <p>居住在紐約的華裔民眾常常會眾多親屬一起集資購房，隨著近幾年房地產價格攀升，早一批購房的華裔逐漸將名下房產轉移給子女。布碌崙伍先生(化名)一家正是這種情況，但他們擔心轉移給子女後，當... <a href="https://tw.news.yahoo.com/">More</a></p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
	

<script type="text/javascript" src="../../assets/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
<!-- 超強動畫庫 -->
<script  src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
<!-- Swiper -->
<script type="text/javascript" src="../../assets/js/plugins/swiper/swiper.min.js"></script>
<!-- isotope -->
<script type="text/javascript" src="../../assets/js/plugins/isotope/isotope.pkgd.min.js"></script>
<!-- FancyBox -->
<script type="text/javascript" src="../../assets/js/plugins/fancybox/jquery.fancybox.min.js"></script>
<!-- Google Map -->
<script type="text/javascript" src="../../assets/js/plugins/tinyMap/jquery.tinyMap.js"></script>
<script type="text/javascript" src="../../assets/js/horizontal.js"></script>
</body>
</html>