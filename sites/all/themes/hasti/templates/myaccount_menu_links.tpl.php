<?php

$arg = arg(1);
$active = "active";
$myOrder = "";
$returnOrderItem = "";
$trackOrder = "";
$review = "";
$myWallet = "";
$personalInfo = "";
$changePwd = "";
$addressClass = "";

if($arg == 'orders' || $arg == 'returnOrder' || $arg == 'reorder') {
	$myOrder = $active;
}
if($arg == 'return-order') {
	$returnOrderItem = $active;
}
if($arg == 'review-rating') {
	$review = $active;
}
if($arg == 'profile') {
	$personalInfo = $active;
}
if($arg == 'add-address' || $arg == 'address-book' || $arg == 'edit-address') {
	$addressClass = $active;
}
if($arg == 'change-password') {
	$changePwd = $active;
}
?>
<h2>My Account</h2>
<ul>
	<li>
		<h3>Orders</h3>
		<ul>
			<li><a href="<?php echo url('account/orders');?>" data-ajax="false" class="<?php echo $myOrder;?>" >My Order</a></li>
			<li><a href="<?php echo url('account/return-order');?>" data-ajax="false" class="<?php echo $returnOrderItem;?>">Return Order</a></li>
			<li><a href="<?php echo url('account/');?>" data-ajax="false" class="<?php echo $trackOrder;?>">Track Order</a></li>
		</ul>
	</li>
	<li>
		<h3>My Stuff</h3>
		<ul>
			<li><a href="<?php echo url('account/review-rating');?>" data-ajax="false" class="<?php echo $review;?>">My Review & Ratings</a></li>
			<!--<li><a href="<?php //echo url('account/');?>" data-ajax="false">Recommendations for you</a></li>-->
			<li><a href="<?php echo url('account/love-list');?>" data-ajax="false">My Wishlist</a></li>
			<li><a href="<?php echo url('account/my-wallet');?>" data-ajax="false" class="<?php echo $myWallet;?>">My Wallet</a></li>
		</ul>
	</li>
	<li>
		<h3>Settings</h3>
		<ul>
			<li><a href="<?php echo url('account/profile');?>" data-ajax="false" class="<?php echo $personalInfo;?>">Personal information</a></li>
			<li><a href="<?php echo url('account/change-password');?>" data-ajax="false" class="<?php echo $changePwd;?>">Change Password</a></li>
			<li><a href="<?php echo url('account/address-book');?>" data-ajax="false" class="<?php echo $addressClass;?>">Address</a></li>
			<!--<li><a href="<?php //echo url('account/');?>" data-ajax="false">Profile Settings</a></li>
			<li><a href="<?php //echo url('account/');?>" data-ajax="false">Update Email/Mobile</a></li>
			<li><a href="<?php //echo url('account/');?>" data-ajax="false">Deactivate Account</a></li>
			<li><a href="<?php //echo url('account/');?>" data-ajax="false">Notification</a></li>-->
		</ul>
	</li>
	
</ul>
