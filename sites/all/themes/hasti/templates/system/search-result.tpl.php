<?php

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['module']: The module that implemented the search query.
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])): ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 *
 * @ingroup themeable
 */
  $nid = $variables['result']['node']->entity_id;
  $node = node_load($nid);
  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
  $product = $system_data->product_raw;
  $selected_features = get_selected_features($product);
  $facet_values = get_facet_values($system_data);
  $share_url = url('node/' . $node->nid, array('absolute' => TRUE));
 //krumo($node);
?>
<!-- starts -->
<!-- <div id="content" class="plp"> -->
    <!-- <div class="container-fluid"> -->
      <!-- <div class="row"> -->
        <!-- <div class="col-xs-12 col-sm-9 col-md-9 plp-right"> -->
          <!-- <div class="row"> -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-12 sortby">
              <div class="sort-wrap">
                <span>Sort By</span>
                <select>
                  <option>Best Selling</option>
                </select>
              </div>
            </div> -->
            <div class="col-xs-12 col-sm-4 col-md-3">
              <div class="box">
                <div class="img-wrap">
                  <a class="pdpUrl" title="<?php echo htmlentities($node->title) ?>" href="<?php echo url('node/' . $node->nid) ?>" id="<?php echo $product->product_id ?>">
                    <img alt="<?php echo htmlentities($node->title) ?>" title="<?php echo htmlentities($node->title) ?>" src="<?php print current_theme_path() .'/images/img1.jpg'; ?>" onmouseover="src='<?php print current_theme_path() .'/images/img2.jpg'; ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php print current_theme_path() .'/images/img1.jpg'; ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
                    <div class="select-wrap">
                      <a href="#" alt="cart"><span class="addcart"></span></a>
                      <a href="#" alt="wishlist"><span class="wishlist"></span></a>
                    </div>
                  </a>
                </div>
                <div class="title"><?php echo htmlentities($node->title) ?></div>
                <div class="price">Rs. <?php echo format_money($product->sales_price) ?></div>
              </div>
            </div>
          <!-- </div> -->
        <!-- </div> -->
        <!-- </div> -->
    <!-- </div> -->
  <!-- </div> -->
<!-- ends -->
<!--<div class="boxListItemGrid productItem PLP <?php print $classes; ?>"<?php print $attributes; ?>>
  <ul class="displayList productItemList PLP">
    <li id="<?php echo $product->product_id ?>" class="image thumbImage plpThumbImage">
      <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
        <div class="js_swatchProduct">
          <a class="pdpUrl" title="<?php echo htmlentities($node->title) ?>" href="<?php echo url('node/' . $node->nid) ?>" id="<?php echo $product->product_id ?>">
          <img alt="<?php echo htmlentities($node->title) ?>" title="<?php echo htmlentities($node->title) ?>" src="<?php echo drubiz_image($product->plp_image) ?>" class="productThumbnailImage" height="187" width="140" onmouseover="src='<?php echo drubiz_image($product->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
          </a>
        </div>
      </div>
    </li>
    <div id="fb-root"></div>
    <div class="wishList_social_share" style="display: block;">
      <span>
      <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PLP_<?php echo $product->product_id ?>', '<?php echo $product->product_id ?>');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PLP_<?php echo $product->product_id ?>"></a>
      </span>
  
    </div>
    <li class="container selectableFeature plpSelectableFeature" style="display:none" id="js_selectableFeature_li_PLP_<?php echo $product->product_id ?>">
      <div class="sizeBg"></div>
      <div class="plpSelectableFeature">
        <div><a href="javascript:void(0);" onclick="javascript:showPlpSizeGuide('PLP_<?php echo $product->product_id ?>');"></a></div>
        <div class="selectableFeatures SIZE" id="PLP_<?php echo $product->product_id ?>">
          <label>Size:</label>
          <select class="js_selectableFeature_1 FTSIZE_PLP_<?php echo $product->product_id ?>" id="FTSIZE_PLP_<?php echo $product->product_id ?>" name="FTSIZE_PLP_<?php echo $product->product_id ?>" onchange="javascript:getListPlp(this.name,(this.selectedIndex-1), 1,'PLP_<?php echo $product->product_id ?>');">
            <option></option>
          </select>
          <ul class="plp_selectableFeature js_selectableFeature_1" id="LiFTSIZE_PLP_<?php echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php if (!empty($facet_values['Size'])) foreach ($facet_values['Size'] as $size => $variant_product_id): ?>
              <li class="<?php echo $size ?>" value="<?php echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-cart"  data-product-id="<?php echo $variant_product_id ?>">
                  <?php echo $size ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="selectableFeatures COLOR" id="PLP_<?php echo $product->product_id ?>">
          <label>Color:</label>
          <select class="js_selectableFeature_2 FTCOLOR_PLP_<?php echo $product->product_id ?>" id="FTCOLOR_PLP_<?php echo $product->product_id ?>" name="FTCOLOR_PLP_<?php echo $product->product_id ?>" onchange="javascript:getListPlp(this.name,(this.selectedIndex-1), 1,'PLP_<?php echo $product->product_id ?>');">
            <option></option>
          </select>
          <ul class="js_selectableFeature_2" id="LiFTCOLOR_PLP_<?php echo $product->product_id ?>" name="LiFTCOLOR_PLP_<?php echo $product->product_id ?>">
            <li class="Blue">
              <a href="javascript:void(0);" onclick="javascript:getListPlp('FTCOLOR_PLP_<?php echo $product->product_id ?>','0', 1,'PLP_<?php echo $product->product_id ?>');addItemPlpToCart('PLP_<?php echo $product->product_id ?>');">
              Blue
              </a>
            </li>
          </ul>
        </div>
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_product_id" value="<?php echo $product->product_id ?>">
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_add_product_id" id="PLP_<?php echo $product->product_id ?>_add_product_id" value="NULL">
        <div class="selectableFeatureAddProductId">
          <span id="product_id_display"> </span>
          <div id="variant_price_display"> </div>
        </div>
      </div>
    </li>
    <li class="container selectableFeature plpSelectableFeature" style="display:none" id="js_selectableFeature1_li_PLP_<?php echo $product->product_id ?>">
      <div class="sizeBg"></div>
      <div class="plpSelectableFeature">
        <div class="selectableFeatures SIZE" id="PLP_<?php echo $product->product_id ?>">
          <label>Size:</label>
          <select class="js_selectableFeature1_1 FTSIZE_PLP_<?php echo $product->product_id ?>" name="FTSIZE_PLP_<?php echo $product->product_id ?>" onchange="javascript:getListPlp(this.name,(this.selectedIndex-1), 1,'PLP_<?php echo $product->product_id ?>');">
            <option></option>
          </select>
          <ul class="js_selectableFeature1_1" id="LiFTSIZE_PLP_<?php echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php if (!empty($facet_values['Size'])) foreach ($facet_values['Size'] as $size => $variant_product_id): ?>
              <li class="<?php echo $size ?>" value="<?php echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-wishlist" data-product-id="<?php echo $variant_product_id ?>">
                  <?php echo $size ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="selectableFeatures COLOR" id="PLP_<?php echo $product->product_id ?>">
          <label>Color:</label>
          <select class="js_selectableFeature1_2 FTCOLOR_PLP_<?php echo $product->product_id ?>" name="FTCOLOR_PLP_<?php echo $product->product_id ?>" onchange="javascript:getListPlp(this.name,(this.selectedIndex-1), 1,'PLP_<?php echo $product->product_id ?>');">
            <option></option>
          </select>
          <ul class="js_selectableFeature1_2" id="LiFTCOLOR_PLP_<?php echo $product->product_id ?>" name="LiFTCOLOR_PLP_<?php echo $product->product_id ?>">
            <li class="Blue">
              <a href="javascript:void(0);" onclick="javascript:getListPlp('FTCOLOR_PLP_<?php echo $product->product_id ?>','0', 1,'PLP_<?php echo $product->product_id ?>');addItemPlpToWishlist('PLP_<?php echo $product->product_id ?>');"> 
              Blue
              </a>
            </li>
          </ul>
        </div>
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_product_id" value="<?php echo $product->product_id ?>">
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_add_product_id" id="PLP_<?php echo $product->product_id ?>_add_product_id" value="NULL">
        <div class="selectableFeatureAddProductId">
          <span id="product_id_display"> </span>
          <div id="variant_price_display"> </div>
        </div>
      </div>
    </li>
    <li class="container selectableFeature plpSelectableFeature hk_selectable" style="display:none" id="js_selectableFeature2_li_PLP_<?php echo $product->product_id ?>">
      <div class="sizeBg"></div>
      <div class="plpSelectableFeature">
        <div class="selectableFeatures SIZE" id="PLP_<?php echo $product->product_id ?>">
          <label>Size:</label>
          <div class="plp_social_share">
            <span class="fb_share"></span>
            <span class="tw_share"></span>
            <span class="google_share"></span>
            <span class="pinit_share"></span>
          </div>
          <ul class="js_selectableFeature2_1" id="LiFTSIZE_PLP_<?php echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <div class="avs_title">Available Sizes</div>
            <li class="M">
              <div class="avb_size"> 
                M
              </div>
            </li>
            <li class="XL">
              <div class="avb_size"> 
                XL
              </div>
            </li>
          </ul>
        </div>
        <div class="selectableFeatures COLOR" id="PLP_<?php echo $product->product_id ?>">
          <label>Color:</label>
          <div class="plp_social_share">
            <span class="fb_share"></span>
            <span class="tw_share"></span>
            <span class="google_share"></span>
            <span class="pinit_share"></span>
          </div>
          <ul class="js_selectableFeature2_2" id="LiFTCOLOR_PLP_<?php echo $product->product_id ?>" name="LiFTCOLOR_PLP_<?php echo $product->product_id ?>">
            <div class="avs_title">Available Sizes</div>
            <li class="Blue">
              <div class="avb_size"> 
                Blue
              </div>
            </li>
          </ul>
        </div>
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_product_id" value="<?php echo $product->product_id ?>">
        <input type="hidden" name="PLP_<?php echo $product->product_id ?>_add_product_id" id="PLP_<?php echo $product->product_id ?>_add_product_id" value="NULL">
        <div class="selectableFeatureAddProductId">
          <span id="product_id_display"> </span>
          <div id="variant_price_display"> </div>
        </div>
      </div>
    </li>
    <li class="action addToCart plpAddToCart plp_hover_addtocart" id="js_plpAddtoCart_licartbtn_PLP_<?php echo $product->product_id ?>" style="display: none;">
      <input type="hidden" name="PLP_<?php echo $product->product_id ?>_add_category_id" id="PLP_<?php echo $product->product_id ?>_add_category_id" value="520"> 
      <input type="hidden" name="PLP_<?php echo $product->product_id ?>_add_product_name" id="PLP_<?php echo $product->product_id ?>_add_product_name" value="Fashion Women Casual Patialas -<?php echo $product->product_id ?>"> 
      <div id="js_plpAddtoCart_div_PLP_<?php echo $product->product_id ?>">
        <label>Add To Cart:</label>
        <a title="Add to Cart" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide('PLP_<?php echo $product->product_id ?>', '<?php echo $product->product_id ?>');" class="standardBtn addToCart addCart_icon  inactiveAddToCart" id="js_plpAddtoCart_PLP_<?php echo $product->product_id ?> plpCheckInventory" style="display: block;"><span style="display:none;">ADD TO BAG</span></a>
      </div>
      <div class="js_plpPdpInStoreOnlyContent" id="js_plpPdpInStoreOnlyLabel_PLP_<?php echo $product->product_id ?>" style="display:none;">
      </div>
    </li>
    <li class="plp_hover_addtowish action addToWishlist plpAddToWishlist" id="js_addToWishlist_Wishlistbtn_PLP_<?php echo $product->product_id ?>" style="display: none;">
      <div id="plpQuicklook_" class="js_plpQuicklook plpQuicklookIcon">
        <input type="hidden" class="param" name="productId" id="QuicklookProductId" value="<?php echo $product->product_id ?>">
        <input type="hidden" class="param" name="productCategoryId" value="520">
        <input type="hidden" class="param" name="productFeatureType" id="<?php echo $product->product_id ?>_productFeatureType" value="">
      </div>
    </li>
    <li class="string productName plpProductName" id="js_plpProductName_li_PLP_<?php echo $product->product_id ?>">
      <div>
        <span>
        <?php echo $node->title ?>
        </span>
      </div>
    </li>
    <li class="priceListGroup">
      <div class="currency priceList plpPriceList">
        <div class="js_plpPriceList">
          <?php if ($product->list_price != $product->sales_price): ?>
            <p class="oldprice">
              <span class="price">   
              <span>$ <?php echo format_money($product->list_price) ?></span>
              </span>
            </p>
          <?php endif; ?>
          <div class="js_plpPriceOnline">
            <label> </label>
            <span>
            <span class="bold" ;="">$ <?php echo format_money($product->sales_price) ?>
            </span>
            </span>
          </div>
        </div>
      </div>
    </li>
    <?php if (!empty($product->promotion_label)): ?>
      <div class="promotion-label plp-promotion-label">
        <span><?php echo $product->promotion_label ?></span>
      </div>
    <?php else: ?>
      <?php if ($product->list_price != $product->sales_price): ?>
        <div class="promotion-label plp-promotion-label">
          <span><?php echo 100 - round($product->sales_price * 100 / $product->list_price) ?>% Off</span>
        </div>
      <?php else: ?>
        <div class="promotion-label plp-promotion-label">
          &nbsp;
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </ul>
</div>
<div class="variableMapForFilterAjax" style="display:none;"><span id="span_PLP_<?php echo $product->product_id ?>" style="display:none;" ftcolor_blue="2443919" ftsize_m="2443919" ftsize_xl="2443920"></span></div> -->
