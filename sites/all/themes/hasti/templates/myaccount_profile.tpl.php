<?php krumo($profile);?>
<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <h3>Personal Information</h3>
  <div class="outerbox">
    <div class="form-wrap">
      <div class="form-row">
        <label>First Name</label>
        <input type="text" value="<?php echo $profile['firstName'];?>" disabled="disabled">
      </div>
      <div class="form-row">
        <label>Last Name</label>
        <input type="text" value="<?php echo $profile['lastName'];?>" disabled="disabled">
      </div>
      <div class="form-row">
        <label>Gender</label>
        <input type="text" value="<?php echo $profile['gender'];?>" disabled="disabled">
      </div>
      <div class="btns-wrap">
        <a href="#" data-ajax="false"class="basic-btn">Edit</a>
      </div>
    </div>
  </div>
</div>