<div class="footer">

            <div>
               <strong><?php echo $company['name'] ?> Admin </strong> - Copyright ©<?php echo $company['remark'] ?>
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="../../js/jquery-2.1.1.js"></script>
<script src="../../js/jquery-ui-1.10.4.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../../js/inspinia.js"></script>
<script src="../../js/plugins/pace/pace.min.js"></script>

<!-- CKeditor -->
<script src="../../js/plugins/ckeditor/ckeditor.js"></script>
<!-- <script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script> -->

<!-- twzipcode -->
<script src="../../js/plugins/twzipcode/jquery.twzipcode.js"></script>

<!-- AJAX File -->
<script src="../../js/ajaxfileupload.js"></script>

<!-- C3 Chart -->
<script src="../../js/plugins/c3/c3.min.js"></script>
<script src="../../js/plugins/c3/d3.min.js"></script>

<!-- dataTables -->
<script type="text/javascript" charset="utf8" src="../../js/jquery.dataTables.js"></script>

<!-- FancyBox -->
<script type="text/javascript" src="../../js/plugins/fancyBox/jquery.fancybox.js"></script>

<!-- 漂亮拉bar -->
<script type="text/javascript" src="../../js//plugins/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- 超強動畫庫 -->
<script  src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>

</script>

<script type="text/javascript">

//-- 過時自動登出 ---
$(document).ready(function() {
   $(document).mousemove(function(event) {
    session_replay();
  });

  $(document).mousedown(function(event) {
    session_replay();
  });
});

var t;
function session_replay() {
  clearTimeout(t);
    t=setTimeout(function () {
    alert('您以登出，請重新登入');
    location.replace('../../login.php');
  },1440*1000);
}


if ($('#ckeditor').length>0) {
  	CKEDITOR.replace('ckeditor',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php?case_id=<?php echo $_GET['Tb_index']?>',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php?case_id=<?php echo $_GET['Tb_index']?>', height:300});
  }

if ($('#ckeditor1').length>0) {
    CKEDITOR.replace('ckeditor1',{filebrowserUploadUrl:'../../js/plugins/ckeditor/php/upload.php?case_id=<?php echo $_GET['Tb_index']?>',filebrowserImageUploadUrl : '../../js/plugins/ckeditor/php/upload_img.php?case_id=<?php echo $_GET['Tb_index']?>', height:300});
  }

	/* ==================== 基本AJAX 新增，修改，刪除 ======================= */
	function ajax_in(url, data, alert_txt ,replace) {
		$.ajax({
			url: url,
			type: 'POST',
			data: data,
			success:function () {
        if (alert_txt!='no') { alert(alert_txt); }
				if (replace!='no') { location.replace(replace); }
			}
		});
	}

	/* ===================== AJAX檔案上傳 ======================== */
	function ajax_file(url, file_id, show_id) {

		$.ajaxFileUpload({
              url: url,
              secureuri: false, //是否需要安全協議
              fileElementId: file_id, //上傳input元件ID
              dataType: 'json',
              success: function (data, status) {  //服务器成功响应处理函数

                  alert('檔案儲存');
              }
		});
	}


 /* ========================== 預覽影片方法 ============================= */
 function video_load(controller,html_id) {

            var file=controller.files[0];
             if (file==null) {
                $(html_id).html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){
               // $(html_id).attr('src', this.result);
                $(html_id).html(' <video controls src="'+this.result+'"></video>');
             }
            };
          }


 /* ========================== 預覽音樂方法 ============================= */
 function audio_load(controller,html_id) {

            var file=controller.files[0];
             if (file==null) {
                $(html_id).html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file);
                fileReader.onload = function(event){
               // $(html_id).attr('src', this.result);
                $(html_id).html(' <audio controls src="'+this.result+'"></audio>');
             }
            };
          }


 /* ========================== 預覽圖片方法 ============================= */
 function file_viewer_load_new(controller,html_id) {
            $(html_id).html('');
            var file=controller.files;
            for (var i = 0; i < file.length; i++) {

             if (file[i]==null) {

                 $(html_id).html('');
             }
             else{
                var fileReader= new FileReader();
                fileReader.readAsDataURL(file[i]);
                fileReader.onload = function(event){

                //$(html_id).attr('src', this.result);
                var file_name=controller.value.split('\\');
                var type=file_name[2].split('.');
                var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;

                if (re.exec(file_name[2])) {
                    var result=this.result;
                  }else{
                    var result='../../img/other_file_img/file.svg';
                  }

           var html_txt='<img id="one_img" src="'+result+'" alt="請上傳代表圖檔">';


              $(html_id).append(html_txt);
             }
            }
          }

}

/*  */
function save_img_btn(ajax_php, file_id) {
  ajax_file(ajax_php, file_id, '#one_img');
  //$('.img_check').css('display', 'block');
}

/* ======================== 重設表單 ========================== */
function clean_all() {
   if (confirm("是否要重設表單??")) {
      window.location.reload();
   }
}

/* ===================== 燈箱 =================== */
$(".fancybox").fancybox();


</script>