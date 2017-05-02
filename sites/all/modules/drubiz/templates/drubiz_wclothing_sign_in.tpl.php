<div id="eCommeceOuterBasicWrap">
      <div id="eCommerceInnerBasicWrapper">
        <div id="eCommerceContent" class="mainPanel">
          <div id="commonSearchDialog">
            <div id="search_dialog" class="dialogOverlay"></div>
            <div id="search_displayDialog" style="display:none" class="">
              <input type="hidden" name="search_dialogBoxTitle" id="search_dialogBoxTitle" value="">
              <div class="displayBox confirmDialog">
                <h3>Please Confirm</h3>
                <div class="confirmTxt">Please enter a search phrase in the text box and click on the Search icon.</div>
                <div class="container button">
                  <input type="button" class="button red auto" name="noBtn" value="Ok" onclick="javascript:confirmDialogResult('N','search_');">
                </div>
              </div>
            </div>
          </div>
          <div id="pincodeChecker_dialog" class="dialogOverlay"></div>
          <div id="pincodeChecker_displayDialog" style="display:none" class="">
            <input type="hidden" name="pincodeChecker_dialogBoxTitle" id="pincodeChecker_dialogBoxTitle" value="DELIVERY & CoD AVAILABILITY">
            <div id="js_pincodeCheckContainer">
              <div id="pincodeChecker" class="pincodeChecker">
                <form method="post" class="pincodeChecker_Form" action="" name="pincodeSearchForm">
                  <p class="instructions">
                    Please enter your PIN Code to check cash on delivery availability in your area
                  </p>
                  <div class="entry">
                    <label>PIN CODE:</label>
                    <input type="text" maxlength="255" name="pincode" id="pincode" value="" style="display:block!important">
                  </div>
                  <div class="action previousButton">
                    <a href="javascript:void(0);" class="standardBtn js_cancelPinCodeChecker">Close</a>
                  </div>
                  <div class="action continueButton">
                    <input type="submit" value="CHECK PIN CODE" class="standardBtn action">
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div id="eCommerceHeader">
            <div class="content mailingList siteHeaderMailingList">
              <div id="siteMailingList"></div>
            </div>
          </div>
          <div id="eCommercePageBody">
            <div id="scrollToTop" class="js_scrollToTop" style="display: block;">
              <a href="" id="pageScrollId">
              <i class="fa fa-caret-square-o-up fa-3x" aria-hidden="true"></i>
              </a>
            </div>
            <div id="eCommerceMainPanel" class="mainPanel">
              <h1>Sign in</h1>
              <div class="content logo siteHeaderLogo" id="eCommerceNavBar">
                <div id="eCommerceNavBarWidget">
                  <a href="javascript:void(0);" class="showNavWidget"><span> </span></a>
                  <a href="javascript:void(0);" class="hideNavWidget" style="display:none"><span> </span></a>
                </div>
                <a href="" class="menu-mobile"></a>
                <ul id="eCommerceNavBarMenu">
                </ul>
              </div>
              <div id="ajaxAddToWishListDiv"></div>
              <div id="eCommerceLoginContainer">
                <div id="ptsLogin" class="ptsSpot"></div>
                <div class="displayBoxList">
                  
                  
                  <p id="fBLoginInvalidUser" class="content-messages eCommerceErrorMessage" style="display: none;"></p>
                  <div class="col-xs-12 col-sm-12 col-md-12 sign-in-form signin">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                      <h1>SIGN IN</h1>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 signin-bg container existingCustomer signInExistingCustomer">
                      <div class="col-xs-12 col-sm-12 col-md-12 displayBox indus-pd0">
                        <form method="post" action="<?php echo url('drubiz/user'); ?>" id="loginFormMultipage" name="loginform">
                          <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 displayActionList container existingCustomer signInExistingCustomer">
                            <div class="col-md-4"></div>
                            <div class="col-xs-12 col-sm-12 col-md-4 indus-pd0">
                              <div class="user" id="guest">
                                <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0">
                                  <i class="fa fa-user icon-align"></i>
                                  <input id="customerEmail" name="USERNAME" type="text" value="" maxlength="200" placeholder="* EMAIL ID" autofocus="">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0">
                                  <i class="fa fa-unlock icon-align"></i>
                                  <input id="password34" name="PASSWORD" type="password" class="password" value="" maxlength="50" placeholder="* PASSWORD"><br>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0 assured">
                                  <a class="blue_color" href="<?php echo url('wclothing/signup') ?>">Sign UP</a>
                                  <a class="blue_color" href="#">Forgot Password?</a>
                                </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 indus-pd0">
                                <!--<a href="https://womenofindia.sonata-software.com/checkLogin;jsessionid=58797FC3D6EE0772F1633524D69AF57F.jvm1#" id="login_btn" type="image" name="login_btn" class="standardBtn action button red_small auto signin_continue">SIGN IN</a>-->

                                <input type="submit" class="standardBtn action button red_small auto signin_continue" name="login_btn" value="SIGN IN">
                              </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 socal">
                              <div class="col-sm-2 col-md-3"></div>
                              <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="social-facebook">
                                  <a class="btn btn-block btn-social btn-facebook" name="windowX" value="FaceBook" onclick="fb_login(); "><i class="fa fa-facebook"></i>
                                  SIGN IN WITH FACEBOOK</a> 
                                </div>
                              </div>
                              <div class="col-xs-6 col-sm-4 col-md-3">
                                <div class="social-google">
                                  <a class="btn btn-block btn-social btn-google-plus" name="windowX" value="Google" id="signinButton" onclick="_gaq.push(['_trackEvent', 'btn-social', 'click', 'btn-google-plus']);"><i class="fa fa-google-plus"></i>
                                  SIGN IN WITH GOOGLE</a>                     
                                </div>
                              </div>
                              <div class="col-sm-2 col-md-3"></div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="pesLogin" class="pesSpot"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>