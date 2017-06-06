<?php krumo($orders);?>
<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
	<h3>My Orders</h3>
	<ul class="tabing-wrap">
		<li class="tabing-btns tab-active active"><a href="#recent-orders">Recent Orders</a></li>
		<li class="tabing-btns"><a href="#past-orders">Past Orders</a></li>
	</ul>
	<div id="recent-orders" class="tab-content">
		<?php foreach ($orders['OrderHeader'] as $i => $order): 
			$nid = get_nid_from_variant_product_id($order['productId']);
	        $node = node_load($nid);
	        $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
	        $product = $system_data->product_raw;
	        $product_variant = $system_data->product_variants->{$order['productId']};
	        $status = $order['statusId'];
			?>
			<div class="cartbox">
				<h3>Order Id: <span><a href="<?php echo url('account/orders-details/' . $order['orderId']) ?>"><?php echo $order['orderId'] ?></a></span></h3>
				<div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
					<img alt="<?php echo $product->product_name ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
				</div>
				<div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
					<div class="col-xs-12 col-sm-12 col-md-12 details-left">
						<div class="cartrow">
							<label>Grand Total:</label><span>₹. <?php echo format_money($order['orderGrandTotal']) ?></span>
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
					<?php if($status == 'Delivered') :?>
					<a class="returnorder" data-return-id="<?php echo $product_variant->product_id; ?>" data-ajax="false">Return</a>
				<?php endif;?>
					<?php if($status == 'Approved') :?>
					<a class="ordercancel" data-cancel-id="<?php echo $product_variant->product_id; ?>" data-ajax="false">Cancel Order</a>
					<?php endif;?>
					<a class="reorder" data-reorder-id="<?php echo $product_variant->product_id; ?>" data-ajax="false">Re-Order</a>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<!-- Recent orders tab end -->

	<div id="past-orders" class="tab-content" style="display: none;">
		<div class="cartbox">
			<h3>Order Id: <span>123456789</span></h3>
			<div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
				<img src="images/cart1.jpg" alt="" class="img-responsive">
			</div>
			<div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
				<div class="col-xs-12 col-sm-12 col-md-12 details-left">
					<h4>Name of the Product</h4>
					<div class="cartrow"><label>Qty:</label><span class="qty">1</span></div>
					<div class="cartrow"><label>Price:</label><span>₹. 320</span></div>
					<div class="cartrow"><label>Date:</label><span>Wed 16th may 2017</span></div>
					<div class="cartrow"><label>Status:</label><span>Delivered on <span class="deliver-date">17th may 2017</span></span></div>
				</div>
			</div>
		</div>
	</div>
	<!-- past orders tab end -->

</div>