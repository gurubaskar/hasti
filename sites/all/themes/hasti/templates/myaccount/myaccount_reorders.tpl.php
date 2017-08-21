<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right reOrder">
  <h3>ReOrder Items</h3>
  <div id="demo-top-bar">
    <div id="no-more-tables">
      <table class="table-bordered table-striped table-condensed cf returnDetail">
        <thead>
          <tr>
            <td><?php echo t('Image');?></td>
            <td><?php echo t('Product Name');?></td>
            <td><?php echo t('SKU');?></td>
            <td><?php echo t('Price');?></td>
            <td><?php echo t('Quantity');?></td>
            <td><?php echo t('Item Status');?></td>
            <td><?php echo t('Sub Total');?></td>
            <td><?php echo t('Select Product');?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($order['OrderHeader'] as $cart_product){ 
            $nid = get_nid_from_variant_product_id($cart_product['productId']);
            $node = node_load($nid);
            $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
            $product_variant = $system_data->product_variants->{$cart_product['productId']};
          ?>
          <tr>
            <td data-title="Image">
              <a href="<?php echo url('node/'.$nid);?>" id="image_500194">
                <img class="order-img" alt="<?php echo $cart_product['productName'][0] ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
             </a>
            </td>
            <td data-title="Product Name">
               <a href="<?php echo url('node/'.$nid);?>"><?php echo $cart_product['productName'][0] ?></a>
            </td>
            <td data-title="SKU">
            <?php $selected_features = get_selected_features($product_variant); ?>
             <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
               <?php  echo $selected_feature_name . ': ' . $selected_feature_value.'<br />' ?>
              <?php endforeach; ?>
            </td>
            <td data-title="Price">
              &#8377;. <?php echo format_money($cart_product['unitPrice']);?>
            </td>
            <td data-title="Quantity">
              <?php echo (int)$cart_product['quantity'];?>
            </td>
            <td data-title="Item Status">
              <?php echo $order['OrderHeader'][0]['statusId'] ?>
            </td>
            <td data-title="Sub Total">
              &#8377;. <?php echo format_money($cart_product['unitPrice'] * (int)$cart_product['quantity']);?>
            </td> 
            <td data-title="Select Product">
              <input type="checkbox" name="slectedProduct[]" id="slectedProduct[]" class="theClass" value="<?php echo $cart_product['productId'];?>">
            </td>
          </tr>
          <?php } ?>
        <tbody>
      </table>
      <div class="subTotal">
        <div class="price1-wrap">
          <span>Sub Total</span><span>&#8377;. <?php echo format_money($order['cartSubTotal']);?></span>
        </div>
      </div>
      <div class="grandTotal">
        <div class="price1-wrap">
          <span>Grand Total</span><span>&#8377;. <?php echo format_money($order['orderGrandTotal']);?></span>
        </div>
      </div>
      <div class="reorderBtn">
        <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="text" class="reoderItem">Reorder Selected item</a>
      </div>
    </div>
  </div>
</div>