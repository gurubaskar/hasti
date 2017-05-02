<?php //krumo($cart, $addresses); ?>
<?php $cartItems = $cart['productList']; ?>


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
<div id="multiPageCustomerAddress" class="multiPageCustomerAddress">
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
    return;

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
			//	alert(document.getElementById("secSignature"));
		      //	document.getElementById("addressStreet1").value = document.getElementById("js_SHIPPING_ADDRESS1").value;

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
    	    form.action="/multiPageUpdateCustomerAddress";
            form.submit();
        }else if (mode == "MAU") {
            form.action="/multiPageCustomerAddressValidation";
            form.submit();
        }else if (mode == "VDN") {
            if (validateCart()) {
                form.action="/multiPageUpdateCustomerAddress";
            	form.submit();
            }
        }else if (mode == "NA") {
            form.action="/multiPageNewCheckoutAddress?preContactMechTypeId=POSTAL_ADDRESS&contactMechPurposeTypeId="+value+"&DONE_PAGE=";
            form.submit();
        } else if (mode == "BK") {
            form.action="/?action=previous";
            form.submit();
        }  else if (mode == "SCBK") {
            form.action="";
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
			                    url: '/modifycartSnippet',
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
		            				
		            			/*	var totalCartNo=jQuery(response).find('.number').html();
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
        	var grandTotal="";
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
                document.checkoutInfoForm.action="/";
                document.checkoutInfoForm.submit();
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
          var cform = document.checkoutInfoForm;
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
        var cform = document.checkoutInfoForm;
        cform.action="/?gcNumber="+giftCardNumberWithoutSpace+"";
        cform.submit();
    }

    function removeGiftCardNumber(gcPaymentMethodId)
    {
        if (gcPaymentMethodId != null)
        {
          var cform = document.checkoutInfoForm;
          cform.action="/?gcPaymentMethodId="+gcPaymentMethodId+"";
          cform.submit();
        }
    }

    function addLoyaltyPoints()
    {
    	jQuery('#js_applyLoyaltyCard').bind('click', false);
    	var loyaltyNo=jQuery("#js_loyaltyPointsId").val();
        var cform = document.checkoutInfoForm;
        var url="/?loyaltyPointsId="+loyaltyNo+"";
         return ajaxFormSubmit(url,cform);
    }
    function removeLoyaltyPoints()
    {
    	jQuery('#js_removeLoyaltyCard').bind('click', false);
	    var cform = document.checkoutInfoForm;
	    window.location='/'
	    //var url="/";
	    //return ajaxFormSubmit(url,cform);
    }
    function updateLoyaltyPoints(indexOfAdj)
    {
    	jQuery('#js_updateLoyaltyPointsAmount').bind('click', false);
	    var cform = document.checkoutInfoForm;
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

<form method="post" action="/" id="checkoutInfoForm" name="checkoutInfoForm">
    <input type="hidden" id="checkoutpage" name="checkoutpage" value="shippingaddress">
    <input type="hidden" name="csrfPreventionSalt" value="qhK7W0ipoKIUk1YTZAVG">
    <input type="hidden" name="partyId" value="10230">
    <input type="hidden" name="productStoreId" value="GS_STORE">
    <!-- Begin Screen component://osafe/widget/CommonScreens.xml#PageMessages -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->





<!-- End Template component://osafe/webapp/osafe/common/eCommerceErrorMessages.ftl -->
<!-- End Screen component://osafe/widget/CommonScreens.xml#PageMessages -->

    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_SHIPPING_ADDRESS -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="ptsShippingAddress" class="ptsSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_SHIPPING_ADDRESS -->

    <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressFootprint -->
<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceCartFootprint -->
<div id="eCommerceCartFootprintContainer">
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceCartFootprint.ftl -->
<style>

.mainul{  margin-bottom:5px;}
.mainul li{display:inline; margin-right:84px;}
.step ul{width:auto;}
</style>


<ul class="mainul">
<li>
<!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/2-1.jpg">-->
<div class="progress_dot inactive" id="login-stage">
<div class="progress_state levelone"><?php echo t('confirm order');?></div>
<div class="resp_progress_state resplevelone">
<i class="fa fa-lock" aria-hidden="true"></i>
</div>
</div>
</li>
<li class="resp-active">
<!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/2-2.jpg">-->
<div class="progress_dot active" id="shipping-stage">
<div class="progress_state leveltwo"><?php echo t('shipping address');?></div>
<div class="resp_progress_state respleveltwo">
<i class="fa fa-truck" aria-hidden="true"></i>
</div>
</div>
</li>
<li>
<!--<img alt="HomeS" src="/osafe_theme/images/user_content/images/2-3.jpg">-->
<div class="progress_dot inactive" id="payment-stage">
<div class="progress_state levelthree"><?php echo t('payment method');?></div>
<div class="resp_progress_state resplevelhree">
<i class="fa fa-money" aria-hidden="true"></i>
</div>
</div>
</li>
</ul>

<div style="display:none">
     <ul>
           <!--<a href="javascript:submitCheckoutForm(document.checkoutInfoForm, 'SCBK', '');"></a>--><li id="cart" class="first"><span><?php echo t('My Bag');?></span></li>
            <li id="shippingAddress" class="current"><span><?php echo t('Shipping Address');?></span></li>
            <li id="payment" class="next"><span><?php echo t('Payment');?></span></li>
            <!--<li id="confirmation" class="last"><span>Order Confirmation</span></li>-->
        
        
        <!---->
    </ul>
</div>
<!-- End Template component://osafe/webapp/osafe/common/eCommerceCartFootprint.ftl -->
</div><!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#eCommerceCartFootprint -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressFootprint -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressShippingAddress -->
<!-- Begin Screen component://osafe/widget/EcommerceCheckoutScreens.xml#multiPageShippingAddress -->
<!-- Begin Screen component://osafe/widget/EntryScreens.xml#addressShippingEntryForm -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressShippingEntry.ftl -->

<div class="formwidth">

  <div class="container shippingAddress shippingAddressShippingAddress">
	<div id="js_SHIPPING_ADDRESS_ENTRY">
<script type="text/javascript">
    jQuery(document).ready(function () {
  		//Check if country is available according to DIV sequencing strategy
  		//If NOT we need to add a hidden jquery field to handle processing on the back end and jquery getPostalAdress method (formEntryJS.ftl)
  		//In this case Country is set to system parameter COUNTRY_DEFAULT
	  	if (jQuery('#js_SHIPPING_ADDRESS_ENTRY').length)
	  	{
	  		if (jQuery('#js_SHIPPING_COUNTRY').length)
	  		{
	  			//Country will be processed as normal
	  		}
	  		else
	  		{
	  			//When only one country is supported (Country Div is hidden or Drop Down is not displayed)
	      		var defaultCountryValue = "IND";
	  			jQuery('<input>').attr({
				    type: 'hidden',
				    id: 'js_SHIPPING_COUNTRY',
				    name: 'SHIPPING_COUNTRY',
				    value: ''+defaultCountryValue+''
				}).appendTo('#js_SHIPPING_ADDRESS_ENTRY');
				jQuery('#js_SHIPPING_COUNTRY').val(defaultCountryValue);
				updateShippingOption('N');
	  		}
	  	}
	  	
	  	//When country is changed get the list of available state/province geo. 
        if (jQuery('#js_SHIPPING_COUNTRY')) 
        {
            if(!jQuery('#SHIPPING_STATE_LIST_FIELD').length) 
            {
                getAssociatedStateList('js_SHIPPING_COUNTRY', 'js_SHIPPING_STATE', 'advice-required-SHIPPING_STATE', 'SHIPPING_STATES');
            }
            getAddressFormat("SHIPPING");
            jQuery('#js_SHIPPING_COUNTRY').change(function()
            {
                getAssociatedStateList('js_SHIPPING_COUNTRY', 'js_SHIPPING_STATE', 'advice-required-SHIPPING_STATE', 'SHIPPING_STATES');
                getAddressFormat("SHIPPING");
            });
        }
    });
    
    
    
</script>

<script>

 jQuery(document).ready(function () 
  {
  	jQuery(window).resize(function() {
    var shpAddressSelcted=jQuery("input[type='radio'][name='SHIPPING_SELECT_ADDRESS']:checked");
  if (shpAddressSelcted.length > 0) {
    selectedVal = shpAddressSelcted.val();
	getPostalAddress(selectedVal, 'SHIPPING');	
}
	}).resize();
  });

</script>

    <!--<h1>Shipping Address</h1>-->   
    <div class="eCommerceEditCustomerInfo-headerr"></div> <!-- added on 13-06 -->
    <!-- <h2 class="MyAccount-subhead">Contact Information</h2>
   <p class="instructions">Where would you like your items shipped?</p> -->

<input type="hidden" id="js_SHIPPINGAddressContactMechId" name="SHIPPINGAddressContactMechId" value="10731">
<input type="hidden" id="SHIPPINGHomePhoneContactMechId" name="SHIPPINGHomePhoneContactMechId" value="">
<input type="hidden" id="SHIPPINGMobilePhoneContactMechId" name="SHIPPINGMobilePhoneContactMechId" value="">
<input type="hidden" id="SHIPPING_ADDRESS_ALLOW_SOL" name="SHIPPING_ADDRESS_ALLOW_SOL" value="N">
<input type="hidden" name="SHIPPING_USE_SCREEN" value="SHIPPING">
   <!-- -->
    <div class="addressSection">
    <div id="js_SHIPPING_AddressSection">
<div>
</div>

<!-- address common field entry -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

          <div class="ShippingAddressInfo group group1">
	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddressSelector -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddressSelector.ftl -->
<script>

jQuery(document).ready(function () {
		ContactSearchText();
 		jQuery(".contactautosuggest").autocomplete({
     	select:function(event, ui){
     	console.log(event);
      	itemval=ui.item.value;
      	postldetls = itemval.split('-');
       	if(isNaN( postldetls[0])){
       	jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[3]);
    	var stateISO=getStateValue(postldetls[2]);
    	jQuery("#js_SHIPPING_STATE").val(stateISO);
    	jQuery("#js_SHIPPING_CITY").val(postldetls[1]);
    	autoFill:false;
    	return false;
 	}else{
    	jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[0]);
    	var stateISO=getStateValue(postldetls[3]);
    	jQuery("#js_SHIPPING_STATE").val(stateISO);
    	jQuery("#js_SHIPPING_CITY").val(postldetls[2]);
    	autoFill:false;
    	return false;
 	}
      jQuery("#js_SHIPPING_POSTAL_CODE").removeClass();
            jQuery("#js_SHIPPING_POSTAL_CODE").addClass("autosuggest");
       }
  	});




var newUserBtnHide = jQuery("#hideNewAddressBtnForRegUser").val();
var btnPos = newUserBtnHide.indexOf("undefined");



jQuery('.SHIPPING_SELECT_ADDRESS').change(function() {
        if(jQuery(this).is(":checked")) {
       		jQuery("#js_PostalAddressContactMechIdForRadio").val(jQuery(this).val());
            jQuery('#displayContinueShippingBtn').css({'display':'block'});
    		jQuery('#displayNewAddContinueShippingBtn').css({'display':'none'});
        }else{
	        jQuery('#displayContinueShippingBtn').css({'display':'none'});
	    	jQuery('#displayNewAddContinueShippingBtn').css({'display':'block'});
        }

    });

    jQuery('.radioOption').click(function(){
    	jQuery('.SHIPPING_SELECT_ADDRESS').prop('checked', false);
    	jQuery('#displayContinueShippingBtn').css({'display':'none'});
    	jQuery('#displayNewAddContinueShippingBtn').css({'display':'block'});
	});


		var shippingPageError=jQuery(".radioOption").find(".fieldErrorMessage");
	if(shippingPageError != undefined && shippingPageError != null && shippingPageError.length >0)
	{
		jQuery(this).prop('checked', true);
		jQuery('.SHIPPING_SELECT_ADDRESS').prop('checked', false);
		jQuery('#displayContinueShippingBtn').css({'display':'none'});
		jQuery('#displayNewAddContinueShippingBtn').css({'display':'block'});
	}
});

jQuery("input[name='SHIPPING_SELECT_ADDRESS']").each(function() {
     jQuery('#displayContinueShippingBtn').css({'display':'block'});
    jQuery('#displayNewAddContinueShippingBtn').css({'display':'none'});
});



jQuery('.contactautosuggest').keypress(function (e) {
 	var key = e.which;
 	if(key == 13)
  	{
    	if(isNaN( postldetls[0])){
    	jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[3]);
    	var stateISO=getStateValue(postldetls[2]);
    	jQuery("#js_SHIPPING_STATE").val(stateISO);
    	jQuery("#js_SHIPPING_CITY").val(postldetls[1]);
    	autoFill:false;
    	return false;
 	}else{
    	jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[0]);
    	var stateISO=getStateValue(postldetls[3]);
    	jQuery("#js_SHIPPING_STATE").val(stateISO);
    	jQuery("#js_SHIPPING_CITY").val(postldetls[2]);
    	autoFill:false;
    	return false;
 		}
  	}
  	
  	});
  	jQuery('.contactautosuggest').keydown(function(event){
    var keyCode = (event.keyCode ? event.keyCode : event.which);
    	if(keyCode == 13){
      		if(isNaN( postldetls[0])){
    			jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[3]);
    			var stateISO=getStateValue(postldetls[2]);
    			jQuery("#js_SHIPPING_STATE").val(stateISO);
    			jQuery("#js_SHIPPING_CITY").val(postldetls[1]);
    			autoFill:false;
    			return false;
 		}else{
    		jQuery("#js_SHIPPING_POSTAL_CODE").val(postldetls[0]);
    		var stateISO=getStateValue(postldetls[3]);
    		jQuery("#js_SHIPPING_STATE").val(stateISO);
    		jQuery("#js_SHIPPING_CITY").val(postldetls[2]);
    		autoFill:false;
    		return false;
 			}
    	}
	});


	
	function ContactSearchText() {
	
	jQuery(".contactautosuggest").autocomplete({
		source: function(request, response) {
		var url;
		if(controlfocus=='pincode'){
			url="https://www.whizapi.com/api/v2/util/ui/in/indian-city-by-postal-code?pin="+ document.getElementById("js_SHIPPING_POSTAL_CODE").value + "&project-app-key=1uezklredknnej72z9n2ci7q";
		}
		if(controlfocus=='city'){
			url="https://www.whizapi.com/api/v2/util/ui/in/indian-postal-codes?search="+ document.getElementById('js_SHIPPING_CITY').value +"&project-app-key=1uezklredknnej72z9n2ci7q";
		}
	jQuery.ajax({
		type: "POST",
		contentType: "application/json; charset=utf-8",
		url: url,
		dataType: "json",
		success: function(data) {
		console.log(data);
 		var suggestions = [];
 		jQuery.each(data, function (property, value){
        	if(property == "Data"){
				var pincity;
				jQuery.each( value, function( key, value ) {
					if(controlfocus=='pincode'){
						pincity=value.Pincode+"-"+value.Address+"-"+value.City+"-"+value.State;
					}
					if(controlfocus=='city'){
						pincity=value.Address+"-"+value.City+"-"+value.State+"-"+value.Pincode;
					}
 						suggestions.push(pincity);
				});
			}
		});
			response(suggestions);
		},
		error: function(result) {
		}
	});
	}
	});
}



</script>
<input type="hidden" id="js_PostalAddressContactMechIdForRadio" name="js_PostalAddressContactMechIdForRadio" value="">
<div class="entry addressSelector shippingAddressInfoAddressSelector">

<?php if (!empty($addresses['postalAddressList'])): ?>

	    <div class="shipping-leftContainer">


          <div id="addressbox">

  <?php foreach ($addresses['postalAddressList'] as $i => $address): ?>

		        		         <div class="addressbox">
			                      <label class="radioOptionLabel">
			                      <input type="radio" class="SHIPPING_SELECT_ADDRESS" style="width:25px; height:25px;" name="SHIPPING_SELECT_ADDRESS" value="<?php echo $address['contactMechId'] ?>" <?php echo empty($i) ? 'checked="checked"' : '' ?>>
		                          <span class="radioOptionText">
								    

	<div>
      <span>
      </span>
    </div>

 <div class="shippingaddress">
    <ul>
    	

		<div class="shipping-addrwrap">


            <li class=" shipname">
                <div>
                    <span style="font-size:1.2em;"><b><?php echo $address['toName'] ?></b></span>
                </div>
            </li>
            <li class="address-nname ">
                <h4><?php echo $address['attnName'] ?></h4>
            </li>
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $address['address1'] . ' ' . $address['address2'] ?></span>
                </div>
            </li>
        <li>
            <div>
                    <span style="font-size:1.1em; word-wrap: break-word;"><?php echo $address['city'] ?>,</span>
           </div>
        </li>
        <li>
        	<div>
                    <span style="font-size:1.1em;">
                            <?php echo $address['stateProvinceGeoId'] ?>,
                            <?php echo $address['postalCode'] ?>
                    </span>
        	</div>
        </li>
        <li>
			<div class=""><span style="font-size:1.1em; word-wrap: break-word;">
			Phone : <?php echo $address['contactNumber'] ?>
			</span></div>
		</li>
		
		</div>

   </ul>
   </div>


								  </span>
								  </label>
								  </div>

  <?php endforeach; ?>

  <div class="shippingaddress" style="clear: both;">
    <ul>

      <li>

          <div class="hide">
            <span class="hide"><a id="js_chooseAddressBtn" href="#"><?php echo t('Checkout with Selected Address'); ?></a></span>
          </div>
      </li>

    </ul>
  </div>

          </div>



	      </div>

<?php endif; ?>

	    <div class="shipping-rightContainer">
	    <h4><?php echo t('Add New Address'); ?></h4>
	    	 <div class="entry radioOption">
	        <div style="clear:both;">

					<div class="shippingRow">
					<label for="SHIPPING_POSTAL_CODE"><span class="required">*</span><?php echo t('Pin Code:'); ?></label>
		      			<div class="entryField">
		      				<input type="text" maxlength="100" class="addressFirstName" name="SHIPPING_POSTAL_CODE" id="js_SHIPPING_POSTAL_CODE_NEW" value="">
		      			</div>
					</div>

					<div class="shippingRow">
					<label for="SHIPPING_NICK_NAME_NEW"><span class="required">*</span><?php echo t('Address Type:'); ?></label>
		      			<div class="entryField">
		      				<input type="text" maxlength="100" class="addressFirstName" name="SHIPPING_ATTN_NAME" id="js_SHIPPING_ATN_NAME" value="">
		      			</div>
					</div>



					<div class="shippingRow">
					<label for="SHIPPING_FIRST_NAME_NEW"><span class="required">*</span><?php echo t('First Name:'); ?></label>
		      			<div class="entryField">
		      				<input type="text" maxlength="100" class="addressFirstName" name="SHIPPING_FIRST_NAME" id="js_SHIPPING_FIRST_NAME_NEW" value="">
		      			</div>
					</div>

					<div class="shippingRow">
					<label for="SHIPPING_LAST_NAME_NEW"><span class="required">*</span>
<?php echo t('Last Name:'); ?></label>
		      			<div class="entryField">
		      				<input type="text" maxlength="100" class="addressLastName" name="SHIPPING_LAST_NAME" id="js_SHIPPING_LAST_NAME_NEW" value="">
		      			</div>
		      			</div>


					<div class="shippingRow">
					<label for="SHIPPING_ADDRESS1_NEW">
						<span><span class="required">*</span>
 <?php echo t('Address:'); ?></span></label>
						<textarea id="js_SHIPPING_ADDRESS1_NEW" name="SHIPPING_ADDRESS1" class="content characterLimit" cols="35" rows="5" maxlength="255"></textarea>
					</div>

					<div class="shippingRow">
					<label for="SHIPPING_CITY_NEW"><span class="required">*</span><?php echo t('City:'); ?></label>
		      			<div class="entryField">
		      				<input type="text" maxlength="100" class="addressFirstName" name="SHIPPING_CITY" id="js_SHIPPING_CITY_NEW" value="">
		      			</div>
					</div>

				<div class="shippingRow">

<div class="basic-grey">
    <div id="SHIPPING_STATES" class="state">
        <label for="SHIPPING_STATE"><span><span class="required">*</span><?php echo t('State:'); ?></span>
            <span id="advice-required-SHIPPING_STATE_NEW" style="display:none; margin-left:20px; " class="errorMessage"><?php echo t('(Required)'); ?></span>
        
     
        <select id="js_SHIPPING_STATE_NEW" name="SHIPPING_STATE" class="select SHIPPING_COUNTRY">
          <?php echo theme('drubiz_us_states') ?>
        </select>
        </label>
      
    </div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressAddNewStateProvince.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingNewAddressInfoStateProvince -->

 					</div>

					<div class="shippingRow">
 					<label for="PHONE_MOBILE_CONTACT_NEW">
      					<span><span class="required">*</span>
<?php echo t('Mobile:'); ?></span></label>
     					<div style="display:inline;float:left;" class="newwidth shipping-mobile">
			    			<input type="text" size="2" id="PHONE_MOBILE_LOCAL" name="PHONE_MOBILE_LOCAL" value="+1" readonly="readonly" class="codecontrol" style="width:35px;">
	            			<input type="text" class="phone10 shipping-phone widthcontrol" pattern=".{10,10}" id="PHONE_MOBILE_CONTACT_NEW" maxlength="10" name="PHONE_MOBILE_CONTACT" style="width:326px;" value="">
          				</div>
            			<span class="entryHelper"> </span>
        				<div style="clear:both;"></div>
        				</div>

	        </div>

            </div>
						  <div class="entry addressSelector shippingAddressInfoAddressSelector" id="displayContinueShippingBtn123">
						  <label>&nbsp;</label>
						    <a href="#" class="standardBtn positive" id="js_submitAddressBtn"><span><?php echo t('Save & Checkout'); ?></span></a>
						  </div>

	    </div>

</div>
</div>
	<input type="hidden" id="hideNewAddressBtnForRegUser" value="10731">
<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddressSelector.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddressSelector -->

          </div>
          <div class="ShippingAddressInfo group group2">
	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoZipPostcode -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoZipPostcode.ftl -->
<!-- address zip entry -->
<div class="basic-grey" id="SHIPPING_postalcodeId" style="display: none;">
        <label for="SHIPPING_POSTAL_CODE">
            <span><span class="required">*</span>
<?php echo t('Pin Code:'); ?></span>
  <div class="entryField">

        	<input type="text" maxlength="6" class="contactautosuggest ui-autocomplete-input areapincode" autofill="false" onfocus="controlFocus('pincode');" name="SHIPPING_POSTAL_CODE" id="js_SHIPPING_POSTAL_CODE" value="560001" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        	<input type="hidden" id="SHIPPING_POSTAL_CODE_MANDATORY" name="SHIPPING_POSTAL_CODE_MANDATORY" value="Y">
        	</div>
        </label>
</div>


<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoZipPostcode.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoZipPostcode -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoNickname -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoNickname.ftl -->
 
<div class="displaynone entry nickname shippingAddressInfoNickname" style="display: none;">
<!-- <h2 class="MyAccount-subhead">Address</h2>		 added on 22-06 -->
        <!-- address nick name -->
          <label for="SHIPPING_ATTN_NAME"><span class="required">*</span>
<?php echo t('Address Type:'); ?>  </label>
          <div class="entryField">
          	<input type="text" maxlength="100" class="addressNickName" name="SHIPPING_ATTN_NAME" id="js_SHIPPING_ATTN_NAME" value="Shipping" placeholder="Home, Office..">
          	<input type="hidden" id="SHIPPING_ATTN_NAME_MANDATORY" name="SHIPPING_ATTN_NAME_MANDATORY" value="Y">
          </div>
</div>

<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoNickname.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoNickname -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoFirstName -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoFirstName.ftl -->
<div id="displaynone" class="displaynone" style="display: none;">
  
	<script>
		if((document.URL.indexOf("deleteFromCartSnippet") > -1) ||(document.URL.indexOf("updateSnippet") > -1)||(document.URL.indexOf("multiPageUpdateCustomerAddress") > -1) || (document.URL.indexOf("multiPageCustomer") > -1) || (document.URL.indexOf("multiPageValidateCheckoutAddress") > -1) || (document.URL.indexOf("multiPageAddOrUpdateCustomerAddress") > -1)) {
		  document.getElementById("displaynone").style.display = "none";
		  jQuery(".displaynone").hide();
		  jQuery("#SHIPPING_postalcodeId").hide(); 
		 }
		 var pn=jQuery(location).attr('pathname');
		 if(pn =="/validateAnonCustomerEmail"){
			jQuery(".nickname").hide();
			}
	</script>
	

<div class="entry firstName shippingAddressInfoFirstName">
    <!-- address first name -->
      <label for="SHIPPING_FIRST_NAME"><span class="required">*</span>
First Name:</label>
      <div class="entryField">
      	<input type="text" maxlength="20" class="addressFirstName" name="SHIPPING_FIRST_NAME" id="js_SHIPPING_FIRST_NAME" value="Akshay">
      	<input type="hidden" id="SHIPPING_FIRST_NAME_MANDATORY" name="SHIPPING_FIRST_NAME_MANDATORY" value="Y">
      </div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoFirstName.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoFirstName -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoLastName -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoLastName.ftl -->

<div class="entry lastName shippingAddressInfoLastName">
    <!-- address last name -->
      <label for="SHIPPING_LAST_NAME"><span class="required">*</span>
Last Name:</label>
      <div class="entryField">
      	<input type="text" maxlength="20" class="addressLastName" name="SHIPPING_LAST_NAME" id="js_SHIPPING_LAST_NAME" value="Patel">
      	<input type="hidden" id="SHIPPING_LAST_NAME_MANDATORY" name="SHIPPING_LAST_NAME_MANDATORY" value="Y">
      </div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoLastName.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoLastName -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddress1 -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddress1.ftl -->

<!-- address Line1 entry -->
<div class="basic-grey">
      <label for="SHIPPING_ADDRESS1">
      	<span><span class="required">*</span>
 Address:</span>
      		<div class="entryField">
      	<!-- <input type="text" maxlength="255" class="address" name="SHIPPING_ADDRESS1" id="js_SHIPPING_ADDRESS1" value="Global Village" /> -->
		<textarea id="js_SHIPPING_ADDRESS1" name="SHIPPING_ADDRESS1" class="content characterLimit" cols="35" rows="5" maxlength="255">Global Village</textarea>
      	<input type="hidden" id="SHIPPING_ADDRESS1_MANDATORY" name="SHIPPING_ADDRESS1_MANDATORY" value="Y">
      	</div>
      </label>
</div>

<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddress1.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddress1 -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddress2 -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddress2.ftl -->
<!-- address Line2 entry -->
<!-- <div class="basic-grey">
        <label for="SHIPPING_ADDRESS2">
            <span>Address line 2&#58;</span>
           	<input type="text" maxlength="255" class="address" name="SHIPPING_ADDRESS2" id="js_SHIPPING_ADDRESS2" value="" />
        	<input type="hidden" id="SHIPPING_ADDRESS2_MANDATORY" name="SHIPPING_ADDRESS2_MANDATORY" value="N"/>
        </label>
</div>--><!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoAddress2.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoAddress2 -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoCityTown -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoCityTown.ftl -->


<!-- address city entry -->
<div class="basic-grey myaddresscity">		<!-- added on 22-06 -->
    <div id="city">
        <label for="SHIPPING_CITY">
            <span><span class="required">*</span>
 City:</span>
       <div class="entryField">
      
        	<input type="text" maxlength="100" class="contactautosuggest ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" onfocus="controlFocus('city');" name="SHIPPING_CITY" id="js_SHIPPING_CITY" value="Bangalore"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
        	<input type="hidden" id="SHIPPING_CITY_MANDATORY" name="SHIPPING_CITY_MANDATORY" value="Y">
        	</div>
        	 </label>

    </div>
</div>

<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoCityTown.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoCityTown -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoStateProvince -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoStateProvince.ftl -->
<!-- address state entry -->





<div class="basic-grey myaddressstate">		<!-- added on 22-06 -->
    <div id="SHIPPING_STATES" class="state">
        <label for="SHIPPING_STATE"><span><span class="required">*</span>
 State:</span>
            <span id="advice-required-SHIPPING_STATE" style="display:none; margin-left:20px; " class="errorMessage">(Required)</span>


        <select id="js_SHIPPING_STATE" name="SHIPPING_STATE" class="select SHIPPING_COUNTRY">
          <?php echo theme('drubiz_us_states') ?>
        </select>
        </label>
        <input type="hidden" id="SHIPPING_STATE_MANDATORY" name="SHIPPING_STATE_MANDATORY" value="Y">
            <input type="hidden" id="SHIPPING_STATE_LIST_FIELD_MANDATORY" name="SHIPPING_STATE_LIST_FIELD_MANDATORY" value="Y">
            <input type="hidden" id="SHIPPING_STATE_LIST_FIELD" name="SHIPPING_STATE_LIST_FIELD" value="">

    </div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoStateProvince.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoStateProvince -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoPhoneCell -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoPhoneCell.ftl -->


<div class="basic-grey">
    <input type="hidden" name="mobilePhoneContactMechId" value="10732">
      <label for="PHONE_MOBILE_CONTACT">
      <div class="mobile"><span><span class="required">*</span>
 Mobile:</span></div>
      <div class="entryFieldmobile">
     		<div style="display:inline;float:left;" class="newwidth">                          <modified on="" 14-06="" --="">
		    <input type="text" size="2" id="PHONE_MOBILE_LOCAL" name="PHONE_MOBILE_LOCAL" value="+1" readonly="readonly" class="codecontrol" style="width:35px;">
           <input type="text" class="phone10 widthcontrol" pattern=".{10,10}" id="PHONE_MOBILE_CONTACT" maxlength="10" name="PHONE_MOBILE_CONTACT" value="9916574985">
          </modified></div>
            <span class="entryHelper"> </span>
            <input type="hidden" name="PHONE_MOBILE_CONTACT_OTHER_MANDATORY" value="Y">

         </div>
      </label>
</div>
	  <div class="entry phoneCell shippingAddressInfoPhoneCell" id="displayContinueShippingBtn">
	    <a href="javascript:submitCheckoutForm(document.checkoutInfoForm, 'DN', '');" class="standardBtn positive"><span>Continue</span></a>
	  </div>

<input type="hidden" name="fbDoneAction" value="multiPageUpdateCustomerAddress">
<!-- End Template component://osafe/webapp/osafe/common/entry/addressInfo/addressInfoPhoneCell.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoPhoneCell -->

          </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressInfoDivSequence -->

<!-- This looks odd but must stay.  The two opening DIVS are in the addressInfoSameAsBilling.ftl. -->
    </div>
    </div>
	<input type="hidden" id="js_SHIPPING_COUNTRY" name="SHIPPING_COUNTRY" value="IND"></div>
  </div>

 

</div>
<!-- End Template component://osafe/webapp/osafe/common/entry/addressShippingEntry.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#addressShippingEntryForm -->
<!-- End Screen component://osafe/widget/EcommerceCheckoutScreens.xml#multiPageShippingAddress -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressShippingAddress -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressCartInfo -->
<!-- Begin Template component://osafe/webapp/osafe/common/cart/cartInformation.ftl -->



    
		<div class="cont-right_multi shipping-cartdetails">
			<div class="checkout-cart-con">
				<div id="mycartSummaryfill">
					<div class="summaryhead"><div class="checkout-cart-head ch-cart-items">
							<strong><?php echo t('review your order'); ?></strong>
						</div>
						<div class="shipping-edit-cart"><a href="<?php echo url('cart') ?>"><?php echo t('Edit Cart'); ?></a></div>
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

									<div class="productimage"><img src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');"></div>
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
									 </div>
									 <div class="checkout-cart-head ch-cart-qt">
								 	<span><?php echo (int)$cart_product['quantity'] ?><!--<span-->
								 	<a href="javascript:submitCheckoutForm(document.checkoutInfoForm, 'UC', '');" title="Update"><span style="margin-left:17px;"><img width="10" height="10" style="margin-top:5px;" src="<?php echo current_theme_path() ?>/images/cartUpdateOver.png"></span></a>
						    	</span></div>
						    	<div> <input type="hidden" name="productName0" id="js_productName_0" value="<?php echo $cart_product['productName'] ?>"></div>
							   	<div class="checkout-cart-head ch-crt-price">
                    <?php if (FALSE AND $cart_product['productPrice'] != $cart_product['offerPrice']): ?>
									      <p class="oldprice">
									   		<span id="cart_strikedcost" class="order-price price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
									   		</p>
                    <?php endif; ?>
									<span id="cart_subTotal" class="order-price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
							   	</div>
                  <?php if(!empty($cart_product['promoName'])) { ?>
          <div style="clear: left;">
            <strong><?php echo t('Promo Applied:');?> </strong>
            <span ><?php echo $cart_product['promoName'] ?></span>
          </div>
      <?php } ?>
		                    	</div>
								
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="shp-crt-info">

      <?php $promoTotalAmount = getTotalPromoAmount($cartItems) ;?>
      <strong><?php echo t('Sub Total:'); ?> </strong>
          <span>$ <?php echo format_money($cart['shoppingCartItemTotal']) ?></span>
          <?php if(!empty($promoTotalAmount)) { ?>

          <strong><?php echo t('Promo Discount:'); ?> </strong>
          <span>- $ <?php echo format_money($promoTotalAmount) ?></span>

      <?php } ?>

					<!--<strong><?php echo t('Tax collected:'); ?></strong>
      <strong>Sub Total: </strong>
          <span>$ <?php echo format_money($cart['cartSubTotal'] + $promoTotalAmount) ?></span>
          <span>$ <?php echo format_money($cart['cartSubTotal']) ?></span>
          <?php if(!empty($promoTotalAmount)) { ?>

          <strong>Promo Discount: </strong>
          <span> $ <?php echo format_money($promoTotalAmount) ?></span>

      <?php } ?>-->

        <?php if(!empty($cart['couponCode'])) { ?>
        <strong><?php echo t('Coupon Discount:');?> </strong>
        <span>$ <?php echo format_money($cart['couponValue']) ?></span>
        <?php } ?>

        <?php if(isset($cart['LoyaltyAmount'])) { ?>
        <strong>Loyalty Amount:</strong>
         <span>-$ <?php echo format_money($cart['LoyaltyAmount']) ?></span>
        <?php } ?>

    <!--    <?php if(!empty($cart['partyAppliedStoreCreditTotal'])) { ?>
         <strong><?php echo t('storecredit applied:');?></strong>
         <span>-$ <?php echo format_money($cart['partyAppliedStoreCreditTotal'])?></span>
        <?php } ?>  -->

					<strong><?php echo t('Tax collected:');?></strong>
 					<span>$ <?php echo format_money($cart['salesTax']) ?></span>

          <strong><?php echo t('Shipping Charges:'); ?></strong>-
          <span>$ <?php echo format_money($cart['orderShippingTotal']) ?></span>


			</div>

			<div class="shp-crt-info mt10">
				<div class="ch-pay-box"><?php echo t('Payable Amount'); ?></div>
					<div class="ch-pay-price" id="grandTotal">
							<span>$ <?php echo format_money($cart['orderGrandTotal']) ?></span>
					</div>
				</div>

			</div>
		</form></div>
<!-- End Template component://osafe/webapp/osafe/common/cart/cartInformation.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressCartInfo -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressPreviousButton -->
<!-- Begin Template component://osafe/webapp/osafe/common/cart/previousCartButton.ftl -->
  <div class="action previousButton shippingAddressPreviousButton">
    <a href="<?php echo url() ?>" class="standardBtn positive"><span><?php echo t('Continue Shopping'); ?></span></a>
  </div>

<!-- End Template component://osafe/webapp/osafe/common/cart/previousCartButton.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressPreviousButton -->



<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#shippingAddressDivSequence -->

    <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_SHIPPING_ADDRESS -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="pesShippingAddress" class="pesSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_SHIPPING_ADDRESS -->



<!-- Begin Screen component://osafe/widget/EntryScreens.xml#capturePlusJs -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/js/capturePlusJs.ftl -->
<!-- End Template component://osafe/webapp/osafe/common/entry/js/capturePlusJs.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#capturePlusJs -->

<!-- End Template component://osafe/webapp/osafe/templates/commonCheckout.ftl -->
</div>