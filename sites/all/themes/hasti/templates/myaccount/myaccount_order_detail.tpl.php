<?php //krumo($order) ?>
<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
<div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">


<div id="eCommerceOrderDetail" class="orderDetail-layout">

<div class="container shippingGroup orderDetailShippingGroup">
     <div class="itemsordered-details">
 <div class="orderdetails-summary">
 <div class="orderheading"><h4 class="ordr-dtls"><?php echo t('ORDER DETAILS');?></h4></div>
 <!-- <div class="orderprint"><a href="javascript:void(0);" class="printOrder" onclick="printOrderDetails()"><?php echo t('Print Order');?></a></div> -->
 </div>
  <ul class="myorder-left">

       <div class="myorder-summary">
      <div class="order-col1"><?php echo t('Order Number:');?></div>
      <div class="order-col2"><?php echo $order['orderId']; ?></div>
    </div>
     <!-- track order code added by venkat -->
     <div class="myorder-summary">
      <li class="myorderstatus">

        <div>
        <div class="order-col1"><?php echo t('Order Status:');?></div>
            <span class="order-col2"><?php echo $order['OrderHeader'][0]['statusId'];?></span>
        </div>

      </li>
      </div>


<div class="myorder-summary">
    <li class="myorder-amt">
    <div>
      <div class="order-col1"><?php echo t('Amount Paid:');?></div>
      <span class="order-col2">₹. <?php echo format_money($order['orderGrandTotal']) ?></span>
      </div>
    </li>
    </div>
     </ul>
      <div class="myorder-right">
     <ul>
    <li><label class="od-address"><?php echo t('Shipping Address');?></label></li>
        <li>
           <?php echo $order['shippingAddress'][0]['toName'] ?>
        </li>
        <li>
           <?php echo $order['shippingAddress'][0]['address1'] . ' ' . $order['shippingAddress'][0]['address2'] ?>
            
        </li>
        <li>
            <?php echo $order['shippingAddress'][0]['city'] ?>,
        </li>
        <li>
            <span style="font-size:12px;">
               <?php echo $order['shippingAddress'][0]['stateProvinceGeoId'] ?>
,
                            <?php echo $order['shippingAddress'][0]['postalCode'] ?>
            </span>
        </li>
        <li>
          <span>Phone: </span>
            <?php echo $order['shippingAddress'][0]['contactNumber'] ?>
        </li>

    </ul>
</div>
 </div>
<script>
function printOrderDetails(){
    //jQuery("#orderDetails").window.print();
    window.print();
}
</script><br><br>
         <div class="dashboard-orderdetails">

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
  
</div>

<!-- </script> -->
</div>
</div>

</div>