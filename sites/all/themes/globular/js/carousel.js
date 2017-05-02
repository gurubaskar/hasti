(function($) {
  $(function() {
    $('[data-jcarousel]').jcarouselAutoscroll({
    autostart: true, 
    interval: 1000,
    
});
    $('[data-jcarousel]').each(function() {
      var el = $(this);
      el.jcarousel(el.data());
      
    });
  $('#play').click(function() 
    {
        $('[data-jcarousel]').jcarouselAutoscroll('start');
    });
    $('#pause').click(function() 
    {
        $('[data-jcarousel]').jcarouselAutoscroll('stop');
    });

    $('[data-jcarousel-control]').each(function() {
      var el = $(this);
      el.jcarouselControl(el.data());
    });
  });
})(jQuery);