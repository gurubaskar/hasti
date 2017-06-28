<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2><?php echo t('Contact Information');?></h2>
    </div>
    <div>
      <input type="text" maxlength="20" class="" name="firstname" id="firstname" placeholder="First Name" value="<?php echo $addr['toName'];?>">
      <input type="text" maxlength="20" class="" name="lastname" id="lastname" placeholder="Last Name">
      <input type="text" name="address1" id="address1" placeholder="Address Line 1" value="<?php echo $addr['address1'];?>">
      <input type="text" name="address2" id="address2" placeholder="Address Line 2" value="<?php echo $addr['address2'];?>">
      <input type="text" name="city" id="city" placeholder="City" value="<?php echo $addr['city'];?>">
      <input type="text" name="state" id="state" placeholder="State" value="Karnataka">
      <input type="text" name="country" placeholder="Country" class="disable" value="India">
      <input type="text" maxlength="6" name="zipcode" id="zipcode" placeholder="Zipcode" value="<?php echo $addr['postalCode'];?>">
      <input type="text" maxlength="10" name="mobile" id="mobile" placeholder="Mobile" value="<?php echo $addr['contactNumber'];?>">
      <div class="btns-wrap">
        <a href="#" class="buy-now" onclick="editAddress()">Update</a>
      </div>
    </div>
  </div>
</div>

