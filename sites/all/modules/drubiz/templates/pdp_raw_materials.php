<?php //krumo($_SESSION['drubiz']['promoCodeFlag']) ;?>
<?php //krumo($cart) ;?>
<?php //krumo($viewPromo) ;?>
<?php $cartItems = $cart['productList']; ?>

<?php if (empty($cart['productList'])) { ?>

<h3>No Items!</h3>


<?php return; } ?>

<div id="eCommerceShowcart" class="eCommerceShowcart">
<form method="post" class="cartForm" action="/checkout" id="cartform" name="cartform" onsubmit="return updateCart()">

<div id="ptsShoppingCart" class="ptsSpot">
</div>

          <div class="ShowCart group group1">

<div class="shoppingbag-wrapper">
<div class="showcartgroup">
     <input type="hidden" name="removeSelected" value="false">

   <div class="eCommerceEditCustomerInfo-headerr"> </div>

   <div class="container orderItems showCartOrderItems">

     <div class="boxList cartList">
     
     <table class="cartPageTable">
	       <thead>
				<tr class="first last">
	                    <th><?php echo t('item');?></th>
	                    <th><?php echo t('Description');?></th>
	                    <th><?php echo t('Color');?></th>
	                    <th><?php echo t('Size');?></th>
	                    <th><?php echo t('Quantity');?></th>
	                    <th><?php echo t('Price');?></th>
	            </tr>
	       </thead>
	    </table>
     <div class="cartitems-wrapper">

<?php foreach ($cart['productList'] as $cart_product): ?>
    <?php
      $nid = get_nid_from_variant_product_id($cart_product['productID']);
      $node = node_load($nid);
      $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
      $product_variant = $system_data->product_variants->{$cart_product['productID']};
    ?>

     <div class="boxListItemTabular cartItem ShowCartOrderItems" data-product-id="<?php echo $cart_product['productID'] ?>">
          <div class="ShowCartOrderItems group group1">
         <ul class="displayList cartItemList ShowCartOrderItems">

<li class="image itemImage showCartOrderItemsItemImage firstRow cartimage-desk">
	<div>
	    <a href="<?php echo url('node/' . $nid) ?>">
	      <img alt="<?php echo $cart_product['productName'] ?>" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($product_variant->plp_image_alt) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='<?php echo drubiz_image($product_variant->plp_image) ?>'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
	    </a>
  	</div>

</li>
</ul>
<br />
<ul>
<li class="action itemRemoveButton showCartOrderItemsItemRemoveButton firstRow">
  <div>
      <a class="delete cart-product-delete" title="Remove Item"><?php echo t('Remove');?> |
      </a>
   </div>
</li>

<li class="action itemUpdateButton showCartOrderItemsItemUpdateButton firstRow">
      <a class="update" title="Update"> <div class="cart-product-edit"><?php echo t('edit');?></div> <div class="cart-product-update" style="display: none;"> <?php echo t('Update');?></div></a>

</li>

<!-- <li class="action itemGiftMessageLink showCartOrderItemsItemGiftMessageLink firstRow">
                            <div>
                              <a href="<?php echo url('gift-message'); ?>">
                                <div class="fa fa-gift" id="cartpageGifticon"></div>
                                <span>Add Gift to products</span>
                              </a>
                            </div>
                          </li> -->

         </ul>
          </div>
          <div class="ShowCartOrderItems group group2">
         <ul class="displayList cartItemList ShowCartOrderItems">

<li class="string itemName showCartOrderItemsItemName firstRow">
  <div>
	<a href="<?php echo url('node/' . $nid) ?>" id="image_500194">
	  <h3>
       <?php echo $cart_product['productName'] ?>
	  </h3> 	  
	</a>
  </div>
</li>

<li class="string itemDescription showCartOrderItemsItemDescription firstRow prdetails">
  <div>
    <span>
      <ul class="displayList productFeature">
		
		 <div>
		  <?php $selected_features = get_selected_features($product_variant); ?>
			     <li class="">
		    	<div class="color-swatch">
		    		<div class="color-code" style="background-color:<?php echo @$selected_features['Color'] ?>;border:1px solid black;padding:1px;"></div>
		    	</div>				    	
	          </li>

		        <li class="size">
					<div class="size-swatch">
						<div class="size-code"><?php echo @$selected_features['Size'] ?></div>
			    	</div>	
		        </li>
         </div>
      
      </ul>
    </span>


  </div>
</li>

<li class="entry itemQty showCartOrderItemsItemQty firstRow">
  <div class="quantity"> 

    <div style=" float: left;" class="qty-number" id="qtyInCart_2472544">
    <?php echo (int)$cart_product['quantity'] ?>
    </div>

    <div class="item-qt" style="display:none;">
            <select style="width: 42px;">        	
        		<option value="1" selected="">1</option>
        		<option value="2">2</option>
        		<option value="3">3</option>
        		<option value="4">4</option>
        		<option value="5">5</option>
        		<option value="6">6</option>
        		<option value="7">7</option>
        		<option value="8">8</option>
        		<option value="9">9</option>
        		<option value="10">10</option>
        </select>
    <div>    
  </div>
</div></div></li>

         </ul>
          </div>
          <div class="ShowCartOrderItems group group3">
         <ul class="displayList cartItemList ShowCartOrderItems">

<li class="currency itemOfferPrice showCartOrderItemsItemOfferPrice firstRow">
  <div>
  </div>
</li>

<li class="currency itemPrice showCartOrderItemsItemPrice firstRow">
  <div>
              <?php if (FALSE AND $cart_product['productPrice'] != $cart_product['offerPrice']): ?>
                <p class="oldprice left">
              <span id="cart_strikedcost" class="left price">$ <?php echo format_money($cart_product['productPrice']) ?></span>
              </p>
              <?php endif; ?>

   	<p class="oldprice left">
   	<span id="cart_actualcost" class="left" ;=""> $ <?php echo format_money($cart_product['productPrice']) ?></span>
   	</p>
    
  </div>

</li>

<!--<?php if(!empty($cart_product['promoName'])) { ?>
<li class="currency totalSubAmount showCartOrderItemsSummaryTotalSubAmount oc-summry">
  <div class="sub-total">
    <label>Promo Applied: </label>
        <span><?php echo $cart_product['promoName'] ?></span>
  </div>
</li>
<?php } ?>  -->

         </ul>
          </div>
          <div class="ShowCartOrderItems group group4">
         <ul class="displayList cartItemList ShowCartOrderItems">

         </ul>
          </div>
     </div>
<?php endforeach; ?>

   </div>
	 </div>
	<div class="cart-promo-pincode" id="cartPromoPincode">
		<!-- <a class="cartPromoPincode" onclick="return cartPromoPincodeEnter();">Click to Enter Pincode for getting more benefits</a> -->
		<div id="" class="cartPromoPincodeDiv" style="display:none;">
	    	<input type="text" id="cartPincode" name="cartPincode" value="" maxlength="6">
        	<a class="standardBtn action" id="cartPincodeSubmit" onclick="javascript:cartPincodeSubmit(document.cartform, 'UC', '2472544');"><span><?php echo t('Apply');?></span></a>
			<div class="cartPincodeMessageId" style="color:red;"></div>
		</div>
	</div>
</div>
<div>
<li>
 </li>
 </div>
  </div>
<div id="giftwrapAllForCommon" title=" " style="display:none;">
		       <div class="gftwrap-title"><?php echo t('Gift Message');?></div>
 <div class="gift-wrapper">  
 <div class="entry fromName wrap-lbl">
		            <label><?php echo t('From:');?></label>
		            <input type="text" class="characterLimit" maxlength="50" onblur="restrictTextLength(this);" name="from_All" id="from_All" value="">
		          </div>
		          <div class="entry toName wrap-lbl">
		            <label><?php echo t('To:');?></label>
		            <input type="text" class="characterLimit" maxlength="50" onblur="restrictTextLength(this);" name="to_All" id="to_All" value="">
		          </div> 
		          <div class="entry giftMessage wrap-lbl">
		            <label><?php echo t('Message, your choice (Max 500 Characters):');?></label>
		            <div class="entryField wrap-msg">
			            <textarea name="giftMessageText" class="content characterLimit" id="js_content_all" cols="35" rows="5" maxlength="500"></textarea>
			            <span class="js_textCounter textCounter"><?php echo t('500 characters left');?></span>
			        </div>
		          </div>
		          </div>
 <div class="action itemGiftMessageLink showCartOrderItemsItemGiftMessageLink ">
  <a href="javascript:onclick=giftWrapSaveAll('1');" class="standardBtn positive"><span><?php echo t('Save');?></span></a>
 </div>

 
 </div>

 </div>
 <div class="continuebutton">
  <div class="action itemGiftMessageLink showCartOrderItemsItemGiftMessageLink">
    <a href="<?php echo url() ?>" class="standardBtn negative"><span><?php echo t('Continue Shopping');?></span></a>
  </div>

</div>

          </div>
          <div class="ShowCart group group2">
<!--<div class="displayBox"><h1><?php echo t('Shopping bag summary');?></h1></div>

<div class="container promoCode showCartPromoCode">
 <div class="displayBox" >
    <h3 style="clear:both;"><?php echo t('Promotional Code');?></h3>
    <ul class="displayActionList container promoCode showCartPromoCode">
      <li>
       <div>
        <label class="promoenterlabel"><?php echo t('If you have a promotional code, please enter it here:');?></label><br>

        <input type="text" id="js_manualOfferCode" name="manualOfferCode" value="" maxlength="20" onkeypress="javascript:setCheckoutFormAction(document.cartform, 'APC', '');">

        <a class="standardBtn action" onclick=" return addManualPromoCode();"><span><?php echo t('Apply');?></span></a>-->
<div class="displayBox"><h1><?php echo t('Shopping bag summary');?></h1></div>
<?php if (!empty($GLOBALS['user']->uid)): ?>
 <div class="container loyaltyPoints showCartLoyaltyPoints">
  <div class="displayBox loyaltySection">
    <h3><?php echo t('Loyalty Points Redemption');?></h3>
    <ul class="displayActionList container loyaltyPoints showCartLoyaltyPoints">
      <li>
       <div class="loyaltypoints-redemption">
         <?php if(isset($cart['LoyaltyAmount'])) { ?>
           <input type="text" id="js_loyaltyPointsId" name="loyaltyPointsId" placeholder="" value="<?php echo $partyId; ?>" maxlength="10" disabled="disabled" onkeypress="">
           <a class="standardBtn action" id="js_applyLoyaltyCard"><span><?php echo t('Apply');?></span></a>
             <label><?php echo t('Loyalty Amount:');?></label>
             <span id="loyaltyValue">-$ <?php echo format_money($cart['LoyaltyAmount'])?></span>
             <a class="standardBtn action" id="js_removeLoyalty"><span><?php echo t('Remove');?></span></a>
         <?php } else { ?> 
           <input type="text" id="js_loyaltyPointsId" name="loyaltyPointsId" placeholder="" value="<?php echo $partyId; ?>" maxlength="10" disabled="disabled" onkeypress="">
           <a class="standardBtn action" id="js_applyLoyaltyCard"><span><?php echo t('Apply');?></span></a>
           <span id="loyaltyInfo"></span>
           <a class="standardBtn action" id="js_removeLoyalty" style="display:none"><span><?php echo t('Remove');?></span></a>
           <div id="redmpts" style="display:none">
             <span><?php echo t('Points Redeemed');?></span>
             <input type="text" id="js_redeemLoyaltyPoints" name="redeemLoyaltyPoints" placeholder="" value="" maxlength="10">
             <a class="standardBtn action" id="js_redeemLoyalty"><span><?php echo t('Redeem');?></span></a>
             <input type="hidden" id="hidloyalpts" value=""/>
           </div>
           <span id="loyaltyErrorInfo"></span>
         <?php } ?>
       </div>
      </li>
    </ul>
  </div>
 </div>
<div class="container promoCode showCartPromoCode">
 <div class="displayBox">
    <h3 style="clear:both;"><?php echo t('Promotional Code');?></h3>
    <ul class="displayActionList container promoCode showCartPromoCode">
      <li>
       <div id="promobox">
        <label class="promoenterlabel"><?php echo t('If you have a promotional code, please enter it here:');?></label>
        <br>

        <input type="text" id="js_manualOfferCode" name="manualOfferCode" value="" maxlength="20">

        <a class="standardBtn action" id="promoapply"><span><?php echo t('Apply');?></span></a>
        <span><?php echo t('click');?><a onclick="popcall();" href="#myModal" class="promoview" id="promoview" style="color:#0000FF"> 
         Here  </a> <?php echo t('to view all coupons');?></span>
         </br>
         <span id="coupon_codes"></span>
         <?php if(!empty($cart['couponCode'])){?>
        <span id="coupon_apply"><div></br>The Promotion  <?php echo $cart['couponCode']; ?> has been applied on your bag account </div></span>
        <?php } else { ?>
        <span id="coupon_apply"></span>
        <?php } ?>        
       </div>
      </li>
      <ul class="fieldErrorMessage" id="promotionError" style="display:none"><li><?php echo t('Please enter your Offer Code.');?></li></ul>
    </ul>
   <div class="boxList promoCodeList"></div>
 </div>
 </div> 
<?php endif; ?> 

<div class="container orderItemsSummary showCartOrderItemsSummary">

          <div class="ShowCartOrderItemsSummary group group1">
         <ul class="displayList summary ShowCartOrderItemsSummary">
<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems">
  <div>
    <label><?php echo t('Total Items:');?></label>
    <span class="miniTotal"><?php echo $cart['shoppingCartSize'] ?></span>
  </div>
  </li>
<!-- <li class="currency totalSubAmount showCartOrderItemsSummaryTotalSubAmount oc-summry">
  <div class="sub-total">
    <label>Grand Total:</label>
        <span>$ <?php echo format_money($cart['orderGrandTotal']) ?></span>
  </div>
</li> -->

<?php $promoTotalAmount = getTotalPromoAmount($cartItems) ;?>
<li class="currency totalSubAmount showCartOrderItemsSummaryTotalSubAmount oc-summry">
  <div class="sub-total">
    <label><?php echo t('Sub Total:');?></label>
      	<span>$ <?php echo format_money($cart['shoppingCartItemTotal']) ?></span>
  </div>
</li>

<?php if(!empty($promoTotalAmount)) { ?>
<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems">
  <div>
    <label><?php echo t('Promo Amount:');?></label>
    <span class="promoTotal">-$<?php echo format_money($promoTotalAmount); ?></span>
  </div>
  </li>
<?php } ?>

<?php if(!empty($cart['couponCode'])) { ?>
<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems coupon">
  <div>
    <label><?php echo t('Coupon Amount:');?></label>
    <span class="promoTotal">$<?php echo format_money($cart['couponValue']); ?></span>
  </div>
  </li>
<?php } ?>

<?php if(isset($cart['LoyaltyAmount'])) { ?>
<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems loyaltyPoint">
  <div>
    <label><?php echo t('Loyalty Amount:');?></label>
    <span id="loyaltyValue">-$ <?php echo format_money($cart['LoyaltyAmount'])?></span>
  </div>
  </li>
<?php } ?>


<!-- <?php if(!empty($cart['partyAppliedStoreCreditTotal'])) { ?>
<li class="number totalNumberItems showCartOrderItemsSummaryTotalNumberItems storeCredit">
  <div>
    <label><?php echo t('Store Credit:');?></label>
    <span>-$ <?php echo format_money($cart['partyAppliedStoreCreditTotal'])?></span>
  </div>
  </li>
<?php } ?> -->


<!--<?php if(!empty($promoTotalAmount)) { ?>
<li class="currency totalSubAmount showCartOrderItemsSummaryTotalSubAmount oc-summry">
  <div class="sub-total">
    <label><?php echo t('Promo Discount:');?> </label>
        <span>- $ <?php echo format_money($promoTotalAmount) ?></span>
    <label>Promo Discount: </label>
        <span> $ <?php echo format_money($promoTotalAmount) ?></span>
  </div>
</li>
<?php } ?> -->

  <?php if (!empty($cart['salesTax'])): ?>
    <li class="currency taxAmount showCartOrderItemsSummaryTaxAmount">
      <div class="sale-tax">
          <label><?php echo t('Tax Collected:');?></label>
        <span>$ <?php echo format_money($cart['salesTax']) ?>
      </span></div>
    </li>
  <?php endif; ?>

  <li class="currency shippingAmount showCartOrderItemsSummaryShippingAmount">
    <div>
      <label><?php echo t('Shipping Charges:');?> </label>	
      	<span>$ <?php echo format_money($cart['orderShippingTotal']) ?></span>
    </div>
  </li>

<li class="currency totalAmount showCartOrderItemsSummaryTotalAmount">
  <div>
    <label><?php echo t('Total:');?></label>
    <span>$ <?php echo format_money($cart['orderGrandTotal']) ?></span>
  </div>
</li>
         </ul>
          </div>

</div>  
	 <div class="action continueButton showCartContinueButton">
		  	  <!-- <input type="submit" id="js_submitCartBtn" name="submitCartBtn" value="proceed to secure checkout" onclick="return setCheckoutFormAction(document.cartform, 'DN', '');" class="standardBtn positive"> -->
		  	  <input type="submit" id="js_submitCartBtn" name="submitCartBtn" value="<?php echo t('proceed to secure checkout');?>" class="standardBtn positive">
	 </div>

<input type="hidden" name="fbDoneAction" value="checkout">

          </div>
<div id="pesShoppingCart" class="pesSpot">
</div>
</div></form>
</div>

<div class="modal" id="myModal" style="display:none;">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" onclick="popupclose();" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Coupon Codes</h4>
        </div>
        <?php if (!empty($viewPromo['coupons'])) { ?>
        <?php foreach ($viewPromo['coupons'] as $coupon): ?>
        <div class="modal-body">
        <div class="cp-code">
          <p class="cp-cd"><?php echo $coupon['couponCode']; ?></p>
          <p><?php echo $coupon['description']; ?></p>
          <p>$ <?php echo format_money($coupon['amount']) ?></p>
          <a onclick="popupclose();" class="standardBtn action" class="apply_cpnkjno" id="apply_cpn" data-coupon-value="<?php echo $coupon['couponCode'] ?>"><span class="apply_cpn" data-coupon-value="<?php echo $coupon['couponCode'] ?>"><?php echo t('Apply');?></span></a>
          </div>
        </div>
        <?php endforeach; ?>
        <?php } else { ?>
        No Coupons are available
        <?php } ?>
      </div>
      
    </div>
  </div> 
