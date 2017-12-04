$(function(){

  
  $('.js-core-detail').on("click",'.item', function(e){
    e.preventDefault()
    var id = $(this).data("id")
    var mid = $(this).data("mid")
    var thumb = $(this).data("thumb") || '/images/core_placeholder.jpg'
    var title = $(this).data("title")
    $(this).parent().addClass('current').siblings().removeClass('current')
    $.ajax({
      url: api_url('getcore','get_core_detail'),
      type:'Get',
      dataType:'json',
      data:{
        id:id,
        mid:mid
      },
      success: function( result ) {
        if(result.status == 'ok'){
            render_detail(result.content, title ,thumb )
        }else{
            $.dialog.alert(result.content);
            return false;
        }
        
      }
    });
  })

});

function render_detail($result, $title, $thumb) {
    var str = ''
    str += '<h3>'+$title+'</h3>'
        +'<div class="img"><img src="'+$thumb+'" alt=""></div>'
        +'<p><span>来源：</span>'+$result.from+'</p>'
        +'<p><span>成果：</span>'+$result.rewards+'</p>'
        +'<p><span>功效：</span>'+$result.effect+'</p>'
    $('.js-core-detail-wrapper').html(str)
}