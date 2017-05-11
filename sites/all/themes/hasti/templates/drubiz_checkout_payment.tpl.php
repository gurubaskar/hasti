<?php //krumo($cart);?>
<div class="col-xs-12 col-sm-4 col-md-3 checkout-left">
<h2>Placing Order</h2>
<ul>
  <li><a href="#checkout-login">Sign In</a></li>
  <li><a href="#order-summary">Order Summary</a></li>
  <li><a href="#delivery-address">Delivery Address</a></li>
  <li><a href="#payment-method">Payment Method</a></li>
</ul>
</div>
<div class="col-xs-12 col-sm-8 col-md-9 checkout-right">
<div id="checkout-login" class="tab-content">
  <div class="col-xs-12 col-sm-12 col-md-8">
    <h3>Sign In</h3>
    <input type="text" placeholder="* User Name" id="">
    <input type="text" placeholder="* Password" id="">
    <span class="remember"><a href="#">Remember Me</a></span>
    <div class="checkoutbtn-wrap">
      <input type="button" value="Sign In" id="signin">
      <span class="forgot-pwd"><a href="#">Forgot Password?</a></span>
    </div>

    <h3 class="signup">Sign Up</h3>
    <input type="text" placeholder="* Email Id" id="">
    <input type="text" placeholder="* Password" id="">
    <input type="text" placeholder="* Confirm Password" id="">
    <div class="checkoutbtn-wrap">
      <input type="button" value="Sign Up" id="signin">
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4"></div>
</div>
<!--login end -->

<div id="order-summary" class="tab-content">
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
        <div class="cartrow"><label>Price:</label><span>₹. <?php echo format_money($cart_value['listPrice']);?></span></div>
        <?php if(!empty($node->field_size)){?><div class="cartrow"><label>Size:</label><span class="size"><?php echo $node->field_size[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
        <?php if(!empty($node->field_color)){?><div class="cartrow"><label>Color:</label><span class="color"><?php echo $node->field_color[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
        <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
      </div>
    </div>
    <?php }?>
    <div id="subtotal">
      <label>Amount Payable:</label>
      <span>&#8377; <?php echo format_money($cart['cartSubTotal']);?></span>
    </div>
    <div id="order-confirm">
      <label>Order Confirmation will be sent to:</label>
      <span>&#43; 911234567890</span>
    </div>
    <div class="btns-wrap">
      <span><a href="#" class="buy-now">Continue</a></span>
    </div>
  </div>
</div>
<!--order summary end -->

<div id="delivery-address" class="tab-content">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2>Delivery Address</h2>
    </div>
    <div class="cartbox">
      <div class="col-xs-8 col-sm-8 col-md-8 pleft">
        <h4>Name</h4>

        <div class="cartrow"><label>Mob No:</label><span>1234567899</span></div>
      </div>
      <div class="col-xs-4 col-sm-4 col-md-4"></div>
    </div>
    
    <div class="btns-wrap">
      <span><a href="#" class="buy-now">Continue</a></span>
    </div>
  </div>
</div>
<!--delivery address end -->

<div id="payment-method" class="tab-content">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="heading-bar">
      <h2>Payment Method</h2>
    </div>
    <div class="cartbox">
      <div class="col-xs-12 col-sm-12 col-md-12 pleft">
        <h4>Name</h4>
        
      </div>
    </div>
    
    <div class="btns-wrap">
      <span><a href="#" class="buy-now">Continue</a></span>
    </div>
  </div>
</div>
<!--payment method end -->
</div>