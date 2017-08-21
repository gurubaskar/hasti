<?php //krumo($profile);?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<form method="post" action="<?php echo url('account/save-profile') ?>" id="personalinfoForm" name="personalinfoForm">
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <h3>Personal Information</h3>
  <div class="outerbox">
   <div class="success-msg" style="display: none">
    Succesfully Updated
   </div> 
   <div id="signup_errormsgs" style=""></div>
    <div class="form-wrap" id="addpersonalinfo">
      <div class="form-row">
        <label><span class="required">*</span>First Name</label>
        <input type="text" id="firstName" value="<?php echo $profile['firstName'];?>" data-msg-required="FirstName can't be Empty" id="" data-rule-required="true">
      </div>
      <div class="form-row">
        <label><span class="required">*</span>Last Name</label>
        <input type="text" id="lastName" value="<?php echo $profile['lastName'] ;?>" data-msg-required="lastName can't be Empty" id="" data-rule-required="true">
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
        <label><span class="required">*</span>Email Id</label>
        <input type="text" value="<?php echo $profile['emailAddress'];?>" disabled="disabled" data-msg-required="The Email Id is required." id="" data-rule-required="true" data-rule-email="true">
      </div>
      <div class="form-row">
        <label><span class="required">*</span>Phone Number</label>
        <input type="text" id="phoneNumber" maxlength="10" value="<?php echo $profile['mobileNumber'];?>" data-msg-required="The Mobile number is required." id="" data-rule-required="true" data-rule-number="true" data-rule-minlength="10">
      </div>
      <div class="btns-wrap">
      <input type="submit" value="Save" class="basic-btn" id="personalinfo">
        <!--a href="javascript:savePersonalInfo()" data-ajax="false" class="basic-btn">Save</a-->
      </div>
    </div>
  </div>
</div>
</form>