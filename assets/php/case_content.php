<?php 

for ($i=0; $i < $fun_block_id_num; $i++) { 
	
	 $fun_type=substr($fun_block_id[$i]['fun_id'], 0,2);
	//------------ 基本圖文 --------------
	if ($fun_type=='bs') {
		$base_row=pdo_select("SELECT * FROM base_word WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

    //-- 判斷是否啟用 --
    if (empty($base_row['Tb_index'])) { continue; }

		$base_img=explode(',', $base_row['base_img']);
    $base_img_ph=explode(',', $base_row['base_img_ph']);
		$txt_fadein=empty($base_row['txt_fadein']) ? '': 'wow '.$base_row['txt_fadein'];
		$img_fadein=empty($base_row['img_fadein']) ? '': 'wow '.$base_row['img_fadein'];

    
   $back_img=empty($base_row['back_img']) ? '':'style="background-image: url(img/'.$base_row['back_img'].'); background-size:cover;"';
  
   $total_txt= '<div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 row no-gutters base_word" '.$back_img.'>';
   
   //-- 判斷是否左右編排  --
   $imgWord_col=$base_row['ImgWord_type']>2 ? '6':'12';

   //-- 排序(電腦) --
   $img_sort=$base_row['ImgWord_type']%2==1 ? 'order-lg-1':'order-lg-2';
   //-- 排序(手機) --
   $img_ph_sort=$base_row['ImgWord_ph_type']==1 ? 'order-1':'order-2';
   
    $img_txt='';
   //----------------- 手機圖片 --------------
    if (wp_is_mobile() && !empty($base_row['base_img_ph'])) {
      for ($j=0; $j <count($base_img_ph)-1 ; $j++) { 
       

        if ($base_row['zoomin_img']=='1') {
          $img_txt.= '
           <div class="col-md-'.$imgWord_col.' '.$img_fadein.' '.$img_sort.' '.$img_ph_sort.'">
             <a href="img/'.$base_img_ph[$j].'" data-fancybox>
               <img src="img/'.$base_img_ph[$j].'" alt="">
               <i class="fa fa-search-plus zoomin_img"></i>
             </a>
            </div>';
        }
        else{
         $img_txt.= '
           <div class="col-md-'.$imgWord_col.' '.$img_fadein.' '.$img_sort.' '.$img_ph_sort.'">
              <img src="img/'.$base_img_ph[$j].'" alt="">
            </div>';
        }
     }
    }
     //----------------- 電腦圖片 --------------
    else{
      for ($j=0; $j <count($base_img)-1 ; $j++) { 
       
        if ($base_row['zoomin_img']=='1') {
          $img_txt.= '
           <div class="col-md-'.$imgWord_col.' '.$img_fadein.' '.$img_sort.' '.$img_ph_sort.'">
             <a href="img/'.$base_img[$j].'" data-fancybox>
               <img src="img/'.$base_img[$j].'" alt="">
               <i class="fa fa-search-plus zoomin_img"></i>
             </a>
            </div>';
        }
        else{
         $img_txt.= '
           <div class="col-md-'.$imgWord_col.' '.$img_fadein.' '.$img_sort.' '.$img_ph_sort.'">
              <img src="img/'.$base_img[$j].'" alt="">
            </div>';
        }
        
     }
    }
		
    //-------------------------- 文字 -----------------------
    $word_txt='';
		if (!empty($base_row['aTitle']) || !empty($base_row['Title_two']) || !empty($base_row['content'])) {

      //-- 排序(電腦) --
       $word_sort=$base_row['ImgWord_type']%2==1 ? 'order-lg-2':'order-lg-1';
      //-- 排序(手機) --
       $word_ph_sort=$base_row['ImgWord_ph_type']==1 ? 'order-2':'order-1';

      $LeftRight_div= $base_row['ImgWord_type']>2 ? '<div class="center_div">' : '';

			$word_txt.= '
		    <div class="col-md-'.$imgWord_col.' '.$word_sort.' '.$word_ph_sort.' con_txt" >'.$LeftRight_div;

     
      if(!empty($base_row['aTitle'])){ 
        $word_txt.= '<h1 class="'.$txt_fadein.'">'.nl2br($base_row['aTitle']).'</h1>';
      }

      if (!empty($base_row['Title_two'])) {
        $word_txt.= '<h2 class="'.$txt_fadein.'">'.$base_row['Title_two'].'</h2>';
      }

      if (!empty($base_row['content'])) {
        
       $word_txt.= '<div class="'.$txt_fadein.'">'.$base_row['content'].'</div>';
      }

      $LeftRight_div= $base_row['ImgWord_type']>2 ? '</div>' : '';

    	$word_txt.= $LeftRight_div.'</div>';
		}


   //-------------------------- 圖文編排 ----------------------------
    $total_txt.=$img_txt.$word_txt;
    
  $total_txt.= '</div>';
	echo $total_txt;
	}

	//----------- 幻燈片 -----------
	elseif($fun_type=='ss'){
      $show_row=pdo_select("SELECT * FROM slideshow_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

      //-- 判斷是否啟用 --
      if (empty($show_row['Tb_index'])) { continue; }
      //-- 手機圖 --
      $show_img_ph=explode(',', $show_row['show_img_ph']);
      $show_img_ph_num=count($show_img_ph)-1;
      //-- 電腦圖 --
      $show_img=explode(',', $show_row['show_img']);
      $show_img_num=count($show_img)-1;

      //-- 判斷是否左右編排  --
      $imgWord_col=$show_row['ImgWord_type']>2 ? '6':'12';

      //-- 幻燈片排序(電腦) --
      $slider_sort=$show_row['ImgWord_type']%2==1 ? 'order-lg-1':'order-lg-2';
      //-- 幻燈片排序(手機) --
      $slider_ph_sort=$show_row['ImgWord_ph_type']==1 ? 'order-1':'order-2';

      //-- 內容排序(電腦) --
      $txt_sort=$show_row['ImgWord_type']%2==1 ? 'order-lg-2':'order-lg-1';
      //-- 內容排序(手機) --
      $txt_ph_sort=$show_row['ImgWord_ph_type']==1 ? 'order-2':'order-1';

      echo '
        <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 row no-gutters slideshow_tb">
          <div class="col-md-'.$imgWord_col.' '.$slider_sort.' '.$slider_ph_sort.'">
           <div class="swiper-container">
              <div class="swiper-wrapper">';

             if (wp_is_mobile() && !empty($show_row['show_img_ph'])){
               for ($j=0; $j < $show_img_ph_num; $j++) { 
                echo '<div class="swiper-slide"><img src="img/'.$show_img_ph[$j].'" alt=""></div>';
               } 
             }
             else{
               for ($j=0; $j < $show_img_num; $j++) { 
                echo '<div class="swiper-slide"><img src="img/'.$show_img[$j].'" alt=""></div>';
               } 
             }
             
       echo   '</div>
              <!-- 如果需要导航按钮 -->
              <div class="swiper-button-prev"><i class="fa fa-angle-left"></i></div>
              <div class="swiper-button-next"><i class="fa fa-angle-right"></i></div>
          </div>
        </div>';
        
        //-- 內容 --
        if (!empty($show_row['aTXT'])) {
          echo'
          <div class="col-md-'.$imgWord_col.' '.$txt_sort.' '.$txt_ph_sort.'">
           <div class="center_div con_txt">
           '.$show_row['aTXT'].'
           </div>
         </div>';
        }
        

      echo'</div>';

        //-- 內容 --



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
		
	         var myswiper = new Swiper("#'.$fun_block_id[$i]['fun_id'].' .swiper-container", {
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
       
       //-- 判斷是否啟用 --
       if (empty($youtube_row['Tb_index'])) { continue; }
       
       if ($youtube_row['video_type']=='0') {
       	    $you_adds=explode('v=', $youtube_row['you_adds']);
         	echo '
       	       <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 video-container youtube_tb">
       	        <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$you_adds[1].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
       	      </div>';
       }
       else{

       	  $autoPlay=$youtube_row['autoPlay']=='1' ? 'autoPlay':'';
           echo '
       	       <div class="col-md-12">
       	         <video style="width: 100%;" src="video/'.$youtube_row['video_file'].'" controls '.$autoPlay.'></video>
       	      </div>';
       } 
       
	}

	//-------------- 圖片牆 ----------------
	elseif($fun_type=='iw'){
       $img_wall_row=pdo_select("SELECT * FROM img_wall_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

       //-- 判斷是否啟用 --
      if (empty($img_wall_row['Tb_index'])) { continue; }

       $img_file=explode(',', $img_wall_row['img_file']);
       $img_file_num=count($img_file)-1;
       $img_item_arr=['grid-item--w-h2', 'grid-item--width2', 'grid-item--height2', '', 'grid-item--height2', '', 'grid-item--width2', ''];
       echo '
       <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 img_wall_tb">
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
     $li_row=pdo_select("SELECT * FROM life_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

     $life_location=empty($li_row['location']) ? $map_txt:$li_row['location'];
     
     switch ($li_row['color_type']) {
       case '0':
         $color_arr=['#3d3d3d', '#4d4d4d', '#3d3d3d', '#4d4d4d', '#3d3d3d', '#4d4d4d'];
         $img_dir='mapTool';
         $txt_color='#fff';
         $pc_a_back=['#3d3d3d', '#4d4d4d', '#3d3d3d', '#4d4d4d', '#3d3d3d', '#4d4d4d', '#3d3d3d'];
         break;
       case '1':
         $color_arr=['#303030', '#303030', '#303030', '#303030', '#303030', '#303030'];
         $img_dir='gold';
         $txt_color='#c8a062';
         $pc_a_back=['#303030', '#303030', '#303030', '#303030', '#303030', '#303030', '#303030'];
         break;
     }

      echo '
      <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 google_life_div">
        <div id="google_life" class="life_div row">
         <div id="base_life_div"  class="row no-gutters">
          <div id="gm_food_btn" style="background-color: '.$color_arr[0].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=food&keyword=餐廳&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'食\')">
              <img src="../../img/svg/'.$img_dir.'/food.svg" alt=""><p style="color:'.$txt_color.';">食</p>
            </a>
          </div>

          <div id="gm_hos_btn" style="background-color: '.$color_arr[1].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=doctor&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'醫\')">
              <img src="../../img/svg/'.$img_dir.'/hospital.svg" alt=""><p style="color:'.$txt_color.';">醫</p>
            </a>
          </div>

          <div id="gm_home_btn" style="background-color: '.$color_arr[2].';" class="col-4">
           <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=lodging&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'住\')">
             <img src="../../img/svg/'.$img_dir.'/home.svg" alt=""><p style="color:'.$txt_color.';">住</p>
           </a>
           </div>

          <div id="gm_work_btn" style="background-color: '.$color_arr[3].';" class="col-4">
             <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=bus_station&radius=500&zoom=16&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'行\')">
               <img src="../../img/svg/'.$img_dir.'/bus.svg" alt=""><p style="color:'.$txt_color.';">行</p>
             </a>
          </div>
          <div id="gm_school_btn" style="background-color: '.$color_arr[4].';" class="col-4">
             <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=school&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'育\')">
               <img src="../../img/svg/'.$img_dir.'/school.svg" alt=""><p style="color:'.$txt_color.';">育</p>
             </a>
          </div>
          <div id="gm_fun_btn" style="background-color: '.$color_arr[5].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=shopping_mall&keyword=&radius=2000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'樂\')">
             <img src="../../img/svg/'.$img_dir.'/shop.svg" alt=""><p style="color:'.$txt_color.';">樂</p>
            </a>
           </div>
          </div>

            
          
          <div id="more_life_div" class="row no-gutters">
          
          <div id="gm_school_btn" style="background-color: '.$color_arr[4].';" class="col-4">
             <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=park&radius=2000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'公園\')">
               <img src="../../img/svg/'.$img_dir.'/park.svg" alt=""><p style="color:'.$txt_color.';">公園</p>
             </a>
          </div>
          <div id="gm_hos_btn" style="background-color: '.$color_arr[1].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=cafe&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'咖啡店\')">
              <img src="../../img/svg/'.$img_dir.'/cafe.svg" alt=""><p style="color:'.$txt_color.';">咖啡店</p>
            </a>
          </div>
          <div id="gm_home_btn" style="background-color: '.$color_arr[2].';" class="col-4">
             <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=bank&radius=2000&zoom=16&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'銀行\')">
               <img src="../../img/svg/'.$img_dir.'/bank.svg" alt=""><p style="color:'.$txt_color.';">銀行</p>
             </a>
          </div>
          <div id="gm_work_btn" style="background-color: '.$color_arr[3].';" class="col-4">
             <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=convenience_store&radius=1000&zoom=16&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'商店\')">
               <img src="../../img/svg/'.$img_dir.'/store.svg" alt=""><p style="color:'.$txt_color.';">商店</p>
             </a>
          </div>
          <div id="gm_food_btn" style="background-color: '.$color_arr[0].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=gas_station&radius=2000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'加油站\')">
              <img src="../../img/svg/'.$img_dir.'/gas-station.svg" alt=""><p style="color:'.$txt_color.';">加油站</p>
            </a>
          </div>
          
          <div id="gm_fun_btn" style="background-color: '.$color_arr[5].';" class="col-4">
            <a data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=pharmacy&keyword=&radius=2000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'藥局\')">
             <img src="../../img/svg/'.$img_dir.'/pharmacy.svg" alt=""><p style="color:'.$txt_color.';">藥局</p>
            </a>
           </div>
          </div>

          <a id="life_more" href="javascript:;"><i style="color:'.$txt_color.';" class="fa fa-chevron-down"></i></a>

        </div>
      </div>

      <div id="pc_life_div">
         <a style="background-color:'.$pc_a_back[0].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=food&keyword=餐廳&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'食\')">
              <img src="../../img/svg/'.$img_dir.'/food.svg" alt=""><p style="color:'.$txt_color.';">食</p>
         </a>

         <a style="background-color:'.$pc_a_back[1].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=doctor&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'醫\')">
              <img src="../../img/svg/'.$img_dir.'/hospital.svg" alt=""><p style="color:'.$txt_color.';">醫</p>
         </a>

         <a style="background-color:'.$pc_a_back[2].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=lodging&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'住\')">
             <img src="../../img/svg/'.$img_dir.'/home.svg" alt=""><p style="color:'.$txt_color.';">住</p>
         </a>

         <a style="background-color:'.$pc_a_back[3].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=bus_station&radius=500&zoom=16&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'行\')">
               <img src="../../img/svg/'.$img_dir.'/bus.svg" alt=""><p style="color:'.$txt_color.';">行</p>
          </a>

          <a style="background-color:'.$pc_a_back[4].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=school&radius=1000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'育\')">
               <img src="../../img/svg/'.$img_dir.'/school.svg" alt=""><p style="color:'.$txt_color.';">育</p>
          </a>

         <a style="background-color:'.$pc_a_back[5].'; border: 1px solid '.$txt_color.';" data-fancybox data-type="iframe" data-src="../../googleMapTool/googlemap_place.php?place_loc='.$life_location.'&type=shopping_mall&keyword=&radius=2000&zoom=14&case_name='.$case['aTitle'].'" href="javascript:;" onclick="ga(\'send\', \'event\', \'食醫住行\', \'click\', \'樂\')">
             <img src="../../img/svg/'.$img_dir.'/shop.svg" alt=""><p style="color:'.$txt_color.';">樂</p>
          </a>

          <a style="background-color:'.$pc_a_back[6].'; border: 1px solid '.$txt_color.';" id="pc_life_more" href="javascript:;">
            <img src="../../img/svg/'.$img_dir.'/new_more.png" alt=""><p style="color:'.$txt_color.'; font-weight: 600;">....</p>
          </a>
      </div>
      ';

	}
    
    //-------------- Google Map ----------------
	elseif($fun_type=='gm'){
       $gm_row=pdo_select("SELECT * FROM googlemap_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

       //-- 判斷是否啟用 --
      if (empty($gm_row['Tb_index'])) { continue; }

       echo '
       <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 googleMap_div">';

      if (!empty($gm_row['aTitle'])) {
      	echo '<h1>'.$gm_row['aTitle'].'</h1>';
       }

      echo' 
        <div class="map" location="'.$gm_row['location'].'" loc_txt="'.$gm_row['loc_txt'].'"></div>
        <a target="_blank" class="map_placeholder" href="https://www.google.com/maps/dir//'.$gm_row['location'].'/@ '.$gm_row['location'].',17z/?hl=zh-TW" onclick="ga(\'send\', \'event\', \'google 導航\', \'click\', \'tool_bar\')">
          <img src="../../img/svg/gps.svg" alt=""> 導航
        </a>
      </div>';
       
	}

	//-------------- 聯絡我們 ----------------
	elseif($fun_type=='ca'){
      $call_row=pdo_select("SELECT * FROM call_us_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

      //-- 判斷是否啟用 --
      if (empty($call_row['Tb_index'])) { continue; }

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


      echo '<div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 contact_us_div">
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
                  <textarea class="form-control" placeholder="Message" id="ca_msg" style="height: 180px;"></textarea>
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
     <div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12 math_count_div">

        <div id="math_count" >
         <h1>房貸試算</h1>
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
            <div class="col-sm-12 text-center">
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
              
            </div>
          </div>
        </div>
      </div>';
  }

  //-------------- 錨點 ----------------
  elseif($fun_type=='an'){
     
     $anchor_row=pdo_select("SELECT * FROM anchor_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);
     //-- 判斷是否啟用 --
     if (empty($anchor_row['Tb_index'])) { continue; }
     
     echo '<span id="'.$anchor_row['Tb_index'].'" class="anchor"></span>';
  }


  //-------------- 自訂區塊 ----------------
  elseif($fun_type=='ot'){
    
     $other_row=pdo_select("SELECT * FROM other_tb WHERE Tb_index=:Tb_index AND OnLineOrNot='1'", ['Tb_index'=>$fun_block_id[$i]['fun_id']]);

     //-- 判斷是否啟用 --
     if (empty($other_row['Tb_index'])) { continue; }

     echo '<div id="'.$fun_block_id[$i]['fun_id'].'" class="col-md-12">';
     echo $other_row['content'];
     echo '</div>';
  }
}
?>
