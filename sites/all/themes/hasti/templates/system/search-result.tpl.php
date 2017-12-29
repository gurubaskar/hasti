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
  //krumo($product);
  //$selected_features = get_selected_features($product);
  $facet_values = get_facet_values($system_data);
  //krumo($system_data);
  //krumo($facet_values);
  $share_url = url('node/' . $node->nid, array('absolute' => TRUE));
 //krumo($node);
?>
<div class="col-xs-12 col-sm-4 col-md-3">
  <div class="box">
    <div class="img-wrap">
      <a class="pdpUrl" data-ajax="false" title="<?php echo htmlentities($node->title) ?>" href="<?php echo url('node/' . $node->nid) ?>" id="<?php echo $product->product_id ?>">
        <img alt="<?php echo drubiz_image($product->plp_image_alt); ?>" title="<?php echo htmlentities($node->title) ?>" src="<?php echo drubiz_image($product->plp_image); ?>" onmouseover="src='<?php echo drubiz_image($product->plp_image_alt); ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product->plp_image); ?>'; jQuery(this).error(function(){onImgError(this, 'PLP- Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
    </a>
      <div class="select-wrap">
        <a href="#" alt="cart" data-ajax="false"><span onclick="showVariants(this,'PLP_<?php echo $product->product_id ?>', '<?php echo $product->product_id ?>');" id="<?php echo $product->product_id; ?>" class="addcart"></span></a>
        <a href="#" alt="wishlist" data-ajax="false"><span onclick="showWishlistVariants(this);" id="<?php echo $product->product_id; ?>" class="wishlist"></span></a>
      </div>
      <div class="cart-options variant-<?php echo $product->product_id; ?>" style="display:none">
        <img class="close" onclick="hideVariants(this);" src="<?php echo current_theme_path();?>/images/close.png" alt="close" />
        <!--<ul class="color plp_selectableFeature js_selectableFeature_1" id="LiFTSIZE_PLP_<?php //echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php //if (!empty($facet_values['Color'])) foreach ($facet_values['Color'] as $color => $variant_product_id): ?>
              <li class="<?php //echo strtolower($color); ?>" value="<?php //echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-cart"  data-product-id="<?php //echo $variant_product_id ?>">
                </a>
              </li>
            <?php //endforeach; ?>
        </ul>-->
        <ul class="size plp_selectableFeature js_selectableFeature_1" id="LiFTSIZE_PLP_<?php echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php if (!empty($facet_values['Size'])) foreach ($facet_values['Size'] as $size => $variant_product_id): ?>
              <li class="<?php echo $size ?>" value="<?php echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-cart" data-ajax="false" data-product-id="<?php echo $variant_product_id ?>" onclick="plpAddtoCart(this);">
                  <?php echo $size ?>
                </a>
              </li>
            <?php endforeach; ?>
        </ul>
      </div>
      <div class="wishlist-options wishlist-variant-<?php echo $product->product_id; ?>" style="display:none">
        <img class="close" onclick="hideVariants(this);" src="<?php echo current_theme_path();?>/images/close.png" alt="close" />
        <!--<ul class="color plp_selectableFeature js_selectableFeature_1" id="LiFTSIZE_PLP_<?php //echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php //if (!empty($facet_values['Color'])) foreach ($facet_values['Color'] as $color => $variant_product_id): ?>
              <li class="<?php //echo strtolower($color); ?>" value="<?php //echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-wishlist"  data-product-id="<?php //echo $variant_product_id ?>">
                </a>
              </li>
            <?php //endforeach; ?>
        </ul>-->
        <ul class="size plp_selectableFeature js_selectableFeature_1" id="LiFTSIZE_PLP_<?php echo $product->product_id ?>" name="LiFTSIZE_PLP_<?php echo $product->product_id ?>">
            <?php if (!empty($facet_values['Size'])) foreach ($facet_values['Size'] as $size => $variant_product_id): ?>
              <li class="<?php echo $size ?>" value="<?php echo $variant_product_id ?>">
                <a href="#" class="plp-add-to-wishlist" data-ajax="false" data-product-id="<?php echo $variant_product_id ?>" onclick="plpAddToWishList(this);">
                  <?php echo $size ?>
                </a>
              </li>
            <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <div class="title"><?php echo $product->product_name;?></div>
    <div class="price">Rs. <?php echo format_money($product->sales_price) ?></div>
  </div>
</div>
            