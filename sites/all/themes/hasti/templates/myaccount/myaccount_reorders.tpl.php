<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="dashboard-orderdetails">
<h3>ReOrder Items</h3>
Order Number: <?php echo $orderId;?>
<table border="1" cellpadding="5" cellspacing="5" class="dashboard-ordertable">
     <tbody>
      <tr class="ordertable-head">
      <th><?php echo t('Image');?></th>
      <th><?php echo t('Product Name');?></th>
      <th><?php echo t('SKU');?></th>
      <th><?php echo t('Price');?></th>
      <th><?php echo t('Qty');?></th>
      <th><?php echo t('Item Status');?></th>
      <th><?php echo t('Sub Total');?></th>
      <th><?php echo t('Select Product');?></th>
      </tr>
                
  <?php foreach ($order['OrderHeader'] as $cart_product){ ?>

  <?php
    $nid = get_nid_from_variant_product_id($cart_product['productId']);
    $node = node_load($nid);
    $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
    $product_variant = $system_data->product_variants->{$cart_product['productId']};
  ?>

         <tr class="ordersummary-order-details">
 <td>
   <a href="<?php echo url('node/'.$nid);?>" id="image_500194">
        <img class="order-img" alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
   </a>
 </td>
 <td><a href="<?php echo url('node/'.$nid);?>"><?php echo $cart_product['productName'][0] ?></a></td>   
 <td>        <?php $selected_features = get_selected_features($product_variant); ?>
   <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
     <?php  echo $selected_feature_name . ': ' . $selected_feature_value.'<br />' ?>
    <?php endforeach; ?>
</td>    
    <td class="pricecol"><p>
      <span class="productprice">₹. <?php echo format_money($cart_product['unitPrice']);?></span></p>
    </td>
  <td><?php echo (int)$cart_product['quantity'];?></td>
  <td>  
      <?php echo $order['OrderHeader'][0]['statusId'] ?>
      <br>
  </td>
  <td>₹. <?php echo format_money($cart_product['unitPrice'] * (int)$cart_product['quantity']);?></td>  
  <td><input type="checkbox" name="slectedProduct[]" id="slectedProduct[]" class="theClass" value="<?php echo $cart_product['productId'];?>"></td>  
</tr>
  <?php } ?>

       </tbody>
       <tfoot class="order-total-price">
      <tr><td>&nbsp;</td>
       <td colspan="5">Sub Total</td><td>₹. <?php echo format_money($order['cartSubTotal']);?></td>
      </tr>

      <tr class="order-grand-total">
      <td>&nbsp;</td>
       <td colspan="5">Grand Total</td><td>₹. <?php echo format_money($order['orderGrandTotal']);?></td>
      </tr>
    </tfoot>
    </table>
    
         </div>
         <div>
         	<a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="text" class="reoderItem">Reorder Selected item</a>
         </div>