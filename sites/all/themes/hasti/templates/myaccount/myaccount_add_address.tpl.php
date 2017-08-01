<div class="col-xs-12 col-sm-4 col-md-3">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2><?php echo t('Add Address');?></h2>
    </div>
    <div class="outerbox">
      <div class="form-wrap">
        <style type="text/css">.ui-select {position: static;}</style>
        <div id="addNewAddress" name="addNewAddress">
          <?php
            $state = getState();
            $stateList = $state['stateList'];
          ?>
          <div class="form-row">
            <label>First Name</label>
            <input type="text" maxlength="20" class="" name="firstname" id="firstname">
          </div>
          <div class="form-row">
            <label>Last Name</label>
            <input type="text" maxlength="20" class="" name="lastname" id="lastname">
          </div>
          <div class="form-row">
            <label>Address 1</label>
            <input type="text" name="address1" id="address1">
          </div>
          <div class="form-row">
            <label>Address 2</label>
            <input type="text" name="address2" id="address2">
          </div>
          <div class="form-row">
            <label>City</label>
            <input type="text" name="city" id="city">
          </div>
          <div class="form-row">
            <label>State</label>
            <select name="state" id="state">
            <?php foreach ($stateList as $key => $value) { ?>
              <option value="<?php echo $value['geoId']?>"><?php echo $value['geoName']?></option>
            <?php } ?>
            </select>
          </div>
          <div class="form-row">
            <label>Country</label>
            <input type="text" name="country" class="disabled-text" value="India" disabled>
          </div>
          <div class="form-row">
            <label>Zipcode</label>
            <input type="text" maxlength="6" name="zipcode" id="zipcode">
          </div>
          <div class="form-row">
            <label>Mobile</label>
            <input type="text" maxlength="10" name="mobile" id="mobile">
          </div>
          <div class="btns-wrap">
            <a href="#" class="buy-now" onclick="addAddress()">Save</a>
            <a href="<?php echo url('account/address-book');?>" class="">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>