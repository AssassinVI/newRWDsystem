$(document).ready(function() {
  
  //指定視窗物件
  var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
  //目前畫面Div (預設 #case_di)
  var pcph_Div=$(window).width()>768 ? 'html,body' :'#case_div';
  var nowDiv=$(window).width()>768 ? 'html,body' :'#case_div';;
  //基本圖文-動態文字圖片
  wow = new WOW({ mobile: false } );
                    wow.init();
  


		// 巡覽列按鈕
		$('#ph_nav_btn').click(function(event) {
			if ($('#ph_nav_btn.is-active ').length<1) {
				$(this).addClass('is-active');
				$('.collapse').css('display', 'block');
				TweenMax.fromTo( '.collapse', 0.5, { opacity:0, top:70},{ opacity:1, top:0 });

        //-- 建案資訊 --
        if ($('#case_div').css('display')!='block') {

               $('#life_more_btn').css('display', 'inline-block');

               $('.ch_tool_btn a span').css('height', '0%');
               TweenMax.to( $('#case_btn').find('span'), 0.2, {height:'100%'});

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



    
    //---- 關閉巡覽列 ----
    if ($(window).width()<=768) {
     
      //---------------- 滑動關閉 -----------------
      $(document).on("scrollstart",function(){

      	 TweenMax.to( '.life_tool_div', 0.3, { opacity:0, bottom:0});
          setTimeout("$('.life_tool_div').css('display', 'none')", 500);
          TweenMax.to( '.more_tool_div', 0.3, { opacity:0, bottom:0});
         setTimeout("$('.more_tool_div').css('display', 'none')", 500);


        
      });


      $('#top_arrow, .ch_tool_btn, .txt_big_btn, #case_div, #news_div, #link_btn, #qr_btn, #life_btn0, #life_btn1, #more_btn').click(function(event) {
        $('#ph_nav_btn').removeClass('is-active');
        TweenMax.to( '.collapse', 0.5, { opacity:0, top:70});
        setTimeout("$('.collapse').css('display', 'none')", 500);
      });
    }



        // Top按鈕
        $('#top_arrow').click(function(event) {
            $(nowDiv).animate({
                scrollTop:0
            },1000);
        });

  

      

       //生活按鈕1-彈出----------------------
       $('#life_btn0').click(function(event) {
         
          if ($('.life_tool_div').css('display')=='none') {

             $('.life_tool_div').css('display', 'flex');
             $('.more_tool_div').css('display', 'none');

                 TweenMax.fromTo( '.life_tool_div', 0.3, { opacity:0, bottom:0},{ opacity:1, bottom:$('.bottom_tool').css('height').slice(0,-2)-3});


                   //-- 關閉提示 --
                   TweenMax.to('.life_prompt', 0.5, {opacity:0 });
                   TweenMax.to('.life_prompt', 0.1, {display:'none', delay:0.5});
                   TweenMax.to('.news_prompt', 0.5, {opacity:0});
                   TweenMax.to('.news_prompt', 0.1, {display:'none', delay:0.5});
          }
          else{
             TweenMax.to( '.life_tool_div', 0.3, { opacity:0, bottom:0});
             setTimeout("$('.life_tool_div').css('display', 'none')", 500);
          }
       });

       $('#life_more_btn').click(function(event) {
          $('#case_div').animate({
             scrollTop: $('#google_life').offset().top+$('#case_div').scrollTop()-$('html, body').scrollTop()-$('#top_navbar').height() //食醫住行位置+位移量-body位移量-navbar高度
         },1000);

           $('#more_life_div').css('display', 'flex');
           TweenMax.fromTo( '#more_life_div', 0.5, { opacity:0},{ opacity:1});
           $('#life_more i').addClass('fa-chevron-up');
           $('#life_more i').removeClass('fa-chevron-down');
           TweenMax.fromTo( '#life_more i', 1, { opacity:1, top:0 },{ opacity:0, top:-10, repeat:-1});
       });

       //-- 關閉 --
       $('#top_arrow, .ch_tool_btn, .txt_big_btn, #case_div, #news_div, #link_btn, #qr_btn, #life_btn, #more_btn, #ph_nav_btn').click(function(event) {
       	  TweenMax.to( '.life_tool_div', 0.3, { opacity:0, bottom:0});
          setTimeout("$('.life_tool_div').css('display', 'none')", 500);
       });


      //生活按鈕1-彈出 END----------------------

      //生活按鈕2-滑到指定位置------------------
       $('#life_btn1').click(function(event) {
         $('#case_div').animate({
             scrollTop: $('#google_life').offset().top+$('#case_div').scrollTop()-$('html, body').scrollTop()-$('#top_navbar').height() //食醫住行位置+位移量-body位移量-navbar高度
         },1000);

       });
      //生活按鈕2-滑到指定位置 END------------------

      //更多生活按鈕
      $('#life_more').click(function(event) {

        if ($('#more_life_div').css('display')=='none') {
          $('#more_life_div').css('display', 'flex');
          TweenMax.fromTo( '#more_life_div', 0.5, { opacity:0},{ opacity:1});
          $('#life_more i').addClass('fa-chevron-up');
          $('#life_more i').removeClass('fa-chevron-down');
          TweenMax.fromTo( '#life_more i', 1, { opacity:1, top:0 },{ opacity:0, top:-10, repeat:-1});

        }
        else{
          TweenMax.fromTo( '#more_life_div', 0.5, { opacity:1},{ opacity:0});
          setTimeout(function () {
            $('#more_life_div').css('display', 'none');
          },300);
          $('#life_more i').removeClass('fa-chevron-up');
          $('#life_more i').addClass('fa-chevron-down');
          TweenMax.fromTo( '#life_more i', 1, { opacity:1, top:0 }, { opacity:0, top:10, repeat:-1});
        }

      });
       //更多生活按鈕預設動畫
      TweenMax.fromTo( '#life_more i', 1,{ opacity:1, top:0 }, { opacity:0, top:10, repeat:-1});

      //--- 電腦食醫住行 按鈕特效 ---
      $('#pc_life_div a').mouseenter(function(event) {
         TweenMax.to( $(this), 0.3,{ width:70, right:20 });
         TweenMax.to( $(this).find('p'), 0.3,{ opacity:0 });
         TweenMax.to( $(this).find('img'), 0.3,{ opacity:1 });
      });

      $('#pc_life_div a').mouseleave(function(event) {
         TweenMax.to( $(this), 0.3,{ width:52, right:0 });
         TweenMax.to( $(this).find('p'), 0.3,{ opacity:1 });
         TweenMax.to( $(this).find('img'), 0.3,{ opacity:0 });
        
      });
      

      $('#pc_life_more').click(function(event) {
         $body.animate({
             scrollTop: $('#google_life').offset().top-$('#top_navbar').height() //食醫住行位置+位移量-body位移量-navbar高度
         },1000);

         if ($('#more_life_div').css('display')=='none') {
          $('#more_life_div').css('display', 'flex');
          TweenMax.fromTo( '#more_life_div', 0.5, { opacity:0},{ opacity:1});
          $('#life_more i').addClass('fa-chevron-up');
          $('#life_more i').removeClass('fa-chevron-down');
          TweenMax.fromTo( '#life_more i', 1, { opacity:1, top:0 },{ opacity:0, top:-10, repeat:-1});

        }
      });
        

		// ===== 建案資訊 ====
        $('#case_btn').click(function(event) {
        	if ($('#case_div').css('display')!='block') {

               $('#life_more_btn').css('display', 'inline-block');

               $('.ch_tool_btn a span').css('height', '0%');
               TweenMax.to( $(this).find('span'), 0.2, {height:'100%'});

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

            $('#life_more_btn').css('display', 'none');

            $('.ch_tool_btn a span').css('height', '0%');
            TweenMax.to( $(this).find('span'), 0.2, {height:'100%'});

        		$('#news_div').css('z-index', '2');
        		$('#case_div').css('z-index', '0');
        		TweenMax.fromTo( $('#news_div'), 0.5, {display:'none', left:'-100%'},{display:'block', left:'0%'});
        		TweenMax.to( $('#case_div'), 0.1, {display:'none',  delay:'0.5' });
            nowDiv='#news_div';

            //-- 關閉提示 --
                   TweenMax.to('.life_prompt', 0.5, {opacity:0 });
                   TweenMax.to('.life_prompt', 0.1, {display:'none', delay:0.5});
                   TweenMax.to('.news_prompt', 0.5, {opacity:0});
                   TweenMax.to('.news_prompt', 0.1, {display:'none', delay:0.5});
        	}
        });


		//放大鏡
		$('.txt_big_btn a').click(function(event) {
			var html_size=parseInt($('html').css('font-size').substr(0,2));
			if (html_size<16) {
				$('html').css('font-size', (html_size+2)+'px');
			}
			else{
				$('html').css('font-size', '12px');
			}
		});


		// 更多按鈕
		$('#more_btn').click(function(event) {
			// if ($('.more_tool_btn').css('display')=='none') {

			//    $('.more_tool_btn').css('display', 'block');
			//    $('.more_tool_btn').css('left', $(this).offset().left);
   //             TweenMax.fromTo( '#qr_btn', 0.5, { opacity:0, bottom:0},{ opacity:1, bottom:$('.bottom_tool').height()+30 });
   //             TweenMax.fromTo( '#link_btn', 0.5, { opacity:0, bottom:0},{ opacity:1, bottom:$('.bottom_tool').height()+60 });
			// }
			// else{
			//    TweenMax.to( '.more_tool_btn', 0.5, { opacity:0, bottom:0});
			//    setTimeout("$('.more_tool_btn').css('display', 'none')", 500);
			// }

		});

    // 更多按鈕2
    $('#more_btn').click(function(event) {
      if ($('.more_tool_div').css('display')=='none') {

         $('.more_tool_div').css('display', 'block');
         $('.life_tool_div').css('display', 'none');
          
          TweenMax.fromTo( '.more_tool_div', 0.3, { opacity:0, bottom:0},{ opacity:1, bottom:$('.bottom_tool').css('height').slice(0,-2)-3});
         
      }
      else{
         TweenMax.to( '.more_tool_div', 0.3, { opacity:0, bottom:0});
         setTimeout("$('.more_tool_div').css('display', 'none')", 500);
      }
    });

    //-- 關閉 --
       $('#top_arrow, .ch_tool_btn, .txt_big_btn, #case_div, #news_div, #link_btn, #qr_btn, #life_btn, #ph_nav_btn').click(function(event) {
       	 TweenMax.to( '.more_tool_div', 0.3, { opacity:0, bottom:0});
         setTimeout("$('.more_tool_div').css('display', 'none')", 500);
       });


    
    //-- 更多功能點擊後關閉 --
    $('.more_tool_btn').click(function(event) {

      if($('.more_tool_div').css('display')!='none'){
       // TweenMax.to( '.more_tool_div', 0.3, { opacity:0, bottom:0});
       // setTimeout("$('.more_tool_div').css('display', 'none')", 500);
      }
      else{
       // TweenMax.to( '.life_tool_div', 0.3, { opacity:0, bottom:0});
       // setTimeout("$('.life_tool_div').css('display', 'none')", 500);
      }
      
    });



    //-------- 複製連結 ------------
    new Clipboard('#link_btn');
    $('#link_btn').click(function(event) {
      alert('已複製連結!!');
    });
    


    // === 錨點 ===
    
    //-- 電腦 --
    if ($(window).width()>768){ 
       
       $('#navbarNavAltMarkup a').click(function(event) {
       var anchor_id=$(this).attr('anchor');
       $(pcph_Div).animate({
           scrollTop: $('#'+anchor_id).offset().top-$('#top_navbar').height()
       },1000);
    
     });
    }
    //-- 手機平板 --
    else{
       $('#navbarNavAltMarkup a').click(function(event) {
       var anchor_offset=$('#'+$(this).attr('anchor')).offset().top+$('#case_div').scrollTop()-$('html, body').scrollTop()-42; //錨點位置+位移量-body位移量-navbar高度
       
       $(pcph_Div).animate({
           scrollTop: anchor_offset
       },1000);
       
       
       //-- 關閉menu--
        $('#ph_nav_btn').removeClass('is-active');
        TweenMax.to( '.collapse', 0.5, { opacity:0, top:70});
        setTimeout("$('.collapse').css('display', 'none')", 500);
       });
    }

        
        // 橫式遮罩動畫
        TweenMax.fromTo( '.portrait', 2, { opacity:1},{ opacity:0, repeat:-1});


        //---------- 初始幻燈片 -------------
        // if ($('.swiper-container').length>0) {

        // 	var mySwiper = new Swiper ('.swiper-container', {
        // 	    loop: true,
        	   
        // 	    // 如果需要前进后退按钮
        // 	    navigation: {
        // 	      nextEl: '.swiper-button-next',
        // 	      prevEl: '.swiper-button-prev',
        // 	    }
        	    
        // 	  }); 
        // }


        //------ 初始圖片牆 ------
        if ($('.grid').length>0) {
        	$('.grid').isotope({
        	  // set itemSelector so .grid-sizer is not used in layout
        	  itemSelector: '.grid-item',
        	  percentPosition: true,
        	  masonry: {
        	      // use element for option
        	      columnWidth: '.grid-sizer'
        	    }
        	})
        }


        //--------- 初始Google地圖 -----------
        if ($('.map').length>0) {

        	$.fn.tinyMapConfigure({
        	'key': 'AIzaSyBmcZ9YTd68k4QYur5nowITqcI_kGZO5Ks'
        	});

        	$('.map').tinyMap({
            'center': $('.map').attr('location'),
            'zoom': 14,
            'marker': [{
                'addr': $('.map').attr('location'),
                'text': '<p style="font-size: 1.4rem;">'+document.title+'<br>'+$('.map').attr('loc_txt')+'</p>',
                
            }],
            'event': {
              'idle':{
                'func':function () {
                  var self = this;
                  $('.map').tinyMap('get', 'marker', function (markers) {
                    markers.forEach(function (marker) {
                      marker.infoWindow.open(self, marker);
                    });
                  });
                }
              }
            }
        });
        }


    //-------------- 聯絡我們 -------------
     if ($('.contact_us').length>0) {
       $('#sub_btn').click(function(event) {

        if (confirm('是否要送出訊息??')){
          var err_txt='';
          err_txt = err_txt + check_input( '#ca_name', '姓名，' );
          err_txt = err_txt + check_input( '#ca_mail', 'Email，' );
          err_txt = err_txt + check_input( '#ca_phone', '聯絡電話，' );
          err_txt = err_txt + check_input( '#ca_msg', '內容，' );

          if(err_txt!=''){
            alert("請輸入"+err_txt+"!!");
          }
          else if(check_word('#ca_name')){
            alert('請勿輸入特殊符號!');
          }
          else if(check_word('#ca_phone')){
            alert('請勿輸入特殊符號!');
          }
          else if(check_word('#ca_msg')){
            alert('請勿輸入特殊符號!');
          }
          else if(!check_email('#ca_mail')){
           alert('請輸入正確Email格式!');
         }
         else{
           $.ajax({
             url: '../../assets/php/call_ajax.php',
             type: 'POST',
             data: {
              name: $('#ca_name').val(),
              mail: $('#ca_mail').val(),
              phone: $('#ca_phone').val(),
              question: $('#ca_question').val(),
              subject: $('#ca_subject').val(),
              msg: $('#ca_msg').val(),
              case_name: document.title,
              case_id:$('#case_id').val(),
              send_list: $('#send_list').val()
            },
            success:function (data) {
              alert("感謝您的來信");
              document.getElementById("call_form").reset();
            }
           });
         }
        }//-- confirm END --
         
       });//-- click END --
     }



   //--------- 房貸試算 -------------
    if($('#math_years').length>0){

      for (var i = 5; i <= 40; i+=5) {
            $('#math_years').append('<option value="'+i+'">'+i+'年</option>');
        }

       //------ 試算按鈕 ------
       $("#enter_math").click(function(event) {

           $.fancybox.close();
           $.fancybox.open({
               src  : '#math_result',
               type : 'inline'
            });
        
         //年利率
         var one=parseFloat($("#one_math").val())/100;
         var two=parseFloat($("#two_math").val())/100;
         var three=parseFloat($("#three_math").val())/100;
         
         /* =========== 月利率 ============ */
         var avg_month1=one/12;
         var avg_month2=two/12;
         var avg_month3=three/12;

         /* ======================== 每月應付本息金額之平均攤還率 =========================== */
          var months=parseInt($("#math_years").val())*12 ;
          var avg1=avg_fun(avg_month1, months);
          var avg2=avg_fun(avg_month2, months);
          var avg3=avg_fun(avg_month3, months);

        /* ============================== 每期平均本息金額 ================================== */
        var total=parseInt($("#total").val());

        var avg_total_pay1=avg_total_pay(avg1,total);
        var avg_total_pay2=avg_total_pay(avg2,total);
        var avg_total_pay3=avg_total_pay(avg3,total);

        $("#avg_total_pay1").html(moneyFormat(avg_total_pay1.toString())+"<small>元/月</small>");
        $("#avg_total_pay2").html(moneyFormat(avg_total_pay2.toString())+"<small>元/月</small>");
        $("#avg_total_pay3").html(moneyFormat(avg_total_pay3.toString())+"<small>元/月</small>");

         /* =================================== 總還款金額 ====================================== */
         var pay1_total=avg_total_pay1*12;
         var pay2_total=avg_total_pay2*12;
         var pay3_total=avg_total_pay3*(months-24);
         var in_total=pay1_total+pay2_total+pay3_total;
         $("#total_pay").html(moneyFormat(in_total.toString())+"<small>元</small>");

         /* =================================== 總利息 ====================================== */
         var total=parseInt($("#total").val());
         var interest=in_total-total;
         $("#interest").html(moneyFormat(interest.toString())+"<small>元</small>");

         /* =========================== 平均利息 ==================================== */
         var avg_interest=parseInt(interest/months);
         $("#avg_interest").html(moneyFormat(avg_interest.toString())+"<small>元/月</small>");
         
         /*========================== 平均本金 ====================================*/
         var avg_principal=parseInt(total/months);
         $("#avg_principal").html(moneyFormat(avg_principal.toString())+"<small>元/月</small>");
      });

       //-- 重新試算 --
       // $('#reset_btn').click(function(event) {
       //     $.fancybox.close();
       //     $.fancybox.open({
       //         src  : '#math_count',
       //         type : 'inline'
       //     });
       // });

    }
      
    

    //-----橫式無效 ------
    $(window).on("orientationchange",function(event){
       
       //--- 橫式 ---
       if (event.orientation=='landscape') {
         $('.landscape_div').css('display', 'block');
       }
       //--- 直式 ---
       else{
         $('.landscape_div').css('display', 'none');
       }
    });
             
});


// ===== 網站加載完成後 =====
$(window).on('load', function(event) {
  
   TweenMax.to( '#nowLoading', 0.5, { opacity:0, 'z-index':-1});
    
    //-- 手機平板適用 --
    if ($(window).width()<=768) {

    	$(document).on("scrollstart",function(){
         	if ($('.navbar').css('top')!='0px') {
         		all_show();
         	}
         });


        setTimeout(function () {
        	if ($('.navbar').css('top')!='0px') {
        		all_show();
        	}
        }, 3000);
    }
       
        
});


//-- 顯示功能欄 --
function all_show() {

	/*-- 食醫住行+新聞提示 --*/
	TweenMax.to('.life_prompt', 0.5, {opacity:1, });
	TweenMax.to('.news_prompt', 0.5, {opacity:1, });

	var test1= $(window).width()==375 ? TweenMax.to('.life_prompt', 0.5, {bottom:110 ,repeat:-1, yoyo:true}) : TweenMax.to('.life_prompt', 0.5, {bottom:67 ,repeat:-1, yoyo:true});
	var test2= TweenMax.to('.news_prompt', 0.5, {top:51 ,repeat:-1, yoyo:true});
	//-- 五秒後消失 --
	TweenMax.to('.life_prompt', 0.5, {opacity:0, delay:5, display:'none'});
	TweenMax.to('.news_prompt', 0.5, {opacity:0, delay:5, display:'none'});
	setTimeout(function () { test1.kill(); test2.kill(); },5500);

	TweenMax.to('.navbar', 0.5, {top:0});
	TweenMax.to('.bottom_tool', 0.5, {bottom:0});
}
  



/*  每月應付本息金額之平均攤還率  */
   function avg_fun(avg_month, months) {
     /* ========== 月數 ================ */
      
     var avg1=Math.pow(1+avg_month, months)*avg_month;
     var avg2=Math.pow(1+avg_month, months)-1;
     var avg=avg1/avg2; 
     return avg;  
   }
 /* 每期平均本息金額 */  
   function avg_total_pay(avg,total) {
    var avg_total_pay=total*avg;
          avg_total_pay=parseInt(avg_total_pay);
         return avg_total_pay;
   }

/* 金錢格式 */
    function moneyFormat(str){
        if(str.length<=3)   return str;
        else    return moneyFormat(str.substr(0,str.length-3))+","+(str.substr(str.length-3));
    }

    // =============================== 檢查input ====================================
function check_input(id,txt) {

          if ($(id).attr('type')=='radio' || $(id).attr('type')=='checkbox') {
            
            if($(id+':checked').val()==undefined){
             $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }else{
            if ($(id).val()=='') {
              $(id).css('borderColor', 'red');
              return txt;
           }else{
              $(id).css('borderColor', 'rgba(0,0,0,0.1)');
              return "";
           }
          }
  }
  
  //-- 判斷特殊符號 --
  function check_word(id) {
     if($(id).val().search(/^(?:[^\~|\!|\#|\$|\%|\^|\&|\*|\(|\)|\=|\+|\{|\}|\[|\]|\"|\'|\<|\>]+)$/)==-1){
        $(id).css('borderColor', 'red');
        return true;
     }
     else{
        $(id).css('borderColor', 'rgba(0,0,0,0.1)');
       return false;
     }
  }
  
  //-- 判斷Email --
  function check_email(id) {
    if($(id).val().search(/^\w+(?:(?:-\w+)|(?:\.\w+))*\@\w+(?:(?:\.|-)\w+)*\.[A-Za-z]+$/)>-1){
        $(id).css('borderColor', 'rgba(0,0,0,0.1)');
        return true;
     }
     else{
        $(id).css('borderColor', 'red');
        return false;
     }
  }