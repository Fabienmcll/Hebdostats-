$(function(){
  $('.num-counterUp').each(function() {
    var num = Number($(this).html());
    if(!isNaN(num)){
      $(this).html(num).counterUp({
        time: (num*10)
      });
    }
  });
  /*$('#preloader').load(function() {
    window.location.href = '{{ url("app_tournois") }}'
  });*/
});
  
