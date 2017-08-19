<?php //krumo($orders);?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
	<h3>Track Order</h3>
	<div id="recent-orders">
		<?php 
		if(count($orders['OrderHeader']) > 0) {
			foreach ($orders['OrderHeader'] as $i => $order): 
				$orderDate = strtotime($order['orderDate']);
				$nid = get_nid_from_variant_product_id($order['productId']);
		        $node = node_load($nid);
		        $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
		        $product = $system_data->product_raw;
		        $product_variant = $system_data->product_variants->{$order['productId']};
		        $status = $order['statusId'];
			?>
			<div class="cartbox">
				<h3>Order Id: <span><?php echo $order['orderId'] ?></span></h3>
				<div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
					<img alt="<?php echo $product->product_name ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
				</div>
				<div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
					<div class="col-xs-12 col-sm-12 col-md-12 details-left">
						<div class="cartrow">
							<label>Grand Total:</label><span>&#8377;. <?php echo format_money($order['orderGrandTotal']) ?></span>
						</div>
						<div class="cartrow">
							<label>Date:</label><span><?php echo date('d/m/Y H:i:s', strtotime($order['orderDate'])) ?></span>
						</div>
						<div class="cartrow">
							<label>Status:</label><span><?php echo $status; ?></span></span>
						</div>
					</div>
				</div>
				<div class="details-btns">
					<a class="returnOrder" href="<?php echo url('account/trackOrder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Track Order</a>
				</div>
			</div>
			<?php endforeach; 
		} else {?>
			<div> No Orders</div>
		<?php } ?>
	</div>
</div>