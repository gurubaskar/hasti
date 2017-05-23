<?php //krumo($wishlist)?>
<div id="eCommerceShowWishList" class="eCommerceShowWishList">
  <form method="post" class="cartForm" action="https://182.72.231.54:8443/modifyWishList" id="wishListform" name="wishListform" onsubmit="return updateWishlist()">
    <input type="hidden" id="checkoutpage" name="checkoutpage" value="">
    <input type="hidden" name="csrfPreventionSalt" value="Bi19MTx7v1JLDlBEYSWP">
    <input type="hidden" name="partyId" value="10230">
    <input type="hidden" name="productStoreId" value="GS_STORE">
    <input type="hidden" name="removeSelected" value="false">
    <input type="hidden" name="add_item_id" id="js_add_item_id" value="">
    <h1> my wishlist</h1>
    <?php if(empty($wishlist['wishList'])){?>
      <div class="no-items-wishlist">
        No Items in your Wishlist
      </div>
    <?php }else{?>
      <div class="boxList cartList">
        <table class="wishlistTable">
          <thead>
            <tr class="first last">
              <th></th>
              <th>Product Details and Comment</th>
              <th>Add to Cart</th>
              <th></th>
            </tr>
          </thead>
        </table>
        <?php 
          foreach ($wishlist['wishList']  as $wishList_key => $wishList_value) :
        ?>
        <?php
          $nid = get_nid_from_variant_product_id($wishList_value['productID']);
          $node = node_load($nid);
          $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
          $product = $system_data->product_raw;
          $product_variant = $system_data->product_variants->{$wishList_value['productID']};
          //krumo($product);
          //krumo($product_variant);
        ?>
        <div class="boxListItemTabular cartItem ShowWishlistOrderItems">
          <div class="ShowWishlistOrderItems group group1">
            <ul class="displayList cartItemList ShowWishlistOrderItems">
              <li class="image itemImage showWishlistOrderItemsItemImage firstRow cartimage-desk">
                <div>
                  <a href="<?php echo url('node/' . $nid) ?>">
                    <img alt="<?php echo $product->product_name ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
                  </a>
                </div>
              </li>
            </ul>
          </div>
          <div class="ShowWishlistOrderItems group group2">
            <ul class="displayList cartItemList ShowWishlistOrderItems">
              <li class="string itemName showWishlistOrderItemsItemName firstRow">
                <div>
                  <a href="<?php echo url('node/' . $nid) ?>" id="image_500205">
                    <h3>
                     <?php echo $product->product_name;?>
                    </h3>
                  </a>
                </div>
              </li>
              <span class="prod-description">
                <p class="cartProdName-detail"><?php echo $product->long_description ;?></p>
                <span>
                  <li class="string itemDescription showWishlistOrderItemsItemDescription firstRow prdetails">
                    <div>
                      <span>
                        <?php $selected_features = get_selected_features($product_variant); ?>
                        <ul class="displayList productFeature">
                          <div>
                            <li class="">
                              <div class="color-swatch">
                                <span class="wishlist-color">Color:</span>
                                <div class="color-code" style="background-color:<?php echo @$selected_features['Color'] ?>;border:1px solid black;padding:1px;"></div>
                              </div>
                            </li>
                            <li class="size">
                              <div class="size-swatch">
                                <span class="wishlist-size">Size:</span>
                                <div class="size-code"><?php echo @$selected_features['Size'] ?></div>
                              </div>
                            </li>
                          </div>
                        </ul>
                      </span>
                    </div>
                  </li>
                </span>
              </span>
            </ul>
          </div>
          <div class="ShowWishlistOrderItems group group3">
            <ul class="displayList cartItemList ShowWishlistOrderItems">
              <li class="entry itemQty showWishlistOrderItemsItemQty firstRow">
                <div style="display:none">
                  <label>Quantity:</label>
                  <input size="6" type="text" class="qtyInCart_2460619" name="update_00001" id="update_00001" value="1" maxlength="5" onkeypress="javascript:setCheckoutFormAction(document.wishListform, UWL, );">
                </div>
              </li>
              <li class="currency itemPrice showWishlistOrderItemsItemPrice firstRow">
                <div>
                  <?php if ($product->list_price != $product->sales_price): ?>
                    <p class="oldprice">
                      <span id="cart_strikedcost" class="left price" ;="">$ <?php echo format_money($product->list_price); ?></span>
                    </p>
                  <?php endif; ?>
                  <p class="oldprice">
                    <span id="cart_actualcost" class="left" ;="">$ <?php echo format_money($product->sales_price); ?></span>
                  </p>
                </div>
              </li>
              <li class="action itemAddToCartButton showWishlistOrderItemsItemAddToCartButton firstRow">
                <div style=" height:30px;">
                  <a class="standardBtn addToCart addToCartFromWishlistGlobular" data-delete-id="delete_<?php echo $wishList_value['shoppingListItemSeqId'];?>" data-product-id= "<?php echo $product_variant->product_id; ?>" data-quantity="<?php echo round($wishList_value['quantity']);?>" title="Add to Cart">
                  <span> Add to Cart</span>
                  </a>
                  <input type="hidden" name="add_category_id_00001" value="110">
                </div>
              </li>
            </ul>
          </div>
          <div class="ShowWishlistOrderItems group group4">
            <ul class="displayList cartItemList ShowWishlistOrderItems">
              <li class="action itemRemoveButton showWishlistOrderItemsItemRemoveButton firstRow">
                <div class="wishList_cls_btn wish-delete" data-delete-id="delete_<?php echo $wishList_value['shoppingListItemSeqId'];?>">
                  <label>Remove Item:</label>
                  <a class="standardBtn delete" title="Remove Item">
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
        <input type="hidden" name="product_name_0" id="js_productName_00001" value="Globus Men Party Wear Shirts -500205">
        <!--<a class="clear-wishlistitems" href="https://182.72.231.54:8443/clearWishList">Clear WishList</a>-->
      </div>
      <div class="action previousButton showWishlistPreviousButton">
        <a href="<?php echo url('');?>" class="standardBtn negative"><span>Continue Shopping</span></a>
      </div>
    <?php }?>
  </form>
</div>