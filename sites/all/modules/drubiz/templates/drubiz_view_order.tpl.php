<?php //krumo($order) ?>
<?php $cartItems = $order['OrderItemList']; ?>
<div id="eCommerceMainPanel" class="mainPanel">
<!-- Begin Screen component://osafe/widget/EcommerceScreens.xml#pageTitle -->
<!-- Begin Template component://osafe/webapp/osafe/common/pageTitle.ftl -->





<div class="content navigation siteHeaderNavigation" id="eCommerceNavBar" style="display:none;">
  <ul id="eCommerceNavBarMenu">
    <!-- <div id="magazine"> <a href="#"><span>Read Magazine</span></a><div> -->
  </ul>
</div>
<!-- End Template component://osafe/webapp/osafe/common/pageTitle.ftl -->
<!-- End Screen component://osafe/widget/EcommerceScreens.xml#pageTitle -->
<!-- Begin Section Widget  -->
<!-- End Section Widget  -->
<!-- Begin Section Widget  -->
<div id="multiPageOrderConfirm" class="multiPageOrderConfirm">
<!-- Begin Template component://osafe/webapp/osafe/templates/commonCheckout.ftl -->
<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#entryFormJS -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/js/formEntryJS.ftl -->
<script type="text/javascript">

  lastFocusedName = null;
  function setLastFocused(formElement) {
    lastFocusedName = formElement.name;
  }

  function changeEmail() {
    jQuery('#js_USERNAME').val(jQuery('#js_CUSTOMER_EMAIL').val());
  }
  
  jQuery(document).ready(function () 
  {
    jQuery(window).resize(function() {
    jQuery('.characterLimit').each(function(){
            restrictTextLength(this);
        });
        }).resize();
  });
  
  jQuery(document).ready(function () 
  {
      jQuery(window).resize(function() {
      if(jQuery('#js_isSameAsBilling').length)
      {
        if(jQuery('#js_isSameAsBilling').is(":checked"))
        {
          jQuery('#js_SHIPPING_AddressSection').hide();
        }
      }
      
    jQuery('#js_isSameAsBilling').click(function()
    {
      if(jQuery('#js_isSameAsBilling').is(":checked"))
      {  
        jQuery('#js_SHIPPING_AddressSection').hide();
      }
      else
      {
        jQuery('#js_SHIPPING_AddressSection').show();
      }
      updateShippingOption('N');
    });
    }).resize();
  });
  

  function getAddressFormat(idPrefix) {
    var countryId = '#js_'+idPrefix+'_COUNTRY'
    if (jQuery(countryId).val() == "USA") {
      jQuery('.js_'+idPrefix+'_CAN').hide();
      jQuery('.js_'+idPrefix+'_OTHER').hide();
      jQuery('.js_'+idPrefix+'_USA').show();
    } else if (jQuery(countryId).val() == "CAN") {
      jQuery('.js_'+idPrefix+'_USA').hide();
      jQuery('.js_'+idPrefix+'_OTHER').hide();
      jQuery('.js_'+idPrefix+'_CAN').show();
    } else{
      jQuery('.js_'+idPrefix+'_USA').hide();
      jQuery('.js_'+idPrefix+'_CAN').hide();
      jQuery('.js_'+idPrefix+'_OTHER').show();
    }
  }

  //This method exists in geoAutoCompleter.js named 'getAssociatedStateList'. we have reused and customized.
  function getAssociatedStateList(countryId, stateId, errorId, divId) 
  {
    var optionList = "";
    jQuery.ajaxSetup({async:false});
    jQuery.post("https://182.72.231.54:8443/getAssociatedStateList;jsessionid=205CC56E5D1B336D836A5FD41AE0B2BF.jvm1", {countryGeoId: jQuery("#"+countryId).val()}, function(data) {
      var stateList = data.stateList;
      jQuery(stateList).each(function() {
        if (this.geoId) {
          optionList = optionList + "<option value = "+this.geoId+" >"+this.geoName+"</option>";
        } else {
          optionList = optionList + "<option value = >"+this.geoName+"</option>";
        }
      });
      jQuery("#"+stateId).html(optionList);
    });
  }

  function getPostalAddress(contactMechId, purpose) {

/*
  if(document.getElementById(contactMechId).checked)
  {     
  
   document.getElementById("proccedtopay").style.display="block";
  }
  else
  {
   document.getElementById("proccedtopay").style.display="none";
  }*/
 
    jQuery.ajaxSetup({async:false});
    jQuery.post("https://182.72.231.54:8443/getPostalAddress;jsessionid=205CC56E5D1B336D836A5FD41AE0B2BF.jvm1", {contactMechId: contactMechId}, function(data) {
        jQuery("#js_"+purpose+"_COUNTRY").val(data.countryGeoId);
       jQuery("#js_"+purpose+"_STATE > option").each(function() {
        if (this.value ==data.stateProvinceGeoId) {
           jQuery(this).attr('selected', 'selected');
        }
    });
    jQuery("#"+purpose+"AddressContactMechId").val(data.contactMechId);
    if(purpose !== "SHIPPING"){
      jQuery("#js_"+purpose+"_ATTN_NAME").val(data.attnName);
    }
    if(jQuery("#js_"+purpose+"_FULL_NAME").length )
    {
      jQuery("#js_"+purpose+"_FULL_NAME").val(data.toName);
         
    }
    else
    {
  
      var firstName = "";
      var lastName = "";
      var toNameString = data.toName;
      if (toNameString != "" && (typeof toNameString != "undefined"))
      {
        var toNameArray = toNameString.split(' ');
        var toNameArraySize = toNameArray.length;
        if(toNameArraySize > 0)
        {
          firstName = toNameArray[0];
          if(toNameArraySize > 1)
          {
            lastName = toNameArray[toNameArraySize - 1];
          }
        }
      }
      
      jQuery("#js_"+purpose+"_FIRST_NAME").val(firstName);
      jQuery("#js_"+purpose+"_LAST_NAME").val(lastName);
    }
    jQuery("#js_"+purpose+"_ADDRESS1").val(data.address1);
    jQuery("#js_"+purpose+"_ADDRESS2").val(data.address2);
    jQuery("#js_"+purpose+"_ADDRESS3").val(data.address3);
    jQuery("#js_"+purpose+"_CITY").val(data.city);
    jQuery("#js_"+purpose+"_POSTAL_CODE").val(data.postalCode);
    jQuery("#js_"+purpose+"_POSTAL_CODE").change();
    getAddressFormat(purpose);
    });
    
  }
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
        /* counts \n */
        try {
            return((str.match(/[^\n]*\n[^\n]*/gi).length));
        } catch(e) {
            return 0;
        }
    }
    
    
    //set cell phone number to required based on user text messaging options
    jQuery(document).ready(function () {
      jQuery(window).resize(function() {
        //when page first loads
        txtPreferenceSelected = jQuery("input[name='PARTY_TEXT_PREFERENCE']:checked").val();
        if(txtPreferenceSelected == "Y")
        {
            jQuery("#js_PHONE_MOBILE_REQUIRED").val("true");
        }
        else
        {
            jQuery("#js_PHONE_MOBILE_REQUIRED").val("false");
        }
        //when user changes preference
        jQuery("input[name='PARTY_TEXT_PREFERENCE']").change(function(){
            txtPreferenceSelected = jQuery(this).val();
            if(txtPreferenceSelected == "Y")
            {
                jQuery("#js_PHONE_MOBILE_REQUIRED").val("true");
            }
            else
            {
                jQuery("#js_PHONE_MOBILE_REQUIRED").val("false");
            }
        });
        }).resize();
    });
    
    //when gift message text is empty and a help text is selected, copy the help text to the message
    function giftMessageHelpCopy(count)
    {
    var helpText = jQuery("#js_giftMessageEnum_"+count).val();
    if(helpText != "")
    {
      jQuery("#js_giftMessageText_"+count).val(helpText);
      
      restrictTextLength(jQuery("#js_giftMessageText_"+count));
    }
    }
    
    function setMaxLength(textArea)
    {
          var maxchar = jQuery(textArea).attr('maxlength');
            var curLen = jQuery(textArea).val().length;
            var regCharLen = lineBreakCount(jQuery(textArea).val());
            jQuery(textArea).keyup(function() {
                var cnt = jQuery(this).val().length;
                var regCharLen = lineBreakCount(jQuery(this).val());
                var remainingchar = maxchar - (cnt + regCharLen);
                if(remainingchar < 0){
                    jQuery(this).val(jQuery(this).val().slice(0, (maxchar-regCharLen)));
                } else{
                }
            });
    }
    
</script>
<!-- End Template component://osafe/webapp/osafe/common/entry/js/formEntryJS.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#entryFormJS -->

<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#checkoutJS -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/js/checkoutJS.ftl -->
<script type="text/javascript">
//Payment Page validation added by Nagaratna mirji
function validateCard(cardType,ccname,cardNumber,expMonth,expYear,verificationNo)
{
     var ccnameValidate = /^[a-zA-Z ]*$/;

   /*if(document.getElementById(cardType).value==""){
          jQuery('#'+cardType).after("<div class='error_msg_display' style='color:red'>Please Select the Card Type</div>");
         return false;
       }*/

          if(document.getElementById(ccname).value==""){
          jQuery('#'+ccname).after("<div class='error_msg_display' style='color:red'>Please Enter the Name</div>");
         return false;
       }
       /*Added By imteyaj Name for characters only */

       else if (!ccnameValidate.test(document.getElementById(ccname).value)) {

      jQuery('#'+ccname).after("<div class='error_msg_display' style='color:red'>Please Enter Only Characters for  the Name</div>");
      return false;
  }

       if(document.getElementById(cardNumber).value==""){
          jQuery('#'+cardNumber).after("<div class='error_msg_display' style='color:red'>Please Enter the Card Number</div>");
         return false;
       }

       else if(!jQuery.isNumeric(document.getElementById(cardNumber).value)){
         jQuery('#'+cardNumber).after("<div class='error_msg_display' style='color:red'>Please Enter valid Card Number</div>");
         return false;
     }

       if(jQuery("#js_expMonth").val()=="" && jQuery("#js_cardNumber_mask").val()!=""){
          jQuery('#js_expMonth').parent().addClass("js_expMonth");            
          jQuery('.js_expMonth').after("<div class='error_msg_display' style='color:red'>The specified card expiration month is invalid</div>");
         return false;
       }
       
       if(jQuery("#js_dexpMonth").val()=="" && jQuery("#js_dcardNumber_mask").val()!=""){
            jQuery('#js_dexpMonth').parent().addClass("js_dexpMonth");  
            jQuery('.js_dexpMonth').after("<div class='error_msg_display' style='color:red'>The specified card expiration month is invalid</div>");
           return false;          
       }
       
       if(jQuery("#js_expYear").val()=="" && jQuery("#js_cardNumber_mask").val()!=""){
          jQuery('#js_expYear').parent().addClass("js_expYear");            
          jQuery('.js_expYear').after("<div class='error_msg_display' style='color:red'>The specified card expiration month is invalid</div>");
         return false;
       }
       
       if(jQuery("#js_dexpYear").val()=="" && jQuery("#js_dcardNumber_mask").val()!=""){
            jQuery('#js_dexpYear').parent().addClass("js_dexpYear");  
            jQuery('.js_dexpYear').after("<div class='error_msg_display' style='color:red'>The specified card expiration month is invalid</div>");
           return false;          
       }       
       
       if(document.getElementById(expYear).value==""){
          jQuery('.cardexpyear').after("<div class='error_msg_display' style='color:red'>The specified card expiration year is invalid</div>");
         return false;
       }
       today = new Date();
       someday = new Date();
     someday.setFullYear(document.getElementById(expYear).value, document.getElementById(expMonth).value, 30);
       if (someday < today) {
           jQuery('.cardexpyear').after("<div class='error_msg_display' style='color:red'>Please Enter the valid expired year</div>");
         return false;
       }

       if(document.getElementById(verificationNo).value==""){
          jQuery('#'+verificationNo+'1').after("<div class='error_msg_display' style='color:red'>Please Enter the verification Number</div>");
         return false;
       }
       else if(!jQuery.isNumeric(document.getElementById(verificationNo).value)){console.log("mmmmmmmmmmmm"+document.getElementById(verificationNo).value);
        jQuery('#'+verificationNo+'1').after("<div class='error_msg_display' style='color:red'>Please Enter the valid Varification Number</div>");
         return false;
       }
        return true;
}
function validatePayment() {
jQuery('.error_msg_display').remove();
  if(document.getElementById('useSavedCard').checked) {
      var resultStatus=validateCard("js_cardType","ccname","js_cardNumber","js_expMonth","js_expYear","js_verificationNo");
        return resultStatus;
   }
  else if(document.getElementById('netbankingPayment').checked) {
        if(document.getElementById("js_netbanking").value==""){jQuery('#js_netbanking').after("<div class='error_msg_display' style='color:red'> Please Select the Bank </div>");
        return false;
    }
    return true;
  }
  else if(document.getElementById('debitcardPayment').checked) {
    var resultStatus=validateCard("js_debitbanking","dccname","js_dcardNumber","js_dexpMonth","js_dexpYear","js_dverificationNo");
        return resultStatus;
  }

  return true;
}
 //Payment Page validation added by Nagaratna mirji -End

//form validations santhosh
function submitAddress(form){

  if(!isNaN(document.getElementById("js_CUSTOMER_FULL_NAME").value) && document.getElementById("js_CUSTOMER_FULL_NAME").value != ""){
      alert("Please enter a valid Full Name");
      return false;
  }
  if(!isNaN(document.getElementById("js_CUSTOMER_CITY").value) && document.getElementById("js_CUSTOMER_CITY").value != ""){
      alert("Please enter a valid city");
      return false;
  }
     if(document.getElementById("js_CUSTOMER_CITY").value.match(/[a-z]/i) == null){
              alert("Please enter a valid City");
              return false;
       }
       if(document.getElementById("js_CUSTOMER_FULL_NAME").value.match(/[a-z]/i) == null){
              alert("Please enter a valid Full Name");
              return false;
       }

  // regex check for all spl chars in address
  var address1 = document.getElementById("js_CUSTOMER_ADDRESS1").value;
  if(address1 == null){
    address1 = document.getElementById("js_SHIPPING_ADDRESS1").value;
  }

  if(address1.match(/[a-zA-Z0-9]/g) == null && address1 != ""){
    alert("Please enter a valid address");
    return false;
  }
  if(isNaN(document.getElementById("PHONE_MOBILE_CONTACT").value) && document.getElementById("PHONE_MOBILE_CONTACT").value != "" || document.getElementById("PHONE_MOBILE_CONTACT").value.length < 10 && document.getElementById("PHONE_MOBILE_CONTACT").value != ""){
      alert("Please enter a valid Phone Number");
      return false;
  }
  document.getElementById(form).submit();
}
  var merchantURLPart = "https://www.citruspay.com/tgdpjhds2r";
  var vanityURLPart="tgdpjhds2r";
  var reqObj = null;

  function generateHMAC(form) {
  //var x = document.URL;
  var x = encodeURIComponent(document.URL);
  var y = x.lastIndexOf("/");
  y=x.substring(0,x.lastIndexOf("/"));
  document.getElementById("returnUrl").value =  y+"/netBankingResponse";


  if (window.XMLHttpRequest) {
      reqObj = new XMLHttpRequest();
    } else {
      reqObj = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if(merchantURLPart.lastIndexOf("/") != -1){
      vanityURLPart= merchantURLPart.substring(merchantURLPart.lastIndexOf("/")+1);
    }

    var orderAmount = document.getElementById("orderAmount").value;
    var merchantTxnId = document.getElementById("merchantTxnId").value;
    var currency = document.getElementById("currency").value;
    var param = "merchantId=" + vanityURLPart + "&orderAmount=" + orderAmount
        + "&merchantTxnId=" + merchantTxnId + "&currency=" + currency;

  jQuery.getJSON("/netBankingRedirect?"+param,function(result){

     jQuery.each(result, function(key, val){
          if(key == "sKey"){

            document.getElementById("secSignature").value = val.trim();
      //  alert(document.getElementById("secSignature"));
          //  document.getElementById("addressStreet1").value = document.getElementById("js_SHIPPING_ADDRESS1").value;

            //document.getElementById("addressCity").value = document.getElementById("js_SHIPPING_CITY").value;
            //document.getElementById("addressZip").value = document.getElementById("js_SHIPPING_POSTAL_CODE").value;
            //document.getElementById("addressState").value = jQuery("#js_SHIPPING_STATE option:selected").html();
            submitForm(form);
          }

        });

    });

    /*
    reqObj.onreadystatechange = process;
    reqObj.open("POST", "/online/control/netBankingRedirect?"+param, false);
    reqObj.send(null);*/

  }

  function submitForm(form) {
    document.getElementById("firstNameCitrus").value = document.getElementById("firstName").innerHTML;
    document.getElementById("emailAddressCitrus").value = document.getElementById("emailAddress").innerHTML;
    document.getElementById("phoneNumberCitrus").value = document.getElementById("phoneNumber").innerHTML;
    form.action = "https://www.citruspay.com/tgdpjhds2r";
    form.method = 'POST';
    form.submit();
  }



    function submitCheckoutForm(form, mode, value)
    {
      var isguestUsercreated=0;
      if(document.getElementById('gusetUserId') != null){
      var userName=document.getElementById('gusetUserId').value;
      var partyId=document.getElementById('gusetUserPartyId').value;
      userName=userName.replace("&#64;", "@");
      if(userName.length > 0){
      isguestUsercreated=createGuestUser(userName,partyId);
      }
    }else{
    isguestUsercreated=1;
    }
    if(isguestUsercreated > 0 ){
      if (mode == "NADD") {
        document.getElementById("js_SHIPPING_ATTN_NAME").value = document.getElementById("js_SHIPPING_ATTN_NAME").value;
      document.getElementById("js_SHIPPING_FIRST_NAME").value = document.getElementById("js_SHIPPING_FIRST_NAME_NEW").value;
        document.getElementById("js_SHIPPING_LAST_NAME").value = document.getElementById("js_SHIPPING_LAST_NAME_NEW").value;
        document.getElementById("js_SHIPPING_ADDRESS1").value = document.getElementById("js_SHIPPING_ADDRESS1_NEW").value;
        document.getElementById("js_SHIPPING_CITY").value = document.getElementById("js_SHIPPING_CITY_NEW").value;
        document.getElementById("js_SHIPPING_STATE").value = document.getElementById("js_SHIPPING_STATE_NEW").value;
        document.getElementById("js_SHIPPING_POSTAL_CODE").value = document.getElementById("js_SHIPPING_POSTAL_CODE_NEW").value;
        document.getElementById("PHONE_MOBILE_CONTACT").value = document.getElementById("PHONE_MOBILE_CONTACT_NEW").value;

           form.action="https://182.72.231.54:8443/multiPageAddOrUpdateCustomerAddress;jsessionid=205CC56E5D1B336D836A5FD41AE0B2BF.jvm1";
           form.submit();

      } else if (mode == "DN") {
          form.action="/";
            form.submit();
        }else if (mode == "MAU") {
            form.action="/";
            form.submit();
        }else if (mode == "VDN") {
            if (validateCart()) {
                form.action="/";
              form.submit();
            }
        }else if (mode == "NA") {
            form.action="/?preContactMechTypeId=POSTAL_ADDRESS&contactMechPurposeTypeId="+value+"&DONE_PAGE=";
            form.submit();
        } else if (mode == "BK") {
            form.action="/?action=previous";
            form.submit();
        }  else if (mode == "SCBK") {
            form.action="";
            form.submit();
        }  else if (mode == "CABK") {
            form.action="/?action=previous";
            form.submit();
        }  else if (mode == "SOBK") {
            form.action="/?action=previous";
            form.submit();
        } else if (mode == "UC") {
            if (updateCart()) {
              if(document.getElementById("update_0").value != 0){
              jQuery.ajax({
                          url: '/',
                          type: "POST",
                          data :jQuery(form).serialize(),
                           beforeSend: function() {jQuery('body').append("<div class=facetLoyaltyAjaxImg></div>");},
                          success: function(response) {
                            var group1 = jQuery(response).find('.container.orderItems.showCartOrderItems');
                        jQuery('.container.orderItems.showCartOrderItems').replaceWith(group1);
                        var group2 = jQuery(response).find('.ShowCart.group.group2');
                        jQuery('.ShowCart.group.group2').replaceWith(group2);
                        var cartstatus = jQuery(response).find('#addCartlist').find(".list-count").html();
                      //  alert("cartstatus="+cartstatus);
                        jQuery('#addCartlist').find(".list-count").html(cartstatus);
                        jQuery('#addCart').find(".list-count").html(cartstatus);
                        jQuery('#addCart2').find(".list-count").html(cartstatus);
                        
                      /*  var totalCartNo=jQuery(response).find('.number').html();
                        var totalQtyNo=jQuery(response).find('.itemQty').html();
                        
                        jQuery('.miniTotal').html(cartstatus);
                        jQuery('.itemQty').html(totalQtyNo); */
                        
                         var lightCartDialog = jQuery(response).find('#lightCart_displayDialog');
                        jQuery('#lightCart_displayDialog').replaceWith(lightCartDialog);
                        
                    if(jQuery("#addWishlist2").is(":visible"))
                      {
                        jQuery('#addCart').css("display","block");
                      }
                        },
                        complete:function(){
                        jQuery('.facetLoyaltyAjaxImg').remove();
                       if(jQuery("#cartPincode").val().length > 0 && jQuery(".promoCodeItem").is(":visible")){
                          jQuery(".cartPincodeMessageId").html("Pincode successfully applied");
                        }
                     }
                    });
          return false;
        }
                else{
                  alert("cart qty cant be zero");
                  return false;
                }
            }
        }  else if (mode == "PA") {
            document.getElementById("js_paymentMethodTypeId").value = value;
            form.action="/";
            form.submit();
        } else if (mode == "SO") {

          var temp = document.getElementById("js_submitOrderBtn").value ;
          document.getElementById("js_submitOrderBtn").value = "Placing an Order";
          var grandTotal="724.95";
          if(grandTotal > 0){
          if(document.getElementById('useSavedCard').checked) {
            document.getElementById("dccname").value = document.getElementById("ccname").value;
            document.getElementById("ccnum").value = document.getElementById("js_cardNumber").value;
            document.getElementById("ccvv").value = document.getElementById("js_verificationNo").value;
            document.getElementById("ccexpmon").value = document.getElementById("js_expMonth").value;
            document.getElementById("ccexpyr").value = document.getElementById("js_expYear").value;

            jQuery("#js_submitOrderBtn").attr("disabled", "disabled");
        document.getElementById("pinCodes").value = document.getElementById("pinCode").value;
        form.action="https://test.payu.in/_payment";

          }
          /* added by veeraprasasd for netbanking & Debit Payment start*/
          else if(document.getElementById('netbankingPayment').checked) {
            document.getElementById("ccnum").value = document.getElementById("js_cardNumber").value;
            document.getElementById("ccvv").value = document.getElementById("js_verificationNo").value;
            document.getElementById("ccexpmon").value = document.getElementById("js_expMonth").value;
            document.getElementById("ccexpyr").value = document.getElementById("js_expYear").value;

            jQuery("#js_submitOrderBtn").attr("disabled", "disabled");
        document.getElementById("pinCodes").value = document.getElementById("pinCode").value;
        form.action="https://test.payu.in/_payment";

          }
          else if(document.getElementById('debitcardPayment').checked) {
            document.getElementById("ccname").value = document.getElementById("dccname").value;
            //var serialisedFormData = jQuery("#checkoutInfoForm").serialize();
            document.getElementById("ccnum").value = document.getElementById("js_dcardNumber").value;
            document.getElementById("ccvv").value = document.getElementById("js_dverificationNo").value;
            document.getElementById("ccexpmon").value = document.getElementById("js_dexpMonth").value;
            document.getElementById("ccexpyr").value = document.getElementById("js_dexpYear").value;
            jQuery("#js_submitOrderBtn").attr("disabled", "disabled");
        document.getElementById("pinCodes").value = document.getElementById("pinCode").value;
        form.action="https://test.payu.in/_payment";

          }
          /* added by veeraprasasd for netbanking & Debit Payment end*/
          else{
            /* Updated by Krishnamohan J - Start */

            if(jQuery("#isOtpValid").val() === 'valid'){
                jQuery("#js_submitOrderBtn").attr("disabled", "disabled");
                document.getElementById("pinCodes").value = document.getElementById("pinCode").value;
                form.action="/";
            }else{
              document.getElementById("js_submitOrderBtn").value = temp;
              jQuery("#responseMessage").html("Unable to continue as OTP is not validated");
              return;
            }
            /* Updated by Krishnamohan J - End */
          }
          }
          else{
           form.action="/";
           }
           form.submit();

        } else if (mode == "EB") {
            document.getElementById("js_paymentMethodTypeId").value = value;
            form.action="/";
            form.submit();
        } else if (mode == "UWL") {
            if (updateWishlist()) {
              form.action="/";
              form.submit();
            }
        } else if (mode == "ACW") {
            if (addItemToCartFromWishlist(value)) {
                document.getElementById("js_add_item_id").value = value;
               jQuery.ajax({
                          url: '/',
                          type: "POST",
                          data :jQuery("form").serialize(),
                          success: function(response) {
                           var eCommerceShowWishList = jQuery(response).find('#eCommerceShowWishList');
                         jQuery('#eCommerceShowWishList').replaceWith(eCommerceShowWishList);
                        var wishListStatus=jQuery(response).find('#wishlistHeaderCount').find(".list-count");
                jQuery("#wishlistHeaderCount").find(".list-count").html(wishListStatus.html());
                jQuery("#wishlistCount").find(".list-count").html(wishListStatus.html());
                jQuery("#wishlistCountRes").find(".list-count").html(wishListStatus.html());
                      var cartstatus = jQuery(response).find('#addCartlist').find(".list-count").html();;
                      jQuery('#addCartlist').find(".list-count").html(cartstatus);
                      jQuery('#addCart').find(".list-count").html(cartstatus);
                      jQuery('#addCart2').find(".list-count").html(cartstatus);
                   if(jQuery("#addWishlist2").is(":visible"))
                    {
                      jQuery('#addCart').css("display","block");
                    }
                  jQuery(".wishList_social_share").css("display","block");
                        }
                    });
          return false;
            }
        } else if (mode == "AMCW") {
            if (addMultiItemsToCartFromWishlist(value)) {
                form.action="/";
                form.submit();
            }
        } else if (mode == "SP") {
            document.getElementById("js_storeId").value = value;
                document.orderCompleteForm.action="/";
                document.orderCompleteForm.submit();
        } else if (mode == "PNZ") {
            document.getElementById("js_paymentMethodTypeId").value = value;
            form.action="/";
            form.submit();
        } else if (mode == "BBK") {
            window.history.back();
        }
      }
    }

    function updateCart()
    {
      var cartIsValid = true;
      var cartItemsNo = 0;
      var zeroQty = false;

      for (var i=0;i<cartItemsNo;i++)
        {
          var productName = jQuery('#js_productName_'+i).val();
          var productId = "";
          var quantityInputClassAttr = jQuery('#update_'+i).attr("class");
          if(quantityInputClassAttr != null && quantityInputClassAttr != "")
          {
            productId = quantityInputClassAttr.replace("qtyInCart_", "");
          }

          var quantity = Number(getTotalQtyFromScreen('update_',i));

            if(isQtyWhole(quantity,productName))
            {
          if(!(jQuery('.showCartOrderItemsItemUpdateButton').length))
          {
            quantity = quantity + getQtyInCart(productId);
          }
                if(!(validateQtyMinMax(productId,productName,quantity)))
                {
                  cartIsValid = false;
                }
            }
            else
            {
              cartIsValid = false;
            }
            if(quantity == 0)
            {
              var zeroQty = true;
            }
        }
        if(zeroQty == true)
        {
            //window.location='https://182.72.231.54:8443/deleteFromCart;jsessionid=205CC56E5D1B336D836A5FD41AE0B2BF.jvm1';
        }
        return cartIsValid;
    }

    function updateWishlist()
    {
      var cartIsValid = true;
      var cartItemsNo = 0;
      var zeroQty = false;

      for (var i=0;i<cartItemsNo;i++)
        {
          var productName = jQuery('#js_productName_'+i).val();

          var productId = "";
          var quantityInputClassAttr = jQuery('#update_'+i).attr("class");
          if(quantityInputClassAttr != null && quantityInputClassAttr != "")
          {
            productId = quantityInputClassAttr.replace("qtyInCart_", "");
          }
            else
            {
                productId = getProductIdInWishlist(i);
            }
            var quantity = 0;
            if (jQuery('#update_'+i).length)
            {
                quantity = Number(getTotalQtyFromScreen('update_',i));
            }
            else
            {
                quantity = getQtyInWishlist(productId);
            }

            if(!(isQtyWhole(quantity,productName)))
            {
        cartIsValid = false;
            }
            if(quantity == 0)
            {
              var zeroQty = true;
            }
        }
        if(zeroQty == true)
        {
            //window.location='/deleteFromWishlist';
        }
        return cartIsValid;
    }

    function addItemToCartFromWishlist(value)
    {
      var cartItemsNo = 0;
      var zeroQty = false;

      var productName = jQuery('#js_productName_'+value).val();

      var productId = "";
      var quantityInputClassAttr = jQuery('#update_'+value).attr("class");
      if(quantityInputClassAttr != null && quantityInputClassAttr != "")
      {
        productId = quantityInputClassAttr.replace("qtyInCart_", "");
      }
        else
        {
            productId = getProductIdInWishlist(value);
        }
        var quantity = 0;
        if (jQuery('#update_'+value).length)
        {
            quantity = Number(getTotalQtyFromScreen('update_',value));
        }
        else
        {
            quantity = getQtyInWishlist(productId);
        }

        if(isQtyWhole(quantity,productName))
        {
            if(!(isQtyZero(quantity,productName,productId)))
            {
              quantity = Number(quantity) + Number(getQtyInCart(productId));
                if(validateQtyMinMax(productId,productName,quantity))
                {
                 return true;
                }
            }
        }
        return false;
    }

    function addMultiItemsToCartFromWishlist(value)
    {

        var addItemsToCart = true;
        var itemSelected = false;
        var count = 0;
        jQuery('.js_add_multi_product_id').each(function ()
        {
            qtyIdArr = jQuery(this).attr("id").split("_");
            variantIsChecked = jQuery(this).is(":checked");
            if(variantIsChecked)
            {
                itemSelected = true;
                var add_productId = jQuery(this).val();
                var quantity = 0;
                if (jQuery('#update_'+qtyIdArr[5]).length)
                {
                    quantity = jQuery('#update_'+qtyIdArr[5]).val();
                }
                else
                {
                    quantity = getQtyInWishlist(add_productId);
                }
                var productName = jQuery('#js_productName_'+qtyIdArr[5]).val();
                if(quantity != "")
                {
                    if(isQtyWhole(quantity,productName))
                    {
                        if(!(isQtyZero(quantity,productName,add_productId)))
                        {
                            quantity = Number(quantity) + Number(getQtyInCart(add_productId));
                            if(!(validateQtyMinMax(add_productId,productName,quantity)))
                            {
                                addItemsToCart = false;
                            }
                        }
                        else
                        {
                            addItemsToCart = false;
                        }
                    }
                    else
                    {
                        addItemsToCart = false;
                    }
                }
                else
                {
                    addItemsToCart = false;
                }
            }
            count = count + 1;
        });
        if (!itemSelected)
        {
            alert("No items have been selected, please select items to add to your Cart");
            addItemsToCart = false;
        }
        return addItemsToCart;
    }

<!--added by sailaja-->
function codAlert(subTotal,val,chk,cLimit)
{
   <!--validate each item in cart -->

  <!-- added by santhosh -->
      if(document.getElementById("ccAvenuePayment").checked){
    /*var x = document.URL;
    var y = x.lastIndexOf("/");
    y=x.substring(0,x.lastIndexOf("/"));
    document.getElementById("ebsScreen").src = y+"/iciciRedirect";
    window.location = y+"/iciciRedirect"; */
    document.getElementById("paymentFrame").style.display = "block";
    document.getElementById("js_submitOrderBtn").style.display = "none";
    var codFee = document.getElementById("codFee").value;
    var grandTotal = document.getElementById("cartGrandTotal").value;
    grandTotal = grandTotal.replace("/","");
      document.getElementById("grandTotal").innerText = "Rs "+parseFloat(grandTotal).toFixed(2);
      document.getElementById("freeDelivaryCharges").style.display = "block";
      document.getElementById("freeDelivaryCharges").innerText = "Free";
      //validation for ccAvenue by Santhosh
      document.getElementById("deliveryChargesText").style.display = "block";
      document.getElementById("checkoutCOD").style.display = "none";
      document.getElementById("checkoutCODText").style.display = "none";
      document.getElementById("codChargesText").style.display = "none";
      }

     <!--ended by santhosh -->
     var codLimit = parseInt(cLimit,10);
  codLimit = parseFloat(codLimit);
  if(val=='PAYOPT_COD' && chk==true){
  document.getElementById("paymentFrame").style.display = "none";
  document.getElementById("js_submitOrderBtn").style.display = "block";
  document.getElementById("deliveryChargesText").style.display = "none"
  document.getElementById("freeDelivaryCharges").style.display = "none"
  var codFee = document.getElementById("codFee").value;
  var grandTotal = document.getElementById("cartGrandTotal").value;
  grandTotal = grandTotal.replace("/","");
  var codCharges  = parseFloat(codFee);
  var orderGrandTotal = parseFloat(grandTotal);
  var displayTotal = orderGrandTotal + codCharges;

  if(orderGrandTotal < codLimit ){
    subTotValue=subTotal.replace("/","");
    var cartSubTot = parseInt(subTotValue,10);
    var x;
    //var r=confirm("COD (Cash On Delivery) fee of Rs 49 chargeable below purchase of Rs 799");
    document.getElementById("checkoutCOD").style.display = "block";
     document.getElementById("deliveryChargesText").style.display = "none";
         document.getElementById("codChargesText").style.display = "block";
       document.getElementById("codChargesText").innerText = "Cod Charges";
       document.getElementById("checkoutCOD").innerText = "Rs. "+codCharges.toFixed(2);
       document.getElementById("checkoutCODText").style.display = "block";
       document.getElementById("grandTotal").innerText = "Rs. "+displayTotal.toFixed(2);
       document.getElementById("js_submitOrderBtn").style.display = "block";
       var cform = document.orderCompleteForm;
       cform.action="/?payOpt="+val+"";
      // cform.submit();


    }
  }
}

<!--ended-->
    function addManualPromoCode()
    {
        if (jQuery('#js_manualOfferCode').val().length > 1  && jQuery('#js_manualOfferCode').val() != null)
        {
          promo = jQuery('#js_manualOfferCode').val().toUpperCase();
          promoCodeWithoutSpace = promo.replace(/^\s+|\s+$/g, "");
           var cform = document.orderCompleteForm;
       var url="/?productPromoCodeId="+promoCodeWithoutSpace+"";
       return ajaxFormSubmit(url,cform);
        }
        else
        {
         jQuery("#promotionError").css("display","block");
          return false;
        }

    }

    function removePromoCode(promoCode)
    {
        if (promoCode != null)
        {
          var cform = document.orderCompleteForm;
          var url="/?productPromoCodeId="+promoCode+"";          
      jQuery('#js_manualOfferCode').val("");
          return ajaxFormSubmit(url,cform);
        }
    }
    function addGiftCardNumber()
    {
        if (jQuery('#js_giftCardNumber').length && jQuery('#js_giftCardNumber').val() != null)
        {
          giftCardNumber = jQuery('#js_giftCardNumber').val();
          giftCardNumberWithoutSpace = giftCardNumber.replace(/^\s+|\s+$/g, "");
        }
        var cform = document.orderCompleteForm;
        cform.action="/?gcNumber="+giftCardNumberWithoutSpace+"";
        cform.submit();
    }

    function removeGiftCardNumber(gcPaymentMethodId)
    {
        if (gcPaymentMethodId != null)
        {
          var cform = document.orderCompleteForm;
          cform.action="/?gcPaymentMethodId="+gcPaymentMethodId+"";
          cform.submit();
        }
    }

    function addLoyaltyPoints()
    {
      jQuery('#js_applyLoyaltyCard').bind('click', false);
      var loyaltyNo=jQuery("#js_loyaltyPointsId").val();
        var cform = document.orderCompleteForm;
        var url="/?loyaltyPointsId="+loyaltyNo+"";
         return ajaxFormSubmit(url,cform);
    }
    function removeLoyaltyPoints()
    {
      jQuery('#js_removeLoyaltyCard').bind('click', false);
      var cform = document.orderCompleteForm;
      window.location='/'
      //var url="/";
      //return ajaxFormSubmit(url,cform);
    }
    function updateLoyaltyPoints(indexOfAdj)
    {
      jQuery('#js_updateLoyaltyPointsAmount').bind('click', false);
      var cform = document.orderCompleteForm;
      var url="/";
      return ajaxFormSubmit(url,cform);
    }

    function ajaxFormSubmit(url,form)
    {
    jQuery.ajax({
        url: url,
        type: "POST",
        data: form.serialize(),
        beforeSend: function() {jQuery('body').append("<div class=facetLoyaltyAjaxImg></div>");},
        success: function(response) {
          var group2 = jQuery(response).find('.ShowCart.group.group2');
        jQuery('.ShowCart.group.group2').replaceWith(group2);
        
         var orderSummaryPromoCode = jQuery(response).find('.promoCodeList');
       jQuery('.promoCodeList').replaceWith(orderSummaryPromoCode);
      
        if(jQuery(response).find('.shippingbox')){
        var group = jQuery(response).find('.OrderSummary.group.group3');
        jQuery('.OrderSummary.group.group3').replaceWith(group);
          }

          }
        }).done(function(){
        jQuery('.facetLoyaltyAjaxImg').remove();
        });
        return false;
    }

   jQuery(document).ready(function ()
   {
      jQuery(window).resize(function() {
      validateCart();

        if (jQuery('#js_SHIPPING_POSTAL_CODE').length)
        {
          updateShippingOption('Y');
          jQuery('#js_SHIPPING_POSTAL_CODE').change(function ()
          {
            updateShippingOption('N');
          });
          jQuery('#js_SHIPPING_STATE').change(function ()
          {
            updateShippingOption('N');
          });
          jQuery('#js_SHIPPING_ADDRESS1').change(function ()
          {
            updateShippingOption('N');
          });
          jQuery('#js_SHIPPING_ADDRESS2').change(function ()
          {
            updateShippingOption('N');
          });
          jQuery('#js_SHIPPING_ADDRESS3').change(function ()
          {
            updateShippingOption('N');
          });
          jQuery('#js_SHIPPING_COUNTRY').change(function ()
          {
            updateShippingOption('N');
          });
        }

        if (jQuery('input.js_shipping_method:checked').val() == undefined)
        {
          jQuery('input.js_shipping_method:first').attr("checked", true);
        }

        pickupStoreEventListener();
        }).resize();
    });

    jQuery(document).ready(function ()
    {
      jQuery(window).resize(function() {
      if (jQuery('#js_payInStoreY').is(':checked'))
      {
        jQuery('#js_checkoutPaymentOptions').hide();
    }
      jQuery('#js_payInStoreN').click(function()
      {
        jQuery('#js_checkoutPaymentOptions').show();
    });

    jQuery('#js_payInStoreY').click(function()
    {
        jQuery('#js_checkoutPaymentOptions').hide();
    });
      }).resize();
    });


    function pickupStoreEventListener()
    {
        jQuery('.js_shippingMethodsContainer').click(function()
        {
      if(jQuery(this).find('input[type="radio"]').is(':checked'))
            {
              var selected = jQuery(".js_shipping_method:checked");
              if(jQuery(selected).hasClass('js_shippingMethodRadioButton'))
              {
                var shipMethErrorMessage = jQuery(this).closest('#js_deliveryOptionBox').next('#js_deliveryOptionBoxError');
                if(jQuery(shipMethErrorMessage).length)
                {
                  if(jQuery.trim(jQuery(shipMethErrorMessage).html()).length)
                  {
                    jQuery(shipMethErrorMessage).children().hide();
                  }
                }
              }
            }
    });

        jQuery('.js_cancelPickupStore').click(function(event)
        {
            event.preventDefault();
            jQuery(displayDialogId).dialog('close');
         });

        jQuery('.storePickup_Form').submit(function(event)
        {
            event.preventDefault();
            jQuery.get(jQuery(this).attr('action')+'?'+jQuery(this).serialize(), function(data)
            {
                jQuery('#eCommerceStoreLocatorContainer').replaceWith(data);
                pickupStoreEventListener();
                if (jQuery('#isGoogleApi').val() != "Y")
                {
                    loadScript();
                }
                else
                {
                    hideDirection();
                }
            });
        });
    }

    function updateShippingOption(isOnLoad)
    {
        if (jQuery('#js_deliveryOptionBox').length)
        {
            if (jQuery('#js_SHIPPING_POSTAL_CODE').length)
            {
              var useShipping = true;
              if (jQuery('#js_isSameAsBilling').length)
          {
            if(jQuery('#js_isSameAsBilling').is(":checked"))
            {
              useShipping = false;
            }
          }

          if(useShipping)
          {
                  var address1 = (jQuery('#js_SHIPPING_ADDRESS1').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_ADDRESS1').val());
                  var address2 = (jQuery('#js_SHIPPING_ADDRESS2').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_ADDRESS2').val());
                  var address3 = (jQuery('#js_SHIPPING_ADDRESS3').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_ADDRESS3').val());
                  var city = (jQuery('#js_SHIPPING_CITY').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_CITY').val());
                  var postalCode = (jQuery('#js_SHIPPING_POSTAL_CODE').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_POSTAL_CODE').val());
                  var stateProvinceGeoId = (jQuery('#js_SHIPPING_STATE').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_STATE').val());
                  var countryGeoId = (jQuery('#js_SHIPPING_COUNTRY').val()== null)?'':encodeURIComponent(jQuery('#js_SHIPPING_COUNTRY').val());
                }
                else
                {
                  if(jQuery('#js_BILLING_STATE').length)
                  {
                    var address1 = (jQuery('#js_BILLING_ADDRESS1').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS1').val());
                    var address2 = (jQuery('#js_BILLING_ADDRESS2').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS2').val());
                    var address3 = (jQuery('#js_BILLING_ADDRESS3').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS3').val());
                    var city = (jQuery('#js_BILLING_CITY').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_CITY').val());
                    var postalCode = (jQuery('#js_BILLING_POSTAL_CODE').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_POSTAL_CODE').val());
                    var stateProvinceGeoId = (jQuery('#js_BILLING_STATE').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_STATE').val());
                    var countryGeoId = (jQuery('#js_BILLING_COUNTRY').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_COUNTRY').val());
                  }
                  else if(jQuery('#js_PERSONAL_STATE').length)
                  {
                    var address1 = (jQuery('#js_BILLING_ADDRESS1').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS1').val());
                    var address2 = (jQuery('#js_BILLING_ADDRESS2').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS2').val());
                    var address3 = (jQuery('#js_BILLING_ADDRESS3').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_ADDRESS3').val());
                    var city = (jQuery('#js_BILLING_CITY').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_CITY').val());
                    var postalCode = (jQuery('#js_BILLING_POSTAL_CODE').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_POSTAL_CODE').val());
                    var stateProvinceGeoId = (jQuery('#js_BILLING_STATE').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_STATE').val());
                    var countryGeoId = (jQuery('#js_BILLING_COUNTRY').val()== null)?'':encodeURIComponent(jQuery('#js_BILLING_COUNTRY').val());
                  }
                }

                var reqParam = '?address1='+address1+'&address2='+address2+'&address3='+address3+'&city='+city;
                reqParam = reqParam+'&postalCode='+postalCode+'&stateProvinceGeoId='+stateProvinceGeoId+'&countryGeoId='+countryGeoId;

                jQuery.get('/'+reqParam+'&callback=Y&rnd='+String((new Date()).getTime()).replace(/\D/gi, "")+'', function(data) {
                    var shippingOptions = jQuery(data).find('#js_deliveryOptionBox');
                    jQuery('#js_deliveryOptionBox').replaceWith(shippingOptions);
                    if(jQuery('input.js_shipping_method:checked').val() != null)
                    {
                        setShippingMethod(jQuery('input.js_shipping_method:checked').val(), isOnLoad);
                    }
                    else
                    {
                        jQuery('input.js_shipping_method:first').attr("checked", true);
                        setShippingMethod(jQuery('input.js_shipping_method').val(), isOnLoad);
                    }
                });
            } else {
                location.reload();
                jQuery('#isGoogleApi').val("");
            }
        }
    }

    function setShippingMethod(selectedShippingOption, isOnLoad)
    {
      var selectedStoreId = "";
        if (jQuery('.js_onePageCheckoutOrderItemsSummary').length)
        {
            if (selectedShippingOption == "NO_SHIPPING@_NA_")
            {
                if(false && false)
                {
                    jQuery('.js_paymentOptions').hide();
                    jQuery('#js_checkoutPaymentOptions').show();
                }
                else if (false && !false)
                {
                    jQuery('.js_paymentOptions').show();
                    jQuery('#js_checkoutPaymentOptions').show();
                }
                else if (!false)
                {
                    jQuery('.js_paymentOptions').hide();
                    jQuery('#js_checkoutPaymentOptions').hide();
                }
                if(true)
                {
                    jQuery('.js_codOptions').hide();
                }
                if (jQuery('#js_payInStoreY').is(':checked'))
                {
                    jQuery('#js_checkoutPaymentOptions').hide();
                }

                selectedStoreId = jQuery('#js_storeId').val();
            }
            else
            {
                if(true)
                {
                    jQuery('.js_codOptions').show();
                }
                jQuery('.js_paymentOptions').hide();
                jQuery('#js_checkoutPaymentOptions').show();
            }

            jQuery.ajaxSetup({async:false});
            jQuery.get('/?shipMethod='+selectedShippingOption+'&storeId='+selectedStoreId+'&rnd=' + String((new Date()).getTime()).replace(/\D/gi, "")+'', function(data)
            {
              if (jQuery('.js_onePageCheckoutOrderItemsSummary').length)
            {
                jQuery('.js_onePageCheckoutOrderItemsSummary').replaceWith(data);
              }

              var selected = jQuery(".js_shipping_method:checked");
          if(jQuery(selected).length)
          {
            if(jQuery('.js_shippingMethodsContainer').find('input[type="radio"]').is(':checked'))
                {
                  var selected = jQuery(".js_shipping_method:checked");
                  if(jQuery(selected).hasClass('js_shippingMethodRadioButton'))
                  {
                    var shipMethErrorMessage = jQuery('.js_shippingMethodsContainer').closest('#js_deliveryOptionBox').next('#js_deliveryOptionBoxError');
                    if(jQuery(shipMethErrorMessage).length)
                    {
                      if(jQuery.trim(jQuery(shipMethErrorMessage).html()).length)
                      {
                        jQuery(shipMethErrorMessage).children().hide();
                      }
                    }
                  }
                 }
         }
      });
        }

        if((isOnLoad != null) && (isOnLoad =='N'))
        {
          if (jQuery('.js_onePageCheckoutLoyaltyPoints').length)
             {
                jQuery.get('/?rnd=' + String((new Date()).getTime()).replace(/\D/gi, "")+'', function(lpData)
              {
                jQuery('.js_onePageCheckoutLoyaltyPoints').replaceWith(lpData);
              });
             }
            if (jQuery('.js_onePageCheckoutPromoCode').length)
            {
              jQuery.get('/?rnd=' + String((new Date()).getTime()).replace(/\D/gi, "")+'', function(promoData)
            {
              jQuery('.js_onePageCheckoutPromoCode').replaceWith(promoData);
              });
            }
        }
        if (jQuery('.js_onePageCheckoutGiftCard').length)
      {
          var gcWarningMessTest;
          if((isOnLoad == null) || (isOnLoad !='N'))
          {
            gcWarningMessTest = jQuery("#js_gcWarningMessTest");
          }
        jQuery.get('/?rnd=' + String((new Date()).getTime()).replace(/\D/gi, "")+'', function(gcData)
        {
          jQuery('.js_onePageCheckoutGiftCard').find('.js_eCommerceEnteredGiftCardPayment').replaceWith(jQuery(gcData).find('.js_eCommerceEnteredGiftCardPayment'));
          if((isOnLoad == null) || (isOnLoad !='N'))
        {
          if(jQuery(gcWarningMessTest).length)
          {
            jQuery(".giftCardSummary").append(gcWarningMessTest);
          }
        }
          });
      }

       if (jQuery('#js_remainingPayment').length)
       {
        jQuery.get('/?rnd=' + String((new Date()).getTime()).replace(/\D/gi, "")+'', function(data)
          {
             var balanceSection = jQuery(data).find("#js_remainingPayment");
             jQuery('#js_remainingPayment').replaceWith(balanceSection);

             var remainingBalance = Number(jQuery("#js_remainingPaymentValue").val());
               if(Number(remainingBalance) <= 0)
               {
                  jQuery(".js_paymentOptions").hide();
                  jQuery("#js_checkoutPaymentOptions").hide();
               }
          });
       }
    }

    jQuery(document).ready(function ()
    {
      jQuery(window).resize(function() {
      jQuery('#js_savedCard').change(function ()
    {
      jQuery('#js_useSavedCard').prop('checked',true);
    });
    jQuery('#js_savedVerificationNo').change(function ()
    {
      jQuery('#js_useSavedCard').prop('checked',true);
    });

      jQuery('#js_cardType').change(function ()
    {
      jQuery('#js_useOtherCard').prop('checked',true);
    });
    jQuery('#js_cardNumber,#js_cardNumber_mask').change(function ()
    {
      jQuery('#js_useOtherCard').prop('checked',true);
    });
    jQuery('#js_expMonth').change(function ()
    {
      jQuery('#js_useOtherCard').prop('checked',true);
    });
    jQuery('#js_expYear').change(function ()
    {
      jQuery('#js_useOtherCard').prop('checked',true);
    });
    jQuery('#js_verificationNo').change(function ()
    {
      jQuery('#js_useOtherCard').prop('checked',true);
    });
    }).resize();
    });

    function getQtyInWishlist(productId)
    {
        var qtyInWishlist = Number(0);
        return qtyInWishlist;
    }

    function getProductIdInWishlist(index)
    {
        var cartItemProductId = "";
        return cartItemProductId;
    }

  function formatCreditCard(ele,event)
  {
    var key = (window.event) ? event.which : event.keyCode;
      if( key != 8){
        var num=ele.value;
      num=num.replace(/[^0-9]/g, '');
        num= num.replace(/(\d{4})/g,"$1 ");
        ele.value=num;
        num=num.replace(/[^0-9]/g, '');
        var id=ele.id.split('_mask')[0];
        jQuery('#'+id).val(num);
        detectCardType(num);
      }
      if( key == 8){
        var num=ele.value;
      num=num.replace(/[^0-9]/g, '');
        detectCardType(num);
      }
  }

  function formatDebitCard(ele,event)
  {
    var key = (window.event) ? event.which : event.keyCode;
      if( key != 8){
        var num=ele.value;
      num=num.replace(/[^0-9]/g, '');
        num= num.replace(/(\d{4})/g,"$1 ");
        ele.value=num;
        num=num.replace(/[^0-9]/g, '');
        var id=ele.id.split('_mask')[0];
        jQuery('#'+id).val(num);
        debitDetectCardType(num);
      }
      if( key == 8){
        var num=ele.value;
      num=num.replace(/[^0-9]/g, '');
        debitDetectCardType(num);
      }
  }



  function detectCardType(num)
  {
    number=num.replace(/[^0-9]/g, '');
      var re = {
          electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
          maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
          dankort: /^(5019)\d+$/,
          interpayment: /^(636)\d+$/,
          unionpay: /^(62|88)\d+$/,
          visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
          mastercard: /^5[1-5][0-9]{14}$/,
          amex: /^3[47][0-9]{13}$/,
          diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
          discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
          jcb: /^(?:2131|1800|35\d{3})\d{11}$/
      };
      if(re.electron.test(number))
        {
            jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'ELECTRON';
        }
        else if(re.maestro.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'MAESTRO';
        }
        else if(re.dankort.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'DANKORT';
        }
        else if(re.interpayment.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'INTERPAYMENT';
        }
        else if(re.unionpay.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'UNIONPAY';
        }
        else if (re.visa.test(number))
        {
          jQuery("#visaId").css("display", "block");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
          jQuery("#js_cardType").val("Visa");
            return 'VISA';
        }
        else if (re.mastercard.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "block");
          jQuery("#dinersId").css("display", "none");
          jQuery("#js_cardType").val("MasterCard");
            return 'MASTERCARD';
        }
        else if (re.amex.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "block");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
          jQuery("#js_cardType").val("AmericanExpress");
            return 'AMEX';
        }
        else if (re.diners.test(number))
        {
          jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "block");
          jQuery("#js_cardType").val("DinersClub");
            return 'DINERS';
        }
        else if (re.discover.test(number))
        {
        jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'DISCOVER';
        }
        else if (re.jcb.test(number))
        {
        jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return 'JCB';
        }
        else{
        jQuery("#visaId").css("display", "none");
          jQuery("#amexId").css("display", "none");
          jQuery("#masterId").css("display", "none");
          jQuery("#dinersId").css("display", "none");
            return undefined;
        }
  }



  function debitDetectCardType(num)
  {
    number=num.replace(/[^0-9]/g, '');
      var re = {
          electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
          maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
          dankort: /^(5019)\d+$/,
          interpayment: /^(636)\d+$/,
          unionpay: /^(62|88)\d+$/,
          visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
          mastercard: /^5[1-5][0-9]{14}$/,
          amex: /^3[47][0-9]{13}$/,
          diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
          discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
          jcb: /^(?:2131|1800|35\d{3})\d{11}$/
      };
      if(re.electron.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'ELECTRON';
        }
        else if(re.maestro.test(number))
        {
          jQuery("#ddvisaId").css("display", "none");
          jQuery("#ddamexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "block");
          jQuery("#js_debitbanking").val("MAES");

            return 'MAESTRO';
        }
        else if(re.dankort.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'DANKORT';
        }
        else if(re.interpayment.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'INTERPAYMENT';
        }
        else if(re.unionpay.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'UNIONPAY';
        }
        else if (re.visa.test(number))
        {
          jQuery("#dvisaId").css("display", "block");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
          jQuery("#js_debitbanking").val("VISA");
            return 'VISA';
        }
        else if (re.mastercard.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "block");
          jQuery("#dmaestroId").css("display", "none");
          jQuery("#js_debitbanking").val("MAST");
            return 'MASTERCARD';
        }
        else if (re.amex.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "block");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
          jQuery("#js_debitbanking").val("AmericanExpress");
            return 'AMEX';
        }

        else if (re.discover.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'DISCOVER';
        }
        else if (re.jcb.test(number))
        {
          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return 'JCB';
        }
        else{

          jQuery("#dvisaId").css("display", "none");
          jQuery("#damexId").css("display", "none");
          jQuery("#dmasterId").css("display", "none");
          jQuery("#dmaestroId").css("display", "none");
            return undefined;
        }
  }

</script>
<!-- End Template component://osafe/webapp/osafe/common/entry/js/checkoutJS.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#checkoutJS -->

<form method="post" action="/" id="orderCompleteForm" name="orderCompleteForm">
    <input type="hidden" id="checkoutpage" name="checkoutpage" value="">
    <input type="hidden" name="csrfPreventionSalt" value="4xBvnjYASzPbDXv73Hlb">
    <input type="hidden" name="partyId" value="10230">
    <input type="hidden" name="productStoreId" value="GS_STORE">
    <!-- Begin Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->





<!-- End Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
<!-- End Screen component://osafe/widget/CommonScreens.xml#PageMessages -->

    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_ORDER_CONFIRM -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="ptsOrderConfirm" class="ptsSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_ORDER_CONFIRM -->

    <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmStorePickup -->
<!-- Begin Screen component://osafe/widget/EcommerceScreens.xml#storeDetail -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceStoreDetail.ftl -->
<!-- End Template component://osafe/webapp/osafe/common/eCommerceStoreDetail.ftl -->
<!-- End Screen component://osafe/widget/EcommerceScreens.xml#storeDetail -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmStorePickup -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmShippingGroupSummary -->
<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#orderShippingGroups -->
<!-- Begin Template component://osafe/webapp/osafe/common/order/orderShippingGroups.ftl -->
<div id="orderConfirmId" class="container shippingGroupSummary orderConfirmShippingGroupSummary">
       <div class="displayBox">


        <!--  <h4>Shipping Group 1 of 1</h4> -->

           <div class="boxList cartList">
             <!-- Updated by Krishnamohan J - Start -->

               <span id="orderHeaderId" class="order_headder">
                       <h1>Order Confirmation</h1>
                       </span>

             <!-- Updated by Krishnamohan J - End -->

                <div class="boxListItemTabular shipItem shippingGroupSummary">
                <div class="shippingGroupCartItem grouping grouping1 hk_shippingInfo">
                    
                    
                  <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#shippingGroupOrderShipGroupItem -->
<!-- Begin Template component://osafe/webapp/osafe/common/order/orderItem/shippingGroupOrderShipGroupItem.ftl -->
<div class="thank-stmt">
<h3><?php echo t('Thank you for your order'); ?></h3>
</div>
<ul class="orderPlacedInfo">
<li class="order_conf_orderid ordernum" style="display: block;">
<?php echo t('Order No:'); ?> <?php echo $order['orderId'] ?>
</li>
  <li class="order-placed" style="display: block;"><?php echo t('Order placed on:'); ?> <?php echo date('d/m/Y H:i:s', strtotime($order['OrderHeader'][0]['orderDate'])) ?></li>
  <li class="order_aler_msg" style="display: block;"><?php echo t('We will deliver your order in the shortest possible time. However, if you want to receive the product at a later date, you can convey the same to our delivery boy once he gets in touch with you.'); ?></li>
  <li class="order_conf_orderid" style="display: block;"><?php echo t('Order will be shipped to your shipping address'); ?></li>
  <li>
            
            
            <!-- Begin Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->
<!-- Begin Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->




  <div>
      <span>
      </span>
    </div>
    
 <div class="shippingaddress">
    <ul>
      

    <div class="shipping-addrwrap">


            <li class=" shipname">
                <div>
                    <span style="font-size:1.2em;"><b><?php echo $order['shippingAddress'][0]['toName'] ?></b></span>
                </div>
            </li>
            <li class="address-nname ">
                <h4><?php echo $order['shippingAddress'][0]['attnName'] ?></h4>
            </li>
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $order['shippingAddress'][0]['address1'] . ' ' . $order['shippingAddress'][0]['address2'] ?></span>
                </div>
            </li>
        <li>
            <div>
                    <span style="font-size:1.1em; word-wrap: break-word;"><?php echo $order['shippingAddress'][0]['city'] ?>,</span>
           </div>
        </li>
        <li>
          <div>
                    <span style="font-size:1.1em;">
                            <?php echo $order['shippingAddress'][0]['stateProvinceGeoId'] ?>
,
                            <?php echo $order['shippingAddress'][0]['postalCode'] ?>
                    </span>

          </div>
        </li>
        <!--
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word;">
                           IND
                    </span>
                </div>
            </li>
        -->
        <li>
      <div class=""><span style="font-size:1.1em; word-wrap: break-word;">
      <?php echo t('Phone :'); ?> <?php echo $order['shippingAddress'][0]['contactNumber'] ?>
      </span></div>
    </li>
    
    </div>
    
    <li>
    </li>
       
   </ul>
   </div>
  


<!-- End Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->
<!-- End Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->

  </li>
  <li class="order_conf_orderid" style="display: block;"><?php echo t('Note for Cash on Delivery Orders'); ?></li>
  <li class="order-option" style="display: block;"><?php echo t('When you make a purchase using the COD option, your product will be booked.'); ?></li>
  <li class="order-amount" style="display: block;"><?php echo t('Please keep'); ?> <b class="bold">$ <?php echo format_money($order['orderGrandTotal']) ?></b><?php echo t('ready at the time of delivery.(only US Dollars currency accepted)'); ?></li>
</ul>

<ul class="displayList cartItemList shippingGroupSummary">
  <li class="container shipOption shippingGroupSummaryShipOption firstRow">
      <div>
         <label><?php echo t('Shipping Method'); ?></label>

          <span class="carrGroup"><?php echo t('Delhivery'); ?></span>
          <span class="shipMethod"><?php echo t('Air'); ?></span>
      </div>
    </li>
</ul>
<!-- End Template component://osafe/webapp/osafe/common/order/orderItem/shippingGroupOrderShipGroupItem.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#shippingGroupOrderShipGroupItem -->

                     </div>
                     <div class="orderConfirmation_table">
                      <span class="confirm_orderdetail"><?php echo t('Order Details'); ?></span>
                          <ul class="oc_prodDetails">
                              <li class="oc-hide"><?php echo t('Sr No'); ?></li>
                              <li><?php echo t('Product'); ?></li>
                <li class="oc-qty"><?php echo t('Qty'); ?></li>
               <!-- <li>Delivered by</li> -->
                <li><?php echo t('Price'); ?></li>
               </ul>
             
                       <div class="shippingGroupCartItem grouping grouping2">


                             <div class="shippingGroupCartItem groupRow">
                    
                    
                    
                  
                
                
                
                
                  <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#shippingGroupOrderItem -->
<!-- Begin Template component://osafe/webapp/osafe/common/order/orderItem/shippingGroupOrderItem.ftl -->
 <div class="m-oc">
<span class="order-items" style="display: none;">
              Globus Womens Blue Jackets 
      </span>

<div class="orderConfirmation_table">

<?php foreach ($order['OrderItemList'] as $cart_product): ?>

  <?php
    $nid = get_nid_from_variant_product_id($cart_product['productID']);
    $node = node_load($nid);
    $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
    $product_variant = $system_data->product_variants->{$cart_product['productID']};
  ?>


 <div class="shippingGroupCartItem group group1 oc-product">

   <ul class="displayList cartItemList shippingGroupSummary oc-pro-details">
  <li class="image itemImage shippingGroupSummaryItemImage firstRow">

    <div>
        <img alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
    </div>
  </li>
  <li class="oc-productname string itemName shippingGroupItemName firstRow">
    <div>
      <!--    <label>Item Name&#58;</label>-->
     <!-- <h3>500194</h3> -->
     <span class="order-items2">
        <?php echo $cart_product['productName'] ?>
      </span>

            <?php $selected_features = get_selected_features($product_variant); ?>
            <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
              <?php if (strtolower($selected_feature_name) == 'color'): ?>
                <div class="color-swatch">
                  <div class="color-text"><?php echo t('Color:'); ?></div>
                  <div class="color-code" style="background-color:<?php echo $selected_feature_value ?>;"></div>
                </div>
              <?php elseif (strtolower($selected_feature_name) == 'size'): ?>
                <div class="size-swatch">
                  <div class="size-text"><?php echo t('Size:'); ?></div>
                  <div class="size-code"><?php echo $selected_feature_value ?></div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>

    </div>

  </li>



    <li class="number itemQty shippingGroupSummaryItemQty firstRow">
      <div>
      <!--  <label>Quantity&#58;</label> -->
           <span class="qty" style="display: none;"><?php echo t('Qty:'); ?></span>
        <span class="qty-list"><?php echo (int)$cart_product['quantity'] ?></span>
      </div>
  </li>
  <!--
  <li>
    <div> <span class="devlivery-date">Fri,30th June</span></div>
  </li>

  <li>
-->
  <li class="oc-fnprice priceOnline">
      <div id="resPrice2" style="display: block;">
        <span class="bold">$ <?php echo format_money($cart_product['productPrice']) ?></span>
      </div>
      <div>
    <?php if(!empty($cart_product['promoName'])) { ?>
          <span><?php echo t('Promo Applied:'); ?> <?php echo $cart_product['promoName'] ?></span>
      <?php } ?>
      </div>
  </li>
   </ul>
 </div>

<?php endforeach; ?>


</div>

     </div>

<script lnaguage="javascript">
    if(jQuery(window).width() <= 767){
    jQuery(".order-items2").css("display","none");
    jQuery(".currency").css("display","none");
    }
</script><!-- End Template component://osafe/webapp/osafe/common/order/orderItem/shippingGroupOrderItem.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#shippingGroupOrderItem -->

                  </div>





               <div class="order_rewards">
                  <span class="bold"></span>
               </div>
                 <div class="OC-billstatus">

                 <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
  <?php $promoTotalAmount = getTotalPromoAmount($cartItems); ?>
    <label><?php echo t('Sub Total:'); ?></label>
        <span>$ <?php echo format_money($order['shoppingCartItemTotal']) ?></span>
  </div>
</li>

  <?php if(!empty($order['partyAppliedStoreCreditTotal'])) { ?>
    <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
    <div class="sub-total">
      <label><?php echo t('Store Credit:'); ?> </label>
      <span>-$ <?php echo format_money($order['partyAppliedStoreCreditTotal']) ?></span>
    </div>
    </li>
  <?php } ?>

          <?php if(!empty($promoTotalAmount)) { ?>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
                 
  <div class="sub-total">

    <label><?php echo t('Promo Discount:'); ?> </label>

        <span>- $ <?php echo format_money($promoTotalAmount) ?></span>
  </div>
</li>
 <?php } ?>

      <?php if(!empty($order['couponCode'])) { ?>
        <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
        <div class="sub-total">
           <label><?php echo t('Coupon Discount:'); ?> </label>
           <span> $ <?php echo format_money($order['couponValue']) ?></span>
        </div>
        </li>
      <?php } ?>

        <?php if(isset($order['loayaltyAmount'])): ?>
       <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
       <div class="sub-total">
         <label>Loyalty Amount:</label>
         <span>-$ <?php echo format_money($order['loayaltyAmount']) ?></span>
           </div>
         </li>
        <?php endif; ?>
<!-- Added by Krishnamohan - Start -->

  <!-- <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
   <div class="sub-total">
    <label>COD Charges:</label>
      <span> $ <?php echo $order['orderId'] ?></span>
    </div>
  </li> -->

<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
      <label><?php echo t('Tax Collected:'); ?></label>
        <span>  $ <?php echo format_money($order['salesTax']) ?></span>
  </div>
</li>

<?php if (!empty($order['orderShippingTotal'])): ?>
  <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
    <div class="sub-total">
        <label><?php echo t('Shipping Charges:'); ?></label>
              <span>$ <?php echo format_money($order['orderShippingTotal']) ?></span>
    </div>
  </li>
<?php endif; ?>

<li>
</li>
<li>
</li>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
  </div>
</li>
<?php $storeCredit = 0; ?>
<?php if(!empty($order['partyAppliedStoreCreditTotal'])) { ?>
  <?php $storeCredit = $order['partyAppliedStoreCreditTotal'] ; ?>
<?php } ?>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
 <div class="sub-total">
  <label><?php echo t('Grand Total:'); ?></label>
    <span>$ <?php echo format_money($order['orderGrandTotal'] - $storeCredit) ?></span>
  </div>
</li>
<!-- Added by Krishnamohan - End -->
</div>
              <!-- <div class="orderDelivery_conditions">Due to overwhelming response for our no conditions sale, our delivery time is slightly higher that usual.</div> -->
               <div class="gb-support"><?php echo t('Any problems? Call us at 022 12345678 or email us'); ?> <a href="mailto:cs@sonata-software.com">cs@sonata-software.com</a></div>

             </div>
                      </div>
           </div>
           </div>
           <div class="orderConfirm_continueBtn"><li>
   <div>
     <a class="standardBtn" href="<?php echo url() ?>"><span><?php echo t('Continue Shopping'); ?></span></a>
     </div> 
  </li>
 
</div>
         </div>
  </div>
   </form></div>
<script lnaguage="javascript">
    if(jQuery(window).width() <= 767){
      jQuery("#orderConfirmId").css("display","none");
      jQuery("#orderHeaderId").css("display","none");
    }
</script><!-- End Template component://osafe/webapp/osafe/common/order/orderShippingGroups.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#orderShippingGroups -->
<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#orderShippingGroupsResponsive -->
<!-- Begin Template component://osafe/webapp/osafe/common/order/orderShippingGroupsResponsive.ftl -->
<div id="orderConfirmId2" class="container shippingGroupSummary orderConfirmShippingGroupSummary" style="display: none;">
       <div class="displayBox">
        <!--  <h4>Shipping Group 1 of 1</h4> -->
           <div class="boxList cartList">
             <!-- Updated by Krishnamohan J - Start -->
             <div class="oc-mesg">
               <span id="orderHeaderId" class="thankyou-messag">
                       <?php echo t('Your order has been placed.'); ?> <span class="thankyou"><?php echo t('Thank You!'); ?></span>
                       </span>
                       <div class="stamp"><img src="osafe_theme/images/user_content/images/stamp.png"></div>
             <!-- Updated by Krishnamohan J - End -->
              <div class="info">
            <span class="yourorder"> <?php echo t('Your order number is'); ?> </span> <span> GS10200</span>
            </div>
            </div>
                <div class="boxListItemTabular shipItem shippingGroupSummary">
            
            <h2 class="ordr-summry"><?php echo t('Order Summary'); ?></h2>
            <div class="oc-summry"><p><?php echo t('Order placed on:'); ?> <span>12/28/2016 , 01:54:59</span></p><p></p></div>
            <div class="OC-billsummery"><li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
    <label><?php echo t('Sub Total:'); ?></label>
        <span>$ 599</span>
  </div>
</li>
<!-- Added by Krishnamohan - Start -->

  <li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
   <div class="sub-total">
    <label><?php echo t('COD Charges:'); ?></label>
      <span> $ 49</span>
    </div>
  </li>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
      <label><?php echo t('Tax Collected:'); ?></label>
        <span>  $ 27 </span>
  </div>
</li>

<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
      <label><?php echo t('Shipping Charges:'); ?></label>
            <span>$ 50</span>
  </div>
</li>

<li>
</li>
<li>
</li>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
  <div class="sub-total">
  </div>
</li>
<li class="container shippingGroupSummary orderConfirmShippingGroupSummary oc-summry">
 <div class="sub-total">
  <label><?php echo t('Total Amount'); ?></label>
    <span>$ 725</span>
  </div>
</li>
<!-- Added by Krishnamohan - End -->
</div>                                 
                     <div class="orderConfirmation_table">

                       <div class="shippingGroupCartItem grouping grouping2">
                             <div class="shippingGroupCartItem groupRow">
                    
                    
                    
                  
                
                
                
                
                  <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#shippingGroupOrderItem -->
<!-- Begin Template component://osafe/webapp/osafe/common/order/orderItem/shippingGroupOrderItem.ftl -->
 <div class="m-oc">

<div class="orderConfirmation_table">

</div>
<div>
</div>

     </div>

                  </div>
             </div>
           </div>

           </div>
           </div>
           <div class="orderConfirm_continueBtn"><li>
   <div>
     <a class="standardBtn" href="/home"><span><?php echo t('Continue Shopping'); ?></span></a>
     </div> 
  </li>
 
</div>
         </div>
  </div>
<script lnaguage="javascript">
    if(jQuery(window).width() >= 767){
      jQuery("#orderConfirmId2").css("display","none");       
      jQuery(".order_aler_msg").css("display","block");
      jQuery(".order_conf_orderid").css("display","block");  
      jQuery(".order_conf_orderid").css("display","block");       
      jQuery(".order-option").css("display","block");
      jQuery(".order-amount").css("display","block");
      jQuery(".order_conf_orderid").css("display","block");
      jQuery(".order-placed").css("display","block");
       jQuery(".order-items").css("display","none");
       jQuery(".qty").css("display","none");
       jQuery("#resPrice").css("display","none");   
       jQuery("#resPrice2").css("display","block");    
    }
</script><!-- End Template component://osafe/webapp/osafe/common/order/orderShippingGroupsResponsive.ftl -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#orderShippingGroupsResponsive -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmShippingGroupSummary -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmPreviousButton -->
<!-- Begin Template component://osafe/webapp/osafe/common/cart/previousCartButton.ftl -->
<!-- End Template component://osafe/webapp/osafe/common/cart/previousCartButton.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmPreviousButton -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmContinueButton -->
<!-- Begin Template component://osafe/webapp/osafe/common/cart/continueCartButton.ftl -->
<input type="hidden" name="fbDoneAction" value="">

<script>
   function preventBack(){window.history.forward();}
   setTimeout("preventBack()", 0);
</script>
<!-- End Template component://osafe/webapp/osafe/common/cart/continueCartButton.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmContinueButton -->



<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderConfirmDivSequence -->

    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ORDER_CONFIRM -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="pesOrderConfirm" class="pesSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ORDER_CONFIRM -->




<!-- End Template component://osafe/webapp/osafe/templates/commonCheckout.ftl -->
</div>