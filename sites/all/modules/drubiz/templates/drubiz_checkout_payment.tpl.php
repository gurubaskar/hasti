<?php //krumo($_SESSION['drubiz']['CODAvailable']) ?>
<?php $cartItems = $cart['productList']; ?>
<?php //krumo($cart);?>
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
  <div id="multiPageOrderSummary" class="multiPageOrderSummary">
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
        jQuery.post("/getAssociatedStateList", {countryGeoId: jQuery("#"+countryId).val()}, function(data) {
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
        jQuery.post("/getPostalAddress", {contactMechId: contactMechId}, function(data) {
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
             today = new Date();
             someday = new Date();
           someday.setFullYear(document.getElementById(expYear).value, document.getElementById(expMonth).value, 30);
             if (someday < today) {
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
      
                 form.action="/multiPageAddOrUpdateCustomerAddress";
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
                  form.action="/multiPageShippingOptions?action=previous";
                  form.submit();
              }  else if (mode == "SCBK") {
                  form.action="eCommerceShowcart";
                  form.submit();
              }  else if (mode == "CABK") {
                  form.action="/multiPageCustomerAddress?action=previous";
                  form.submit();
              }  else if (mode == "SOBK") {
                  form.action="/multiPageShippingOptions?action=previous";
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
                  form.action="/setPayPalCheckout";
                  form.submit();
              } else if (mode == "SO") {
      
                var temp = document.getElementById("js_submitOrderBtn").value ;
                document.getElementById("js_submitOrderBtn").value = "Placing an Order";
                var grandTotal="675.95";
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
                      form.action="/multiPageSubmitOrder";
                  }else{
                    document.getElementById("js_submitOrderBtn").value = temp;
                    jQuery("#responseMessage").html("Unable to continue as OTP is not validated");
                    return;
                  }
                  /* Updated by Krishnamohan J - End */
                }
                }
                else{
                 form.action="/multiPageSubmitOrder";
                 }
                 form.submit();
      
              } else if (mode == "EB") {
                  document.getElementById("js_paymentMethodTypeId").value = value;
                  form.action="/multiPageEBSCheckout";
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
                      document.checkoutInfoForm.action="/setMultiPageOrderSummaryStorePickup";
                      document.checkoutInfoForm.submit();
              } else if (mode == "PNZ") {
                  document.getElementById("js_paymentMethodTypeId").value = value;
                  form.action="/multiPagePayNetzCheckout";
                  form.submit();
              } else if (mode == "BBK") {
                  window.history.back();
              }
            }
          }
      
          function updateCart()
          {
            var cartIsValid = true;
            var cartItemsNo = 1;
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
                  //window.location='/deleteFromCart';
              }
              return cartIsValid;
          }
      
          function updateWishlist()
          {
            var cartIsValid = true;
            var cartItemsNo = 1;
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
            var cartItemsNo = 1;
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
             var cform = document.checkoutInfoForm;
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
                 var cform = document.checkoutInfoForm;
             var url="/validateCartPromoCode?productPromoCodeId="+promoCodeWithoutSpace+"";
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
                var cform = document.checkoutInfoForm;
                var url="/removeCartPromoCode?productPromoCodeId="+promoCode+"";          
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
              var cform = document.checkoutInfoForm;
              cform.action="/multiPageAddGiftCardNumber?gcNumber="+giftCardNumberWithoutSpace+"";
              cform.submit();
          }
      
          function removeGiftCardNumber(gcPaymentMethodId)
          {
              if (gcPaymentMethodId != null)
              {
                var cform = document.checkoutInfoForm;
                cform.action="/multiPageRemoveGiftCardNumber?gcPaymentMethodId="+gcPaymentMethodId+"";
                cform.submit();
              }
          }
      
          function addLoyaltyPoints()
          {
            jQuery('#js_applyLoyaltyCard').bind('click', false);
            var loyaltyNo=jQuery("#js_loyaltyPointsId").val();
              var cform = document.checkoutInfoForm;
              var url="/validateLoyaltyPoints?loyaltyPointsId="+loyaltyNo+"";
               return ajaxFormSubmit(url,cform);
          }
          function removeLoyaltyPoints()
          {
            jQuery('#js_removeLoyaltyCard').bind('click', false);
            var cform = document.checkoutInfoForm;
            window.location='/removeLoyaltyPoints'
            //var url="/removeLoyaltyPoints";
            //return ajaxFormSubmit(url,cform);
          }
          function updateLoyaltyPoints(indexOfAdj)
          {
            jQuery('#js_updateLoyaltyPointsAmount').bind('click', false);
            var cform = document.checkoutInfoForm;
            var url="/validateUpdateLoyaltyPoints";
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
    <form method="post" action="/" id="checkoutInfoForm" name="checkoutInfoForm">
      <input type="hidden" id="checkoutpage" name="checkoutpage" value="payment">
      <input type="hidden" name="csrfPreventionSalt" value="tOIPjtQN4crXOybhx0vg">
      <input type="hidden" name="partyId" value="10230">
      <input type="hidden" name="productStoreId" value="GS_STORE">
      <!-- Begin Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
      <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
      <!-- End Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
      <!-- End Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
      <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_ORDER_SUMMARY -->
      <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
      <!-- Begin Section Widget  -->
      <div id="ptsOrderSummary" class="ptsSpot"></div>
      <!-- End Section Widget  -->
      <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
      <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_ORDER_SUMMARY -->
      <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryDivSequence -->
      <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
      <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
      <div class="OrderSummary group group1">
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryFootprint -->
        <!-- Begin Template component://osafe/webapp/osafe/common/orderSummaryFootprint.ftl -->
        <style>
          .mainul{ clear:both;}
          .mainul li{display:inline; margin-right:84px;}
          .step ul{width:auto;}
        </style>
        <ul class="mainul">
          <li>
            <!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/3-1.jpg">-->
            <div class="progress_dot inactive" id="login-stage">
              <div class="progress_state levelone"><?php echo t('confirm order');?></div>
              <div class="resp_progress_state resplevelone">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </div>
            </div>
          </li>
          <a href="<?php echo url('checkout') ?>">
            <li>
              <!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/3-2.jpg">-->
              <div class="progress_dot inactive" id="shipping-stage">
                <div class="progress_state leveltwo"><?php echo t('shipping address');?></div>
                <div class="resp_progress_state respleveltwo">
                  <i class="fa fa-truck" aria-hidden="true"></i>
                </div>
              </div>
            </li>
          </a>
          <li class="resp-active">
            <!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/3-3.jpg">-->
            <div class="progress_dot active" id="payment-stage">
              <div class="progress_state levelthree"><?php echo t('payment method');?></div>
              <div class="resp_progress_state resplevelhree">
                <i class="fa fa-money" aria-hidden="true"></i>
              </div>
            </div>
          </li>
        </ul>
        <!-- End Template component://osafe/webapp/osafe/common/orderSummaryFootprint.ftl -->
        <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryFootprint -->
      </div>
      <div class="OrderSummary group group2">
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryPaymentOptions -->
        <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#multiPageOrderPayment -->
        <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceOrderPaymentMethods.ftl -->
        <input type="hidden" name="productId0" id="js_productId_0" value="2472544">
        <input type="hidden" id="gusetUserPartyId" value="10230">
        <div class="container paymentOptions orderSummaryPaymentOptions">
          <div class="displayBox">
            <!--<h3>Payment Information</h3>-->
            <div>
              <div id="js_remainingPayment" class="container remainingPayment">
                <!-- ajith -->
                <!--<h4>Total Amount Due</h4> -->
                <!-- <label>BALANCE DUE&#58;</label> -->
                <!-- <span>&#x20B9; 676</span> -->
                <input type="hidden" name="remainingPayment" id="js_remainingPaymentValue" value="675.95">
              </div>
              <input type="hidden" id="BACK_PAGE" name="BACK_PAGE" value="checkoutoptions">
              <input type="hidden" name="pinCode" id="pinCodes" value="">
              <input type="hidden" name="companyNameOnCard" id="companyNameOnCard" value="">
              <input type="hidden" name="titleOnCard" id="titleOnCard" value="">
              <input type="hidden" name="firstNameOnCard" id="firstNameOnCard" value="Akshay">
              <input type="hidden" name="middleNameOnCard" id="middleNameOnCard" value="">
              <input type="hidden" name="lastNameOnCard" id="lastNameOnCard" value="Patel">
              <input type="hidden" name="suffixOnCard" id="suffixOnCard" value="">
              <input type="hidden" name="cardSecurityCode" id="cardSecurityCode" value="">
              <input type="hidden" name="description" id="cardSecurityCode" value="">
              <input type="hidden" name="contactMechId" id="contactMechId" value="">
              <input type="hidden" name="paymentMethodTypeId" id="js_paymentMethodTypeId" value="CREDIT_CARD">
              <input type="hidden" name="storeCCRequired" id="storeCCRequired" value="FALSE">
              <input type="hidden" name="storeCCValidate" id="storeCCValidate" value="FALSE">
              <!-- End of checkoutPaymentOptions DIV -->
              <input type="hidden" id="mailId" name="email" value="akshay.p@sonata-software.com">
              <input type="hidden" name="amount" value="675.950000000">
              <input type="hidden" name="productinfo" value="ProductId - 2472544, , , ,  PiecesIncluded - 1, , ">
              <input type="hidden" name="phone" value="9916574985">
              <input type="hidden" name="firstname" value="Akshay">
              <input type="hidden" name="lastname" value="Patel">
              <input type="hidden" name="surl" value="https://182.72.231.54:8443//ebsCheckoutReturn">
              <input type="hidden" name="furl" value="https://182.72.231.54:8443//ebsCheckoutReturn">
              <input type="hidden" name="key" value="gtKFFx">
              <input type="hidden" name="hash" id="hash" value="15f3205cab2b86b9f1f54700f2ad78cc8ae116009a5306156bd6f4c0484fc9c584c0def49405440d4853fdb91393db0499986de5b13b80822a2c00c6fcd97ade">
              <input type="hidden" name="txnid" id="txnid" value="afb989c9fb2a86916764">
              <input type="hidden" name="ccnum" id="ccnum" value="">
              <input type="hidden" name="ccvv" id="ccvv" value="">
              <input type="hidden" name="ccexpmon" id="ccexpmon" value="">
              <input type="hidden" name="ccexpyr" id="ccexpyr" value="">
              <input type="hidden" name="pg" id="pg" value="CC">
              <input type="hidden" name="Bankcode" id="Bankcode" value="CC">
            </div>
          </div>
          <?php if(isset($_SESSION['drubiz']['CODAvailable']))
            $CODAvailable = $_SESSION['drubiz']['CODAvailable'] ; 
            ?>
          <?php if($CODAvailable == "TRUE") {?>
          <div id="payment_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-vertical ui-helper-clearfix">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
              <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="-1" aria-controls="d" aria-labelledby="ui-id-4" aria-selected="false">
                <a href="#d" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"><?php echo t('COD');?></a>
              </li>
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="creditCardTab" aria-labelledby="ui-id-1" aria-selected="true">
                <a href="#creditCardTab" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">
                <?php echo t('Credit card');?>
                </a>
              </li>
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="debitCardTab" aria-labelledby="ui-id-2" aria-selected="false">
                <a href="#debitCardTab" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><?php echo t('Debit card');?></a>
              </li>
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="c" aria-labelledby="ui-id-3" aria-selected="false">
                <a href="#c" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><?php echo t('Net Banking');?></a>
              </li>
              <!--here-->
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="s" aria-labelledby="ui-id-5" aria-selected="false">
                <a href="#s" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5"><?php echo t('Store Credit');?></a>
              </li>
            </ul>
            <div class="paymentMethods">
              <div class="paymentTypeSelectContainer">
                <span id="paymentTypeSelect"><?php echo t('Select');?></span>
                <span id="arrowdownside"></span>
                <span id="arrowupside"></span>
              </div>
              <ul id="sel-option">
                <li class="current"> <a href="#creditCardTab"><?php echo t('Credit card');?></a></li>
                <li> <a href="#debitCardTab"><?php echo t('Debit card');?></a></li>
                <li><a href="#c"><?php echo t('Net Banking');?></a></li>
                <li> <a href="#d"><?php echo t('COD');?></a></li>
                <li> <a href="#s"><?php echo t('Store Credit');?></a></li>
              </ul>
            </div>
            <div id="creditCardTab" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false" style="display: block;">
              <div class="container creditCard js_creditCardEntry">
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel"><input type="radio" id="useSavedCard" name="paymentOption" value="PAYOPT_CC_NEW" checked="checked"><span class="radioOptionText"><?php echo t('Credit Card');?></span></label>
                </div>
                <input type="hidden" name="useSavedCard" value="N">
                <div class="entry cardType" style="display:none;">
                  <label for="cardType"><span class="required">*</span>
                  <?php echo t('Card Type');?></label>
                  <div class="entryField customselect">
                    <select id="js_cardType" name="cardType" class="cardType">
                      <option value=""><?php echo t('Select One');?></option>
                      <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccTypes -->
                      <!-- Begin Template component://osafe/webapp/osafe/common/ccTypes.ftl -->
                      <option value="Visa"><?php echo t('Visa');?></option>
                      <option value="MasterCard"><?php echo t('Master Card');?></option>
                      <option value="AmericanExpress"><?php echo t('American Express');?></option>
                      <option value="DinersClub"><?php echo t('Diners Club');?></option>
                      <!-- End Template component://osafe/webapp/osafe/common/ccTypes.ftl -->
                      <!-- End Screen component://osafe/widget/CommonScreens.xml#ccTypes -->
                    </select>
                  </div>
                </div>
                <div class="entry nameOnCard">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Name on card');?></label>
                  <div class="entryField">
                    <input type="text" class="ccname" maxlength="30" id="ccname" name="ccname" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry cardNumber">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Card Number:');?></label>
                  <div class="entryField">
                    <input type="text" class="cardNumber" maxlength="30" id="js_cardNumber_mask" name="cardNumber_mask" value="" autocomplete="off" onkeyup="formatCreditCard(this,event)" onblur="detectCardType(this.value);">
                    <span class="guest-pic" style="display:block;">
                    <img id="visaId" src="<?php echo current_theme_path() ?>/images/visa.png" style="display:none" ;="">
                    <img id="amexId" src="<?php echo current_theme_path() ?>/images/amex.png" style="display:none" ;="">
                    <img id="masterId" src="<?php echo current_theme_path() ?>/images/mastercard.png" style="display:none" ;="">
                    <img id="dinersId" src="<?php echo current_theme_path() ?>/images/diners.png" style="display:none" ;="">
                    </span>
                    <input type="hidden" class="cardNumber" maxlength="30" id="js_cardNumber" name="cardNumber" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry expMonth">
                  <label for="expMonth"><span class="required">*</span>
                  <?php echo t('expiration date:');?></label>
                  <div class="entryField">
                    <div class="cardmonthdiv">
                      <div class="customselect cardexpmonth">
                        <select id="js_expMonth" name="expMonth" class="expMonth">
                          <option value=""><?php echo t('Month');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                        </select>
                      </div>
                    </div>
                    <div class="cardyeardiv">
                      <div class="customselect cardexpyear">
                        <select id="js_expYear" name="expYear" class="expYear">
                          <option value=""><?php echo t('Year');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="entry" id="js_verificationNo1">
                  <label for="verificationNo"><span class="required">*</span>
                  <?php echo t('VERIFICATION:');?></label>
                  <div class="entryField">
                    <input type="password" class="cardNumber card-valid" maxlength="4" id="js_verificationNo" name="verificationNo" value="">
                    <a class="cvvicon">
                      <img src="<?php echo current_theme_path() ?>/images/cvvicon.png" alt="cvv" onclick="creditCVVClick()">
                      <span id="">
                        <span class="arrow_box">
                          <p><?php echo t('The CVV number is the last 3 digits printed on the signature panel on the back of the Card.') ?></p>
                          <img src="<?php echo current_theme_path() ?>/images/cvv.jpg">
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <span id="creditCvv">
                  <p><?php echo t('The CVV number is the last 3 digits printed on the signature panel on the back of the Card.') ?></p>
                  <img src="<?php echo current_theme_path() ?>/images/cvv.jpg">
                </span>
                <div class="entry content">
                  <label for="content">&nbsp;</label>
                  <span>
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- Begin Section Widget  -->
                    <div id="checkoutCcVerify"></div>
                    <!-- End Section Widget  -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                  </span>
                </div>
              </div>
            </div>
            <div id="debitCardTab" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_CC_NEW">
              <div class="container paymentOption js_codOptions">
                <!-- Netbanking added by veeraprasad end -->
                <!-- Debit Card Payment added by veeraprasad end -->
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel">
                  <input type="radio" id="debitcardPayment" name="paymentOption" value="PAYOPT_NETBANKING" checked="checked">
                  <span class="codtext"><?php echo t('Debit Card');?></span>
                  </label>
                </div>
                <div class="entry debitbanking" style="display:none;">
                  <label for="debitbanking"><span class="required">*</span>
                  <?php echo t('Card Type:');?></label>
                  <div class="entryField customselect">
                    <select id="js_debitbanking" name="debitbanking" class="savedCard">
                      <option value=""><?php echo t('Select One');?></option>
                      <option value="VISA">Visa Cards</option>
                      <option value="MAST">MasterCard</option>
                      <option value="SMAE">SBI Maestro</option>
                      <option value="MAES">Other Maestro</option>
                    </select>
                  </div>
                </div>
                <div class="entry nameOnCard">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Name on card');?></label>
                  <div class="entryField">
                    <input type="text" class="ccname" maxlength="30" id="dccname" name="ccname" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry cardNumber">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Card Number:');?></label>
                  <div class="entryField">
                    <input type="text" class="cardNumber" maxlength="30" id="js_dcardNumber_mask" name="dcardNumber_mask" value="" autocomplete="off" onkeyup="formatCreditCard(this,event)" onblur="debitDetectCardType(this.value);">
                    <span class="guest-pic" style="display:block;">
                    <img id="dvisaId" src="<?php echo current_theme_path() ?>/images/visa.png" style="display:none" ;="">
                    <img id="damexId" src="<?php echo current_theme_path() ?>/images/amex.png" style="display:none" ;="">
                    <img id="dmasterId" src="<?php echo current_theme_path() ?>/images/mastercard.png" style="display:none" ;="">
                    <img id="dmaestroId" src="<?php echo current_theme_path() ?>/images/maestro.png" style="display:none" ;="">
                    </span>
                    <input type="hidden" class="cardNumber" maxlength="30" id="js_dcardNumber" name="dcardNumber" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry expMonth">
                  <label for="expMonth"><span class="required">*</span>
                  <?php echo t('expiration date:');?></label>
                  <div class="entryField">
                    <div class="cardmonthdiv">
                      <div class="customselect cardexpmonth">
                        <select id="js_dexpMonth" name="dexpMonth" class="expMonth">
                          <option value=""><?php echo t('Month');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                        </select>
                      </div>
                    </div>
                    <div class="cardyeardiv">
                      <div class="customselect cardexpyear">
                        <select id="js_dexpYear" name="dexpYear" class="expYear">
                          <option value=""><?php echo t('Year');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="entry" id="js_dverificationNo1">
                  <label for="verificationNo"><span class="required">*</span>
                  <?php echo t('Verification:');?></label>
                  <div class="entryField">
                    <input type="password" class="cardNumber card-valid" maxlength="4" id="js_dverificationNo" name="dverificationNo" value="">
                    <a class="cvvicon">
                      <img src="<?php echo current_theme_path() ?>/images/cvvicon.png" alt="cvv" onclick="debitCVVClick()">
                      <span id="">
                        <span class="arrow_box">
                          <p>The CVV number is the last 3 digits printed on the signature panel on the back of the Card.<img src="<?php echo current_theme_path() ?>/images/cvv.jpg"></p>
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <span id="debitCvv">
                  <p>The CVV number is the last 3 digits printed on the signature panel on the back of the Card.<img src="<?php echo current_theme_path() ?>/images/cvv.jpg"></p>
                </span>
                <div class="entry content">
                  <label for="content">&nbsp;</label>
                  <span>
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- Begin Section Widget  -->
                    <div id="checkoutCcVerify"></div>
                    <!-- End Section Widget  -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                  </span>
                </div>
                <!-- Debit Card Payment added by veeraprasad end -->
              </div>
            </div>
            <div id="c" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_CC_NEW">
              <div class="container paymentOption js_codOptions">
                <!-- Netbanking added by veeraprasad start -->
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel">
                  <input type="radio" id="netbankingPayment" name="paymentOption" value="PAYOPT_NETBANKING" onclick="netBanking();" checked="checked">
                  <span class="codtext">NET BANKING</span>
                  </label>
                </div>
                <div id="netbanking" class="entry selectbank">
                  <lable for="js_savedCard"><?php echo t('Select Bank :');?></lable>
                  <div class="customselect">
                    <select id="js_netbanking" name="netbanking" class="savedCard">
                      <option value=""><?php echo t('Select One');?></option>
                      <option value="AXIB">AXIS Bank NetBanking</option>
                      <option value="IDBB">Industrial Development Bank of India</option>
                      <option value="INDB">Indian Bank</option>
                      <option value="INIB">IndusInd Bank</option>
                      <option value="INOB">Indian Overseas Bank</option>
                      <option value="JAKB">Jammu and Kashmir Bank</option>
                      <option value="KRKB">Karnataka Bank</option>
                      <option value="KRVB">Karur Vysya - Retail Netbanking</option>
                      <option value="KRVBC">Karur Vysya - Corporate Netbanking</option>
                      <option value="SBBJB">State Bank of Bikaner and Jaipur</option>
                      <option value="SBHB">State Bank of Hyderabad</option>
                      <option value="BOIB">Bank of India</option>
                      <option value="SBIB">State Bank of India</option>
                      <option value="SBMB">State Bank of Mysore</option>
                      <option value="SBTB">State Bank of Travancore</option>
                      <option value="SOIB">South Indian Bank</option>
                      <option value="UBIB">Union Bank - Retail Netbanking</option>
                      <option value="UBIBC">Union Bank - Corporate Netbanking</option>
                      <option value="UNIB">United Bank Of India</option>
                      <option value="VJYB">Vijaya Bank</option>
                      <option value="YESB">Yes Bank</option>
                      <option value="CUBB">CityUnion</option>
                      <option value="BOMB">Bank of Maharashtra</option>
                      <option value="CABB">Canara Bank</option>
                      <option value="SBPB">State Bank of Patiala</option>
                      <option value="DSHB">Deutsche bank Netbanking</option>
                      <option value="162B">kotak bank Netbanking</option>
                      <option value="DLSB">Dhanlaxmi Netbanking</option>
                      <option value="INGB">ING Vysya Netbanking</option>
                      <option value="CSBN">Catholic Syrian Bank</option>
                      <option value="PNBB">Punjab Nation Bank - Retail Netbanking</option>
                      <option value="CPNB">Punjab Nation Bank - Corporate Netbanking</option>
                      <option value="CBIB">Central Bank Of India</option>
                      <option value="CRPB">Corporation Bank</option>
                      <option value="DCBB">Development Credit Bank</option>
                      <option value="FEDB">Federal Bank</option>
                      <option value="HDFB">HDFC Bank</option>
                      <option value="ICIB">ICICI Netbanking</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="d" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <div class="codPayment">
              </div>
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_COD">
              <div class="container paymentOption js_codOptions">
                <div class="cash-pay"><?php echo t('Amount payable at the time of delivery') ?>
                  <span id="totalWithOutCODFee" style="display: block;">
                  $ <?php echo format_money($cart['orderGrandTotal'])  - $cart['partyAppliedStoreCreditTotal'] ?>
                  </span>
                  <span id="totalWithCODFee" style="display:none;">
                  <span>$ 725</span>
                  </span>
                </div>
                <div id="checkoutCODFeeCnt" style="display:none;" class="cod-help">Includes Rs. 49 as convenience charge for Cash on Delivery</div>
                <!-- <div id="codOtpHlpTxt" class="cod-help">In order to confirm your order,please click on "Send OTP" button and enter  One Time Password here</div> -->
                <div class="entry codbar cod_radiobutton">
                  <label class="radioOptionLabel">
                    <input style="display:none;" type="radio" id="codPayment" name="paymentOption" value="PAYOPT_COD" onclick="javascript:codAlert(cartSubTotal.value,this.value,this.checked,codLimit.value);" checked="checked">
                    <!-- <span class="codtext" data-payment-method="CashOnDelivery" title="Cash On Delivery is not permitted for orders above Rs. 10000/- (Rupees Ten Thousand). Please select from the other available payment methods to complete your transaction." disabled="disabled"> COD (Cash on Delivery)</span> -->
                  </label>
                  <input type="hidden" id="isOtpValid" value="">
                  <!-- <input class="otp-validate" id="otpSendOTP" type="button" value="Send OTP"> -->
                  <div id="otpSection" style="display:none;" class="otp-number">
                    <label for"otptxt"="">OTP: <input type="text" class="otp-col" id="otptxt" name="otptxt" autocomplete="off"></label>
                    <input class="otp-validate" id="otpValidate" type="button" value="Validate OTP">
                  </div>
                  <div id="responseMessage" class="otp-msg"></div>
                  <!-- Added by Krishnamohan - End -->
                </div>
              </div>
            </div>
            <div id="s" aria-labelledby="ui-id-5" style="display: none;">
              <div class="displayBox">
                <h3><?php echo t('Store Credit Redemption');?></h3>
                <ul class="displayActionList">
                  <li>
                    <div>
                      <!--<?php echo $storeCredit['partyAppliedStoreCreditTotal']; ?>-->
                      <label><?php echo t('You have a');?> <?php echo $storeCredit['partyStoreCreditBalance']; ?> <?php echo t('Store Credit available');?></label>
                    </div>
                  </li>
                  <li>
                    <?php //krumo($storeCredit['partyAppliedStoreCreditTotal']);
                      if (!empty($storeCredit['partyAppliedStoreCreditTotal'])){?>
                    <label>   You have applied <?php echo $storeCredit['partyAppliedStoreCreditTotal'] ?> Store Credit points </label>
                    <input type="button" id="removeStoreCredit" value="Remove Store Credit"/>
                    <?php } else { ?>
                    <div>
                      <input id="useStoreCredit" name="useStoreCredit" value="Redeem Store Credit" type="button">
                    </div>
                    <div id="store_redeem" style="display:none;">
                      <label id="js_storeCreditAmountRedeem"><?php// echo t('Amount To Be Redeemed:');?></label>
                      <?php if (!empty($storeCredit['partyAppliedStoreCreditTotal'])) { ?>
                      <input id="js_storeCreditAmount" placeholder="Enter amount to be redeemed" value="<?php echo $storeCredit['partyAppliedStoreCreditTotal'] ?>" name="storeCreditAmount" value=""  autocomplete="off" type="text">
                      <?php } else { ?>
                      <input id="js_storeCreditAmount" placeholder="Enter amount to be redeemed"name="storeCreditAmount" value="" autocomplete="off" type="text">
                      <?php } ?>
                      <input id="save_credit" value="Save" type="button"/>
                    </div>
                    <?php } ?>
                    <span id="creditErrorInfo"></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <?php }else { ?>
          <div id="payment_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-vertical ui-helper-clearfix">
            <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
              <!--<li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="-1" aria-controls="d" aria-labelledby="ui-id-4" aria-selected="false">
                <a href="#d" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4"><?php //echo t('COD');?></a>
                </li>-->
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="0" aria-controls="creditCardTab" aria-labelledby="ui-id-1" aria-selected="true">
                <a href="#creditCardTab" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">
                <?php echo t('Credit card');?>
                </a>
              </li>
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="debitCardTab" aria-labelledby="ui-id-2" aria-selected="false">
                <a href="#debitCardTab" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2"><?php echo t('Debit card');?></a>
              </li>
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="c" aria-labelledby="ui-id-3" aria-selected="false">
                <a href="#c" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3"><?php echo t('Net Banking');?></a>
              </li>
              <!--here-->
              <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="s" aria-labelledby="ui-id-5" aria-selected="false">
                <a href="#s" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-5"><?php echo t('Store Credit');?></a>
              </li>
            </ul>
            <div class="paymentMethods">
              <div class="paymentTypeSelectContainer">
                <span id="paymentTypeSelect"><?php echo t('Select');?></span>
                <span id="arrowdownside"></span>
                <span id="arrowupside"></span>
              </div>
              <ul id="sel-option">
                <li class="current"> <a href="#creditCardTab"><?php echo t('Credit card');?></a></li>
                <li> <a href="#debitCardTab"><?php echo t('Debit card');?></a></li>
                <li><a href="#c"><?php echo t('Net Banking');?></a></li>
                <li> <a href="#d"><?php echo t('COD');?></a></li>
                <li> <a href="#s"><?php echo t('Store Credit');?></a></li>
              </ul>
            </div>
            <div id="creditCardTab" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false" style="display: block;">
              <div class="container creditCard js_creditCardEntry">
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel"><input type="radio" id="useSavedCard" name="paymentOption" value="PAYOPT_CC_NEW" checked="checked"><span class="radioOptionText"><?php echo t('Credit Card');?></span></label>
                </div>
                <input type="hidden" name="useSavedCard" value="N">
                <div class="entry cardType" style="display:none;">
                  <label for="cardType"><span class="required">*</span>
                  <?php echo t('Card Type');?></label>
                  <div class="entryField customselect">
                    <select id="js_cardType" name="cardType" class="cardType">
                      <option value=""><?php echo t('Select One');?></option>
                      <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccTypes -->
                      <!-- Begin Template component://osafe/webapp/osafe/common/ccTypes.ftl -->
                      <option value="Visa"><?php echo t('Visa');?></option>
                      <option value="MasterCard"><?php echo t('Master Card');?></option>
                      <option value="AmericanExpress"><?php echo t('American Express');?></option>
                      <option value="DinersClub"><?php echo t('Diners Club');?></option>
                      <!-- End Template component://osafe/webapp/osafe/common/ccTypes.ftl -->
                      <!-- End Screen component://osafe/widget/CommonScreens.xml#ccTypes -->
                    </select>
                  </div>
                </div>
                <div class="entry nameOnCard">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Name on card');?></label>
                  <div class="entryField">
                    <input type="text" class="ccname" maxlength="30" id="ccname" name="ccname" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry cardNumber">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Card Number:');?></label>
                  <div class="entryField">
                    <input type="text" class="cardNumber" maxlength="30" id="js_cardNumber_mask" name="cardNumber_mask" value="" autocomplete="off" onkeyup="formatCreditCard(this,event)" onblur="detectCardType(this.value);">
                    <span class="guest-pic" style="display:block;">
                    <img id="visaId" src="<?php echo current_theme_path() ?>/images/visa.png" style="display:none" ;="">
                    <img id="amexId" src="<?php echo current_theme_path() ?>/images/amex.png" style="display:none" ;="">
                    <img id="masterId" src="<?php echo current_theme_path() ?>/images/mastercard.png" style="display:none" ;="">
                    <img id="dinersId" src="<?php echo current_theme_path() ?>/images/diners.png" style="display:none" ;="">
                    </span>
                    <input type="hidden" class="cardNumber" maxlength="30" id="js_cardNumber" name="cardNumber" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry expMonth">
                  <label for="expMonth"><span class="required">*</span>
                  <?php echo t('expiration date:');?></label>
                  <div class="entryField">
                    <div class="cardmonthdiv">
                      <div class="customselect cardexpmonth">
                        <select id="js_expMonth" name="expMonth" class="expMonth">
                          <option value=""><?php echo t('Month');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                        </select>
                      </div>
                    </div>
                    <div class="cardyeardiv">
                      <div class="customselect cardexpyear">
                        <select id="js_expYear" name="expYear" class="expYear">
                          <option value=""><?php echo t('Year');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="entry" id="js_verificationNo1">
                  <label for="verificationNo"><span class="required">*</span>
                  <?php echo t('VERIFICATION:');?></label>
                  <div class="entryField">
                    <input type="password" class="cardNumber card-valid" maxlength="4" id="js_verificationNo" name="verificationNo" value="">
                    <a class="cvvicon">
                      <img src="<?php echo current_theme_path() ?>/images/cvvicon.png" alt="cvv" onclick="creditCVVClick()">
                      <span id="">
                        <span class="arrow_box">
                          <p><?php echo t('The CVV number is the last 3 digits printed on the signature panel on the back of the Card.') ?></p>
                          <img src="<?php echo current_theme_path() ?>/images/cvv.jpg">
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <span id="creditCvv">
                  <p><?php echo t('The CVV number is the last 3 digits printed on the signature panel on the back of the Card.') ?></p>
                  <img src="<?php echo current_theme_path() ?>/images/cvv.jpg">
                </span>
                <div class="entry content">
                  <label for="content">&nbsp;</label>
                  <span>
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- Begin Section Widget  -->
                    <div id="checkoutCcVerify"></div>
                    <!-- End Section Widget  -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                  </span>
                </div>
              </div>
            </div>
            <div id="debitCardTab" aria-labelledby="ui-id-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_CC_NEW">
              <div class="container paymentOption js_codOptions">
                <!-- Netbanking added by veeraprasad end -->
                <!-- Debit Card Payment added by veeraprasad end -->
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel">
                  <input type="radio" id="debitcardPayment" name="paymentOption" value="PAYOPT_NETBANKING" checked="checked">
                  <span class="codtext"><?php echo t('Debit Card');?></span>
                  </label>
                </div>
                <div class="entry debitbanking" style="display:none;">
                  <label for="debitbanking"><span class="required">*</span>
                  <?php echo t('Card Type:');?></label>
                  <div class="entryField customselect">
                    <select id="js_debitbanking" name="debitbanking" class="savedCard">
                      <option value=""><?php echo t('Select One');?></option>
                      <option value="VISA">Visa Cards</option>
                      <option value="MAST">MasterCard</option>
                      <option value="SMAE">SBI Maestro</option>
                      <option value="MAES">Other Maestro</option>
                    </select>
                  </div>
                </div>
                <div class="entry nameOnCard">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Name on card');?></label>
                  <div class="entryField">
                    <input type="text" class="ccname" maxlength="30" id="dccname" name="ccname" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry cardNumber">
                  <label for="cardNumber"><span class="required">*</span>
                  <?php echo t('Card Number:');?></label>
                  <div class="entryField">
                    <input type="text" class="cardNumber" maxlength="30" id="js_dcardNumber_mask" name="dcardNumber_mask" value="" autocomplete="off" onkeyup="formatCreditCard(this,event)" onblur="debitDetectCardType(this.value);">
                    <span class="guest-pic" style="display:block;">
                    <img id="dvisaId" src="<?php echo current_theme_path() ?>/images/visa.png" style="display:none" ;="">
                    <img id="damexId" src="<?php echo current_theme_path() ?>/images/amex.png" style="display:none" ;="">
                    <img id="dmasterId" src="<?php echo current_theme_path() ?>/images/mastercard.png" style="display:none" ;="">
                    <img id="dmaestroId" src="<?php echo current_theme_path() ?>/images/maestro.png" style="display:none" ;="">
                    </span>
                    <input type="hidden" class="cardNumber" maxlength="30" id="js_dcardNumber" name="dcardNumber" value="" autocomplete="off">
                  </div>
                </div>
                <div class="entry expMonth">
                  <label for="expMonth"><span class="required">*</span>
                  <?php echo t('expiration date:');?></label>
                  <div class="entryField">
                    <div class="cardmonthdiv">
                      <div class="customselect cardexpmonth">
                        <select id="js_dexpMonth" name="dexpMonth" class="expMonth">
                          <option value=""><?php echo t('Month');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">Jul</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccMonths.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccMonths -->
                        </select>
                      </div>
                    </div>
                    <div class="cardyeardiv">
                      <div class="customselect cardexpyear">
                        <select id="js_dexpYear" name="dexpYear" class="expYear">
                          <option value=""><?php echo t('Year');?></option>
                          <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                          <!-- Begin Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <option value="2016">2016</option>
                          <option value="2017">2017</option>
                          <option value="2018">2018</option>
                          <option value="2019">2019</option>
                          <option value="2020">2020</option>
                          <option value="2021">2021</option>
                          <option value="2022">2022</option>
                          <option value="2023">2023</option>
                          <option value="2024">2024</option>
                          <option value="2025">2025</option>
                          <option value="2026">2026</option>
                          <!-- End Template component://osafe/webapp/osafe/common/ccYears.ftl -->
                          <!-- End Screen component://osafe/widget/CommonScreens.xml#ccYears -->
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="entry" id="js_dverificationNo1">
                  <label for="verificationNo"><span class="required">*</span>
                  <?php echo t('Verification:');?></label>
                  <div class="entryField">
                    <input type="password" class="cardNumber card-valid" maxlength="4" id="js_dverificationNo" name="dverificationNo" value="">
                    <a class="cvvicon">
                      <img src="<?php echo current_theme_path() ?>/images/cvvicon.png" alt="cvv" onclick="debitCVVClick()">
                      <span id="">
                        <span class="arrow_box">
                          <p>The CVV number is the last 3 digits printed on the signature panel on the back of the Card.<img src="<?php echo current_theme_path() ?>/images/cvv.jpg"></p>
                        </span>
                      </span>
                    </a>
                  </div>
                </div>
                <span id="debitCvv">
                  <p>The CVV number is the last 3 digits printed on the signature panel on the back of the Card.<img src="<?php echo current_theme_path() ?>/images/cvv.jpg"></p>
                </span>
                <div class="entry content">
                  <label for="content">&nbsp;</label>
                  <span>
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- Begin Section Widget  -->
                    <div id="checkoutCcVerify"></div>
                    <!-- End Section Widget  -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
                    <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#CHECKOUT_CC_VERIFY -->
                  </span>
                </div>
                <!-- Debit Card Payment added by veeraprasad end -->
              </div>
            </div>
            <div id="c" aria-labelledby="ui-id-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_CC_NEW">
              <div class="container paymentOption js_codOptions">
                <!-- Netbanking added by veeraprasad start -->
                <div class="entry" style="display:none;">
                  <label class="radioOptionLabel">
                  <input type="radio" id="netbankingPayment" name="paymentOption" value="PAYOPT_NETBANKING" onclick="netBanking();" checked="checked">
                  <span class="codtext">NET BANKING</span>
                  </label>
                </div>
                <div id="netbanking" class="entry selectbank">
                  <lable for="js_savedCard"><?php echo t('Select Bank :');?></lable>
                  <div class="customselect">
                    <select id="js_netbanking" name="netbanking" class="savedCard">
                      <option value=""><?php echo t('Select One');?></option>
                      <option value="AXIB">AXIS Bank NetBanking</option>
                      <option value="IDBB">Industrial Development Bank of India</option>
                      <option value="INDB">Indian Bank</option>
                      <option value="INIB">IndusInd Bank</option>
                      <option value="INOB">Indian Overseas Bank</option>
                      <option value="JAKB">Jammu and Kashmir Bank</option>
                      <option value="KRKB">Karnataka Bank</option>
                      <option value="KRVB">Karur Vysya - Retail Netbanking</option>
                      <option value="KRVBC">Karur Vysya - Corporate Netbanking</option>
                      <option value="SBBJB">State Bank of Bikaner and Jaipur</option>
                      <option value="SBHB">State Bank of Hyderabad</option>
                      <option value="BOIB">Bank of India</option>
                      <option value="SBIB">State Bank of India</option>
                      <option value="SBMB">State Bank of Mysore</option>
                      <option value="SBTB">State Bank of Travancore</option>
                      <option value="SOIB">South Indian Bank</option>
                      <option value="UBIB">Union Bank - Retail Netbanking</option>
                      <option value="UBIBC">Union Bank - Corporate Netbanking</option>
                      <option value="UNIB">United Bank Of India</option>
                      <option value="VJYB">Vijaya Bank</option>
                      <option value="YESB">Yes Bank</option>
                      <option value="CUBB">CityUnion</option>
                      <option value="BOMB">Bank of Maharashtra</option>
                      <option value="CABB">Canara Bank</option>
                      <option value="SBPB">State Bank of Patiala</option>
                      <option value="DSHB">Deutsche bank Netbanking</option>
                      <option value="162B">kotak bank Netbanking</option>
                      <option value="DLSB">Dhanlaxmi Netbanking</option>
                      <option value="INGB">ING Vysya Netbanking</option>
                      <option value="CSBN">Catholic Syrian Bank</option>
                      <option value="PNBB">Punjab Nation Bank - Retail Netbanking</option>
                      <option value="CPNB">Punjab Nation Bank - Corporate Netbanking</option>
                      <option value="CBIB">Central Bank Of India</option>
                      <option value="CRPB">Corporation Bank</option>
                      <option value="DCBB">Development Credit Bank</option>
                      <option value="FEDB">Federal Bank</option>
                      <option value="HDFB">HDFC Bank</option>
                      <option value="ICIB">ICICI Netbanking</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="d" aria-labelledby="ui-id-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="false" aria-hidden="true" style="display: none;">
              <div class="codPayment">
              </div>
              <input type="hidden" name="selectedPaymentOption" value="PAYOPT_COD">
              <div class="container paymentOption js_codOptions">
                <div class="cash-pay"><?php echo t('Amount payable at the time of delivery') ?>
                  <span id="totalWithOutCODFee" style="display: block;">
                  $ <?php echo format_money($cart['orderGrandTotal']) ?>
                  </span>
                  <span id="totalWithCODFee" style="display:none;">
                  <span>$ 725</span>
                  </span>
                </div>
                <div id="checkoutCODFeeCnt" style="display:none;" class="cod-help">Includes Rs. 49 as convenience charge for Cash on Delivery</div>
                <!-- <div id="codOtpHlpTxt" class="cod-help">In order to confirm your order,please click on "Send OTP" button and enter  One Time Password here</div> -->
                <div class="entry codbar cod_radiobutton">
                  <label class="radioOptionLabel">
                    <input style="display:none;" type="radio" id="codPayment" name="paymentOption" value="PAYOPT_COD" onclick="javascript:codAlert(cartSubTotal.value,this.value,this.checked,codLimit.value);" checked="checked">
                    <!-- <span class="codtext" data-payment-method="CashOnDelivery" title="Cash On Delivery is not permitted for orders above Rs. 10000/- (Rupees Ten Thousand). Please select from the other available payment methods to complete your transaction." disabled="disabled"> COD (Cash on Delivery)</span> -->
                  </label>
                  <input type="hidden" id="isOtpValid" value="">
                  <!-- <input class="otp-validate" id="otpSendOTP" type="button" value="Send OTP"> -->
                  <div id="otpSection" style="display:none;" class="otp-number">
                    <label for"otptxt"="">OTP: <input type="text" class="otp-col" id="otptxt" name="otptxt" autocomplete="off"></label>
                    <input class="otp-validate" id="otpValidate" type="button" value="Validate OTP">
                  </div>
                  <div id="responseMessage" class="otp-msg"></div>
                  <!-- Added by Krishnamohan - End -->
                </div>
              </div>
            </div>
            <div id="s" aria-labelledby="ui-id-5" style="display: none;">
              <div class="displayBox">
                <h3><?php echo t('Store Credit Redemption');?></h3>
                <ul class="displayActionList">
                  <li>
                    <div>
                      <!--<?php echo $storeCredit['partyAppliedStoreCreditTotal']; ?>-->
                      <label><?php echo t('You have a');?> <?php echo $storeCredit['partyStoreCreditBalance']; ?> <?php echo t('Store Credit available');?></label>
                    </div>
                  </li>
                  <li>
                    <div>
                      <label><?php echo t('Use Store Credit:');?></label>
                      <input id="js_useStoreCredit" name="useStoreCredit" value="Y" type="checkbox">
                    </div>
                    <div>
                      <label id="js_storeCreditAmountRedeem" style="display:none;"><?php echo t('Amount To Be Redeemed:');?></label>
                      <input id="js_storeCreditAmount" name="storeCreditAmount" value="" autocomplete="off" type="text" style="display:none;">
                    </div>
                  </li>
                </ul>
                <input id="storCreditRedeem" type="button" value="<?php echo t('Redeem');?>" style="display:none;"/>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <script>
          var codLimit=99999;
          var grandTotal=675.95;
           jQuery(function() {
               jQuery(window).resize(function() {
                   if(jQuery(window).width() >= 640){
               jQuery('#payment_tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
               jQuery("#payment_tabs").tabs().bind("tabsselect",function(event,ui){
               jQuery(".paymenterrspan").css("display","none");
               if (ui.index == 0) {
                    jQuery("#js_useSavedCard").attr("checked", true);
                    jQuery("#useSavedCard").attr("checked", true);
                    jQuery('#pg').val("CC");
                      jQuery('#Bankcode').val("CC");
                      jQuery("#dccname").val("");
                      jQuery("#js_dcardNumber_mask").val("");
                      jQuery("#js_dexpMonth").val("");
                      jQuery("#js_dexpYear").val("");
                      jQuery("#js_dverificationNo").val("");
                      jQuery(".error_msg_display").css("display","none");
                      }
                  if(ui.index == 1) {
                    jQuery("#debitcardPayment").attr("checked", true);
                      jQuery("#ccname").val("");
                      jQuery("#js_cardNumber_mask").val("");
                      jQuery("#js_expMonth").val("");
                      jQuery("#js_expYear").val("");
                      jQuery("#js_verificationNo").val("");
                      jQuery(".error_msg_display").css("display","none");
                  }
                  if(ui.index ==2) {
                    jQuery("#netbankingPayment").attr("checked", true);
                     }
                  if(ui.index == 3) {
                    jQuery("#codPayment").attr("checked", true);
                    var isotpvalid=jQuery("#isOtpValid").val();
                    jQuery("#totalWithOutCODFee").html(jQuery("#grandTotal").text());
                      if(isotpvalid != "undefined" && isotpvalid == "valid")
                      {
                        if(parseInt(grandTotal)<parseInt(codLimit)){
                        enableCod(true);
                        }
                      }
                    }
                    else{
                    enableCod(false);
                    }
                  });
                }else{
                      jQuery('#paymentTypeSelect').text("Credit card");
                      jQuery("#js_useSavedCard").attr("checked", true);
                    jQuery("#useSavedCard").attr("checked", true);
                    jQuery('#pg').val("CC");
                      jQuery('#Bankcode').val("CC");
                      jQuery("#creditCardTab").css("display","block");
                      jQuery("#debitCardTab,#c,#d,#arrowupside").css("display","none");
                }
          
                }).resize();
          
              jQuery(".cardNumber").live('keypress', function (e) {
                  if(e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)){
                  return false;
                  }
                });
          
          
                 jQuery('.paymentTypeSelectContainer').click(function(){
                        if(jQuery('#sel-option').is(":visible")){
                           jQuery('#sel-option').hide();
                           jQuery("#arrowupside").css("display","none");
                           jQuery("#arrowdownside").css("display","block");
                        }else{
                          jQuery('#sel-option').show();
                          jQuery("#arrowdownside").css("display","none");
                          jQuery("#arrowupside").css("display","block");
                        }
                    });
                    jQuery('#sel-option a').click(function(e){
                     var paymentType= jQuery(this).text();
                      jQuery("#arrowupside").css("display","none");
                    jQuery("#arrowdownside").css("display","block");
                         jQuery('#paymentTypeSelect').text(paymentType);
                        jQuery('#sel-option').hide();
          
                    if (paymentType == "Credit card") {
                    jQuery("#js_useSavedCard").attr("checked", true);
                    jQuery("#useSavedCard").attr("checked", true);
                    jQuery('#pg').val("CC");
                      jQuery('#Bankcode').val("CC");
                      jQuery("#creditCardTab").css("display","block");
                      jQuery("#debitCardTab,#c,#d").css("display","none");
                      }
                  if(paymentType == "Debit card") {
                    jQuery("#debitcardPayment").attr("checked", true);
                    jQuery("#debitCardTab").css("display","block");
                      jQuery("#creditCardTab,#c,#d").css("display","none");
                  }
                  if(paymentType == "Net Banking") {
                    jQuery("#netbankingPayment").attr("checked", true);
                    jQuery("#c").css("display","block");
                      jQuery("#debitCardTab,#creditCardTab,#d").css("display","none");
                     }
                  if(paymentType == "COD") {
                    jQuery("#codPayment").attr("checked", true);
                    jQuery("#d").css("display","block");
                      jQuery("#debitCardTab,#c,#creditCardTab").css("display","none");
                      var isotpvalid=jQuery("#isOtpValid").val();
                      jQuery("#totalWithOutCODFee").html(jQuery("#grandTotal").text());
                      if(isotpvalid != "undefined" && isotpvalid == "valid")
                      {
                        if(parseInt(grandTotal)<parseInt(codLimit)){
                        enableCod(true);
                        }
                      }
          
                    }
                    else{
                    enableCod(false);
                    }
                  jQuery("#sel-option li.current").removeClass('current');
                     jQuery(this).parent().addClass('current');
                        e.preventDefault();
                    })
          
          
          
          
             });
          
          
             function enableCod(status)
             {
                  if(!status)
                {
                  jQuery("#checkoutCODFee").css('display','none');
                  jQuery("#checkoutCODFeeCnt").css('display','none');
                  jQuery("#grandTotalWithCODFee").css('display','none');
                  jQuery("#totalWithCODFee").css('display','none');
                  jQuery("#totalWithOutCODFee").html(jQuery("#grandTotal").text());
                  jQuery("#totalWithOutCODFee").css('display','block');
                  jQuery("#grandTotal").css('display','block');
                }
                else{
                  jQuery("#checkoutCODFee").css('display','block');
                  jQuery("#checkoutCODFeeCnt").css('display','block');
                  jQuery("#totalWithCODFee").html(jQuery("#grandTotalWithCODFee").text());
                  jQuery("#grandTotalWithCODFee").css('display','block');
                  jQuery("#totalWithCODFee").css('display','inline-block');
                  jQuery("#totalWithOutCODFee").css('display','none');
                  jQuery("#grandTotal").css('display','none');
                }
             }
              
        </script>
        <!-- Net Banking & Debit Card Payment script added by veeraprasad start-->
        <script>
          jQuery("#creditCardTab").click(function(){
            jQuery('#pg').val("CC");
            jQuery('#Bankcode').val("CC");
           });
          
          jQuery('#js_netbanking').on('change', function() {
              var bankcode=this.value;
              if(bankcode!=""){
              jQuery('#pg').val("NB");
              jQuery('#Bankcode').val(bankcode);
            }
          });
          
          jQuery('#js_debitbanking').on('change', function() {
              var bankcode=this.value;
              if(bankcode!=""){
              jQuery('#pg').val("DC");
              jQuery('#Bankcode').val(bankcode);
            }
          });
          
          
            /* Addeed by krishnamohan J - Start*/
            jQuery('#otpSendOTP').on('click', function() {
              jQuery("#otptxt").val("");
            jQuery.ajax({
               url: '/sendOTP',
               success: function(data) {
                console.log(data);
                jQuery("#otpSection").show();
                jQuery('#otpSendOTP').hide();
                jQuery("#responseMessage").html("OTP Sent to your registered mobile number");
               },
               error: function(data) {
                console.log(data);
                jQuery('#responseMessage').html('<p>An error has occurred</p>');
               },
               type: 'GET'
            });
            });
          
          jQuery('#otpValidate').on('click', function() {
            if(jQuery('#otptxt').val() == null || jQuery('#otptxt').val() == ''){
              jQuery("#responseMessage").html('Please provide OTP to continue');
              return;
            }else{
              jQuery.ajax({
                 url: '/validateOTP',
                 data : {
                    otp : jQuery('#otptxt').val()
                 },
                 success: function(data) {
                  jQuery("#responseMessage").html(data.statusMessage);
                var codLimit=99999;
                var grandTotal=675.95;
                  if(data.statusMessage != ""){
                    jQuery('#otptxt').val("")
                    jQuery("#isOtpValid").val("invalid");
                    if(data.statusMessage === 'OTP Expired'){
                      jQuery("#responseMessage").html('Your OTP expired, Please use the other payment method to proceed your transaction');
                      jQuery("#otpSection").hide();
                    }else{
                      jQuery("#otpSection").show();
                    }
          
                  }else{
                    jQuery("#responseMessage").html('Your OTP validated, You can place the order now');
                    jQuery(".paymenterrspan").css('display','none');
                    jQuery("#isOtpValid").val("valid");
                    jQuery("#otpSection").hide();
                  jQuery("#codOtpHlpTxt").css('display','none');
                  if(parseInt(grandTotal)<parseInt(codLimit)){
                      enableCod(true);
                    }
                  else{
                  enableCod(false);
                  }
          
                  }
          
          
          
                 },
                 error: function(data) {
                  jQuery('#info').html('<p>An error has occurred</p>');
                 },
                 type: 'GET'
              });
            }
            });
          
            jQuery("#useSavedCard, #ccAvenuePayment, #js_netbanking, #netbankingPayment, #debitcardPayment, #netbankingPayment").on('change', function() {
              jQuery('#otptxt').val("");
              jQuery("#responseMessage").html("");
              jQuery("#otpSection").hide();
            });
            /* Addeed by krishnamohan J - End*/
          
          
              function debitCVVClick()
              {
                if(jQuery(window).width() <= 1030){
                jQuery('#debitCvv').slideToggle('fast');
                     return false;
                }
              }
          
              function creditCVVClick()
              {
                if(jQuery(window).width() <= 1030){
                  jQuery('#creditCvv').slideToggle('fast');
                     return false;
                }
              }
          
          
        </script>
        <!-- Net Banking & Debit Card Payment script added by veeraprasad End-->
        <!-- End Template component://osafe/webapp/osafe/common/eCommerceOrderPaymentMethods.ftl -->
        <!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#multiPageOrderPayment -->
        <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryPaymentOptions -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryContinueButton -->
        <!-- Begin Template component://osafe/webapp/osafe/common/cart/continueCartButton.ftl -->
        <div class="action continueButton orderSummaryContinueButton">
          <input type="button" id="js_submitOrderBtn" name="submitOrderBtn" value="<?php echo t('Place Order');?>" class="standardBtn submitOrder">
        </div>
        <input type="hidden" name="fbDoneAction" value="">
        <script>
          function preventBack(){window.history.forward();}
          setTimeout("preventBack()", 0);
        </script>
        <!-- End Template component://osafe/webapp/osafe/common/cart/continueCartButton.ftl -->
        <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryContinueButton -->
      </div>
      <div class="OrderSummary group group3">
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryCartInfo -->
        <!-- Begin Template component://osafe/webapp/osafe/common/order/orderSummaryCartInfo.ftl -->
        <div class="cont-right_multi shipping-cartdetails">
          <div class="checkout-cart-con">
            <div id="mycartSummaryfill">
              <div class="summaryhead">
                <div class="checkout-cart-head ch-cart-items">
                  <strong><?php echo t('review your order');?></strong>
                </div>
                <div class="shipping-edit-cart"><a href="<?php echo url('cart') ?>"><?php echo t('Edit Cart');?></a></div>
              </div>
              <div class="shipping-cart">
                <?php foreach ($cart['productList'] as $cart_product): ?>
                <?php
                  $nid = get_nid_from_variant_product_id($cart_product['productID']);
                  $node = node_load($nid);
                  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
                  $product_variant = $system_data->product_variants->{$cart_product['productID']};
                  ?>
                <div class="viewcartdtls" style="clear:both; border-bottom:1px solid #e1e1e1; ">
                  <div class="productimage"> <img src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');"></div>
                  <div class="shippingCart-image">
                    <div class="checkout-cart-head ch-cart-items">
                      <span class="shp-cart-info">
                        <span class="shp-cart-info"><?php echo $cart_product['productName'] ?></span>
                        <div class="productFeatureSize">
                          <?php $selected_features = get_selected_features($product_variant); ?>
                          <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
                          <?php if (strtolower($selected_feature_name) == 'color'): ?>
                          <div class="color-swatch">
                            <div class="color-text"><?php echo t('COLOR:');?></div>
                            <div class="color-code" style="background-color:<?php echo $selected_feature_value ?>"></div>
                          </div>
                          <?php elseif (strtolower($selected_feature_name) == 'size'): ?>
                          <div class="size-swatch">
                            <div class="size-text"><?php echo t('SIZE:');?></div>
                            <div class="size-code"><?php echo $selected_feature_value ?></div>
                          </div>
                          <?php endif; ?>
                          <?php endforeach; ?>
                        </div>
                      </span>
                      <div class="product-qty">
                        <span class="qtyspan"><?php echo (int)$cart_product['quantity'] ?>
                        <a href="javascript:submitCheckoutForm(document.checkoutInfoForm, 'UC', '');" title="Update"><span style="margin-left:17px;"><img class="updateicon" width="10" height="10" style="margin-top:5px;" src="<?php echo current_theme_path() ?>/images/cartUpdateOver.png"></span></a>                          
                        </span>
                      </div>
                    </div>
                    <div> <input type="hidden" name="productName0" id="js_productName_0" value="<?php echo $cart_product['productName'] ?>"></div>
                    <div class="payment-pricedtls">
                      <?php if (FALSE AND $cart_product['productPrice'] != $cart_product['offerPrice']): ?>
                      <p class="oldprice">
                        <span id="cart_strikedcost" class="order-price price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
                      </p>
                      <?php endif; ?>
                      <span id="cart_subTotal" class="order-price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
                    </div>
                    <?php if(!empty($cart_product['promoName'])) { ?>
                    <strong>Promo Applied: </strong>
                    <span ><?php echo $cart_product['promoName'] ?></span>
                    <?php } ?>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <div class="shp-crt-info">
            <?php $promoTotalAmount = getTotalPromoAmount($cartItems) ;?>
            <strong><?php echo t('Sub Total:');?> </strong>
            <span>$ <?php echo format_money($cart['shoppingCartItemTotal']) ?></span> 
            <strong><?php echo t('Tax collected:');?></strong>
            <span>$ <?php echo format_money($cart['salesTax']) ?></span>
            <strong><?php echo t('Shipping Charges:');?> </strong>
            <span>$ <?php echo format_money($cart['orderShippingTotal']) ?></span>
            <?php if(!empty($promoTotalAmount)) { ?>
            <strong><?php echo t('Promo Discount:');?> </strong>
            <span>-$ <?php echo format_money($promoTotalAmount) ?></span>
            <?php } ?>
            <?php if(!empty($cart['couponCode'])) { ?>
            <strong><?php echo t('Coupon Discount:');?> </strong>
            <span>$ <?php echo format_money($cart['couponValue']) ?></span>
            <?php } ?>
            <?php if(isset($cart['LoyaltyAmount'])) { ?>
            <strong>Loyalty Amount:</strong>
            <span>-$ <?php echo format_money($cart['LoyaltyAmount']) ?></span>
            <?php } ?> 
            <?php if(!empty($storeCredit['partyAppliedStoreCreditTotal'])) { ?>
            <strong><?php echo t('Store Credit Applied:');?> </strong>
            <span>-$ <?php echo format_money($cart['partyAppliedStoreCreditTotal']) ?></span>
            <?php } ?> 
          </div>
          <div class="shp-crt-info mt10">
            <div class="ch-pay-box"><?php echo t('Payable Amount');?></div>
            <div class="ch-pay-price" id="grandTotal" style="display: block;">
              <span>$ <?php echo format_money($cart['orderGrandTotal']) - $storeCredit['partyAppliedStoreCreditTotal']?></span>
            </div>
          </div>
        </div>
        <!--<span id="cart_subTotal" class="order-price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
          </div>
          <?php if(!empty($cart_product['promoName'])) { ?>
          <strong>Promo Applied: </strong>
          <span ><?php echo $cart_product['promoName'] ?></span>
          <?php } ?>
          </div>
          </div>
          </div>
          </div>
          </div>
          <div class="shp-crt-info">
          <?php $promoTotalAmount = getTotalPromoAmount($cartItems) ;?>
          <strong>Sub Total: </strong>
          <span>$ <?php echo format_money($cart['cartSubTotal'] + $promoTotalAmount) ?></span>
          <span>$ <?php echo format_money($cart['cartSubTotal']) ?></span>
          <?php if(!empty($promoTotalAmount)) { ?>
          <strong>Promo Discount: </strong>
          <span>$ <?php echo format_money($promoTotalAmount) ?></span>
          <?php } ?>
          <?php if(isset($cart['LoyaltyAmount'])) { ?>
          <strong>Loyalty Amount:</strong>
          <span>$ <?php echo format_money($cart['LoyaltyAmount']) ?></span>
          <?php } ?>
          <strong>Tax collected:</strong>
          <span>$ <?php echo format_money($cart['salesTax']) ?></span>
          
          <strong>Shipping Charges: </strong>
          <span>$ <?php echo format_money($cart['orderShippingTotal']) ?></span>-->
      </div>
    </form>
    <!-- End Template component://osafe/webapp/osafe/common/order/orderSummaryCartInfo.ftl -->
    <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryCartInfo -->
    <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryShippingAddress -->
    <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#cartShippingAddress -->
    <!-- Begin Template component://osafe/webapp/osafe/common/cart/cartShippingAddress.ftl -->
    <style>
      .shippingbox{   
      border: 1px solid #E2E2E2;     
      border-radius: 2px; 
      width:30%; 
      margin-top:10px;
      margin-bottom:20px;
      float:right;
      clear: right;
      }
      .shipping-head {
      background: none repeat scroll 0 0 #D8D6D7;
      color: #2E2E2E;
      font-size: 15px;
      font-weight: bold;
      padding: 10px 8px;
      }
      .shipping-address{
      padding: 10px 8px; 
      color: #2E2E2E;
      border: 2px solid #E2E2E2;
      }
    </style>
    <div class="shippingbox">
      <div class="displayBox">
        <div class="shipping-head"><?php echo t('Shipping Information');?></div>
        <div class="shipping-address">
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
                    <span style="font-size:1.2em;"><b><?php echo ($_SESSION['drubiz']['checkout_address']['SHIPPING_FIRST_NAME'] . ' ' . $_SESSION['drubiz']['checkout_address']['SHIPPING_LAST_NAME']) ?></b></span>
                  </div>
                </li>
                <li class="address-nname ">
                  <h4><?php echo t('Shipping');?></h4>
                </li>
                <li>
                  <div>
                    <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $_SESSION['drubiz']['checkout_address']['SHIPPING_ADDRESS1'] ?></span>
                  </div>
                </li>
                <li>
                  <div>
                    <span style="font-size:1.1em; word-wrap: break-word;"><?php echo $_SESSION['drubiz']['checkout_address']['SHIPPING_CITY'] ?>,</span>
                  </div>
                </li>
                <li>
                  <div>
                    <span style="font-size:1.1em;">
                    <?php echo $_SESSION['drubiz']['checkout_address']['SHIPPING_STATE'] ?>
                    ,
                    <?php echo $_SESSION['drubiz']['checkout_address']['SHIPPING_POSTAL_CODE'] ?>
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
                    <?php echo t('Phone :');?> <?php echo $_SESSION['drubiz']['checkout_address']['PHONE_MOBILE_CONTACT'] ?>
                    </span>
                  </div>
                </li>
              </div>
              <li>
                <div class="hide">
                  <span class="hide"><a href="<?php echo url('checkout') ?>"><?php echo t('Change Address');?></a></span>
                </div>
              </li>
            </ul>
          </div>
          <!-- End Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->
          <!-- End Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->
        </div>
      </div>
    </div>
  </div>
  <!-- End Template component://osafe/webapp/osafe/common/cart/cartShippingAddress.ftl -->
  <!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#cartShippingAddress -->
  <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryShippingAddress -->
  <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryPromoCode -->
  <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceEnterPromoCode -->
  <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceEnterPromoCode.ftl -->
  <div class="container promoCode orderSummaryPromoCode" style="display: none;">
    <div class="displayBox">
      <h3 style="clear:both;"><?php echo t('Promotional Code');?></h3>
      <ul class="displayActionList container promoCode orderSummaryPromoCode">
        <li>
          <div>
            <label class="promoenterlabel"><?php echo t('If you have a promotional code, please enter it here:');?></label><br>
            <input type="text" id="js_manualOfferCode" name="manualOfferCode" value="" maxlength="20" onkeypress="javascript:setCheckoutFormAction(document.checkoutInfoForm, 'APC', '');">
            <a class="standardBtn action" onclick=" return addManualPromoCode();"><span><?php echo t('Apply');?></span></a>
          </div>
        </li>
        <ul class="fieldErrorMessage" id="promotionError" style="display:none">
          <li><?php echo t('Please enter your Offer Code.');?></li>
        </ul>
      </ul>
      <!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceEnteredPromoCode -->
      <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceEnteredPromoCode.ftl -->
      <div class="boxList promoCodeList">
        <!-- End Template component://osafe/webapp/osafe/common/eCommerceEnteredPromoCode.ftl -->
        <!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceEnteredPromoCode -->
      </div>
    </div>
    <!-- End Template component://osafe/webapp/osafe/common/eCommerceEnterPromoCode.ftl -->
    <!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceEnterPromoCode -->
    <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryPromoCode -->
  </div>
  <!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
  <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
  <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#orderSummaryDivSequence -->
  <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ORDER_SUMMARY -->
  <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
  <!-- Begin Section Widget  -->
  <div id="pesOrderSummary" class="pesSpot"></div>
  <!-- End Section Widget  -->
  <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
  <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ORDER_SUMMARY -->
  <!-- Begin Screen component://osafe/widget/DialogScreens.xml#storePickupDialog -->
  <!-- Begin Template component://osafe/webapp/osafe/templates/commonDialog.ftl -->
  <div id="storePickup_dialog" class="dialogOverlay"></div>
  <div id="storePickup_displayDialog" style="display:none" class="">
    <input type="hidden" name="storePickup_dialogBoxTitle" id="storePickup_dialogBoxTitle" value="">
    <div id="eCommerceStoreLocatorContainer">
      <!-- Begin Screen component://osafe/widget/EcommerceScreens.xml#pageTitle -->
      <!-- Begin Template component://osafe/webapp/osafe/common/pageTitle.ftl -->
      <div class="container promoCode orderSummaryPromoCode" id="eCommerceNavBar" style="display:none;">
        <ul id="eCommerceNavBarMenu">
          <!-- <div id="magazine"> <a href="#"><span>Read Magazine</span></a><div> -->
        </ul>
      </div>
      <!-- End Template component://osafe/webapp/osafe/common/pageTitle.ftl -->
      <!-- End Screen component://osafe/widget/EcommerceScreens.xml#pageTitle -->
      <!-- Begin Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
      <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
      <!-- End Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
      <!-- End Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
      <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_STORE_PICKUP -->
      <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
      <!-- Begin Section Widget  -->
      <div id="ptsStorePickup" class="ptsSpot"></div>
      <!-- End Section Widget  -->
      <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
      <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_STORE_PICKUP -->
      <!-- Begin Template component://osafe/webapp/osafe/common/storeLocator/storeLocator.ftl -->
      <div class="header-group">
        <h3><?php echo t('Store Locator');?></h3>
      </div>
      <div class="storelocator-headerinfo">
        <!-- added on 17-06 -->
        <?php echo t('To get that unmatched look, find an Globus outlet closest to you now!');?><br>
        <?php echo t('Our store locator will help you find Globus stores all over the country and provide details about each one.');?><br> 
      </div>
      <!-- ends -->
      <div class="displayBox">
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorDivSequence -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
        <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
        <div class="StoreLocator group group1">
          <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorSearch -->
          <!-- Begin Template component://osafe/webapp/osafe/common/storeLocator/storeLocatorSearch.ftl -->
          <!--<div class="container search storeLocatorSearch">
            <form method="post" class="storePickup_Form" action="/searchStorePickup" id="searchStoreLocator" name="searchStoreLocator">
             
               
                  <input type="hidden" name="notFoundLatitude" id="notFoundLatitude" value=""/>
                  <input type="hidden" name="notFoundLongitude" id="notFoundLongitude" value=""/>
                  <input type="hidden" name="notFoundAddress" id="notFoundAddress" value=""/>
                  <input type="hidden" name="latitude" id="latitude" value=""/>
                  <input type="hidden" name="longitude" id="longitude" value=""/>
               
               <ul class="displayActionList container search storeLocatorSearch">
                <li>
                 <div>
                  
                  <input type="hidden" maxlength="255" name="address" id="address" value=""/>
                  
                  <select  maxlength="255" name="mySelect"  id="mySelect" class="mycalss" style="float:none;" value="">
                <option value="Ahmedabad">Ahmedabad</option>
                        <option value="Aurangabad">Aurangabad</option>
                        <option value="Bilaspur">Bilaspur</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Ghaziabad" >Ghaziabad</option>
                        <option value="Hyderabad" >Hyderabad</option>
                        <option value="Indore" >Indore</option>
                        <option value="Jalgaon" >Jalgaon</option>
                        <option value="Kanpur" >Kanpur</option>
                        <option value="Kolkata" >Kolkata</option>
                        <option value="Lucknow" >Lucknow</option>
                        <option value="Ludhiana" >Ludhiana</option>
                        <option value="Moradabad" >Moradabad</option>
                        <option value="Mumbai" >Mumbai</option>
                        <option value="Nagpur" >Nagpur</option>
                        <option value="Navi Mumbai">Navi Mumbai</option>
                        <option value="Noida" >Noida</option>
                        <option value="pune" >Pune</option>
                        <option value="raipur" >Raipur</option>
                        <option value="rajkot" >Rajkot</option>
                        <option value="thane" >Thane</option>
                        <option value="Vadodara" >Vadodara</option>
                        <option value="varanasi" >Varanasi</option>
                        <option value="vijaywada" >Vijaywada</option>
                        <option value="bangalore" >Bangalore</option>
                    </select>       
                    
                        <label for = "address">Address: </label><input type="text"  name="address" id="address" value=""/>    
                    <input type="button" value="Search"  onclick="getStoreName()"/>
                  
                  
                 </div>
                </li>
               </ul>
            </form>
            </div>
            -->
          <script>
            /*
            function getStoreName(){
            
            jQuery("#mySelect :selected").text() //the text content of the selected option
            jQuery("#mySelect").val() 
            var citySelected = jQuery("#mySelect").val()
            
            jQuery("#address").val(citySelected);
            
             jQuery("#searchStoreLocator").submit();
            }
            */
            
          </script>
          <!-- End Template component://osafe/webapp/osafe/common/storeLocator/storeLocatorSearch.ftl -->
          <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorSearch -->
          <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorItems -->
          <!-- Begin Template component://osafe/webapp/osafe/common/storeLocator/storeLocationsList.ftl -->
          <div class="store-address">
            <div class="container items storeLocatorItems">
              <form method="post" class="storePickup_Form" action="/searchStorePickup" id="searchStoreLocator" name="searchStoreLocator">
                <input type="hidden" name="notFoundLatitude" id="notFoundLatitude" value="">
                <input type="hidden" name="notFoundLongitude" id="notFoundLongitude" value="">
                <input type="hidden" name="notFoundAddress" id="notFoundAddress" value="">
                <input type="hidden" name="latitude" id="latitude" value="">
                <input type="hidden" name="longitude" id="longitude" value="">
                <ul class="displayActionList container items storeLocatorItems">
                  <li class="storeLocatorItemsli">
                    <div>
                      <!--<label>Address, City, State or Zip&#58;</label>-->
                      <!-- <label>Select your City</label> -->
                      <input type="hidden" maxlength="255" name="address" id="address" value="">
                      <label for="address" class="store-heading"><?php echo t('Enter your city:');?> </label><br>
                      <input placeholder="Select your City:" type="text" name="address" id="searchaddress" value="Select your city" readonly="" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                      <select maxlength="255" name="mySelect" id="mySelect" class="mycalss storeoptions" value="" onclick="restoreStoreAddr()">
                        <option value=""><?php echo t('--Select City--');?></option>
                        <option value="Ahmedabad">Ahmedabad</option>
                        <option value="Aurangabad">Aurangabad</option>
                        <option value="Bilaspur">Bilaspur</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Ghaziabad">Ghaziabad</option>
                        <option value="Hyderabad">Hyderabad</option>
                        <option value="Indore">Indore</option>
                        <option value="Jalgaon">Jalgaon</option>
                        <option value="Kanpur">Kanpur</option>
                        <option value="Kolkata">Kolkata</option>
                        <option value="Lucknow">Lucknow</option>
                        <option value="Ludhiana">Ludhiana</option>
                        <option value="Moradabad">Moradabad</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Nagpur">Nagpur</option>
                        <option value="Navi Mumbai">Navi Mumbai</option>
                        <option value="Noida">Noida</option>
                        <option value="Pune">Pune</option>
                        <option value="Raipur">Raipur</option>
                        <option value="Rajkot">Rajkot</option>
                        <option value="Vadodara">Vadodara</option>
                        <option value="Varanasi">Varanasi</option>
                        <option value="Vijaywada">Vijaywada</option>
                      </select>
                    </div>
                  </li>
                </ul>
              </form>
            </div>
            <!--<div class="storedetails-close">
              <img src="/osafe_theme/images/user_content/images/popupclosebtn.png"></button></div>-->
          </div>
          <script>
            jQuery(document).ready(function(){
                jQuery("#mySelect").change(function(){
                    jQuery("#mySelect :selected").text();
                  jQuery("#mySelect").val();
                  var b = jQuery("#mySelect").val();
                  jQuery("#address").val(b);
                  jQuery("#searchStoreLocator").submit()
                });
              });
              
              function restoreStoreAddr(){
               jQuery(".StoreLocatorItems" ).css("display","block");
              }
            
            if(wid>768){
            jQuery("#storeId").css("display","none");
            }
            
            
            function getDetailStore(latitude2, longitude2){ 
                     var lat = latitude2,
                         lng = longitude2,
                         latlng = new google.maps.LatLng(lat, lng),
                         image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png';
            
                     var mapOptions = {
                         center: new google.maps.LatLng(lat, lng),
                         zoom: 16,
                         mapTypeId: google.maps.MapTypeId.ROADMAP,
                         panControl: true,
                         panControlOptions: {
                             position: google.maps.ControlPosition.TOP_RIGHT
                         },
                         zoomControl: true,
                         zoomControlOptions: {
                             style: google.maps.ZoomControlStyle.LARGE,
                             position: google.maps.ControlPosition.TOP_left
                         }
                     },
                     map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions),
                         marker = new google.maps.Marker({
                             position: latlng,
                             map: map,
                             icon: new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png")
                         });
                  
                  var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
                      infoWindow = new google.maps.InfoWindow();
                      directionsService = new google.maps.DirectionsService();
                      var rendererOptions = { suppressBicyclingLayer: true,suppressMarkers: true
                                            };
                      directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                      directionsDisplay.setMap(map);
                      directionsDisplay.setPanel(document.getElementById("routeDirection"));
            
                        var geoLat = "19.075984";
                        var geoLng = "72.877656";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_0 = new google.maps.Marker(GMarkerOptions);             
                            marker_0.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Thane&#41; (11)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Unit No.GF-35,Viviana Mall, Pokharan No.2,Subhash Nagar, Next to Jupiter Hospital</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400610</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 6170 5701</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_0)            
                           
                            google.maps.event.addListener(marker_0, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Thane&#41; (11)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Unit No.GF-35,Viviana Mall, Pokharan No.2,Subhash Nagar, Next to Jupiter Hospital</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400610</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 6170 5701</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_0)
                            });
                          }
                        var geoLat = "22.515358";
                        var geoLng = "88.35004";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_1 = new google.maps.Marker(GMarkerOptions);             
                            marker_1.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">Globus &#40;Kolkata II&#41; (2)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">1st and 2nd Floor, Lake Mall, 104 Rashbhihari Avenue, Lake Market</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Kolkata,</span> ' + 
                                                    '<span class="addressState">IN-WB</span> ' + 
                                                    '<span class="addressZipCode">700029</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">033 23242436</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_1)            
                           
                            google.maps.event.addListener(marker_1, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">Globus &#40;Kolkata II&#41; (2)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">1st and 2nd Floor, Lake Mall, 104 Rashbhihari Avenue, Lake Market</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Kolkata,</span> ' + 
                                                    '<span class="addressState">IN-WB</span> ' + 
                                                    '<span class="addressZipCode">700029</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">033 23242436</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_1)
                            });
                          }
                        var geoLat = "21.1458";
                        var geoLng = "79.088155";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_2 = new google.maps.Marker(GMarkerOptions);             
                            marker_2.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Nagpur II&#41; (6)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Gr.Flr G 52A,52B,53A,Empress Mall, Sir Bezonji Mehta Road, Nr Gandhi Sagar Lake</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Nagpur,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">440018</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">090216 88575</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_2)            
                           
                            google.maps.event.addListener(marker_2, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Nagpur II&#41; (6)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Gr.Flr G 52A,52B,53A,Empress Mall, Sir Bezonji Mehta Road, Nr Gandhi Sagar Lake</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Nagpur,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">440018</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">090216 88575</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_2)
                            });
                          }
                        var geoLat = "22.303895";
                        var geoLng = "70.80216";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_3 = new google.maps.Marker(GMarkerOptions);             
                            marker_3.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Rajkot&#41; (8)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Shop No.2,Ground Floor, Crystal Mall,Kalawao Main Road, Opp. Rani Tower</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Rajkot,</span> ' + 
                                                    '<span class="addressState">IN-GJ</span> ' + 
                                                    '<span class="addressZipCode">360005</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">088663 17870</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_3)            
                           
                            google.maps.event.addListener(marker_3, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Rajkot&#41; (8)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Shop No.2,Ground Floor, Crystal Mall,Kalawao Main Road, Opp. Rani Tower</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Rajkot,</span> ' + 
                                                    '<span class="addressState">IN-GJ</span> ' + 
                                                    '<span class="addressZipCode">360005</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">088663 17870</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_3)
                            });
                          }
                        var geoLat = "19.077064";
                        var geoLng = "72.998993";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_4 = new google.maps.Marker(GMarkerOptions);             
                            marker_4.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Vashi II&#41; (9)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">8&#47;8A&#47;9, Gr Floor, Inorbit Mall,  Vashi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Navi Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400703</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 3209 5668</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_4)            
                           
                            google.maps.event.addListener(marker_4, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Vashi II&#41; (9)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">8&#47;8A&#47;9, Gr Floor, Inorbit Mall,  Vashi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Navi Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400703</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 3209 5668</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_4)
                            });
                          }
                        var geoLat = "19.090806";
                        var geoLng = "72.907667";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_5 = new google.maps.Marker(GMarkerOptions);             
                            marker_5.setIcon(new google.maps.MarkerImage("<?php echo current_theme_path() ?>/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Ghatkopar&#41; (10)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">37A &#47; 44, Second floor, R city mall, LBS Marg, Old Anacin Factory, Ghatkopar &#40;W&#41;</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400086</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value"> 10:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 2517 2954</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_5)            
                           
                            google.maps.event.addListener(marker_5, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Ghatkopar&#41; (10)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">37A &#47; 44, Second floor, R city mall, LBS Marg, Old Anacin Factory, Ghatkopar &#40;W&#41;</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Mumbai,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">400086</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value"> 10:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">022 2517 2954</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_5)
                            });
                          }
                        var geoLat = "16.498973";
                        var geoLng = "80.652114";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_6 = new google.maps.Marker(GMarkerOptions);             
                            marker_6.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">Globus &#40;Vijaywada&#41; (15)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Ground Floor, Ripples Mall, MG Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Vijaywada,</span> ' + 
                                                    '<span class="addressState">IN-AP</span> ' + 
                                                    '<span class="addressZipCode">520010</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">0866 666 6005</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_6)            
                           
                            google.maps.event.addListener(marker_6, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">Globus &#40;Vijaywada&#41; (15)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Ground Floor, Ripples Mall, MG Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Vijaywada,</span> ' + 
                                                    '<span class="addressState">IN-AP</span> ' + 
                                                    '<span class="addressZipCode">520010</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">0866 666 6005</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_6)
                            });
                          }
                        var geoLat = "21.147728";
                        var geoLng = "79.084277";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_7 = new google.maps.Marker(GMarkerOptions);             
                            marker_7.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Nagpur&#41; (17)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Variety Mall,Amravati-Vardha Rd, Variety Square,Sitabuldi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Nagpur,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">440012</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 8:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">079 3220 1017</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_7)            
                           
                            google.maps.event.addListener(marker_7, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Nagpur&#41; (17)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Variety Mall,Amravati-Vardha Rd, Variety Square,Sitabuldi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Nagpur,</span> ' + 
                                                    '<span class="addressState">IN-MH</span> ' + 
                                                    '<span class="addressZipCode">440012</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 8:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">079 3220 1017</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_7)
                            });
                          }
                        var geoLat = "13.040456";
                        var geoLng = "80.243213";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_8 = new google.maps.Marker(GMarkerOptions);             
                            marker_8.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;T-Nagar&#41; (18)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">113&#47;114,Sir Theyagaraya Road, Meena Kampala Arcade,T-Nagar</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Chennai,</span> ' + 
                                                    '<span class="addressState">IN-TN</span> ' + 
                                                    '<span class="addressZipCode">600017</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">044 2815 5059</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_8)            
                           
                            google.maps.event.addListener(marker_8, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;T-Nagar&#41; (18)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">113&#47;114,Sir Theyagaraya Road, Meena Kampala Arcade,T-Nagar</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Chennai,</span> ' + 
                                                    '<span class="addressState">IN-TN</span> ' + 
                                                    '<span class="addressZipCode">600017</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">044 2815 5059</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_8)
                            });
                          }
                        var geoLat = "13.001024";
                        var geoLng = "80.256416";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_9 = new google.maps.Marker(GMarkerOptions);             
                            marker_9.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Adyar&#41; (21)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">36,Lattice Bridge Road, Adyar,Mungeli Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Chennai,</span> ' + 
                                                    '<span class="addressState">IN-TN</span> ' + 
                                                    '<span class="addressZipCode">600017</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">044 2446 6281</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_9)            
                           
                            google.maps.event.addListener(marker_9, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Adyar&#41; (21)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">36,Lattice Bridge Road, Adyar,Mungeli Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Chennai,</span> ' + 
                                                    '<span class="addressState">IN-TN</span> ' + 
                                                    '<span class="addressZipCode">600017</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">044 2446 6281</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_9)
                            });
                          }
                        var geoLat = "28.650531";
                        var geoLng = "77.352542";
                        if(lat == geoLat && geoLng == lng){     
                            var GMarkerOptions = {
                            position: new google.maps.LatLng(lat, lng),
                            map: map
                          };
                          
                          var marker_10 = new google.maps.Marker(GMarkerOptions);             
                            marker_10.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                          
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Pacific&#41; (23)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Pacific Mall,Plot No 1, Site No IV,Sahibabad Industrial Area, Sahibabad,Kaushambi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Ghaziabad,</span> ' + 
                                                    '<span class="addressState">IN-UP</span> ' + 
                                                    '<span class="addressZipCode">201010</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br><br><br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">0120 417 2200</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_10)            
                           
                            google.maps.event.addListener(marker_10, "click", function() {
                              var message = '<ul class="displayList storeDetailsBubble">'+
                                              '<li class="storeName">GLOBUS &#40;Pacific&#41; (23)</li>';
                              message = message+'<li class="storeAddress">' + 
                                                '<span class="label">Address&#58;</span>' + 
                                                '<span class="value">' + 
                                                    '<span class="addressLine addressLine1">Pacific Mall,Plot No 1, Site No IV,Sahibabad Industrial Area, Sahibabad,Kaushambi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                    '<span class="addressCity">Ghaziabad,</span> ' + 
                                                    '<span class="addressState">IN-UP</span> ' + 
                                                    '<span class="addressZipCode">201010</span>' + 
                                                  '</span>' + 
                                                '</li>';
                                  message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br><br><br></span></li>';
                              message = message+'<li class="storePhone">' + 
                                                  '<span class="label">Phone&#58;</span> <span class="value">0120 417 2200</span>' + 
                                                '</li>'+
                                              '</ul>';
                              infoWindow.setContent(message);
                              infoWindow.open(map, marker_10)
                            });
                          }
                   }
            
          </script>
          <!-- End Template component://osafe/webapp/osafe/common/storeLocator/storeLocationsList.ftl -->
          <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorItems -->
          <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#storeLocatorGoogleMap -->
          <!-- Begin Template component://osafe/webapp/osafe/common/storeLocator/storeLocatorGoogleMap.ftl -->
          <script type="text/javascript">
            function loadScript() {
                    var script = document.createElement("script");
                    script.type = "text/javascript";
                    script.src = "https://maps.google.com/maps/api/js?sensor=false&key=&callback=hideDirection";
                    document.body.appendChild(script);
                    jQuery('#isGoogleApi').val("Y");
             }
            function hideDirection() {
                jQuery('.noDirection').hide();
                jQuery('.mapDirection').hide();
                jQuery('.mapCanvas').removeClass('mapCanvasWithDirection');
                jQuery('.routeDirection').children().remove();
                loadMap();
            }
            function showDirection() {
                jQuery('.noDirection').hide();
                jQuery('.mapDirection').show();
                jQuery('.mapCanvas').addClass("mapCanvasWithDirection");
            }
            function noDirection() {
                jQuery('.noDirection').show();
                jQuery('.mapDirection').show();
                jQuery('.mapCanvas').addClass("mapCanvasWithDirection");
            }
          </script>
          <div class="storelocator-wrapper">
            <div class="container googleMap storeLocatorGoogleMap">
              <div class="mapCanvas" id="map_canvas" style="width:600px; height:700px;">
                <div class="mapLoading">Loading...</div>
              </div>
              <div class="mapDirection" style="height:700px;display:none;">
                <div id="noDirection" class="noDirection">
                  <span>Sorry no direction route found.</span>
                </div>
                <div id="routeDirection" class="routeDirection" style="height:700px;"></div>
                <div id="closeDirection" class="closeDirection">
                  <a href="javascript:void(0);" class="standardBtn action" onclick="hideDirection();">Close</a>
                </div>
              </div>
              <script type="text/javascript">
                var directionsService;
                var directionsDisplay;
                function loadMap() {
                  var mapOptions = {zoom: Math.min (4),
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        scrollwheel: false,
                        mapTypeControl: true,
                        mapTypeControlOptions: {
                                               style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
                                               },
                        zoomControl: true,
                        zoomControlOptions: {
                                            style: google.maps.ZoomControlStyle.SMALL
                                            }
                        }
                  var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
                  infoWindow = new google.maps.InfoWindow();
                  directionsService = new google.maps.DirectionsService();
                  var rendererOptions = { suppressBicyclingLayer: true,suppressMarkers: true
                                        };
                  directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                  directionsDisplay.setMap(map);
                  directionsDisplay.setPanel(document.getElementById("routeDirection"));
                
                          map.setCenter(new google.maps.LatLng(19.075984, 72.877656));
                          map.setCenter(new google.maps.LatLng(22.515358, 88.35004));
                          map.setCenter(new google.maps.LatLng(21.1458, 79.088155));
                          map.setCenter(new google.maps.LatLng(22.303895, 70.80216));
                          map.setCenter(new google.maps.LatLng(19.077064, 72.998993));
                          map.setCenter(new google.maps.LatLng(19.090806, 72.907667));
                          map.setCenter(new google.maps.LatLng(16.498973, 80.652114));
                          map.setCenter(new google.maps.LatLng(21.147728, 79.084277));
                          map.setCenter(new google.maps.LatLng(13.040456, 80.243213));
                          map.setCenter(new google.maps.LatLng(13.001024, 80.256416));
                          map.setCenter(new google.maps.LatLng(28.650531, 77.352542));
                
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(19.075984, 72.877656),
                        map: map
                      };
                      var marker_0 = new google.maps.Marker(GMarkerOptions);
                        marker_0.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_0, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Thane&#41; (11)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Unit No.GF-35,Viviana Mall, Pokharan No.2,Subhash Nagar, Next to Jupiter Hospital</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Mumbai,</span> ' + 
                                                '<span class="addressState">IN-MH</span> ' + 
                                                '<span class="addressZipCode">400610</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">022 6170 5701</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_0)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(22.515358, 88.35004),
                        map: map
                      };
                      var marker_1 = new google.maps.Marker(GMarkerOptions);
                        marker_1.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_1, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">Globus &#40;Kolkata II&#41; (2)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">1st and 2nd Floor, Lake Mall, 104 Rashbhihari Avenue, Lake Market</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Kolkata,</span> ' + 
                                                '<span class="addressState">IN-WB</span> ' + 
                                                '<span class="addressZipCode">700029</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">033 23242436</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_1)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(21.1458, 79.088155),
                        map: map
                      };
                      var marker_2 = new google.maps.Marker(GMarkerOptions);
                        marker_2.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_2, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Nagpur II&#41; (6)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Gr.Flr G 52A,52B,53A,Empress Mall, Sir Bezonji Mehta Road, Nr Gandhi Sagar Lake</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Nagpur,</span> ' + 
                                                '<span class="addressState">IN-MH</span> ' + 
                                                '<span class="addressZipCode">440018</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">090216 88575</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_2)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(22.303895, 70.80216),
                        map: map
                      };
                      var marker_3 = new google.maps.Marker(GMarkerOptions);
                        marker_3.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_3, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Rajkot&#41; (8)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Shop No.2,Ground Floor, Crystal Mall,Kalawao Main Road, Opp. Rani Tower</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Rajkot,</span> ' + 
                                                '<span class="addressState">IN-GJ</span> ' + 
                                                '<span class="addressZipCode">360005</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">088663 17870</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_3)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(19.077064, 72.998993),
                        map: map
                      };
                      var marker_4 = new google.maps.Marker(GMarkerOptions);
                        marker_4.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_4, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Vashi II&#41; (9)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">8&#47;8A&#47;9, Gr Floor, Inorbit Mall,  Vashi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Navi Mumbai,</span> ' + 
                                                '<span class="addressState">IN-MH</span> ' + 
                                                '<span class="addressZipCode">400703</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">022 3209 5668</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_4)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(19.090806, 72.907667),
                        map: map
                      };
                      var marker_5 = new google.maps.Marker(GMarkerOptions);
                        marker_5.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_5, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Ghatkopar&#41; (10)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">37A &#47; 44, Second floor, R city mall, LBS Marg, Old Anacin Factory, Ghatkopar &#40;W&#41;</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Mumbai,</span> ' + 
                                                '<span class="addressState">IN-MH</span> ' + 
                                                '<span class="addressZipCode">400086</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value"> 10:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">022 2517 2954</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_5)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(16.498973, 80.652114),
                        map: map
                      };
                      var marker_6 = new google.maps.Marker(GMarkerOptions);
                        marker_6.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_6, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">Globus &#40;Vijaywada&#41; (15)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Ground Floor, Ripples Mall, MG Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Vijaywada,</span> ' + 
                                                '<span class="addressState">IN-AP</span> ' + 
                                                '<span class="addressZipCode">520010</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">0866 666 6005</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_6)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(21.147728, 79.084277),
                        map: map
                      };
                      var marker_7 = new google.maps.Marker(GMarkerOptions);
                        marker_7.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_7, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Nagpur&#41; (17)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Variety Mall,Amravati-Vardha Rd, Variety Square,Sitabuldi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Nagpur,</span> ' + 
                                                '<span class="addressState">IN-MH</span> ' + 
                                                '<span class="addressZipCode">440012</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 8:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">079 3220 1017</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_7)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(13.040456, 80.243213),
                        map: map
                      };
                      var marker_8 = new google.maps.Marker(GMarkerOptions);
                        marker_8.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_8, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;T-Nagar&#41; (18)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">113&#47;114,Sir Theyagaraya Road, Meena Kampala Arcade,T-Nagar</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Chennai,</span> ' + 
                                                '<span class="addressState">IN-TN</span> ' + 
                                                '<span class="addressZipCode">600017</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">044 2815 5059</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_8)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(13.001024, 80.256416),
                        map: map
                      };
                      var marker_9 = new google.maps.Marker(GMarkerOptions);
                        marker_9.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_9, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Adyar&#41; (21)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">36,Lattice Bridge Road, Adyar,Mungeli Road</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Chennai,</span> ' + 
                                                '<span class="addressState">IN-TN</span> ' + 
                                                '<span class="addressZipCode">600017</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">11:00 am – 10:00 pm<br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">044 2446 6281</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_9)
                        });
                      var GMarkerOptions = {
                        position: new google.maps.LatLng(28.650531, 77.352542),
                        map: map
                      };
                      var marker_10 = new google.maps.Marker(GMarkerOptions);
                        marker_10.setIcon(new google.maps.MarkerImage("/osafe_theme/images/user_content/images/map/map-pointer.png"));
                        google.maps.event.addListener(marker_10, "click", function() {
                          var message = '<ul class="displayList storeDetailsBubble">'+
                                          '<li class="storeName">GLOBUS &#40;Pacific&#41; (23)</li>';
                          message = message+'<li class="storeAddress">' + 
                                            '<span class="label">Address&#58;</span>' + 
                                            '<span class="value">' + 
                                                '<span class="addressLine addressLine1">Pacific Mall,Plot No 1, Site No IV,Sahibabad Industrial Area, Sahibabad,Kaushambi</span><br/> <span class="addressLine addressLine2"></span> <span class="addressLine addressLine3"></span>' + 
                                                '<span class="addressCity">Ghaziabad,</span> ' + 
                                                '<span class="addressState">IN-UP</span> ' + 
                                                '<span class="addressZipCode">201010</span>' + 
                                              '</span>' + 
                                            '</li>';
                              message = message+'<li class="openingHours"><span class="label">Hours&#58;</span> <span class="value">10:00 am – 10.00 pm<br><br><br></span></li>';
                          message = message+'<li class="storePhone">' + 
                                              '<span class="label">Phone&#58;</span> <span class="value">0120 417 2200</span>' + 
                                            '</li>'+
                                          '</ul>';
                          clearAddress();
                          infoWindow.setContent(message);
                          infoWindow.open(map, marker_10)
                        });
                }
                function setDirections(fromAddress, toAddress, travelMode) {
                  var request = { origin:fromAddress,
                                  destination:toAddress,
                                  travelMode: google.maps.TravelMode[travelMode]
                                    ,unitSystem: google.maps.UnitSystem.IMPERIAL
                                };
                  directionsService.route(request, function(response, status) {
                                if (status == google.maps.DirectionsStatus.OK) {
                                  directionsDisplay.setDirections(response);
                                  showDirection();
                                } else if (status == google.maps.DirectionsStatus.ZERO_RESULTS) {
                                  directionsDisplay.setDirections(response);
                                  noDirection();
                                }
                              });
                              infoWindow.close();
                }
              </script>
            </div>
          </div>
        </div>
      </div>
      <div id="pesStorePickup" class="pesSpot"></div>
    </div>
  </div>
</div>