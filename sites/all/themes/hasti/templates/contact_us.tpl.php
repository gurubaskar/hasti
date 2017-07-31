<script>
jQuery(document).ready(function () 
{
  jQuery('.characterLimit').each(function(){
      restrictTextLength(this);
  });
});
function restrictTextLength(textArea){
    var maxchar = jQuery(textArea).attr('maxlength');
    var curLen = jQuery(textArea).val().length;
    var regCharLen = lineBreakCount(jQuery(textArea).val());
    jQuery(textArea).next('.js_textCounter').html((maxchar - (curLen+regCharLen))+" characters left");
    jQuery(textArea).keyup(function() {
        var cnt = jQuery(this).val().length;
        var regCharLen = lineBreakCount(jQuery(this).val());
        var remainingchar = maxchar - (cnt + regCharLen);
        if(remainingchar < 0){
            jQuery(this).next('.js_textCounter').html('0 characters left');
            jQuery(this).val(jQuery(this).val().slice(0, (maxchar-regCharLen)));
        } else{
            jQuery(this).next('.js_textCounter').html(remainingchar+' characters left');
        }
    });
 }
  function lineBreakCount(str){
    //counts n
    try {
        return((str.match(/[^\n]*\n[^\n]*/gi).length));
    } catch(e) {
        return 0;
    }
  }   
</script>

<div id="content" class="checkout">
  <div class="container-fluid">
    <!-- <div class="row"> -->
    <div class="col-xs-12 col-sm-4 col-md-3 contact-left">
      <!--h2>Placing Order</h2-->
      <ul>
        <li><a href="#faq" id="faq" class="active">Contact Us</a></li>
        <li><a href="#tracking-order">Enquiries</a></li>
        <li><a href="#cancellation" id="security-li">Business Enquiries</a></li>
        <li><a href="#try-buy">Feedback</a></li>
      </ul>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-9">
      <div id="faq" class="tab-content">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="heading-bar">
          <h2><?php echo t('Contact Us');?></h2>
        </div>
        <div class="">
          <div class="col-xs-12 col-sm-12 col-md-12 pleft">
          <div class="outerbox">
          <div class="form-wrap">
            <style type="text/css">.ui-select {position: static;}</style>
            <div id="addNewAddress" name="addNewAddress">          
              <div class="form-row">
                <label>First Name</label>
                <input type="text" maxlength="20" class="" name="firstname" id="firstname" placeholder="<?php echo t('*Full Name / Name of Organization');?>">
              </div>          
              <div class="form-row">
                <label>Email Id</label>
                 <input class="form-control-user" id="returnCustomerEmail" name="emailid" type="text" placeholder="<?php echo t('@ Email');?>" maxlength="200">
              </div>
              <div class="form-row">
                <label>Order Number</label>
                <input type="text" name="orderIdNumber" id="orderIdNumber" placeholder="<?php echo t('Purchase Order Number (Optional)');?>">
              </div>
              <div class="form-row">
                <label>Mobile No</label>
                <input type="text" name="conactUsPhone" id="conactUsPhone" placeholder="<?php echo t('*Mobile No / Phone No');?>">
              </div>          
              <div class="form-row">
                <label>Upload Image</label>
              <input type="file" name="choose-file" class="disabled-text" id="choose-file">
              </div>
              <div class="form-row">
                <label>Message</label>
               <textarea name="content" id="js_content" placeholder="*Type Your Message Here..." class="content characterLimit" cols="35" rows="5" maxlength="255"></textarea>
               <span class="js_textCounter textCounter">255 characters left</span>
               <input type="hidden" name="content_MANDATORY" value="Y">
              </div>         
              <div class="btns-wrap">
                <a href="#" class="buy-now" onclick="contactus()">Save</a>
                <a href="<?php echo url('account/address-book');?>" class="">Cancel</a>
              </div>
            </div>
          </div>
        </div>
          </div>
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4"></div>
      </div>
      <!--returns-policy end -->

      <div id="tracking-order" class="tab-content">
        <div class="col-xs-12 col-sm-12 col-md-12 checkout-right">
          <div class="heading-bar">
            <h2>ENQUIRIES</h2>
          </div>
          <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12 pleft">
              <span>
                <div class="col-md-12"><span>Telephone No:</span> 080-42289591.</div>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!--terms-of-use end -->

      <div id="cancellation" class="tab-content">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="heading-bar">
            <h2>BUSINESS ENQUIRES</h2>
          </div>
          <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12 pleft">
              <span>
               <div class="col-md-12"><span>Telephone No:</span> 080-42289591.</div>
              </span>
            </div>
          </div>          
        </div>
      </div>
      <!--security end -->

      <div id="try-buy" class="tab-content">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="heading-bar">
            <h2>Contact</h2>
          </div>
          <div class="">
            <div class="col-xs-12 col-sm-12 col-md-12 pleft">             
               <p><strong>Industree Crafts Foundation</strong></p>
               <p>Sy No 36/5,</p>
               <p>Somasundrapalya,</p>
               <p>Begur Hobli,</p>
               <p>HSR Layout Sector 2,</p>
               <p>Nr DHL Warehouse,</p>
               <p>Bangalore, India</p>
               <p>Tel.: +91 80 65472295</p>              
            </div>
          </div>
        </div>
      </div>     
    </div>
    <!-- </div> -->
  </div>
</div>