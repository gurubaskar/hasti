<?php //krumo($orders) ?>

 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceOrderHistoryContainer" class="orderDetail-layout">

<div id="ptsOrderStatus" class="ptsSpot">
</div>

<div class="container orderDetails orderHistoryOrderDetails">

	<?php if (empty($orders['OrderHeader'])): ?>
		<h3><?php echo t('No Orders!'); ?></h3>
	<?php else: ?>

 <h1 class="pastorders"><?php echo t('Past Orders');?></h1>
   <div class="eCommerceEditCustomerInfo-headerr">
    <div class="boxList orderList">

		<?php echo count($orders['OrderHeader']) ?> <?php echo t('Item(s)');?>
		<div class="mainorder order-status">
		<ul class="order-statusul">
			<li class="orderid"><b><?php echo t('Order Id');?></b></li>
			<li class="orderedproduct"><b><?php echo t('Product Name');?></b></li>
			<li class="orderdate"><b><?php echo t('Order Date');?></b></li>
			<li class="orderstatus"><b><?php echo t('Status');?></b></li>
			<li class="ordertracking"><b><?php echo t('Price');?></b></li>
			<!--<li class="orderamout"><b>Actions</b></li>-->
		</ul>

		<?php foreach ($orders['OrderHeader'] as $i => $order): ?>
	        <ul class="myacc-orderdtls">
			    <li class="orderid"><?php echo $order['orderId'] ?></li>
				<li class="orderedproduct">
					<?php echo $order['productName'][0] ?>
					(<?php echo ucwords(str_replace(':', ': ', $order['productName'][1])) ?>)
				</li>
				<li class="orderdate"><?php echo date('d/m/Y H:i:s', strtotime($order['orderDate'])) ?></li>
                <li class="orderstatus"><?php echo $order['statusId'] ?></li>
                <li class="ordertracking">
                <span class="order-total">$ <?php echo format_money($order['orderGrandTotal']) ?></span>
                <span class="order-viewall"><a href="<?php echo url('account/orders-details/' . $order['orderId']) ?>"><?php echo t('View');?></a></span>
                </li>
         		<!--<li class="ordertracking"><a href="/eCommerceOrderDetail?orderId=GS10200" onclick="viewProducts();">View All</a></li>-->
			  </ul>
		<?php endforeach; ?>

	</div>
	</div>
	</div>

	<?php endif; ?>

	<div class="backbtn">
			<a href="<?php echo url('account/dashboard') ?>" class="standardBtn negative"><span><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></span></a>
		</div>
</div>

<div id="pesOrderStatus" class="pesSpot">
</div>

</div>
</div>
</div>