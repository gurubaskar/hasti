<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
  <h3>Track Order Details</h3>
  <div id="demo-top-bar">
  <div class="track-container">
      <!--h3>Track your Status</h3-->
      <div id="track-wrap">
        <?php
          $trackList = "";
          foreach ($track as $key => $trackValue) { 
            $trackList = $trackValue['statusList'];
          }
          $li = '';
          foreach ($trackList as $key => $statusValue) { 
            $li .= '<li class="progtrckr-done">'.$statusValue.'</li><!--';
            $li .= '-->';
          } 
        ?>  
        <ol class="progtrckr" data-progtrckr-steps="5">
          <?php echo $li;?>
        </ol>
      </div>
    </div>
    <div class="shippingDetail">
      <div class="trackOrderDetails">
        <h4>Order Details</h4>
        <p><label>Order Id: </label><span><?php echo $order['orderId']; ?></span></p>
        <p><label>Order Status: </label><span><?php echo $order['OrderHeader'][0]['statusId'];?></span></p>
        <p><label>Order Date: </label><span><?php echo date('d-m-Y H:i:s',strtotime($order['orderDate'])) ;?></span></p>
        <p><label>Amount Paid: </label><span>&#8377;. <?php echo format_money($order['orderGrandTotal']); ?></span></p>
        <?php if(!empty($track[0]['trackingNumber'])) { ?>
        <p><label>Tracking Number: </label><span><?php echo $track[0]['trackingNumber'];?></span></p>
        <?php } ?>
      </div>
      <div class="details-wrap">
        <h4>Shipping Address</h4>
        <span><?php echo $order['shippingAddress'][0]['toName'] ?></span>
        <span><?php echo $order['shippingAddress'][0]['address1'] . ' ' . $order['shippingAddress'][0]['address2'] ?></span>
        <span><?php echo $order['shippingAddress'][0]['city'] ?>,</span>
        <span><?php echo $order['shippingAddress'][0]['stateProvinceGeoId'] ?>,<?php echo $order['shippingAddress'][0]['postalCode'] ?>.</span>
        <span><?php echo $order['shippingAddress'][0]['contactNumber'] ?></span>
      </div>
    </div>
    <div id="no-more-tables">
      <table class="table-bordered table-striped table-condensed cf returnOrderDetail">
        <thead>
          <tr class="ordertable-head">
            <td><?php echo t('Image');?></td>
            <td><?php echo t('Product Name');?></td>
            <td><?php echo t('SKU');?></td>
            <td><?php echo t('Price');?></td>
            <td><?php echo t('Quantity');?></td>
            <td><?php echo t('Item Status');?></td>
            <td><?php echo t('Sub Total');?></td>
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
                <img class="order-img" alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');"></a>
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
          </tr>
          <?php } ?>
        <tbody>
      </table>
      <div class="subTotal">
        <div class="price1-wrap">
          <span>Sub Total</span><span>&#8377;. <?php echo format_money($order['cartSubTotal']);?></span>
        </div>
      </div>
      <div class="subTotal">
        <div class="price1-wrap">
          <span>Shipping Total</span><span>&#8377;. <?php echo format_money($order['orderShippingTotal']);?></span>
        </div>
      </div>
      <div class="grandTotal">
        <div class="price1-wrap">
          <span>Grand Total</span><span>&#8377;. <?php echo format_money($order['orderGrandTotal']);?></span>
        </div>
      </div>
    </div>
    
  </div>
</div>
