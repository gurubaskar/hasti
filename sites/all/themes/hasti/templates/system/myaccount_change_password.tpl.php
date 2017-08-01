<div class="col-xs-12 col-sm-4 col-md-3">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
<h3>Change Password</h3>
<div id="content">
  <div class="container-fluid change-pwd">
    <div data-role="" id="changepwd">
      <h3>Change Password</h3>
      <input type="password" maxlength="30" class="password" name="OLD_PASSWORD" id="OLD_PASSWORD" value="" placeholder="* Current Password">
      <input type="password" maxlength="30" class="password" name="NEW_PASSWORD" id="PASSWORD" value="" placeholder="* New Password">
      <input type="password" maxlength="30" class="password" name="CONFIRM_PASSWORD" id="CONFIRM_PASSWORD" value="" placeholder="* Confirm Password">
      <div class="forgot-btn">
        <input type="button" value="Save" id="js_submitChangePasswdBtn">
      </div>
    </div>
  </div>
</div>
</div>