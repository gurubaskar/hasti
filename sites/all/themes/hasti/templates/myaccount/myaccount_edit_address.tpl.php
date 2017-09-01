<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
<form method="post" action="<?php echo url('drubiz/add-address') ?>" id="editaddressForm" name="editaddressForm">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2><?php echo t('Edit Address');?></h2>
    </div>
    <div id="signup_errormsgs" style=""></div>
    <div class="outerbox">
      <div class="form-wrap">
        <style type="text/css">.ui-select {position: static;}</style>
        <div id="editNewAddress" name="editNewAddress">
          <?php
            $toName = explode(" ", $addr['toName']);
            $state = getState();
            $stateList = $state['stateList'];
          ?>
          <div class="form-row">
            <label><span class="required">*</span>First Name</label>
            <input type="text" maxlength="20" class="" name="firstname" id="firstname" value="<?php echo $toName[0];?>"  data-msg-required="FirstName can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>Last Name</label>
            <input type="text" maxlength="20" class="" name="lastname" id="lastname" value="<?php echo $toName[1];?>" data-msg-required="Lastname can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>Address 1</label>
            <input type="text" name="address1" id="address1" value="<?php echo $addr['address1'];?>" data-msg-required="Address1 can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>Address 2</label>
            <input type="text" name="address2" id="address2" value="<?php echo $addr['address2'];?>" data-msg-required="Address2 can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>City</label>
            <input type="text" name="city" id="city" value="<?php echo $addr['city'];?>" data-msg-required="City can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>State</label>
            <select name="state" id="state">
              <?php foreach ($stateList as $key => $value) { 
                $checked = '';
                if($addr['stateProvinceGeoId'] == $value['geoId']){
                  $checked = "selected";
                }
              ?>
              <option value="<?php echo $value['geoId']?>" <?php echo $checked;?>><?php echo $value['geoName']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-row">
            <label>Country</label>
            <input type="text" name="country" class="disabled-text" value="India" disabled>
          </div>
          <div class="form-row">
            <label><span class="required">*</span>Zip Code</label>
            <input type="hidden" name="addressid" class="" value="<?php echo $addr['contactMechId'];?>">
            <input type="text" maxlength="6" name="zipcode" id="zipcode" value="<?php echo $addr['postalCode'];?>"  data-msg-required="Zipcode can't be Empty" data-rule-required="true">
          </div>
          <div class="form-row">
            <label><span class="required">*</span>Mobile</label>
            <input type="text" maxlength="10" name="mobile" id="mobile" value="<?php echo $addr['contactNumber'];?>" data-msg-required="The Mobile number is required." id="" data-rule-required="true" data-rule-number="true" data-rule-minlength="10">
          </div>
          <div class="btns-wrap">
            <!--a href="#" class="buy-now" onclick="editAddress()">Update</a-->
            <input type="submit" value="Update" class="basic-btn" >
            <a href="<?php echo url('account/address-book');?>" class="">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</div>

