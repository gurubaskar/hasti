<div id="content" class="checkout">
	<div class="container-fluid">
		<!-- <div class="row"> -->
		<div class="col-xs-12 col-sm-4 col-md-3 faq-left">
			<!--h2>Placing Order</h2-->
			<ul>
				<li><a href="#faq" id="faq" class="active">Site Map</a></li>
				<li><a href="#tracking-order">Shipping, Order, Tracking & Delivery</a></li>
				<li><a href="#cancellation" id="security-li">Cancellation & Modification</a></li>
				<li><a href="#try-buy">Try & Buy</a></li>
				<li><a href="#payment">Payment</a></li>
				<li><a href="#return-exchange">Returns & Exchange</a></li>
			</ul>
		</div>
		<div class="col-xs-12 col-sm-8 col-md-9">
			<div id="faq" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
					<h2>Site Map</h2>
				</div>
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 pleft">
					<?php
						print render($region['return']);
					?>
					</div>
				</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-4"></div>
			</div>
			<!--returns-policy end -->

			<div id="tracking-order" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12 checkout-right">
					<div class="heading-bar">
						<h2>Shipping, Order, Tracking & Delivery</h2>
					</div>
					<div class="">
						<div class="col-xs-12 col-sm-12 col-md-12 pleft">
							<span>
								<?php
									print render($region['term_of_use']);
								?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!--terms-of-use end -->

			<div id="cancellation" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
						<h2>Cancellation & Modification</h2>
					</div>
					<div class="">
						<div class="col-xs-12 col-sm-12 col-md-12 pleft">
							<span>
								<?php
									print render($region['security']);
								?>
							</span>
						</div>
					</div>					
				</div>
			</div>
			<!--security end -->

			<div id="try-buy" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
						<h2>Try & Buy</h2>
					</div>
					<div class="">
						<div class="col-xs-12 col-sm-12 col-md-12 pleft">
							<span>
								<?php
									print render($region['privacy']);
								?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!--Try & Buy -->

			<div id="payment" class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="heading-bar">
					<h2>Payment</h2>
				</div>
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 pleft">
						<?php 
							print render($region['infringement']);
						 ?>	
					</div>
				</div>
				</div>
			</div>
			<!--Payment -->
			
			<div id="return-exchange" class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="heading-bar">
					<h2>Returns & Exchange</h2>
				</div>
				<div class="">
					<div class="col-xs-12 col-sm-12 col-md-12 pleft">
						<?php 
							print render($region['infringement']);
						 ?>	
					</div>
				</div>
				</div>
			</div>
			<!--infringement -->

		</div>
		<!-- </div> -->
	</div>
</div>