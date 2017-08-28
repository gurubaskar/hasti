var ajaxErrorMsg = "We are facing some technical difficulties at the moment. Please try again after some time.";
var ajaxSuccess = "success";
var ajaxInfo = "info";
var ajaxWarning = "warning";
var ajaxDanger = "danger";

function ajaxErrorMsgDisplay(msg,type='info',delay='3000') {
  jQuery.notify({
    message: msg,
  },
  {
    type: type,
    delay: delay,
    placement: {
      from: "top",
      align: "center"
    },
    animate: {
      enter: 'animated fadeInDown',
      exit: 'animated fadeOutUp'
    },
  });
}

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
    $('.policy-left ul li#first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.policy-left ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
    $('.policy-left ul li a').click(function(){
      $('li a').removeClass("active");
      $(this,'a').addClass('active');
     })
  });
  /*$(document).ready(function(){    
    $("#securitypolicy").click(function () {
        $("#returns").removeClass("active");
        $("#security-li").addClass("active");
        $("#security").css('display','block');
        $("#returns-policy").css('display','none');
        //event.preventDefault();
    });
  });*/

  $(document).ready(function () {
    $('.contact-left ul li#first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.contact-left ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
    $('.contact-left ul li a').click(function(){
      $('li a').removeClass("active");
      $(this,'a').addClass('active');
     })
  });

  $(document).ready(function () {
    $('.faq-left ul li#first').addClass('active');
    $('.tab-content:not(:first)').hide();
    $('.faq-left ul li a').click(function (event) {
        event.preventDefault();
        var content = $(this).attr('href');
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        $(content).show();
        $(content).siblings('.tab-content').hide();
    });
    $('.faq-left ul li a').click(function(){
      $('li a').removeClass("active");
      $(this,'a').addClass('active');
     })
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
    $('.checkout-left ul li a').click(function(){
      $('li a').removeClass("active");
      $(this,'a').addClass('active');
     })
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
  // $('#searchText').live('keyup',function(e) {
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
                    var label = data[key].label.replace('<a>', '<a href="' + Drupal.settings.basePath + 'search/site/' + data[key].value + '" data-ajax="'+ false +'">');
                    // label = label.
                    //   replace("<br style='clear:both'>", '').
                    //   replace('</a>', "<br style='clear:both'><br style='clear:both'></a>"); //.
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
    $('.address-delete').click(function(){
      var thisid = $(this).attr('data-contactMechId');
      bootbox.confirm("Are you sure want to delete address?", function(result){ 
        if(result == true) {
        var conatctMechId = thisid;
        loading();
        $.ajax({
              type: "POST",
              url: Drupal.settings.basePath + 'address-delete',
              data: 'contactMechId=' + conatctMechId,
              success: function(data) {
                close_loading();
                $('#delete_'+conatctMechId).hide();
              },
              error: function(jqXHR, textStatus, errorThrown) {
                ajaxErrorMsgDisplay(ajaxErrorMsg,ajaxInfo);
                //console.log(textStatus + ': ' + errorThrown);
                close_loading();
              },
              dataType: 'json'
            });
       } 
        });
    });
    $('.setdefault-address').click(function(){
      var conatctMechId = $(this).data('contactmechid');
      loading();
      $.ajax({
            type: "POST",
            url: Drupal.settings.basePath + 'account/setdefault-address',
            data: 'contactMechId=' + conatctMechId,
            success: function(data) {
              if (data['isError'] == 'false') {
                alert(data['_EVENT_MESSAGE_']);
                close_loading();
                document.location = Drupal.settings.basePath +'account/address-book';
              } else {
                alert(data['_ERROR_MESSAGE_']);
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

/*******************Check Pin*************************/
function checkPin(){
  var pincode = jQuery('#pincode').val();
  var data = 'pincode=' + pincode;
  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'check-pin',
    data: data,
    success: function(data) {
      //console.log(data);
      if (data['isError'] == 'true') {
        //alert(data['_ERROR_MESSAGE_']);
        //jQuery('#pincodeerror').show();
        var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#pincodeerror").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#pincodeerror").focus();
        close_loading();
      } else {
        //alert(data['deliveryCharges']);      
        close_loading();
        jQuery("#shippingcharge").html('&#8377;.'+data['deliveryCharges']+'.00');
        jQuery("#subtotalamount").html('&#8377;.'+data['cartSubTotal']+'.00');
        jQuery("#totalamount").html('&#8377;.'+data['orderGrandTotal']+'.00');  
        jQuery('#pincodeerror').hide();
        //document.location = Drupal.settings.basePath + 'cart';   
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
//        alert(data['error_messages'].join("\n"));
        var errormsgs = data['error_messages'].join("\n");
        jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
        jQuery("#signup_errormsgs").focus();
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
  var remember = jQuery('#remember').val();
  var params = jQuery(location).attr('pathname');
  var checkout = params.split("/");
  var data = 'USERNAME=' + encodeURIComponent(data_USERNAME) + '&PASSWORD=' + encodeURIComponent(data_PASSWORD)+'&remember='+remember;
  loading();
  //alert(data);
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'drubiz/user',
    data: data,
    
    success: function(data) {
      // console.log(data);
      if (!data['error']) {
        if(data['destination'] == '/account/change-password'){
          document.location = data['destination'];  
        } else {
          var href = jQuery(location).attr('href').replace('#&ui-state=dialog','');
          if(checkout[2] == "checkout-payment") {
            document.location = href;
            //jQuery("#orderSummary").trigger("click");
            // jQuery("#order-summary").show();
          } else {
            document.location = href;
          }
        }
      }
      else {
        var errormsgs = data['error_messages'].join("\n");
        jQuery("#signin_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
        jQuery("#signin_errormsgs").focus();
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

function addAddress(){
  /*if(jQuery('#firstname').val() == ''){
    alert('Enter First Name.');
    return false;
  }
  if(jQuery('#lastname').val() == ''){
    alert('Enter Last Name.');
    return false;
  }
  if(jQuery('#address1').val() == ''){
    alert('Enter Address 1.');
    return false;
  }
  if(jQuery('#address2').val() == ''){
    alert('Enter Address 2.');
    return false;
  }
  if(jQuery('#city').val() == ''){
    alert('Enter City.');
    return false;
  }
  if(jQuery('#state').val() == ''){
    alert('Select State.');
    return false;
  }
  if(jQuery('#zipcode').val() == ''){
    alert('Enter zipcode.');
    return false;
  }
  if(jQuery('#mobile').val() == ''){
    alert('Enter mobile.');
    return false;
  }*/

  var data_firstname   = jQuery('#addNewAddress').find('[name=firstname]:first').val();
  var data_lastname    = jQuery('#addNewAddress').find('[name=lastname]:first').val();
  var data_address1    = jQuery('#addNewAddress').find('[name=address1]:first').val();
  var data_address2    = jQuery('#addNewAddress').find('[name=address2]:first').val();
  var data_city        = jQuery('#addNewAddress').find('[name=city]:first').val();
  var data_state        = jQuery('#addNewAddress').find('[name=state]:first').val();
  var data_zipcode     = jQuery('#addNewAddress').find('[name=zipcode]:first').val();
  var data_mobile      = jQuery('#addNewAddress').find('[name=mobile]:first').val();
  
  var data = 'data_firstname=' + encodeURIComponent(data_firstname) + '&data_lastname=' + encodeURIComponent(data_lastname) + '&data_address1=' + encodeURIComponent(data_address1) + '&data_address2=' + encodeURIComponent(data_address2) + '&data_city=' + encodeURIComponent(data_city) + '&data_state=' + encodeURIComponent(data_state) + '&data_zipcode=' + encodeURIComponent(data_zipcode) + '&data_mobile=' + encodeURIComponent(data_mobile);
  var orderAddress = getParameterByName('back');

  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'drubiz/add-address',
    data: data,
    success: function(data) {
      //console.log(data);
      if(data['status'] == 'fail'){
        //alert(data['_ERROR_MESSAGE_']);
          var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#signup_errormsgs").focus();
        close_loading();
      }else {
        if(orderAddress == 'order') {
          document.location = Drupal.settings.basePath + 'checkout-payment?from=address';
        } else {
          close_loading();
          ajaxErrorMsgDisplay("added success",ajaxInfo,'7000');
          document.location = Drupal.settings.basePath + 'account/address-book';
        }
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

jQuery(document).ready(function() {
  if(jQuery('#deliveryAddress').length > 0 && jQuery('#from').val() == '1') {
    jQuery('#deliveryAddress').trigger('click');
  }
});

function editAddress(){
  
  var data_firstname   = jQuery('#editNewAddress').find('[name=firstname]:first').val();
  var data_lastname    = jQuery('#editNewAddress').find('[name=lastname]:first').val();
  var data_address1    = jQuery('#editNewAddress').find('[name=address1]:first').val();
  var data_address2    = jQuery('#editNewAddress').find('[name=address2]:first').val();
  var data_city        = jQuery('#editNewAddress').find('[name=city]:first').val();
  var data_state       = jQuery('#editNewAddress').find('[name=state]:first').val();
  var data_zipcode     = jQuery('#editNewAddress').find('[name=zipcode]:first').val();
  var data_mobile      = jQuery('#editNewAddress').find('[name=mobile]:first').val();
  var data_addressid   = jQuery('#editNewAddress').find('[name=addressid]:first').val();

  var data = 'data_firstname=' + encodeURIComponent(data_firstname) + '&data_lastname=' + encodeURIComponent(data_lastname) + '&data_address1=' + encodeURIComponent(data_address1) + '&data_address2=' + encodeURIComponent(data_address2) + '&data_city=' + encodeURIComponent(data_city) + '&data_state=' + encodeURIComponent(data_state) + '&data_zipcode=' + encodeURIComponent(data_zipcode) + '&data_mobile=' + encodeURIComponent(data_mobile) + '&data_contactMechId=' + encodeURIComponent(data_addressid) + '&data_update=1';

  loading();
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'drubiz/add-address',
    data: data,
    success: function(data) {
      //console.log(data);
      if (data['isError'] == 'true') {
        //alert(data['_ERROR_MESSAGE_']);
        var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#signup_errormsgs").focus();
        close_loading();
      } else {
        document.location = Drupal.settings.basePath + 'account/address-book';
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
   // jQuery(".cancelord").click(function(){
function cancelOrder(){//alert('hi');
    var orderId = jQuery('#cancel-id').val();//jQuery(this).data('cancel-id');
    //alert(orderId);
    //var reasionId = jQuery('#cancelWindow_'+orderId).find('option:selected').attr('id');
    //var reasonComments = jQuery('#cancelWindow_'+orderId).find('textarea').val();
    var reasionId = jQuery('#cancelReason').val();
    var reasonComments = jQuery('#cancelComments').val();
    var data = "";
    // data += 'orderId=' + orderId;
    loading();
    jQuery.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/cancelOrder',
      data: 'orderId=' + orderId + '&reasionId=' + reasionId + '&reasonComments=' + reasonComments,
      success: function(data) {
        if (data['isError'] == 'false') {
          //alert(data['_EVENT_MESSAGE_']);
          var errormsgs = data['_EVENT_MESSAGE_'];
          jQuery("#cancelordermsg").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#cancelordermsg").focus();
          close_loading();
          document.location = Drupal.settings.basePath + 'account/orders';        
        }
        else if (data['isError'] == 'true') {
          //alert(data['_EVENT_MESSAGE_']);            
          var errormsgs = data['_EVENT_MESSAGE_'];
          jQuery("#cancelordermsg").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#cancelordermsg").focus();
          close_loading();
        } else {
          //alert(data['_ERROR_MESSAGE_']);          
          var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#cancelordermsg").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#cancelordermsg").focus();
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

jQuery(document).ready(function(){

  jQuery(".shareStory").click(function(){
    jQuery('#socialIcons').toggle();
  });

  jQuery(".ccavenue").click(function(){
    loading();
    jQuery.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/ccavenue',
      success: function(data) {
        if (data['status'] == 'success') {
          // alert(data['_EVENT_MESSAGE_']);
          close_loading();
          var merchantId = data['merchantId'];
          var encRequest = data['encRequest'];
          var accessCode = data['accessCode'];
          // alert(merchantId +'--' +encRequest +'--'+ accessCode);
          document.location = "https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&merchant_id="+merchantId+"&encRequest="+encRequest+"&access_code="+accessCode;
        }
        else {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus + ': ' + errorThrown);
        close_loading();
      },
      dataType: 'json'
    });
  });

});

jQuery(document).ready(function(){
    jQuery(".reoderItem").click(function(){
     var itemChecked = jQuery(".theClass:checked").length;
     if(itemChecked > 0) {
        var checkedVals = jQuery('.theClass:checkbox:checked').map(function() {
            return this.value;
        }).get();
        var productIds = checkedVals.join(",");
        // alert(productIds);
        loading();
        jQuery.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'reorderItem',
          data: 'productIds=' + productIds,
          success: function(data) {
            if (data['isError_0'] == 'false') {
              alert(data['_EVENT_MESSAGE_0']);
              close_loading();
              document.location = Drupal.settings.basePath + 'cart';        
            }
            else {
              alert(data['_ERROR_MESSAGE_']);
              close_loading();
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            // alert(textStatus + ': ' + errorThrown);
            console.log(textStatus + ': ' + errorThrown);
            // return false;
            close_loading();
          },
          dataType: 'json'
        });
      } else {
        alert("Please select item");
        return false;
      }
      return false;
    });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
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
  /*if (email == "") {
      alert("Please Enter your Email");
      return false;
  }
  if (!filter.test(email)) {
      alert("Please enter a valid email address");
      return false;
  }*/
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
          var errormsgs = data['_ERROR_MESSAGE_LIST_'][0]['message'];
          jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#signup_errormsgs").focus();
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

function openLogin() {
  jQuery("#order-summary").hide();
  jQuery("#checkout-login").show();
  jQuery("#delivery-address").hide();
  jQuery("#payment-method").hide();
  jQuery("#orderSummary").removeClass("active-img");
  jQuery("#deliveryAddress").removeClass("active-img");
  jQuery("#paymentMethod").removeClass("active-img");
}

function openOrderSummary() {
  jQuery("#order-summary").show();
  jQuery("#checkout-login").hide();
  jQuery("#delivery-address").hide();
  jQuery("#payment-method").hide();
  jQuery("#orderSummary").removeClass("active-img");
  jQuery("#deliveryAddress").removeClass("active-img");
  jQuery("#paymentMethod").removeClass("active-img");
}

function openDeliveryAddress() {
 jQuery("#order-summary").hide();
 jQuery("#checkout-login").hide(); 
 jQuery("#delivery-address").show();
 jQuery("#payment-method").hide();
 jQuery("#orderSummary").addClass("active-img");
 jQuery("#deliveryAddress").removeClass("active-img");
 jQuery("#paymentMethod").removeClass("active-img");

 jQuery('li a').removeClass("active");
 jQuery('#deliveryAddress').addClass('active');
}

function openPaymentMethod() {
   var numberOfCheckedRadio = jQuery('input:radio:checked').length;
  if(numberOfCheckedRadio > 0) {
 jQuery("#order-summary").hide();
 jQuery("#checkout-login").hide(); 
 jQuery("#delivery-address").hide();
 jQuery("#payment-method").show();
 jQuery("#orderSummary").addClass("active-img");
 jQuery("#deliveryAddress").addClass("active-img");

 jQuery('#paymentOption').show();
 jQuery('#sendOTP').hide();
 jQuery('#displayOTP').hide();
 jQuery('#placeOrderOTP').hide();
 jQuery('#onlineProceed').hide();
 jQuery('#COD').prop('checked', false);
 jQuery('#Online').prop('checked', false);
 jQuery('#OTPValue').val("");


 jQuery('li a').removeClass("active");
 jQuery('#paymentMethod').addClass('active');
 } else {
    alert("Please select a address");
    return false;
  }
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
            document.getElementById("js_mainImage").setAttribute("data-zoom-image",largeImageUrl);
            jQuery(".js_productLargeImage").elevateZoom();
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
//            jQuery('.innerZoom').jqzoom(zoomOptions);
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
//                jQuery('.innerZoom').jqzoom(zoomOptions);
                jQuery('.innerZoom').elevateZoom();
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

jQuery(document).ready(function () {
  jQuery('.myorders ul li:first').addClass('active');
  jQuery('.tab-content:not(:first)').hide();
  jQuery('.myorders ul li a').click(function (event) {
    event.preventDefault();
    var content = jQuery(this).attr('href');
    jQuery(this).parent().addClass('tab-active');
    jQuery(this).parent().siblings().removeClass('tab-active');
    jQuery(this).parent().siblings().find('a').removeClass('tab-active');
    jQuery(content).show();
    jQuery(content).siblings('.tab-content').hide();
  });
});
jQuery(document).ready(function () 
{
  jQuery('.characterLimit').each(function(){
      restrictTextLength(this);
  });
});
function restrictTextLength(textArea){
    var maxchar = jQuery(textArea).attr('maxlength');
    var curLen = jQuery(textArea).val().length;
    var regCharLen = lineBreakCount(jQuery(textArea).val());
    jQuery(textArea).next('.js_textCounter').html((maxchar - (curLen+regCharLen))+" characters left");
    jQuery(textArea).keyup(function() {
        var cnt = jQuery(this).val().length;
        var regCharLen = lineBreakCount(jQuery(this).val());
        var remainingchar = maxchar - (cnt + regCharLen);
        if(remainingchar < 0){
            jQuery(this).next('.js_textCounter').html('0 characters left');
            jQuery(this).val(jQuery(this).val().slice(0, (maxchar-regCharLen)));
        } else{
            jQuery(this).next('.js_textCounter').html(remainingchar+' characters left');
        }
    });
 }
  function lineBreakCount(str){
    //counts n
    try {
        return((str.match(/[^\n]*\n[^\n]*/gi).length));
    } catch(e) {
        return 0;
    }
  } 
function contactus(){
  var data_firstName = jQuery('#firstname').val();
  var email = jQuery("#returnCustomerEmail").val();
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
  var data_orderIdNumber = jQuery('#orderIdNumber').val();
  var data_phoneNumber = jQuery('#conactUsPhone').val();
  var data_msg = jQuery('#js_content').val();
   var choosefile = jQuery('#choose-file').val();
  /*if(data_firstName == ''){
    alert("FirstName can't be Empty");
    return false;
  }
  if (email == "") {
      alert("Please Enter your Email");
      return false;
  }
  if (!filter.test(email)) {
      alert("Please enter a valid email address");
      return false;
  }  
  if(data_phoneNumber == ''){
    alert("Phone Number cant't be Empty");
    return false;
  }
  if(data_msg == ''){
    alert("Massage can't be Empty");
    return false;
  }*/
  var data = 'data_firstName=' + encodeURIComponent(data_firstName) + '&email=' + encodeURIComponent(email)  + '&data_phoneNumber=' + encodeURIComponent(data_phoneNumber);
  if(data_orderIdNumber != ''){
      data = data + '&data_orderIdNumber=' + encodeURIComponent(data_orderIdNumber)+ '&data_msg='+data_msg+ '&file='+choosefile;
      //alert(data);
  }
  jQuery.ajax({
        type: "POST",
        url: Drupal.settings.basePath + 'save-contact-us',
        data: data,
        success: function(data) {
          console.log(data);
          if (data['isError'] == 'false') {
            // alert(data['status']);
            close_loading();
            jQuery('.success-msg').show();
            jQuery('#addContactus').hide();
            //document.location = Drupal.settings.basePath +'contact-us';
          } else {
            //alert(data['_ERROR_MESSAGE_']);
            var errormsgs = data['_ERROR_MESSAGE_'];
            jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
            jQuery("#signup_errormsgs").focus();
            jQuery('.success-msg').hide();
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

function savePersonalInfo(){
  var data_firstName = jQuery('#firstName').val();
  var data_lastName = jQuery('#lastName').val();
  var data_phoneNumber = jQuery('#phoneNumber').val();
  var data_gender = jQuery('#gender').val();
  /*if(data_firstName == ''){
    alert("FirstName can't be Empty");
    return false;
  }
  if(data_lastName == ''){
    alert("Last Name can't be Empty");
    return false;
  }
  if(data_phoneNumber == ''){
    alert("Phone Number cant't be Empty");
    return false;
  }*/
  var data = 'data_firstName=' + encodeURIComponent(data_firstName) + '&data_lastName=' + encodeURIComponent(data_lastName)  + '&data_phoneNumber=' + encodeURIComponent(data_phoneNumber);
  if(data_gender != ''){
      data = data + '&data_gender=' + encodeURIComponent(data_gender);
      // alert(data);
  }
  jQuery.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'account/save-profile',
      data: data,
      success: function(data) {
        console.log(data);
        if (data['isError'] == 'false') {
          //alert(data['_EVENT_MESSAGE_']);
          close_loading();
          jQuery('.success-msg').show();
          jQuery('#addpersonalinfo').hide();
          //document.location = Drupal.settings.basePath +'account/profile';
        } else {
          var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#signup_errormsgs").focus();
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

jQuery(document).ready(function(){
    jQuery('#refundType').on('change', function() {
      var selectedReturnValue = jQuery('#refundType').val();
      if(selectedReturnValue == 'RTN_REFUND') {
        jQuery('.bankDetails').show();
      } else {
        jQuery('.bankDetails').hide();
      }
    });
    jQuery(".returnProduct").click(function(){
      var itemChecked = jQuery(".returnProduct").is(":checked");
      if(itemChecked > 0) {
        jQuery('.refundTypeDisplay').show();
      } else {
        jQuery('input:checkbox').prop('checked', false);
        jQuery('.refundTypeDisplay').hide();
        jQuery('.bankDetails').hide();
      }
    });
    jQuery('#checkAll').click(function () {    
       jQuery('input:checkbox').prop('checked', this.checked);
         var itemChecked = jQuery(".returnProduct").is(":checked");
        if(itemChecked > 0) {
          jQuery('.refundTypeDisplay').show();
        } else {
          jQuery('.refundTypeDisplay').hide();
          jQuery('.bankDetails').hide();
        }    
    });
    jQuery("#refundType").on('change', function() {
      var selectedReturnValue = jQuery('#refundType').val();
      if(selectedReturnValue == 'RTN_CREDIT') {
        jQuery('#storecredit').show();
      }else{
         jQuery('#storecredit').hide();
      }
    });
      function refundReturn(){
      var orderId = jQuery("#orderId").val();
      var itemChecked = jQuery(".returnProduct:checked").length;
      if(itemChecked > 0) {
        var selectedReturnValue = jQuery('#refundType').val();
        if(selectedReturnValue == 0) {
          alert("Please select Refund type");
          return false;
        }
        var checkedVals = jQuery('.returnProduct:checkbox:checked').map(function() {
            return this.value;
        }).get();
        var productIds = checkedVals.join(",");
        var splitProductId = productIds.split(',');
        var returnReasonId = [];
        var data = '';
        // console.log(str_array);
        for(var i = 0; i < splitProductId.length; i++) {
           // Trim the excess whitespace.
           returnReasonId.push(jQuery("#returnReason_" + splitProductId[i]).val());
           // Add additional code here, such as:
           
        }
        if(selectedReturnValue == 'RTN_REFUND') {         
          var accountHolderName = jQuery('#accountHolderName').val();
          var bankName = jQuery('#bankName').val();
          var accountNumber = jQuery('#accountNumber').val();
          var ifscCode = jQuery('#ifscCode').val();

          /*if(accountHolderName == '') {
            alert('Enter account holder Name.');
            return false;
          }
          if(bankName == '') {
            alert('Enter Bank Name');
            return false;
          }
          if(accountNumber == '') {
            alert('Enter Accouont Number');
            return false;
          }
          if(ifscCode == '') {
            alert('Enter IFSC code');
            return false;
          }
          */
          data += 'orderId=' + orderId + '&accountHolderName=' + accountHolderName + '&bankName=' + bankName + '&accountNumber=' + accountNumber + '&ifscCode=' + ifscCode + '&returnTypeId=' + selectedReturnValue + '&returnReasonId=' + returnReasonId + '&productIds=' +productIds;

        }
        data += 'orderId=' + orderId + '&returnTypeId=' + selectedReturnValue + '&returnReasonId=' + returnReasonId + '&productIds=' +productIds;
// alert(jQuery("#returnReason_00001_100044-1").val());
    // var orderId = jQuery(this).data('cancel-id');
    // var reasionId = jQuery('#cancelWindow_'+orderId).find('option:selected').attr('id');
    // var reasonComments = jQuery('#cancelWindow_'+orderId).find('textarea').attr('value');
    // var data = "";
    // data += 'orderId=' + orderId;
    // alert(data);
    loading();
    jQuery.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/returnOrder',
      data: data,
      success: function(data) {
        if (data['status'] == 'pass') {
          // alert(data['_EVENT_MESSAGE_']);
          // close_loading();
          document.location = Drupal.settings.basePath + 'account/orders';        
        } else {
          //alert(data['_ERROR_MESSAGE_']);
          var errormsgs = data['_ERROR_MESSAGE_'];
          jQuery("#return_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#return_errormsgs").focus();
          close_loading();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus + ': ' + errorThrown);
        close_loading();
      },
      dataType: 'json'
    });
    } else {
        alert("Please select item");
        return false;
      }
  }
    jQuery(".chkwallet").on('change', function() { 
      if(jQuery(this).is(":checked")) {        
        var chkval = 1;
        data = 'chkval=' + chkval;
        jQuery.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'account/store-credit',
          data: data,
          success: function(data) {
            console.log(data);
            if (data['isError'] == 'false' && data['status']=='Pass') {
              //alert(data['_EVENT_MESSAGE_']);
              close_loading(); 
              jQuery('#balance').show(); 
              jQuery("#balance").append('<div>' + data['remainingCartTotal'] + '</div>');       
              if(data['remainingCartTotal'] == 0){
                jQuery('#paymentOption').hide();
                jQuery('#placeOrderStoreCredit').show(); 
              }
              //document.location = Drupal.settings.basePath +'checkout-payment';
            } else {
              alert(data['_ERROR_MESSAGE_']);
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
      }else{
        var chkval = 0;
        data = 'chkval=' + chkval;
        jQuery.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'account/store-credit',
          data: data,
          success: function(data) {
            console.log(data);
            if (data['isError'] == 'false' && data['status']=='Pass') {
              //alert(data['_EVENT_MESSAGE_']);
              close_loading(); 
              jQuery('#balance').hide(); 
              if(data['remainingCartTotal'] != 0){
                jQuery('#paymentOption').show();                 
              }
            } else {
              alert(data['_ERROR_MESSAGE_']);
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
  });
});

/******Review page*****/
function reviewAction(){
  jQuery("#reviewForm").toggle();
}

jQuery(function($) {
  $("form[name='signUpForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      hastiSignIn();
    }
  });
  $("form[name='checkoutsignUpForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      hastiSignIn();
    }
  });
  $("form[name='signInForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      signInHasti();
    }
  });
$("form[name='chksignInForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      signInHasti();
    }
  });

  $("form[name='contactusForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      contactus();
    }
  });
  $("form[name='personalinfoForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      savePersonalInfo();
    }
  });
  $("form[name='addressForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      addAddress();
    }
  });
   $("form[name='editaddressForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      editAddress();
    }
  });
   $("form[name='forgotpwdForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      checkEmail();
    }
  });
   $("form[name='checkoutforgotpwdForm']").validate({
  showErrors: function(errorMap, errorList) {
        // Clean up any tooltips for valid elements
        $.each(this.validElements(), function (index, element) {
            var $element = $(element);
            $element.data("title", "") // Clear the title - there is no error associated anymore
                .removeClass("error")
                .tooltip("destroy");
        });
        // Create new tooltips for invalid elements
        $.each(errorList, function (index, error) {
            var $element = $(error.element);
            $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                .data("title", error.message)
                .addClass("error")
                .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
        });
    },
    submitHandler: function(form) {
      checkEmail();
    }
  });
  $("form[name='pinchkForm']").validate({
    showErrors: function(errorMap, errorList) {
          // Clean up any tooltips for valid elements
          $.each(this.validElements(), function (index, element) {
              var $element = $(element);
              $element.data("title", "") // Clear the title - there is no error associated anymore
                  .removeClass("error")
                  .tooltip("destroy");
          });
          // Create new tooltips for invalid elements
          $.each(errorList, function (index, error) {
              var $element = $(error.element);
              $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                  .data("title", error.message)
                  .addClass("error")
                  .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
          });
      },
      submitHandler: function(form) {
        checkPin();
      }
    });
$("form[name='cancelOrderForm']").validate({
    showErrors: function(errorMap, errorList) {
          // Clean up any tooltips for valid elements
          $.each(this.validElements(), function (index, element) {
              var $element = $(element);
              $element.data("title", "") // Clear the title - there is no error associated anymore
                  .removeClass("error")
                  .tooltip("destroy");
          });
          // Create new tooltips for invalid elements
          $.each(errorList, function (index, error) {
              var $element = $(error.element);
              $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                  .data("title", error.message)
                  .addClass("error")
                  .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
          });
      },
      submitHandler: function(form) {
        cancelOrder();
      }
    });

    $("form[name='refundForm']").validate({
    showErrors: function(errorMap, errorList) {
          // Clean up any tooltips for valid elements
          $.each(this.validElements(), function (index, element) {
              var $element = $(element);
              $element.data("title", "") // Clear the title - there is no error associated anymore
                  .removeClass("error")
                  .tooltip("destroy");
          });
          // Create new tooltips for invalid elements
          $.each(errorList, function (index, error) {
              var $element = $(error.element);
              $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                  .data("title", error.message)
                  .addClass("error")
                  .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
          });
      },
      submitHandler: function(form) {
        refundReturn();
      }
    });
  $("form[name='hasti_comments_fn']").validate({
    showErrors: function(errorMap, errorList) {
          // Clean up any tooltips for valid elements
          $.each(this.validElements(), function (index, element) {
              var $element = $(element);
              $element.data("title", "") // Clear the title - there is no error associated anymore
                  .removeClass("error")
                  .tooltip("destroy");
          });
          // Create new tooltips for invalid elements
          $.each(errorList, function (index, error) {
              var $element = $(error.element);
              $element.tooltip("destroy") // Destroy any pre-existing tooltip so we can repopulate with new tooltip content
                  .data("title", error.message)
                  .addClass("error")
                  .tooltip(); // Create a new tooltip based on the error messsage we just set in the title
          });
      },
      submitHandler: function(form) {
        return true;
      }
    });

  $('#signUpPop').click(function() {
    $("form").trigger('reset');
    $('#signup_errormsgs').html('');
  });

  $('#signInPop').click(function() {
    $("form").trigger('reset');
    $('#signup_errormsgs').html('');
  });
  
  $('#newmember_signup').click(function() {
    jQuery('#closetag').click();
    setTimeout(function () {
        jQuery('#signUpPop').click();
    }, 200);
      });  
});
