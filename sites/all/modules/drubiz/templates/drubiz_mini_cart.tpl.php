<?php //krumo($cart); ?>
<?php $cartItems = $cart['productList']; ?>

<?php 

  if (empty($cart['productList'])) {
    echo '<h3>No Items.</h3>';
    return;
  }

?>

<div class="container orderItemsSummary lightBoxOrderItemsSummary">
  <ul class="displayList summary LightBoxOrderItemsSummary">
    <li class="number totalNumberItems lightBoxOrderItemsSummaryTotalNumberItems">
      <div>
        <label><?php echo t('Total Items:');?> <span class="miniTotal"><?php echo $cart['shoppingCartSize'] ?></span></label>
      </div>
    </li>
    <li class="currency totalAmount lightBoxOrderItemsSummaryTotalAmount">
      <div>
        <label><?php echo t('Total:');?></label>
        <span>$ <?php echo format_money($cart['orderGrandTotal']) ?></span>
      </div>
    </li>
    <?php $promoTotalAmount = getTotalPromoAmount($cartItems) ;?>
    <div class="cart-price">
      <label><?php echo t('Sub Total:');?></label>
      <span>$ <?php echo format_money($cart['cartSubTotal']) ?></span>
    </div>
  </ul>
</div>
<input type="hidden" name="removeSelected" value="false">
<div class="boxList cartList">

  <?php foreach ($cart['productList'] as $cart_product): ?>
    <?php
      $nid = get_nid_from_variant_product_id($cart_product['productID']);
      $node = node_load($nid);
      $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
      $product_variant = $system_data->product_variants->{$cart_product['productID']};
    ?>
    <div class="boxListItemTabular cartItem LightBoxOrderItems">
      <div class="LightBoxOrderItems group group1">
        <ul class="displayList cartItemList LightBoxOrderItems">
          <li class="image itemImage lightBoxOrderItemsItemImage firstRow cartimage-desk">
            <div>
              <a href="<?php echo url('node/' . $nid) ?>">
              <img alt="<?php echo $cart_product['productName'] ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
              </a>
            </div>
          </li>
        </ul>
      </div>
      <div class="LightBoxOrderItems group group2">
        <ul class="displayList cartItemList LightBoxOrderItems">
          <li class="string itemName lightBoxOrderItemsItemName firstRow">
            <div>
              <a href="<?php echo url('node/' . $nid) ?>">
                <h3>
                  <?php echo $cart_product['productName'] ?>
                </h3>
              </a>
            </div>
          </li>
          <li class="string itemDescription lightBoxOrderItemsItemDescription firstRow prdetails">
            <div>
              <span>
                <ul class="displayList productFeature">
                  <div>
                    <?php $selected_features = get_selected_features($product_variant); ?>
                    <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
                      <?php if (strtolower($selected_feature_name) == 'color'): ?>
                        <li class="<?php echo strtolower($selected_feature_name) ?>">
                          <div class="<?php echo strtolower($selected_feature_name) ?>-swatch">
                            <div class="<?php echo strtolower($selected_feature_name) ?>-code" style="background-color:<?php echo $selected_feature_value ?>;border:1px solid black;padding:1px;"></div>
                          </div>
                        </li>
                      <?php elseif (strtolower($selected_feature_name) == 'size'): ?>
                        <li class="<?php echo strtolower($selected_feature_name) ?>">
                          <div class="<?php echo strtolower($selected_feature_name) ?>-swatch">
                            <div class="<?php echo strtolower($selected_feature_name) ?>-code"><?php echo $selected_feature_value ?></div>
                          </div>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="">
                      <div>
                        <label><?php echo t('Quantity:');?> <?php echo (int)$cart_product['quantity'] ?></label>
                      </div>
                    </li>
                  </div>
                </ul>
              </span>
            </div>
          </li>
        </ul>
      </div>
      <div class="LightBoxOrderItems group group3">
        <ul class="displayList cartItemList LightBoxOrderItems">
          <li class="currency itemPrice lightBoxOrderItemsItemPrice firstRow">
            <div>
              <?php if (FALSE AND $cart_product['productPrice'] != $cart_product['offerPrice']): ?>
                <p class="oldprice">
              <span id="cart_strikedcost" class="left price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
              </p>

              <?php endif; ?>
              <p class="oldprice">
                <span id="cart_actualcost" class="left">&nbsp;$ <?php echo format_money($cart_product['productPrice']) ?></span>
              </p>
            </div>
          </li>
          <li class="currency itemTotal lightBoxOrderItemsItemTotal firstRow">
            <div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  <?php endforeach; ?>

</div>

<div class="action showCartButton lightBoxShowCartButton">
  <a href="<?php echo url('cart') ?>" class="standardBtn positive"><span><?php echo t('View bag');?></span></a>
</div>
