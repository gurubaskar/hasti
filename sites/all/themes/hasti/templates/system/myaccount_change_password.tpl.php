<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
<h3>Change Password</h3>
<div id="content">
<form method="post" action="<?php echo url('drubiz/user-change-password') ?>" id="changepwdForm" name="changepwdForm">
  <div class="container-fluid change-pwd">
    <div data-role="" id="changepwd">
      <h3>Change Password</h3>
      <div id="signup_errormsgs" style=""></div>
      <input type="password" maxlength="30" class="password" name="OLD_PASSWORD" id="OLD_PASSWORD" value="" placeholder="* Current Password" data-msg-required="Current Password is required." id="" data-rule-required="true">
      <input type="password" maxlength="30" class="password" name="NEW_PASSWORD" id="PASSWORD" value="" placeholder="* New Password" data-msg-required="New Password is required." id="" data-rule-required="true">
      <input type="password" maxlength="30" class="password" name="CONFIRM_PASSWORD" id="CONFIRM_PASSWORD" value="" placeholder="* Confirm Password" data-msg-required="Confirm Password is required." id="" data-rule-required="true">
      <div class="forgot-btn">
        <!--input type="button" value="Save" id="js_submitChangePasswdBtn"-->
        <input type="submit" value="Save" id="js_submitChangePasswdBtn">
      </div>
    </div>
  </div>
</form>
</div>
</div>