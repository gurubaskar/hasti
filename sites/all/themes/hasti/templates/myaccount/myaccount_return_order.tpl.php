<?php //krumo($order) ?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
  <h3>My Orders</h3>
  <?php if(count($order['orderId']) > 0 ) {?>
  <div id="demo-top-bar">
    <div id="no-more-tables">
      <table class="table-bordered table-striped table-condensed cf returnDetail">
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
            <td data-title="Order Id">
              <?php echo $order['orderId'];?>
            </td>
            <td data-title="Date">
              <?php echo date('d/m/Y H:m',strtotime($order['orderDate']));?>
            </td>
            <td data-title="Place">
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
    <div id="no-more-tables">
      <input type="hidden" name="orderId" id="orderId" value="<?php echo $order['orderId'];?>">
      <table class="table-bordered table-striped table-condensed cf returnOrderDetail">
        <thead>
          <tr>
            <td>
              Product Name
            </td>
            <td>
              Image
            </td>
            <td>
              Quantity
            </td>
            <td>
              Price
            </td>
            <td>
              <input type="checkbox" id="checkAll">
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
        <?php foreach ($order['orderItems'] as $key => $orderValue) { 
          $nid = get_nid_from_variant_product_id($orderValue['productId']);
          $node = node_load($nid);
          $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
          $product_variant = $system_data->product_variants->{$orderValue['productId']};
        ?>
          <tr>
            <td data-title="Product Name">
              <?php 
                echo $orderValue['itemDescription'];
                $isReturned = $orderValue['isReturned'];
                if($isReturned == 'Y') {
                  echo "<br />Note: You have already requested <br />a Return for this product.";
                }
              ?>
            </td>
            <td data-title="Image">
              <img class="order-img" alt="<?php echo $orderValue['itemDescription'];?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
            </td>
            <td data-title="Quantity">
              <?php 
                echo $orderValue['quantity'];
              ?>
            </td>
            <td data-title="Price">&#8377;.
              <?php 
                echo $orderValue['unitPrice'];
              ?>
            </td>
            <td data-title="Return">
              <?php 
              if($isReturned == 'N') {
                $selectedReturnProductId = $orderValue['orderItemSeqId'].'_'.$orderValue['productId'].'_'.$orderValue['quantity'];?>
                <input type="checkbox" name="slectedReturnProduct[]" id="slectedReturnProduct[]" class="returnProduct" value="<?php echo $selectedReturnProductId;?>">
              <?php } ?>
            </td>
            <td data-title="Reason">
            <?php
              $returnReasonIdSelected = '';
              $disabled = '';
              if($isReturned == 'Y') {
                $returnReasonIdSelected = $orderValue['returnReasonId'];
                $disabled = 'disabled';
              }
            ?>
              <select id="returnReason_<?php echo $selectedReturnProductId;?>" <?php echo $disabled;?> >
                <?php 
                  foreach ($order['returnReasons'] as $key => $returnValue) { 
                    $selected = '';
                    $returnReasonId = $returnValue['returnReasonId'];
                    if($returnReasonIdSelected == $returnReasonId) {
                      $selected = 'selected';
                    }
                  ?>
                    <option value="<?php echo $returnValue['returnReasonId'];?>" <?php echo $selected;?>><?php echo $returnValue['description'];?></option>
                <?php } ?>
              </select>
            </td>
            <td data-title="Item Status">
              <?php 
                echo $orderValue['setStatusId'];
              ?>
            </td>
          </tr>
          <?php } ?>
        <tbody>
      </table>
    </div>
    <div id="page-wrap" class="refundTypeDisplay" style="display: none;">
      <table>
        <thead>
          <tr>
            <td>
              Select Refund Type
            </td>
            <td>
            <select id="refundType">
              <option value="0">Please select</option>            
              <?php foreach ($order['returnTypes'] as $key => $refundValue) { ?>
                <option value="<?php echo $refundValue['returnTypeId'];?>"><?php echo $refundValue['description'];?></option>
              <?php } ?>
            </select>
            </td>
          </tr>
        </thead>
      </table>
    </div>
    <div class="bankDetails" style="display: none;">
      <div id="return_errormsgs" style=""></div>
      <form method="post" action="<?php echo url('drubiz/returnOrder') ?>" id="refundForm" name="refundForm"> 
      <div class="form-row">
        <label>*Account Holder Name</label> <input type="textbox" name="accountHolderName" id="accountHolderName" data-msg-required="Enter the Account holder name" data-rule-required="true">
      </div>
      <div class="form-row">
        <label>*Bank Name</label> <input type="textbox" name="bankName" id="bankName" data-msg-required="Enter the bank name" data-rule-required="true">
      </div>
      <div class="form-row">
        <label>*Account Number</label> <input type="textbox" name="accountNumber" id="accountNumber" data-msg-required="Enter the Account number" data-rule-required="true">
      </div>
      <div class="form-row">
        <label>*IFSC Code</label> <input type="textbox" name="ifscCode" id="ifscCode" data-msg-required="Enter the ifsc code" data-rule-required="true">
      </div>
       <!--div id="returnSubmit" class="details-btns returnSubmit">
        <a href="">Submit</a-->
      <div>
        <input type="submit" value="Submit" class="basic-btn">
      </div>
      </form>
    </div>
   <div id="storecredit" style="display: none">
      <div class="details-btns returnSubmit">
        <a href="" id="returnSubmit" onclick="refundReturn()">Submit</a>
      </div>
   </div>
  </div>
  <?php } else { ?>
    <div>No Orders</div>
  <?php } ?>
</div>