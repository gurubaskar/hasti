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
  //$messages = '';
  //print $messages;
  
  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
  $product = $system_data->product_raw;
  $product_associations = $system_data->product_associations;
  
  $drubiz_category_names = json_decode(variable_get('drubiz_category_names', '[]'), TRUE);
  $category_names_from_catalog = $drubiz_category_names['hasti'];
  $get_category_names = explode(',', $product->product_category_id);
  $category_names = $category_names_from_catalog[$get_category_names[2]];
  $category = strtolower($category_names);
  $category_name = str_replace(" ", '' , $category);
  $selected_features = get_selected_features($product);
  $facet_values = get_facet_values($system_data, false);
  $share_url = url('node/' . $node->nid, array('absolute' => TRUE));
  $out_of_stock_info = pdp_out_of_stock_info($node->field_product_id[LANGUAGE_NONE][0]['value']);
  $out_of_stock = $out_of_stock_info->availableQuantity;
  $rating = displayPDPReviewandRating($product->product_id);
  //krumo($product);
  $pdpList = displayPDPList($product->product_id);
  $ofbiz_url = variable_get("drubiz_ofbiz_url");
  // krumo($out_of_stock_info);
  // krumo($out_of_stock_info->availableQuantity , $facet_values);
  $variantsData = $system_data->product_variants;
  $product_id = $product->product_id;
  $isMasterProduct = false;
  if(array_key_exists($product_id, get_object_vars($variantsData))) {
    $isMasterProduct = true;
  }
  $availableVariant = '';
  if(!$isMasterProduct) {
     $key = array('Colour','Size');
     $availableKey = array_intersect_key(array_flip($key), $facet_values);
     if(count($availableKey) == 1) {
       $variantKey = array_keys($availableKey);
       $availableVariant = $variantKey[0];
     }
    $size_exist = array_key_exists('Size', $facet_values);
    $colour_exist = array_key_exists('Colour', $facet_values);
  }
?>
<div id="eCommerceProductDetailContainer" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

<div id="content" class="pdp">
  <div class="review-message"><?php
      
           if ($messages): print $messages; endif;
  
        ?>
  <!-- <div class="container-fluid"> -->
    <!-- <div class="row"> -->
      <!-- <div class="col-xs-12 col-sm-12 col-md-12 breadcrumb"><h3>Women / Clothing / Women Long Kurti</h3></div> -->
      <div class="col-xs-12 col-sm-6 col-md-5 pdp-left">
        <!-- <div class="zoom-wrap"> -->
          <!-- <div class="col-xs-2 col-sm-2 col-md-2 pleft thumb-wrap">
            <img src="<?php print current_theme_path() .'/images/pdp-thumb1.jpg'; ?>" class="img-responsive" />
          </div>
          <div class="col-xs-10 col-sm-10 col-md-10 pleft pright zoom-img">
            <img src="<?php echo drubiz_image($product->pdp_regular_image); ?>" class="img-responsive" />
          </div> -->

        <div class="PDP group group1 zoom-wrap">
          <ul class="displayList pdpList PDP">
            <div class="col-xs-2 col-sm-2 col-md-2 pleft thumb-wrap">
                <li class="image mainImage pdpMainImage thumb" style="display: block;">
                  <div class="pdpAlternateImage">
                    <div id="js_eCommerceProductAddImage">

                       <div id="js_altImageThumbnails" class="bxslider mCustomScrollbar _mCS_1" style="height:630px"><div id="mCSB_1" class="mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px;" dir="ltr">

                        <div id="addImageLink_li"><a href="javascript:void(0);" style="border:1px solid #eee;" id="mainAddImageLink" onclick="javascript:replaceDetailImage('<?php echo drubiz_image($product->pdp_regular_image) ?>','<?php echo drubiz_image($product->pdp_large_image) ?>');"><img src="<?php echo drubiz_image($product->pdp_thumbnail_image) ?>" id="mainAddImage" name="mainAddImage" vspace="5" hspace="5" alt="" class="productAdditionalImage mCS_img_loaded" height="102" width="88" onerror="onImgError(this, 'PDP-Alt');" data-ajax="false"></a></div>

                        <?php foreach (range(1, 10) as $img_n): $img_prefix = "pdp_alt_{$img_n}"; if (empty($product->{$img_prefix . '_large_image'})) continue; ?>
                          <div id="addImage<?php echo $img_n ?>Link_li"><a href="javascript:void(0);" style="border:1px solid #eee;" id="addImage<?php echo $img_n ?>Link" onclick="javascript:replaceDetailImage('<?php echo drubiz_image($product->{$img_prefix . '_large_image'}) ?>','<?php echo drubiz_image($product->{$img_prefix . '_large_image'}) ?>');"><img src="<?php echo drubiz_image($product->{$img_prefix . '_thumbnail_image'}) ?>" name="addImage1" id="addImage1" vspace="5" hspace="5" alt="" class="productAdditionalImage mCS_img_loaded" height="102" width="88" onerror="onImgError(this, 'PDP-Alt');" data-ajax="false"></a></div>
                        <?php endforeach; ?>

                       </div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-dark-3 mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 580px; max-height: 620px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                    </div>
                  </div>
                </li>
            </div>
            <div class="col-xs-10 col-sm-10 col-md-10 pleft pright zoom-img">
              <li class="image mainImage pdpMainImage">
                <div class="pdpMainImage">
                  <div id="js_productDetailsImageContainer" onclick="displayDialogBox('largeImage_')">
                    <a href="<?php echo drubiz_image($product->pdp_large_image) ?>" class="innerZoom" rel="undefined" title="" style="outline-style: none; text-decoration: none;" data-ajax="false">
                      <div class="zoomPad"><img data-zoom-image="<?php echo drubiz_image($product->pdp_regular_image); ?>" src="<?php echo drubiz_image($product->pdp_regular_image) ?>" name="mainImage" class="js_productLargeImage" height="630" width="490" onerror="onImgError(this, 'PDP-Large');" id="js_mainImage" title="" style="opacity: 1; display: block;"><div class="zoomPup" style="display: none; top: -1px; left: 223px; width: 266px; height: 330px; position: absolute; border-width: 1px;"></div><div class="zoomWindow" style="position: absolute; z-index: 5001; cursor: default; left: 0px; top: 0px; display: none;"><div class="zoomWrapper" style="border-width: 1px; width: 490px; cursor: crosshair;"><div class="zoomWrapperTitle" style="width: 100%; position: absolute; display: block;">undefined</div><div class="zoomWrapperImage" style="width: 100%; height: 630px;"><img src="<?php echo drubiz_image($product->pdp_alt_1_large_image) ?>" style="position: absolute; border: 0px; display: block; left: -411.429px; top: 0px;"></div></div></div><div class="zoomPreload" style="visibility: hidden; top: 293.5px; left: 245px; position: absolute;"></div></div>
                    </a>
                  </div>
                </div>
              </li>
            </div>
            <!-- </div> -->
          </ul>
           <!-- </div> -->
          <script type="text/javascript">
            jQuery( function() {
               jQuery("#tabs").tabs();
            } );
            jQuery(document).ready(function(){
              jQuery('.alert-danger').css('display', 'none');
              jQuery(window).resize(function() {

               width = jQuery(window).width();
               if(jQuery(window).width() > 900){
                jQuery('#js_altImageThumbnails').mCustomScrollbar({
                  theme:"dark-3",
                });
              }
             if(width < 768  )
             { 

              //jQuery(".pdpImgCaurosel").css("display","block");
              //jQuery("#js_mainImage").css("display","none");
              //jQuery(".image.mainImage.pdpMainImage.thumb").css("display","none");
              jQuery(".pdpImgCaurosel").bxSlider({
                slideWidth: 350,
                minSlides: 2,
                moveSlides: 1,
                maxSlides: 1,
                slideMargin:10
              });
            }
            else{
              //jQuery(".pdpImgCaurosel").css("display","none");
              //jQuery("#js_mainImage").css("display","block");
              //jQuery(".image.mainImage.pdpMainImage.thumb").css("display","block");
            }

            var maxSlides=3;
            var slideMargin=50;
            if (width > 1000) {
              maxSlides = 4;
            }
            else if(width >480 && width<700) {
              maxSlides = 2;
            }
            else{
              if (width < 490) {
                maxSlides = 1;
              }
            }
        var slider=jQuery('.slider1').bxSlider({
        slideWidth: 200,
        responsive : true,
        minSlides: 2,
        useCSS: true,
        moveSlides: 1,
        maxSlides: maxSlides,
        slideMargin:10,
        adaptiveHeight: true
      });
  
 /*   jQuery(window).resize(function () {
      if (jQuery(window).width() < 480) {
         slider.reloadSlider({
          mode: 'vertical',
          slideWidth: 200,
          responsive : true,
          minSlides: 1,
          moveSlides: 1,
          maxSlides: maxSlides,
          slideMargin:10,
          adaptiveHeight: true
        });
      }
      else if(jQuery(window).width() < 768) {
         slider.reloadSlider({
            mode: 'vertical',
            slideWidth: 200,
            responsive : true,
            minSlides: 2,
            moveSlides: 1,
            maxSlides: maxSlides,
            slideMargin:10,
            adaptiveHeight: true
          });
        
      }else{
         slider.reloadSlider({
            mode: 'horizontal',
            slideWidth: 200,
            responsive : true,
            minSlides: 1,
            moveSlides: 1,
            maxSlides: maxSlides,
            slideMargin:10,
            adaptiveHeight: true
          });
        
      }     
    });*/


            if(false)
            {
              var thmbSlides=7;
              if (width > 550) {
                thmbSlides = 7;
              }
              else if(width >380 && width<550) {
                thmbSlides = 4;
              }
              else if(width >250 && width<380) {
                thmbSlides = 3;
              }
              else{
                if (width < 250) {
                  thmbSlides = 2;
                }
              }
              jQuery('.bxslider').bxSlider({
                slideWidth: 50,
                minSlides: 1,
                moveSlides: 1,
                maxSlides: thmbSlides,
                slideMargin:10
              });
            }
            }).resize();
            jQuery(".js_productLargeImage").elevateZoom();
            
            });
          </script>

        </div>
       <!--  <div class="price-wrap">
          <h2>Transparent Price</h2>
          <p>We believe customers have the right to know what their products costs to make</p>
        </div> -->
      </div>
      <div class="col-xs-12 col-sm-6 col-md-7 pdp-right">
        <div class="title">
          <div class="title-wrap">
            <?php $manufacturerLogo = getManufacturerLogo($product->product_id);?>
            <h4><?php echo $manufacturerLogo['manufacturerName'];?> </h4>
            <h2><?php echo $node->title ?></h2>
            <span class="price">&#8377;. <?php echo $product->sales_price; ?></span>
            <span><?php
              $overallRating = $rating['overallRating'];
              if($overallRating > 0) {
                $overallAverage = $overallRating * 20;
                $path = drupal_get_path('module', 'fivestar');      
                drupal_add_js($path . '/js/fivestar.js');
                drupal_add_css($path . '/css/fivestar.css');
                echo theme('fivestar_static', array('rating' => $overallAverage, 'stars' => 5, 'tag' => 'vote'));
              }
              ?>
            </span>
          </div>
          <div class="manufacturer">
            <img src="<?php echo $ofbiz_url.$manufacturerLogo['manufacturerImage'] ?>" width="105" onerror="onImgError(this, 'PLP-Thumb');">
          </div>
        </div>
        <?php 
          if(!$isMasterProduct) {
            $var_size=false;
            $var_color=false;
            if($availableVariant == 'Size') {
                $var_size = true;
            }
            if($availableVariant == 'Colour') {
                $var_color = true;
            }
            if($availableVariant == '') {
                $var_size = true;
                $var_color = true;
            }
            if($var_size) { ?>
        <div class="size">
          <span class="available">Available Sizes</span>
          <!-- varients -->
          <ul>
            <?php foreach ($facet_values as $facet_name => $this_facet_values): ?>
              <!-- <li class="string selectableFeature pdpSelectableFeature"> -->
                <?php if(strtolower($facet_name) == 'size') { ?>
                  <!-- <label><?php echo($facet_name) . ':'; ?></label> -->
                    <div class="pdpSelectableFeature">
                      <div class="selectableFeatures_<?php echo strtoupper($facet_name) ?>">
                        <div id="size-wrapper">
                          <div class="forgot-area">
                            <ul class="js_selectableFeature_1">
                            <?php $countFacet=0; ?>
                              <?php foreach ($this_facet_values as $this_facet_value => $this_facet_product_id): ?>
                                <li class="<?php echo $this_facet_value ?>" id="selectableFeature_<?php echo ++$countFacet; ?>">
                                  <a class="product-choose-facet-size" href="#" data-product-id="<?php echo $this_facet_product_id ?>" data-ajax="false"><?php echo $this_facet_value ?></a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php } ?>
              <!-- </li> -->
            <?php endforeach; ?>
          </ul>
          <?php 
            $size_chart = size_chart($product->product_id);
          ?>
          <div class="sizechart"><p>Not Sure? <span><a class="colorbox-inline" href="?inline=true#id-of-content">See Size Chart</a></span></p></div>
          <!-- <p>The mode (height 5'8". chest 33" and wast 28")</p> -->
        </div>
        <?php } ?>
        <div style="display: none;">
        <div id="id-of-content">
          <?php if (array_key_exists("Size Chart",$size_chart)){
              echo $size_chart["Size Chart"];
            }else{
             echo $size_chart["message"];
            }?>
          <!-- <?php //if(isset($product->pdp_size_guide)) { echo $product->pdp_size_guide; } else { echo "Product size not available to this product";}?> --></div>
        </div>
        <!-- Colors -->
        <?php if($var_color) { ?>
        <div class="color">
          <span class="available">Available Colors</span>
          <ul>
            <?php foreach ($facet_values as $facet_name => $this_facet_values): ?>
              <?php if(strtolower($facet_name) == 'colour') { ?>
                <!-- <li class="string selectableFeature pdpSelectableFeature"> -->
                  <!-- <label><?php echo($facet_name) . ':'; ?></label> -->
                    <div class="pdpSelectableFeature">
                      <div class="selectableFeatures_<?php echo strtoupper($facet_name) ?>">
                        <div id="size-wrapper">
                          <div class="forgot-area">
                            <ul class="js_selectableFeature_1">
                            <?php $countFacet1=0; ?>
                              <?php foreach ($this_facet_values as $this_facet_value => $this_facet_product_id): ?>
                                  <?php 
                                  $product_nid = get_nid_from_variant_product_id($this_facet_product_id);
                                  ?>
                                    <a class="product-choose-facet-color" href="#" data-ajax="false">
                                      <?php if(strtolower($this_facet_value) == strtolower('MultiColour')) {
                                        $MultiColourImg = 'multi-color.jpg';
                                        ?>
                                    <li class="<?php echo $this_facet_value ?>" data-nid="<?php echo $nid?>" data-product-id="<?php echo $this_facet_product_id ?>" style="background-image: url('<?php echo drubiz_image($MultiColourImg);?>');" data-facet-color=<?php echo $this_facet_value;?> id="selectableFeature_<?php echo ++$countFacet1; ?>">
                                    </li>
                                    <?php } else { ?>
                                    <li class="<?php echo $this_facet_value ?>" data-nid="<?php echo $nid?>" data-product-id="<?php echo $this_facet_product_id ?>" style="background: <?php echo getColourCode($this_facet_value);?> ;" data-facet-color=<?php echo $this_facet_value;?> id="selectableFeature_<?php echo ++$countFacet1; ?>">
                                    </li>
                                    <?php } ?>
                                  </a>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                <!-- </li> -->
              <?php } ?>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php } 
        } ?>
        <?php
          $stockClass = '';
          $addToCart = 'js_addToCart';
          $buyNow = 'js_addToCart_buynow';
          if($out_of_stock_info->inventory == 'No') :
            $stockClass = 'disabled';
            $addToCart = '';
            $buyNow = '';
          elseif($out_of_stock_info->inventory == 'Yes' && $out_of_stock < $out_of_stock_info->bufferInventory) : 
            $stockClass = "lowstock";
          endif;
        ?>
        <div class="stock">
          <ul>
            <li>
              <span class="instock"></span>In Stock
            </li>
            <li>
              <span class="lowstock"></span>Low Stock
            </li>
            <li>
              <span class="outstock"></span>Out of Stock
            </li>
          </ul>
        </div>
        <div class="btns-wrap">
          <?php if($GLOBALS['user']->uid != 0) { ?>
            <?php if($isMasterProduct) {?>
              <span><a href="#" class="wish-icon" data-master-wish-product-id="<?php echo $product->product_id; ?>" id="js_addToWishlistMaster" data-ajax="false">Add to wish list</a></span>
            <?php } else { ?>
            <span><a href="#" class="wish-icon" id="js_addToWishlist" data-ajax="false" data-wish-variant = <?php echo $availableVariant; ?>>Add to wish list</a></span>
          <?php }
          } else {?>
            <span><a href="#signInWindow" id="signInPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" onclick="openSignIn()" data-ajax="false" class="wish-icon">Add to wish list</a></span>
          <?php } ?>
          <?php if($isMasterProduct) {?>
            <span><a href="#" class="add-bag <?php echo $stockClass;?>" id="js_addToCartMaster" data-master-product-id="<?php echo $product->product_id; ?>">Add to Bag</a></span>
            <span><a href="#" class="buy-now-master <?php echo $stockClass;?>" id="js_addToCartBuyNowMaster" data-master-product-id="<?php echo $product->product_id; ?>">Buy Now</a></span>
          <?php } else { ?>
            <span><a href="#" class="add-bag <?php echo $stockClass;?>" id="<?php echo $addToCart;?>" data-variant = <?php echo $availableVariant; ?>>Add to Bag</a></span>
            <span><a href="#" class="buy-now <?php echo $stockClass;?>" id="<?php echo $buyNow;?>" data-variant = <?php echo $availableVariant; ?>>Buy Now</a></span>
          <?php } ?>
        </div>
        <p><?php echo $body[0]['safe_value'] ?></p>
        <div class="story-wrap">
          <?php $storyInfo = pdp_story_info($product->product_id); 
            if($storyInfo->isError == 'false') :
          ?>
          <h2>Story</h2>
          <?php if(!empty($storyInfo->storyDescription[0]) and $storyInfo->storyDescription[0] != null) { ?>
          <p><?php echo $storyInfo->storyDescription[0]; ?></p>
          <?php } ?>
          <div class="storyimg-wrap">
            <div class="col-xs-12 col-sm-12 col-md-12 pleft pright-five">
              <div class="img-wrap">
                <?php if(!empty($storyInfo->Image1[0]) and $storyInfo->Image1[0] != null) { ?>
                  <img src="<?php print current_theme_path() . $storyInfo->Image1[0] ?>" class="img-responsive" />
                <?php } if(!empty($storyInfo->Image2[0]) and $storyInfo->Image2[0] != null) {?>
                  <img src="<?php print current_theme_path() . $storyInfo->Image2[0] ?>" class="img-responsive" />
                <?php } if(!empty($storyInfo->Image3[0]) and $storyInfo->Image3[0] != null) {?>
                  <img src="<?php print current_theme_path() . $storyInfo->Image3[0] ?>" class="img-responsive" />
                <?php } ?>
              </div>
              <div class="video">
                <?php 
                if(!empty($storyInfo->storyVideo[0]) and $storyInfo->storyVideo[0] != null) {?>
                <span class="video">
                  <a class="colorbox-load" href=<?php print current_theme_path() . $storyInfo->storyVideo[0];?>?width=853&amp;height=480&amp;iframe=true&amp;autoplay=1">
                  <img src="<?php print current_theme_path();?>/images/h-img5.jpg"  class="img-responsive"/></a>
                </span>
                <?php } if(!empty($storyInfo->Image4[0]) and $storyInfo->Image4[0] != null) {?>
                <img src="<?php print current_theme_path() . $storyInfo->Image4[0] ?>" class="img-responsive" />
                <?php } ?>
              </div>
            </div>
          </div>
          <?php endif;?>
          <div class="btns-wrap">
            <span><a href="#" class="shareStory">Share this Product</a></span>
            <span><a href="#" id="review-btn" onclick="reviewAction();">Write a review</a></span>
          </div>
  
          <div style="clear: both; display: none;" id="socialIcons">
            <?php print render($region['social_share']); ?>
          </div>
        </div>
        <div id="reviewForm" style="display: none">
          <?php
            $comments_form = drupal_get_form('drubiz_hasti_comments_form');
            $comments_form['productid_field']['#value'] = $product->product_id;
          // var_dump($comments_form['my_field']['#value']);
              print drupal_render($comments_form);
          ?>
        </div>
       
      </div>
    <!-- </div> -->

    <div id="js_mainImageDiv" style="display:none">
      <a href="">
        <img src="" name="mainImage" data-zoom-image="" class="js_productLargeImage" width="100%" onerror="onImgError(this, 'PDP-Large');">
      </a>
    </div>
    <?php drupal_add_js(drupal_get_path('theme', 'hasti') . '/js/jquery.elevatezoom.js'); ?>
<!--   </div> -->
  
 

  <?php 
$count=0;
if(sizeof($pdpList['pdpList']['artisan']['description']))
  $count ++;
if(sizeof($pdpList['pdpList']['designer']['description']))
  $count ++;
if(sizeof($pdpList['pdpList']['process']['description']))
  $count ++;
if(sizeof($pdpList['pdpList']['rawMaterial']['longDescription']))
  $count ++;

if($count == 3){
    $class = "col-xs-4 col-sm-4 col-md-4";
}elseif ($count == 2) {
  $class = "col-xs-6 col-sm-6 col-md-6";
}elseif ($count == 1) {
  $class = "col-xs-12 col-sm-12 col-md-12";
}else{
    $class = "col-xs-3 col-sm-3 col-md-3";
}
;?>

<div class="panel with-nav-tabs panel-default col-xs-12 col-sm-12 col-md-12 pl0">
    <?php if(sizeof($pdpList['pdpList']['artisan']) || sizeof($pdpList['pdpList']['designer']) || sizeof($pdpList['pdpList']['process']) || sizeof($pdpList['pdpList']['rawMaterial'])) { ?>
    <div class="panel-heading">
      <ul class="nav nav-tabs">
      <?php if(sizeof($pdpList['pdpList']['artisan'])) {?>
      <li class="<?php //echo $class;?> active"><a href="#tab1default" data-toggle="tab"><span><img src="<?php echo drubiz_image('pdptabs/artisan.png');?>" />Artisan</span></a></li>
      <?php }?>
      <?php if(sizeof($pdpList['pdpList']['designer'])) {?>
      <li class="<?php //echo $class;?>"><a href="#tab2default" data-toggle="tab"><span><img src="<?php echo drubiz_image('pdptabs/designer.png');?>" />Designers</span></a></li>
       <?php }?>
       <?php if(sizeof($pdpList['pdpList']['process'])) {?>
      <li class="<?php //echo $class;?>"><a href="#tab3default"  data-toggle="tab"><span><img src="<?php echo drubiz_image('pdptabs/process.png');?>" />Process</span></a></li>
      <?php }?>
      <?php if(sizeof($pdpList['pdpList']['rawMaterial'])) {?>
      <li class="<?php //echo $class;?>"><a href="#tab4default" data-toggle="tab"><span><img src="<?php echo drubiz_image('pdptabs/rawmaterial.png');?>" />Raw Material</span></a></li>
      <?php }?>
      </ul>
    </div>
    <?php } ?>

    <?php if(sizeof($pdpList['pdpList']['artisan']) || sizeof($pdpList['pdpList']['designer']) || sizeof($pdpList['pdpList']['process']) || sizeof($pdpList['pdpList']['rawMaterial'])) { ?>
    <div class="panel-body">
      <div class="tab-content">
      <?php if(sizeof($pdpList['pdpList']['artisan']['description'])) {?>
      <div class="tab-pane fade in active" id="tab1default">
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="artisan" src="<?php echo $ofbiz_url.$pdpList['pdpList']['artisan']['artisianImage1'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="artisan" src="<?php echo $ofbiz_url.$pdpList['pdpList']['artisan']['artisianImage2'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-2">
          <img class="order-img" alt="artisan" src="<?php echo $ofbiz_url.$pdpList['pdpList']['artisan']['artisianImage3'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 tab-text">
          <p>
            <?php echo $pdpList['pdpList']['artisan']['description'];?>
          </p>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2 know-more">
          <a href="<?php echo url("pdp/artisan/");?><?php echo $product->product_id ?>"><img src="<?php echo drubiz_image('pdptabs/tabs-more.png');?>" /><p>Know more</p></a>
        </div>
      </div>
      <?php }?>
      <?php if(sizeof($pdpList['pdpList']['designer']['description'])) {?>
      <div class="tab-pane fade" id="tab2default">
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="designer" src="<?php echo $ofbiz_url.$pdpList['pdpList']['designer']['designerImage1'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="designer" src="<?php echo $ofbiz_url.$pdpList['pdpList']['designer']['designerImage2'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="designer" src="<?php echo $ofbiz_url.$pdpList['pdpList']['designer']['designerImage3'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 tab-text">
          <p>
            <?php echo $pdpList['pdpList']['designer']['description'];?>
          </p>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2 know-more">
          <a href="<?php echo url("pdp/designer/");?><?php echo $product->product_id ?>"><img src="<?php echo drubiz_image('pdptabs/tabs-more.png');?>" /><p>Know more</p></a>
        </div>
      </div>
      <?php }?>
      <?php if(sizeof($pdpList['pdpList']['process']['description'])) {?>
      <div class="tab-pane fade" id="tab3default">
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="process" src="<?php echo $ofbiz_url.$pdpList['pdpList']['process']['productionProcImage1'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="process" src="<?php echo $ofbiz_url.$pdpList['pdpList']['process']['productionProcImage2'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2">
          <img class="order-img" alt="process" src="<?php echo $ofbiz_url.$pdpList['pdpList']['process']['productionProcImage3'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 tab-text"><p>
          <?php echo $pdpList['pdpList']['process']['description'];?></p>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-2 know-more">
          <a href="<?php echo url("pdp/process/");?><?php echo $product->product_id ?>"><img src="<?php echo drubiz_image('pdptabs/tabs-more.png');?>" /><p>Know more</p></a>
        </div>
      </div>
      <?php }?>
      <?php if(sizeof($pdpList['pdpList']['rawMaterial']['longDescription'])) {?>
      <div class="tab-pane fade" id="tab4default">
        <div class="col-xs-12 col-sm-2 col-md-2">
          <img class="order-img" alt="rawMaterial" src="<?php echo $ofbiz_url.$pdpList['pdpList']['rawMaterial']['rawMaterialImage1'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2">
          <img class="order-img" alt="rawMaterial" src="<?php echo $ofbiz_url.$pdpList['pdpList']['rawMaterial']['rawMaterialImage2'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2">
          <img class="order-img" alt="rawMaterial" src="<?php echo $ofbiz_url.$pdpList['pdpList']['rawMaterial']['rawMaterialImage3'] ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4 tab-text">
          <p>
            <?php echo $pdpList['pdpList']['rawMaterial']['longDescription'];?>
          </p>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-2 know-more">
          <a href="<?php echo url("pdp/rawMaterials/");?><?php echo $product->product_id ?>"><img src="<?php echo drubiz_image('pdptabs/tabs-more.png');?>" /><p>Know more</p></a>
        </div>
      </div>
      <?php }?>
      </div>
    </div>
    <?php } ?>
</div>

<!--You MAy Also Like -->
<?php if(!empty($product_associations)){?>
<div id="review-wrap" class="col-xs-12 col-sm-12 col-md-12 umayalso">
  <h2>You May Also Like</h2>
 <div class="container">
    <div id="owl-demo" class="owl-carousel column-5 owl-theme">
      <?php foreach ($product_associations as $product) {?>
         <?php $product_id_to = $product->product_id_to;
         //print_r($product_id_to);
          $nid = get_nid_from_product_id($product_id_to);
          $node = node_load($nid);         
          $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);        
          $product_variant = $system_data->product_raw;
          //print_r($product_variant);
      ?>
     <div class="item">
        <a href="<?php echo url('node/'.$nid);?>" data-ajax="false" id="image_500194">
        <img class="order-img" alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');"></a>
        <a href="<?php echo url('node/'.$nid);?>" data-ajax="false"><?php echo $product_variant->product_name ?></a> 
      </div>
    <?php } ?>
  </div>
  </div>
</div>
<?php }?>
<!--Review Display-->
 <?php if(count($rating['review']) > 0) { ?>
        <div id="review-wrap">
          <h2>Feedback and Reviews</h2>
          <div class="PDPReview">
            <?php 
                // $rating = displayPDPReviewandRating($product->product_id);
                  foreach ($rating['review'] as $key => $ratingValue) {
              ?>
              <div class="review-wrap">
                <div class="review-row rating"><span><?php
                    $rating = $ratingValue['productRating'];
                    $ratingAverage = $rating * 20;
                    $path = drupal_get_path('module', 'fivestar');      
                    drupal_add_js($path . '/js/fivestar.js');
                    drupal_add_css($path . '/css/fivestar.css');
                    echo theme('fivestar_static', array('rating' => $ratingAverage, 'stars' => 5, 'tag' => 'vote'));?>
                  </span>
                </div>
                  <div class="review-row review-title"><span><?php echo $ratingValue['reviewTitle'];?></span></div>
                  <div class="review-row"><span><?php echo $ratingValue['productReview'];?></span></div>
                  <div class="review-row nickname"><span><?php echo $ratingValue['reviewNickName'];?></span></div>
                  <div class="review-row date"><span><?php echo date("d/m/Y H:s",strtotime($ratingValue['postedDateTime']));?></span></div>
              </div>
                
              <?php }
            ?>
          </div>
        </div>
        <?php } ?>
   </div>
</div>
