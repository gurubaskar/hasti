 <?php //krumo($wishlist)?>
<?php if($GLOBALS['user']->uid == 0) { ?>
Please login to view the view list
<?php } else { ?>
<div id="eCommerceShowWishList" class="eCommerceShowWishList">
  <?php if(empty($wishlist['wishListItemDetails'])){?>
    <div class="no-items-wishlist">
      No Items in your Wishlist
    </div>
  <?php }else{?>
      <div class="col-xs-12 col-sm-12 col-md-12 myaccount-right wishlist">
      <h3>My Wishlist</h3>
      <?php 
        foreach ($wishlist['wishListItemDetails']  as $wishList_key => $wishList_value) :
      ?>
      <?php
        $nid = get_nid_from_variant_product_id($wishList_value['productId']);
        $node = node_load($nid);
        $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
        $product = $system_data->product_raw;
        $product_variant = $system_data->product_variants->{$wishList_value['productId']};
        // krumo($product);
        // krumo($product_variant);
      ?>
      <div class="col-xs-12 col-sm-6 col-md-6 cartbox">
        <div class="col-xs-12 col-sm-3 col-md-3 img-wrap">
          <a href="<?php echo url('node/' . $nid) ?>">
            <img alt="<?php echo $product->product_name ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
          </a>
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 cart-details pright">
          <?php $selected_features = get_selected_features($product_variant); ?>
          <div class="col-xs-6 col-sm-8 col-md-8 details-left">
            <a href="<?php echo url('node/' . $nid) ?>" id="image_">
              <h4>
               <?php echo $product->product_name;?>
              </h4>
            </a>
            <div class="cartrow"><label>Qty:</label><span class="qty"><?php echo round($wishList_value['quantity']);?></span></div>
            <div class="cartrow"><label>Price:</label><span>Rs. <?php echo format_money($product->list_price); ?></span></div>
            <div class="cartrow"><label>Size:</label><span class="size"><?php echo @$selected_features['Size'] ?></span></div>
            <div class="cartrow"><label>Color:</label><span class="color"><?php echo @$selected_features['Color'] ?></span></div>
            <?php $inventoryCheck = pdp_out_of_stock_info($product_variant->product_id);?>
            <div class="cartrow">
              <?php if($inventoryCheck->inventory == 'Yes') {?>
              <span>In Stock</span>
              <?php } else { ?>
              <span>Out Stock</span>
              <?php } ?>
            </div>
          </div>
          <div class="wishList_cls_btn wish-delete details-right" data-delete-id="delete_<?php echo $wishList_value['shoppingListItemSeqId'];?>">
            <a class="remove" title="Remove Item" href="#">Remove</a>
          </div>
          <div class="btns-wrap">
            <span>
              <?php if($inventoryCheck->inventory == 'Yes') {?>
              <a class="standardBtn addToCart addToCartFromWishlistGlobular" data-delete-id="delete_<?php echo $wishList_value['shoppingListItemSeqId'];?>" data-product-id= "<?php echo $product_variant->product_id; ?>" data-quantity="<?php echo round($wishList_value['quantity']);?>" title="Add to Cart">
              Add to Bag</a>
              <?php } else { ?>
              <a class="" title="Add to Cart" disabled="disabled"> Add to Bag </a>
              <?php } ?>
              </span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
     </div>
    <div class="action previousButton showWishlistPreviousButton">
      <a href="<?php echo url('');?>" class="standardBtn negative"><span>Continue Shopping</span></a>
    </div>
  <?php }?>
</div>
<?php } ?>