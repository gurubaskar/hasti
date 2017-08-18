<style>
ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3.5em;
}

ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}

ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 2.2em;
    width: 2.2em;
    line-height: 2.2em;
    border: none;
    border-radius: 2.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 2.2em;
    bottom: -1.2em;
}

</style>
<?php //krumo($order) ?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>

<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
  <h3>Order Details</h3>
  <div id="demo-top-bar">
    <div id="no-more-tables">
      <table class="table-bordered table-striped table-condensed cf returnDetail">
        <thead>
          <tr>
            <td>
              Order Id
            </td>
            <td>
              Order Status
            </td>
            <td>
              Amount Paid
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td data-title="Order Id">
              <?php echo $order['orderId']; ?>
            </td>
            <td data-title="Order Status">
              <?php echo $order['OrderHeader'][0]['statusId'];?>
            </td>
            <td data-title="Amount Paid">
              &#8377;. <?php echo format_money($order['orderGrandTotal']) ?>
            </td>
          </tr>
        <tbody>
      </table>
    </div>
    <div class="shippingDetail">
      <h4>Shipping Address</h4>
      <span><?php echo $order['shippingAddress'][0]['toName'] ?></span>
      <span><?php echo $order['shippingAddress'][0]['address1'] . ' ' . $order['shippingAddress'][0]['address2'] ?></span>
      <span><?php echo $order['shippingAddress'][0]['city'] ?>,</span>
      <span><?php echo $order['shippingAddress'][0]['stateProvinceGeoId'] ?>,<?php echo $order['shippingAddress'][0]['postalCode'] ?></span>
      <span><?php echo $order['shippingAddress'][0]['contactNumber'] ?></span>
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
            <td data-title="SKU">&#8377;.
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
        <span>Sub Total</span><span>&#8377;. <?php echo format_money($order['cartSubTotal']);?></span>
      </div>
      <div class="grandTotal">
        <span>Grand Total</span><span>&#8377;. <?php echo format_money($order['orderGrandTotal']);?></span>
      </div>
    </div>
    <div>
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
</div>
