<?php 

for ($i=0; $i < $fun_block_id_num; $i++) { 
	
	 $fun_type=substr($fun_block_id[$i]['fun_id'], 0,2);
	//------------ 基本圖文 --------------
	if ($fun_type=='bs') {
		$base_row=pdo_select("SELECT * FROM base_word WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
		$base_img=explode(',', $base_row['base_img']);
		$txt_fadein=empty($base_row['txt_fadein']) ? '': 'wow '.$base_row['txt_fadein'];
		$img_fadein=empty($base_row['img_fadein']) ? '': 'wow '.$base_row['img_fadein'];
		for ($j=0; $j <count($base_img)-1 ; $j++) { 
			echo '
			 <div class="col-md-12 '.$img_fadein.'">
    			<img src="img/'.$base_img[$j].'" alt="">
    		</div>';
		}

		if (!empty($base_row['aTitle']) || !empty($base_row['Title_two']) || !empty($base_row['content'])) {
			echo '
		    <div class="col-md-12 con_txt">
    			<h1 class="'.$txt_fadein.'">'.$base_row['aTitle'].'</h1>
    			<h2 class="'.$txt_fadein.'">'.$base_row['Title_two'].'</h2>
    			<div>
    			  '.$base_row['content'].'
    			</div>
    		</div>';
		}
		
	}

	//----------- 幻燈片 -----------
	elseif($fun_type=='ss'){
      $show_row=pdo_select("SELECT * FROM slideshow_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
      $show_img=explode(',', $show_row['show_img']);
      $show_img_num=count($show_img)-1;

      echo '
        <div class="col-md-12">
          <div id="'.$fun_block_id[$i]['fun_id'].'" class="swiper-container">
              <div class="swiper-wrapper">';

             for ($j=0; $j < $show_img_num; $j++) { 
             	echo '<div class="swiper-slide"><img src="img/'.$show_img[$j].'" alt=""></div>';
             } 
             
       echo   '</div>
              
              <!-- 如果需要导航按钮 -->
              <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
              <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
             
          </div>
        </div>';


        $play_speed=!empty($show_row['play_speed']) ? 'autoplay : { delay:'. $show_row['play_speed'] .' },' : '';

        if ($show_row['effect']=='coverflow') {
        	$ph_rotate=check_mobile() ? '90' : '50';
        	$effect='effect: "'. $show_row['effect'].'",
        	         coverflow:{
        	         	rotate: '.$ph_rotate.',
                        stretch: 110,
                        depth: 500,
                        modifier: 1,
                        slideShadows : true
        	         },';
        }
        elseif(!empty($show_row['effect'])){
           $effect='effect: "'. $show_row['effect'].'",';
        }
        else{ $effect=''; }


     echo '
		<script type="text/javascript">
	       $(window).on("load", function(event) {
		
	         var myswiper = new Swiper("#'.$fun_block_id[$i]['fun_id'].'", {
	             speed: 1500,
	             '.$play_speed.'
	             '.$effect.'
	             loop: true,

	             // 如果需要前进后退按钮
         	    navigation: {
         	      nextEl: ".swiper-button-next",
         	      prevEl: ".swiper-button-prev",
         	    }
	         });
	
	        });
        </script>';
      
	}
    
    //----------- Youtube -----------
	elseif($fun_type=='yu'){
       $youtube_row=pdo_select("SELECT * FROM youtube_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
       
       if ($youtube_row['video_type']=='0') {
       	    $you_adds=explode('v=', $youtube_row['you_adds']);
         	echo '
       	       <div class="col-md-12 video-container">
       	        <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$you_adds[1].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
       	      </div>';
       }
       else{

       	  $autoPlay=$youtube_row['autoPlay']=='1' ? 'autoPlay':'';
           echo '
       	       <div class="col-md-12 video-container">
       	         <video src="video/'.$youtube_row['video_file'].'" controls '.$autoPlay.'></video>
       	      </div>';
       } 
       
	}

	//-------------- 圖片牆 ----------------
	elseif($fun_type=='iw'){
       $img_wall_row=pdo_select("SELECT * FROM img_wall_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

       $img_file=explode(',', $img_wall_row['img_file']);
       $img_file_num=count($img_file)-1;
       $img_item_arr=['grid-item--w-h2', 'grid-item--width2', 'grid-item--height2', '', 'grid-item--height2', '', 'grid-item--width2', ''];
       echo '
       <div class="col-md-12">
        <div class="grid">
          <div class="grid-sizer" ></div>';
          
       for ($j=0; $j <$img_file_num ; $j++) { 
       	 echo '<div class="grid-item '.$img_item_arr[$j].' " style="background-image: url(img/'.$img_file[$j].');"><a href="img/'.$img_file[$j].'" data-fancybox="groups"></a></div>';
       } 

     echo'</div>
      </div>';
       
	}

	//-------------- 食醫住行 ----------------
	elseif($fun_type=='li'){

      echo '
      <div class="col-md-12">
        <div id="google_life" class="life_div row">
          <div id="gm_food_btn" class="col-4">
            <a href="../../googleMapTool/googlemap_place.php?place_loc='.$map_txt.'&type=food&keyword=餐廳&radius=1000&zoom=14&case_name='.$case['aTitle'].'">
              <img src="../../img/svg/mapTool/food_black.svg" alt=""><p>食</p>
            </a>
          </div>
          <div id="gm_hos_btn" class="col-4">
            <a href="../../googleMapTool/googlemap_place.php?place_loc='.$map_txt.'&type=doctor&radius=1000&zoom=14&case_name='.$case['aTitle'].'">
              <img src="../../img/svg/mapTool/hospital_black.svg" alt=""><p>醫</p>
            </a>
          </div>
          <div id="gm_home_btn" class="col-4"><a href="https://www.google.com/maps/dir//'.$map_txt.'/@ '.$map_txt.',17z/?hl=zh-TW"><img src="../../img/svg/mapTool/home_black.svg" alt=""><p>住</p></a></div>
          <div id="gm_work_btn" class="col-4">
             <a href="../../googleMapTool/googlemap_place.php?place_loc='.$map_txt.'&type=bus_station&radius=500&zoom=16&case_name='.$case['aTitle'].'">
               <img src="../../img/svg/mapTool/bus_black.svg" alt=""><p>行</p>
             </a>
          </div>
          <div id="gm_school_btn" class="col-4">
             <a href="../../googleMapTool/googlemap_place.php?place_loc='.$map_txt.'&type=school&radius=1000&zoom=14&case_name='.$case['aTitle'].'">
               <img src="../../img/svg/mapTool/school_black.svg" alt=""><p>育</p>
             </a>
          </div>
          <div id="gm_fun_btn" class="col-4">
            <a href="../../googleMapTool/googlemap_place.php?place_loc='.$map_txt.'&type=shopping_mall&keyword=&radius=2000&zoom=14&case_name='.$case['aTitle'].'">
             <img src="../../img/svg/mapTool/shop_black.svg" alt=""><p>樂</p>
            </a>
           </div>
        </div>
      </div>';

	}
    
    //-------------- Google Map ----------------
	elseif($fun_type=='gm'){
       $gm_row=pdo_select("SELECT * FROM googlemap_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

       echo '
       <div class="col-md-12 googleMap_div">';

      if (!empty($gm_row['aTitle'])) {
      	echo '<h1>'.$gm_row['aTitle'].'</h1>';
       }

      echo' 
        <div class="map" location="'.$gm_row['location'].'" loc_txt="'.$gm_row['loc_txt'].'"></div>
        <a target="_blank" class="map_placeholder" href="https://www.google.com/maps/dir//'.$gm_row['location'].'/@ '.$gm_row['location'].',17z/?hl=zh-TW">
          <img src="../../img/svg/gps.svg" alt=""> 導航-星晴天接待會館位置
        </a>
      </div>';
       
	}

	//-------------- 聯絡我們 ----------------
	elseif($fun_type=='ca'){
      $call_row=pdo_select("SELECT * FROM call_us_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

      $send_name=explode(',', $call_row['re_name']);
      $send_mail=explode(',', $call_row['re_mail']);
      $send_name_num=count($send_name);
      $send_list=[];
      for ($j=0; $j <$send_name_num ; $j++) { 
      	if (!empty($send_name[$j])) {
      		array_push($send_list, $send_name[$j].','.$send_mail[$j]);
      	}
      }
      $send_list=implode('||', $send_list);


      echo '<div class="col-md-12">
        <div class="contact_us">
          <h1>'.$call_row['btn_name'].'</h1>
          <form id="call_form">
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">姓名：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="ca_name" placeholder="name">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">電子郵件：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="ca_mail" placeholder="E-mail">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">電話：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="ca_phone" placeholder="Phone">
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">問題類別：</label>
                <div class="col-sm-10">
                  <select class="form-control" id="ca_question">
                    <option value="客戶意見留言">客戶意見留言</option>
                    <option value="建案相關">建案相關</option>
                    <option value="其他">其他</option>
                  </select>
                </div>
              </div>
              <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">主旨：</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="ca_subject" placeholder="Subject">
                </div>
              </div>
               <div class="form-group row no-gutters">
                <label  class="col-sm-2 col-form-label">內容：</label>
                <div class="col-sm-10">
                  <textarea class="form-control" placeholder="Message" id="ca_msg" style="height: 200px;"></textarea>
                </div>
              </div>
              <div class="form-group row no-gutters">
                <div class="col-sm-12 contact_btn_div" >
                  <button id="sub_btn" type="button" class="btn btn-info btn-lg">發送訊息</button>
                </div>
              </div>
              <input type="hidden" id="send_list" value="'.$send_list.'">
              <input type="hidden" id="case_id" value="case'.$Tb_index[2].'">
          </form>
        </div>
      </div>';
	}


  //-------------- 房貸試算 ----------------
  elseif($fun_type=='ma'){
     
     echo '
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
      </div>';
  }

  //-------------- 錨點 ----------------
  elseif($fun_type=='an'){
     
     $anchor_row=pdo_select("SELECT * FROM anchor_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
     echo '<span id="'.$anchor_row['Tb_index'].'" class="anchor"></span>';
  }


  //-------------- 自訂區塊 ----------------
  elseif($fun_type=='ot'){
    
     $other_row=pdo_select("SELECT * FROM other_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
     echo '<div class="col-md-12">';
     echo $other_row['content'];
     echo '</div>';
  }
}
?>
