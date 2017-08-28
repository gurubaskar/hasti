<?php //krumo($order) ?>
<div id="content">
    <div class="container-fluid order-confirmation">
      <div class="col-xs-12 col-sm-12 col-md-12" id="cart">
          <div class="row">
            <div class="confirmation-wrap">
              <div class="heading-bar orderno">
                <h2 class="">Order Confirmation -  <span><?php echo t('Order No:'); ?> <?php echo $order['orderId'] ?></span></h2>
              </div>
              <div class="cartbox">
                <p>Thank you for shopping with us. We would like to let you know that Hasti has received your order and is preparing for its shipment. Your order delivery details are stated below.</p>
                <p>If you would like to view the status of your order or make any changes to it, please visit '<a href="#">Track order</a>'</p>
                <div class="col-xs-12 col-sm-6 col-md-6 pleft delivery-wrap">
                  <p>Your Estimated Delivery date is : <br/><span calss="delivery-details">Thursday, May 30 2017 - Friday May 31, 2017</span></p>
                  <p>Your Purchase invoice has been sent to your email id which is:<br/> <span calss="delivery-details"><?php echo $GLOBALS['user']->mail;?></span></p>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 pleft pright delivery-wrap">
                  <p>Your order was sent to:<br/> <span calss="delivery-details">
                  <?php echo $order['shippingAddress'][0]['toName'] ?>,<br />
                  <?php echo $order['shippingAddress'][0]['address1'] . ' ' . $order['shippingAddress'][0]['address2'] ?>,<br />
                  <?php echo $order['shippingAddress'][0]['city'] ?>.<br/>
                  <?php echo $order['shippingAddress'][0]['stateProvinceGeoId'] ?>.<br />
                  <?php echo t('Pin : '); ?><?php echo $order['shippingAddress'][0]['postalCode'] ?><br/><br/>
                  <?php echo t('Mob No :'); ?> <?php echo $order['shippingAddress'][0]['contactNumber'] ?>
                  </span></p>
                </div>
              </div>
            </div>
            <div class="details-wrap">
              <div class="heading-bar">
                <h2 class="">Order Details</h2>
              </div>
              <div class="cartbox">
                <h3><?php echo t('Order Id:'); ?> <span><?php echo $order['orderId'] ?></span></h3>
                <?php foreach ($order['OrderHeader'] as $cart_product): 
                  $nid = get_nid_from_variant_product_id($cart_product['productId']);
                  $node = node_load($nid);
                  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
                  $product_variant = $system_data->product_variants->{$cart_product['productId']};
                ?>
                <div class="product-wrap">
                  <div class="col-xs-12 col-sm-3 col-md-2 img-wrap">
                    <img alt="Globus Womens Blue Jackets -500194" src="<?php echo drubiz_image($product_variant->plp_image) ?>" class="productCartListImage img-responsive" height="140" width="105" onerror="onImgError(this, 'PLP-Thumb');">
                  </div>
                  <div class="col-xs-12 col-sm-9 col-md-10 cart-details pright">
                    <div class="col-xs-6 col-sm-6 col-md-5 details-left">
                      <h4><?php echo $cart_product['productName'][0]; ?></h4>
                      <div class="cartrow">
                        <label>Qty:</label>
                        <span class="qty"><?php echo (int)$cart_product['quantity'] ?></span>
                      </div>
                      <div class="cartrow">
                        <label>Price:</label>
                        <span>&#8377;. <?php echo format_money($cart_product['unitPrice']) ?></span>
                      </div>
                      <?php $selected_features = get_selected_features($product_variant); ?>
                      <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
                        <?php if (strtolower($selected_feature_name) == 'size'): ?>
                            <div class="cartrow"><label><?php echo t('Size:'); ?></label><span class="size"><?php echo $selected_feature_value ?></span></div>
                         <?php elseif (strtolower($selected_feature_name) == 'color'): ?>
                            <div class="cartrow"><label><?php echo t('Color:'); ?></label><span class="color"><?php echo $selected_feature_value ?></span></div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      <div class="cartrow"><label>Seller:</label><span>Mother Earth</span></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 edit">
                      <div class="col-xs-6 col-sm-6 col-md-7 total">
                        <?php
                          $unitPrice = $cart_product['unitPrice'] * (int)$cart_product['quantity'];
                        ?>
                        <div><label>Amount Payable:</label><span>&#8377. <?php echo format_money($unitPrice) ?></span></div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
          <div id="subtotal">
            <div class="price1-wrap">
              <label>SubTotal:</label>
              <span>&#8377; <?php echo format_money($order['paymentSubTotal']);?></span>
            </div>
          </div>
          <div id="shipping">
            <div class="price1-wrap">
              <label>Shipping Charge:</label>
              <span>&#8377; <?php echo format_money($order['orderShippingTotal']);?></span>
            </div>
          </div>          
            <div class="alltotal">
              <div class="price1-wrap">
                <label>Total:</label><span>&#8377. <?php echo format_money($cart_product['orderGrandTotal']) ?></span>
              </div>
            </div>
            <div class="icon-wrap">
              <div class="icon-container">
                <ul>
                  <li>
                    <a href="<?php echo url('print_invoice.php')?>?orderid=<?php echo $order['orderId'] ?>&partyid=<?php echo $partyId ?>" target="_blank"><img src="<?php echo current_theme_path();?>/images/print.png" id="print"></a>
                    <?php $partyId=get_user_party_id();?>
                    <a href="<?php echo url('print_invoice.php')?>?orderid=<?php echo $order['orderId'] ?>&partyid=<?php echo $partyId ?>" target="_blank">Print</a>
                  </li>
                  <li>
                    <a href="<?php echo url('contact-us');?>"><img src="<?php echo current_theme_path();?>/images/contact.png" id="contact"></a>
                    <a href="<?php echo url('contact-us');?>">Contact us</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
