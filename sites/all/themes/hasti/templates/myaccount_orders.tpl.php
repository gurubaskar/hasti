<?php //krumo($orders);?>
<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right myorders">
	<h3>My Orders</h3>
	<ul class="tabing-wrap">
		<li class="tabing-btns tab-active active"><a href="#recent-orders">Recent Orders</a></li>
		<li class="tabing-btns"><a href="#past-orders">Past Orders</a></li>
	</ul>
	<div id="recent-orders" class="tab-content">
		<?php 
			if(count($orders['OrderHeader']) > 0) {
			foreach ($orders['OrderHeader'] as $i => $order): 
				$orderDate = strtotime($order['orderDate']);
				$dateInterval = strtotime("-2 weeks");
			if($dateInterval < $orderDate) {
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
					<?php if($status == 'Completed' || $status == "Return Requested" || $status == "Returned " || $status == "Return Cancelled") :?>
					<a class="returnOrder" href="<?php echo url('account/returnOrder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Return Order</a>
				<?php endif;?>
					<?php if($status == 'Approved') :?>
						<a href="#cancelWindow_<?php echo $order['orderId'];?>" id="signUpPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" class="ordercancel">Cancel Order</a>
					<!-- <a href="#cancelWindow" class="ordercancel" data-ajax="false">Cancel Order</a> -->
					<?php endif;?>
					<a class="reorder" href="<?php echo url('account/reorder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Re-Order</a>
					<!-- <a class="returnOrder" href="<?php echo url('account/returnOrder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Return Order</a> -->
				</div>
			</div>
			<?php
			  	$reasonList = cancelOrderReason();
			  ?>
			<div data-role="popup" id="cancelWindow_<?php echo $order['orderId'];?>" class="ui-content signin cancelOrder-wrap" style="max-width:700px">
			  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			  <form method="post" action="<?php echo url('drubiz/cancelOrder') ?>" id="cancelOrderForm" name="cancelOrderForm_<?php echo $order['orderId'];?>">
			  <div>
			  <h3>Cancel Order</h3>
			  <div id="cancelordermsg_<?php echo $order['orderId'];?>"></div>
			    <textarea id="cancelComments" data-msg-required="Comments is required." data-rule-required="true" placeholder="Remarks"></textarea>
			  	
			  	<select id="cancelReason">
			  		<?php
			  		foreach ($reasonList['cancelReasonList'] as $key => $reasonValue) { ?>
			  			<option id="<?php echo $reasonValue['cancelReasonId']?>" value="<?php echo $reasonValue['cancelReasonId']?>"><?php echo $reasonValue['cancelReason']?></option>
			  		<?php } ?>
			  	</select>
			  	<input type="hidden" name="orderid" value="<?php echo $order['orderId'];?>" id="cancel-id">
			    <!--<input type="button" value="Submit" onclick="cancelOrder(<?php //echo $order['orderId'];?>);">-->
			    <!--a href="" class="cancelord submit-btn" data-role="button" data-ajax="false" data-cancel-id="<?php echo $order['orderId'];?>">Submit</a-->
			    <input type="submit" value="Submit" class="cancelord submit-btn" data-cancel-id="<?php echo $order['orderId'];?>">
			    <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="text" class="cancel-btn">Cancel</a>
			  </div>
			  </form>
			</div>
		<?php } endforeach; 
		} else {?>
		<div> No Orders</div>
		<?php } ?>
	</div>
	
	<!-- Recent orders tab end -->

	<div id="past-orders" class="tab-content" style="display: none;">
		<?php 
			// if(count($orders['OrderHeader']) > 0) {
			foreach ($orders['OrderHeader'] as $i => $order): 
				$orderDate = strtotime($order['orderDate']);
				$dateInterval = strtotime("-2 weeks");
			if($dateInterval > $orderDate) {
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
					<?php if($status == 'Delivered') :?>
					<a class="returnorder" data-return-id="<?php echo $product_variant->product_id; ?>" data-ajax="false">Return</a>
				<?php endif;?>
					<?php if($status == 'Approved') :?>
						<a href="#cancelWindow_<?php echo $order['orderId'];?>" id="signUpPop" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" class="ordercancel">Cancel Order</a>
					<!-- <a href="#cancelWindow" class="ordercancel" data-ajax="false">Cancel Order</a> -->
					<?php endif;?>
					<a class="reorder" href="<?php echo url('account/reorder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Re-Order</a>
					<a class="returnOrder" href="<?php echo url('account/returnOrder');?>/<?php echo $order['orderId'];?>" data-ajax="false">Return Order</a>
				</div>
			</div>
			<?php
			  	$reasonList = cancelOrderReason();
			  ?>
			<div data-role="popup" id="cancelWindow_<?php echo $order['orderId'];?>" class="ui-content signin" style="max-width:700px">
			  <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
			  <div >
			  <h3>Cancel Order</h3>
			  <div id="cancelordermsg"></div>
			    <textarea id="cancelComments"></textarea>
			    <select id="cancelReason">
			  		<?php
			  		foreach ($reasonList['cancelReasonList'] as $key => $reasonValue) { ?>
			  			<option id="<?php echo $reasonValue['cancelReasonId']?>" value="<?php echo $reasonValue['cancelReasonId']?>"><?php echo $reasonValue['cancelReason']?></option>
			  		<?php } ?>
			  	</select>
			  	<input type="hidden" name="orderid" value="<?php echo $order['orderId'];?>" id="cancel-id">
			    <!--<input type="button" value="Submit" onclick="cancelOrder(<?php //echo $order['orderId'];?>);">-->
			    <a href="" class="cancelord" data-role="button" data-ajax="false" data-cancel-id="<?php echo $order['orderId'];?>">Submit</a>
			    <a href="#" data-rel="back" data-role="button" data-theme="b" data-icon="delete" data-iconpos="text" class="">Cancel</a>
			  </div>
			</div>
		<?php } endforeach; ?>
		
	<!-- </div> -->
	</div>
	<!-- past orders tab end -->

</div>