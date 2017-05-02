 <div id="eCommerceMainPanel" class="mainPanel">
    <div id="eCommerceMyAccountContainer">
        <?php echo theme('myaccount_menu'); ?>
        <div id="eCommerceEditAddressBookContainer" class="orderDetail-layout">
          <div id="addressheader-wrapper">
            <div class="addressheader"><h1 class="myaccountaddressbook"><?php echo t('Address Book');?> </h1></div>
                <div class="container hk_container">
                          <a href="<?php echo url('account/add-address') ?>" class="standardBtn action"><?php echo t('Add New Address');?></a>
                      </div>
          </div>

            <div class="shippingAddress">
               <div class="addressContainer">
                  <div class="boxList addressBookList">
              
              <?php foreach($address_list as $k=>$addr) { ?>
               <div class="boxListItemGrid addressBookItem ">
                   <div class="displayBox">
                      <div class="default-address"><?php 
                       if($addr['isDefaultShipAddr']) { echo "Default Shipping Address";}
                      if($addr['isDefaultBillAddr']) { echo "Default Billing Address";}
                       ?></div>
                        <div class="shippingaddress">
                          <ul>
                            <div class="shipping-addrwrap">
                              <li class="shipname">
                                <div>
                                  <span style="font-size:1.2em;"><b><?php echo $addr['toName'];?></b></span>
                                </div>
                              </li>
                              
                              <li>
                                <div>
                                <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $addr['address1'];?></span>
                                </div>
                              </li>
                              <li>
                                <div>
                                    <span style="font-size:1.1em; word-wrap: break-word;"><?php echo $addr['city'];?>,</span>
                                </div>
                              </li>
                              <li>
                                  <div>
                                      <span style="font-size:1.1em;">
                                      <?php echo $addr['stateProvinceGeoId'];?>,<?php echo $addr['postalCode'];?>
                                      </span>
                                  </div>
                              </li>
                          
                                <li>
                                  <div class=""><span style="font-size:1.1em; word-wrap: break-word;">
                                  <?php echo t('Phone :');?> <?php echo $addr['contactNumber'];?>
                                  </span></div>
                                </li>

                               </div>
                             </ul>
                          </div>
  
                           <div class="container ">
                               <a href="<?php echo url('account/edit-address/'.$addr['contactMechId']) ?>" class="standardBtn update"><?php echo t('Update');?></a>
                           </div>
                         </div>
                      </div>
                      <?php } ?>
                  </div>
                 </div>
              </div>
        <div class="backbtn">
          <a href="<?php echo url('account/dashboard') ?>" class="standardBtn negative"><span><i class="fa fa-angle-double-left"></i><?php echo t('Back');?></span></a>
        </div>

    </div>
  </div>
</div>