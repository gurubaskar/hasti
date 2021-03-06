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
require_once 'vendor/autoload.php';
  $language_param = variable_get('locale_language_negotiation_session_param', 'language');
  $main_menu_suffix = (empty($_SESSION[$language_param]) || @$_SESSION[$language_param] == 'en') ? '-en' : '-' . $_SESSION[$language_param];
  $main_menu_name = 'main-menu-' . $drubiz_domain['catalog'] . $main_menu_suffix;
  $menu_tree = menu_tree_output(menu_tree_all_data($main_menu_name));
  $search_filter_sidebar = !empty($page['search_filter_sidebar']);

  $drubiz_category_names = json_decode(json_decode(json_encode(variable_get('drubiz_category_names'))),true);
  $drubiz_subcategory_images = json_decode(variable_get('drubiz_subcategory_images'));


  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
  $product = $system_data->product_raw;
  //krumo($product);
  $drubiz_category_names1 = json_decode(variable_get('drubiz_category_names', '[]'), TRUE);
  // $category_names_from_catalog = $drubiz_category_names['globus'];
  $get_category_names = explode(',', $product->product_category_id);

  $catalogName = $drubiz_domain['catalog'];
  //print_r($_SERVER);
?>

<?php 
  $cntCategory = count($get_category_names);
  $cname = "";
  $collon = rawurlencode(":");
  $smCatalog = "?f[0]=sm_field_catalog".$collon.$catalogName;
  $smCategory= "";
  $smCategoryName = "";
  $smSubCategoryName = "";
  /*for($i=0;$i<$cntCategory;$i++) {
    if($i==0) {
      $smCategory = "&f[1]=sm_field_category_id".$collon;
      // $smCategoryName = urlencode($drubiz_category_names[$catalogName][trim($get_category_names[$i])]);
      $smCategoryName = trim($get_category_names[$i]);
    }
    // $smFieldName = str_replace('&', '&amp;',$drubiz_category_names[$catalogName][trim($get_category_names[$i])]);
    $smFieldName = trim($get_category_names[$i]);
    // $smSubCategoryName = "&f[2]=sm_field_subcategory".$collon.rawurlencode($smFieldName);
    $smSubCategoryName = "&f[2]=sm_field_subcategory_id".$collon.rawurlencode($smFieldName);
    $c = $get_category_names[$i];
    $url = url('search/site').$smCatalog.$smCategory.$smCategoryName.$smSubCategoryName;
    if($drubiz_category_names[$catalogName][trim($get_category_names[$i])])
    $breadcrumbList .= "<a href=$url>".$drubiz_category_names[$catalogName][trim($get_category_names[$i])]."</a>/";
  }*/
  $breadcrumbList = '';
  for($i=0;$i<$cntCategory;$i++) {
    if($i==0) {
      $smCategory = "&f[1]=sm_field_category_id".$collon;
      $smCategoryName = trim($get_category_names[$i]);
      $url = url('search/site').$smCatalog.$smCategory.$smCategoryName.$smSubCategoryName;
      $breadcrumbList .= "<a href=$url>".$drubiz_category_names[$catalogName][trim($get_category_names[$i])]."</a>/";
    }
    if($i == 1) {
      $smFieldName = trim($get_category_names[$i]);
      $smSubCategoryName = "&f[2]=sm_field_subcategory_id".$collon.rawurlencode($smFieldName);
      // $c = $get_category_names[$i];
      $url = url('search/site').$smCatalog.$smCategory.$smCategoryName.$smSubCategoryName;
      if($drubiz_category_names[$catalogName][trim($get_category_names[$i])])
      $breadcrumbList .= "<a href=$url>".$drubiz_category_names[$catalogName][trim($get_category_names[$i])]."</a>/";
    }
    if($i == 2) {
      $smFieldName = trim($get_category_names[1]);
      $smSubCategoryName = "&f[2]=sm_field_subcategory_id".$collon.rawurlencode($smFieldName);
      // $c = $get_category_names[$i];
      $smFieldName1 = trim($get_category_names[$i]);
      $smSubCategoryName1 = "&f[3]=sm_field_sub_subcategory_id".$collon.rawurlencode($smFieldName1);
      // $c = $get_category_names[$i];
      $url = url('search/site').$smCatalog.$smCategory.$smCategoryName.$smSubCategoryName.$smSubCategoryName1;
      if($drubiz_category_names[$catalogName][trim($get_category_names[$i])])
      $breadcrumbList .= "<a href=$url>".$drubiz_category_names[$catalogName][trim($get_category_names[$i])]."</a>/";
    }
  }

  $homeurl = url();
  $home = "<a href=$homeurl>Home</a>&nbsp;/&nbsp;";
?>

<div id="topnav">
  <div class="container-fluid">
      <div class="col-xs-12 col-sm-7 col-md-6 header-content">
        <p>Every purchase made on Hastti is a step towards a better lifestyle and sustainable livelihoods</p>
      </div>
      <div class="col-xs-12 col-sm-5 col-md-6 siteHeaderLinks">
          <ul>
            <?php if($GLOBALS['user']->uid == 0) { ?>
              <li><a href="#signInWindow" id="signInPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()" data-ajax="false"><?php echo t('Track Order');?></a></li>
              <li><a href="#signInWindow" id="signInPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()" data-ajax="false">Wish List</a></li>
            <?php } else { ?>
              <li><a href="<?php echo url('account/track-order');?>"><?php echo t('Track Order');?></a></li>
              <li><a href="<?php echo url('account/love-list')?>" data-ajax="false">Wish List</a></li>            
            <?php } if($GLOBALS['user']->uid != 0):?>
              <li><a href="<?php echo url('account/orders');?>"><?php echo t('Hi ');?><?php echo $_SESSION['drubiz']['session']['firstName']; ?></a></li>
              <li><a href="<?php echo url('user/logout');?>" data-ajax="false">LOGOUT</a></li>
            <?php endif; ?>
            <?php if($GLOBALS['user']->uid == 0):?>
              <li><a href="#positionWindow" id="signUpPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignUp()">Sign Up</a></li>
              <li><a href="#signInWindow" id="signInPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()">Sign In</a></li>
            <?php endif; ?>
          </ul>
      </div>
  </div>
</div>
<div data-role="popup" id="positionWindow" class="ui-content signin" style="max-width:700px">
<div id="signUpPopup">
  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right" id="closetag">Close</a>
  <h3>Sign up</h3>
  <div id="signup_errormsgs" style=""></div>
  <form method="post" action="<?php echo url('drubiz/user') ?>" id="signUpForm" name="signUpForm">       
    <input type="text" name ="firstName" placeholder="<?php echo t('* First Name');?>" 
      data-msg-required="The First Name is required." id="" data-rule-required="true">    
    <input type="text" name="lastName" placeholder="<?php echo t('* Last Name');?>" 
      data-msg-required="The Last Name is required." id="" data-rule-required="true">   
    <input type="text" name="PHONE_MOBILE_CONTACT_OTHER" placeholder="<?php echo t('* Mobile');?>" data-msg-required="The Mobile number is required." id="" data-rule-required="true" data-rule-number="true" data-rule-minlength="10">
    <input type="text" name="userLoginId" placeholder="<?php echo t('* Email Id');?>" 
      data-msg-required="The Email Id is required." id="" data-rule-required="true" data-rule-email="true">
    <input type="password" name="currentPassword" placeholder="<?php echo t('* Password');?>" data-msg-required="The Password is required." id="" data-rule-required="true" data-rule-minlength="6">
    <input type="password" name="currentPasswordVerify" placeholder="<?php echo t('* Re-enter');?>" data-msg-required="The Confirm Password is required." id="" data-rule-required="true">
   
    <div class="signin-btn">
<!--      <input type="button" value="Save" id="signin" onclick="hastiSignIn();">-->
      <input type="submit" value="Sign Up" id="signin">
    </div>
  </form>
</div>
</div>

<div data-role="popup" id="signInWindow" class="ui-content signin" style="max-width:700px">
<div id="signInPopup">
  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right" id="closetag">Close</a>
  <h3>Sign in</h3>
  <div id="signin_errormsgs" style=""></div>
  <form method="post" action="<?php echo url('drubiz/user') ?>" id="signInForm" name="signInForm">
    <input type="text" name="USERNAME" placeholder="<?php echo t('* User Name');?>" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>"  data-msg-required="The username is required." id="USERNAME" data-rule-required="true">
    <input type="password" name="PASSWORD" placeholder="<?php echo t('* Password');?>" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" data-msg-required="The Password is required." id="PASSWORD" data-rule-required="true">
    <span class="remember">
    <input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["username"])) { ?> checked <?php } ?> /><span>
    Remember Me</span></span>
  <div class="signin-btn">
    <!--input type="button" value="Sign In" id="signin" onclick="signInHasti();"-->
    <input type="submit" value="Sign In" id="signin">
    <span class="forgot-pwd"><a href="#" onclick="openForgotPassword()">Forgot Password?</a></span>
    <span class="new-signup"><i>New Member?</i> <a href="#" id="newmember_signup">Sign Up</a></span>
  </div>
    </form>
  <span class="facebook">
  <?php $_SESSION['page_url'] = $_SERVER['HTTP_REFERER'];?>
  <a href="<?php echo url('facebook-config.php')?>">SIGN IN WITH FACEBOOK</a></span>
  <span class="google"><a href="<?php echo url('google-config.php')?>">SIGN IN WITH GOOGLE</a></span>
    </div>
  <div id="forgotPopup">
  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
  <h3>Forgot Password</h3>
 
  <form method="post" action="<?php echo url('forgotPassword') ?>" id="forgotpwdForm" name="forgotpwdForm">
  <p>Enter your Email Address here to receive a new password</p>
   <div id="forgot_errormsgs" style=""></div>
  <input type="text" id="emailid" placeholder="* Email Id" data-msg-required="The Email Id is required." id="" data-rule-required="true" data-rule-email="true">
  <div class="forgot-btn">
     <input type="submit" value="Continue" id="Continue">
    <!--input type="button" value="Continue" id="Continue" onclick="checkEmail();"-->
    <input type="button" value="Back" id="back" onclick="closeForgotPassword();">
  </div>
</form>
  </div>
</div>
<!-- header -->
<div id="header">
  <div class="container-fluid">
    <div class="col-xxs-10 col-xs-8 col-sm-4 col-md-8 col-lg-8" id="navbar">
        <div class="mob-nav"></div>
        <?php if ($logo): ?>
          <a class="logo navbar-btn pull-left" data-ajax="false" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
            <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
            </a>
        <?php endif; ?>
        <div class="menu" id="eCommerceNavBar">
          <ul id="eCommerceNavBarMenu">
            <?php foreach ($menu_tree as $menu_id => $menu): if (!is_numeric($menu_id)) continue; ?>
              <li class="topLevel">
                <a data-ajax="false" class="topLevel" href="<?php echo url($menu['#href'], array('query' => @$menu['#localized_options']['query'])) ?>">
                  <?php echo $menu['#title'] ?>
                </a>
                <?php if (!empty($menu['#below'])): ?>
                  <!--<div class="mainDiv" style="display:none;">-->
                    <ul class="subCategoryNav" style="display: none;">
                      <?php foreach ($menu['#below'] as $sub_menu_id => $sub_menu): if (!is_numeric($sub_menu_id)) continue; ?>
                        <li class="subLevel">
                          <a data-ajax="false" class="subLevel" href="<?php echo url($sub_menu['#href'], array('query' => @$sub_menu['#localized_options']['query'])) ?>">
                            <?php echo $sub_menu['#title'] ?>
                          </a>
                          <?php if (!empty($sub_menu['#below'])): ?>
                            <ul class="subCategoryNav">
                              <?php foreach ($sub_menu['#below'] as $sub_sub_menu_id => $sub_sub_menu): if (!is_numeric($sub_sub_menu_id)) continue; ?>
                                <li class="subLevel">
                                  <a data-ajax="false" class="subLevel" href="<?php echo url($sub_sub_menu['#href'], array('query' => @$sub_sub_menu['#localized_options']['query'])) ?>">
                                    <?php echo $sub_sub_menu['#title'] ?>
                                  </a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          <?php endif; ?>
                          <!-- menu image -->
                         <?php 
                           // $get_category_id = array_search($sub_menu['#title'],$drubiz_category_names['hasti']);
                           $parentCategoryTitle = $menu['#title'];
                           $subCategoryTitle = $sub_menu['#title'];
                           $menuImageURL = @$drubiz_subcategory_images->$catalogName->$parentCategoryTitle->$subCategoryTitle;
                           if(!empty($menuImageURL) and $menuImageURL != NULL) {
                           ?>
                            <img src="<?php echo current_theme_path() . '/images/' .$menuImageURL;?>" style="width: 230px; height: 250px; " />
                           <?php } ?>
                          <!-- menu image -->
                        </li>
                      <?php endforeach; ?>
                    </ul>
                    <!--<div class="menuimgDiv" style="display:none;">--><!-- <img src="<?php echo current_theme_path() ?>/images/Women_-Banner_1.jpg" alt="banner"> </div>-->
                    <!--<div class="subUlDiv">-->
                    <!--</div>-->
                  <!--</div>-->
                <?php endif; ?>

                </li>
              <?php endforeach; ?>
            </ul>
        </div>
      </div>
      <div class="col-xxs-2 col-xs-4 col-sm-8 col-md-4 col-lg-4 search-section">
        <div class="cart">
          <a href="<?php echo url('cart') ?>" data-ajax="false" title="My Cart">
          <span class="count" id="mini-cart-count"></span></a>
        </div>
        <img src="<?php print current_theme_path();?>/images/search.png" class="mobsearch-icon">
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
      </div>
      <div class="mob-search">
        <form id="frmSearchForm-resp" name="frmSearchForm" method="get">
            <!-- <fieldset class="formstyle" title="Search this site..."> -->
              <div id="searchContainer" class="targetMobile" style="display: block;">
                <div id="searchField">
                  <input type="text" placeholder="<?php echo t('search website');?>" name="searchText" id="searchText-resp" class="ui-autocomplete-input" autocomplete="on">
                  <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                  <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                </div>
                <!-- <div id="searchButton">
                  <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                </div> -->
              </div>
              <div id="solr-suggestions-resp" class="input-group">
              </div>
            <!-- </fieldset> -->
            <div class="searchErrorMsg" style="color:red"></div>
            <div class="searchAutoComplete" id="searchAutoComplete"></div>
          </form>
        <!-- <input type="text" name="" id="" class="mob-input">  -->
        <input type="image" class="mobsearch-icon1" src="<?php print current_theme_path();?>/images/search.png">
      </div>
  </div>
</div>
<!-- content -->
<?php
  $homePageTitle = 'homepage';
  $nl = node_load(arg(1));
  if($homePageTitle == strtolower($nl->title)) {
    ?>
    <style type="text/css">
      .static-content h1 {display: none;}
      #content {padding-top: 132px;}
    </style>
    <?php
  }
?>
<div id="eCommercePageBody"></div>
  <?php //print_r($drubiz_domain);?>
  <div id="content" class="plp">
    <?php
      if(arg(0) == "node" || arg(0) == "search") {
      if(arg(0) != "node") {
        if ($breadcrumb):
    ?>
      <div id="breadcrumb">
         <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php print clean_breadcrumb($breadcrumb); ?>
            </div>
          </div>
      </div>
      <?php endif;
      } 
      if (arg(0) == 'node' && is_numeric(arg(1))) { 
          $node = node_load(arg(1));
        if ( $node->type == 'product' ) {        
        ?>
      <div id="breadcrumb">
         <div class="container-fluid">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php echo $home . $breadcrumbList.'&nbsp;'.$product->product_name;?>
            </div>
          </div>
      </div>
    <?php } } } ?>
    <div class="container-fluid">
      <?php if ($search_filter_sidebar): ?>
          <div class="col-xs-0 col-sm-3 col-md-3">
            <div class="plp-left">
            <div class="left-wrap">
              <ul>
                <?php echo render($page['search_filter_sidebar']) ?>
              </ul>
            </div>
            </div>
          </div>

      <?php endif; ?><?php /*if ($page['left_menu']): ?>
      <div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">        
        <?php print render($page['left_menu']); ?>
      </div>
       <?php endif; */?>
       <!--div class="col-xs-12 col-sm-12 col-md-12 myaccount-right"-->
      <?php //print render($page['content']); ?>

      <?php //endif; ?>
      <?php // if ($page['left_menu']): ?>
      <!-- <div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">         -->
        <?php // print render($page['left_menu']); ?>
      <!-- </div> -->
       <?php //endif; ?>
      <!-- <div class="col-xs-12 col-sm-8 col-md-9 myaccount-right"> -->
      <?php print render($page['content']); ?>
      <?php //print render($page['homepage_block_1']); ?>
      <?php //print render($page['homepage_block_2']); ?>
      <?php //print render($page['homepage_block_3']); ?>

      <!-- </div>       -->
    </div>
  </div>
 
<!-- Footer -->
<div id="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 links-wrap">
          <div class="col-xs-12 col-sm-3 col-md-3 links">
            <h3>Get to Know Hastti</h3>
            <ul>
              <li><a href="<?php echo url('about-us')?>" alt="About Us" target="_blank"><?php echo t('About Us');?></a></li>
              <li><a href="#" alt="Press Release" target="_blank"><?php echo t('Press Release');?></a></li>
              <li><a href="#" alt="News & Events" target="_blank"><?php echo t('News & Events');?></a></li>
              <!--<li><a href="<?php echo url('faq')?>" alt="Site Map" target="_blank"><?php echo t('Site Map');?></a></li> 
              <li><a href="<?php echo url('story-list')?>" alt="Story List" target="_blank"><?php echo t('Story List');?></a></li>-->           
            </ul>
          </div>
          <div class="col-xs-12 col-sm-3 col-md-3 links">
            <h3>Help</h3>
            <ul>
              <li><a href="<?php echo url('cancellation-returns')?>" alt="Cancellation & Returns" target="_blank"><?php echo t('Cancellation & Returns');?></a></li>
              <li><a href="<?php echo url('shipping-policy')?>" alt="Shipping Policy" target="_blank"><?php echo t('Shipping Policy');?></a></li>
              <li><a href="<?php echo url('contact-us')?>" alt="Contact Us"><?php echo t('Contact Us');?></a></li>
              <?php if($GLOBALS['user']->uid == 0) { ?>
              <li><a href="#signInWindow" id="signInPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()" alt="Track Orders" ><?php echo t('Track Orders');?></a></li>
              <?php } else { ?>
              <li><a href="<?php echo url('account/track-order');?>" alt="Track Orders" target="_blank"><?php echo t('Track Orders');?></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="col-xs-12 col-sm-3 col-md-3 links">
            <h3>Policies</h3>
            <ul>
              <li><a href="<?php echo url('terms-of-use')?>" alt="Terms Of Use" target="_blank"><?php echo t('Terms Of Use');?></a></li>
              <li><a href="<?php echo url('privacy-policy')?>" alt="Privacy Policy" target="_blank"><?php echo t('Privacy Policy');?></a></li>
              <li><a href="#" alt="Returns Policy" target="_blank"><?php echo t('Returns Policy');?></a></li>
              <!-- policies security-->
              <li><a href="<?php echo url('security')?>" alt="Security" id="securitypolicy" target="_blank"><?php echo t('Security');?></a></li>
            </ul>
          </div>
          <div>

          <div class="col-xs-12 col-sm-3 col-md-3 social-wrap icons-wrap">
            <div class="col-xs-12 col-sm-12 col-md-12 subscribe">
              <div class="row">
                <h3>Subscribe</h3>
                <!-- <select name="contactListId" id="contactListId">
                    <option value="9000">
                      Announcement- New Product Announcements
                    </option>
                    <option value="9010">
                      Newsletter- Product Tips Newsletter
                    </option>
                </select> -->
                <input type="text" name ="emailId" id="emailId" placeholder="<?php echo t('* Email Id');?>" 
                data-msg-required="The Email Id is required." id="" data-rule-required="true">
                <span>
                  <input type="submit" value="Submit" id="js_submitSubscribeBtn">
                </span>
              </div>
            </div>
            
            <h3>Follow Us</h3>
            <ul>
              <li class="facebook"><a href="https://www.facebook.com/Hastti-1385257374900900/" target="_blank"></a></li>
              <li class="google"><a href="https://plus.google.com/u/4/111641175858782258793" target="_blank"></a></li>
              <li class="printrest"><a href="https://in.pinterest.com/hastti1/" target="_blank"></a></li>
              <li class="twitter"><a href="https://twitter.com/hastti_official" target="_blank"></a></li>
              <li class="in"><a href="https://www.instagram.com/hastti_official/" target="_blank"></a></li>
            </ul>
          </div>
        </div>
    </div>
  </div>
</div>