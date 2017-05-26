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
					<!-- <div class="cartrow"><label>Size:</label><span class="size">XXL</span></div>
					<div class="cartrow"><label>Color:</label><span class="color">Blue</span></div> -->
					<div class="cartrow"><label>Date:</label><span>Wed 16th may 2017</span></div>
					<div class="cartrow"><label>Status:</label><span>Delivered on <span class="deliver-date">17th may 2017</span></span></div>
				</div>
			</div>
		</div>
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