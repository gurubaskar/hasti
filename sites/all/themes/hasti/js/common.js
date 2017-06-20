(function($) {
  $( window ).on( "load", function() { 
    $(".select-wrap") .hide();
    $(".cart-options").hide();
    $(".wishlist-options").hide();
    $(".mob-search").hide();
    $("#forgotPopup").hide();
  });

 $(document).ready(function(){
      $(".mobsearch-icon").click(function(){
        $(".mob-search").slideToggle('medium', function(){
          if ($(this).is(':visible'))
                $(this).css('display','block');
        });
      });
  });

  $(document).ready(function () {
    $('.checkout-left ul li:first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.checkout-left ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
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
    
  $('#searchText').keyup(function(e) {
      // console.log(e.which);
      var special_keys = [37, 38, 39, 40, 16, 17, 18, 91, 33, 34, 35, 36, 45, 144, 145, 20];
      if ($.inArray(e.which, special_keys) != -1) {
        // Special keys used; don't do anything!
        return;
      }

      if (e.which == 13) {
        // Enter key.
        $('#custom-search-button').click();
      }
      else {
        var text = $(this).val().replace(/[^a-z0-9\s\.'"]+/ig, '');
        if (text.length > 0) {
          //$('#solr-suggestions').html('<small><em><img src="'+ Drupal.settings.basePath + 'misc/throbber-active.gif"> ' + Drupal.t('Loading suggestions...') + '</em></small>');
          $.ajax({
            type: "GET",
            // url: Drupal.settings.basePath + 'apachesolr_autocomplete_callback/apachesolr_search_page/core_search',
            url: Drupal.settings.basePath + 'drubiz-search-suggest',
            data: 'term=' + encodeURIComponent(text),
            success: function(data) {
              var latest_text = $('#searchText').val();
              if (data.length > 0) {
                if (latest_text == text) {
                  $('#solr-suggestions').html('');
                  var count = 1;
                  for (key in data) {
                    //alert(data[key].value);
                    var label = data[key].label.replace('<a>', '<a href="' + Drupal.settings.basePath + 'search/site/' + data[key].value + '">');
                    label = label.
                      replace("<br style='clear:both'>", '').
                      replace('</a>', "<br style='clear:both'><br style='clear:both'></a>"); //.
                      //replace(/count'>([0-9]+)<\/div>/g, 'count\'>$1 results</div>');
                    $('#solr-suggestions').append(label);
                    if (++count > 5) break;
                  }
                }
              }
              else {
                $('#solr-suggestions').html('<small><em>' + Drupal.t('No suggestions.') + '</em></small>');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $('#solr-suggestions').html('<small><em>Error fetching suggestions.</em></small>');
              console.log(textStatus + ': ' + errorThrown);
            },
            dataType: 'json'
          });
        }
        else {
          $('#solr-suggestions').html('<small><em>' + Drupal.t('Please type some keywords.') + '</em></small>');
        }
      }
    });

    $('#searchText').click(function(e) {
      e.preventDefault();
      var search_text = $('#searchText').val().replace(/[^a-z0-9\s\.'"]+/ig, '');
      if (search_text.length == 0) {
        //alert(Drupal.t('Please enter some search terms'));
        $('#searchText').focus();
      }
      else {
        document.location = Drupal.settings.basePath + 'search/site/' + encodeURIComponent(search_text);
      }
    });

    $('.address-select').click(function(){
      var conatctMechId = $(this).data('contactmechid');
      loading();
      $.ajax({
            type: "POST",
            url: Drupal.settings.basePath + 'checkout-address',
            data: 'contactMechId=' + conatctMechId,
            success: function(data) {
              close_loading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('We are facing some technical difficulties at the moment. Please try again after some time.');
              console.log(textStatus + ': ' + errorThrown);
              close_loading();
            },
            dataType: 'json'
          });
    });
    $(".topLevel.topCatalogLi").mouseover(function(){
      $(this).find("ul").css("display","block");
      //$(this).find(".mainDiv").css("display","block");
      //$(this).find(".imgDivClass").remove();
      //var subUlDiv=$(this).find(".subUlDiv");
      //var str='<div class="imgDivClass">'+$(this).find(".menuimgDiv").html()+'</div>';
      // $(str).insertAfter(subUlDiv);
    });
    $(".topLevel.topCatalogLi").mouseout(function(){
      //$(this).find(".mainDiv").css("display","none");
      $(this).find("ul").css("display","none");
      //$(this).find(".imgDivClass").remove();
    });
  });
  $(window).load(function(){
    $('.ui-link').attr('data-ajax','false');
    $('#signUpPop,#signInPop').attr('data-ajax','');
  });
})(jQuery);

/*********************Sign UP**************************/
function hastiSignIn(){
  var data_firstName                  = jQuery('#signUpForm').find('[name=firstName]:first').val();
  var data_lastName                   = jQuery('#signUpForm').find('[name=lastName]:first').val();
  var data_PHONE_MOBILE_CONTACT_OTHER = jQuery('#signUpForm').find('[name=PHONE_MOBILE_CONTACT_OTHER]:first').val();
  var data_userLoginId                = jQuery('#signUpForm').find('[name=userLoginId]:first').val();
  var data_currentPassword            = jQuery('#signUpForm').find('[name=currentPassword]:first').val();
  var data_currentPasswordVerify      = jQuery('#signUpForm').find('[name=currentPasswordVerify]:first').val();
  var data = 'firstName=' + encodeURIComponent(data_firstName) + '&lastName=' + encodeURIComponent(data_lastName) + '&PHONE_MOBILE_CONTACT_OTHER=' + encodeURIComponent(data_PHONE_MOBILE_CONTACT_OTHER) + '&userLoginId=' + encodeURIComponent(data_userLoginId) + '&currentPassword=' + encodeURIComponent(data_currentPassword) + '&currentPasswordVerify=' + encodeURIComponent(data_currentPasswordVerify);

  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'drubiz/user-register',
    data: data,
    success: function(data) {
      //console.log(data);
      if (!data['error']) {
        //document.location = data['destination'];
        var href = jQuery(location).attr('href').replace('#&ui-state=dialog','');
        document.location = href;
      }
      else {
        alert(data['error_messages'].join("\n"));
        close_loading();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('We are facing some technical difficulties at the moment. Please try again after some time.');
      console.log(textStatus + ': ' + errorThrown);
      close_loading();
    },
    dataType: 'json'
  });
}

/*******************Sign IN*************************/
function signInHasti(){
  var data_USERNAME = jQuery('#signInForm').find('[name=USERNAME]:first').val();
  var data_PASSWORD = jQuery('#signInForm').find('[name=PASSWORD]:first').val();

  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'drubiz/user',
    data: 'USERNAME=' + encodeURIComponent(data_USERNAME) + '&PASSWORD=' + encodeURIComponent(data_PASSWORD),
    success: function(data) {
      // console.log(data);
      if (!data['error']) {
        if(data['destination'] == '/account/change-password'){
          document.location = data['destination'];  
        } else {
          var href = jQuery(location).attr('href').replace('#&ui-state=dialog','');
          document.location = href;
        }
      }
      else {
        alert(data['error_messages'].join("\n"));
        close_loading();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('We are facing some technical difficulties at the moment. Please try again after some time.');
      console.log(textStatus + ': ' + errorThrown);
      close_loading();
    },
    dataType: 'json'
  });
}

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
  jQuery('filterToggle').hide();
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

/*************** Forgot Password ******************/
function checkEmail() {
  var email = jQuery("#emailid").val();
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if (email == "") {
      alert("Please Enter your Email");
      return false;
  }
  if (!filter.test(email)) {
      alert("Please enter a valid email address");
      return false;
  }
  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'forgotPassword',
    data: 'userEmail=' + email,
    success: function(data) {
      if (data['isError'] == 'False') {
        alert(data['_EVENT_MESSAGE_']);
        close_loading();
        document.location = Drupal.settings.basePath;        
      }
      else {
        alert(data['_ERROR_MESSAGE_LIST_'][0]['message']);
        close_loading();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus + ': ' + errorThrown);
      close_loading();
    },
    dataType: 'json'
  });
}

function openForgotPassword() {
  jQuery("#signInPopup").hide();
  jQuery("#forgotPopup").show();
  jQuery("#emailid").val("");
}

function openSignIn() {
 jQuery("#signInPopup").show();
 jQuery("#forgotPopup").hide(); 
 jQuery("#emailid").val("");
}

function closeForgotPassword() {
 jQuery("#forgotPopup").hide();
 jQuery("#signInPopup").show(); 
}

/*************** mega menu *****************/

jQuery(document).ready(function()
{ 
if (jQuery(window).width() >= 767) 
{
    jQuery("#eCommerceNavBarMenu li").mouseover(function() {
    jQuery(this).find('ul').show();         
    var posMainPanel = jQuery("#eCommercePageBody").offset();  
    var posMenuWidth = jQuery(this).first('ul').offset();
    var left = (posMainPanel.left - posMenuWidth.left) + "px";
    jQuery(this).find('ul').css({"left":left});       
      });
      jQuery("#eCommerceNavBarMenu li").mouseleave(function() {

        jQuery(this).find('ul').hide();
      });
}
else
{  
 
  jQuery( "#eCommerceNavBar > ul > li > ul" ).addClass( "slider" );
    jQuery("#eCommerceNavBarMenu li>ul").css({"width":"100%"});
    jQuery("#eCommerceNavBarMenu li").find('ul').css({left:"0px"});  
    jQuery("#eCommerceNavBarMenu li>ul").children("li.subLevel").css({"width":"100%"});
    jQuery("#eCommerceNavBarMenu li").off('mouseover');
        jQuery("#eCommerceNavBar > ul > li > ul").mouseleave(function() {
           jQuery(this).slideUp();
           jQuery('#eCommerceNavBar > ul > li:has( > ul)').removeClass('menu-drop-icon').addClass('menu-dropdown-icon');
        });
        jQuery("#eCommerceNavBar > ul > li").click(function () {
        
          jQuery(this).has( "ul" ).toggleClass('menu-drop-icon');
          /*jQuery(this).children("ul").slideToggle(150);*/
          jQuery('html, body').animate({
                scrollTop: jQuery(this).offset().top
            }, 100);
      });
}
  
jQuery(window).resize(function () {
    if (jQuery(window).width() < 767) {
      
      jQuery( "#eCommerceNavBar > ul > li > ul" ).addClass( "slider" );
      /*jQuery("#js_eCommerceProductAddImage > ul  li:gt(2)").hide();*/
      jQuery("#eCommerceNavBarMenu li>ul").css({"width":"100%"});
      jQuery("#eCommerceNavBarMenu li").find('ul').css({left:"0px"});
      jQuery("#eCommerceNavBarMenu li>ul").children("li.subLevel").css({"width":"100%"});
      jQuery("#eCommerceNavBarMenu li").off('mouseover');
          jQuery("#eCommerceNavBar > ul > li").mouseleave(function() {
        jQuery(this).children("ul").slideUp();
        jQuery('#eCommerceNavBar > ul > li:has( > ul)').removeClass('menu-drop-icon').addClass('menu-dropdown-icon');
        });
          jQuery("#eCommerceNavBar > ul > li").click(function () {
              jQuery(this).has( "ul" ).toggleClass('menu-drop-icon');
              /*jQuery(this).children("ul").slideToggle(150);*/
              jQuery(this).children("ul").css("display","block");
              jQuery('html, body').animate({
                    scrollTop: jQuery(this).offset().top
                }, 100);
          });
    }
    else{
      jQuery("#eCommerceNavBarMenu li").mouseover(function() {
        jQuery(this).find('ul').css({"width":"1240px"});
        jQuery(this).find('ul').show();
        jQuery("#eCommerceNavBarMenu li>ul").children("li.subLevel").css({"width":""});
          var posMainPanel = jQuery("#eCommercePageBody").offset();  
         
          var posMenuWidth = jQuery(this).first('ul').offset();
          
          var left = (posMainPanel.left - posMenuWidth.left) + "px";
          jQuery(this).find('ul').css({"left":left});
        });
        jQuery("#eCommerceNavBarMenu li").mouseleave(function() {
          jQuery(this).find('ul').hide();
          });
        jQuery("#eCommerceNavBar > ul > li").off('click');
        jQuery("#eCommerceNavBar > ul").removeClass('show-on-mobile');
        
    }
});


jQuery('#eCommerceNavBar > ul > li:has( > ul)').addClass('menu-dropdown-icon');

jQuery("#eCommerceNavBar > ul").before("<a href=\"#\" class=\"mob-nav\"></a>");

jQuery(".mob-nav").click(function (e) {
  jQuery("#eCommerceNavBar > ul").toggleClass('show-on-mobile');
  jQuery("#eCommercePageBody").toggleClass('mob-active');
  //jQuery(".menu > ul").toggleClass('show-on-mobile');
 // jQuery("#eCommercePageBody").toggleClass('mob-active');
  e.preventDefault();
});

});

function replaceDetailImage(largeImageUrl, detailImageUrl)
    {
        if (!jQuery('#mainImages').length)
        {
            var mainImages = jQuery('#js_mainImageDiv').clone();
            jQuery(mainImages).find('img.js_productLargeImage').attr('id', 'js_mainImage');
            jQuery('#js_productDetailsImageContainer').html(mainImages.html());
            jQuery('#js_seeMainImage a').attr("href", "javascript:replaceDetailImage('"+largeImageUrl+"', '"+detailImageUrl+"');");
        }
            var mainImages = jQuery('#js_mainImageDiv').clone();
            jQuery(mainImages).find('img.js_productLargeImage').attr('id', 'js_mainImage');
            jQuery(mainImages).find('img.js_productLargeImage').attr('src', largeImageUrl+ "?" + new Date().getTime());
            jQuery(mainImages).find('a').attr('class', 'innerZoom');
            if(detailImageUrl != "")
            {
              jQuery(mainImages).find('a').attr('href', detailImageUrl);
            }
            else
            {
                jQuery(mainImages).find('a').attr('href', 'javaScript:void(0);');
            }
            jQuery('#js_productDetailsImageContainer').html(mainImages.html());
            activateZoom(detailImageUrl);

        if (document.images['js_mainImage'] != null)
        {
            var detailimagePath;
            document.getElementById("js_mainImage").setAttribute("src",largeImageUrl);
            if(document.getElementById('js_largeImage'))
            {
                setDetailImage(detailImageUrl);
            }
            document.getElementById("js_mainImage").setAttribute("class","js_productLargeImage");
            detailimagePath = "javascript:displayDialogBox('largeImage_')";
            if (jQuery('#js_mainImageLink').length)
            {
                jQuery('#js_mainImageLink').attr("href",detailimagePath);
            }
        }
    }

    function activateZoom(imgUrl)
    {
        if (typeof imgUrl == "undefined" || imgUrl == "NULL" || imgUrl == "")
        {
            return;
        }
        var image = new Image();
        image.src = imgUrl+ "?" + new Date().getTime();
        image.onerror = function ()
        {
            jQuery('.innerZoom').attr('href', 'javaScript:void(0);');
            return false;
        };
        image.onload = function ()
        {
            jQuery('.innerZoom').jqzoom(zoomOptions);
        };

    }

    function activateInitialZoom()
    {
        jQuery('.innerZoom').each(function()
        {
            var elm = this;
            var image = new Image();
            image.src = this.href+ "?" + new Date().getTime();
            image.onerror = function ()
            {
                jQuery(elm).attr('href', 'javaScript:void(0);');
                return false;
            };
            image.onload = function ()
            {
                jQuery('.innerZoom').jqzoom(zoomOptions);
            };
        });
    }

    var zoomOptions = {
        zoomType: 'innerzoom',
        lens:true,
        preloadImages: true,
        preloadText: ''
    };

    jQuery(document).ready(function() {
      jQuery('#mainAddImageLink').click();
    });

function displayActionDialogBoxQuicklook(dialogPurpose,elm,pdpUrl)
  {

     var params = jQuery(elm).siblings('input.param').serialize();
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     var url = "";
     if (params)
     {
        url = '/dialogActionRequest?'+params;
     }
     else
     {
        url = '/dialogActionRequest';
     }


      jQuery.ajax({
      url: url,
      type: "POST",
      data: {},
      success: function(response) {
          jQuery("#js_plpQuicklook_Container_id").html("");
          jQuery("#js_plpQuicklook_Container_id").html(response);
           quicklookDialog = jQuery(displayDialogId).dialog({
                modal: true,
                resizeable:false,
                draggable:false,
                position:'center',
                close:function(){jQuery(".ui-dialog").removeClass("TestQuickLookClass");},
              });
          jQuery(".quicklookPDPurl").attr("href", pdpUrl);
          quicklookDialog.dialog('open');
           jQuery(".ui-dialog").addClass("QuickLookPopup");
           jQuery(".pdpImgCaurosel").css("display","block");
        jQuery("#js_mainImage").css("display","none");
         jQuery(".image.mainImage.pdpMainImage.thumb").css("display","none");
         jQuery("#js_plpQuicklook_Container_id").find("#js_altImageThumbnails").css("display","none");
         jQuery("#js_plpQuicklook_Container_id").find("#js_altImageThumbnailsForQuickLook").css("display","block");
        jQuery("#js_plpQuicklook_Container_id").find(".pdpImgCaurosel").bxSlider({
        infiniteLoop: true,
        pager:true,
        touchEnabled:true,
            slideWidth: 350,
            minSlides: 2,
            moveSlides: 1,
            maxSlides: 1,
            slideMargin:10,
        pagerCustom:'#js_altImageThumbnailsForQuickLook'
          });
    jQuery('#js_altImageThumbnailsForQuickLook').mCustomScrollbar({
    theme:"dark-3"
});
     }
      });
  }
  jQuery(document).ready(function(){
  jQuery('#block-menu-menu-footer-menu-1-hasti- > ul').removeClass('menu nav');
  jQuery('#block-menu-menu-footer-menu-2-hasti- > ul').removeClass('menu nav');
});