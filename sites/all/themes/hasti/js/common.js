jQuery(window ).on( "load", function() { 
  jQuery(".select-wrap") .hide();
  jQuery(".cart-options").hide();
});


/************** plp box hover code **************/
jQuery(document).ready(function(){
  jQuery('#block-menu-menu-top-nav-hasti- ul').removeClass('nav');
  jQuery('.box').mouseover(function(){
    if(jQuery(".select-wrap", this).css("display")=="none"){
          jQuery(".select-wrap", this).show();
      }
  });
  jQuery('.box').mouseout(function(){
         jQuery(".select-wrap", this).hide();
  });

//-----

//-----  
});


/************** plp left panel code **************/
function hidefacet(id){
  jQuery("#filter_"+id).toggle(function(){
    jQuery("#filterToggle_"+id).toggleClass("plus minus");
  });
  
}

/*jQuery('document').ready(function(){
    jQuery('.filterfacet').click(function(){
      jQuery("span").closest("div > ul").toggle(function(){
      jQuery("span").toggleClass("plus minus");
  });
    });
});*/
