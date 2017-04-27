jQuery(function($){

    $(window).load(function(){
        $('.page_preloader').delay(600).fadeOut(600);
    });

    $('html').removeClass('no-js'); 

    $('ul.styles > li').click(function(){
        var className = $(this).attr('class');
        $('body').removeClass('theme-style-0 theme-style-1 theme-style-2 theme-style-3');
        $('body').addClass(className);
      });


    /* placeholder js */
    $('[placeholder]').each(function(){
      if ($(this).val() === '') {
        var hint = $(this).attr('placeholder');
        $(this).val(hint).addClass('hint');
      }
    });

    $('[placeholder]').focus(function() {
      if ($(this).val() === $(this).attr('placeholder')) {
        $(this).val('').removeClass('hint');
      }
    }).blur(function() {
      if ($(this).val() === '') {
        $(this).val($(this).attr('placeholder')).addClass('hint');
      }
    });                    


    /* form validation */
    $('input.error, textarea.error').focus(function() {
      $(this).removeClass('error');
    });

    $('form :submit').click(function() {
      $(this).parents('form').find('input.hint, textarea.hint').each(function() {
        $(this).val('').removeClass('hint');
      });
      return true;
    });

   
    /* FORM STYLES */  
    $('.address_table form, .customer_address form').addClass('form-horizontal');


    /* ALERTS */
    $('.template-customers-login, #create_customer').find('.errors').addClass('alert').addClass('alert-danger');


	/* CUSTOM SELECTS */
    $('.header_currency select, #navigation select').styler();
    $('.jq-selectbox__trigger').append('<i class="fa fa-angle-down"></i>');


    /* MEGAMENU DESKTOP */
    $('.sf-menu').superfish({
        animation: {height: 'show'},
        speed: 'fast'
    });

    var path = window.location.pathname.split('/');
    path = path[path.length-1];
    if (path !== undefined) {
      $("ul.sf-menu > li").children("a[href$='" + path + "']").parents('li').children('a').addClass('active');
    };

    var path2 = window.location.pathname;
  	if (path2 == '/' || path == undefined) {
      $("ul.sf-menu > li").children("a[href$='" + path2 + "']").parents('li').children('a').addClass('active');
    };


    /* MEGAMENU MOBILE */
    $(document).ready(function(){
        $(".megamenu_mobile h2").click(function(){
            $(".submenu__1").slideToggle("slow");
            $(this).toggleClass("active");
        });

        $(".submenu__1 > li > a > i").click(function(){
            $(this).parent().parent().find(".submenu__2").slideToggle("slow");
            $(this).parent().toggleClass("active");
            return false;
        });

        $(".submenu__2 > li > a > i").click(function(){
            $(this).parent().parent().find(".submenu__3").slideToggle("slow");
            $(this).parent().toggleClass("active");
            return false;
        });

        $('.megamenu_mobile h2').on('click touchstart', function(e){
          	e.stopPropagation();
        });

        $(document).on('click', function(){
            $(".submenu__1").slideUp("slow");
            $(".megamenu_mobile").find("h2").removeClass("active");
        });
    });


    /* STICK MENU */
    $(document).ready(function(){
      	$('#megamenu').tmStickUp();
    });

  	/* MAIN PRODUCT LISTING IMAGE CHANGE */
    $(document).ready(function(){
        if (device.desktop()) {
            $(".img_change").hover(function(){
                $(this).find(".img__2").stop().animate({"opacity": 1});
            },function(){
                $(this).find(".img__2").stop().animate({"opacity": 0});
            });
        };
    });

if(device.desktop()){
  	$(".instagram_wr").addClass('act');
}



});