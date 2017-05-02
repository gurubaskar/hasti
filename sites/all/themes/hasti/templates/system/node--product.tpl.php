<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
  $product = $system_data->product_raw;
  $drubiz_category_names = json_decode(variable_get('drubiz_category_names', '[]'), TRUE);
  $category_names_from_catalog = $drubiz_category_names['globus'];
  $get_category_names = explode(',', $product->product_category_id);
  $category_names = $category_names_from_catalog[$get_category_names[2]];
  $category = strtolower($category_names);
  $category_name = str_replace(" ", '' , $category);
  $selected_features = get_selected_features($product);
  $facet_values = get_facet_values($system_data, false);
  $share_url = url('node/' . $node->nid, array('absolute' => TRUE));
  $out_of_stock_info = pdp_out_of_stock_info($node->field_product_id[LANGUAGE_NONE][0]['value']);
  $out_of_stock = $out_of_stock_info->availableQuantity;
  // krumo($node);
  // krumo($out_of_stock_info->availableQuantity , $facet_values);
  // krumo($sku);
?>
<div id="content" class="pdp">
  <div class="container-fluid">
    <!-- <div class="row"> -->
      <div class="col-xs-12 col-sm-12 col-md-12 breadcrumb"><h3>Women / Clothing / Women Long Kurti</h3></div>
      <div class="col-xs-12 col-sm-6 col-md-5 pdp-left">
        <div class="zoom-wrap">
          <div class="col-xs-2 col-sm-2 col-md-2 pleft thumb-wrap">
            <img src="<?php print current_theme_path() .'/images/pdp-thumb1.jpg'; ?>" class="img-responsive" />
          </div>
          <div class="col-xs-10 col-sm-10 col-md-10 pleft pright zoom-img">
            <img src="<?php print current_theme_path() .'/images/pdp-zoom1.jpg'; ?>" class="img-responsive" />
          </div>
        </div>
        <div class="price-wrap">
          <h2>Transparent Price</h2>
          <p>We believe customers have the right to know what their products costs to make</p>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-7 pdp-right">
        <div class="title">
          <h2><?php echo $node->title ?></h2>
          <span class="price">Rs. <?php echo $product->sales_price; ?></span>
        </div>
        <div class="size">
          <span class="available">Available Sizes</span>
          <!-- varients -->
           <?php foreach ($facet_values as $facet_name => $this_facet_values): ?>
              <li class="string selectableFeature pdpSelectableFeature">
                <?php if(strtolower($facet_name) == 'size' || strtolower($facet_name) == 'color') { ?>
                  <label><?php echo($facet_name) . ':'; ?></label>
                    <div class="pdpSelectableFeature">
                      <div class="selectableFeatures <?php echo strtoupper($facet_name) ?>">
                        <div id="size-wrapper">
                          <div class="forgot-area">
                            <ul class="js_selectableFeature_1">
                            <?php $countFacet=0; ?>
                              <?php foreach ($this_facet_values as $this_facet_value => $this_facet_product_id): ?>
                                
                                <li class="<?php echo $this_facet_value ?>" id="selectableFeature_<?php echo ++$countFacet; ?>">
                                  <a class="product-choose-facet" href="#" data-product-id="<?php echo $this_facet_product_id ?>"><?php echo $this_facet_value ?></a>
                                </li>
                                
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php } ?>
              </li>
            <?php endforeach; ?>

          <ul>
            <li>
              <input type="checkbox">
              <label>S</label>
            </li>
            <li>
              <input type="checkbox">
              <label>M</label>
            </li>
            <li>
              <input type="checkbox">
              <label>L</label>
            </li>
            <li>
              <input type="checkbox">
              <label>XL</label>
            </li>
            <li>
              <input type="checkbox">
              <label>XXL</label>
            </li>
          </ul>
          <div class="sizechart"><p>Not Sure? <span><a href="#">See Size Chart</a></span></p></div>
          <p>The mode (height 5'8". chest 33" and wast 28")</p>
        </div>
        <div class="color">
          <span class="available">Available Colors</span>
          <ul>
            <li class="white"></li>
            <li class="black"></li>
            <li class="red"></li>
            <li class="blue"></li>
            <li class="green"></li>
          </ul>
        </div>
        <div class="btns-wrap">
          <span><a href="#" class="wish-icon">Add to wish list</a></span>
          <?php if($out_of_stock <= 0) { ?>
            <span><a href="#" class="add-bag">Add to Bag disabled</a></span>
          <?php } else { ?>
          <span><a href="#" class="add-bag">Add to Bag</a></span>
          <?php } ?>
          <span><a href="#" class="buy-now">Buy Now</a></span>
        </div>
        <p><?php echo $body[0]['safe_value'] ?></p>
        <div class="story-wrap">
          <h2>Story</h2>
          <p><?php echo $body[0]['safe_value'] ?></p>
          <div class="storyimg-wrap">
            <div class="col-xs-12 col-sm-12 col-md-12 pleft pright-five">
              <div class="img-wrap">
                <img src="<?php print current_theme_path() .'/images/pdp-rimg1.jpg'; ?>" class="img-responsive" />
                <img src="<?php print current_theme_path() .'/images/pdp-rimg2.jpg'; ?>" class="img-responsive" />
                <img src="<?php print current_theme_path() .'/images/pdp-rimg6.jpg'; ?>" class="img-responsive" />
              </div>
              
              <div class="video">
                <a href="#"><img src="<?php print current_theme_path() .'/images/pdp-rvedio.jpg'; ?>" class="img-responsive" /></a>
                <img src="<?php print current_theme_path() .'/images/pdp-rimg5.jpg'; ?>" class="img-responsive" />
              </div>
              
            </div>
            <div class="btns-wrap">
              <span><a href="#">Share this story</a></span>
              <span><a href="#">Your Feedback</a></span>
            </div>
          </div>
        </div>
      </div>
    <!-- </div> -->
  </div>
</div>