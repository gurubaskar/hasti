<?php //krumo($_SESSION['drubiz']['promoCodeFlag']) ;?>
<?php //krumo($cart['cartItemDetails']) ;?>
<?php //krumo($cart) ;?>
<?php
  $profile = get_user_profile();
  toCheckSession($profile);
?>
<?php $cartItems = $cart['cartItemDetails']; ?>

<?php if (empty($cart['cartItemDetails'])) { ?>

<h3>No Items!</h3>


<?php return; } ?>

<div class="col-xs-12 col-sm-12 col-md-12" id="cart">
        <div class="heading-bar">
          <h2 class="">Bag (<span><?php echo count($cart['cartItemDetails']);?></span>)</h2>
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
          $selected_features = get_selected_features($product_or_product_variants_details);
        ?>
        <div class="cartbox">
          <!--<h3>Order Id: <span>123456789</span></h3>-->
          <div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
            <a href="<?php echo url('/node/'.$node->nid);?>"><img src="<?php echo drubiz_image($product_or_product_variants_details->pdp_regular_image);?>" alt="<?php echo $node->title;?>" class="img-responsive"/></a>
          </div>
          <div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
            <div class="col-xs-6 col-sm-6 col-md-5 details-left">
              <h4><a href="<?php echo url('/node/'.$node->nid);?>"><?php echo $cart_value['internalName']; ?></a></h4>
              <div class="cartrow"><label>Qty:</label>
                <span class="qty-minus" data-index="<?php echo $cart_key;?>"></span>
                <span class="qty" id="qty-<?php echo $cart_key;?>"><?php echo $cart_value['quantity']; ?></span>
                <span class="qty-plus" data-index="<?php echo $cart_key;?>"></span>
              </div>
              <div class="cartrow"><label>Price:</label><span>&#8377. <?php echo format_money($cart_value['listPrice']);?></span></div>
              <?php if(!empty($selected_features['Size'])){?><div class="cartrow"><label>Size:</label><span class="size"><?php echo $selected_features['Size'];?></span></div><?php } ?>
              <?php if(!empty($selected_features['Colour'])){?><div class="cartrow"><label>Color:</label><span class="color"><?php echo $selected_features['Colour'];?></span></div><?php } ?>
              <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-7 details-right">
              <div class="cartrow"><label>Delivery Details:</label><span>Free</span></div>
              <div class="cartrow"><label>Delivered By:</label><span>2-3 Working days</span></div>
              <div class="cartrow"><label>Exchange:</label><span>Within 30 days</span></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 edit">
              <div class="col-xs-6 col-sm-6 col-md-5 edit-wrap nopad">
                <a href="#" class="remove" data-delete-id="<?php echo $cart_key;?>" >Remove</a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-7 total">
                <div><label>Amount Payable:</label><span>&#8377. <?php echo format_money($cart_value['quantity'] * $cart_value['listPrice']);?></span></div>
              </div>
            </div>
          </div>
        </div>
        <?php }?>
        
        <div id="subtotal">
          <div class="price1-wrap">
            <label>Sub Total:</label> <span id="subtotalamount">&#8377. <?php echo format_money($cart['cartSubTotal']);?></span>
          </div>
        </div>
        <div id="shipping">
          <div class="price1-wrap">
           <label>Shipping Charge:</label><span id="shippingcharge">&#8377. <?php echo format_money($cart['orderShippingTotal']);?></span>
          </div>
        </div>
        <div id="total">
          <div class="price1-wrap">
            <label>Grand Total:</label><span id="totalamount">&#8377. <?php echo format_money($cart['orderGrandTotal']);?></span>
          </div>
        </div>
        <div class="btns-wrap">
          <span><a href="<?php echo url('checkout-payment');?>" data-ajax="false" class="place-order">Place Order</a></span>
          <span><a href="<?php echo url();?>" class="continue">Continue Shopping</a></span>
          <div class="checkpin">
          <form method="post" action="<?php echo url('check-pin') ?>" id="pinchkForm" name="pinchkForm">
          <input type="text" id="pincode" placeholder="Enter Your Pin" data-msg-required="Zipcode is required." data-rule-required="true" maxlength="6" data-rule-minlength="6">
          <input type="submit" value="Check" class="basic-btn">
          
          <!--a href="#" class="check" onclick="checkPin();">Check</a-->
          </form>
          <div id="pincodeerror"></div>
          </div>
        </div>          
        <div class="bottomimg-wrap">
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/secure.png" /></span>
            <p>Secure <br/>Payments</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/return.png" /></span>
            <p>Free & Easy <br/> Return</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/products.png" /></span>
            <p>Original <br/>Products</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/protection.png" /></span>
            <p>100% Buyer <br/> Protection</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/transparent.png" /></span>
            <p>Transparent <br/> Pricing</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><img src="<?php echo current_theme_path();?>/images/handmade.png" /></span>
            <p>Handmade <br/>Products</p>
          </div>
        </div>

      </div>