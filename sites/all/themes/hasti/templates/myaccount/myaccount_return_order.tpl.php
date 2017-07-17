<?php //krumo($order) ?>
<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
  <h3>My Orders</h3>
  <div id="demo-top-bar">
    <div id="page-wrap">
      <table>
        <thead>
          <tr>
            <td>
              Order Id
            </td>
            <td>
              Date
            </td>
            <td>
              Place
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <?php echo $order['orderId'];?>
            </td>
            <td>
              <?php echo date('d/m/Y H:m',strtotime($order['orderDate']));?>
            </td>
            <td>
              <?php 
                echo $order['orderPlacedAddress']['toName'].',<br>';
                echo $order['orderPlacedAddress']['address1'].',<br>';
                echo $order['orderPlacedAddress']['address2'].',<br>';
                echo $order['orderPlacedAddress']['city'].'-'.$order['orderPlacedAddress']['postalCode'].',<br>';
                echo $order['orderPlacedAddress']['stateProvinceGeoId'].','. $order['orderPlacedAddress']['countryGeoId'];
              ?>
            </td>
          </tr>
        <tbody>
      </table>
    </div>
    <div id="page-wrap">
      <table>
        <thead>
          <tr>
            <td>
              Product Name
            </td>
            <td>
              Image
            </td>
            <td>
              Price
            </td>
            <td>
              Return
            </td>
            <td>
              Reason
            </td>
            <td>
              Item Status
            </td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($order['returnableOrderItems'] as $key => $orderValue) { 
          $nid = get_nid_from_variant_product_id($orderValue['productId']);
          $node = node_load($nid);
          $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
          $product_variant = $system_data->product_variants->{$orderValue['productId']};
        ?>
          <tr>
            <td>
              <?php echo $orderValue['itemDescription'];?>
            </td>
            <td>
              <img class="order-img" alt="<?php echo $orderValue['itemDescription'];?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
            </td>
            <td>₹.
              <?php 
                echo $orderValue['unitPrice'];
              ?>
            </td>
            <td>
              <input type="checkbox" name="slectedReturnProduct[]" id="slectedReturnProduct[]" class="returnProduct" value="<?php echo $orderValue['productId'];?>">
            </td>
            <td>
              <select id="returnReason">
                <?php foreach ($order['returnReasons'] as $key => $returnValue) { ?>
                    <option value="<?php echo $returnValue['returnReasonId'];?>"><?php echo $returnValue['description'];?></option>
                <?php } ?>
              </select>
            </td>
            <td>
              <?php 
                echo $orderValue['setStatusId'];
              ?>
            </td>
          </tr>
          <?php } ?>
        <tbody>
      </table>
    </div>
    <div id="page-wrap">
      <table>
        <thead>
          <tr>
            <td>
              Select Refund Type
            </td>
            <td>
            <select id="refundType">
            <?php foreach ($order['returnTypes'] as $key => $refundValue) { ?>
                <option value="<?php echo $refundValue['returnTypeId'];?>"><?php echo $refundValue['description'];?></option>
            <?php } ?>
            </select>
            </td>
          </tr>
        </thead>
      </table>
    </div>
    <div id="returnSubmit" class="details-btns returnSubmit">
      <a href="">Submit</a>
    </div>
  </div>
  
  
</div>