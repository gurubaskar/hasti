<?php //krumo($orders, $profile, $addresses) ?>
 <div id="eCommerceMainPanel" class="mainPanel">
 <div id="eCommerceMyAccountContainer">
 <?php echo theme('myaccount_menu'); ?>
<div id="eCommerceEditAddressBookContainer" class="orderDetail-layout">
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PTS_ADDRESS_BOOK_VIEW -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="ptsAddressBook" class="ptsSpot">
</div>
<h1><?php echo t('My Dashboard'); ?></h1><br>
<p class="dashboard-msg"><?php echo t('From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.'); ?></p>	
<br>
<div class="content navigation siteHeaderNavigation">

  <?php if (!empty($orders['OrderHeader'])): ?>
		<table class="dashboard-table">
			
            <tbody><tr class="dashboard-head">
                  <td class="product firstCol orderid" scope="col" colspan="2"><b><?php echo t('Order Id'); ?></b></td>
                  <td class="product firstCol orderdate" scope="col" colspan="2"><b><?php echo t('Order Date'); ?></b></td>
                  <td class="product firstCol shipto" scope="col" colspan="2"><b><?php echo t('Ship To'); ?></b></td>
                  <td class="product firstCol ordertotal" scope="col" colspan="2"><b><?php echo t('Order Total'); ?></b></td>
                  <td class="product firstCol orderstatus" scope="col" colspan="2"><b><?php echo t('Status'); ?></b></td>
                  <td class="product firstCol vieworder" scope="col" colspan="2"><b><?php echo t('Action'); ?></b></td>
			</tr>

    <?php foreach ($orders['OrderHeader'] as $i => $order): if ($i >= 2) break; ?>

			<tr class="dashboard-dtls">
				<td class="product firstCol oid" scope="col" colspan="2"><b><?php echo $order['orderId'] ?></b></td>
				<td class="product firstCol odate" scope="col" colspan="2"><b><?php echo date('d/m/Y', strtotime($order['orderDate'])) ?></b></td>
                <td class="product firstCol oshipto" scope="col" colspan="2"><b><?php echo $profile['firstName'] . ' ' . $profile['lastName'] ?></b></td>
                <td class="product firstCol ototal" scope="col" colspan="2"><b>$ <?php echo format_money($order['orderGrandTotal']) ?></b></td>
                <td class="product firstCol ostatus" scope="col" colspan="2"><b><?php echo $order['statusId'] ?></b></td>
                <td class="product firstCol oview" scope="col" colspan="2"><b><a href="<?php echo url('account/orders-details/' . $order['orderId']) ?>"><span><?php echo t('View Order'); ?></span></a></b></td>
			</tr>

    <?php endforeach; ?>

    </tbody>
    </table>
  <?php endif; ?>

 <div class="personalinfo-newsletter">
 <div class="content navigation siteHeaderNavigation" id="dashboard-personalinfo">
<span class="account"><b><?php echo t('Personal Information'); ?></b>
<a class="dbedit" href="<?php echo url('account/profile') ?>">
<span class="editinfo"><span class="brac">(</span><?php echo t('Edit'); ?><span class="brac">)</span></span>
</a>
</span>  <!-- end of account -->
<br>
<span class="db-personaldtls"><label class="db-username"><?php echo t('Username:'); ?></label> <span class="db-fname"><?php echo $profile['firstName'] . ' ' . $profile['lastName'] ?></span></span> <br>
<span class="db-personaldtls"><label class="db-email"><?php echo t('Email Address:'); ?></label> <span class="db-mail"><?php echo $GLOBALS['user']->mail ?></span>
<a class="db-changepwd" href="<?php echo url('account/change-password') ?>"><span class="brac">(</span><?php echo t('change password'); ?><span class="brac">)</span></a></span>
 </div>
 <div class="dashboard-newsletter">
 <span class="account"><b><?php echo t('newsletters'); ?></b><a class="newsedit" href="/eCommerceSubscriptions"><span class="brac">(</span><?php echo t('edit'); ?><span class="brac">)</span></a></span><br>
  <span class="subscription-dtls"><?php echo t('You are currently not subscribed any newsletters'); ?></span>
</div>
</div> 

		<!-- added on 22-06 -->
<div class="eCommerceEditCustomerInfo-headerr"></div>	<!-- changed on 22-06 -->
<form method="post" id="checkoutInfoForm" name="checkoutInfoForm">
<input type="hidden" id="checkoutpage" name="checkoutpage" value="shippingaddress">
<input type="hidden" id="osafeFormRequestName" name="osafeFormRequestName" value="multiPageValidateCheckoutAddress">
<input type="hidden" id="contactMechId" name="contactMechId">
<div class="shippingAddress dashboard-shipaddr">
<h1 class="dashboard-addr"><?php echo t('Address Book'); ?>  <a class="db-editaddr" href="<?php echo url('account/address-book') ?>"><span class="brac">(</span><?php echo t('manage address'); ?><span class="brac">)</span></a></h1>
    <!--<p class="instructions">These addresses can be used as delivery address during checkout.</p>-->
          <div class="boxList addressBookList">

<?php if (!empty($addresses['postalAddressList'][0])): ?>

               <input type="hidden" id="shipping_contact_mech_id0" name="shipping_contact_mech_id" value="10762">
               <div class="boxListItemGrid addressBookItem ">
                   <div class="displayBox">

	                       <div class="default-address">
	                         <?php echo t('Default Billing Address'); ?>
	                      </div>
                       
                		
                		<input type="hidden" value="" name="backButton">
                       <!-- Begin Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->
<!-- Begin Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->




	<div>
      <span>
      </span>
    </div>
    
 <div class="shippingaddress">
    <ul>
    	

		<div class="shipping-addrwrap">


            <li class=" shipname">
                <div>
                    <span style="font-size:1.2em;"><b><?php echo $addresses['postalAddressList'][0]['toName'] ?></b></span>
                </div>
            </li>
            <li class="address-nname ">
                <h4><?php echo $addresses['postalAddressList'][0]['attnName'] ?></h4>
            </li>
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $addresses['postalAddressList'][0]['address1'] ?> <?php echo $addresses['postalAddressList'][0]['address2'] ?></span>
                </div>
            </li>
        <li>
            <div>
                    <span style="font-size:1.1em; word-wrap: break-word;"><?php echo $addresses['postalAddressList'][0]['city'] ?>,</span>
           </div>
        </li>
        <li>
        	<div>
                    <span style="font-size:1.1em;">
                            <?php echo $addresses['postalAddressList'][0]['stateProvinceGeoId'] ?>
,
                            <?php echo $addresses['postalAddressList'][0]['postalCode'] ?>
                    </span>

                <!--
                    <span style="font-size:1.1em; word-wrap: break-word;">
                            560001
                    </span>
                -->
        	</div>
        </li>
        <!---->
        <li>
			<div class=""><span style="font-size:1.1em; word-wrap: break-word;">
			<?php echo t('Phone :'); ?> <?php echo $addresses['postalAddressList'][0]['contactNumber'] ?>
			</span></div>
		</li>
		
		</div>
		
		<li>

		   	<div class="hide">
		   		<span class="hide"><a href="/editAddress?contactMechId=10762&amp;partyId=10230"><?php echo t('Change Address'); ?></a></span>
		    </div>
		</li>
       
   </ul>
   </div>
  


<!-- End Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->
<!-- End Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->

                       
                   </div>
               </div>
<?php endif; ?>

<?php if (!empty($addresses['postalAddressList'][1])): ?>
               <input type="hidden" id="shipping_contact_mech_id1" name="shipping_contact_mech_id" value="10731">
               <div class="boxListItemGrid addressBookItem address-warp">
                   <div class="displayBox">
	                       <div class="default-address"><?php echo t('Default Shipping Address'); ?>                   
	                       </div>                       
                		
                		<input type="hidden" value="" name="backButton">
                       <!-- Begin Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->
<!-- Begin Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->




	<div>
      <span>
      </span>
    </div>
    
 <div class="shippingaddress">
    <ul>
    	

		<div class="shipping-addrwrap">


            <li class=" shipname">
                <div>
                    <span style="font-size:1.2em;"><b><?php echo $addresses['postalAddressList'][1]['toName'] ?></b></span>
                </div>
            </li>
            <li class="address-nname ">
                <h4><?php echo $addresses['postalAddressList'][1]['attnName'] ?></h4>
            </li>
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word; max-width:230px;"><?php echo $addresses['postalAddressList'][1]['address1'] ?> <?php echo $addresses['postalAddressList'][1]['address2'] ?></span>
                </div>
            </li>
        <li>
            <div>
                    <span style="font-size:1.1em; word-wrap: break-word;">Bangalore,</span>
           </div>
        </li>
        <li>
        	<div>
                    <span style="font-size:1.1em;">
                            <?php echo $addresses['postalAddressList'][1]['stateProvinceGeoId'] ?>
,
                            <?php echo $addresses['postalAddressList'][1]['postalCode'] ?>
                    </span>

                <!--
                    <span style="font-size:1.1em; word-wrap: break-word;">
                            560001
                    </span>
                -->
        	</div>
        </li>
        <!--
            <li>
                <div>
                    <span style="font-size:1.1em; word-wrap: break-word;">
                           IND
                    </span>
                </div>
            </li>
        -->
        <li>
			<div class=""><span style="font-size:1.1em; word-wrap: break-word;">
			<?php echo t('Phone :'); ?> <?php echo $addresses['postalAddressList'][1]['contactNumber'] ?>
			</span></div>
		</li>
		
		</div>
		
		<li>

		   	<div class="hide">
		   		<span class="hide"><a href="/editAddress?contactMechId=10731&amp;partyId=10230"><?php echo t('Change Address'); ?></a></span>
		    </div>
		</li>
       
   </ul>
   </div>
  


<!-- End Template component://osafe/webapp/osafe/common/displayPostalAddress.ftl -->
<!-- End Screen component://osafe/widget/CommonScreens.xml#displayPostalAddress -->

                       
                   </div>
               </div>

<?php endif; ?>

         </div>
</div>
</form>

<!-- End Template component://osafe/webapp/osafe/common/order/accountDashboard.ftl -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ADDRESS_BOOK_VIEW -->
<!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- Begin Section Widget  -->
<div id="pesAddressBook" class="pesSpot">
</div><!-- End Section Widget  -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
<!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#PES_ADDRESS_BOOK_VIEW -->
</div></div>
</div>
</div>