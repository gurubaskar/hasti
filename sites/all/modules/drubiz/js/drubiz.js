var mini_cart_timer = setTimeout('', 0);

(function ($) {

$(document).ready(function() {
  $('#size_guide_fancybox').click(function(event) {
      event.preventDefault();
      var id=$(this).attr('href');
      $('div#'+id).modal();
  });

  $("#close_chart").click(function(){
    $("#size_guide_fancy").hide();
  });

  

    $('#drubiz-language-selector').change(function() {
      Cookies.set(language_param, $(this).val());
      location.reload();
    });

    $('#removeStoreCredit').click(function(){
        loading();
        $.ajax({
              type: "POST",
              url: Drupal.settings.basePath + 'drubiz/remove-store-credit',
              data: '',
              success: function(data) {
                document.location = Drupal.settings.basePath + 'checkout-payment';
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

     $('#useStoreCredit').unbind('click').click(function(){
      $('#store_redeem').show();
    });

    $('#save_credit').click(function(){
      var creditAmount = $('#js_storeCreditAmount').val();
      var data='';
      if(creditAmount == ''){
        alert('Enter amount to be redeemed!')
      }
      else{
        //productStoreId=Globus_STORE&partyId=10030&storeCreditAmount=99
        data += 'creditAmount=' + creditAmount;
        loading();
          $.ajax({
              type: "POST",
              url: Drupal.settings.basePath + 'drubiz/store-credit',
              data: data,
              success: function(data) {
                //alert(data['partyAppliedStoreCreditTotal']);
                if(data['status']=='Success'){
                document.location = Drupal.settings.basePath + 'checkout-payment';
                close_loading();
              }
            else if((data['status']=='Fail') && (data['isError']=='true')){
                alert(data['_ERROR_MESSAGE_']);
                $('#creditErrorInfo').empty();
                $('#creditErrorInfo').append('<div>'+ data['_ERROR_MESSAGE_']+'</div>');
                $('#js_storeCreditAmount').val('');
                close_loading();
        }
        else {
          close_loading();
        }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                alert('Store credit could be applied.');
                console.log(textStatus + ': ' + errorThrown);
                close_loading();
              },
              dataType: 'json'
          });
      }
    });
   

 /*   $('#js_useLoyalty').change(function(){
      if (!($('#js_useLoyalty:checked').val())){
        //http://localhost:8080/globus/multiPageRemoveStoreCreditNew
        $('#js_loyaltyAmount').hide();
        $('#loyaltyRedeem').hide();
        $('#js_loyaltyAmountRedeem').hide();
        loading();
        $.ajax({
              type: "POST",
              url: Drupal.settings.basePath + 'drubiz/remove-loyalty',
              data: '',
              success: function(data) {
              if(data['_ERROR_MESSAGE_']!=undefined){
                 alert(data['_ERROR_MESSAGE_']);
                 close_loading();
               } 
              else if (data['status']=='pass' && data['isError']=='false') {      
                 document.location = Drupal.settings.basePath + 'checkout-payment';
                 close_loading();
               }
               else {
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
        $('#js_loyaltyAmountRedeem').show();
        $('#loyaltyRedeem').show();
        $('#js_loyaltyAmount').show();
      }
    });

    $('#loyaltyRedeem').click(function(){
      var loyaltyAmount = $('#js_loyaltyAmount').val();
      var data='';
      if(loyaltyAmount == ''){
        alert('Enter amount to be redeemed!')
      }
      else{
        //productStoreId=Globus_STORE&partyId=10030&storeCreditAmount=99
        data += 'loyaltyAmount=' + loyaltyAmount;
        loading();
          $.ajax({
              type: "POST",
              url: Drupal.settings.basePath + 'drubiz/redeem-loyalty',
              data: data,
              success: function(data) {
                if ((data['status']=='pass') && (data['isError']=='false')) {
                document.location = Drupal.settings.basePath + 'checkout-payment';
                close_loading();
               }
              else if((data['status']=='fail') && (data['isError']=='true')){
                alert(data['errorInfo']);
                $('#loyaltyErrorInfo').empty();
                $('#loyaltyErrorInfo').append('<div>'+ data['errorInfo']+'</div>');
                $('#js_loyaltyAmount').val('');
                close_loading();
               }
              else {
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
    });*/

  $('#addCartlist').mouseover(function() {
    if ($('#js_lightCart').length == 0) {
      $(this).after('<div id="js_lightCart" class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable lightCart_displayDialog js_lightBoxCartContainer" tabindex="-1" style="outline: 0px; z-index: 1013; width: auto; top: 50px; left: -123% !important; min-height: 200px; max-height: 300px; min-width: 300px !important; display: block; overflow-y: scroll; margin-top: 0px; margin-bottom: 0px; background-color: #fff;" role="dialog">  <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" id="js_lightBoxCartTitleBar" style="width: 0px;"> <span id="ui-id-15" class="ui-dialog-title">&nbsp;</span>    <a href="#" style="right: 0.3em; top: 50%; background-color: #fff;" class="ui-dialog-titlebar-close ui-corner-all" role="button"><span class="ui-icon ui-icon-closethick">close</span></a>  </div><div id="lightCart_inner" style="padding: 1em;"></div></div>');
      $('#lightCart_inner').html($('#cartLightform').html());
      $('#js_lightCart .ui-dialog-titlebar-close').click(function() {
        $('#js_lightCart').fadeOut(function() {
          $('#js_lightCart').remove();
        });
      });

      mini_cart_timer = setTimeout(function() {
        $('#js_lightCart .ui-dialog-titlebar-close').click();
      }, 2000);

      $('#js_lightCart').mouseover(function() {
        // console.log('mini cart mouseover');
        clearTimeout(mini_cart_timer);
      });

      $('#js_lightCart').mouseleave(function() {
        // console.log('mini cart mouseout');
        mini_cart_timer = setTimeout(function() {
          $('#js_lightCart .ui-dialog-titlebar-close').click();
        }, 1000);
      });
    }
  });

  $('#login_btn').click(function(e) {
    e.preventDefault();

    var $form = $(this).closest('form');
    var data_USERNAME = $form.find('[name=USERNAME]:first').val();
    var data_PASSWORD = $form.find('[name=PASSWORD]:first').val();

    loading();
    $.ajax({
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
  });


  $('#js_applyLoyaltyCard').click(function(e) {
    e.preventDefault();
        loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/view-loyalty',
      success: function(data) {
        console.log(data);
        if (data['status']=='pass') {
          $('#js_applyLoyaltyCard').hide();
          $('#loyaltyInfo').empty();
          $('#loyaltyInfo').append('<div>Points Available:'+data['totalPoints']+'</div>');
          $('#loyaltyInfo').show();
          $('#js_redeemLoyaltyPoints').val('');
          $('#hidloyalpts').val(data['totalPoints']);
          $('#redmpts').show();
          close_loading();              
        }
        else if((data['status']=='fail') && (data['totalPoints']=='0')){
           $('#js_applyLoyaltyCard').hide();
           $('#loyaltyInfo').append('<div>Loyalty Amount:'+data['totalPoints'] +'<br>Since you have not made any purchase so far, your loyalty account balance is '+data['totalPoints'] +'</div>');
           close_loading();
         }
        else{
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

  $('#js_redeemLoyalty').click(function(e) {
    e.preventDefault();
    var loyalpoints = $("#js_redeemLoyaltyPoints").val();
    var avlloyalpts = $('#hidloyalpts').val();
    if(Number(loyalpoints)>Number(avlloyalpts)){
       $('#loyaltyErrorInfo').empty();
       $('#loyaltyErrorInfo').append('<div>Sry,you have only'+ avlloyalpts+' Points to redeem.</div>');
       $('#js_redeemLoyaltyPoints').val('');
     }
     else{
    var data = '';
    data += 'loyalpoints=' + loyalpoints;
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/redeem-loyalty',
      data: data,
      success: function(data) {
        //console.log(data);
        if ((data['status']=='pass') && (data['isError']=='false')) {
          call_cart();
          $('#loyaltyErrorInfo').empty();
          $('#js_applyLoyaltyCard').hide();
          $('#redmpts').hide();
          $('#loyaltyInfo').empty();
          $('#loyaltyInfo').append('<div>Redeeming Loyalty Points:' + data['redeemedpoints']+ '<br>Adjustment Amount:'+ data['adjustmentAmount']+'<br>Total RewardPoints Available:'+data['totalRewardPoints']+'</div>');
          $('#js_removeLoyalty').show();
          close_loading();              
        }
        else if((data['status']=='fail') && (data['isError']=='true')){
         // alert(data['errorInfo']);
         $('#loyaltyErrorInfo').empty();
         $('#loyaltyErrorInfo').append('<div>'+ data['errorInfo']+'</div>');
          $('#js_redeemLoyaltyPoints').val('');
          close_loading();
        }
        else {
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

  $('#js_removeLoyalty').click(function(e) {
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/remove-loyalty',
      success: function(data) {
        console.log(data);
        if(data['_ERROR_MESSAGE_']!=undefined){
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else if (data['status']=='pass' && data['isError']=='false') {
         // call_cart();
          document.location = Drupal.settings.basePath + 'cart';
          close_loading();              
        }
        else {
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

   $('#promoapply').click(function(e) {
    e.preventDefault();
    var promo_code = $("#js_manualOfferCode").val();
    var data = '';
    data += 'promo_code=' + promo_code;
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/apply-promo',
      data: data,
      success: function(data) {
        console.log(data);
        if ((data['fieldLevelErrors']=='Y') && ((data['_ERROR_MESSAGE_LIST_']) != undefined)) {
           $('#coupon_codes').empty();
          $('#coupon_apply').empty(); 
           $('#coupon_apply').append('<div class="fieldErrorMessage" id="promotionError">'+data['_ERROR_MESSAGE_LIST_'][0]['message']+'</div>');
           $('#coupon_apply').show();
           close_loading();              
        }
        else if((data['fieldLevelErrors'] == undefined) && (data['_WARNING_MESSAGE_']!= undefined)){
          $('#coupon_codes').empty();
          $('#coupon_apply').empty(); 
          $('#coupon_apply').append('<div class="fieldErrorMessage" id="promotionError">'+data['_WARNING_MESSAGE_']+'</div>');
          $('#coupon_apply').show();
          close_loading(); 
        }
         else if((data['status']=='fail') && (data['iserror']=='true')){
          $('#coupon_codes').empty();
          $('#coupon_apply').empty(); 
          $('#coupon_apply').append('<div class="fieldErrorMessage" id="promotionError">'+data['_ERROR_MESSAGE_']+'</div>');
          $('#coupon_apply').show();
          close_loading(); 
        }
        else if(data['status']=='Pass'){
          document.location = Drupal.settings.basePath + 'cart';
          close_loading();              
        }
        else {
          close_loading();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('We are facing some technical difficulties at the moment. Please try again after some time.');
        //console.log(textStatus + ': ' + errorThrown);
        close_loading();
      },
      dataType: 'json'
    });
  });
  
   $("#google_login").click(function(){
    $('#edit-submit-google').closest('form').parent().show();
    $('.ui-dialog-titlebar-close').click()
    $('#edit-submit-google').click();
   });
  


/*  $('#promoview').click(function(e) {
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/view-promo',
      success: function(data) {
        console.log(data);
        if (data['status']=='pass') {
		  $('#coupon_codes').empty();
          $('#coupon_codes').append(data['couponcode']);
          close_loading();
        }
        else {
          alert('Sry, there are no promoCodes available');
          //alert(data['error_messages'].join("\n"));
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
  */

  $('#apply_coupon').click(function(e){
    $('#js_manualOfferCode').val();
    });
  

  $('#signup_btn').click(function(e) {
    e.preventDefault();

    var $form = $(this).closest('form');
    var data_USERNAME = $form.find('[name=USERNAME]:first').val();
    var data_PASSWORD = $form.find('[name=PASSWORD]:first').val();

    var data_firstName                  = $form.find('[name=firstName]:first').val();
    var data_lastName                   = $form.find('[name=lastName]:first').val();
    var data_PHONE_MOBILE_CONTACT_OTHER = $form.find('[name=PHONE_MOBILE_CONTACT_OTHER]:first').val();
    var data_dobLongDayUs               = $form.find('[name=dobLongDayUs]:first').val();
    var data_dobLongMonthUs             = $form.find('[name=dobLongMonthUs]:first').val();
    var data_dobLongYearUs              = $form.find('[name=dobLongYearUs]:first').val();
    var data_USER_GENDER                = $form.find('[name=USER_GENDER]:first').val();
    var data_userLoginId                = $form.find('[name=userLoginId]:first').val();
    var data_currentPassword            = $form.find('[name=currentPassword]:first').val();
    var data_currentPasswordVerify      = $form.find('[name=currentPasswordVerify]:first').val();

    var data = 'firstName=' + encodeURIComponent(data_firstName) + '&lastName=' + encodeURIComponent(data_lastName) + '&PHONE_MOBILE_CONTACT_OTHER=' + encodeURIComponent(data_PHONE_MOBILE_CONTACT_OTHER) + '&dobLongDayUs=' + encodeURIComponent(data_dobLongDayUs) + '&dobLongMonthUs=' + encodeURIComponent(data_dobLongMonthUs) + '&dobLongYearUs=' + encodeURIComponent(data_dobLongYearUs) + '&USER_GENDER=' + encodeURIComponent(data_USER_GENDER) + '&userLoginId=' + encodeURIComponent(data_userLoginId) + '&currentPassword=' + encodeURIComponent(data_currentPassword) + '&currentPasswordVerify=' + encodeURIComponent(data_currentPasswordVerify);

    loading();
    $.ajax({
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
  });

  $('.product-choose-facet').click(function(e) {
    e.preventDefault();
    var product_id = $(this).data('product-id');
    $(this).closest('ul').find('a.selected').removeClass('selected');
    $(this).closest('a').addClass('selected');
    $(this).closest('a').find('li').css("border", "red solid 1px");
  });
  $('#js_addToCart, #js_addToCart_buynow, .plp-add-to-cart').click(function(e) {
    e.preventDefault();
    if ($(this).hasClass('plp-add-to-cart')) {
      var product_id = $(this).data('product-id');
      var quantity = 1;
    }
    else {
      var product_id = $('.js_selectableFeature_1 a.selected').data('product-id');
      var quantity = 1; // commented due to no quantity selectable. $('#quantity').val();
    }
    if(product_id == null || product_id == undefined){
      alert('Please select a size of your choice');
      return;
    }
    var action = $(this).attr('id') == 'js_addToCart_buynow' ? 'buy_now' : 'add';
    var action1 = $(this).attr('id') == 'js_addToCart' ? 'add' : 'plp';
    // alert(action + ' - ' + product_id + ' | ' + quantity);
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/add-to-cart',
      data: 'product_id=' + product_id + '&quantity=' + quantity,
      success: function(data) {
        // console.log(data);
        if (data['isError'] == 'false') {
          if (action == 'buy_now') {
            document.location = Drupal.settings.basePath + 'checkout-payment';
          }
          else if(action == 'add' && action1 == 'add') {
            update_mini_cart();
            document.location = Drupal.settings.basePath + 'cart';
          } else {
            jQuery.notify("1 Item added to the cart.");
            update_mini_cart();
          }
        }
        else {
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
  
  $('#js_addToWishlist, .plp-add-to-wishlist').click(function(e) {
    e.preventDefault();
    var product_id = $('.pdpSelectableFeature a.selected:first li').data('product-id');
    var quantity =  1;
    if ($(this).hasClass('plp-add-to-wishlist')) {
      var product_id = $(this).data('product-id');
      var quantity = 1;
    }
    if(product_id == undefined || product_id == null){
      alert('Please select a variant');
      return;
    }
    // alert(product_id+'--'+quantity);
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/add-to-love-list',
      data: 'product_id=' + product_id + '&quantity=' + quantity,
      success: function(data) {
             //console.log(data);
        if (data['isError'] == 'False') {
          close_loading();
        }
        else {
          alert(data['_EVENT_MESSAGE_']+' Error adding item.');
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

  $('.remove').click(function(e) {
    e.preventDefault();
    var index = $(this).data('delete-id');
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/delete-item',
      data: 'index=' + index,
      success: function(data) {
        // console.log(data);
        if (data['isError'] == 'false') {
          document.location = Drupal.settings.basePath + 'cart';
        }
        else {
          alert('Error deleting item.');
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

  $('.cart-product-edit').click(function(e) {
    e.preventDefault();
    var product_id = $(this).closest('.cartItem').data('product-id');
    $(this).hide();
    $(this).closest('.cartItem').find('.cart-product-update').show();
    $(this).closest('.cartItem').find('.item-qt').show();
    $(this).closest('.cartItem').find('.qty-number').hide();
  });

  $('.qty-plus, .qty-minus').click(function(e) {
    e.preventDefault();
    var index = $(this).data('index');
    var class_name =  $(this).attr('class');
    var quantity = $('.qty').html();
      if(class_name == "qty-plus"){
        quantity = Number(quantity) + 1;
      }else{
        if(Number(quantity) <= Number(1)){
          alert('Quantity cannot be zero');
          return 0;
        }else{
          quantity = Number(quantity) - 1;
        }
      }
    /*$(this).hide();
    $(this).closest('.cartItem').find('.cart-product-edit').show();
    $(this).closest('.cartItem').find('.item-qt').hide();
    $(this).closest('.cartItem').find('.qty-number').show();*/
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/modify-item',
      data: 'index=' + index + '&quantity=' + quantity,
      success: function(data) {
        // console.log(data);
        if (data['isError'] == 'false') {
          document.location = Drupal.settings.basePath + 'cart';
        }
        else {
          alert('Error modifying item.');
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

  $('#js_submitCartBtn').click(function(e) {
    e.preventDefault();
    loading();
    document.location = Drupal.settings.basePath + 'checkout';
  });

  $('#js_chooseAddressBtn').click(function(e) {
    e.preventDefault();
    var $address = $('input.SHIPPING_SELECT_ADDRESS:checked');
    var post_data = 'contactMechId='+encodeURIComponent($address.val());

    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'checkout/update-cart-address',
      data: post_data,
      success: function(data) {
        if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
          document.location = Drupal.settings.basePath + 'checkout-payment';
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

  $('#js_submitAddressBtn').click(function(e) {
    e.preventDefault();
    if($('#js_SHIPPING_POSTAL_CODE_NEW').val() == ''){
              alert('Enter Postal Code.');
              return false;
          }
          if($('#js_SHIPPING_ATN_NAME').val() == ''){
              alert('Enter Address type.');
              return false;
          }
          if($('#js_SHIPPING_FIRST_NAME_NEW').val() == ''){
              alert('Enter First Name.');
              return false;
          }
          if($('#js_SHIPPING_LAST_NAME_NEW').val() == ''){
              alert('Enter Last Name.');
              return false;
          }
          if($('#js_SHIPPING_ADDRESS1_NEW').val() == ''){
              alert('Enter Address.');
              return false;
          }
          if($('#js_SHIPPING_CITY_NEW').val() == ''){
              alert('Enter City.');
              return false;
          }
          if($('#js_SHIPPING_STATE_NEW').val() == ''){
              alert('Enter State.');
              return false;
          }
          if($('#PHONE_MOBILE_CONTACT_NEW').val() == ''){
              alert('Enter Mobile Number.');
              return false;
          }
    var data_SHIPPING_POSTAL_CODE = $('[name=SHIPPING_POSTAL_CODE]:first').val();
    var data_SHIPPING_ADDRESS1    = $('[name=SHIPPING_ADDRESS1]:first').val();
    var data_SHIPPING_FIRST_NAME  = $('[name=SHIPPING_FIRST_NAME]:first').val();
    var data_SHIPPING_LAST_NAME   = $('[name=SHIPPING_LAST_NAME]:first').val();
    var data_SHIPPING_ATTN_NAME   = $('[name=SHIPPING_ATTN_NAME]:first').val();
    var data_SHIPPING_CITY        = $('[name=SHIPPING_CITY]:first').val();
    var data_PHONE_MOBILE_LOCAL   = $('[name=PHONE_MOBILE_LOCAL]:first').val();
    var data_PHONE_MOBILE_CONTACT = $('[name=PHONE_MOBILE_CONTACT]:first').val();
    var data_SHIPPING_STATE       = $('[name=SHIPPING_STATE]:first').val();

    var post_data = 'SHIPPING_POSTAL_CODE='+encodeURIComponent(data_SHIPPING_POSTAL_CODE)+'&SHIPPING_ADDRESS1='+encodeURIComponent(data_SHIPPING_ADDRESS1)+'&SHIPPING_FIRST_NAME='+encodeURIComponent(data_SHIPPING_FIRST_NAME)+'&SHIPPING_LAST_NAME='+encodeURIComponent(data_SHIPPING_LAST_NAME)+'&SHIPPING_ATTN_NAME='+encodeURIComponent(data_SHIPPING_ATTN_NAME)+'&SHIPPING_CITY='+encodeURIComponent(data_SHIPPING_CITY)+'&PHONE_MOBILE_LOCAL='+encodeURIComponent(data_PHONE_MOBILE_LOCAL)+'&PHONE_MOBILE_CONTACT='+encodeURIComponent(data_PHONE_MOBILE_CONTACT)+'&SHIPPING_STATE='+encodeURIComponent(data_SHIPPING_STATE);

    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/add-address',
      data: post_data,
      success: function(data) {
        if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
          document.location = Drupal.settings.basePath + 'checkout-payment';
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

  $('#js_submitOrderBtn, .hastiCOD').click(function(e) {
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'checkout-final',
      success: function(data) {
         console.log(data);
        if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
          document.location = Drupal.settings.basePath + 'view-order/' + encodeURIComponent(data['orderId']);
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

  $('#COD').click(function(e) {
    $('#sendOTP').show();
    $('#onlineProceed').hide();
    $('#displayOTP').hide();
    $('#placeOrderOTP').hide();
  });

  $('#Online').click(function(e) {
    $('#onlineProceed').show();
    $('#sendOTP').hide();
    $('#displayOTP').hide();
    $('#placeOrderOTP').hide();
  });

  $('.sendOTP').click(function(e) {
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'send-otp',
      success: function(data) {
         console.log(data);
        if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
          close_loading();
          $('#sendOTP').hide();
          $('#displayOTP').show();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('We are facing some technical difficulties at the moment. Please try again after some time.');
        close_loading();
      },
      dataType: 'json'
    });
  });

$('.validateOTP').click(function(e) {
    var otp = $('#OTPValue').val();
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'validate-otp',
      data: 'otp=' + otp,
      success: function(data) {
        if (data['status'] == 'fail' && data['isError'] == 'true') {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
           close_loading();
           $('#placeOrderOTP').show();
           $('#paymentOption').hide();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('We are facing some technical difficulties at the moment. Please try again after some time.');
        close_loading();
      },
      dataType: 'json'
    });
  });

  $('.placeOrderBtn').click(function(e) {
    e.preventDefault();
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'checkout-final',
      success: function(data) {
        if (data['status'] == 'fail' && data['isError'] == 'true') {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
           document.location = Drupal.settings.basePath + 'view-order/' + encodeURIComponent(data['orderId']);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('We are facing some technical difficulties at the moment. Please try again after some time.');
        close_loading();
      },
      dataType: 'json'
    });
  });


  $('#subscribeMail').click(function(){
    $('#subMsg').empty();
    var subscriberEmail = document.getElementById('newsletter').value;
    var data = '';
    data += '&subscriberEmail=' + subscriberEmail;
    $.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'drubiz/lookbook',
          data: data,
          success: function(data) {
            if (typeof data['_SUCCESS_MESSAGE_'] != 'undefined' && data['_SUCCESS_MESSAGE_'].length > 0) {
                $('#subMsg').append('Thank you for subscribing.');
              }
              if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
                $('#subMsg').append(data['_ERROR_MESSAGE_']);
              }
            console.log(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            close_loading();
          },
          dataType: 'json'
        });
  });

      $(".addToCartFromWishlistGlobular").click(function(){
        var product_id = $(this).data('product-id');
        var quantity = $(this).data('quantity');
        var sequenceId = $(this).data('delete-id');
        if(quantity == undefined || quantity == null){
            quantity = 1;
        }
        loading();
        $.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'drubiz/add-to-cart',
          data: 'product_id=' + product_id + '&quantity=' + quantity,
          success: function(data) {
            console.log(data);
            if (data['isError'] == 'false') {
                if(remove_wishlist(sequenceId) == 'true'){
                  document.location = Drupal.settings.basePath + 'cart';
                }
                close_loading();
            }else {
              alert('Error adding item.');
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


  $('.wish-delete').click(function(e){
    e.preventDefault();
    var sequenceId = jQuery(this).data('delete-id');
      jQuery.ajax({
          type: "POST",
          url: Drupal.settings.basePath + 'delete-wishlist',
          data: 'sequenceId=' + sequenceId,
          success: function(data) {
             //console.log(data);
            if (data['isError'] == 'false') {
                document.location = Drupal.settings.basePath + 'account/love-list';
            }
            else {
              alert('Server Down! Please try again Later');
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
          },
          dataType: 'json'
        });
  })
  jQuery(function($) {
  $("form[name='changepwdForm']").validate({
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
      submitChangePasswd();
    }
  })
});

  //$('#js_submitChangePasswdBtn').click(function(e) {
  function submitChangePasswd(){
   // e.preventDefault();
    
    var data_OLD_PASSWORD     = $('[name=OLD_PASSWORD]:first').val();
    var data_NEW_PASSWORD     = $('[name=NEW_PASSWORD]:first').val();
    var data_CONFIRM_PASSWORD = $('[name=CONFIRM_PASSWORD]:first').val();

    var post_data = 'OLD_PASSWORD=' + encodeURIComponent(data_OLD_PASSWORD) + '&NEW_PASSWORD=' + encodeURIComponent(data_NEW_PASSWORD) + '&CONFIRM_PASSWORD=' + encodeURIComponent(data_CONFIRM_PASSWORD);
    //alert(post_data);
    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'drubiz/user-change-password',
      data: post_data,
      success: function(data) {
        // console.log(data);
        if (data['error']) {
         // alert("Error updating password!\n" + data['error_messages'].join("\n"));
          var errormsgs = data['error_messages'].join("\n");
          jQuery("#signup_errormsgs").html('<span class="err_msgs">'+errormsgs+'</span>');
          jQuery("#signup_errormsgs").focus();
           close_loading();
        }
        else {
          alert(data['error_messages']);
          document.location = Drupal.settings.basePath + 'user/logout';
        }
        close_loading();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('We are facing some technical difficulties at the moment. Please try again after some time.');
        console.log(textStatus + ': ' + errorThrown);
        close_loading();
      },
      dataType: 'json'
    });
  }

  $('#js_submitProfileBtn').click(function(e) {
    e.preventDefault();

    var data_USER_FIRST_NAME  = $('[name=USER_FIRST_NAME]:first').val();
    var data_USER_LAST_NAME   = $('[name=USER_LAST_NAME]:first').val();

    var post_data = 'USER_FIRST_NAME='+encodeURIComponent(data_USER_FIRST_NAME)+'&USER_LAST_NAME='+encodeURIComponent(data_USER_LAST_NAME);

    loading();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'account/update-profile',
      data: post_data,
      success: function(data) {
        if (typeof data['_ERROR_MESSAGE_'] != 'undefined' && data['_ERROR_MESSAGE_'].length > 0) {
          alert(data['_ERROR_MESSAGE_']);
          close_loading();
        }
        else {
          document.location = Drupal.settings.basePath + 'account/profile';
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

  $("#giftMessageEnum").change(function(e){
    $('#giftMessageText').val($("#giftMessageEnum :selected").text());
  });

  $('.giftMessageSave').click(function(e){
    var giftFrom = $('#from').attr('value');
    var giftTo = $('#to').attr('value');
    var cartLine = $('#cartLine').attr('value');
    var msgText = $('#giftMessageText').val();
    $.ajax({
      type: "POST",
      url: Drupal.settings.basePath + 'saveGiftMessage',
      data: 'cartLine=' + cartLine + '&giftFrom=' + giftFrom + '&giftTo=' + giftTo + '&msgText=' + msgText,
      success: function(data){
        if(data['error']){
            alert("Error setting the gift message!\n" + data['error_messages'].join("\n"));
        }else{
            document.location = Drupal.settings.basePath + 'cart';
        }
      },
      dataType: 'json'

    });
  });

  $('input.searchSubmit,input.searchGlowingSubmit').click(function(e) {
    e.preventDefault();
    var search_text = $('#searchText').val().replace(/[^a-z0-9\s\.'"]+/ig, '');
    if (search_text.length == 0) {
      alert(Drupal.t('Please enter some search terms'));
      $('#searchText').focus();
    }
    else {
      document.location = Drupal.settings.basePath + 'search/site/' + encodeURIComponent(search_text);
    }
  });


  $('#searchText').keyup(function(e) {
    if (e.which == 13) {
      e.preventDefault();
      // Enter key.
      $('input.searchSubmit:first').click();
    }
  });
  $('.button_font').click(function(){
        if($('#js_CUSTOMER_POSTAL_CODE').val() == ''){
              alert('Enter Postal Code.');
              return false;
          }
          if($('#js_CUSTOMER_FIRST_NAME').val() == ''){
              alert('Enter First Name.');
              return false;
          }
          if($('#js_CUSTOMER_LAST_NAME').val() == ''){
              alert('Enter Last Name.');
              return false;
          }
          if($('#PHONE_MOBILE_CONTACT').val() == ''){
              alert('Enter Mobile Number.');
              return false;
          }
          if($('#js_CUSTOMER_ATTN_NAME').val() == ''){
              alert('Enter Address type.');
              return false;
          }
          if($('#js_CUSTOMER_ADDRESS1').val() == ''){
              alert('Enter Address.');
              return false;
          }
          if($('#js_CUSTOMER_CITY').val() == ''){
              alert('Enter City.');
              return false;
          }
          if($('#js_CUSTOMER_STATE').val() == ''){
              alert('Enter State.');
              return false;
          }
  });

  $('#search_sort').change(function(e) {
    e.preventDefault();
    var search_sort = $(this).val();
    var current_search_without_sort = document.location.search.replace(/\&*solrsort.*?(asc|desc)\&*/, '');
    var final_destination = document.location.pathname + current_search_without_sort;
    if (final_destination.indexOf('?') == -1) {
      final_destination += '?';
    }
    if (search_sort.length > 0) {
      final_destination += ('&solrsort=' + encodeURIComponent(search_sort));
    }
    document.location = final_destination;
  });

  update_mini_cart();

  $('#drubiz-demo-admin-change-theme').change(function() {
    document.location = Drupal.settings.basePath + '?drubiz_demo_theme=' + $(this).val();
  });

  $(".apply_cpn").click(function(){
   var code = $(this).attr('data-coupon-value');
   document.getElementById('js_manualOfferCode').value = code;
   $('#myModal').hide();
   $('.jquery-modal').hide(); 
  });

  $('.close').click(function(){
    $('#myModal').hide();
   $('.jquery-modal').hide();
  });
  $('#promoview').click(function(event) {
    console.log('this also triggering');
    event.preventDefault();
    var id=$(this).attr('href');
    $('div#'+id).modal(); 
  });

});

function update_mini_cart() {
  $.ajax({
    type: "GET",
    url: Drupal.settings.basePath + 'drubiz/mini-cart',
    success: function(data) {
      console.log(data);
      $('.cost').html('&#8377.'+ data['cartSubTotal']);
      $('#mini-cart-count').html(Object.keys(data['cartItemDetails']).length);
      close_loading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus + ': ' + errorThrown);
    },
    dataType: 'json'
  });
}

})(jQuery);

function loading() {
  // add the overlay with loading image to the page
  var over = '<div id="overlay">' +
    '<img id="ajax-loading" src="' + Drupal.settings.basePath + 'sites/all/modules/drubiz/images/ajax-loader.gif">' +
    '<p id="ajax-loading-message">' + Drupal.t('Please wait...') + '</p>' +
    '</div>';
  jQuery(over).appendTo('body');

  // click on the overlay to remove it
  // jQuery('#overlay').click(function() {
  //   jQuery(this).remove();
  // });

  // hit escape to close the overlay
  // jQuery(document).keyup(function(e) {
  //   if (e.which === 27) {
  //     close_loading();
  //   }
  // });
};

function close_loading() {
  jQuery('#overlay').remove();
}
function submitAddress(form_name){
   jQuery('#'+form_name).submit();
}

function remove_wishlist(sequenceId){
  var flag = 'true';
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'delete-wishlist',
    data: 'sequenceId=' + sequenceId,
    success: function(data) {
      console.log(data);
      if (data['isError'] == 'false') {
        //document.location = Drupal.settings.basePath + 'account/love-list';
        
      }
      else {
        alert('Server Down! Please try again Later');
        flag = 'false';
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus + ': ' + errorThrown);
      flag = 'false';
    },
    dataType: 'json'
  });
  return flag;
}

function showPlpSizeGuide(selectFeatureDiv, productId) {
  jQuery(".js_selectableFeature1_1").hide();
  var data = "";
  data += 'productId=' + productId;
  loading();
       jQuery.ajax({
          type: 'POST',
          url: Drupal.settings.basePath + 'drubiz/plp-check-inventory',
          data : data,
          success: function(data){
            console.log(data);
            var all_pid = Object.keys(data['inventoryProductLevel']);
            for(var i =0 ; i< all_pid.length ; i++){
              var pid = all_pid[i];
              var ppid = '';
              if(data['inventoryProductLevel'][pid]['availableQuantity'] == '0'){
              ppid = pid;
              jQuery("#js_selectableFeature_li_"+selectFeatureDiv).find('.js_selectableFeature_1').find('li').each(function() {
                  //  $(this).show();
                    if($(this).value == ppid){
                      jQuery(this).find('a').addClass('disableClass').slideToggle();
                    }
                });
              }
            }
            jQuery("#js_selectableFeature_li_"+selectFeatureDiv).slideToggle();
            close_loading();
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert("Server down. Please try again later!")
            close_loading();
          },
          dataType:'json'
       });
       
}

function showPlpSizeGuide1(selectFeatureDiv , productId) {
      //jQuery("#js_selectableFeature_li_"+selectFeatureDiv).slideToggle();
   /*   if(isVisible12){
        sizeplp=false;
        }
        else{
        sizeplp=true;
        }
     */
     jQuery(".js_selectableFeature_1").hide();
     var data = "";
  data += 'productId=' + productId;
  loading();
       jQuery.ajax({
          type: 'POST',
          url: Drupal.settings.basePath + 'drubiz/plp-check-inventory',
          data : data,
          success: function(data){
            console.log(data);
            var all_pid = Object.keys(data['inventoryProductLevel']);
            for(var i =0 ; i< all_pid.length ; i++){
              var pid = all_pid[i];
              var ppid = '';
              if(data['inventoryProductLevel'][pid]['availableQuantity'] == '0'){
              ppid = pid;
              jQuery("#js_selectableFeature1_li_"+selectFeatureDiv).find('.js_selectableFeature1_1').find('li').each(function() {
                   // $(this).show();
                    if($(this).value == ppid){
                      jQuery(this).find('.plp-add-to-wishlist').addClass('disableClass').slideToggle();
                    }
                });
              }
            }
            var isVisible12 = jQuery("#js_selectableFeature1_li_"+selectFeatureDiv).is(":visible");
    jQuery("#size-wrapper").html('');
    jQuery("#size-wrapper").html(wishListContent);
      jQuery("#js_selectableFeature1_li_"+selectFeatureDiv).slideToggle();
            close_loading();
          },
          error: function(jqXHR, textStatus, errorThrown){
            alert("Server down. Please try again later!")
            close_loading();
          },
          dataType:'json'
       });
}

 function call_cart(){
  jQuery.ajax({
    type: "POST",
    url: Drupal.settings.basePath + 'cart',
    data: 'flag=' + true,
    success: function(data) {
      console.log(data);
      if (data['isError'] == 'false') {
        //document.location = Drupal.settings.basePath + 'account/love-list';
        if(data['LoyaltyAmount'] >= 0){
          jQuery('.loyaltyPoint').empty();
          jQuery('.oc-summry').after('<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems"><div><label>Loyalty Amount:</label><span>-$'+ data['LoyaltyAmount'].toFixed('2')+'</span></div></li>');
          jQuery('.totalAmount').empty();
          if((data['partyAppliedStoreCreditTotal'])!='0'){
            var grandtotal=data['orderGrandTotal'] - data['partyAppliedStoreCreditTotal'];
           jQuery('.showCartOrderItemsSummaryShippingAmount').after('<li class="currency totalAmount showCartOrderItemsSummaryTotalAmount"><div><label>Total:</label><span>$'+grandtotal+'</span></div></li>'); 
          }else{
          jQuery('.showCartOrderItemsSummaryShippingAmount').after('<li class="currency totalAmount showCartOrderItemsSummaryTotalAmount"><div><label>Total:</label><span>$'+data['orderGrandTotal']+'</span></div></li>');
          }
        }
      }
      else {
        alert('Server Down! Please try again Later');
        flag = 'false';
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus + ': ' + errorThrown);
      flag = 'false';
    },
    dataType: 'json'
  });
} 
