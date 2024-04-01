$(function(){
    $('#lien_bracket').hide();
    $('.hors-top-8').hide();
    $('#display-all').on( "click", function() {
        $('.hors-top-8').show();
        $('#lien_bracket').show();
        $(this).hide();
      });
});
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="tooltip"]').on( "touchstart", function(){
    $(this).tooltip('show');
  })
  $('[data-toggle="tooltip"]').on( "touchend", function(){
    $(this).tooltip('hide');
  })
});