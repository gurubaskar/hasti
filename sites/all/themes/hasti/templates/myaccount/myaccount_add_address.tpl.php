<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2><?php echo t('Add Address');?></h2>
    </div>
    <style type="text/css">.ui-select {position: static;}</style>
    <div id="addNewAddress" name="addNewAddress">
      <?php
        $state = getState();
        $stateList = $state['stateList'];
      ?>
      <input type="text" maxlength="20" class="" name="firstname" id="firstname" placeholder="First Name">
      <input type="text" maxlength="20" class="" name="lastname" id="lastname" placeholder="Last Name">
      <input type="text" name="address1" id="address1" placeholder="Address Line 1">
      <input type="text" name="address2" id="address2" placeholder="Address Line 2">
      <input type="text" name="city" id="city" placeholder="City">
      <select name="state" id="state">
        <?php foreach ($stateList as $key => $value) { ?>
          <option value="<?php echo $value['geoId']?>"><?php echo $value['geoName']?></option>
        <?php } ?>
      </select>
      <input type="text" name="country" placeholder="Country" class="disabled-text" value="India" disabled>
      <input type="text" maxlength="6" name="zipcode" id="zipcode" placeholder="Zipcode">
      <input type="text" maxlength="10" name="mobile" id="mobile" placeholder="Mobile">
      <div class="btns-wrap">
        <a href="#" class="buy-now" onclick="addAddress()">Save</a>
      </div>
    </div>
  </div>
</div>