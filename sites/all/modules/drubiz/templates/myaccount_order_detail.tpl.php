<?php //krumo($order) ?>
<div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">

  <?php echo theme('myaccount_menu'); ?>

<div id="eCommerceOrderDetail" class="orderDetail-layout">

<div class="container shippingGroup orderDetailShippingGroup">
     <div class="itemsordered-details">
 <div class="orderdetails-summary">
 <div class="orderheading"><h4 class="ordr-dtls"><?php echo t('ORDER DETAILS');?></h4></div>
 <div class="orderprint"><a href="javascript:void(0);" class="printOrder" onclick="printOrderDetails()"><?php echo t('Print Order');?></a></div>
 </div>
  <ul class="myorder-left">

       <div class="myorder-summary">
      <div class="order-col1"><?php echo t('Order Number:');?></div>
      <div class="order-col2"><?php echo $order['orderId']; ?></div>
    </div>
    <div class="myorder-summary">
      <div class="order-col1"><?php echo t('Order Date and Time:');?></div>
      <div class="order-col2">
                   <?php echo date('d/m/Y H:i:s', strtotime($order['OrderHeader'][0]['orderDate'])) ?>
      </div>
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


<?php $storeCredit = 0; ?>
<?php if(!empty($order['partyAppliedStoreCreditTotal'])) { ?>
  <?php $storeCredit = $order['partyAppliedStoreCreditTotal'] ; ?>
<?php } ?>
<div class="myorder-summary">
    <li class="myorder-amt">
    <div>
      <div class="order-col1"><?php echo t('Amount Paid:');?></div>
      <span class="order-col2">$ <?php echo format_money($order['orderGrandTotal'] - $storeCredit) ?></span>
      </div>
    </li>
    </div>


    <div class="myorder-summary">
      <li class="myorder-amtdtls">
          <div>
        <div class="order-col1"><?php echo t('Payment:');?> </div>
        <label class="order-col2"><?php echo t('Cash on Delivery');?></label>
        <div class="cod-dtls">
          <!-- <div class="order-col1 emptycol">&nbsp;</div>
            <label class="order-col2 codfee">Cash on Delivery fee : </label>
            <span class="order-col2 cod-fee-span">$ 49</span> -->
        </div>
          </div>
        </li>
        </div>
    <div class="myorder-summary">
      <li class="myorder-amtdtls">
          <div>
        <div class="cod-dtls">
        </div>
          </div>
        </li>
        </div>
    <div class="myorder-summary">
      <li class="myorder-amtdtls">
          <div>
        <div class="cod-dtls">
            <label class="order-col1">&nbsp;<!--Shipping Charges: --></label>
            <span class="order-col2">&nbsp;<!-- $ 50 --></span>
        </div>
          </div>
        </li>
        </div>
    <li>
    </li>
      <li>
      </li>
      <li>
    </li>

    
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
        </li>
        <li>
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
  <!--
  <div class="myorder-right">
    <ul>
    <li><label class="od-address">Billing Address</label></li>
        <li>
            Akshay Patel
        </li>
        <li>
            Billing Shipping
        </li>
        <li>
            Global Village,
        </li>
        <li>
        </li>
        <li>
        </li>
        <li>
            Bangalore,
        </li>
        <li>
            <span style="font-size:12px;">
                KARNATAKA,
                560001.
            </span>
        </li>
        <li>
            <span>Phone: </span>
            9916574985
        </li>

    </ul>
  </div>
  -->
 </div>
<script>
function printOrderDetails(){
    //jQuery("#orderDetails").window.print();
    window.print();
}
</script><br><br>
         <div class="dashboard-orderdetails">
         <h4 class="itemsordered"><?php echo t('Items Ordered');?></h4><ul class="displayList shippingGroupList OrderDetailShippingGroup">

<div class="container shippingAddress orderDetailShippingGroupShippingAddress">
</div>

<div class="container orderItems orderDetailShippingGroupOrderItems">
 

     <div class="boxListItemTabular orderItem OrderDetailShippingGroupOrderItems">
          <div class="OrderDetailShippingGroupOrderItems group group1">
         <ul class="displayList orderItemList OrderDetailShippingGroupOrderItems">
              
   
<li class="string itemImage orderDetailShippingGroupOrderItemsItemImage firstRow cartimage-desk">
  <div>
      <a href="" id="image_500194">
        <img alt="Globus Womens Blue Jackets -500194" src="<?php //echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
      </a>
    </div>
  <div id="fb-root" class=" fb_reset"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div><iframe name="fb_xdm_frame_https" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" id="fb_xdm_frame_https" aria-hidden="true" title="Facebook Cross Domain Communication Frame" tabindex="-1" src="https://staticxx.facebook.com/connect/xd_arbiter.php?version=42#channel=f2c77355707a77c&amp;origin=https%3A%2F%2F182.72.231.54%3A8443" style="border: none;"></iframe></div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div>
  

</li>

         </ul>
          </div>
          <div class="OrderDetailShippingGroupOrderItems group group2">
         <ul class="displayList orderItemList OrderDetailShippingGroupOrderItems">
              
              
           
</ul></div></div></div></ul><div id="checkboxerr" style="display:none"><?php echo t('Please select the completed item');?> </div><li class="string itemStatus orderDetailShippingGroupOrderItemsItemStatus firstRow">
      <div>
      </div>
</li><table border="1" cellpadding="5" cellspacing="5" class="dashboard-ordertable">
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
                
  <?php foreach ($order['OrderItemList'] as $cart_product){ ?>

  <?php
    $nid = get_nid_from_variant_product_id($cart_product['productID']);
    $node = node_load($nid);
    $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
    $product_variant = $system_data->product_variants->{$cart_product['productID']};
  ?>

         <tr class="ordersummary-order-details">
 <td>
   <a href="<?php echo url('node/'.$nid);?>" id="image_500194">
        <img class="order-img" alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
   </a>
 </td>
 <td><a href="<?php echo url('node/'.$nid);?>"><?php echo $cart_product['productName'] ?></a></td>   
 <td>        <?php $selected_features = get_selected_features($product_variant); ?>
   <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
     <?php  echo $selected_feature_name . ': ' . $selected_feature_value.'<br />' ?>
    <?php endforeach; ?>
</td>    
    <td class="pricecol"><p>
      <span class="productprice">$ <?php echo format_money($cart_product['productUnitPrice']);?></span></p>
    </td>
  <td><?php echo (int)$cart_product['quantity'];?></td>
  <td>  
      <?php echo $order['OrderHeader'][0]['statusId'] ?>
      <br>
  </td>
  <td>$ <?php echo format_money($cart_product['productPrice']);?></td>  
</tr>
  <?php } ?>

       </tbody>
       <tfoot class="order-total-price">
       <?php $cartItems = $order['OrderItemList']; ?>
       <?php $promoTotalAmount = getTotalPromoAmount($cartItems); ?>
      <tr><td>&nbsp;</td>
       <td colspan="5">Sub Total</td><td>$ <?php echo format_money($order['shoppingCartItemTotal']);?></td>
      </tr>
      <?php if(!empty($order['partyAppliedStoreCreditTotal'])) { ?>
        <tr><td>&nbsp;</td>
         <td colspan="5">Store Credit</td><td>-$ <?php echo format_money($order['partyAppliedStoreCreditTotal']);?></td>
        </tr>
      <?php } ?>
      <?php if (!empty($promoTotalAmount)): ?>
        <tr><td>&nbsp;</td>
         <td colspan="5">Promo Discount</td><td>- $ <?php echo format_money($promoTotalAmount);?></td>
        </tr>
      <?php endif; ?>
        <tr>
          <td>&nbsp;</td>
          <td colspan="5">Tax Collected </td>
          <td>$ <?php echo format_money($order['salesTax']);?></td>
        </tr>
        
        <?php if(!empty($order['couponCode'])): ?>
        <tr>
        <td>&nbsp;</td>
         <td colspan="5">Coupon Amount:</td>
          <td>$ <?php echo format_money($order['couponValue']) ?></td>
        </tr>
        <?php endif; ?>

        <?php if(isset($order['loayaltyAmount'])): ?>
        <tr>
         <td>&nbsp;</td>
         <td colspan="5">Loyalty Amount:</td>
         <td>-$ <?php echo format_money($order['loayaltyAmount']) ?></td>
        </tr>
        <?php endif; ?>

      
        <!-- <tr>
          <td>&nbsp;</td>
          <td colspan="5">Cash on Delivery fee </td>
          <td>$ 49</td>
        </tr> -->

        <?php if (!empty($order['orderShippingTotal'])): ?>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Shipping Charges </td>
            <td>$ <?php echo format_money($order['orderShippingTotal']) ?></td>
          </tr>
        <?php endif; ?>

      
       <tr>
      </tr>
      <?php $storeCredit = 0; ?>
<?php if(!empty($order['partyAppliedStoreCreditTotal'])) { ?>
  <?php $storeCredit = $order['partyAppliedStoreCreditTotal'] ; ?>
<?php } ?>


      <tr class="order-grand-total">
      <td>&nbsp;</td>
       <td colspan="5">Grand Total</td><td>$ <?php echo format_money($order['orderGrandTotal']- $storeCredit);?></td>
      </tr>
    </tfoot>
    </table>
    
         </div>
         <br><br>
         <div class="string itemStatus orderDetailShippingGroupOrderItemsItemStatus orderstatus-back OrderBack-btn">
          <a href="javascript:history.go(-1)" class="standardBtn negative"><span><?php echo t('Back');?></span></a>
    </div>
    <div class="string itemStatus orderDetailShippingGroupOrderItemsItemStatus orderstatus-cancel OrderCancel-btn">
    </div>
    <div class="backbtn">
      <a class="orderwise-back" href=""><span><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></span></a>
    </div>
</div>

</script>
</div>
</div>