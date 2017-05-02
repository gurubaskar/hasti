<?php //krumo($profile) ?>
 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceEditCustomerInfoContainer" class="orderDetail-layout">
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_PERSONAL_INFO -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="ptsPersonalInfo" class="ptsSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_PERSONAL_INFO -->
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

<form method="post" class="entryForm" action="/validateUpdateCustomer" id="checkout" name="checkout">
    <input type="hidden" name="csrfPreventionSalt" value="ppimfOxuLY4xsRXXcOrZ">
    <input type="hidden" name="partyId" value="10230">
    <input type="hidden" name="productStoreId" value="GS_STORE">
    <!-- Begin Screen component://osafe/widget/EntryScreens.xml#aboutYouEntryForm -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/aboutYouEntry.ftl -->
<script type="text/javascript">
    jQuery(document).ready(function () {
    	getAddressFormat("USER");
    	
  		//Check if country is available according to DIV sequencing strategy
  		//If NOT we need to add a hidden jquery field to handle processing on the back end and jquery getPostalAdress method (formEntryJS.ftl)
  		//In this case Country is set to system parameter COUNTRY_DEFAULT
	  	if (jQuery('#js_PERSONAL_ADDRESS_ENTRY').length)
	  	{
	  		if (jQuery('#js_PERSONAL_COUNTRY').length)
	  		{
	  			//Country will be processed as normal
	  		}
	  		else
	  		{
	  			//When only one country is supported (Country Div is hidden or Drop Down is not displayed)
	      		var defaultCountryValue = "IND";
	  			jQuery('<input>').attr({
				    type: 'hidden',
				    id: 'js_PERSONAL_COUNTRY',
				    name: 'PERSONAL_COUNTRY',
				    value: ''+defaultCountryValue+''
				}).appendTo('#js_PERSONAL_ADDRESS_ENTRY');
				jQuery('#js_PERSONAL_COUNTRY').val(defaultCountryValue);
				updateShippingOption('N');
	  		}
	  		
	  		//When country is changed get the list of available state/province geo. 
	        if (jQuery('#js_PERSONAL_COUNTRY')) 
	        {
	            if(!jQuery('#PERSONAL_STATE_LIST_FIELD').length) 
	            {
	                getAssociatedStateList('js_PERSONAL_COUNTRY', 'js_PERSONAL_STATE', 'advice-required-PERSONAL_STATE', 'PERSONAL_STATES');
	            }
	            getAddressFormat("PERSONAL");
	            jQuery('#js_PERSONAL_COUNTRY').change(function()
	            {
	                getAssociatedStateList('js_PERSONAL_COUNTRY', 'js_PERSONAL_STATE', 'advice-required-PERSONAL_STATE', 'PERSONAL_STATES');
	                getAddressFormat("PERSONAL");
	            });
	        }
	  	}
	  	
	  	
    });
</script><input type="hidden" name="USER_COUNTRY" id="js_USER_COUNTRY" value="IND">
<input type="hidden" id="js_PERSONALAddressContactMechId" name="PERSONALAddressContactMechId" value="10762">
<input type="hidden" id="PERSONALHomePhoneContactMechId" name="PERSONALHomePhoneContactMechId" value="">
<input type="hidden" id="PERSONALMobilePhoneContactMechId" name="PERSONALMobilePhoneContactMechId" value="">
<input type="hidden" id="PERSONAL_ADDRESS_ALLOW_SOL" name="PERSONAL_ADDRESS_ALLOW_SOL" value="N">
<input type="hidden" name="PERSONAL_USE_SCREEN" value="PERSONAL">
<div id="logintit4">
			<h1> <?php echo t('Edit Account Information');?></h1>
<div class="eCommerceEditCustomerInfo-headerr"></div>
	</div>
<div id="aboutYouEntry" class="displayBox">
<h2 class="MyAccount-subhead"><?php echo t('Account Information');?></h2>		<!-- added on 22-06 -->
     <!--<h3>About You</h3>
     <p class="instructions">Any information with an asterisk <span class="required">*</span> is required.</p>-->
     
     <!-- DIV for Displaying Person info STARTS here -->
    <div class="personInfo">
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoFirstName -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoFirstName.ftl -->
<div>

     <div class="basic-grey myaccountfirstname">		<!-- added on 22-06 -->
      <label for="USER_FIRST_NAME">
      <span><span class="required">*</span>
<?php echo t('First Name:');?></span>
          <input type="text" maxlength="20" name="USER_FIRST_NAME" id="js_USER_FIRST_NAME" value="<?php echo $profile['firstName'] ?>">
	      <input type="hidden" name="USER_FIRST_NAME_MANDATORY" value="Y">
	      </label>
      </div><!-- End Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoFirstName.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoFirstName -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoLastName -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoLastName.ftl -->
<div class="basic-grey myaccountlastname">		<!-- added on 22-06 -->
      <label for="USER_LAST_NAME">
      	<span><span class="required">*</span>
<?php echo t('Last Name:');?></span>
      
	      <input type="text" maxlength="20" name="USER_LAST_NAME" id="js_USER_LAST_NAME" value="<?php echo $profile['lastName'] ?>">
	      <input type="hidden" name="USER_LAST_NAME_MANDATORY" value="Y">
     </label>
</div>
<!-- End Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoLastName.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoLastName -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoDateOfBirthMMDDYYYY -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoDobMMDDYYYY.ftl -->

<?php if (FALSE): ?>

  <div class="entry dateOfBirthMMDDYYYY myAccountPersonalInfoDateOfBirthMMDDYYYY">
        <label for="DOB_MMDDYYYY"><span class="required">*</span>
  <?php echo t('Date Of Birth:');?></label>
        <div class="entryField dateoFBirthValiadtion">
  	      <select id="dobLongDayUs" name="dobLongDayUs" class="dobDay" readonly="readonly">
  	          <option value="31">31</option>
  	       <option value="">Day</option>
  	        <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ddDays -->
  <!-- Begin Template component://osafe/webapp/osafe/common/ddDays.ftl -->
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  <!-- End Template component://osafe/webapp/osafe/common/ddDays.ftl -->
  <!-- End Screen component://osafe/widget/CommonScreens.xml#ddDays -->

  	      </select>
  	      <select id="dobLongMonthUs" name="dobLongMonthUs" class="dobMonth" readonly="readonly">
  	      <option value="10">10</option>
  	       <option value="">Month</option>
  	        <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ddMonths -->
  <!-- Begin Template component://osafe/webapp/osafe/common/ddMonths.ftl -->
  <option value="01">01</option>
  <option value="02">02</option>
  <option value="03">03</option>
  <option value="04">04</option>
  <option value="05">05</option>
  <option value="06">06</option>
  <option value="07">07</option>
  <option value="08">08</option>
  <option value="09">09</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <!-- End Template component://osafe/webapp/osafe/common/ddMonths.ftl -->
  <!-- End Screen component://osafe/widget/CommonScreens.xml#ddMonths -->

  	      </select>
  	      <select id="dobLongYearUs" name="dobLongYearUs" class="dobYear" readonly="readonly">
  	          <option value="1990">1990</option>
  	        <option value="">Year</option>
  	        <!-- Begin Screen component://osafe/widget/CommonScreens.xml#ddYears -->
  <!-- Begin Template component://osafe/webapp/osafe/common/ddYears.ftl -->

      <option value="1998">1998</option>
      <option value="1997">1997</option>
      <option value="1996">1996</option>
      <option value="1995">1995</option>
      <option value="1994">1994</option>
      <option value="1993">1993</option>
      <option value="1992">1992</option>
      <option value="1991">1991</option>
      <option value="1990">1990</option>
      <option value="1989">1989</option>
      <option value="1988">1988</option>
      <option value="1987">1987</option>
      <option value="1986">1986</option>
      <option value="1985">1985</option>
      <option value="1984">1984</option>
      <option value="1983">1983</option>
      <option value="1982">1982</option>
      <option value="1981">1981</option>
      <option value="1980">1980</option>
      <option value="1979">1979</option>
      <option value="1978">1978</option>
      <option value="1977">1977</option>
      <option value="1976">1976</option>
      <option value="1975">1975</option>
      <option value="1974">1974</option>
      <option value="1973">1973</option>
      <option value="1972">1972</option>
      <option value="1971">1971</option>
      <option value="1970">1970</option>
      <option value="1969">1969</option>
      <option value="1968">1968</option>
      <option value="1967">1967</option>
      <option value="1966">1966</option>
      <option value="1965">1965</option>
      <option value="1964">1964</option>
      <option value="1963">1963</option>
      <option value="1962">1962</option>
      <option value="1961">1961</option>
      <option value="1960">1960</option>
      <option value="1959">1959</option>
      <option value="1958">1958</option>
      <option value="1957">1957</option>
      <option value="1956">1956</option>
      <option value="1955">1955</option>
      <option value="1954">1954</option>
      <option value="1953">1953</option>
      <option value="1952">1952</option>
      <option value="1951">1951</option>
      <option value="1950">1950</option>
      <option value="1949">1949</option>
      <option value="1948">1948</option>
      <option value="1947">1947</option>
      <option value="1946">1946</option>
      <option value="1945">1945</option>
      <option value="1944">1944</option>
      <option value="1943">1943</option>
      <option value="1942">1942</option>
      <option value="1941">1941</option>
      <option value="1940">1940</option>
      <option value="1939">1939</option>
      <option value="1938">1938</option>
      <option value="1937">1937</option>
      <option value="1936">1936</option>
      <option value="1935">1935</option>
      <option value="1934">1934</option>
      <option value="1933">1933</option>
      <option value="1932">1932</option>
      <option value="1931">1931</option>
      <option value="1930">1930</option>
      <option value="1929">1929</option>
      <option value="1928">1928</option>
      <option value="1927">1927</option>
      <option value="1926">1926</option>
      <option value="1925">1925</option>
      <option value="1924">1924</option>
      <option value="1923">1923</option>
      <option value="1922">1922</option>
      <option value="1921">1921</option>
  <!-- End Template component://osafe/webapp/osafe/common/ddYears.ftl -->
  <!-- End Screen component://osafe/widget/CommonScreens.xml#ddYears -->

  	      </select>
  	      <input type="hidden" name="DOB_MMDDYYYY_MANDATORY" value="Y">
        </div>
  </div>

  <!-- End Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoDobMMDDYYYY.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoDateOfBirthMMDDYYYY -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoPhoneCell -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoPhoneCell.ftl -->

<div class="entry phoneCell myAccountPersonalInfoPhoneCell">
    <input type="hidden" name="mobilePhoneContactMechId" value="10732">
      <label for="PHONE_MOBILE_CONTACT"><span class="required">*</span>
Mobile:</label>
      <div class="entryField telephone">
        <span class="js_USER_USA js_USER_CAN" style="display: none;">
            <input type="text" class="phone3" id="PHONE_MOBILE_AREA" name="PHONE_MOBILE_AREA" maxlength="3" value="">
            <input type="hidden" id="PHONE_MOBILE_CONTACT" name="PHONE_MOBILE_CONTACT" value="9916574985">
            <input type="hidden" id="PHONE_MOBILE_MANDATORY" name="PHONE_MOBILE_MANDATORY" value="Y">
            <input type="text" class="phone3" id="PHONE_MOBILE_CONTACT3" name="PHONE_MOBILE_CONTACT3" value="991" maxlength="3">
            <input type="text" class="phone4" id="PHONE_MOBILE_CONTACT4" name="PHONE_MOBILE_CONTACT4" value="6574" maxlength="4">
            <span class="entryHelper"> </span>
        </span>
        <span style="" class="js_USER_OTHER">
            <input type="text" readonly="readonly" maxlength="10" class="phone10" id="PHONE_MOBILE_CONTACT_OTHER" name="PHONE_MOBILE_CONTACT_OTHER" value="9916574985">
            <span class="entryHelper"> </span>
            <input type="hidden" name="PHONE_MOBILE_CONTACT_OTHER_MANDATORY" value="Y">
        </span>
      </div>
</div><!-- End Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoPhoneCell.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoPhoneCell -->

	            
	            
	            <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoGender -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoGender.ftl -->
<div class="entry gender myAccountPersonalInfoGender">
      <label for="USER_GENDER"><span class="required">*</span>
Gender:</label>
      <div class="entryField genderValidation">
	      <select name="USER_GENDER" id="USER_GENDER">
	        <option value="">Select One... </option>
	        <option value="M">Male</option>
	        <option value="F">Female</option>
	      </select>
	      <input type="hidden" name="USER_GENDER_MANDATORY" value="Y">
      </div>
</div>
<!-- End Template component://osafe/webapp/osafe/common/entry/personInfo/personInfoGender.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoGender -->



<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#myAccountPersonalInfoDivSequence -->

<?php endif; ?>


    </div>
    <!-- DIV for Displaying Person Info ENDS here -->  
</div>
<!-- End Template component://osafe/webapp/osafe/common/entry/aboutYouEntry.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#aboutYouEntryForm -->

    <!-- Begin Screen component://osafe/widget/EntryScreens.xml#formEntryContinueBackButton -->
<!-- Begin Template component://osafe/webapp/osafe/common/entry/formEntryContinueBackButton.ftl -->
<div class="changePersInfo">
<div class="container mcontainer">
			<a class="standardBtn" href="/eCommerceAccountDashboardInfo"><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></a>
    	<a href="#" class="button red auto button_aline" id="js_submitProfileBtn"><?php echo t('Save');?></a>

</div>
</div>
<script>

 function checkEmailPass(){
   document.getElementById("forgotAlertsucess").style.display="none";
   var status="false";
   jQuery( "#forgotPassAlert" ).empty();
   var email=jQuery("#forgotEmailId").val();
 	    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(email==""){
			document.getElementById("forgotPassAlert").innerText = "Please Enter your Email";
			return false;
		}
		if (!filter.test(email)) {
			document.getElementById("forgotPassAlert").innerText = "Please enter a valid email address";
			return false;
		}
		jQuery.ajax({
			url :"validateForgotPassword",
		type:"POST",
			data:{"USERNAME":email,"EMAIL_PASSWORD":"Y"},
		success:function(data, textStatus, jqXHR)

	{
jQuery.each(data, function(property, value) {
		if(property == "_ERROR_MESSAGE_LIST_"){
		status="true";
		jQuery.each( value, function( key, value ) {
  			document.getElementById("forgotPassAlert").innerText=value.message;
  			return false;
		});
		}
        if(property == "targetRequestUri"){
        status="true";
        }
        if(property == "_CONTEXT_ROOT_"){
        status="true";
        }
        if(property == "_FORWARDED_FROM_SERVLET_"){
        status="true";
        }
        if(property == "_SERVER_ROOT_URL_"){
        status="true";
        }
        if(property == "_CONTROL_PATH_"){
        status="true";
        }
        if(property == "thisRequestUri"){
        status="true";
        }
        if(status=="false"){
         jQuery("#forgotEmailId").val("");
         jQuery("#forgotAlertsucessMsg").css("display","block");
         return false;
        }

        });
        }
	});
   }
</script><!-- End Template component://osafe/webapp/osafe/common/entry/formEntryContinueBackButton.ftl -->
<!-- End Screen component://osafe/widget/EntryScreens.xml#formEntryContinueBackButton -->

    

<!-- End Template component://osafe/webapp/osafe/templates/commonEntryForm.ftl -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_PERSONAL_INFO -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="pesPersonalInfo" class="pesSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_PERSONAL_INFO -->
</div></form></div>
</div></div>