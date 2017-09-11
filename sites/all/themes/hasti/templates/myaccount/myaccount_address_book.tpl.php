<div class="col-xs-12 col-sm-4 col-md-3 leftMenuWrap">
  <div class=" myaccount-left">
    <?php echo theme('myaccount_menu_links'); ?>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 myaccount-right">
  <div class="col-xs-12 col-sm-12 col-md-12" id="address-book">
    <h3>Address Book</h3>
    <?php if(isset($_COOKIE['flag'])){?>
    <script type="text/javascript">
    //alert('hi');
    var ajaxErrorMsg = '<?php echo $_COOKIE["successmsg"];?>';
    //alert(ajaxErrorMsg);
    jQuery( document ).ready(function() {
      ajaxErrorMsgDisplay(ajaxErrorMsg,ajaxInfo);
    });
    //jQuery.notify(<?php //echo $_COOKIE["successmsg"];?>);</script>
    <?php }
    // setcookie('successmsg','', time() + (60 * 2), '/');
    // setcookie('flag','', time() + (60 * 2), '/');
    // unset($_COOKIE['successmsg']);
    // unset($_COOKIE['flag']);
    ?>
    <?php foreach($address_list as $k=>$addr) { ?>
      <div class="addressbox" id="delete_<?php echo $addr['contactMechId'] ;?>">
        <div class="col-xs-12 col-sm-12 col-md-12 pleft address">
          <h4><?php echo $addr['toName']?></h4>
          <span><?php echo $addr['address1'];?></span>
          <span><?php echo $addr['address2']?></span>
          <span><?php echo $addr['city'];?></span>
          <span><?php echo $addr['stateProvinceGeoId'];?>,<?php echo $addr['postalCode'];?></span>
          <div class="phno"><label>Mob No:</label><span><?php echo $addr['contactNumber'];?></span></div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 edit-address">
          <a href="<?php echo url('account/edit-address/'.$addr['contactMechId']) ?>" class="standardBtn"><?php echo t('Update');?></a>
          <a href="#"><span class="delete address-delete" data-contactMechId="<?php echo $addr['contactMechId'] ;?>">Delete</span></a>
          <?php if($addr['isDefaultShipAddr'] == false) {?>
          <a href="#"><span class="setdefault-address" data-contactMechId="<?php echo $addr['contactMechId'] ;?>">Set As Default</span></a>
          <?php } else { ?>
            <span class="basic-btn">Default Address</span>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
    <div class="btns-wrap">
    <?php if(count($address_list) < 4){ ?>
      <span class="new-address"><a href="<?php echo url('account/add-address') ?>" class="buy-now">Add New Address</a></span>
    <?php }?>
      <a href="<?php echo url('account/profile') ?>" class="standardBtn negative"><span><i class="fa fa-angle-double-left"></i><?php echo t('<< Back');?></span></a>
    </div>
  </div>
</div>