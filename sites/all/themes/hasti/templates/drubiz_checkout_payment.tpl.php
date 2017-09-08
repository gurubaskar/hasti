<?php 
$from="";
if(!empty($_GET['from'])) {
  $from="1";
}
?>
<input type="hidden" id="from" value="<?php echo $from;?>" />
<div class="col-xs-12 col-sm-4 col-md-3 checkoutwrap-left">
  <div class="checkout-left">
    <h2>Placing Order</h2>
    <ul>
      <?php if($GLOBALS['user']->uid != 0) {?>
        <li><a href="#" onclick="openLogin();" class="active-img">Login Details</a></li>
        <li><a id="orderSummary" href="#" onclick="openOrderSummary();" class="tickimg">Order Summary</a></li>
        <li><a id="deliveryAddress" href="#" onclick="openDeliveryAddress();" class="tickimg">Delivery Address</a></li>
        <?php if(count($addresses['postalAddressList']) > 0) {?>
          <li><a id="paymentMethod" href="#" onclick="openPaymentMethod();" class="tickimg">Payment Method</a></li>
        <?php } else { ?>
          <li><a id="" href="#" class="disabled">Payment Method</a></li>
        <?php } ?>
      <?php } else { ?>
        <li><a class="active" href="#checkout-login">Sign In</a></li>
        <li><span>Order Summary</span></li>
        <li><span>Delivery Address</span></li>
        <li><span>Payment Method</span></li>
      <?php } ?>
    </ul>
  </div>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 checkout-right">
  <div id="checkout-login" class="">
    <div class="col-xs-12 col-sm-12 col-md-8">
      <?php if($GLOBALS['user']->uid){?>
        <span class="logged-user" id="logged-user"><?php echo t('Username') ?>:</span>
        <span class=""><?php echo $GLOBALS['user']->mail ?></span>
        <div class="checkoutbtn-wrap">
          <a href="<?php echo url('user/logout'); ?>"><input type="button" value="Logout" id="logout"></a>
        </div>
      <?php }else{ ?>
        <div id="signInPopupCheckout">
          <h3>Sign In</h3>
          <div id="signin_errormsgs" style=""></div>
          <form method="post" action="<?php echo url('drubiz/user') ?>" id="chksignInForm" name="chksignInForm">
            <input type="text" name="USERNAME" placeholder="<?php echo t('* User Name');?>" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" data-msg-required="The username is required." id="USERNAME" data-rule-required="true">
          <input type="password" name="PASSWORD" placeholder="<?php echo t('* Password');?>" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>"  data-msg-required="The Password is required." id="PASSWORD" data-rule-required="true">  
        <span class="remember"><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["username"])) { ?> checked <?php } ?> /><span> Remember Me</span></span>
            <!--input type="button" value="Sign In" id="signinorder" onclick="signInHasti();"-->
            <input type="submit" value="Sign In" id="signinorder">
            </form>          
          <div class="checkoutbtn-wrap">            
            <span class="forgot-pwd"><a href="#" onclick="opencheckoutForgotPassword()">Forgot Password?</a></span>
            <?php $_SESSION['page_url'] = $_SERVER['HTTP_REFERER'];?>
            <span class="facebook"><a href="<?php echo url('facebook-config.php')?>" class="ui-link">SIGN IN WITH FACEBOOK</a></span>
            <span class="google"><a href="<?php echo url('google-config.php')?>" class="ui-link">SIGN IN WITH GOOGLE</a></span>
          </div>          
        </div>
        <div id="forgotPopupCheckout">
          <h3>Forgot Password</h3>
          <div id="forgot_errormsgs" style=""></div>
          <form method="post" action="<?php echo url('forgotPassword') ?>" id="checkoutforgotpwdForm" name="checkoutforgotpwdForm">
          <p>Enter your Email Address here to receive a new password</p>
          <input type="text" id="emailid" placeholder="* Email Id" data-msg-required="The Email Id is required." data-rule-required="true" data-rule-email="true">
          <div class="forgot-btn">
            <!--input type="button" value="Continue" id="Continue" onclick="checkEmail();"-->
            <input type="submit" value="Continue" id="Continue">
            <input type="button" value="Back" id="back" onclick="closeForgotPasswordchkout();">
          </div>
          </form>
        </div>

        <h3 class="signup">Sign Up</h3>
        <div id="signup_errormsgs" style=""></div>
        <form method="post" action="<?php echo url('drubiz/user') ?>" id="checkoutsignUpForm" name="checkoutsignUpForm">
          <input type="text" name ="firstName" placeholder="<?php echo t('* First Name');?>" data-msg-required="The First Name is required." id="" data-rule-required="true">
          <input type="text" name="lastName" placeholder="<?php echo t('* Last Name');?>" data-msg-required="The Last Name is required." id="" data-rule-required="true">
          <input type="text" name="PHONE_MOBILE_CONTACT_OTHER" placeholder="<?php echo t('* Mobile');?>" data-msg-required="The Mobile number is required." id="" data-rule-required="true" data-rule-number="true" data-rule-minlength="10">
          <input type="text" name="userLoginId" placeholder="<?php echo t('* Email Id');?>" data-msg-required="The Email Id is required." id="" data-rule-required="true" data-rule-email="true">
          <input type="password" name="currentPassword" placeholder="<?php echo t('* Password');?>" data-msg-required="The Password is required." id="" data-rule-required="true">
          <input type="password" name="currentPasswordVerify" placeholder="<?php echo t('* Re-enter');?>" data-msg-required="The Confirm Password is required." id="" data-rule-required="true">
        <div class="checkoutbtn-wrap">
        <input type="submit" value="Sign Up" id="signin">
          <!--input type="button" value="Sign Up" id="signin" onclick="hastiSignIn();"-->
        </div>
        </form> 
        
      <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4"></div>
  </div>
  <!--login end -->

  <div id="order-summary" class="" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="heading-bar">
        <h2>Order Summary</h2>
      </div>
      <?php foreach ($cart['cartItemDetails'] as $cart_key => $cart_value) { ?>
      <?php 
        $node = node_load(get_nid_from_variant_product_id($cart_key));
        if(empty($node)){
          $node = node_load(get_nid_from_product_id($cart_key));
        }
        $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
        $product_or_product_variants_details = array();
        if($cart_key == $system_data->product_raw->product_id){
          $product_or_product_variants_details = $system_data->product_raw;
        }else{
          $product_or_product_variants_details = $system_data->product_variants->$cart_key;
        }
      ?>
      <div class="cartbox">
        <div class="col-xs-4 col-sm-4 col-md-4 img-wrap">
          <img src="<?php echo drubiz_image($product_or_product_variants_details->pdp_regular_image);?>" alt="<?php echo $node->title;?>" class="img-responsive"/>
        </div>
        <div class="col-xs-8 col-sm-8 col-md-8 cart-details pright">
          <h4><?php echo $cart_value['internalName']; ?></h4>
          <div class="cartrow"><label>Qty:</label><span class="qty"><?php echo $cart_value['quantity']; ?></span></div>
          <div class="cartrow"><label>Price:</label><span>&#8377;. <?php echo format_money($cart_value['listPrice']);?></span></div>
          <?php if(!empty($node->field_size)){?><div class="cartrow"><label>Size:</label><span class="size"><?php echo $node->field_size[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
          <?php if(!empty($node->field_color)){?><div class="cartrow"><label>Color:</label><span class="color"><?php echo $node->field_color[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
          <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
        </div>
      </div>
      <?php }?>
      <div id="subtotal">
        <div class="price1-wrap">
          <label>Amount Payable:</label>
          <span>&#8377; <?php echo format_money($cart['cartSubTotal']);?></span>
        </div>
      </div>
      <div id="shipping">
        <div class="price1-wrap">
          <label>Shipping Charge:</label>
          <span id="shippingPrice">&#8377; <?php echo format_money($cart['orderShippingTotal']);?></span>
        </div>
      </div>
      <div id="total">
        <div class="price1-wrap">
          <label>Grand Total:</label>
          <span id="shippingGrandTotal">&#8377; <?php echo format_money($cart['orderGrandTotal']);?></span>
        </div>
      </div>
      <div id="order-confirm">
        <label>Order Confirmation will be sent to:</label>
        <span>&#43;91 <?php echo $cart['DefaultPhoneNumber'][0]; ?></span>
      </div>
      <div class="btns-wrap">
        <span><a href="#" class="buy-now" onclick="openDeliveryAddress();">Continue</a></span>
      </div>
    </div>
  </div>
  <!--order summary end -->


  <div id="delivery-address" class="" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="heading-bar">
        <h2>Delivery Address</h2>
      </div>
      <?php foreach ($addresses['postalAddressList'] as $postal_key => $postal_value) { ?>
      <div class="addressbox" id="delete_<?php echo $postal_value['contactMechId'] ;?>">
        <div class="col-xs-8 col-sm-6 col-md-6 pleft address">
        <?php
          $checked = "";
          if($postal_value['isDefaultShipAddr'] == 1) {
            $checked = "checked";
          }
        ?>
          <input type="radio" class="address-select" name="deliveryaddress" data-contactMechId="<?php echo $postal_value['contactMechId'] ;?>" value="<?php echo $postal_value['contactMechId'] ;?>" <?php echo $checked;?>>
          <h4><?php echo $postal_value['toName']?></h4>
          <span><?php echo $postal_value['address1']?></span>
          <span><?php echo $postal_value['address2']?></span>
          <span><?php echo $postal_value['city']?></span>
          <span><?php echo $postal_value['stateProvinceGeoId']?></span>
          <span><?php echo $postal_value['postalCode']?></span>
          <div class="phno"><label>Mob No:</label><span><?php echo $postal_value['contactNumber']?></span></div>
        </div>
        <div class="col-xs-4 col-sm-6 col-md-6 edit-address pright">
          <a href="<?php echo url('account/edit-address/'.$postal_value['contactMechId']) ?>"><span class="edit"></span></a>
          <a href="#"><span class="delete address-delete" data-contactMechId="<?php echo $postal_value['contactMechId'] ;?>"></span></a>
        </div>
      </div>
      <?php } ?>
      <div class="btns-wrap">
        <?php if(count($addresses['postalAddressList']) < 4){ ?>
        <span class="new-address"><a href="<?php echo url('account/add-address') ?>?back=order" class="buy-now">Add New Address</a></span>
        <?php } if(count($addresses['postalAddressList']) > 0) {?>
          <span class="continue"><a href="#" class="buy-now" onclick="openPaymentMethod();">Continue</a></span>
        <?php } else { ?>
          <span class="continue"><a href="#" class="buy-now disabled">Continue</a></span>
        <?php } ?>
      </div>
    </div>
  </div>
  <!--delivery address end -->
  <div id="payment-method" class="" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="heading-bar">
        <h2>Payment Method</h2>
      </div>
      <div class="cartbox">
        <div class="col-xs-12 col-sm-12 col-md-12 pleft payment-method">
          <div id="walletOption">
          <div class="wallet-total"><p>Total amount to be paid</p> <span class="price">&#8377;. <?php $grandTotal = get_user_cart();
          echo $grandTotal['orderGrandTotal'];?></span></div>          
          <?php if($walletAmount > 0){?>
             <div class="wallet-amt">
             <input type="checkbox" name="walletamt" id="wallet" class="chkwallet">
             <input type="hidden" name="walletmoney" id="walletmoney" value="<?php echo $walletAmount;?>">
             <input type="hidden" name="totalamount" id="totalamount" value="<?php echo $grandTotal['orderGrandTotal'];?>">
             <p>Use wallet Amount </p><span class="price"> &#8377;.<?php echo $walletAmount;?></span></div>
               <div id="remainingamt"><p>Available balance is</p><span> &#8377;.<?php echo $walletAmount;?></span></div>
               <div id="balance" style="display: none">select an option to pay balance : </div>
           <?php } ?>
          </div>
          <div id="paymentOption">
          <span>
            <input type="radio" name="radiobtn" id="COD"><label>COD</label>
            <!-- <div class="btns-wrap">
              <a href="#" class="buy-now hastiCOD">Continue</a>
            </div> -->
            <div class="btns-wrap" id="sendOTP" style="display: none;">
              <a href="#" class="sendOTP">Send OTP</a>
            </div>
            <div class="displayOTP" id="displayOTP" style="display: none;">
              <input type="text" name="OTPValue" id="OTPValue" maxlength="6">
              <div class="btns-wrap">
              <?php $grandTotal = get_user_cart();?>
                <!--p>Amount payable at the time of delivery <b>&#8377;. <?php echo $grandTotal['orderGrandTotal'];?></b></p-->
                <p>In order to confirm your order,please click on "Send OTP" button and enter One Time Password here</p>
                <a href="#" class="validateOTP">Validate OTP</a>
              </div>
            </div>
          </span>
          <span>
            <input type="radio" name="radiobtn" id="Online"><label>Online Payment</label>
            <div class="btns-wrap" id="onlineProceed" style="display:none">
              <a href="#" class="buy-now ccavenue">Proceed to Payment</a>
            </div>
          </span>
          </div>
          <div class="btns-wrap placeOrderOTP" id="placeOrderOTP" style="display:none;">
            OTP verified successfully. Please click below "Place Order" button.<br /><br />
            <a href="#" class="placeOrderBtn">Place Order</a>
          </div>
           <div class="btns-wrap" id="placeOrderStoreCredit" style="display:none;">           
            <a href="#" class="placeOrderBtn">Place Order</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--payment method end -->
</div>