(function($) {
  $( window ).on( "load", function() { 
    $(".select-wrap") .hide();
    $(".cart-options").hide();
    $(".wishlist-options").hide();
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
      $(this).find(".mainDiv").css("display","block");
      $(this).find(".imgDivClass").remove();
      var subUlDiv=$(this).find(".subUlDiv");
      var str='<div class="imgDivClass">'+$(this).find(".menuimgDiv").html()+'</div>';
      // $(str).insertAfter(subUlDiv);
    });
    $(".topLevel.topCatalogLi").mouseout(function(){
      $(this).find(".mainDiv").css("display","none");
      $(this).find("ul").css("display","none");
      $(this).find(".imgDivClass").remove();
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
      console.log(data);
      if (!data['error']) {
        document.location = data['destination'];
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
        document.location = data['destination'];
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
