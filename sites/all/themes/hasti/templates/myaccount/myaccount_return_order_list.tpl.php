<?php //krumo($orders);?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right returnOrderItem">
	<h3>Return Orders</h3>
	<div id="past-orders" class="tab-content">
		<?php 
			// if(count($orders['OrderHeader']) > 0) {
			foreach ($returnOrder['returnedOrders'] as $key => $order): 
				$orderDate = strtotime($order['orderDate']);
				// $dateInterval = strtotime("-2 weeks");
			$nid = get_nid_from_variant_product_id($order['productId']);
	        $node = node_load($nid);
	        $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
	        $product = $system_data->product_raw;
	        $product_variant = $system_data->product_variants->{$order['productId']};
	        $status = $order['statusId'];
			?>
			<div class="cartbox">
				<div class="col-xs-3 col-sm-3 col-md-4 img-wrap">
					<img alt="<?php echo $product->product_name ?>" src="<?php echo drubiz_image($product_variant->plp_image_alt) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
				</div>
				<div class="col-xs-9 col-sm-9 col-md-8 cart-details pright">
					<div class="col-xs-12 col-sm-12 col-md-12 details-left">
						<div id="orderid-wrap"> Order Id: <span><a href="<?php echo url('account/returnOrder/' . $order['orderId']) ?>"><?php echo $order['orderId'] ?></a></span>
						</div>
						<div class="cartrow">
							<label>Grand Total:</label><span>&#8377;. <?php echo format_money($order['grandTotal']) ?></span>
						</div>
						<div class="cartrow">
							<label>Date:</label><span><?php echo date('d/m/Y H:i:s', strtotime($order['returnDate'])) ?></span>
						</div>
						<div class="cartrow">
							<label>Status:</label><span><?php echo $status; ?></span></span>
						</div>
					</div>
				</div>
				
			</div>
			
		<?php endforeach; ?>
		
	<!-- </div> -->
	</div>
</div>