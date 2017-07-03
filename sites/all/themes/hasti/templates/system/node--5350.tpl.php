<div id="content" class="checkout">
	<div class="container-fluid">
		<!-- <div class="row"> -->
		<div class="col-xs-12 col-sm-4 col-md-3 policy-left">
			<!--h2>Placing Order</h2-->
			<ul>
				<li><a href="#returns-policy" id="returns">Returns Policy</a></li>
				<li><a href="#terms-of-use">Terms Of Use</a></li>
				<li><a href="#security" id="security-li" class="active">Security</a></li>
				<li><a href="#privacy-policy">Privacy</a></li>
				<li><a href="#infringement">Infringement</a></li>
			</ul>
		</div>
		<div class="col-xs-12 col-sm-8 col-md-9">
			<div id="returns-policy" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
					<h2>Returns Policy</h2>
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

			<div id="terms-of-use" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12 checkout-right">
					<div class="heading-bar">
						<h2>Terms Of Use</h2>
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

			<div id="security" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
						<h2>Security</h2>
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

			<div id="privacy-policy" class="tab-content">
				<div class="col-xs-12 col-sm-12 col-md-12">
					<div class="heading-bar">
						<h2>Privacy Policy</h2>
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
			<!--privacy-policy end -->

			<div id="infringement" class="tab-content">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="heading-bar">
					<h2>infringement</h2>
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