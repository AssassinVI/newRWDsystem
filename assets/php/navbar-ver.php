<nav id="top_navbar" class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
	 

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
	  	<a id="case_btn" href="javascript:;">建案資訊 <span style="height: 100%;"></span></a>
	  	<a id="news_btn" href="javascript:;">媒體報導 <span></span></a>
	  </div>


  </div>
	</nav>