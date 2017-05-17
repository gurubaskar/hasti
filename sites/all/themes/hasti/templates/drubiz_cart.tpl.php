<?php //krumo($_SESSION['drubiz']['promoCodeFlag']) ;?>
<?php //krumo($cart['cartItemDetails']) ;?>
<?php //krumo($cart) ;?>
<?php $index = 0;?>
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
        ?>
        <div class="cartbox">
          <!--<h3>Order Id: <span>123456789</span></h3>-->
          <div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
            <a href="<?php echo url('/node/'.$node->nid);?>"><img src="<?php echo drubiz_image($product_or_product_variants_details->pdp_regular_image);?>" alt="<?php echo $node->title;?>" class="img-responsive"/></a>
          </div>
          <div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
            <div class="col-xs-6 col-sm-6 col-md-5 details-left">
              <h4><?php echo $cart_value['internalName']; ?></h4>
              <div class="cartrow"><label>Qty:</label>
                <span class="qty-minus" data-index="<?php echo $index;?>"></span>
                <span class="qty"><?php echo $cart_value['quantity']; ?></span>
                <span class="qty-plus" data-index="<?php echo $index;?>"></span>
              </div>
              <div class="cartrow"><label>Price:</label><span>&#8377. <?php echo format_money($cart_value['listPrice']);?></span></div>
              <?php if(!empty($node->field_size)){?><div class="cartrow"><label>Size:</label><span class="size"><?php echo $node->field_size[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
              <?php if(!empty($node->field_color)){?><div class="cartrow"><label>Color:</label><span class="color"><?php echo $node->field_color[LANGUAGE_NONE][0]['value'];?></span></div><?php } ?>
              <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-7 details-right">
              <div class="cartrow"><label>Delivery Details:</label><span>Free</span></div>
              <div class="cartrow"><label>Delivered By:</label><span>2-3 Working days</span></div>
              <div class="cartrow"><label>Exchange:</label><span>Within 30 days</span></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 edit">
              <div class="col-xs-6 col-sm-6 col-md-5 edit-wrap nopad">
                <a href="#" class="remove" data-delete-id="<?php echo $index;?>" >Remove</a>
                <?php $index++;?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-7 total">
                <div><label>Amount Payable:</label><span>&#8377. <?php echo format_money($cart_value['quantity'] * $cart_value['listPrice']);?></span></div>
              </div>
            </div>
          </div>
        </div>
        <?php }?>
        <div id="subtotal">
          <label>Sub Total:</label><span>&#8377. <?php echo format_money($cart['cartSubTotal']);?></span>
        </div>

        <div class="btns-wrap">
          <span><a href="<?php echo url('checkout-payment');?>" class="place-order">Place Order</a></span>
          <span><a href="<?php echo url();?>" class="continue">Continue Shopping</a></span>
          <div class="checkpin"><input type="text" placeholder="Enter Your Pin"><a href="#" class="check">Check</a></div>
        </div>

        <div class="bottomimg-wrap">
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/secure.png" /></a></span>
            <p>Secure <br/>Payments</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/return.png" /></a></span>
            <p>Free & Easy <br/> Return</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/products.png" /></a></span>
            <p>Original <br/>Products</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/protection.png" /></a></span>
            <p>100% Buyer <br/> Protection</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/transparent.png" /></a></span>
            <p>Transparent <br/> Pricing</p>
          </div>
          <div class="img-box col-xs-4 col-sm-4 col-md-2">
            <span><a href="#"><img src="<?php echo current_theme_path();?> /images/handmade.png" /></a></span>
            <p>Handmade <br/>Products</p>
          </div>
        </div>

      </div>