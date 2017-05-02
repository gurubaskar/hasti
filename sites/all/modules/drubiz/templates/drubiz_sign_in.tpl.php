<div class="col-xs-12 col-sm-12 col-md-12 sign-in-form signin">
  <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 signin-bg container existingCustomer signInExistingCustomer">
    <div class="col-xs-12 col-sm-12 col-md-12 displayBox indus-pd0">
      <form method="post" action="<?php echo url('drubiz/user') ?>" id="loginFormMultipage" name="loginform">
        <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 displayActionList container existingCustomer signInExistingCustomer">
          <div class="col-xs-12 col-sm-2 col-md-2"></div>
          <div class="col-xs-12 col-sm-8 col-md-8 signinform">
            <div class="col-xs-12 col-sm-12 col-md-12">
              <h1>
                <?php echo t('SIGN IN');?> 
                <p class="newus">New User? <a href="<?php echo url('weaving/signup') ?>"><?php echo t('SIGN UP');?></a></p>
              </h1>
              <p><?php echo t('Signin using your registered account:');?></p>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 user" id="guest">
              <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0">
                <i class="fa fa-user icon-align"></i>
                <input id="customerEmail" name="USERNAME" type="text" value="" maxlength="200" placeholder="* EMAIL ID" autofocus="">
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0">
                <i class="fa fa-key icon-align"></i>
                <input id="password34" name="PASSWORD" type="password" class="password" value="" maxlength="50" placeholder="* PASSWORD"><br>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 assured">
                <div class="col-xs-8 col-sm-6 col-md-6 indus-pd0">
                  <a class="blue_color" href="https://emarket.thehandloomschool.org/forgotPassword"><?php echo t('Forgot Password?');?></a>
                </div>
                <div class="col-xs-4 col-sm-6 col-md-6 indus-pd0">
                  <!--<a onclick="login()" id="login_btn" type="image" name="login_btn" class="standardBtn action button red_small auto signin_continue">SIGN IN</a>-->
                  <input type="submit" name="login_btn" class="standardBtn action button red_small auto signin_continue" id="login_btn" value=" SIGN IN"/>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 socal ">
              <p><?php echo t('Signin using social network:');?></p>
              <div class="col-xs-6 col-sm-6 col-md-6 fbk">
                <div class="social-facebook">
                  <a class="btn btn-block btn-social btn-facebook" name="windowX" value="FaceBook" onclick="fb_login(); "><i class="fa fa-facebook"></i>
                  <?php echo t('SIGN IN WITH FACEBOOK');?></a> 
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 ggl">
                <div class="social-google">
                  <a class="btn btn-block btn-social btn-google-plus" name="windowX" value="Google" id="signinButton" onclick="_gaq.push([&#39;_trackEvent&#39;, &#39;btn-social&#39;, &#39;click&#39;, &#39;btn-google-plus&#39;]);"><i class="fa fa-google-plus"></i>
                  <?php echo t('SIGN IN WITH GOOGLE');?</a>                     
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-2 col-md-2"></div>
        </div>
      </form>
    </div>
  </div>
</div>