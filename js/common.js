$(function(){
  //スムーススクロール
  var windowWidth = $(window).width();
  var windowSm = 899; // スマホに切り替わる横幅
  if (windowWidth <= windowSm) {
    var headerHight = 65; // スマホのヘッダー等の高さ分の数値を入れる
  } else {
    var headerHight = 129; // PC のヘッダー等の高さ分の数値を入れる
  }
  jQuery('a[href^="#"]').click(function() {
    var speed = 550;
    var href = jQuery(this).attr("href");
    var target = jQuery(href == "#" || href == "" ? "html" : href);
    var position = target.offset().top - headerHight;
    jQuery("body,html").animate({ scrollTop: position }, speed, "swing");
    return false;
  });
  var urlHash = location.hash;
  if(urlHash) {
    jQuery('body,html').stop().scrollTop(0);
    setTimeout(function(){
      var target = jQuery(urlHash);
      var position = target.offset().top - headerHeight;
      jQuery('body,html').stop().animate({scrollTop:position}, 500);
    }, 200);
  }
  //fix_hd
  $(window).on('load scroll', function() {
    if ($(this).scrollTop() > 48) {//170
      $('body,header').addClass('fix_hd');
      //$('header').fadeOut();
    } else {
      $('body,header').removeClass('fix_hd');
      //$('header').fadeIn();
    }
  });
  //page_top
  $("#page_top , #filter_btn_sp").hide();
  //$("#filter_btn_sp").hide();
  $(window).on("scroll", function() {
    if ($(this).scrollTop() > 150) {
      $("#page_top").fadeIn();
    } else {
      $("#page_top").fadeOut();
    }
    if ($(this).scrollTop() > 150) {
      $("#filter_btn_sp").fadeIn();
    } else {
      $("#filter_btn_sp").fadeOut();
    }
    ///
    var scrollHeight = '';
    var scrollPosition = '';
    var footHeight = '';//copy_area
    scrollHeight = $(document).height(); //ドキュメントの高さ
    scrollPosition = $(window).height() + $(window).scrollTop(); //現在地
    footHeight = $("#page_top_area").innerHeight(); //footerの高さ（＝止めたい位置）
    if ( scrollHeight - scrollPosition  <= footHeight ) { //ドキュメントの高さと現在地の差がfooterの高さ以下になったら
      $("#page_top , #filter_btn_sp").css({
        "position":"absolute", //pisitionをabsolute（親：wrapperからの絶対値）に変更
        "bottom": footHeight + 10 //下からfooterの高さ + 10px上げた位置に配置
      });
    } else { //それ以外の場合は
      $("#page_top , #filter_btn_sp").css({
        "position":"fixed", //固定表示
        "bottom": "10px" //下から10px上げた位置に
      });
    }
    ///
  });
  //utility
  $("header .utility li.nv_search .form_inner").on("mouseleave", function(event) {
    event.stopPropagation();
  });
  $("header .utility li.nv_login div.login .login_inner .btm form").on("mouseleave", function(event) {
    event.stopPropagation();
  });
  $("header .utility li.nv_favorite div.login .login_inner .btm form").on("mouseleave", function(event) {
    event.stopPropagation();
  });
  //utility子メニュー開閉
  var $subNv = $('.child_nv');
  $('._jsChildNv').hover(
    function(){
      $(this).find($subNv).stop().fadeIn();
      $(".header_bg").stop().fadeIn();
    },
    function(){
      $subNv.stop().fadeOut();
      $(".header_bg").stop().fadeOut();
    }
  );
  //グローバルメニュー開閉
  $('#gnavi>ul>li').has('.gn_child').hover(function() {
    $(".sp_menu_bg").stop().fadeIn();
    $(this).find('.gn_child').addClass('bg_height');
    $(this).find('.gn_inner').addClass('bg_height');
    $(this).append('<div class="gn_child_full"></div>');
    var pop_height = $(this).find('.gn_child.bg_height').height();
    $('.gn_child_full').css('height', pop_height);
  }, function () {
    $(".sp_menu_bg").stop().fadeOut();
    $(this).find('.gn_child').removeClass('bg_height');
    $(this).find('.gn_inner').removeClass('bg_height');
    $('.gn_child_full').css({'height':'0px','padding-bottom':'0px','border-bottom':'none'}).fadeOut('10000').queue(function() {
      this.remove();
    });
  });
  //スクロールの挙動をしたらグローバルメニュー閉じる
  $(window).on('scroll', function() {
    if ($('.gn_child').hasClass('bg_height')) {
      $(".gn_child").removeClass('bg_height');
      $(".gn_inner").removeClass('bg_height');
      $(".sp_menu_bg").stop().fadeOut();
      $('.gn_child_full').css({'height':'0px','padding-bottom':'0px','border-bottom':'none'}).fadeOut('10000').queue(function() {
        this.remove();
      });
    } else {
    }
  });
  //アコーディオン開閉
  $(".ft_navi .navi_set .aco_ttl").on("click", function() {
    $(this).next().stop().slideToggle();
    $(this).toggleClass("change");
    //$(this).find(".cross_icon").stop().toggleClass('change');
  });
  $(".sp_menu .navi_set .aco_ttl").on("click", function() {
    $(this).next().stop().slideToggle();
    $(this).toggleClass("change");
  });
  $("#top_aco_navi .navi_set .aco_ttl").on("click", function() {
    $(this).next().stop().slideToggle();
    $(this).toggleClass("change");
  });
  $(".side_block .block.aco .aco_ttl").on("click", function() {
    $(this).next().stop().slideToggle();
    $(this).toggleClass("open");
  });
  //sp search
  $(".utility_sp .nv_search").on("click", function() {
    $("#sp_menu_area .sp_search").fadeToggle();
    //$("#sp_menu_area .sp_menu_bg").fadeToggle();
    $(this).toggleClass("open");
    //off
    $("#sp_menu_area .sp_menu").fadeOut();
    $('.hamburger_btn_box .menu_btn').removeClass("change");
    //page_top
    if ($('#page_top').css('display') == 'block') {
      // 表示されている場合の処理
      $('#page_top').addClass("none");
    } else {
      // 非表示の場合の処理
      if ($("#sp_menu_area .sp_menu").css('display') == 'block') {
        $('#page_top').addClass("none");
      } else {
        $('#page_top').removeClass("none");
      }
    }
    //filter_btn_sp
    if ($('#filter_btn_sp').css('display') == 'block') {
      // 表示されている場合の処理
      $('#filter_btn_sp').addClass("none");
    } else {
      // 非表示の場合の処理
      if ($("#sp_menu_area .sp_menu").css('display') == 'block') {
        $('#filter_btn_sp').addClass("none");
      } else {
        $('#filter_btn_sp').removeClass("none");
      }
    }
    return false;
  });
  $("#sp_menu_area .sp_search .close_btn").on("click", function() {
    $("#sp_menu_area .sp_search").fadeOut();
    //$("#sp_menu_area .sp_menu_bg").fadeOut();
    $(".utility_sp .nv_search").removeClass("open");
    $('#page_top').removeClass("none");
    $('#filter_btn_sp').removeClass("none");
    return false;
  });
  //sp menu
  $('.hamburger_btn_box').on('click', function() {
    $("#sp_menu_area .sp_menu").fadeToggle();
    $("body").toggleClass('sp_open');
    $(this).find('.menu_btn').toggleClass("change");
    //off
    $("#sp_menu_area .sp_search").fadeOut();
    $(".utility_sp .nv_search").removeClass("open");
    //page_top
    if ($('#page_top').css('display') == 'block') {
      // 表示されている場合の処理
      $('#page_top').addClass("none");
    } else {
      // 非表示の場合の処理
      if ($('#sp_menu_area .sp_search').css('display') == 'block') {
        $('#page_top').addClass("none");
      } else {
        $('#page_top').removeClass("none");
      }
    }
    //filter_btn_sp
    if ($('#filter_btn_sp').css('display') == 'block') {
      // 表示されている場合の処理
      $('#filter_btn_sp').addClass("none");
    } else {
      // 非表示の場合の処理
      if ($('#sp_menu_area .sp_search').css('display') == 'block') {
        $('#filter_btn_sp').addClass("none");
      } else {
        $('#filter_btn_sp').removeClass("none");
      }
    }
  });
  $("#sp_menu_area .sp_menu .close_btn").on("click", function() {
    $("#sp_menu_area .sp_menu").fadeOut();
    $('.hamburger_btn_box .menu_btn').removeClass("change");
    $("body").removeClass("sp_open");
    $('#page_top').removeClass("none");
    $('#filter_btn_sp').removeClass("none");
    return false;
  });
  //トピックスボタン
  $("._jsTopiBtn").on("click", function() {
    if ($('#top_topics .topics_list').hasClass('full')) {
      $('#top_topics .topics_list').removeClass('full');
      $('._jsTopiBtn').html('<span>もっと見る</span>');
    } else {
      $('#top_topics .topics_list').addClass('full');
      $('._jsTopiBtn').html('<a href="#top_topics">閉じる</a>');
    }
  });
  //itemlist
  $(".itemlist_intro .conditions ul li span.close").on("click", function() {
    $(this).parent().remove();
  });
  $(".itemlist .itemlist_set .img_box .favorite").on("click", function() {
    $(this).toggleClass('faved');
  });
  //variation for itemlist
  $(".itemlist_set .img_box a img").hover(function () {
    var varie = $(this).parents('a').children('.varie');
    varie.stop().fadeIn(300);
    $(this).mousemove(function (e) {
      varie.css({
        'top': e.offsetY - 130,//50
        'left': e.offsetX + 50//50
      });
    });
  }, function () {
    var varie = $(this).parents('a').children('.varie');
    varie.stop().fadeOut(300);
  });
  //variation for itemlist TOP用
  $(".newarrivals_row .item a .item_inner .img_box img").hover(function () {
    var varie = $(this).parents('a').find('.varie');
    varie.stop().fadeIn(300);
    $(this).mousemove(function (e) {
      varie.css({
        'top': e.offsetY - 130,//50
        'left': e.offsetX + 50//50
      });
    });
  }, function () {
    var varie = $(this).parents('a').find('.varie');
    varie.stop().fadeOut(300);
  });
  //件数切り替え
  $(".cnt_switch_panel ul li.cnt60").on("click", function() {
    if ($(this).hasClass('current')) {
    } else {
      $(".cnt_switch_panel ul li").removeClass('current');
      $(this).addClass('current');
      //$(".itemlist .itemlist_block").addClass('column1');
    }
  });
  $(".cnt_switch_panel ul li.cnt120").on("click", function() {
    if ($(this).hasClass('current')) {
    } else {
      $(".cnt_switch_panel ul li").removeClass('current');
      $(this).addClass('current');
      //$(".itemlist .itemlist_block").removeClass('column1');
    }
  });
  //サイド
  $(document).on("click", ".side_block .block .cat .toggle:not('.open') span", function () {
    //$(".side_block .block .cat .toggle").removeClass('open');//add
    $(this).parent('.toggle').addClass('open').children('.furl').slideDown();
  });
  $(document).on("click", ".side_block .block .cat .toggle.open span", function () {
    $(this).parent('.toggle').removeClass('open').children('.furl').slideUp();
  });
  setTimeout(function(){
    $(".side_block .block .cat .toggle:not('.open') .furl").hide();
  },50);
  //カラー サイド
  $(document).on("click", ".side_block .block .colorlist ul li", function () {
    $(".side_block .block .colorlist ul li").removeClass('selected');
    $(this).addClass('selected');
  });
  $(document).on("click", ".side_block .block .colorlist li.reset", function () {
    $(".side_block .block .colorlist ul li").removeClass('selected');
  });
  $(document).on("click", ".side_block .block li .func:not('.active')", function () {
    if($(this).closest("ul.furl").length > 0){
      if($(this).closest("ul.cat").length > 0){
        $(this).closest("ul.cat").find(".active").removeClass('active').children().remove();
        $(this).addClass('active').append('<span class="close"></span>');
      } else {
        $(this).closest("ul").find(".active").removeClass('active').children().remove();
        $(this).addClass('active').append('<span class="close"></span>');
      }
    } else {
      $(this).addClass('active').append('<span class="close"></span>');
    }
  });
  //add すべて以外をclickした場合 →active非表示
  $(document).on("click", ".side_block .block .cat .toggle .furl li .func:not('.active')", function () {
    if ($('.side_block .block .cat .toggle').hasClass('none')) {
      $('.side_block .block .cat .none .func').removeClass('active');
    } else {
    }
  });
  //add .noneをclickした場合 →.cat .toggle配下active非表示
  $(document).on("click", ".side_block .block .cat .toggle.none .func:not('.active')", function () {
    if ($('.side_block .block .cat .toggle .furl li .func').hasClass('active')) {
      $('.side_block .block .cat .toggle .furl li .func').removeClass('active');
    } else {
    }
  });
  //close
  $(document).on("click", ".side_block .block li .func.active .close", function () {
    if($(this).closest("ul.cat").length > 0){
      $(this).parent().removeClass('active');
      $(this).remove();
      $('.side_block .block h2.cat').removeClass('active');
    } else {
      $(this).parent().removeClass('active');
      $(this).remove();
    }
  });
 //
  $(document).on("click", ".sp_panels .colorlist li.color", function () {
    var pcolor = $(this).find('span').text();
    $('.sp_panels #first .cells .cell.value p.select').html(pcolor).css({'color':'#222222'});
    $(".sp_panels .colorlist li.color").removeClass('selected');
    $(this).toggleClass('selected');
  });
  $(document).on("click", ".sp_panels .colorlist li.reset", function () {
    $(".sp_panels .colorlist li.color").removeClass('selected');
    $('.sp_panels #first .cells .cell.value p.select').html('指定なし').css({'color':'#808080'});
  });
  //アクション部
  $(".sp_panels .action ul li.reset").click(function () {
    $('.sp_panels .colorlist li').removeClass('selected');
    $(".sp_panels #first .cells .cell.value.cat").text('指定なし').css({'color':'#808080'});
    $(".sp_panels #first .cells .cell.value.brand").text('指定なし').css({'color':'#808080'});
    //add08
    $(".sp_panels #first .cells .cell.value.gender").text('指定なし').css({'color':'#808080'});
    $(".sp_panels #first .cells .cell.value.sports").text('指定なし').css({'color':'#808080'});
    $(".sp_panels #first .cells .cell.value.size").text('指定なし').css({'color':'#808080'});
    $('.sp_panels #first .cells .cell.value p.select').html('指定なし').css({'color':'#808080'});
  });
  //スクロール 共通
  ///アコ用
  //add08
  $('.scroll_cat .toggle , .scroll_brand .toggle , .scroll_gender .toggle , .scroll_sports .toggle , .scroll_size .toggle').on('click',function(){
    //$(this).toggleClass('open');
    //$(this).find('.ul_wrap').slideToggle();
  });




  //スクロール firstカテ
  $(".sp_panels #first .cells .cell.value.cat").on('click',function(){
    $('.scroll_first_cat').removeClass('is-hide');
  });
  $(".scroll_first_cat .return").on('click',function(){
    $('.scroll_first_cat').addClass('is-hide');//上の戻るボタン
  });
  ///テキストデフォルトに戻す
  $(".scroll_first_cat .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });

  //スクロール secondカテ
  //ウェア
  $(".sp_panels #first .scroll_first_cat ul li .value.wear").on('click',function(){
    $('.scroll_cat_wear').removeClass('is-hide');
  });
  $(".scroll_cat_wear .return").on('click',function(){
    $('.scroll_cat_wear').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_wear .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_wear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_wear .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_wear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //セットアップ
  $(".sp_panels #first .scroll_first_cat ul li .value.setup").on('click',function(){
    $('.scroll_cat_setup').removeClass('is-hide');
  });
  $(".scroll_cat_setup .return").on('click',function(){
    $('.scroll_cat_setup').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_setup .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_setup').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_setup .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_setup').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //アウター
  $(".sp_panels #first .scroll_first_cat ul li .value.outer").on('click',function(){
    $('.scroll_cat_outer').removeClass('is-hide');
  });
  $(".scroll_cat_outer .return").on('click',function(){
    $('.scroll_cat_outer').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_outer .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_outer').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_outer .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_outer').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //セーター
  $(".sp_panels #first .scroll_first_cat ul li .value.sweater").on('click',function(){
    $('.scroll_cat_sweater').removeClass('is-hide');
  });
  $(".scroll_cat_sweater .return").on('click',function(){
    $('.scroll_cat_sweater').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_sweater .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_sweater').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_sweater .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_sweater').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //スウェット
  $(".sp_panels #first .scroll_first_cat ul li .value.sweat").on('click',function(){
    $('.scroll_cat_sweat').removeClass('is-hide');
  });
  $(".scroll_cat_sweat .return").on('click',function(){
    $('.scroll_cat_sweat').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_sweat .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_sweat').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_sweat .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_sweat').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //シャツ
  $(".sp_panels #first .scroll_first_cat ul li .value.shirt").on('click',function(){
    $('.scroll_cat_shirt').removeClass('is-hide');
  });
  $(".scroll_cat_shirt .return").on('click',function(){
    $('.scroll_cat_shirt').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_shirt .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_shirt').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_shirt .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_shirt').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //パンツ
  $(".sp_panels #first .scroll_first_cat ul li .value.pants").on('click',function(){
    $('.scroll_cat_pants').removeClass('is-hide');
  });
  $(".scroll_cat_pants .return").on('click',function(){
    $('.scroll_cat_pants').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_pants .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_pants').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_pants .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_pants').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //ワンピース
  $(".sp_panels #first .scroll_first_cat ul li .value.onepiece").on('click',function(){
    $('.scroll_cat_onepiece').removeClass('is-hide');
  });
  $(".scroll_cat_onepiece .return").on('click',function(){
    $('.scroll_cat_onepiece').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_onepiece .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_onepiece').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_onepiece .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_onepiece').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //スイムウェア
  $(".sp_panels #first .scroll_first_cat ul li .value.swimwear").on('click',function(){
    $('.scroll_cat_swimwear').removeClass('is-hide');
  });
  $(".scroll_cat_swimwear .return").on('click',function(){
    $('.scroll_cat_swimwear').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_swimwear .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_swimwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_swimwear .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_swimwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //レインウェア
  $(".sp_panels #first .scroll_first_cat ul li .value.rainwear").on('click',function(){
    $('.scroll_cat_rainwear').removeClass('is-hide');
  });
  $(".scroll_cat_rainwear .return").on('click',function(){
    $('.scroll_cat_rainwear').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_rainwear .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_rainwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_rainwear .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_rainwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //アンダーウェア
  $(".sp_panels #first .scroll_first_cat ul li .value.underwear").on('click',function(){
    $('.scroll_cat_underwear').removeClass('is-hide');
  });
  $(".scroll_cat_underwear .return").on('click',function(){
    $('.scroll_cat_underwear').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_underwear .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_underwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_underwear .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_underwear').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //シューズ
  $(".sp_panels #first .scroll_first_cat ul li .value.shoes").on('click',function(){
    $('.scroll_cat_shoes').removeClass('is-hide');
  });
  $(".scroll_cat_shoes .return").on('click',function(){
    $('.scroll_cat_shoes').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_shoes .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_shoes').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_shoes .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_shoes').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //バッグ
  $(".sp_panels #first .scroll_first_cat ul li .value.bag").on('click',function(){
    $('.scroll_cat_bag').removeClass('is-hide');
  });
  $(".scroll_cat_bag .return").on('click',function(){
    $('.scroll_cat_bag').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_bag .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_bag').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_bag .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_bag').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //小物
  $(".sp_panels #first .scroll_first_cat ul li .value.accessories").on('click',function(){
    $('.scroll_cat_accessories').removeClass('is-hide');
  });
  $(".scroll_cat_accessories .return").on('click',function(){
    $('.scroll_cat_accessories').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_accessories .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_accessories').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_accessories .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_accessories').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });
  //その他
  $(".sp_panels #first .scroll_first_cat ul li .value.other").on('click',function(){
    $('.scroll_cat_other').removeClass('is-hide');
  });
  $(".scroll_cat_other .return").on('click',function(){
    $('.scroll_cat_other').addClass('is-hide');//上の戻るボタン
  });
  $(".scroll_cat_other .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_other').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#333333'});
  });
  $(".scroll_cat_other .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_cat_other').addClass('is-hide');
    //first
    $('.scroll_first_cat').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.cat").text(valueText).css({'color':'#808080'});
  });


  //スクロール ブランド
  ///表示
  $(".sp_panels #first .cells .cell.value.brand").on('click',function(){
    $('.scroll_brand').removeClass('is-hide');
  });
  $(".scroll_brand .return").on('click',function(){
    $('.scroll_brand').addClass('is-hide');//上の戻るボタン
  });
  ///テキストいれる
  $(".scroll_brand .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_brand').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.brand").text(valueText).css({'color':'#333333'});
  });
  ///テキストデフォルトに戻す
  $(".scroll_brand .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_brand').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.brand").text(valueText).css({'color':'#808080'});
  });
  //スクロール 性別//add08
  ///表示
  $(".sp_panels #first .cells .cell.value.gender").on('click',function(){
    $('.scroll_gender').removeClass('is-hide');
  });
  $(".scroll_gender .return").on('click',function(){
    $('.scroll_gender').addClass('is-hide');//上の戻るボタン
  });
  ///テキストいれる
  $(".scroll_gender .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_gender').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.gender").text(valueText).css({'color':'#333333'});
  });
  ///テキストデフォルトに戻す
  $(".scroll_gender .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_gender').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.gender").text(valueText).css({'color':'#808080'});
  });
  //スクロール スポーツ//add08
  ///表示
  $(".sp_panels #first .cells .cell.value.sports").on('click',function(){
    $('.scroll_sports').removeClass('is-hide');
  });
  $(".scroll_sports .return").on('click',function(){
    $('.scroll_sports').addClass('is-hide');//上の戻るボタン
  });
  ///テキストいれる
  $(".scroll_sports .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_sports').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.sports").text(valueText).css({'color':'#333333'});
  });
  ///テキストデフォルトに戻す
  $(".scroll_sports .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_sports').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.sports").text(valueText).css({'color':'#808080'});
  });
  //スクロール サイズ//add08
  ///表示
  $(".sp_panels #first .cells .cell.value.size").on('click',function(){
    $('.scroll_size').removeClass('is-hide');
  });
  $(".scroll_size .return").on('click',function(){
    $('.scroll_size').addClass('is-hide');//上の戻るボタン
  });
  ///テキストいれる
  $(".scroll_size .value:not('.default')").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_size').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.size").text(valueText).css({'color':'#333333'});
  });
  ///テキストデフォルトに戻す
  $(".scroll_size .value.default").on('click',function(){
    var valueText = $(this).text();
    $('.scroll_size').addClass('is-hide');
    $(".sp_panels #first .cells .cell.value.size").text(valueText).css({'color':'#808080'});
  });
  //絞り込みボタン
  $(".filter_btn , #filter_btn_sp").on('click',function(){
    //$("body").addClass('white_bg');
    $("body").addClass('fixed');
    $(".sp_panels .panels").removeClass('is-hide');
    $('header').fadeOut();
    //$(".sp_menu_bg").stop().fadeIn();
    if($('body').hasClass('fixed')) {
      setTimeout(function(){
        var hSize = $(window).outerHeight(true),
            pSize = hSize - 71,
            psSize = pSize - 54;
        //$('.controls .panels .panel').height(hSize);
        $('.sp_panels .panels .panel').height(hSize);
        //$('.controls .panels .panel .scroll').height(hSize);
        $('.sp_panels .panels .panel .scroll').height(hSize);
        //$('.controls .panels .panel .scroll_cat').height(hSize);
        $('.sp_panels .panels .panel .scroll_cat').height(hSize);
        $('.sp_panels .panels .panel .scroll_brand').height(hSize);
        //add08
        $('.sp_panels .panels .panel .scroll_gender').height(hSize);
        $('.sp_panels .panels .panel .scroll_sports').height(hSize);
        $('.sp_panels .panels .panel .scroll_size').height(hSize);
      },100);
    }
  });
  $(".sp_panels .scroll .header .close").on('click',function(){
    //$("body").removeClass('white_bg');
    $("body").removeClass('fixed');
    $(".sp_panels .panels").addClass('is-hide');
    $('header').fadeIn();
    //$(".sp_menu_bg").stop().fadeOut();
  });
  //詳細 itemdetail
  //タブ
  $(".detail_layout .description_block .tabs ul li").on('click',function(){
    var tabID = $(this).data('id');
    //$(".tabs ul li").removeClass('current');
    $(".detail_layout .description_block .tabs li").removeClass('current');
    $(this).addClass('current');
    $(".detail_layout .description_block .body_set").hide().removeClass('current');
    $("#" + tabID).fadeIn().addClass('current');
    //$('#tab_area').fadeIn();
    return false;
  });
  //タブ アコ
  $(".detail_layout .description_block .aco_ttl").on("click", function() {
    $(this).next().stop().slideToggle();
    $(this).toggleClass("change");
    //$(this).find(".cross_icon").stop().toggleClass('change');
  });
  //カラーリスト switch
  $(".detail_layout .color_switch > ul > li").on("click", function() {
    $(".detail_layout .color_switch > ul > li").removeClass('current');
    $(this).addClass('current');
  });
  //サイズリスト switch
  $(".detail_layout .size_switch > ul > li").on("click", function() {
    $(".detail_layout .size_switch > ul > li").removeClass('current');
    $(this).addClass('current');
  });
  //コーディネート プルダウン、押下でclass
  $('#coordinate_select_list .current_ttl').on('click',function(){
    $(this).toggleClass('change');
    $(this).next('.select_inner').slideToggle();
  });
  $("#coordinate_select_list ul>li").on('click',function(){
    $("#coordinate_select_list ul>li").removeClass('current');
    $(this).addClass('current');
    var txt = $(this).text();
    $("#coordinate_select_list .current_ttl").text(txt);
    $('#coordinate_select_list .current_ttl').removeClass('change');
    $('#coordinate_select_list .select_inner').slideUp();
  });


});
