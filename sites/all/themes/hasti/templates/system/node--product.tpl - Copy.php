<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 *
 * @ingroup themeable
 */
  $system_data = json_decode($node->field_system_data[LANGUAGE_NONE][0]['value']);
  $product = $system_data->product_raw;
  $drubiz_category_names = json_decode(variable_get('drubiz_category_names', '[]'), TRUE);
  $category_names_from_catalog = $drubiz_category_names['globus'];
  $get_category_names = explode(',', $product->product_category_id);
  $category_names = $category_names_from_catalog[$get_category_names[2]];
  $category = strtolower($category_names);
  $category_name = str_replace(" ", '' , $category);
  $selected_features = get_selected_features($product);
  $facet_values = get_facet_values($system_data);
  $share_url = url('node/' . $node->nid, array('absolute' => TRUE));
  $out_of_stock_info = pdp_out_of_stock_info($node->field_product_id[LANGUAGE_NONE][0]['value']);
  $out_of_stock = $out_of_stock_info->inventoryProductLevel;
 // krumo($out_of_stock_info->inventoryProductLevel , $facet_values);
  //krumo($sku);
?>

<div id="eCommerceProductDetailContainer" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

<div class="PDP group group1">
 <ul class="displayList pdpList PDP">

  <li class="image mainImage pdpMainImage">
    <div class="pdpMainImage">
      <div id="js_productDetailsImageContainer" onclick="displayDialogBox('largeImage_')">
        <a href="<?php echo drubiz_image($product->pdp_large_image) ?>" class="innerZoom" rel="undefined" title="" style="outline-style: none; text-decoration: none;">
          <div class="zoomPad"><img src="<?php echo drubiz_image($product->pdp_regular_image) ?>" name="mainImage" class="js_productLargeImage" height="630" width="490" onerror="onImgError(this, 'PDP-Large');" id="js_mainImage" title="" style="opacity: 1; display: block;"><div class="zoomPup" style="display: none; top: -1px; left: 223px; width: 266px; height: 330px; position: absolute; border-width: 1px;"></div><div class="zoomWindow" style="position: absolute; z-index: 5001; cursor: default; left: 0px; top: 0px; display: none;"><div class="zoomWrapper" style="border-width: 1px; width: 490px; cursor: crosshair;"><div class="zoomWrapperTitle" style="width: 100%; position: absolute; display: block;">undefined</div><div class="zoomWrapperImage" style="width: 100%; height: 630px;"><img src="<?php echo drubiz_image($product->pdp_alt_1_large_image) ?>" style="position: absolute; border: 0px; display: block; left: -411.429px; top: 0px;"></div></div></div><div class="zoomPreload" style="visibility: hidden; top: 293.5px; left: 245px; position: absolute;"></div></div>
        </a>
      </div>
      <div class="wishList_social_share pdp">

        <span>

          <span><a title="Share on Facebook" class="fb_share" target="_blank" href="#" rel="me"></a></span>


          <span><a title="Share on Twitter" class="tw_share" target="_blank" href="#" rel="nofollow"></a></span>

          <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="#" count-layout="horizontal"></a></span>

          <span><a title="Share on Google" class="google_share" target="_blank" href="#"></a></span>

          <span><a title="Share on Mail" class="mailFriend" href="#"></a></span>

          <span><a title="Share on WhatsApp" class="whatsApp" href="#"></a></span>
        </span>
        </div>

      </div>

      <!--Added for making the link available on PDP image -->
      <div class="quicklookwishlist">
        <div id="js_addToWishlist_div">
          <a href="javascript:void(0);" class="addToWishlist inactiveAddToWishlist" id="js_addToWishlist"><span><?php t('Add to Wishlist'); ?></span></a>
        </div>
      </div>
    </li>


    <li class="image mainImage pdpMainImage thumb" style="display: block;">
      <div class="pdpAlternateImage">
        <div id="js_eCommerceProductAddImage">

         <div id="js_altImageThumbnails" class="bxslider mCustomScrollbar _mCS_1" style="height:630px"><div id="mCSB_1" class="mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px;" dir="ltr">

          <div id="addImageLink_li"><a href="javascript:void(0);" style="border:1px solid #eee;" id="mainAddImageLink" onclick="javascript:replaceDetailImage('<?php echo drubiz_image($product->pdp_regular_image) ?>','<?php echo drubiz_image($product->pdp_large_image) ?>');"><img src="<?php echo drubiz_image($product->pdp_thumbnail_image) ?>" id="mainAddImage" name="mainAddImage" vspace="5" hspace="5" alt="" class="productAdditionalImage mCS_img_loaded" height="102" width="88" onerror="onImgError(this, 'PDP-Alt');"></a></div>

          <?php foreach (range(1, 10) as $img_n): $img_prefix = "pdp_alt_{$img_n}"; if (empty($product->{$img_prefix . '_regular_image'})) continue; ?>
            <div id="addImage<?php echo $img_n ?>Link_li"><a href="javascript:void(0);" style="border:1px solid #eee;" id="addImage<?php echo $img_n ?>Link" onclick="javascript:replaceDetailImage('<?php echo drubiz_image($product->{$img_prefix . '_regular_image'}) ?>','<?php echo drubiz_image($product->{$img_prefix . '_large_image'}) ?>');"><img src="<?php echo drubiz_image($product->{$img_prefix . '_thumbnail_image'}) ?>" name="addImage1" id="addImage1" vspace="5" hspace="5" alt="" class="productAdditionalImage mCS_img_loaded" height="102" width="88" onerror="onImgError(this, 'PDP-Alt');"></a></div>
          <?php endforeach; ?>

         </div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-dark-3 mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 580px; max-height: 620px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
      </div>
    </div>
  </li>



  <script type="text/javascript">
    jQuery(document).ready(function(){

      jQuery(window).resize(function() {

       width = jQuery(window).width();
       if(jQuery(window).width() > 900){
        jQuery('#js_altImageThumbnails').mCustomScrollbar({
          theme:"dark-3",
        });
      }
 if(width < 768  )
 { 

  //jQuery(".pdpImgCaurosel").css("display","block");
  //jQuery("#js_mainImage").css("display","none");
  //jQuery(".image.mainImage.pdpMainImage.thumb").css("display","none");
  jQuery(".pdpImgCaurosel").bxSlider({
    slideWidth: 350,
    minSlides: 2,
    moveSlides: 1,
    maxSlides: 1,
    slideMargin:10
  });
}
else{
  //jQuery(".pdpImgCaurosel").css("display","none");
  //jQuery("#js_mainImage").css("display","block");
  //jQuery(".image.mainImage.pdpMainImage.thumb").css("display","block");
}

var maxSlides=3;
var slideMargin=50;
if (width > 1000) {
  maxSlides = 4;
}
else if(width >480 && width<700) {
  maxSlides = 2;
}
else{
  if (width < 490) {
    maxSlides = 1;
  }
}

jQuery('.slider1').bxSlider({
  slideWidth: 200,
  minSlides: 2,
  moveSlides: 1,
  maxSlides: maxSlides,
  slideMargin:10
});

if(false)
{
  var thmbSlides=7;
  if (width > 550) {
    thmbSlides = 7;
  }
  else if(width >380 && width<550) {
    thmbSlides = 4;
  }
  else if(width >250 && width<380) {
    thmbSlides = 3;
  }
  else{
    if (width < 250) {
      thmbSlides = 2;
    }
  }


  jQuery('.bxslider').bxSlider({
    slideWidth: 50,
    minSlides: 1,
    moveSlides: 1,
    maxSlides: thmbSlides,
    slideMargin:10
  });

}
}).resize();
    });
  </script>

</ul>
</div>
<div class="PDP group group2">
<ul class="displayList pdpList PDP">

<li class="string productName pdpProductName" id="<?php echo $product->product_id ?>">
 <div>
  <h3>    
   <?php echo $node->title ?>
 </h3>
</div>
</li>   

<li class="priselist">
<table><tbody><tr><td>
  <?php if ($product->list_price != $product->sales_price): ?>
    <li class="currency priceList pdpPriceList">
      <div id="js_pdpPriceList">
       <p class="oldprice">
         <span class="price">
           <span>$ <?php echo format_money($product->list_price) ?></span>
         </span>
       </p>
     </div>
   </li>
  <?php endif; ?>
</td>

<td>
<li class="currency priceOnline pdpPriceOnline">
  <div class="pdpPriceOnline" id="js_pdpPriceOnline">
    <span class="bold">$ <?php echo format_money($product->sales_price) ?></span>
  </div>
</li>
</td></tr>
<tr><td>

  <?php if (!empty($product->promotion_label)): ?>
    <div class="promotion-label pdp-promotion-label">
      <span><?php echo $product->promotion_label ?></span>
    </div>
  <?php else: ?>
    <?php if ($product->list_price != $product->sales_price): ?>
      <div class="promotion-label pdp-promotion-label">
        <span><?php echo 100 - round($product->sales_price * 100 / $product->list_price) ?>% Off</span>
      </div>
    <?php else: ?>
      <div>
        &nbsp;
      </div>
    <?php endif; ?>
  <?php endif; ?>


</td></tr></tbody></table>

<script type="text/javascript">
jQuery('#img1').on('click','#img1',function () {

 jQuery('#img1').addClass('selected')
});
</script>  
</li>
<?php foreach ($facet_values as $facet_name => $this_facet_values): ?>
  <li class="string selectableFeature pdpSelectableFeature">
    <div class="pdpSelectableFeature">
      <div class="selectableFeatures <?php echo strtoupper($facet_name) ?>">
        <div id="size-wrapper">
          <div class="forgot-area">
            <ul class="js_selectableFeature_1">
              <?php foreach ($this_facet_values as $this_facet_value => $this_facet_product_id): ?>
                <li class="<?php echo $this_facet_value ?>">
                <?php foreach ($out_of_stock as $prodIds => $prodId) :?>
                <?php if(($prodIds == $this_facet_product_id) && ($prodId->availableQuantity != 0 )){?>
                  <a class="product-choose-facet" href="#" data-product-id="<?php echo $this_facet_product_id ?>"><?php echo $this_facet_value ?></a>
                <?php } ?>
                  <?php endforeach; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
<div class="sizehide"><a id="size_guide_fancybox" onclick="sizeGuidePopUp('<?php echo drubiz_image('products/sizeGuide/'. $category_name .'.PNG') ?>')"><img src="<?php echo drubiz_image('products/sizeGuide/size-chart-img.png') ?>" alt="size-chart" style="width:21px;height:15px;border:0"><b><?php echo t('(view size chart)'); ?></b></a></div>
        </div>
      </div>
    </div>
  </li>
<?php endforeach; ?>

<li class="entry qty pdpQty">
      <div id="js_quantity_div">

        <label><?php echo t('Quantity:'); ?></label>
        <select id="js_quantity1" name="quantity" style="width: 45px;">
          <option value="1">1</option>
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
      </div>
    </li>

    <li class="entry qty pdpQty pdp_buynow">
      <input type="hidden" name="add_category_id" id="add_category_id" value="520">
      <div>
        <div class="buynow"><a href="#" id="js_addToCart_buynow"><span class="button red auto"><?php echo t('Buy Now');?></span></a></div>
        <div class="addtobag"> <a href="#" id="js_addToCart"><span class="button red auto"><?php echo t('ADD TO BAG');?></span></a></div>
      </div>

    </li>

  <p></p><p></p>

  <li class="content content01 pdpContent01">

    <div id="pdpContent01" class="pdpContent">
    </div><!-- End Section Widget  -->

  </li>

  <div class="pdpLongDescription" id="js_pdpLongDescription">
   <div class="displayBox">
    <h3><?php echo t('Product Description');?></h3>
    <p><?php echo $body[0]['safe_value'] ?></p>
  </div>
</div>

<li class="string specialInstructions pdpSpecialInstructions">

<p id="specialInstructions" style="display:none">Color:Blue-Fabric:Cotton-Fit:Regular Fit</p>
<h3><?php echo t('Features'); ?></h3> 

<div id="dynamictable">
  <table>
    <tbody>
      <?php foreach ($selected_features as $facet_name => $facet_value): ?>
        <tr>
          <td><?php echo $facet_name ?></td>
          <td><?php echo $facet_value ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

</li>

<li class="write-rivew" id=""><span>
<span id="reviewSpanId" style="display:none;"></span>
<a href="#submitPageReview" onclick="return writeAReview(event);"><?php echo t('Write Review');?></a>
</span></li>

<div id="freeDeliveryChecker" class="pincodeChecker forgot-area" style="display:none;">
<?php echo t('Free shipping on all orders above Rs. 1000');?>
</div>

<li class="content content05 pdpContent05">

<div id="pdpContent05" class="pdpContent">

  <script type="text/javascript">(function(d, s, id) {
    /*
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
    fjs.parentNode.insertBefore(js, fjs);
    */
  }(document, 'script', 'facebook-jssdk'));
</script>

<div class="wishList_social_share">

  <span>


    <span><a class="fb_share" target="_blank" href="#" rel="me"></a></span>


    <span><a class="tw_share" target="_blank" href="#" rel="nofollow"></a></span>

    <span><a class="pinit_share pin-it-button" target="_blank" href="#" count-layout="horizontal"></a></span>

    <span><a class="google_share" target="_blank" href="#"></a></span>

    <span><a class="mailFriend" href="#"></a></span>

    <span><a class="instagram" href="#" target="_blank"></a></span>
  </span></div>
</div>

</li>

</ul>
</div>

<div class="PDP group group4">
         <ul class="displayList pdpList PDP">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplement -->
<!-- Begin Template component://osafe/webapp/osafe/common/pdp/pdpComplement.ftl -->

<li class="container complement pdpComplement">
    <div class="js_pdpComplement" style="display: none;">

       


       




       <div class="productImageTitle"><h2>You May Also Like</h2></div>
       <div class="bx-wrapper" style="max-width: 830px;"><div class="bx-viewport" aria-live="polite" style="width: 100%; overflow: hidden; position: relative; height: 340px;"><div class="slider1" style="width: 6215%; position: relative; transition-duration: 0s; transform: translate3d(-840px, 0px, 0px);"><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500010" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500010" href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="500010">
            <img alt="Fashion Women Casual Top -500010" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500010');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500010"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500010&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500010"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="detailLink_-500010">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 559
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 699</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 559
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500011" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Party Wear Dresses -500011" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="500011">
            <img alt="Fashion Women Party Wear Dresses -500011" title="Fashion Women Party Wear Dresses " src="/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500011');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500011"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220;title=Fashion Women Party Wear Dresses " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500011&amp;text=Fashion Women Party Wear Dresses  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg&amp;description=Fashion Women Party Wear Dresses " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Party Wear Dresses &amp;body=Take a look at the Fashion Women Party Wear Dresses  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500011"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Party Wear Dresses " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="detailLink_-500011">
                <span>Fashion Women Party Wear Dresses   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 719
    <div class="plpdiscount">40.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 1,199</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 719
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500012" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Party Wear Dresses -500012" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220" id="500012">
            <img alt="Fashion Women Party Wear Dresses -500012" title="Fashion Women Party Wear Dresses " src="/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500012');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500012"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220;title=Fashion Women Party Wear Dresses " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500012&amp;text=Fashion Women Party Wear Dresses  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg&amp;description=Fashion Women Party Wear Dresses " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Party Wear Dresses &amp;body=Take a look at the Fashion Women Party Wear Dresses  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500012"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Party Wear Dresses " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220" id="detailLink_-500012">
                <span>Fashion Women Party Wear Dresses   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 779
    <div class="plpdiscount">40.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 1,299</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 779
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500013" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Men Casual T-Shirts -500013" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120" id="500013">
            <img alt="Fashion Men Casual T-Shirts -500013" title="Fashion Men Casual T-Shirts " src="/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500013');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500013"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120;title=Fashion Men Casual T-Shirts " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500013&amp;text=Fashion Men Casual T-Shirts  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg&amp;description=Fashion Men Casual T-Shirts " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Men Casual T-Shirts &amp;body=Take a look at the Fashion Men Casual T-Shirts  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500013"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Men Casual T-Shirts " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120" id="detailLink_-500013">
                <span>Fashion Men Casual T-Shirts   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 479
    <div class="plpdiscount">40.1%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 799</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 479
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="false">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500008" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500008" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290" id="500008">
            <img alt="Fashion Women Casual Top -500008" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500008');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500008"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500008&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500008"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290" id="detailLink_-500008">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 479
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 599</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 479
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="false">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500009" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500009" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290" id="500009">
            <img alt="Fashion Women Casual Top -500009" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500009');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500009"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500009&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500009"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290" id="detailLink_-500009">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 559
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 699</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 559
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="false">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500010" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500010" href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="500010">
            <img alt="Fashion Women Casual Top -500010" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500010');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500010"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500010&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500010"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="detailLink_-500010">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 559
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 699</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 559
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="false">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500011" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Party Wear Dresses -500011" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="500011">
            <img alt="Fashion Women Party Wear Dresses -500011" title="Fashion Women Party Wear Dresses " src="/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500011');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500011"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220;title=Fashion Women Party Wear Dresses " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500011&amp;text=Fashion Women Party Wear Dresses  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg&amp;description=Fashion Women Party Wear Dresses " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Party Wear Dresses &amp;body=Take a look at the Fashion Women Party Wear Dresses  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500011"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Party Wear Dresses " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="detailLink_-500011">
                <span>Fashion Women Party Wear Dresses   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 719
    <div class="plpdiscount">40.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 1,199</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 719
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500012" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Party Wear Dresses -500012" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220" id="500012">
            <img alt="Fashion Women Party Wear Dresses -500012" title="Fashion Women Party Wear Dresses " src="/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500012');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500012"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220;title=Fashion Women Party Wear Dresses " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500012&amp;text=Fashion Women Party Wear Dresses  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14LBD016-BLACK-2.jpg&amp;description=Fashion Women Party Wear Dresses " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Party Wear Dresses &amp;body=Take a look at the Fashion Women Party Wear Dresses  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500012"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Party Wear Dresses " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500012&amp;productCategoryId=220" id="detailLink_-500012">
                <span>Fashion Women Party Wear Dresses   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 779
    <div class="plpdiscount">40.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 1,299</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 779
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500013" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Men Casual T-Shirts -500013" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120" id="500013">
            <img alt="Fashion Men Casual T-Shirts -500013" title="Fashion Men Casual T-Shirts " src="/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500013');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500013"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120;title=Fashion Men Casual T-Shirts " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500013&amp;text=Fashion Men Casual T-Shirts  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14CXMT582-WHITE-2.jpg&amp;description=Fashion Men Casual T-Shirts " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Men Casual T-Shirts &amp;body=Take a look at the Fashion Men Casual T-Shirts  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500013"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Men Casual T-Shirts " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500013&amp;productCategoryId=120" id="detailLink_-500013">
                <span>Fashion Men Casual T-Shirts   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 479
    <div class="plpdiscount">40.1%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 799</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 479
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div>
                <!-- DIV for Displaying PLP item ENDS here -->
            <div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500008" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500008" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290" id="500008">
            <img alt="Fashion Women Casual Top -500008" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500008');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500008"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500008&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT041-RED-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500008"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500008&amp;productCategoryId=290" id="detailLink_-500008">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 479
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 599</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 479
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500009" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500009" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290" id="500009">
            <img alt="Fashion Women Casual Top -500009" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500009');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500009"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500009&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT030-PINK-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500009"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500009&amp;productCategoryId=290" id="detailLink_-500009">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 559
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 699</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 559
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500010" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Casual Top -500010" href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="500010">
            <img alt="Fashion Women Casual Top -500010" title="Fashion Women Casual Top " src="/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500010');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500010"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1;title=Fashion Women Casual Top " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500010&amp;text=Fashion Women Casual Top  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT030-GREEN-2.jpg&amp;description=Fashion Women Casual Top " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Casual Top &amp;body=Take a look at the Fashion Women Casual Top  found at http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500010"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Casual Top " href="http://182.72.231.54:8080/290/S15ZCWT003-OFFWHITE;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1" id="detailLink_-500010">
                <span>Fashion Women Casual Top   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 559
    <div class="plpdiscount">20.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 699</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 559
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(20% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div><div class="slide like-carousel bx-clone" style="float: left; list-style: none; position: relative; width: 200px; margin-right: 10px;" aria-hidden="true">
              
                <!-- DIV for Displaying Recommended productss STARTS here -->
                <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->
<!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- Begin Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->

     <div class="boxListItemGrid productItem PDPComplement">
         <ul class="displayList productItemList PDPComplement">
              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<li id="500011" class="image thumbImage pdpComplementThumbImage">
  <div class="js_eCommerceThumbNailHolder eCommerceThumbNailHolder">
      <div class="js_swatchProduct">
        <a class="pdpUrl" title="Fashion Women Party Wear Dresses -500011" href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="500011">
            <img alt="Fashion Women Party Wear Dresses -500011" title="Fashion Women Party Wear Dresses " src="/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg" class="productThumbnailImage" height="187" width="140" onmouseover="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-3.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onmouseout="src='/osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg'; jQuery(this).error(function(){onImgError(this, 'PLP-Thumb');});" onerror="onImgError(this, 'PLP-Thumb');">
        </a>

      </div>

 </div>
</li>

<!-- Added by Krishnamohan J - Start -->
<div id="fb-root"></div>
    


<div class="wishList_social_share">

<span>
       <a title="Add to wishlist" href="javascript:void(0);" onclick="javascript:showPlpSizeGuide1('PDPComplement_500011');" class="wishlist_share" inactiveaddtowishlist"="" id="js_addToWishlist_PDPComplement_500011"></a>
   </span>
  <span><a title="Share on Facebook" class="fb_share" target="_blank" href="http://www.facebook.com/share.php?u=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220;title=Fashion Women Party Wear Dresses " rel="me"></a></span>

    <span><a title="Share on Twitter" class="tw_share" target="_blank" href="http://twitter.com/share?url=http://182.72.231.54:8080//eCommerceProductDetail?productId=500011&amp;text=Fashion Women Party Wear Dresses  at" rel="nofollow"></a></span>

  <span><a title="Share on Pinterest" class="pinit_share pin-it-button" target="_blank" href="http://pinterest.com/pin/create/button/?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220&amp;media=http://182.72.231.54:8080//osafe_theme/images/catalog/products/small/W14ZCWT014-BLACK-2.jpg&amp;description=Fashion Women Party Wear Dresses " count-layout="horizontal">
    </a></span>

    <span><a title="Share on Google" class="google_share" target="_blank" href="https://plus.google.com/share?url=http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
    <span><a title="Share on Mail" class="mailFriend" href="mailto:?subject=Checkout Fashion Women Party Wear Dresses &amp;body=Take a look at the Fashion Women Party Wear Dresses  found at http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220"></a></span>
  <span><a title="Share on WhatsApp" class="whatsApp" href="whatsapp://send?text=Take a look at this awesome product found at http://182.72.231.54:8080/eCommerceProductDetail?productId=500011"></a></span> 
</div>

 <!-- Added by Krishnamohan J - End -->
 <!-- End Template component://osafe/webapp/osafe/common/plp/plpThumbImage.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementThumbImage -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<li class="action detailLink pdpComplementDetailLink">
   <div>      
     <a class="eCommerceProductLink pdpUrl" title="Fashion Women Party Wear Dresses " href="http://182.72.231.54:8080/eCommerceProductDetail;jsessionid=6F9FA1D67061BF8E3A3C9248813885AF.jvm1?productId=500011&amp;productCategoryId=220" id="detailLink_-500011">
                <span>Fashion Women Party Wear Dresses   </span>
                <span>  </span>
    </a> </div>
     <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
    <!-- line added by THRIVIKRAM---REVIEWED BY SHRINATH-->
  
</li>   <!-- End Template component://osafe/webapp/osafe/common/plp/plpDetailLink.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementDetailLink -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->

<!--
<li class="currency priceOnline pdpComplementPriceOnline">
  <div class="js_plpPriceOnline">
      <label> </label>
      <span>&#x20B9; 719
    <div class="plpdiscount">40.0%  </div>
    </span>
   </div>
</li>
-->
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceOnline.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceOnline -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<li class="priceListGroup"><div class="currency priceList pdpComplementPriceList">
  <div class="js_plpPriceList">
    <p class="oldprice">
    <span class="price">   
      <span>$ 1,199</span>
    </span>
    </p>
   <div class="js_plpPriceOnline">
      <label> </label>
      <span>
          <span class="bold" ;="">$ 719
      </span>
   </span></div>  
  </div>


</div>
   
</li>  
 
 <li class="product-discountpercent">
    <div class="plpdiscount">(40% <span>off</span>) </div>
 </li><!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceList.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceList -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
 <li class="percent priceSavingPercent pdpComplementPriceSavingPercent">
  <div class="js_plpPriceSavingPercent">
  </div>
 </li>   
<!-- End Template component://osafe/webapp/osafe/common/plp/plpPriceSavingPercent.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementPriceSavingPercent -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->
<!-- Begin Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
          <li class="image reviewStars pdpComplementReviewStars">
     </li>
<!-- End Template component://osafe/webapp/osafe/common/plp/plpReviewStars.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplementReviewStars -->

         </ul>
     </div>


<!-- End Template component://osafe/webapp/osafe/common/eCommerceDivSequence.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#ecommerceDivSequence -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#PDPComplementDivSequence -->

                    
                
                
                          
                          
                          
                </div></div></div><div class="bx-controls bx-has-controls-direction bx-has-pager"><div class="bx-controls-direction"><a class="bx-prev" href="">Prev</a><a class="bx-next" href="">Next</a></div><div class="bx-pager bx-default-pager"><div class="bx-pager-item"><a href="" data-slide-index="0" class="bx-pager-link active">1</a></div><div class="bx-pager-item"><a href="" data-slide-index="1" class="bx-pager-link">2</a></div><div class="bx-pager-item"><a href="" data-slide-index="2" class="bx-pager-link">3</a></div><div class="bx-pager-item"><a href="" data-slide-index="3" class="bx-pager-link">4</a></div><div class="bx-pager-item"><a href="" data-slide-index="4" class="bx-pager-link">5</a></div><div class="bx-pager-item"><a href="" data-slide-index="5" class="bx-pager-link">6</a></div></div></div></div>
     </div>
</li>



<!-- End Template component://osafe/webapp/osafe/common/pdp/pdpComplement.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpComplement -->

              
              
              <!-- Begin Screen component://osafe/widget/EcommerceDivScreens.xml#pdpRecentlyViewed -->
<!-- Begin Template component://osafe/webapp/osafe/common/pdp/pdpRecentlyViewed.ftl -->

<li class="container recentlyViewed pdpRecentlyViewed">
    <div class="js_pdpRecentlyViewed">
       
       
       
       
       

       
       
       
    
</div></li>


<!-- End Template component://osafe/webapp/osafe/common/pdp/pdpRecentlyViewed.ftl -->
<!-- End Screen component://osafe/widget/EcommerceDivScreens.xml#pdpRecentlyViewed -->

         </ul>
          </div>

<div class="PDP group group5">
<ul class="displayList pdpList PDP">

<li class="action reviewWrite pdpReviewWrite  noReviews">
  <div class="pdpReviewWrite" id="pdpReviewWrite">
   <div class="customerRatingLinks">
    <div title="Be the first to write a review" id="submitPageReview"><span><?php echo t('Be the first to write a review');?></span></div>
  </div>    
</div>
</li>

<div id="reviewtoggle"><span id="Arrow"></span><?php echo t('Reviews');?></div>





<script>
var status=true;
var writereviewcontent;
jQuery("#reviewtoggle").click(function(){
 writeAReview();
 jQuery("#targethk").slideToggle('slow', function(){
   var status= jQuery("#targethk").is(":visible");

   if(status==true){
     jQuery('#Arrow').addClass('reviewtoggele_on');
     jQuery('#Arrow').removeClass('reviewtoggele_off');
   }
   if(status==false){
     jQuery('#Arrow').addClass('reviewtoggele_off');
     jQuery('#Arrow').removeClass('reviewtoggele_on');
   }



 })
});

jQuery(document).ready(function(){
  writereviewcontent=jQuery(".WriteReviewDetail.group.group3").html();
  if( jQuery('#targethk').length )         
  {
    document.getElementById("targethk").style.display="none";
  }
});


</script>
</ul>
</div>
<div class="PDP group group6">
<div class="content-messages eCommerceSuccessMessage" id="subitReviewStatusId" style="display:none;">
 <div class="eventImage"></div>
 <p class="eventMessage"> Thank you for submitting your review </p>
</div>

<ul class="displayList pdpList PDP">

<li class="string additional pdpAdditional">
  <div style="display:none">
   <div class="pdpAdditional">
    ="<div class="sizeChart" id="sizechart_Container">  <h3></h3><img src="<?php echo drubiz_image('products/sizeGuide/'. $category_name .'.PNG') ?>" alt="Mountain VIEW" style="width:775px;height:299px;"><table><thead></thead></table></div>"     </div>
  </div>
</li>

</ul>
</div>

<div id="js_mainImageDiv" style="display:none">
  <a href="">
    <img src="" name="mainImage" class="js_productLargeImage" width="100%" onerror="onImgError(this, 'PDP-Large');">
  </a>
</div>

<div id="writereviewtoggle" style="display: none;">
<div method="post" class="entryForm" id="productReviewForm" name="productReviewForm">

  <div class="writeReview">

    <div class="container product writeReviewProduct" style="display:none;">
     <div class="displayBox">
       <h1>Write a Review</h1>
     </div>
   </div>

  <div class="container detail writeReviewDetail">
    <div class="displayBox">
      <h3><?php echo t('Share your opinion with others and write a detailed review') ;?></h3>
      <div class="WriteReviewDetail group group3">
        <?php print render($content['comments']); ?>
      </div>
    </div>
  </div>

  <!--
  <div class="action submitButton writeReviewSubmitButton">
    <input type="button" value="Submit" onclick="writeReviewSubmit();" class="standardBtn negative">
  </div>

  <div class="action cancelButton writeReviewCancelButton" id="ReviewBtnCancel">
    <a onclick="clearAllReview()" class="standardBtn negative">Cancel</a>
  </div>
  -->
 
 </div></div>

</div>
</div>
