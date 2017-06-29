<div class="col-xs-12 col-sm-4 col-md-3 myaccount-left">
  <?php echo theme('myaccount_menu_links'); ?>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2>Address Book</h2>
    </div>
    <?php foreach($address_list as $k=>$addr) { ?>
      <div class="addressbox" id="delete_<?php echo $addr['contactMechId'] ;?>">
        <div class="col-xs-8 col-sm-6 col-md-6 pleft address">
          <h4><?php echo $addr['toName']?></h4>
          <span><?php echo $addr['address1'];?></span>
          <span><?php echo $addr['address2']?></span>
          <span><?php echo $addr['city'];?></span>
          <span><?php echo $addr['stateProvinceGeoId'];?>,<?php echo $addr['postalCode'];?></span>
          <div class="phno"><label>Mob No:</label><span><?php echo $addr['contactNumber'];?></span></div>
        </div>
        <div class="col-xs-4 col-sm-6 col-md-6 edit-address pright">
          <a href="<?php echo url('account/edit-address/'.$addr['contactMechId']) ?>" class="standardBtn update"><?php echo t('Update');?></a>
          <a href="#"><span class="delete address-delete" data-contactMechId="<?php echo $addr['contactMechId'] ;?>">delete</span></a>
        </div>
      </div>
    <?php } ?>
    <div class="btns-wrap">
      <span class="new-address"><a href="<?php echo url('account/add-address') ?>" class="buy-now">Add New Address</a></span>
      <a href="<?php echo url('account/profile') ?>" class="standardBtn negative"><span><i class="fa fa-angle-double-left"></i><?php echo t('<< Back');?></span></a>
    </div>
  </div>
</div>