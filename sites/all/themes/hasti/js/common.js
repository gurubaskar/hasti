(function($) {
  $( window ).on( "load", function() { 
    $(".select-wrap") .hide();
    $(".cart-options").hide();
    $(".wishlist-options").hide();
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
function showVariants(e ,selectFeatureDiv , productId){
    jQuery(".cart-options").hide();
    var id = jQuery(e).attr("id");
    var data = "";
    data += 'productId=' + productId;
    loading();
    jQuery.ajax({
      type: 'POST',
      url: Drupal.settings.basePath + 'drubiz/plp-check-inventory',
      data : data,
      success: function(data){
        console.log(data);
        if(data['availableQuantity'] <= 0){
            jQuery('.plp-add-to-cart').attr('disabled','disabled');
            console.log(data['availableQuantity']);
        }else{
          var all_pid = Object.keys(data['inventoryProductLevel']);
          for(var i =0 ; i< all_pid.length ; i++){
            var pid = all_pid[i];
            var ppid = '';
            if(data['inventoryProductLevel'][pid]['availableQuantity'] == 0){
              ppid = pid;
              console.log(ppid);
            }
          }
        }
      jQuery(".variant-"+id).show();
      close_loading();
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert("Server down. Please try again later!")
      close_loading();
    },
    dataType:'json'
  });
}

function showWishlistVariants(e){
      jQuery(".wishlist-options").hide();
    var id = jQuery(e).attr("id");

    jQuery(".wishlist-variant-"+id).show();

}

function hideVariants(e){
    jQuery(e).parent().hide();

}

/************** plp left panel code **************/
function hidefacet(e){
  var id = jQuery(e).closest("div").attr("id");
  jQuery("#filter_"+id).toggle(function(){
    jQuery(e).toggleClass("plus minus");
  });
  
}

function onImgError(elem,type) {
  var imgUrl = drubiz_ofbiz_url + "/osafe_theme/images/user_content/images/";
  var imgName= "NotFoundImage.jpg";
  switch (type) {
    case "PLP-Thumb":
      imgName="NotFoundImagePLPThumb.jpg";
      break;
    case "PLP-Swatch":
      imgName="NotFoundImagePLPSwatch.jpg";
      break;
    case "PDP-Large":
      imgName="NotFoundImagePDPLarge.jpg";
      break;
    case "PDP-Alt":
      imgName="NotFoundImagePDPAlt.jpg";
      break;
    case "PDP-Detail":
      imgName="NotFoundImagePDPDetail.jpg";
      break;
    case "PDP-Swatch":
      imgName="NotFoundImagePDPSwatch.jpg";
      break;
    case "CLP-Thumb":
      imgName="NotFoundImageCLPThumb.jpg";
      break;
    case "MANU-Image":
      imgName="NotFoundImage.jpg";
      break;
  }
  elem.src = imgUrl + imgName;
  elem.onmouseout="";
  elem.onmouseover="";
  elem.onerror = "";

  if(type == "PDP-Alt"){
     jQuery("#"+elem.id+"Link_li").css("display","none");
     jQuery("#addImageLink_li").css("display","none");
    var imgUrl = "";
    var imgName= "";
    }
  return true;
}