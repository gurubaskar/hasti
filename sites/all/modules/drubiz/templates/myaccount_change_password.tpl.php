 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceEditCustomerInfoContainer" class="orderDetail-layout">
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_LOGIN_INFO -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="ptsLoginInfo" class="ptsSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_LOGIN_INFO -->
<!-- Begin Template component://osafe/webapp/osafe/templates/commonEntryForm.ftl -->
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

<form method="post" class="entryForm" action="/validateCustomerPassword" id="customerPasswordForm" name="customerPasswordForm">
    <input type="hidden" name="csrfPreventionSalt" value="KOlfhO4YxGLCaQ9coHfN">
    <input type="hidden" name="partyId" value="10230">
    <input type="hidden" name="productStoreId" value="GS_STORE">
    <!-- Begin Screen component://osafe/widget/EntryScreens.xml#customerPasswordEntryForm -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/userLoginInfo/customerPasswordEntry.ftl -->
<input type="hidden" name="partyId" value="10230">
<div id="emailPasswordEntry" class="displayBox">
    <h1><?php echo t('Change Password');?></h1>
    <div class="eCommerceEditCustomerInfo-headerr"></div>
    <h2 class="MyAccount-subhead"><?php echo t('Account Information');?></h2>
   <!--Added by Krishnamohan  --> 
    <div class="change-pwd">
      <label><?php echo t('Email Address:');?></label>
      <span><?php echo $GLOBALS['user']->mail ?></span>
    </div>  
   
       <div class="basic-grey">
          <label for="OLD_PASSWORD"><span><span class="required">*</span>
<?php echo t('Current Password:');?></span>        
            <input type="password" maxlength="60" class="password" name="OLD_PASSWORD" id="OLD_PASSWORD" value="">
          </label>
        </div>
       <div class="myaccounttextboxes">
      <div class="basic-grey myaccountnewpwd">    <!-- added on 22-06 -->
        <label for="PASSWORD">   <span><span class="required">*</span>
<?php echo t('New Password:');?></span>

          <input type="password" maxlength="60" class="password" name="NEW_PASSWORD" id="PASSWORD" value="">
          <span class="entryHelper">
          
          </span>
       </label>
      </div>

      <div class="basic-grey myaccountconfirmpwd">    <!-- added on 22-06 -->
        <label for="CONFIRM_PASSWORD"><span><span class="required">*</span>
<?php echo t('Confirm Password:');?></span>

          <input type="password" maxlength="60" class="password" name="CONFIRM_PASSWORD" id="CONFIRM_PASSWORD" value="">
       </label>
      </div>
      </div>
<!--<p class="instructions">Any information with an asterisk <span class="required">*</span> is required.</p>-->
  <p class="instructions">*<?php echo t('Required Fields');?></p>    <!-- added on 22-06 -->
</div>
<!-- End Template component://osafe/webapp/osafe/common/entry/userLoginInfo/customerPasswordEntry.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#customerPasswordEntryForm -->

    <!-- Begin Screen component://osafe/widget/EntryScreens.xml#formEntryBackButton -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/formEntryBackButton.ftl -->
<div class="changePersInfo">
<div class="container mcontainer">
      <a class="standardBtn" href="<?php echo url('account/dashboard') ?>"><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></a> <!-- added on 22-06 -->
      <a href="#" id="js_submitChangePasswdBtn" class="button red auto button_aline"><?php echo t('Save');?></a>  
</div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/formEntryBackButton.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#formEntryBackButton -->

    
</form>
<!-- End Template component://osafe/webapp/osafe/templates/commonEntryForm.ftl -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_LOGIN_INFO -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="pesLoginInfo" class="pesSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_LOGIN_INFO -->
</div>
</div></div>