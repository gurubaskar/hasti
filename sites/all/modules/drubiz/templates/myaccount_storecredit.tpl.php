 <?php //krumo($storecredit) ?>
 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceEditCustomerInfoContainer" class="orderDetail-layout">
<div id="ptsLoginInfo" class="ptsSpot">
</div>

<input type="hidden" name="partyId" value="10230">
<div id="emailPasswordEntry" class="displayBox">
    <h1><?php echo t('Store Credit Info');?></h1>
    <div class="eCommerceEditCustomerInfo-headerr"></div>
    <h2 class="MyAccount-subhead"><?php echo t('Account Information');?></h2>
  
    <div> Currently you have <?php echo $storecredit['partyStoreCreditBalance'] ?> points in your store credit account.</div>
 
</div>

<div class="changePersInfo">
<div class="container mcontainer">
      <a class="standardBtn" href="<?php echo url('account/dashboard') ?>"><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></a> <!-- added on 22-06 -->
</div>
</div>

<div id="pesLoginInfo" class="pesSpot">
</div>
</div>
</div></div>