(function($) {
  $( window ).on( "load", function() { 
    $(".select-wrap") .hide();
    $(".cart-options").hide();
  });

  $(document).ready(function(){

    /************** plp box hover code **************/
    $('.box').mouseover(function(){
      if($(".select-wrap", this).css("display")=="none"){
            $(".select-wrap", this).show();
        }
    });
    $('.box').mouseout(function(){
           $(".select-wrap", this).hide();
    });
    
  });
})(jQuery);

/************** plp box hover code **************/
function showVariants(e){
      jQuery(".cart-options").hide();
    var id = jQuery(e).attr("id");

    jQuery(".variant-"+id).show();

}

function hideVariants(e){
    jQuery(e).parent().hide();

}

/************** plp left panel code **************/
function hidefacet(e){
  var id = $(e).closest("div").attr("id");
  $("#"+id+"-wrap").toggle(function(){
    $(e).toggleClass("plus minus");
  });
  
}