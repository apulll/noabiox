$(function(){

  $(document).on("click",".cate-list .arrow",function(){
    $(".cate-list .m").removeClass("current");
    $(".cate-list ul ul").slideUp();
    $(this).parent(".m").addClass("current");
    $(this).parent(".m").next('ul').slideDown();

    // if($(this).parent(".m").hasClass("current")){
    //   $(this).parent(".m").removeClass("current");
    //   $(this).parent(".m").next('ul').slideUp();
    // }else{
    //   $(this).parent(".m").addClass("current");
    //   $(this).parent(".m").next('ul').slideDown();
    // }
  });
  $('.js-search-box').on("click",'.js-search-sub', function(){
    var $val = $('.js-search-input').val()
    var href = window.location.href
    var newHref = href.split('?')[1].split('&')
    // console.log(newHref.length-1,'newHref')
    href = href + '&keywords='+$val
    window.location.href =  href;
  })

});