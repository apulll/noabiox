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


});