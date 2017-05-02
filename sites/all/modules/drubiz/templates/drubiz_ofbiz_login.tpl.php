<?php if (drubiz_user_is_demo_administrator()): ?>
  <form target="_blank" id="drubiz-back-end-login-form" method="post" action="<?php echo DRUBIZ_DEMO_OFBIZ_URL ?>ecomadmin/control/login">
    <input name="USERNAME" value="<?php echo $GLOBALS['user']->mail ?>" type="hidden">
    <input name="PASSWORD" value="<?php echo drubiz_demo_password($GLOBALS['user']->mail) ?>" type="hidden">
    <input name="loginBtn" value="<?php echo t('OMS Admin Login') ?>" type="submit">
  </form>
<?php endif; ?>
