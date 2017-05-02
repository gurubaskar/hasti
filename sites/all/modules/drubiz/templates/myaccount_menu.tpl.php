<div class="MyAccount-subdiv">
<span class="MyAccount-subdivh2"><?php echo t('my account');?></span>  <!-- added on 22-06 -->

<div class="displayBoxList" style="display: none;">

	<div class="displayBox">

	<ul>
	    <!--<h3></h3>-->
	    <span class="account"><b><?php echo t('Personal Information');?></b></span>
	    <!-- <li>
	      <div>
	       <p>Need to update your name or other personal information&#63; Click the link below&#58;</p>
	      </div>
	     </li>-->
	     <li>
	      <div class="accountlink">
	      <a href="<?php echo url('account/dashboard') ?>"><span><?php echo t('Account Dashboard');?></span></a>
	      </div>
	     </li>
	    </ul>
	</div>
	<div class="displayBox">
	   <!-- <h3>Order Status</h3>-->
	    <span class="account"><b><?php echo t('Order Status');?></b></span>
	    <ul class="displayList">
	    <!-- <li>
	      <div>
	       <p>Need to view current or past orders&#63;  Click the link below&#58;</p>
	      </div>
	     </li>
	     <li>-->
	      <div class="accountlink">
	       <a href="<?php echo url('account/orders') ?>"><span><?php echo t('My Orders')?></span></a>
	      </div>
	     
	    </ul>
	</div>
	<div class="displayBox">

	<ul>
	    <!--<h3></h3>-->
	    <span class="account"><b><?php echo t('Personal Information');?></b></span>
	    <!-- <li>
	      <div>
	       <p>Need to update your name or other personal information&#63; Click the link below&#58;</p>
	      </div>
	     </li>-->
	     <li>
	      <div class="accountlink">
	      <a href="<?php echo url('account/profile') ?>"><span><?php echo t('Profile Settings');?></span></a>
	      </div>
	     </li>
	    </ul>
	</div>
	<div class="displayBox">
	    <!--<h3>Address Book</h3>-->
	    <span class="account"><b>Address Book</b></span>
	    <ul class="displayList" style="border-bottom:1px solid #ccc; margin-bottom:10px;">
	    <!-- <li>
	      <div>
	       <p>Need to add or update an address&#63;  Click the link below&#58;</p>
	      </div>
	     </li>
	     <li> -->
	      <div class="accountlink">
	       <a href="<?php echo url('account/address-book') ?>"><span><?php echo t('Address Book');?></span></a>
	      </div>
	     
	    </ul>
	</div>
		<div class="displayBox">
		   <!-- <h3></h3>-->
		   <span class="account"><b><?php echo t('Login Information');?></b></span>
		    <ul class="displayList" style="border-bottom:1px solid #ccc; margin-bottom:10px;">
		     <!--<li>
		      <div>
		       <p>Need to update your e-mail address or password&#63;  Click the link below&#58;</p>
		      </div>
		     </li>-->
		     <li>
		      <div class="accountlink">
		       <a href="<?php echo url('account/change-password') ?>"><span><?php echo t('Change Password');?></span></a>
		      </div>
		     </li>
		    </ul>
		</div>
		<div class="displayBox">
		   <span class="account"><b><?php echo t('Loyalty Info');?></b></span>
		    <ul class="displayList" style="border-bottom:1px solid #ccc; margin-bottom:10px;">
		     <li>
		      <div class="accountlink">
		       <a href="<?php echo url('account/loyalty-info').'?flag=true' ?>"><span><?php echo t('Loyalty Information');?></span></a>
		      </div>
		     </li>
		    </ul>
		</div>
		<div class="displayBox">
		   <span class="account"><b><?php echo t('Store Credit Info');?></b></span>
		    <ul class="displayList" style="border-bottom:1px solid #ccc; margin-bottom:10px;">
		     <li>
		      <div class="accountlink">
		       <a href="<?php echo url('account/storecredit-info') ?>"><span><?php echo t('StoreCredit Information');?></span></a>
		      </div>
		     </li>
		    </ul>
		</div>



	<!-- Added by Sankar on 18th Aug 2015-->
	<!-- <div class="displayBox">
	    <span class="account"><b>Globus Frends Reward</b></span>
	    <ul class="displayList">
	      <div class="accountlink">
	       <a href="#"><span>Globus Frends Rewards</span></a>
	      </div>
	     
	    </ul>
	</div> -->
	<!-- End -->
	<!-- Added by Sankar on 10th Mar 2016-->
	<!-- <div class="displayBox">
	    <span class="account"><b>My Product Reviews</b></span>
	    <ul class="displayList">
	      <div class="accountlink">
	       <a href="<?php echo url('product/reviews') ?>"><span>My Product Reviews</span></a>
	      </div>
	     
	    </ul>
	</div> -->
	<!-- End -->
	<!-- Added by Sankar on 17th Mar 2016-->
	<!-- <div class="displayBox">
	    <span class="account"><b>My Subscriptions</b></span>
	    <ul class="displayList">
	      <div class="accountlink">
	       <a href="#"><span>Newsletter Subscriptions</span></a>
	      </div>
	     
	    </ul>
	</div> -->
	<!-- End -->
	<!-- <div class="displayBox">
	    <span class="account"><b>Referrer Invitations</b></span>
	    <ul class="displayList">
	      <div class="accountlink">
	       <a href="#"><span>Referrer Invitations</span></a>
	      </div>
	     
	    </ul>
	</div> -->

</div>
</div>