 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceUpdateAddressBook" class="orderDetail-layout">

<form method="post" class="entryForm" action="<?php echo url('account/submit-add-address'); ?>" id="checkoutInfoForm" name="checkoutInfoForm">

    <div id="js_CUSTOMER_ADDRESS_ENTRY" class="displayBox">
        <div class="eCommerceEditCustomerInfo-headerr"></div> <!-- added on 13-06 -->
        <h2 class="MyAccount-subhead"><?php echo t('Contact Information');?></h2>    <!-- added on 22-06 -->
         <p class="instructions"><?php echo t('This address can now be used as your shipping or delivery address when checking out.');?>
            <br> <?php echo t('Any information with an asterisk');?> <span class="required">*</span> <?php echo t('is required.');?></p>

    <div>
</div>

<div class="basic-grey" id="CUSTOMER_postalcodeId">
        <label for="CUSTOMER_POSTAL_CODE">
            <span><span class="required">*</span>
                <?php echo t('Pin Code:');?></span>
            <div class="entryField">

          <input type="text" maxlength="6" class="contactautosuggest ui-autocomplete-input areapincode" autofill="false" onfocus="controlFocus('pincode');" name="CUSTOMER_POSTAL_CODE" id="js_CUSTOMER_POSTAL_CODE" value="" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
          <input type="hidden" id="CUSTOMER_POSTAL_CODE_MANDATORY" name="CUSTOMER_POSTAL_CODE_MANDATORY" value="Y">
          </div>
        </label>
</div>

<div id="displaynone" class="displaynone">

<div class="entry firstName myAccountAddressBookFirstName">
    <!-- address first name -->
      <label for="CUSTOMER_FIRST_NAME"><span class="required">*</span>
<?php echo t('First Name:');?></label>
      <div class="entryField">
        <input type="text" maxlength="20" class="addressFirstName" name="CUSTOMER_FIRST_NAME" id="js_CUSTOMER_FIRST_NAME" value="">
        <input type="hidden" id="CUSTOMER_FIRST_NAME_MANDATORY" name="CUSTOMER_FIRST_NAME_MANDATORY" value="Y">
      </div>
</div>

<div class="entry lastName myAccountAddressBookLastName">
    <!-- address last name -->
      <label for="CUSTOMER_LAST_NAME"><span class="required">*</span>
<?php echo t('Last Name:');?></label>
      <div class="entryField">
        <input type="text" maxlength="20" class="addressLastName" name="CUSTOMER_LAST_NAME" id="js_CUSTOMER_LAST_NAME" value="">
        <input type="hidden" id="CUSTOMER_LAST_NAME_MANDATORY" name="CUSTOMER_LAST_NAME_MANDATORY" value="Y">
      </div>
</div>
<div class="basic-grey">
    <input type="hidden" name="mobilePhoneContactMechId" value="10732">
      <label for="PHONE_MOBILE_CONTACT">
      <div class="mobile"><span><span class="required">*</span>
 <?php echo t('Mobile:');?></span></div>
      <div class="entryFieldmobile">
        <div style="display:inline;float:left;" class="newwidth">                       
            <modified on="" 14-06="" --="">
        <input type="text" size="2" id="PHONE_MOBILE_LOCAL" name="PHONE_MOBILE_LOCAL" value="+1" readonly="readonly" class="codecontrol" style="width:35px;">
           <input type="text" class="phone10 widthcontrol" pattern=".{10,10}" id="PHONE_MOBILE_CONTACT" maxlength="10" name="PHONE_MOBILE_CONTACT" value="">
          </modified></div>
            <span class="entryHelper"> </span>
            <input type="hidden" name="PHONE_MOBILE_CONTACT_OTHER_MANDATORY" value="Y">

         </div>
      </label>
</div>
<input type="hidden" name="fbDoneAction" value="">

 
<div class="displaynone entry nickname myAccountAddressBookNickname">
          <label for="CUSTOMER_ATTN_NAME"><span class="required">*</span>
            <?php echo t('Address Type:');?>  </label>
          <div class="entryField">
            <input type="text" maxlength="100" class="addressNickName" name="CUSTOMER_ATTN_NAME" id="js_CUSTOMER_ATTN_NAME" value="" placeholder="<?php echo t('Home, Office..');?>">
            <input type="hidden" id="CUSTOMER_ATTN_NAME_MANDATORY" name="CUSTOMER_ATTN_NAME_MANDATORY" value="Y">
          </div>
</div>

<div class="basic-grey">
      <label for="CUSTOMER_ADDRESS1">
        <span><span class="required">*</span>
 <?php echo t('Address:');?></span>
          <div class="entryField">
    <textarea id="js_CUSTOMER_ADDRESS1" name="CUSTOMER_ADDRESS1" class="content characterLimit" cols="35" rows="5" maxlength="255"></textarea>
        <input type="hidden" id="CUSTOMER_ADDRESS1_MANDATORY" name="CUSTOMER_ADDRESS1_MANDATORY" value="Y">
        </div>
      </label>
</div>
<div class="basic-grey myaddresscity">  
    <div id="city">
        <label for="CUSTOMER_CITY">
            <span><span class="required">*</span>
 <?php echo t('City:');?></span>
       <div class="entryField">
      
          <input type="text" maxlength="100" class="contactautosuggest ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true" onfocus="controlFocus('city');" name="CUSTOMER_CITY" id="js_CUSTOMER_CITY" value=""><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
          <input type="hidden" id="CUSTOMER_CITY_MANDATORY" name="CUSTOMER_CITY_MANDATORY" value="Y">
          </div>
           </label>

    </div>
</div>

<div class="basic-grey myaddressstate">   
    <div id="CUSTOMER_STATES" class="state">
        <label for="CUSTOMER_STATE"><span><span class="required">*</span>
 <?php echo t('State:');?></span>
            <span id="advice-required-CUSTOMER_STATE" style="display:none; margin-left:20px; " class="errorMessage">(Required)</span>


        <select id="js_CUSTOMER_STATE" name="CUSTOMER_STATE" class="select CUSTOMER_COUNTRY">
          <?php echo theme('drubiz_us_states') ?>
        </select>
        </label>
        <input type="hidden" id="CUSTOMER_STATE_MANDATORY" name="CUSTOMER_STATE_MANDATORY" value="Y">
            <input type="hidden" id="CUSTOMER_STATE_LIST_FIELD_MANDATORY" name="CUSTOMER_STATE_LIST_FIELD_MANDATORY" value="Y">
            <input type="hidden" id="CUSTOMER_STATE_LIST_FIELD" name="CUSTOMER_STATE_LIST_FIELD" value="">

    </div>
</div>
</div>
<input type="hidden" name="backButton">  
<div class="button_aline_newaddress">
    <a href="<?php echo url('account/address-book') ?>" class="hk_back"><span class="button red auto button_font"><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></span></a>  <!-- added fa-icon on 22-06 -->
    <a onclick="submitAddress('checkoutInfoForm');">
    <span class="button red auto button_font" style="margin-left:5px;" ><?php echo t('Save');?></span></a>
</div>
<input type="hidden" id="js_CUSTOMER_COUNTRY" name="CUSTOMER_COUNTRY" value="IND"></div> 
</form></div>
</div></div>