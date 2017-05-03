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
            <?php if($GLOBALS['user']->uid != 0):?>
              <li><a href="#">My Account</a></li>
            <?php endif; ?>
            <li><a href="#">Track Order</a></li>
            <li><a href="#">Wish List</a></li>
            <?php if($GLOBALS['user']->uid == 0):?>
              <li><a href="#">Sign Up</a></li>
              <li><a href="#">Sign In</a></li>
            <?php endif; ?>
          </ul>
      </div>
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
                            <input type="text" placeholder="<?php echo t('search website');?>" name="searchText" id="searchText" class="ui-autocomplete-input" autocomplete="off">
                            <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                            <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                          </div>
                          <!-- <div id="searchButton">
                            <input type="image" class="searchSubmit" value="Search" src="<?php print current_theme_path() .'/images/search.png'; ?>">
                          </div> -->
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