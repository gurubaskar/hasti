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
    <div class="col-xs-12 col-sm-8 col-md-9 contact-right">
      <div id="faq" class="tab-content">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="heading-bar">
          <h2><?php echo t('Contact Us');?></h2>
        </div>
        <div class="">
          <div class="col-xs-12 col-sm-12 col-md-12 pleft">
          <div class="outerbox">
          <div class="form-wrap">
            <div class="success-msg" style="display: none">
              Succesfully Submitted
            </div> 
            <div id="signup_errormsgs" style=""></div>
            <style type="text/css">.ui-select {position: static;}</style>
             <form method="post" action="<?php echo url('save-contact-us') ?>" id="contactusForm" name="contactusForm">
            <div id="addContactus" name="addContactus">          
              <?php 
              if($GLOBALS['user']->uid != 0):
              ?>
              <div class="form-row">
                <label><span class="required">*</span>First Name</label>
                <input type="text" maxlength="20" class="" name="firstname" id="firstname" value="<?php echo $_SESSION['drubiz']['session']['firstName']; ?>">
              </div>          
              <div class="form-row">
                <label><span class="required">*</span>Email Id</label>
                 <input class="form-control-user" id="returnCustomerEmail" name="emailid" type="text" value="<?php echo $GLOBALS['user']->mail; ?>">
              </div>
              <?php endif; ?>
             <?php if($GLOBALS['user']->uid == 0):?>
              <div class="form-row">
                <label><span class="required">*</span>First Name</label>
                <input type="text" maxlength="20" class="" name="firstname" id="firstname" placeholder="<?php echo t('*Full Name / Name of Organization');?>" data-msg-required="FirstName can't be Empty" id="" data-rule-required="true">
              </div>          
              <div class="form-row">
                <label><span class="required">*</span>Email Id</label>
                 <input class="form-control-user" id="returnCustomerEmail" name="emailid" type="text" placeholder="<?php echo t('@ Email');?>" maxlength="200" data-msg-required="Please Enter your Email" id="" data-rule-required="true">
              </div>
              <?php endif; ?>
              <div class="form-row">
                <label>Order Number</label>
                <input type="text" name="orderIdNumber" id="orderIdNumber" placeholder="<?php echo t('Purchase Order Number (Optional)');?>">
              </div>
              <div class="form-row">
                <label><span class="required">*</span>Mobile No</label>
                <input type="text" name="conactUsPhone" id="conactUsPhone" placeholder="<?php echo t('*Mobile No / Phone No');?>" data-msg-required="Phone Number cant't be Empty" id="" data-rule-required="true">
              </div>          
              <div class="form-row">
                <label>Upload Image</label>
              <input type="file" name="choose-file" class="disabled-text" id="choose-file">
              </div>
              <div class="form-row">
                <label><span class="required">*</span>Message</label>
               <textarea name="content" id="js_content" placeholder="*Type Your Message Here..." class="content characterLimit" cols="35" rows="5" maxlength="100" data-msg-required="Massage can't be Empty" id="" data-rule-required="true"></textarea>
               <span class="js_textCounter textCounter">100 characters left</span>
               <input type="hidden" name="content_MANDATORY" value="Y">
              </div>         
              <div class="btns-wrap">
                <input type="submit" value="Save" class="contact-us" id="contactus">
                <!--a href="#" class="contact-us" onclick="contactus()">Save</a-->
                <a href="<?php echo url('account/address-book');?>" class="">Cancel</a>
              </div>
            </div>
            </form>
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