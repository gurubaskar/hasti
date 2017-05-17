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
 * @see bootstrap_preprocess_page()
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see bootstrap_process_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup templates
 */

global $drubiz_domain;
  $language_param = variable_get('locale_language_negotiation_session_param', 'language');
  $main_menu_suffix = (empty($_SESSION[$language_param]) || @$_SESSION[$language_param] == 'en') ? '-en' : '-' . $_SESSION[$language_param];
  $main_menu_name = 'main-menu-' . $drubiz_domain['catalog'];//. $main_menu_suffix;
  $menu_tree = menu_tree_output(menu_tree_all_data($main_menu_name));

  $search_filter_sidebar = !empty($page['search_filter_sidebar']);
?>
<div id="topnav">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-7 col-md-6 header-content">
        <p>Have your greatest experience with us and support the Women of India.</p>
      </div>
      <div class="col-xs-12 col-sm-5 col-md-6 siteHeaderLinks">
          <ul>
            <li><a href="#"><?php echo t('Track Order');?></a></li>
            <li><a href="#"><?php echo t('Wish List');?></a></li>
            <?php if($GLOBALS['user']->uid != 0):?>
              <li><a href="#"><?php echo t('Hi ');?><?php echo $GLOBALS['user']->mail; ?></a></li>
              <li><a href="<?php echo url('user/logout');?>">LOGOUT</a></li>
            <?php endif; ?>
            <?php if($GLOBALS['user']->uid == 0):?>
              <li><a href="#positionWindow" data-rel="popup" data-position-to="window" data-role="button" data-inline="true">Sign Up</a></li>
              <li><a href="#signInWindow" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()">Sign In</a></li>
            <?php endif; ?>
          </ul>
      </div>
    </div>
  </div>
</div>
<div data-role="popup" id="positionWindow" class="ui-content signin" style="max-width:700px">
  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
  <h3>Sign up</h3>
  <form method="post" action="<?php echo url('drubiz/user') ?>" id="signUpForm" name="signUpForm">
    <input type="text" name ="firstName" placeholder="<?php echo t('* First Name');?>" id="">
    <input type="text" name="lastName" placeholder="<?php echo t('* Last Name');?>" id="">
    <input type="text" name="PHONE_MOBILE_CONTACT_OTHER" placeholder="<?php echo t('* Mobile');?>" id="">
    <input type="text" name="userLoginId" placeholder="<?php echo t('* Email Id');?>" id="">
    <input type="password" name="currentPassword" placeholder="<?php echo t('* Password');?>" id="">
    <input type="password" name="currentPasswordVerify" placeholder="<?php echo t('* Re-enter');?>" id="">
  </form> 
  <div class="signin-btn">
    <input type="button" value="Save" id="signin" onclick="hastiSignIn();">
  </div>
</div>
<div data-role="popup" id="signInWindow" class="ui-content signin" style="max-width:700px">

  <div id="signInPopup">
  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
  <h3>Sign in</h3>
  <form method="post" action="<?php echo url('drubiz/user') ?>" id="signInForm" name="signInForm">
    <input type="text" name="USERNAME" placeholder="<?php echo t('* User Name');?>">
    <input type="password" name="PASSWORD" placeholder="<?php echo t('* Password');?>">
  </form>
  <span class="remember"><a href="#">Remember Me</a></span>
  <div class="signin-btn">
    <input type="button" value="Sign In" id="signin" onclick="signInHasti();">
    <span class="forgot-pwd"><a href="#" onclick="openForgotPassword()">Forgot Password?</a></span>
    <span class="new-signup"><i>New Member?</i> <a href="#">Sign Up</a></span>
  </div>
  <span class="facebook"><a href="#">SIGN IN WITH FACEBOOK</a></span>
  <span class="google"><a href="#">SIGN IN WITH GOOGLE</a></span>
  </div>
  <div id="forgotPopup">

  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
  <h3>Forgot Password</h3>
  <p>Enter your Email Address here to receive a new password</p>
  <input type="text" id="emailid" placeholder="* Email Id">
  <div class="forgot-btn">
    <input type="button" value="Continue" id="Continue" onclick="checkEmail();">
    <input type="button" value="Back" id="back" onclick="closeForgot();">
  </div>
  </div>
</div>
<!-- header -->
<div id="header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="col-xs-0 col-sm-0 col-md-8 col-lg-8"></div>
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row">
              <div class="search-wrap col-xs-12 col-sm-12 col-md-12">
                <div class="row">

                  <div class="search">
                    <form id="frmSearchForm" name="frmSearchForm" method="get">
                      <!-- <fieldset class="formstyle" title="Search this site..."> -->
                        <div id="searchContainer" class="targetMobile" style="display: block;">
                          <div id="searchField">
                            <input type="text" placeholder="<?php echo t('search website');?>" name="searchText" id="searchText" class="ui-autocomplete-input" autocomplete="on">
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                            <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                          </div>
                          <!-- <div id="searchButton">
                            <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                          </div> -->
                        </div>
                        <div id="solr-suggestions" class="input-group">
                        </div>
                      <!-- </fieldset> -->
                      <div class="searchErrorMsg" style="color:red"></div>
                      <div class="searchAutoComplete" id="searchAutoComplete"></div>
                    </form>
                  </div>
                  <div class="cart">
                    <a href="<?php echo url('cart') ?>" title="My Cart">
                    <p><span class="count" id="mini-cart-count"></span> Items <span class="cost">Rs. 0.00</span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12" id="navbar">
        <div class="row">
          <div class="col-xs-2 col-sm-2 col-md-2">
            <?php if ($logo): ?>
              <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
                <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
              </a>
            <?php endif; ?>
              <!-- <img src="images/logo.png" alt="hasti" title="hasti" /> -->
          </div>
          <div class="col-xs-10 col-sm-10 col-md-10 menu">
            <?php print render($page['header']); ?>      
              <!-- <ul>
                <li><a href="#">Women</a></li>
                <li><a href="#">Men</a></li>
                <li><a href="#">Kids</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Food</a></li>
                <li><a href="#">Craft</a></li>
              </ul> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content -->
<?php //print_r($drubiz_domain);?>
<?php if ($breadcrumb): ?>
  <div id="breadcrumb"><?php print clean_breadcrumb($breadcrumb); ?></div>
<?php endif; ?>
<div id="content" class="plp">
  <div class="container-fluid">

  <?php if ($search_filter_sidebar): ?>
      <div id="" style="display: block;">
        <div class="col-xs-0 col-sm-3 col-md-3 plp-left">
        <div class="left-wrap">
          <ul>
            <?php echo render($page['search_filter_sidebar']) ?>
          </ul>
        </div>
        </div>
      </div>
    <?php endif; ?>

    <?php print render($page['content']); ?>      
  </div>
</div> 
<!-- Footer -->
<div id="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <?php print render($page['footer_menu_1']); ?>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
        <?php print render($page['footer_menu_2']); ?>
      </div>
      <!-- Footer Social Icons -->
      <?php print render($page['footer_social']); ?>
    </div>
  </div>
</div>