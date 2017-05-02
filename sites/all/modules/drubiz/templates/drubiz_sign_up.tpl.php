<div id="eCommerceSignUpContainer">
  <div id="chckout">
    <div class="col-md-12 sign-up-form">
      <div class="col-xs-12 col-sm-2 col-md-2"></div>
      <div class="col-xs-12 col-sm-8 col-md-8 signupform">
        <div class="col-md-12 chckheader">
          <h1><?php echo t('SIGN UP');?></h1>
          <p>Already Registered? <a href="<?php echo url('weaving/signin') ?>"><?php echo t('SIGN IN');?></a></p>
        </div>
        <div class="col-md-12 margin_signup indus-pd0">
          <form method="post" action="<?php echo url('drubiz/user-register') ?>" name="loginform" class="entryForm" onsubmit="submitForm(this)">
            <div class="col-md-12 signuptext"><span class="formfeilds"> 
              <i class="fa fa-user icon-align"></i>
              <input type="text" maxlength="100" name="firstName" id="firstName" value="" placeholder="* <?php echo t('FIRST NAME');?>">
              </span>
            </div>
            <div class="col-md-12 signuptext"><span class="formfeilds"> 
              <i class="fa fa-user icon-align"></i>
              <input type="text" maxlength="100" name="lastName" id="lastName" value="" placeholder="* <?php echo t('LAST NAME');?>">
              </span>
            </div>
            <div class="col-md-12 signuptext"><span class="formfeilds"> 
              <i class="fa fa-mobile icon-align"></i>
              <input type="text" maxlength="10" id="PHONE_MOBILE_CONTACT_OTHER" name="PHONE_MOBILE_CONTACT_OTHER" value="" placeholder="* <?php echo t('MOBILE');?>">
              </span>
            </div>
            <div class="col-md-12 signuptext"><span class="formfeilds">
              <i class="fa fa-envelope icon-align"></i>
              <input id="customerEmail" name="userLoginId" type="text" value="" maxlength="200" placeholder="* <?php echo t('EMAIL ID')?>">
              </span>
            </div>
            <div class="col-md-12 signuptext"><span class="formfeilds">
              <i class="fa fa-key icon-align"></i>
              <input id="password" name="currentPassword" type="password" class="password" value="" maxlength="50" placeholder="* <?php echo t('PASSWORD');?>">
              </span>
            </div>
            <div class="col-md-12 signuptext"><span class="formfeilds">
              <i class="fa fa-key icon-align"></i>
              <input id="password" name="currentPasswordVerify" type="password" class="password" value="" maxlength="50" placeholder="* <?php echo t('RE- ENTER');?>">
              </span>
            </div>
            <div class="buttonsdiv">
              <div class="col-md-12  continueBtn_aline">
                <input type="button" id ="signup_btn" class="button red auto signupcontinuebutton standardBtn " name="continueBtn" value="<?php echo t('SIGN UP');?>">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-xs-12 col-sm-2 col-md-2"></div>
    </div>
  </div>
</div>