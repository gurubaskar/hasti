<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
$request_url = request_path();


  global $drubiz_domain;
  $language_param = variable_get('locale_language_negotiation_session_param', 'language');
  $main_menu_suffix = (empty($_SESSION[$language_param]) || @$_SESSION[$language_param] == 'en') ? '-en' : '-' . $_SESSION[$language_param];
  $main_menu_name = 'main-menu-' . $drubiz_domain['catalog'];//. $main_menu_suffix;
  $menu_tree = menu_tree_output(menu_tree_all_data($main_menu_name));
  //krumo($main_menu_name);
  $search_filter_sidebar = !empty($page['search_filter_sidebar']);
?>

<div id="popBackground" style="display:none; position:relative; height:900px; z-index:9; top:900px; margin-top:-900px; background-color:#000; opacity:0.5; "></div>
<div id="eCommerceOuterBasicBevelWrap">
<div id="commonSearchDialog">
  <div id="search_dialog" class="dialogOverlay"></div>
  <div id="search_displayDialog" style="display:none" class="">
    <input type="hidden" name="search_dialogBoxTitle" id="search_dialogBoxTitle" value="">
    <div class="displayBox confirmDialog">
      <h3>Please Confirm</h3>
      <div class="confirmTxt">Please enter a search phrase in the text box and click on the Search icon.</div>
      <div class="container button">
        <input type="button" class="button red auto" name="noBtn" value="Ok" onclick="javascript:confirmDialogResult(&#39;N&#39;,&#39;search_&#39;);">
      </div>
    </div>
  </div>
</div>
<div id="pincodeChecker_dialog" class="dialogOverlay"></div>
<div id="pincodeChecker_displayDialog" style="display:none" class="">
  <input type="hidden" name="pincodeChecker_dialogBoxTitle" id="pincodeChecker_dialogBoxTitle" value="DELIVERY &amp; CoD AVAILABILITY">
  <div id="js_pincodeCheckContainer">
    <div id="pincodeChecker" class="pincodeChecker">
      <form method="post" class="pincodeChecker_Form" action="#" name="pincodeSearchForm">
        <p class="instructions">
          Please enter your PIN Code to check cash on delivery availability in your area
        </p>
        <div class="entry">
          <label>PIN CODE:</label>
          <input type="text" maxlength="6" name="pincode" id="pincode" value="">
        </div>
        <div class="action previousButton">
          <a href="javascript:void(0);" class="standardBtn js_cancelPinCodeChecker">Close</a>
        </div>
        <div class="action continueButton">
          <input type="submit" maxlength="6" value="CHECK PIN CODE" class="standardBtn action" onclick="return pincodeValidation()">
        </div>
        <div id="pincodeMessageId" style="color:red"></div>
        <div id="pincodeSuccessMessageId" style="display:none"></div>
      </form>
    </div>
    <div id="pincode" style="display:none"></div>
  </div>
</div>
<div id="eCommerceInnerBasicBevelWrapper">
  <?php if($request_url != "sonata/help"): ?>
    <?php if($request_url != "sonata/privacy-policy"):?>
  <div class="black-strip"></div>
<?php endif; ?>
<?php endif; ?>
  <div id="eCommerceContent" class="eCommerceHomePage">
  <?php if($request_url != "sonata/privacy-policy"): ?>
    <?php if($request_url != "sonata/help") :?>
    <div id="eCommerceHeader">
      <div class="content links siteHeaderLinks">
        <div id="siteHeaderLinks">
          <!-- <div class="freeship-text">
            FREE SHIPPING ABOVE 
            <p>$</p>
            1000
          </div> -->
          <div class="top-Links">
            <ul>
              <!-- <li id="referFrndLink">
                <a onclick="referFriend()">REFER FRIEND</a>
              </li>
              <li class="mobileRemove"><a class="checkDelivery" id="mcheckcod" href="javaScript:validatePincode();">CHECK COD</a></li>
              <li>
                <a href="#">Store Locator</a>
              </li>
              <li><a href="#" onclick="trackOrderStatus()" id="trackorder">Track Order</a></li> -->
              <?php if (!empty($GLOBALS['user']->uid)): ?>
                <li><?php echo theme('drubiz_ofbiz_login') ?></li>
                <?php echo theme('drubiz_theme_switch') ?>
                <li><a href="<?php echo url('account/dashboard') ?>"><?php echo t('My Account');?></a></li>
                <li><a href="<?php echo url('user/logout') ?>"><?php echo t('Logout');?></a></li>
              <?php endif; ?>
            </ul>
            <div id="sizeGuide" style="display:none">
              <img src="#" id="imageID" style="width:475px;height:400px;">
            </div>
            <div class="links1"></div>
          </div>
          <div class="ui-widget-overlay">
            <div id="dialog" title=" " style="display:none;">
              <div id="dialoglogin" class="dialogsignin"><?php echo t('Login');?> <span class="popUp_signUpLink"><?php echo t('New User?');?> <a onclick="signupPdp()"><?php echo t('SIGN UP');?></a></span></div>
              <a class="signup_pdp" id="signup_pdp" onclick="signupPdp()"><?php echo t('Sign Up');?></a>
              <div id="removeLogin">
                <div class="loginContainer">
                  <div class="loginLeft">
                    <form method="post" action="<?php echo url('drubiz/user') ?>" id="loginform" name="loginform" class="entryForm">
                      <input type="hidden" name="filterPrice" id="priceauto" value="price-asc">
                      <input type="hidden" name="filterDiscount" id="discountauto" value="dis-asc">
                      <div id="loginMessages"></div>
                      <div id="pdppopup">
                        <div id="emailErrorMsg" class="CustomerEmailErrorMsg loginMessages"></div>
                        <div class="loginRow">
                          <span class="login-label"><?php echo t('Email');?>*</span>
                          <!--  <span> <input class="form-control " id="returnCustomerEmail" name="USERNAME" type="text" placeholder="Email Address" value="" maxlength="200"/></span> -->
                          <span> <input class="form-control " id="returnCustomerEmail" name="USERNAME" type="text" placeholder="<?php echo t('Enter your Email Address');?>" maxlength="200"></span>
                        </div>
                        <div id="passwordErrorMsg" class="CustomerPasswordErrorMsg loginMessages"></div>
                        <div class="loginRow">
                          <span class="login-label"><?php echo t('Password');?>*</span>
                          <span><input class="form-control" id="password" name="PASSWORD" type="password" placeholder="<?php echo t('Password');?>" value="" maxlength="20"></span>
                        </div>
                        <div class="rememberMe">
                          <span class="remme">
                            <div class="remText"><input name="rememberme" id="rememberMe" type="checkbox" value="Y" checked="checked"><span><?php echo t('Remember Me');?></span></div>
                          </span>
                          <span class="frgtpawd">
                            <div class="forgotps">
                              <!-- <a onclick="forgetPassword(&#39;register&#39;);">Forgot Password?</a> -->
                              <a href="<?php echo url('user/password'); ?>"><?php echo t('Forgot Password?');?></a>
                            </div>
                          </span>
                        </div>
                        <div class="loginRow userloginbtn">
                          <span></span>
                          <span> <a id="login_btn" name="login_btn" class="button red auto marginleft"><?php echo t('Login');?></a></span>
                        </div>
                        <!--<div class="signinTitle"><?php echo t('OR');?></div>-->
                        <div class="newUserTxt">
                        </div>
                        <div>
                        <!--<?php
                          if (!empty($GLOBALS['fbconnect_login_button'])) {
                            echo $GLOBALS['fbconnect_login_button'];
                          }
                        ?>
                        <input class="btn btn-block btn-social btn-google-plus" type="button" id="google_login" value="Login with Google"/>
                           <span class="login_Social_New fb_New">
                          <a class="btn btn-block btn-social btn-facebook" name="windowX" value="FaceBook" onclick="fb_login();"><i class="fa fa-facebook"></i>Facebook</a>
                          </span> 
                         <span class="login_Social_New gPluse">
                          <a class="btn btn-block btn-social btn-google-plus" name="windowX" value="Google" id="signinButton1" onclick="_gaq.push([&#39;_trackEvent&#39;, &#39;btn-social&#39;, &#39;click&#39;, &#39;btn-google-plus&#39;]);"><i class="fa fa-google-plus"></i>Google</a>
                          </span> -->
                        </div>                        
                      </div>
                    </form>
                  </div>
                  <div style="clear:both;"></div>
                  <!--
                  <div>
                    <div class="assured"><img src="<?php echo current_theme_path() ?>/images/lock.jpg">Be assured, we do not store your password.</div>
                  </div>
                  -->
                  <div>
                  </div>
                </div>
              </div>
              <div id="signInpopup" style="display:none">
                <div id="dialogSignUp" style="display:none;" class="dialogsignup"><?php echo t('SIGN UP');?>  <span><a class="login_pdp" onclick="signInPopUp()"><?php echo t('LOG IN');?></a></span><span class="alreadyReg_Text"><?php echo t('Already Registered?');?></span></div>
                <div id="signupMessages"></div>
                <div class="accountRegContainer">
                  <div class="signin1">
                    <div class="singup-withemail">
                      <form method="post" action="<?php echo url('drubiz/user-register') ?>" id="loginform1" name="loginform" class="entryForm">
                        <div class="loginRow usernames">
                          <span>
                            <?php echo t('Name');?>*
                          </span>
                          <span class="LoginNames">
                            <div class="FirstName">
                              <input type="text" maxlength="20" name="firstName" id="firstName" value="" placeholder="<?php echo t('First Name');?>">
                              <input type="hidden" name="USER_FIRST_NAME_MANDATORY" value="Y">
                            </div>
                            <div class="LastName">
                              <input type="text" maxlength="20" name="lastName" id="lastName" value="" placeholder="<?php echo t('Last Name');?>">
                              <input type="hidden" name="USER_LAST_NAME_MANDATORY" value="Y">
                            </div>
                          </span>
                        </div>
                        <div id="nameError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                            <?php echo t('Mobile Number');?>*
                          </span>
                          <span><input type="text" class="phone10" id="PHONE_MOBILE_CONTACT_OTHER" name="PHONE_MOBILE_CONTACT_OTHER" value="" placeholder="<?php echo t('Mobile Number');?>">
                          <span class="entryHelper"> </span>
                          <input type="hidden" name="PHONE_MOBILE_CONTACT_OTHER_MANDATORY" value="Y">
                          <input type="hidden" name="mainAction" value="CREATE"></span>
                        </div>
                        <div id="mobileNumberError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                            <?php echo t('Date of Birth');?>*
                          </span>
                          <span class="LoginNames">
                            <select id="dobLongDayUs" name="dobLongDayUs" class="dobDay">
                              <option value=""><?php echo t('Day');?></option>
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                              <option value="29">29</option>
                              <option value="30">30</option>
                              <option value="31">31</option>
                            </select>
                            <select id="dobLongMonthUs" name="dobLongMonthUs" class="dobMonth">
                              <option value=""><?php echo t('Month');?></option>
                              <option value="01">01</option>
                              <option value="02">02</option>
                              <option value="03">03</option>
                              <option value="04">04</option>
                              <option value="05">05</option>
                              <option value="06">06</option>
                              <option value="07">07</option>
                              <option value="08">08</option>
                              <option value="09">09</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                            <select id="dobLongYearUs" name="dobLongYearUs" class="dobYear">
                              <option value=""><?php echo t('Year');?></option>
                              <option value="1998">1998</option>
                              <option value="1997">1997</option>
                              <option value="1996">1996</option>
                              <option value="1995">1995</option>
                              <option value="1994">1994</option>
                              <option value="1993">1993</option>
                              <option value="1992">1992</option>
                              <option value="1991">1991</option>
                              <option value="1990">1990</option>
                              <option value="1989">1989</option>
                              <option value="1988">1988</option>
                              <option value="1987">1987</option>
                              <option value="1986">1986</option>
                              <option value="1985">1985</option>
                              <option value="1984">1984</option>
                              <option value="1983">1983</option>
                              <option value="1982">1982</option>
                              <option value="1981">1981</option>
                              <option value="1980">1980</option>
                              <option value="1979">1979</option>
                              <option value="1978">1978</option>
                              <option value="1977">1977</option>
                              <option value="1976">1976</option>
                              <option value="1975">1975</option>
                              <option value="1974">1974</option>
                              <option value="1973">1973</option>
                              <option value="1972">1972</option>
                              <option value="1971">1971</option>
                              <option value="1970">1970</option>
                              <option value="1969">1969</option>
                              <option value="1968">1968</option>
                              <option value="1967">1967</option>
                              <option value="1966">1966</option>
                              <option value="1965">1965</option>
                              <option value="1964">1964</option>
                              <option value="1963">1963</option>
                              <option value="1962">1962</option>
                              <option value="1961">1961</option>
                              <option value="1960">1960</option>
                              <option value="1959">1959</option>
                              <option value="1958">1958</option>
                              <option value="1957">1957</option>
                              <option value="1956">1956</option>
                              <option value="1955">1955</option>
                              <option value="1954">1954</option>
                              <option value="1953">1953</option>
                              <option value="1952">1952</option>
                              <option value="1951">1951</option>
                              <option value="1950">1950</option>
                              <option value="1949">1949</option>
                              <option value="1948">1948</option>
                              <option value="1947">1947</option>
                              <option value="1946">1946</option>
                              <option value="1945">1945</option>
                              <option value="1944">1944</option>
                              <option value="1943">1943</option>
                              <option value="1942">1942</option>
                              <option value="1941">1941</option>
                              <option value="1940">1940</option>
                              <option value="1939">1939</option>
                              <option value="1938">1938</option>
                              <option value="1937">1937</option>
                              <option value="1936">1936</option>
                              <option value="1935">1935</option>
                              <option value="1934">1934</option>
                              <option value="1933">1933</option>
                              <option value="1932">1932</option>
                              <option value="1931">1931</option>
                              <option value="1930">1930</option>
                              <option value="1929">1929</option>
                              <option value="1928">1928</option>
                              <option value="1927">1927</option>
                              <option value="1926">1926</option>
                              <option value="1925">1925</option>
                              <option value="1924">1924</option>
                              <option value="1923">1923</option>
                              <option value="1922">1922</option>
                              <option value="1921">1921</option>
                              <option value="1920">1920</option>
                            </select>
                            <input type="hidden" name="DOB_MMDDYYYY_MANDATORY" value="N">
                          </span>
                        </div>
                        <div id="dobError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                           <?php echo t('Gender');?>*
                          </span>
                          <span>
                            <select name="USER_GENDER" id="USER_GENDER">
                              <option value=""><?php echo t('Select One...');?> </option>
                              <option value="M">Male</option>
                              <option value="F">Female</option>
                            </select>
                            <input type="hidden" name="USER_GENDER_MANDATORY" value="N">
                          </span>
                        </div>
                        <div id="userGenderError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                             <?php echo t('Email ID');?>*
                          </span>
                          <span><input id="customerEmail" name="userLoginId" type="text" placeholder="<?php echo t('Email ID')?>" value="" maxlength="200">
                          </span>
                        </div>
                        <div id="customerEmailError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                            <?php echo t('Password');?>*
                          </span>
                          <span>
                          <input id="password1" name="currentPassword" type="password" placeholder="<?php echo t('Password');?>" class="password" value="" maxlength="20">
                          </span>
                        </div>
                        <div id="passwordError" class="Error"></div>
                        <div class="loginRow">
                          <span>
                            <?php echo t('Re-Enter');?>*
                          </span>
                          <span>
                          <input id="password2" name="currentPasswordVerify" type="password" placeholder="<?php echo t('Password re-enter');?>" class="password" value="" maxlength="20">
                          </span>
                        </div>
                        <div id="rePasswordError" class="Error"></div>
                        <div class="continueBtn_aline loginRow userloginbtn">
                          <a href="#" id="signup_btn" name="continueBtn" class="button red auto"><?php echo t('SIGN UP');?></a>
                        </div>
                      </form>
                    </div>
                       <!--<?php
                          if (!empty($GLOBALS['fbconnect_login_button'])) {
                            echo $GLOBALS['fbconnect_login_button'];
                          }
                        ?>

                        <input class="btn btn-block btn-social btn-google-plus" type="button" id="google_login" value="Login with Google"/>-->
                    <!--
                    <div class="socal">
                      <div class="checkout-alreday-head">Sign in with</div>
                      <div class="social_btn_Container">
                        <div class="left_Socialbtns">
                          <a class="btn btn-block btn-social btn-facebook" name="windowX" value="FaceBook" onclick="fb_login(); ">
                          <i class="fa fa-facebook"></i>Facebook</a>
                        </div>
                        <div class="left_Socialbtns">
                          <a class="btn btn-block btn-social btn-google-plus" name="windowX" value="Google" id="signinButton2" onclick="_gaq.push([&#39;_trackEvent&#39;, &#39;btn-social&#39;, &#39;click&#39;, &#39;btn-google-plus&#39;]);">
                          <i class="fa fa-google-plus"></i>Google</a>
                        </div>
                        <div style="clear:both"></div>
                        <div class="assured">
                          <img src="<?php echo current_theme_path() ?>/images/lock.jpg" width"10px"="" height="10px" "="">Be assured, we do not store your password.
                        </div>
                      </div>
                    </div>
                    -->
                  </div>
                  <div class="signin2">
                    <div class="signupRightContainer">
                      <span class="vochureTrophy"></span><?php echo t('Sign Up & Get Vouchers');?>
                      <h2><?php echo t('Worth $100');?></h2>
                      <ul class="vochuerInfo">
                        <li><?php echo t('1 voucher to avail $300 off on purchase of $999,')?>' <br><?php echo t('which can be used 5 times');?></li>
                        <li><?php echo t('1 voucher to avail $500 off on purchase of $1699,');?><br> <?php echo t('which can be used 2 times');?></li>
                        <li><?php echo t('Coupons can only be used to buy full priced (non-discounted) products');?></li>
                        <li><?php echo t('Valid across all products except precious jewellery, innerwear, socks,');?> <br><?php echo t('Tommy Hilfiger & Casio');?></li>
                        <li><?php echo t('Valid for 10 days');?></li>
                      </ul>
                      <!--
                      <div id="LMS_Title">
                        <span>Also Become a part of</span>
                        <span class="lms"><img src="<?php echo current_theme_path() ?>/images/LMS_Rewards.jpg" title="LMS" alt="LMS" width="75" height="75"></span>
                      </div>
                      -->
                    </div>
                  </div>
                  <div class="socal">
                    <div style="margin-top:-12px; text-align: center;">
                      <a class="login_pdp" id="login_pdp" style="display:none;" onclick="signInPopup()"><?php echo t('LOG IN');?></a>
                    </div>
                  </div>
                </div>
              </div>
              <div id="fpId" style="display:none;">
                <form method="post" onsubmit="return false;" class="entryForm" id="entryForm">
                  <input type="hidden" name="partyId" value="">
                  <input type="hidden" name="productStoreId" value="GS_STORE">
                  <div class="forgot-area">
                    <div id="dialogforpass" style="display:none;" class="dialogsignin">
                      <span class="frgt-pwd"><?php echo t('Forgot Password');?></span>
                      <div class="content-messages eCommerceSuccessMessage" id="forgotAlertsucess" style="display:none;">
                        <div class="eventImage"></div>
                        <p class="eventMessage"> <?php echo t('A new password has been sent to your contact email address. Please use the new password to sign in and for your security you will be prompted to reset your password.');?></p>
                      </div>
                      <div id="forgotPasswordEntry">
                        <p><?php echo t('Enter your Email Address here to receive a new password');?></p>
                        <div id="forgotAlert"></div>
                        <div class="forgot-inputarea">
                          <label for="USERNAME">
                          <b><?php echo t('Email:');?></b>
                          </label>
                          <span>
                          <input type="text" maxlength="100" class="userName" id="unameEmailId" name="USERNAME" onkeypress="entereEmail(event);" value="">
                          </span>
                        </div>
                        <input type="hidden" name="EMAIL_PASSWORD" value="Y">
                        <input type="hidden" name="JavaScriptEnabled" value="N">
                      </div>
                    </div>
                    <div class="changePersInfo">
                      <div class="forGotContainer">
                        <a class="button red auto button_aline" onclick="checkEmail();"><?php echo t('Send Password');?></a>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div id="trackerIdx" style="display:none;">
            <div id="trackerIdxx" style="display:none;" class="dialogsignin"><?php echo t('Track Order');?> </div>
            <div id="trackorderMsg" style="color:red;"></div>
            <form id="traid">
              <div class="textclear">
                <label><?php echo t('Order Id:');?> <input type="text" maxlength="255" name="orderId" id="orderId"></label><br>
                <div id="trackorderEmailMsg" style="color:red;"></div>
                <label><?php echo t('Email Id');?>: <input type="text" maxlength="255" name="emailId" id="emailId"></label><br>
                <a class="standardBtn" onclick="orderStatusTrack();"><?php echo t('Submit');?></a>
              </div>
            </form>
          </div>
          <div class="ui-widget-overlay">
            <div id="signInGuestId" style="display:none; font-family: DIN, Helvetica, Arial, sans-serif;">
              <div id="dialogsignIn" class="dialogsignin"><?php echo t('Log In');?></div>
              <div class="signin" style="font-family: DIN, Helvetica, Arial, sans-serif;">
                <form method="post" action="#" id="loginFormMultipage" name="loginform">
                  <div class="radio">
                    <div class="radio_buttons">
                      <input type="radio" name="guest" value="guest" onclick="guestorlogin1()" checked="" style="padding:5px;" id="loginCheck"><span> <?php echo t('Continue as guest');?></span> 
                    </div>
                    <div class="radio_buttons">
                      <input type="radio" name="guest" value="login" onclick="guestorlogin1()"> <span><?php echo t('I have Fashion login');?></span>
                    </div>
                  </div>
                  <div id="guestusrmessage"></div>
                  <div class="user" id="guest">
                    <span class="text_font"> <?php echo t('Email ID:');?> </span>
                    <input id="customerEmailid" class="loginsession-textbox" name="USERNAME" type="text" value="" maxlength="200" autofocus="">
                  </div>
                  <input id="USERNAME_GUEST" name="USERNAME_GUEST" type="hidden" value="">
                  <div class="user" id="login" style="display:none;">
                    <span class="text_font"><?php echo t('Password:');?></span>
                    <input id="password3" name="PASSWORD" type="password" class="loginsession-textbox password" value="" maxlength="50"><br>
                    <div class="forgotps" style="position: absolute; text-align: right"><a onclick="forgetPassword(&#39;guest&#39;);"><?php echo t('Forgot Password?');?></a></div>
                  </div>
                  <div class="guest_cntue">
                    <a href="#" onclick="return guestorlogin()" id="login_btn" type="image" name="login_btn" class="button red_small auto signin_continue"><?php echo t('Continue');?> <i class="fa fa-angle-double-right "></i></a>
                  </div>
                </form>
              </div>
              <div class="guestSocal_btnSet" style="font-family: DIN, Helvetica, Arial, sans-serif;">
                <div class="checkout-alreday-head"><?php echo t('SIGN IN WITH');?></div>
                <div class="" guest_socialicons="">
                  <div class="guest_fbook">
                    <a class="btn btn-block btn-social btn-facebook" name="windowX" value="FaceBook" onclick="fb_login(); ">
                    <i class="fa fa-facebook"></i><?php echo t('Facebook');?></a>
                  </div>
                  <div class="guest_googleplus">
                    <a class="btn btn-block btn-social btn-google-plus" name="windowX" value="Google" id="signinButton3" onclick="_gaq.push([&#39;_trackEvent&#39;, &#39;btn-social&#39;, &#39;click&#39;, &#39;btn-google-plus&#39;]);">
                    <i class="fa fa-google-plus"></i><?php echo t('Google');?></a>
                  </div>
                  <div class="guest_assured">
                    <img src="<?php echo current_theme_path() ?>/images/lock.jpg" width"10px"="" height="10px" "="">Be assured, we do not store your password.
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="couponId" style="display:none;">
            <div class="gftwrap-title"><?php echo t('COUPON');?></div>
            <div id="couponId" style="display:none;">
            <div class="gftwrap-title">COUPON</div>
            <form id="coupid">
              <div class="coupn-wrap">
                <h3> <?php echo t('Deal Activated. Please follow instructions to avail the offer');?> </h3>
                <div id="courponMsg" class="getcoupn" style="display:none"></div>
                <div class="go-to" id="coupbtn">
                  <a class="standardBtn" onclick="getCoupon();"><?php echo t('Get Coupon');?></a>
                </div>
                <div class="offer-coupon">
                  <h3> Offer: <span id="couponTxt"><?php echo t('Click on the above to button and get the coupon code');?> </span></h3>
                </div>
              </div>
            </form>
          </div>
          <div id="cancelorder" style="display:none;">
            <div class="dialogsignin"><?php echo t('Cancel Order');?> </div>
            <div class="center pd10">
              <span><?php echo t('Are you sure you want to cancel the order');?></span>
              <div class="btn-group">
                <a onclick="return cancelOrderPopup()" class="standardBtn action">Cancel</a>
                <a onclick="return confirmOrderPopup()" class="standardBtn action">Confirm</a>
              </div>
            </div>
          </div>
          <div id="referFriendDialog" style="display:none;">
            <div class="dialogsignin">Refer Friend </div>
            <div class="center pd10">
              <span></span>
              <div class="btn-group">
                <input type="text" name="frndEmails" id="referFrndMails">
                <div class="ReferMailsErrMsg forgot-area"></div>
                <a onclick="return closeReferFrndDialog()" class="standardBtn action">Cancel</a>
                <a onclick="return submitReferFrnd()" class="standardBtn action">Send Invite</a>
              </div>
            </div>
          </div>
          <div id="orderreItemturns" style="display:none;">
            <div class="dialogsignin">Order Items returns </div>
            <div class="center pd10">
              <span class="confirmtext">Are you sure you want to return the order?</span>
              <div class="dashboard-orderreturndetails">
                <table id="orderrReturnTable" border="1" cellpadding="5" cellspacing="5" class="dashboard-ordertable">
                  <tbody>
                    <tr class="ordertable-head">
                      <th>Image</th>
                      <th>Product Name</th>
                      <th>SKU</th>
                      <th>Price</th>
                      <th>Qty</th>
                      <th>Item Status</th>
                      <th>Sub Total</th>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="orderreturn-details">
                <div class="reasondiv orderreturndiv">
                  <div>Return Reason</div>
                  <div id="retuId"></div>
                </div>
                <div class="awbnum orderreturndiv">
                  <span>AWB Number*:</span><input type="text" name="awbnum" required="" id="awbnumId" value="">
                  <div id="awbaError" style="color:red"></div>
                </div>
                <div class="shiptype orderreturndiv"><span>Selfship</span><input type="radio" name="imgsel" value="" checked="checked"></div>
                <div class="globusaddr orderreturndiv">
                  <p class="storename">Fashionstores</p>
                  <p>Sonata Building,</p>
                  <p>V P Road,</p>
                  <p>Santacruz West,</p>
                  <p>Mumbai - 400054</p>
                  <p>Tel.No:+91-22-61731301</p>
                  <p>Email:cs@sonata-software.com</p>
                </div>
                <div class="btn-group">
                  <a onclick="return cancelOrderReturnPopup()" class="standardBtn action cancelbtn">Cancel</a>
                  <a onclick="return confirmOrderReturnPopup()" class="standardBtn action confirmbtn">Confirm</a>
                </div>
              </div>
            </div>
          </div>
          <div id="orderreItemturnsConfirm" style="display:none;">
            <div class="dialogsignin">Order Items returns</div>
            <div class="orderitemreturn"><span class="orderreturn-confirm">Order Return Amount :</span> <span id="retrunAmountId"></span></div>
            <div class="center pd10">
              <div class="btn-group">
                <a onclick="return cancelReturnConfirm()" class="standardBtn action cancelbtn">Cancel</a>
                <a onclick="return confirmReturn()" class="standardBtn action confirmbtn">Confirm</a>
              </div>
            </div>
          </div>
        </div>
        <div class="free-shipTxt">Free Shipping above Rs:1000 Purchage,  Cash on Delivery also available</div>
      </div>
      <div id="freeDeliveryChecker2" class="pincodeChecker" style="display:none;">
        <div class="dialogsignin">Free Delivery</div>
        <div class="left p10">
          <div class="entry">
            Free Delivery is avaliable if purchase above Rs.1000/-.
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content mailingList siteHeaderMailingList">
    <div id="siteMailingList"></div>
  </div>
  <div id="header-container" style="display: block;">
    <div id="header-wrapper">
      <div class="content logo siteHeaderLogo">
        <div id="siteLogo">
          <div class="header-wrapper">
            <div class="defaultDevice logo" style="display: block;"><a href="<?php echo url() ?>"><img alt="HomeS" 
              src="
                 <?php if($drubiz_domain['catalog'] == 'globus') {?>
                      <?php echo current_theme_path() ?>/images/globuslogo.png
                    <?php }else if($drubiz_domain['catalog'] == 'handloom') {?>
                      <?php print current_theme_path(); ?>/images/woi-logo.png
                    <?php }else if($drubiz_domain['catalog'] == 'industree'){ ?>
                      <?php print current_theme_path(); ?>/images/woi-logo-women.png
                    <?php }else if($drubiz_domain['catalog'] == 'hng'){ ?>
                      <?php print current_theme_path(); ?>/images/new-hng-logo.png
                    <?php } ?>

              "></a></div>
          </div>
          <div class="head-right">
            <form id="frmSearchForm" name="frmSearchForm" method="get">
              <fieldset class="formstyle" title="Search this site...">
                <div id="searchContainer" class="targetMobile" style="display: block;">
                  <div id="searchField">
                    <input type="text" placeholder="<?php echo t('search website');?>" name="searchText" id="searchText" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                  </div>
                  <div id="searchButton">
                    <input type="button" class="searchSubmit" value="">
                  </div>
                </div>
              </fieldset>
              <div class="searchErrorMsg" style="color:red"></div>
              <div class="searchAutoComplete" id="searchAutoComplete"></div>
            </form>
          </div>
        </div>
      </div>
      <div class="content search siteHeaderSearch" style="display:none">
        <div id="siteSearch"></div>
      </div>
    </div>
  </div>
  <div class="content navigation siteHeaderNavigation" id="eCommerceNavBar">
    <div id="nav-wrapper">
      <div class="responsive-wrapper">
        <div id="toggleId" class="togglemenu">
          <a class="Menu_toggle" href="#" style="display: none;"></a>
        </div>
        <div class="resp-cart">
          <a href="<?php echo url('cart') ?>" title="My Cart" class="top-link-login">
          <span class="guest-pic" id="siteShoppingCartSize">
          <img width="38" height="30" src="<?php echo current_theme_path() ?>/images/Cart.png">
          </span>
          </a>
        </div>
        <div id="iconSearch2" class="search-sticky" style="display: none;"><input type="button" id="searchId" class="m-search" value="click" onclick="searchBox();" style="display: none;"></div>
        <div class="responsivelogo">
          <div id="stickylogo2" style="display: none;"><a class="sticky-logo" id="logo_globus" href="<?php echo url() ?>"><img src="<?php echo current_theme_path() ?>/images/globuslogo.png"></a></div>
        </div>
        <div class="responseNavBar" style="display:none;">
          <div class="menulistwrapper">
            <ul class="navigationbar">
              <?php foreach ($menu_tree as $menu_id => $menu): if (!is_numeric($menu_id)) continue; ?>
                <li class="subLevel topCatalogLi navlastitem removeFooterLinks" style="display: none;">
                  <?php $top_level_link = !empty($menu['#below']) ? '#' : url($menu['#href'], array('query' => @$menu['#localized_options']['query'])) ?>
                  <a href="<?php echo $top_level_link ?>" class="topLevel topCatlog respFooterLink parent"><?php echo $menu['#title'] ?></a>
                  <?php if (!empty($menu['#below'])): ?>
                    <ul class="subCategoryNav" style="display: none;">
                      <?php foreach ($menu['#below'] as $sub_menu_id => $sub_menu): if (!is_numeric($sub_menu_id)) continue; ?>
                        <li><a href="<?php echo url($sub_menu['#href'], array('query' => @$sub_menu['#localized_options']['query'])) ?>"><?php echo $sub_menu['#title'] ?></a></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="fixed-nav-list">
        <div id="stickylogo" style="display: none;"><a class="sticky-logo" id="logo_globus" href="<?php echo url() ?>"><img src="<?php echo current_theme_path() ?>/images/globuslogo.png"></a></div>
        <div id="nav-container" style="position:relative;">
          <div id="ecommerceNavigationBar" style="display: block;">
            <?php //krumo($menu_tree); ?>
            <ul id="eCommerceNavBarMenu">
              <?php foreach ($menu_tree as $menu_id => $menu): if (!is_numeric($menu_id)) continue; ?>
                <li class="topLevel topCatalogLi">
                  <a class="topLevel topCatlog" href="<?php echo url($menu['#href'], array('query' => @$menu['#localized_options']['query'])) ?>">
                    <?php echo $menu['#title'] ?>
                  </a>
                  <?php if (!empty($menu['#below'])): ?>
                    <div class="mainDiv" style="display:none;">
                      <div class="menuimgDiv" style="display:none;"><!-- <img src="<?php echo current_theme_path() ?>/images/Women_-Banner_1.jpg" alt="banner"> --></div>
                      <div class="subUlDiv">
                        <ul class="subCategoryNav" style="display: none;">
                          <?php foreach ($menu['#below'] as $sub_menu_id => $sub_menu): if (!is_numeric($sub_menu_id)) continue; ?>
                            <li class="subLevel topCatalogLi">
                              <a class="subLevel topCatlog" href="<?php echo url($sub_menu['#href'], array('query' => @$sub_menu['#localized_options']['query'])) ?>">
                                <?php echo $sub_menu['#title'] ?>
                              </a>
                              <?php if (!empty($sub_menu['#below'])): ?>
                                <ul class="subCategoryNav" style="display: none;">
                                  <?php foreach ($sub_menu['#below'] as $sub_sub_menu_id => $sub_sub_menu): if (!is_numeric($sub_sub_menu_id)) continue; ?>
                                    <li class="subLevel topCatalogLi navfirstitem">
                                      <a class="subLevel topCatlog" href="<?php echo url($sub_sub_menu['#href'], array('query' => @$sub_sub_menu['#localized_options']['query'])) ?>">
                                        <?php echo $sub_sub_menu['#title'] ?>
                                      </a>
                                    </li>
                                  <?php endforeach; ?>
                                </ul>
                              <?php endif; ?>

                            </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                  <?php endif; ?>

                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="header-wrapper navigationBarIcns" style="display: block;">
            <div class="head-right">
              <div class="quick-access" style="display: block;">
                <div class="top-logBtn-Group">
                  <div class="first last linkacess">
                    <a title="<?php echo !empty($GLOBALS['user']->uid) ? 'My Account' : t('Log In / SIGN UP') ?>" class="top-link-login" href="<?php echo !empty($GLOBALS['user']->uid) ? url('account/dashboard') : '#' ?>" onclick="<?php echo !empty($GLOBALS['user']->uid) ? '' : 'popupError();signInPopUp()' ?>">
                      <span class="guest-pic"><img src="<?php echo current_theme_path() ?>/images/avataricon.png"></span>
                      <!--<span class="guest-name">Log In / Sign Up</span>-->
                    </a>
                  </div>
                </div>
                <div class="wish-list linkacess wish-field" id="addwishlist">
                  <a href="<?php echo url('account/love-list');?>" title="My Wishlist" class="top-link-login" id="wishlistHeaderCount">
                  <span class="guest-pic">
                  <img src="<?php echo current_theme_path() ?>/images/wishlist_img.png">
                  </span>
                  <span class="list-count"></span>
                  <span class="guest-name"></span>
                  </a>
                </div>
                <div class="wish-list linkacess showLightBoxCart" id="addCartlist">
                  <a href="<?php echo url('cart') ?>" title="My Cart" class="top-link-login">
                  <span class="guest-pic" id="siteShoppingCartSize">
                  <img src="<?php echo current_theme_path() ?>/images/Cart.png">
                  </span>
                  <span id="mini-cart-count" class="list-count countposition"></span>
                  <span class="guest-name">Cart</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="fixed-wishlist">
          <div id="signIn_signUp" class="top-logBtn-Group" style="display: none;">
            <div class="first last linkacess">
              <a title="Log In / Sign Up" class="top-link-login" onclick="signInPopUp(&#39;regular&#39;)">
                <span class="guest-pic"><img src="<?php echo current_theme_path() ?>/images/avataricon2.png"></span>
                <span class="guest-name"></span>
              </a>
            </div>
          </div>
          <div class="wish-list linkacess wish-field" id="addWishlist2" style="display: none;">
            <a title="My Wishlist" class="top-link-login" id="wishlistCount">
            <span class="guest-pic">
            <img src="<?php echo current_theme_path() ?>/images/wishlist_img2.png">
            </span>
            <span class="list-count"></span>
            <span class="guest-name"></span>
            </a>
          </div>
          <div id="addCart" class="wish-list linkacess showLightBoxCart" style="display: none;">
            <a href="<?php echo url('cart') ?>" title="My Cart" class="top-link-login ">
            <span class="guest-pic">
            <img src="<?php echo current_theme_path() ?>/images/Cart2.png">
            </span>
            <span class="list-count"></span>
            <span class="guest-name"></span>
            </a>
          </div>
          <div id="iconSearch" class="search-sticky" style="display: none;"><input type="button" id="searchId" class="m-search" value="click" onclick="searchBox();"></div>
        </div>
        <div class="bgoverlay" style="display: none;"></div>
        <div id="responcive_search" class="responcive-search stkysearch" style="display: none;">
          <div class="search-wrapper">
            <div id="siteSearch">
              <form id="frmSearchForm2" action="#" name="frmSearchForm" method="get">
                <fieldset class="formstyle" title="Search this site...">
                  <div id="searchContainer" class="targetMobile">
                    <div id="searchField">
                      <input type="text" placeholder="<?php echo t('search website');?>" name="searchText" id="searchTextSticky" onblur="setIt(this)" onfocus="clearIt(this)" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    </div>
                    <div id="searchButton" class="clearfixedsearch fixedsearch">
                      <input type="button" class="searchSubmit" onclick="return submitSearchForm(document.frmSearchForm);" value="">
                    </div>
                  </div>
                </fieldset>
                <div class="sticky-search">
                  <div class="searchErrorMsg" style="color:red"></div>
                </div>
              </form>
            </div>
          </div>
          <div class="searchAutoComplete" id="searchAutoCompleteSticky"></div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php endif; ?>
  <div id="eCommercePageBody">
    <div id="scrollToTop" class="js_scrollToTop" style="display:none;">
      <a href="#">
      <img alt="Scroll To Top" src="<?php echo current_theme_path() ?>/images/pageScroller.png">
      </a>
    </div>

    <?php if ($breadcrumb): ?>
      <div id="breadcrumb"><?php print clean_breadcrumb($breadcrumb); ?></div>
    <?php endif; ?>

    <?php print $messages; ?>
    <?php if($request_url != "sonata/help"): ?>
      <?php if($request_url != "sonata/privacy-policy"): ?>
    <div class="warh-lang pull-right">
                  <ul class="nav navbar-nav">
                    <li class="lang">
                      <?php $languages = language_list('enabled'); ?>
                      <label for="drubiz-language-selector"><?php echo t('Language'); ?></label>
                      <select id="drubiz-language-selector">
                        <?php foreach ($languages[1] as $language): ?>
                          <option value="<?php echo $language->language; ?>" <?php echo @$_SESSION[$language_param] == $language->language ? 'selected="selected"' : '' ?>><?php echo $language->native ?></option>
                        <?php endforeach; ?>
                      </select>
                    </li>
                  </ul>
                </div>
    
              <?php endif; ?>
              <?php endif; ?>
    <?php if ($search_filter_sidebar): ?>
      <div id="eCommerceLeftPanel" style="display: block;">
        <div id="eCommerceCategoryFacetContainer">
          <ul>
            <?php echo render($page['search_filter_sidebar']) ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <div id="eCommerceMainPanel" class="<?php echo $search_filter_sidebar ? 'leftPanel' : 'homePage' ?>">
      <div id="main-wrapper"><div id="main" class="clearfix">

        <div id="content" class="column"><div class="section">
          <a id="main-content"></a>
          <?php print render($title_prefix); ?>
          <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
          <?php print render($title_suffix); ?>
          <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
          <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
          <?php print render($page['content']); ?>
          <?php print $feed_icons; ?>
        </div></div> <!-- /.section, /#content -->

      </div></div> <!-- /#main, /#main-wrapper -->
    </div>
  </div>
</div>
</div>

<div id="lightCart_displayDialog" style="display: none;" class="" scrolltop="0" scrollleft="0">
  <div id="lightCart_Container">
    <div class="lightCart">
      <form id="cartLightform" name="cartLightform" action="/online/control/" method="post">
        <h3>No Items.</h3>
      </form>
    </div>
  </div>
</div>

<?php if($request_url != "sonata/help"):?>
  <?php if($request_url != "sonata/privacy-policy"):?>
<div id="eCommerceFooter">
<div id="footer-top">
  <div class="footerWraper">
    <div class="secure_shipping responsceFooter">
      <div class="secure_wrap">
        <div class="ship_title footerSecMainDiv" id="footerSecMainDiv1"><?php echo t('PAYMENT METHODS');?>
          <span id="plusIcon1" class="shpcatgryplus_on1" style="display:none;"></span>
        </div>
        <div class="shipDiv" id="footerSecDiv1" style="display: block;"><span class="card1">&nbsp;</span> <span class="mastercard">&nbsp;</span> <span class="visacard">&nbsp;</span> <span class="debitcard">&nbsp;</span> <span class="verisigncard">&nbsp;</span></div>
      </div>
      <div class="shipping_wrap">
        <div class="ship_title footerSecMainDiv" id="footerSecMainDiv2"><?php echo t('SHIPPING PARTNERS');?>
          <span id="plusIcon2" class="shpcatgryplus_on1" style="display:none;"></span>
        </div>
        <div class="shipPartner" id="footerSecDiv2" style="display: block;"><span class="aramex">&nbsp;</span> <span class="bluedart">&nbsp;</span></div>
      </div>
      <div class="globuson_wrap">
        <div class="ship_title footerSecMainDiv" id="footerSecMainDiv3"><?php echo t('Fashion on the Go');?>
          <span id="plusIcon3" class="shpcatgryplus_on1" style="display:none;"></span>
        </div>
        <div class="shipPartner" id="footerSecDiv3" style="display: block;"><span class="appstore">&nbsp;</span><span class="googleplay">&nbsp;</span></div>
      </div>
      <div class="follow_us_wrap">
        <div class="ship_title footerSecMainDiv" id="footerSecMainDiv4"><?php echo t('connect with us');?>
          <span id="plusIcon4" class="shpcatgryplus_on1" style="display:none;"></span>
        </div>
        <div class="socialshare-footer" id="footerSecDiv4" style="display: block;">
          <a class="facebook-icon" href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> 
          <a class="twitter-icon" href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> 
          <a class="instagram-icon" href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a> 
          <a class="pintrest-icon" href="#"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
          <a class="youtube-icon" href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-links" style="display: block;">
      <div id="ft-wrapper-left">
        <div class="footerColumn">
          <h3><?php echo t('About Fashion');?></h3>
          <ul class="footerLinks">
            <!--<li><a href="#" >Corporate Site</a></li>-->
            <!--<li><a href="#" >Employment</a></li>-->
            <li><a href="#"><?php echo t('Video');?></a></li>
            <!--<li><a href="#" >FAQ</a></li>-->
            <!--<li><a href="#" >Terms & Conditions</a></li>-->
          </ul>
        </div>
        <div class="footerColumn">
          <h3><?php echo t('assistance');?></h3>
          <ul class="footerLinks">
            <li><a href="#"><?php echo t('Terms &amp; Conditions');?></a></li>
            <li class="mobileRemove"><a href="<?php echo url('sonata/help')?>"><?php echo t('Help');?></a></li>
            <li><a href="#"><?php echo t('FAQ');?></a></li>
            <li><a href="#"><?php echo t('Garment Care');?></a></li>
            <li class="mobileRemove"><a href="#"><?php echo t('Contact Us');?></a></li>
          </ul>
        </div>
        <div class="footerColumn">
          <h3><?php echo t('policies');?></h3>
          <ul class="footerLinks">
            <li><a href="#"><?php echo t('Payment Policy');?></a></li>
            <li><a href="<?php echo url('sonata/privacy-policy')?>"><?php echo t('Privacy Policy');?></a></li>
            <li><a href="#"><?php echo t('CANCELLATION & RETURN POLICY');?></a></li>
            <li><a href="#"><?php echo t('Shipping');?></a></li>
          </ul>
        </div>
        <div class="footerColumn mr0">
          <h3><?php echo t('Customer Service');?></h3>
          <ul class="footerLinks">
            <li><a href="#"><?php echo t('22 61731300');?></a></li>
            <li><a href="#"><?php echo t('cs@sonata-software.com');?></a></li>
            <li><span class="working-days"><?php echo t('Mon-Fri - 10am to 7pm');?></span></li>
            <li><span class="mob-sms"><?php echo t('9223990622 (SMS Only)');?></span></li>
          </ul>
        </div>
        <div></div>
      </div>
      <!--<div id="newsletter-search" class="col-xs-12 col-sm-9 col-md-9 thssearch" >
      <label for="newsletter" class="col-xs-12 col-sm-3 col-md-4 subscr"><?php echo t('Subscribe for LookBook');?></label>
      <input id="newsletter" class="col-xs-9 col-sm-7 col-md-6" value="" type="text">
      <button id="subscribeMail" class="col-xs-3 col-sm-2 col-md-2" type="button"><?php echo t('SUBSCRIBE');?></button>
      <div id="subMsg" style="color:red;"></div>
    </div>-->
    </div>
  </div>
</div>
<div class="ft-Bottom">
  <div class="ft-Wraper">
    <div class="copy-wright">
      <ul class="copywright-text">
        <li><a href="#">  <?php echo t('Terms and Conditions');?></a></li>
        <li><a href="<?php echo url('sonata/privacy-policy');?>"> <?php echo t('Privacy Policy');?> </a></li>
        <li><span><?php echo t('© Sonata eCommerce Pvt. Ltd');?> <span class="current-year">2016</span> </span></li>
      </ul>
    </div>
    <div class="content-securityBadges">
      <img alt="Secure Shopping Badges" src="<?php echo current_theme_path() ?>/images/securityBadges.png">
    </div>
  </div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
<!--<div style="display: none;">
  <?php
    if (!empty($GLOBALS['user_login_form'])) {
      echo render($GLOBALS['user_login_form']);
    }
  ?>
</div>-->
