<?php //krumo($_SESSION['drubiz']['promoCodeFlag']) ;?>
<?php //krumo($cart) ;?>
<?php //krumo($viewPromo) ;?>
<?php $cartItems = $cart['productList']; ?>

<?php if (empty($cart['productList'])) { ?>

<h3>No Items!</h3>


<?php return; } ?>

<div class="col-xs-12 col-sm-12 col-md-12" id="cart">
        <div class="heading-bar">
          <h2 class="">Bag (<span>2</span>)</h2>
        </div>
        <div class="cartbox">
          <h3>Order Id: <span>123456789</span></h3>
          <div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
            <img src="images/cart1.jpg" alt="" class="img-responsive"/>
          </div>
          <div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
            <div class="col-xs-6 col-sm-6 col-md-5 details-left">
              <h4>Name of the Product</h4>
              <div class="cartrow"><label>Qty:</label><span class="qty">1</span></div>
              <div class="cartrow"><label>Price:</label><span>&#8377. 320</span></div>
              <div class="cartrow"><label>Size:</label><span class="size">XXL</span></div>
              <div class="cartrow"><label>Color:</label><span class="color">Blue</span></div>
              <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-7 details-right">
              <div class="cartrow"><label>Delivery Details:</label><span>Free</span></div>
              <div class="cartrow"><label>Delivered By:</label><span>2-3 Working days</span></div>
              <div class="cartrow"><label>Exchange:</label><span>Within 30 days</span></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 edit">
              <div class="col-xs-6 col-sm-6 col-md-5 edit-wrap nopad">
                <a href="#" class="update">Update</a>
                <a href="#" class="remove">Remove</a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-7 total">
                <div><label>Amount Payable:</label><span>&#8377. 11350</span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="cartbox">
          <h3>Order Id: <span>123456789</span></h3>
          <div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
            <img src="images/cart1.jpg" alt="" class="img-responsive"/>
          </div>
          <div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
            <div class="col-xs-6 col-sm-6 col-md-5 details-left">
              <h4>Name of the Product</h4>
              <div class="cartrow"><label>Qty:</label><span class="qty">1</span></div>
              <div class="cartrow"><label>Price:</label><span>&#8377. 320</span></div>
              <div class="cartrow"><label>Size:</label><span class="size">XXL</span></div>
              <div class="cartrow"><label>Size:</label><span class="size">XXL</span></div>
              <div class="cartrow"><label>Color:</label><span class="color">Blue</span></div>
              <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-7 details-right">
              <div class="cartrow"><label>Delivery Details:</label><span>Free</span></div>
              <div class="cartrow"><label>Delivered By:</label><span>2-3 Working days</span></div>
              <div class="cartrow"><label>Exchange:</label><span>Within 30 days</span></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 edit">
              <div class="col-xs-6 col-sm-6 col-md-5 edit-wrap nopad">
                <a href="#" class="update">Update</a>
                <a href="#" class="remove">Remove</a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-7 total">
                <div><label>Amount Payable:</label><span>&#8377. 11350</span></div>
              </div>
            </div>
          </div>
        </div>

        <div id="subtotal">
          <label>Sub Total:</label><span>&#8377. 11350</span>
        </div>

        <div class="btns-wrap">
          <span><a href="#" class="place-order">Place Order</a></span>
          <span><a href="#" class="continue">Continue Shopping</a></span>
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