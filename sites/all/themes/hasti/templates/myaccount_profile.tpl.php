<?php //krumo($profile);?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <h3>Personal Information</h3>
  <div class="outerbox">
   <div class="success-msg" style="display: none">
    Succesfully Updated
   </div> 
    <div class="form-wrap" id="addpersonalinfo">
      <div class="form-row">
        <label>First Name</label>
        <input type="text" id="firstName" value="<?php echo $profile['firstName'];?>" >
      </div>
      <div class="form-row">
        <label>Last Name</label>
        <input type="text" id="lastName" value="<?php echo $profile['lastName'] ;?>" >
      </div>
      <div class="form-row">
        <label>Gender</label>
        <select id="gender">
          <option value="">Select One..</option>
          <option value="M" <?php if($profile['gender'] == 'M') :?> selected <?php endif;?>>Male</option>
          <option value="F" <?php if($profile['gender'] == 'F') :?> selected <?php endif;?>>Female</option>
        </select>
      </div>
      <div class="form-row">
        <label>Email Id</label>
        <input type="text" value="<?php echo $profile['emailAddress'];?>" disabled="disabled">
      </div>
      <div class="form-row">
        <label>Phone Number</label>
        <input type="text" id="phoneNumber" maxlength="10" value="<?php echo $profile['mobileNumber'];?>" >
      </div>
      <div class="btns-wrap">
        <a href="javascript:savePersonalInfo()" data-ajax="false"class="basic-btn">Save</a>
      </div>
    </div>
  </div>
</div>