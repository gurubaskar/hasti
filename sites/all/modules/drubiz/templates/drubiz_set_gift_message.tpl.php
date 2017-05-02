<?php 
$cart = get_user_cart();
//krumo($cart) ?>
<!--<?php //if (empty($cart['productList'])) { ?>
<h3>No Items!</h3>
<?php //return; } ?>-->


<div id="scrollerPageTop"></div>
<div id="eCommerceOuterBasicBevelWrap">
  <!-- Begin Screen component://osafe/widget/DialogScreens.xml#searchDialog -->
  <div id="commonSearchDialog">
    <!-- Begin Template component://osafe/webapp/osafe/templates/commonDialog.ftl -->
    <div id="search_dialog" class="dialogOverlay"></div>
    <div id="search_displayDialog" style="display:none" class="">
      <input type="hidden" name="search_dialogBoxTitle" id="search_dialogBoxTitle" value="">
      <!-- Begin Template component://osafe/webapp/osafe/templates/searchDialog.ftl -->
      <div class="displayBox confirmDialog">
        <h3>Please Confirm</h3>
        <div class="confirmTxt">Please enter a search phrase in the text box and click on the Search icon.</div>
        <div class="container button">
          <input type="button" class="button red auto" name="noBtn" value="Ok" onclick="javascript:confirmDialogResult('N','search_');">
        </div>
      </div>
      <!-- End Template component://osafe/webapp/osafe/templates/searchDialog.ftl -->
    </div>
    <!-- End Template component://osafe/webapp/osafe/templates/commonDialog.ftl -->
  </div>
  <!-- End Screen component://osafe/widget/DialogScreens.xml#searchDialog -->
  <!-- Begin Screen component://osafe/widget/DialogScreens.xml#pincodeCheckDialog -->
  <!-- Begin Template component://osafe/webapp/osafe/templates/commonDialog.ftl -->
  <div id="pincodeChecker_dialog" class="dialogOverlay"></div>
  <div id="pincodeChecker_displayDialog" style="display:none" class="">
    <input type="hidden" name="pincodeChecker_dialogBoxTitle" id="pincodeChecker_dialogBoxTitle" value="DELIVERY & CoD AVAILABILITY">
    <div id="js_pincodeCheckContainer">
      <!-- Begin Template component://osafe/webapp/osafe/common/pincodeChecker/pincodeSearch.ftl -->
      <div id="pincodeChecker" class="pincodeChecker">
        <form method="post" class="pincodeChecker_Form" action="http://103.230.37.173/pincodeSearch" name="pincodeSearchForm">
          <p class="instructions">
            Please enter your PIN Code to check cash on delivery availability in your area
          </p>
          <div class="entry">
            <label>Pin Code</label>
            <input type="text" maxlength="255" name="pincode" id="pincode" value="" style="display:block!important">
          </div>
          <div class="action previousButton">
            <a href="javascript:void(0);" class="standardBtn js_cancelPinCodeChecker">Close</a>
          </div>
          <div class="action continueButton">
            <input type="submit" value="CHECK PIN CODE" class="standardBtn action">
          </div>
        </form>
      </div>
      <!-- End Template component://osafe/webapp/osafe/common/pincodeChecker/pincodeSearch.ftl -->
      <!-- Begin Template component://osafe/webapp/osafe/common/pincodeChecker/pincodeSearchResult.ftl -->
      <!-- End Template component://osafe/webapp/osafe/common/pincodeChecker/pincodeSearchResult.ftl -->
    </div>
  </div>
  <!-- End Template component://osafe/webapp/osafe/templates/commonDialog.ftl -->
  <!-- End Screen component://osafe/widget/DialogScreens.xml#pincodeCheckDialog -->
  <div id="eCommerceInnerBasicBevelWrapper">
    <div id="eCommerceContent" class="mainPanel">
      <!-- Begin Screen component://osafe/widget/EcommerceScreens.xml#eCommerceHeader -->
      <div id="eCommerceHeader">
        <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceHeader.ftl -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#siteHeaderDivSequence -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
        <!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#siteHeaderLinks -->
        <!-- Begin Template component://osafe/webapp/osafe/common/siteHeader/siteHeaderLinks.ftl -->
        <!-- End Template component://osafe/webapp/osafe/common/siteHeader/siteHeaderLinks.ftl -->
        <!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#siteHeaderLinks -->
        <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#siteHeaderMailingList -->
        <!-- Begin Template component://osafe/webapp/osafe/common/siteHeader/siteMailingList.ftl -->
        <div class="content mailingList siteHeaderMailingList">
          <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#SI_MAILING_LIST -->
          <!-- Begin Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
          <!-- Begin Section Widget  -->
          <div id="siteMailingList"></div>
          <!-- End Section Widget  -->
          <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#eCommerceRenderContent -->
          <!-- End Screen component://osafe/widget/EcommerceContentScreens.xml#SI_MAILING_LIST -->
        </div>
      </div>
      <!-- End Screen component://osafe/widget/EcommerceScreens.xml#eCommerceHeader -->
      <div id="eCommercePageBody">
        <!-- Begin Screen component://osafe/widget/CommonScreens.xml#PageScroller -->
        <!-- Begin Template component://osafe/webapp/osafe/common/eCommercePageScroller.ftl -->
        <div id="scrollToTop" class="js_scrollToTop" style="display: block;">
          <a href="http://103.230.37.173/eCommerceGiftMessage;jsessionid=0ACF1AC449C9F0698B81909192251C5B.jvm1?cartLineIndex=0#scrollerPageTop" id="pageScrollId">
          <i class="fa fa-caret-square-o-up fa-3x" aria-hidden="true"></i>
          </a>
        </div>
        <div id="eCommerceMainPanel" class="mainPanel">
          <h1>Add Gift Message</h1>
          <div class="content logo siteHeaderLogo" id="eCommerceNavBar">
            <div id="eCommerceNavBarWidget">
              <a href="javascript:void(0);" class="showNavWidget"><span> </span></a>
              <a href="javascript:void(0);" class="hideNavWidget" style="display:none"><span> </span></a>
            </div>
            <a href="http://103.230.37.173/eCommerceGiftMessage;jsessionid=0ACF1AC449C9F0698B81909192251C5B.jvm1?cartLineIndex=0#" class="menu-mobile"></a>
            <ul id="eCommerceNavBarMenu">
            </ul>
          </div>
          <div id="eCommerceShowcart" class="eCommerceShowcart">
            <form method="post" class="entryForm" action="http://103.230.37.173/" id="giftMessageForm" name="giftMessageForm">
              <input type="hidden" id="checkoutpage" name="checkoutpage" value="">
              <input type="hidden" name="partyId" value="">
              <input type="hidden" name="productStoreId" value="THS_STORE">
              <div id="ajaxAddToWishListDiv"></div>
              <div id="ptsGiftMessage" class="ptsSpot"></div>
              <div class="container orderItems giftMessageOrderItems">
                <div class="boxList giftMessageList">
                <?php foreach ($cart['productList'] as $cart_product): ?>
                  <?php
                    $nid = get_nid_from_product_id($cart_product['masterProductID']);
                    $node = node_load($nid);
                    $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
                    $product_variant = $system_data->product_variants->{$cart_product['productID']};
                    $product = $system_data->product_raw;
                 //   krumo($product);
                  ?>
                  <div class="boxListItemTabular cartItem GiftMessageOrderItems" id="carPageSectionOneborderTop">
                    <div class="GiftMessageOrderItems group group1">
                      <ul class="displayList cartItemList GiftMessageOrderItems">
                        <li class="image itemImage giftMessageOrderItemsItemImage firstRow">
                          <div>
                              <a href="<?php echo url('node/' . $nid) ?>" id="image_<?php echo $cart_product['productID'] ?>">
                              <img alt="<?php echo $cart_product['productName'] ?>" src="<?php echo drubiz_image($product->plp_image) ?>" class="productCartListImage" height="140" width="105" onmouseover="src='<?php echo drubiz_image($cart_product['productImage']) ?>';" onmouseout="src='<?php echo drubiz_image($cart_product['productImage']) ?>';">     
                              </a>
                            </div>
                        </li>
                      </ul>
                    </div>
                    <div class="GiftMessageOrderItems group group2">
                      <ul class="displayList cartItemList GiftMessageOrderItems">
                        <li class="string itemName giftMessageOrderItemsItemName firstRow">
                          <div>
                              <label id="title">Item Name</label>
                              <a href="<?php echo url('node/' . $nid) ?>" id="image_<?php echo $cart_product['productID'] ?>">
                              <span><?php echo $cart_product['productName'] ?></span>
                              </a>
                            </div>
                        </li>
                        <li class="string itemDescription giftMessageOrderItemsItemDescription firstRow">
                          <div>
                            <label>Item Description</label>
                            <span>
                              <ul class="displayList productFeature">
                                <li class="string productFeature">
                                  <div>
                                    <p class="noProductFeature">
                                        <?php $selected_features = get_selected_features($product_variant); ?>
                                            <?php foreach ($selected_features as $selected_feature_name => $selected_feature_value): ?>
                                              <?php if (strtolower($selected_feature_name) == 'size'): ?>
                                                <span><?php echo strtolower($selected_feature_name) ?>:<?php echo $selected_feature_value ?></span>
                                              <?php endif; ?>
                                              <?php if (strtolower($selected_feature_name) == 'color'): ?>
                                                <span><?php echo strtolower($selected_feature_name) ?>:<?php echo $selected_feature_value ?></span>
                                              <?php endif; ?>
                                            <?php endforeach; ?>
                                    </p>
                                  </div>
                                </li>
                              </ul>
                            </span>
                          </div>
                        </li>
                        <li class="number itemQty giftMessageOrderItemsItemQty firstRow">
                          <div>
                            <label>Quantity</label>
                            <span><?php echo $cart_product['quantity'] ?></span>
                          </div>
                        </li>
                        <li id="cartpagePRiceTag">
                          <div class="currency itemPrice showCartOrderItemsItemPrice firstRow" id="cartpagePRiceTagRate">
                              <label id="title">Item Price</label>
                              <span>$ <?php echo format_money($cart_product['productPrice']) ?></span>
                            </div>
                        </li>
                        <li class="currency itemOfferPrice giftMessageOrderItemsItemOfferPrice firstRow">
                          <div>
                          </div>
                        </li>
                      </ul>
                    </div>
                    <div class="GiftMessageOrderItems group group3">
                      <ul class="displayList cartItemList GiftMessageOrderItems">
                        <li class="currency itemTotal giftMessageOrderItemsItemTotal firstRow">
                          <div>
                            <label>Item Price Total</label>
                            <span>$ <?php echo format_money($cart['orderGrandTotal']) ?></span> 
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <input type="hidden" id="cartLine" value="<?php echo $cart_product['cartLine'] ;?>" />
                  <?php endforeach; ?>
                </div>

              </div>

              <div class="container messageEntry giftMessageMessageEntry">
                <!-- -->
                <input type="hidden" name="cartLineIndex" value="0">
                <div class="giftMessageEntry displayBox">
                  <input type="hidden" name="row" value="1">
                  <div class="entry fromName">
                    <label>From:</label>
                    <div class="entryField">
                      <input type="text" class="characterLimit" maxlength="50" onblur="restrictTextLength(this);" name="from_1" id="from" value="">
                      <input type="hidden" name="from_MANDATORY" value="Y">
                      <!---->
                    </div>
                  </div>
                  <div class="entry toName">
                    <label>To:</label>
                    <div class="entryField">
                      <input type="text" class="characterLimit" maxlength="50" onblur="restrictTextLength(this);" name="to_1" id="to" value="">
                      <input type="hidden" name="to_MANDATORY" value="Y">
                      <!---->
                    </div>
                  </div>
                  <div class="entry giftType">
                    <label>Message, let us help:</label>
                    <div class="entryField">
                      <select name="giftMessageEnum_1" id="giftMessageEnum" class="js_giftMessageEnum_1">
                        <option value="">Select One... </option>
                        <option value="Happy Mother’s Day.">Happy Mother’s Day.</option>
                        <option value="A symbol of my love and appreciation for you.">A symbol of my love and appreciation for you.</option>
                        <option value="My love for you will last as long as this rose, forever.">My love for you will last as long as this rose, forever.</option>
                        <option value="I Love You! But I Hate Steven Singer!">I Love You! But I Hate Steven Singer!</option>
                        <option value="Finally, flowers that won’t end up in the trash in a week.">Finally, flowers that won’t end up in the trash in a week.</option>
                        <option value="Happy Anniversary. Every year it gets better.">Happy Anniversary. Every year it gets better.</option>
                        <option value="Next time I am in big trouble, remember this note.">Next time I am in big trouble, remember this note.</option>
                        <option value="I know it’s not the ring, but you’ve gotta admit it is pretty sweet.">I know it’s not the ring, but you’ve gotta admit it is pretty sweet.</option>
                        <option value="YES IT’S REAL!">YES IT’S REAL!</option>
                        <option value="The only thing that sparkles more are your eyes.">The only thing that sparkles more are your eyes.</option>
                        <option value="For my princess.">For my princess.</option>
                        <option value="Is tonight the night?">Is tonight the night?</option>
                        <option value="You sure have been naughty, here’s some coal!">You sure have been naughty, here’s some coal!</option>
                        <option value="Perfect for someone soooo pretty.">Perfect for someone soooo pretty.</option>
                        <option value="How many points can I score with this great gift?">How many points can I score with this great gift?</option>
                        <option value="To the best Mom in the world!">To the best Mom in the world!</option>
                      </select>
                      <input type="hidden" name="giftMessageEnum_MANDATORY" value="Y">
                      <!---->
                    </div>
                  </div>
                  <div class="entry giftMessage">
                    <label>Message (your choice):</label>
                    <div class="entryField">
                      <textarea name="giftMessageText_1" id="giftMessageText" class="js_giftMessageText_1" cols="35" rows="5" maxlength="255"></textarea>
                      <span class="js_textCounter textCounter"></span>
                      <input type="hidden" name="giftMessageText_MANDATORY" value="Y">
                      <!---->
                    </div>
                  </div>
                </div>
              </div>
              <div class="action continueButton giftMessageContinueButton">
                <a class="standardBtn positive giftMessageSave"><span>SAVE</span></a>
                <!--<input type="submit" value="SAVE" class="standardBtn positive"/>-->
              </div>
              <div class="action previousButton giftMessagePreviousButton">
                <a href="<?php echo url('cart'); ?>" class="standardBtn negative"><span>BACK</span></a>
              </div>
              <div id="pesGiftMessage" class="pesSpot"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" id="ui-id-1" tabindex="0" style="z-index: 4; display: none;"></ul>