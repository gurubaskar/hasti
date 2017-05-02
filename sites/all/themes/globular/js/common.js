var cancelorderdialog;
var referFrndDialog;
var quicklookDialog;
function getQunt(productFeatureSelectOutOfStockVariantId)
  {
    if(productFeatureSelectOutOfStockVariantId>10){
         jQuery('#js_quantity1').empty();
       for (i = 1; i <=10; i++) {
        jQuery('#js_quantity1').append(jQuery('<option />').val(i).html(i));
    }
    }
    else if(productFeatureSelectOutOfStockVariantId<10 && productFeatureSelectOutOfStockVariantId>0){
           jQuery('#js_quantity1').empty();
           for (i = 1; i <=productFeatureSelectOutOfStockVariantId; i++) {
          jQuery('#js_quantity1').append(jQuery('<option />').val(i).html(i));
       }
  }
}

function getCheckInv(){
var status=false;
  if(jQuery("input[id^='stock_flag_']").length)
  {
      jQuery("input[id^='stock_flag_']").each(function() {
    if(this.value == "N"){
      jQuery("#stock").show();
      event.preventDefault();
      return status;
    }
    else if(this.value == "N1"){
       jQuery("#stock_avl").show();
       jQuery("#inv").html(jQuery('#stockavl').val());
        event.preventDefault();
           return status;
    }
    else{
         

    }
    });
  }
  else{

  }
  return status;
 }

function submitCommonForm(form, mode, value)
  {
      if (mode == "DN") {
          form.action="/";
          form.submit();
      }
  }


  var displayDialogId;
  var myDialog;
  var titleText;
  function displayDialogBox(dialogPurpose)
  {
     var dialogId = '#' + dialogPurpose + 'dialog';
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     dialogTitleId = '#' + dialogPurpose + 'dialogBoxTitle';
     titleText = jQuery(dialogTitleId).val();
     showDialog(dialogId, displayDialogId, titleText);
  }

  function showDialog(dialog, displayDialog, titleText)
  {
      myDialog = jQuery(displayDialog).dialog({
          modal: true,
          draggable: false,
          resizable: false,
          autoResize: true,
          width: 'auto',
           position: 'center',
          title: titleText
      });

      jQuery("#plp").dialog(
  {modal: true,resizable:false});
      jQuery(myDialog).parent().addClass('uiDialogBox');
      var dialogClass = displayDialog;
      dialogClass = dialogClass.replace(/^#+/, "");
      jQuery(myDialog).parent().addClass(dialogClass);
      jQuery(myDialog).siblings('.ui-dialog-titlebar').width(jQuery(myDialog).width());
  }

  function confirmDialogResult(result, dialogPurpose)
  {
      dialogId = '#'+ dialogPurpose +'dialog';
      displayDialogId = '#'+ dialogPurpose +'displayDialog';
      jQuery(displayDialogId).dialog('close');
      if (result == 'Y')
      {
          postConfirmDialog();
      }
  }
  function postConfirmDialog()
  {
      form = document.detailForm;
      form.action="/confirmAction";
      form.submit();
  }
  function newPopupWindow(url)
  {
      popupWindow = window.open(
          url,'popUpWindow','height=350,width=500,left=400,top=200,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
  }
  function newPopupWindow(url, name)
  {
      popupWindow = window.open(
          url,name,'height=500,width=700,left=400,top=200,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')

          jQuery(popupWindow.document).ready(function() {
          popupWindow.document.title = name;
      });
  }

  function setDeleteId(deleteId,hiddenInputId)
  {
    if (jQuery('#'+hiddenInputId).length)
    {
        jQuery('#'+hiddenInputId).val(deleteId);
      }
  }
  function deleteConfirm(appendText)
  {
      jQuery('.confirmTxt').html(' '+appendText+'?');
      displayDialogBox('confirm_');
  }
  function submitSearchForm(form)
  {
     var searchText = jQuery("#searchText").val();
       var searchTextSticky = jQuery("#searchTextSticky").val();
        if(jQuery(window).width() <= 1030){
          if(searchTextSticky == ""){
         jQuery(".searchErrorMsg").html("Search text cannot be empty");
         return false;
         }
        }else{
         if(searchText == ""){
         jQuery(".searchErrorMsg").html("Search text cannot be empty");
         return false;
         }
        }
        if(searchText.length <= 0){
        searchText = jQuery("#searchTextSticky").attr('value');
        }else{
          jQuery("#searchTextSticky").val(searchText);
        }

            if(searchText.length >= 1){
          if(searchText == "" || searchText == "search website") {
              displayDialogBox('search_');
              return false;
          } else {
              jQuery(form).submit();
          }
            }

  }

  function prepareActionDialog(dialogPurpose)
  {
     jQuery('#'+ dialogPurpose +'displayDialog').find('.eCommerceErrorMessage').hide();

  }

  function displayActionDialogBox(dialogPurpose,elm)
  {
     var params = jQuery(elm).siblings('input.param').serialize();
     var dialogId = '#' + dialogPurpose + 'dialog';
     var displayContainerId = '#js_' + dialogPurpose + 'Container';
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     dialogTitleId = '#' + dialogPurpose + 'dialogBoxTitle';
     titleText = jQuery(dialogTitleId).val();
     jQuery(displayContainerId).html('<div id=loadingDiv class=loadingImg></div>');

     getActionDialog(displayContainerId,params);
     showDialog(dialogId, displayDialogId, titleText);

  }

  function displayActionDialogBoxQuicklook(dialogPurpose,elm,pdpUrl)
  {

     var params = jQuery(elm).siblings('input.param').serialize();
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     var url = "";
     if (params)
     {
        url = '/dialogActionRequest?'+params;
     }
     else
     {
        url = '/dialogActionRequest';
     }


      jQuery.ajax({
      url: url,
      type: "POST",
      data: {},
      success: function(response) {
          jQuery("#js_plpQuicklook_Container_id").html("");
          jQuery("#js_plpQuicklook_Container_id").html(response);
           quicklookDialog = jQuery(displayDialogId).dialog({
                modal: true,
                resizeable:false,
                draggable:false,
                position:'center',
                close:function(){jQuery(".ui-dialog").removeClass("TestQuickLookClass");},
              });
          jQuery(".quicklookPDPurl").attr("href", pdpUrl);
          quicklookDialog.dialog('open');
           jQuery(".ui-dialog").addClass("QuickLookPopup");
           jQuery(".pdpImgCaurosel").css("display","block");
        jQuery("#js_mainImage").css("display","none");
         jQuery(".image.mainImage.pdpMainImage.thumb").css("display","none");
         jQuery("#js_plpQuicklook_Container_id").find("#js_altImageThumbnails").css("display","none");
         jQuery("#js_plpQuicklook_Container_id").find("#js_altImageThumbnailsForQuickLook").css("display","block");
        jQuery("#js_plpQuicklook_Container_id").find(".pdpImgCaurosel").bxSlider({
        infiniteLoop: true,
        pager:true,
        touchEnabled:true,
            slideWidth: 350,
            minSlides: 2,
            moveSlides: 1,
            maxSlides: 1,
            slideMargin:10,
        pagerCustom:'#js_altImageThumbnailsForQuickLook'
          });
    jQuery('#js_altImageThumbnailsForQuickLook').mCustomScrollbar({
    theme:"dark-3"
});
     }
      });
  }

  function displayProductScrollActionDialogBox(dialogPurpose,elm)
  {
     var params = jQuery(elm).siblings('input.param').serialize();
     var dialogId = '#' + dialogPurpose + 'dialog';
     var displayContainerId = '#' + dialogPurpose + 'Container';
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     dialogTitleId = '#' + dialogPurpose + 'dialogBoxTitle';
     titleText = jQuery(dialogTitleId).val();
     jQuery(displayContainerId).html('<div id=loadingImg></div>');
     getActionDialog(displayContainerId,params);
  }

function getActionDialog (displayContainerId,params)
{
    var url = "";
    if (params)
    {
        url = 'dialogActionRequest?'+params;
    } else {
        url = 'dialogActionRequest';
    }
    jQuery.get(url, function(data)
    {
        jQuery(displayContainerId).replaceWith(data);
        //jQuery(myDialog).dialog( "option", "position", 'center' );
    });
}


  var isWhole_re = /^\s*\d+\s*$/;
  function isWhole (s) {
      return String(s).search (isWhole_re) != -1
  }

  function onImgError(elem,type)
  {
    var imgUrl = drubiz_ofbiz_url + "/osafe_theme/images/user_content/images/";
    var imgName= "NotFoundImage.jpg";
    switch (type) {
      case "PLP-Thumb":
        imgName="NotFoundImagePLPThumb.jpg";
        break;
      case "PLP-Swatch":
        imgName="NotFoundImagePLPSwatch.jpg";
        break;
      case "PDP-Large":
        imgName="NotFoundImagePDPLarge.jpg";
        break;
      case "PDP-Alt":
        imgName="NotFoundImagePDPAlt.jpg";
        break;
      case "PDP-Detail":
        imgName="NotFoundImagePDPDetail.jpg";
        break;
      case "PDP-Swatch":
        imgName="NotFoundImagePDPSwatch.jpg";
        break;
      case "CLP-Thumb":
        imgName="NotFoundImageCLPThumb.jpg";
        break;
      case "MANU-Image":
        imgName="NotFoundImage.jpg";
        break;
    }
    elem.src = imgUrl + imgName;
    elem.onmouseout="";
  elem.onmouseover="";
    elem.onerror = "";

    if(type == "PDP-Alt"){
       jQuery("#"+elem.id+"Link_li").css("display","none");
       jQuery("#addImageLink_li").css("display","none");
      var imgUrl = "";
      var imgName= "";

      }


    return true;


  }

  function getExpDate(days, hours, minutes) {
      var expDate =new Date();
      if (typeof days == "number" && typeof hours == "number" && typeof hours == "number") {
          expDate.setDate(expDate.getDate() + parseInt(days));
          expDate.setHours(expDate.getHours() + parseInt(hours));
          expDate.setMinutes(expDate.getMinutes() + parseInt(minutes));
          return expDate.toGMTString();
      }
  }

  function getCookieVal(offset)
  {
      var endstr = document.cookie.indexOf (";", offset);
      if (endstr == -1)
      {
          endstr = document.cookie.length;
      }
      return unescape(document.cookie.substring(offset, endstr));
  }

  function getCookie(name)
  {
      var arg = name + "=";
      var alen = arg.length;
      var clen = document.cookie.length;
      var i = 0;
      while (i < clen)
      {
          var j = i + alen;
          if (document.cookie.substring(i, j) == arg)
          {
              return getCookieVal(j);
          }
          i = document.cookie.indexOf(" ", i) + 1;
          if (i == 0) break;
      }
      return null;
  }

  function setCookie(name, value, expires, path, domain, secure)
  {
      document.cookie = name + "=" + escape (value) +
          ((expires) ? "; expires=" + expires : "") +
          ((path) ? "; path=" + path : "") +
          ((domain) ? "; domain=" + domain : "") +
          ((secure) ? "; secure" : "");
  }

  function deleteCookie(name,path,domain)
  {
      if (getCookie(name))
      {
          document.cookie = name + "=" +
              ((path) ? "; path=" + path : "") +
              ((domain) ? "; domain=" + domain : "") +
              "; expires=Thu, 01-Jan-70 00:00:01 GMT";
      }
  }


  jQuery(document).ready(function ()
  {
    jQuery('.MyAccount-subdivh2').click(function() {
      if (jQuery(window).width() <= 900) {
        var menu_visible = jQuery('.displayBoxList').is(':visible');
        if (menu_visible) {
          jQuery('.displayBoxList').slideUp();
          jQuery('.MyAccount-subdivh2').removeClass('opened');
        }
        else {
          jQuery('.displayBoxList').slideDown();
          jQuery('.MyAccount-subdivh2').addClass('opened');
        }
      }
    });

    if (jQuery(window).width() > 900) {
      jQuery('.displayBoxList').fadeIn();
    }

  var cancelorderdialog;
  var wid=jQuery(window).width();
  if(wid<1030){
  jQuery("#freeShipping").css("display","none");
  }
  function validateFreeDelivery(){
  if(wid>1030){
  jQuery('body').addClass('stop-scrolling');
     cancelorderdialog = jQuery("#freeDeliveryChecker2").dialog({
    modal: true,
    resizable:false
   });
   cancelorderdialog.dialog("open");
  }else{
      //window.location.href = "/eCommerceFreeShipping"
   }
  }

  jQuery(window).resize(function() {
    var window_width = jQuery(window).width();
   if(window_width > 1024){
    if (isMenuToggled) {
      jQuery('body').css('overflow-y', 'scroll');
    }
    jQuery(".responseNavBar").css("display","none");
    jQuery(".subCategoryNav").css("display","none");
    jQuery("#ecommerceNavigationBar").css("display","block");
    jQuery("#stickylogo2").css("display","none");
    //jQuery("#stickylogo").css("display","none");
    jQuery(".Menu_toggle").css("display","none");
    jQuery("#searchId").css("display","none");
    }
    else
    {
      // less than 1024 px
      if (isMenuToggled) {
        jQuery('body').css('overflow-y', 'hidden');
      }
      jQuery(".responseNavBar").css("display","block");
      jQuery(".subCategoryNav").css("display","block");
      jQuery("#ecommerceNavigationBar").css("display","none");
      jQuery(".Menu_toggle").css("display","block");
      jQuery("#searchId").css("display","block");
      //jQuery("#stickylogo").css("display","none");

      jQuery(".mainDiv").replaceWith(function() { return jQuery(this).contents(); });
      jQuery(".subUlDiv").replaceWith(function() { return jQuery(this).contents(); });


   var subulDivcount=0;
  if(!jQuery(".subCategoryNav").parent().hasClass('subUlDiv')){
  jQuery("#eCommerceNavBarMenu li ul").replaceWith(function() {
  var str=jQuery(this).html();
  if(subulDivcount==0){
  jQuery(this).replaceWith("<div class='mainDiv'><div class='subUlDiv'><ul class='newarrivals subCategoryNav'>"+str+"</ul></div></div>");

subulDivcount++;
}
else{
jQuery(this).replaceWith("<div class='mainDiv'><div class='subUlDiv'><ul class='subCategoryNav'>"+str+"</ul></div></div>");
}
});
  }

    $myaccount_subdiv = jQuery('.MyAccount-subdiv');
    if ($myaccount_subdiv.length > 0) {
      if (window_width <= 900) {
        jQuery('.displayBoxList').hide();
        jQuery('.MyAccount-subdivh2').removeClass('opened');
      }
      else {
        jQuery('.displayBoxList').fadeIn();
        jQuery('.MyAccount-subdivh2').addClass('opened');
      }
    }

  }


 jQuery(".ui-dialog-titlebar-close").on('click',function(){
  jQuery('body').removeClass('stop-scrolling');
 });

 jQuery('#js_cardNumber,#js_cardNumber_mask').bind("cut copy paste",function(e) {
     e.preventDefault();
 });

 jQuery('#js_dcardNumber,#js_dcardNumber_mask').bind("cut copy paste",function(e) {
     e.preventDefault();
 });

 jQuery(".none").css("display","none");

try{
 if(window.location.href.indexOf("isReviewWindowShow") > -1 )
 {
      window.location.hash = '#submitPageReview';
       jQuery("#writereviewtoggle").slideToggle('slow', function(){});
 }
  }catch(err){}


jQuery(".confirmLink").click(function(e) {
if(jQuery(window).width() > 1024){
    e.preventDefault();
    jQuery('body').addClass('stop-scrolling');
    cancelorderdialog = jQuery("#cancelorder").dialog({
    modal: true,
    resizable:false
    });
    cancelorderdialog.dialog("open");
    }
});

jQuery('body').bind('wheel mousewheel', function(e) {
      if(jQuery(".ui-dialog.ui-widget").is(":visible")){
      return false;
      }
  })


    jQuery("#searchAutoComplete").html("");
    jQuery("#searchText").val("");

  showcartFlyOut ();

      jQuery('.showNavWidget').click(function()
      {
        jQuery('.showNavWidget').hide();
        jQuery('.hideNavWidget').show();
        jQuery('#eCommerceNavBarMenu').show();
       });
      jQuery('.hideNavWidget').click(function()
      {
        jQuery('.hideNavWidget').hide();
        jQuery('.showNavWidget').show();
        jQuery('#eCommerceNavBarMenu').hide();
       });



      jQuery('.dateEntry').each(function(){datePicker(this);});
if(jQuery(window).width() > 1030){
      jQuery('.showLightBoxCart').hover(
          function(e) {
          },
          function()
          {
          }
      );}


       }).resize();

var count=0;
var counter=1;

jQuery(window).scroll(function(){
       scroller();
    var scroll=jQuery(window).scrollTop();
    if(scroll > 1000 ){
    jQuery(".showMoreBtnClass").css("display","block");
    }

      var url=window.location.href;
      if(url.indexOf("eCommerceProductList") > -1 )
 {
      var showMoreCount=parseInt(jQuery(".showMoreCount").val());
  //if((scroll  > 800) && (parseInt(scroll/800) == parseInt(counter)) && url !='undefined' && url.length > 10){
      if((scroll  > 800) && (1== parseInt(counter)) && url !='undefined' && url.length > 10){
        counter=counter+1;
    count=count+showMoreCount;
        var filterGroup = jQuery("input[name=filterGroup]").val();
    var sortOrder = jQuery("#sortResults").val();
    if (!(url.indexOf("filterGroup") > -1)) {
      if (typeof filterGroup !== "undefined") {
      url= url + "&filterGroup=" + filterGroup;
      }
    }
    if (!(url.indexOf("sortResults") > -1)) {
      if (typeof sortOrder !== "undefined") {
      url= url + "&sortResults="+sortOrder;
      }
    }

    if (!(url.indexOf("rows=") > -1)) {
    if (typeof showMoreCount !== "undefined") {
      url= url + "&rows="+showMoreCount;
      }
    }



    jQuery.ajax({
      url : url,
      type : "POST",
      data : {},
      success : function(data) {
        if(jQuery.isNumeric(showMoreCount) == true){
          var res= jQuery(data).find("#eCommerceProductList");
            jQuery("#eCommerceProductList").replaceWith(res);
          }else{
            var res= jQuery(data).find("#eCommerceProductList");
            //jQuery("#eCommerceProductList").replaceWith(res);
          }
          jQuery(".loadedProductsCount").val(showMoreCount);
        jQuery("#sortResults").val(sortOrder);
          var shopcategoryId = jQuery(data).find('#shopcategoryId');
               jQuery('#shopcategoryId').replaceWith(shopcategoryId);

               var tabs = jQuery(data).find('#tabs');
              jQuery('#tabs').replaceWith(tabs);

             /*  var pricetarId = jQuery(data).find('#pricetarId');
               jQuery('#pricetarId').replaceWith(pricetarId);

                var js_toggle_tarwc_1 = jQuery(data).find('#js_toggle_tarwc_1');
               jQuery('#js_toggle_tarwc_1').replaceWith(js_toggle_tarwc_1);

              var js_toggle_tarwc_2 = jQuery(data).find('#js_toggle_tarwc_2');
               jQuery('#js_toggle_tarwc_2').replaceWith(js_toggle_tarwc_2);

               var js_toggle_tarwc_3 = jQuery(data).find('#js_toggle_tarwc_3');
               jQuery('#js_toggle_tarwc_3').replaceWith(js_toggle_tarwc_3);

               var js_toggle_tarwc_4 = jQuery(data).find('#js_toggle_tarwc_4');
               jQuery('#js_toggle_tarwc_4').replaceWith(js_toggle_tarwc_4);

               var js_toggle_tarwc_5 = jQuery(data).find('#js_toggle_tarwc_5');
               jQuery('#js_toggle_tarwc_5').replaceWith(js_toggle_tarwc_5);

               var js_toggle_tarwc_6 = jQuery(data).find('#js_toggle_tarwc_6');
               jQuery('#js_toggle_tarwc_6').replaceWith(js_toggle_tarwc_6); */



              processPLPPageLoad();
              //Todo added for PLP tab show by venkat and Krishna
             jQuery("#tabs").tabs();
         //jQuery( "#tabs" ).tabs({ active: res[1]-2 });
         if(res !== undefined &&  res !== null){
         jQuery( "#tabs" ).tabs({ active: res[1]-2 });
        }

         filters_clear();

        jQuery(".ui-dialog-content").dialog("close");

         jQuery(data).find('.variableMapForFilterAjax').each(function(i){
                jQuery('.hideAjaxResponse').append(jQuery(this).html());
           });
            if (jQuery('div').hasClass('PLP')) {
          jQuery(".wishList_social_share").css({ 'display': "block" });
        }
        
      }
    });
      }
  }

 });


      var autoSuggestionList = [""];
      jQuery(function()
      {
          //jQuery("#searchText").autocomplete({source: autoSuggestionList});
      });

      jQuery("#searchText").keyup(function(e)
      {

          var keyCode = e.keyCode;
          if(keyCode != 40 && keyCode != 38)
          {

            var searchText = jQuery(this).attr('value');
            var url;
             if(searchText.length < 1){
             jQuery("#searchAutoComplete").html("");
             }

            if(searchText.length >= 1){
            if(window.location.protocol == "https:"){
        url = "/findAutoSuggestionssec?searchText="+searchText;
      }
     else{
      url = "/findAutoSuggestions?searchText="+searchText;
     }

             jQuery("#searchText").autocomplete({
              source: function(request, response) {
              jQuery.ajax({
                  url: url,
                  type: "POST",
                  dataType: "json",
                  success: function(data) {
                   jQuery("#searchAutoComplete").html("<ul>");
                  if(data.autoSuggestionList != null)
                  {
                        jQuery.each( data.autoSuggestionList, function(i,item ) {
                        var itemDtls=item.split("#");
              var searchProd="<li class=''>"+
            "<a href='/eCommerceProductDetail?productId="+itemDtls[1]+"&productCategoryId="+itemDtls[4]+"' class='table autolink'>"+
            "<div class='table-cell pl-10'>"+
            "<span class='autosuggest_prod_name'>"+itemDtls[2]+"</span><br/><span class='autosugges_price'> Rs "+itemDtls[3]+
            "</span></div><div class='searchImg'><img width='100px' src='"+itemDtls[0]+"' alt='"+itemDtls[2]+"'/></div></a></li>";
            jQuery("#searchAutoComplete ul").append(searchProd);
        });
                  }
                  else
                  {
                      jQuery("#searchAutoComplete").html("");
                  }

              }

          }); //end of jQuery AJAX
        }, //end of SOURCE
        minLength: 1
        });
       } else
                  {
                      jQuery("#searchAutoComplete").html("");
                  }
      }

  });


  jQuery('.checkDelivery').click(function(e)
  {
  jQuery("#pincodeMessageId").empty();
  jQuery("#pincodeSuccessMessageId").css("display","none");  // added for pincode
  if(wid>768){
  jQuery('body').addClass('stop-scrolling');
displayActionDialogBox('pincodeChecker_',this);
jQuery(".entry input").each(function() {
      this.value = "";
   });
}
else{
jQuery('<form action="eCommerceCheckCod"></form>').appendTo('body').submit().remove();
}
  });

  jQuery('.pincodeChecker_Form').submit(function(event)
  {
          event.preventDefault();
          jQuery.get(jQuery(this).attr('action')+'?'+jQuery(this).serialize(), function(data)
          {
              jQuery('#js_pincodeCheckContainer').replaceWith(data);
          });
  });

  jQuery('.js_cancelPinCodeChecker').click(function(event)
  {
          event.preventDefault();
          jQuery(displayDialogId).dialog('close');
  });

  setTableColumnNumber();

});



function __highlight(s, t)
{
var matcher = new RegExp("("+jQuery.ui.autocomplete.escapeRegex(t)+")", "ig" );
return s.replace(matcher, "<span class=\"searchHighlight\">$1</span>");
}

  function displayLightDialogBox(dialogPurpose)
  {
     var dialogId = '#' + dialogPurpose + 'dialog';
     displayDialogId = '#' + dialogPurpose + 'displayDialog';
     dialogTitleId = '#' + dialogPurpose + 'dialogBoxTitle';
     titleText = jQuery(dialogTitleId).val();
     showLightBoxDialog(dialogId, displayDialogId, titleText);
  }

  function showLightBoxDialog(dialog, displayDialog, titleText)
  {
      myDialog = jQuery(displayDialog).dialog({
          modal: false,
          draggable: true,
          resizable: false,
          width: 'auto',
          autoResize:true,
          position: 'center',
          title: titleText
      });
      var dialogClass = displayDialog;
      dialogClass = dialogClass.replace(/^#+/, "");
      jQuery(myDialog).parent().addClass(dialogClass);
      jQuery(myDialog).siblings('.ui-dialog-titlebar').width(jQuery(myDialog).width());
  }


  function datePicker(triger)
  {
   jQuery(triger).datepicker({
       showOn: 'button',
       buttonImage: '/images/cal.gif',
       buttonImageOnly: false,
       dateFormat: 'mm/dd/y'
   });
}

  function addMultiOrderItems()
  {
    var addItemsToCart = "true";
      var itemSelected = false;
    var count = 0;
    jQuery('.js_add_multi_product_quantity').each(function ()
    {
      reOrderQtyIdArr = jQuery(this).attr("id").split("_");
        variantIsChecked = jQuery('#js_add_multi_product_id_'+reOrderQtyIdArr[5]).is(":checked");
      if(variantIsChecked)
      {
              itemSelected = true;
        var quantity = jQuery(this).val();
        var add_productId = jQuery('#js_add_multi_product_id_'+reOrderQtyIdArr[5]).val();
        var productName = jQuery('#js_productName_'+count).val();
        if(quantity != "")
      {
        if(isQtyWhole(quantity,productName))
        {
          if(!(isQtyZero(quantity,productName,add_productId)))
          {
                  quantity = Number(quantity) + Number(getQtyInCart(add_productId));
                    if(!(validateQtyMinMax(add_productId,productName,quantity)))
                    {
                      addItemsToCart = "false";
                    }
                  }
                  else
                  {
                    addItemsToCart = "false";
                  }
        }
        else
        {
          addItemsToCart = "false";
        }
      }
      else
      {
          alert("ReOredrBlankQtyError");
        addItemsToCart = "false";
      }
      }
      count = count + 1;
    });

      if (!itemSelected)
      {
          alert("Please select items to order");
          addItemsToCart = "false";
      }
  if(addItemsToCart == "true")
  {
        document.reOrderItemForm.action="/";
        document.reOrderItemForm.submit();
      }
  }

  function seqReOrderCheck(elm)
  {
      reOrderQtyIdArr = jQuery(elm).attr("id").split("_");
      if(jQuery(elm).val()=="")
      {
          jQuery('#js_add_multi_product_id_'+reOrderQtyIdArr[5]).attr("checked", false);
      }
      else
      {
          jQuery('#js_add_multi_product_id_'+reOrderQtyIdArr[5]).attr("checked", true);
      }

  }
  function findOrderItems(elm)
  {
      document.reOrderItemSearchForm.action="https://182.72.231.54:8443/eCommerceReOrderItems;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
    document.reOrderItemSearchForm.submit();
  }

  function showTooltip(text, elm, elmType)
  {
      var tooltipBox = jQuery('.js_tooltip')[0];
      if(text != "")
      {
      var obj2 = jQuery('.js_tooltipText')[0];
      obj2.innerText = text;
    }
    tooltipBox.style.display = 'block';
    var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
    var sl = Math.max(document.body.scrollLeft,document.documentElement.scrollLeft);

          var eCommerceContentLeftPos = 0;

    var WW = jQuery(window).width();
    var WH = jQuery(window).height();

    var EX = "";
  var EY = "";
    if(elmType == "icon")
    {
      //subtracting the sl and st from element left and top position because element left and top includes the scroll pixels.
      EX = jQuery(elm).children().offset().left - sl;
      EY = jQuery(elm).children().offset().top - st;
    }
    else if(elmType == "input")
    {
      //subtracting the sl and st from element left and top position because element left and top includes the scroll pixels.
      EX = jQuery(elm).offset().left - sl;
      EY = jQuery(elm).offset().top - st;
    }

    var TTW = jQuery(tooltipBox).width();
    var TTH = jQuery(tooltipBox).height();
    var LP = 0;
    var TP = 0;
    var EH = jQuery(elm).children().height();
  var EW = jQuery(elm).children().width();

  var EH = "";
  var EW = "";
    if(elmType == "icon")
    {
      EH = jQuery(elm).children().height();
    EW = jQuery(elm).children().width();
    }
    else if(elmType == "input")
    {
      EH = jQuery(elm).height();
    EW = jQuery(elm).width();
    }

    var TOP = eval(EY > TTH);
    var BOTTOM = eval(!(TOP));
    var LEFT = eval((TTW + EX) > WW);
    var RIGHT = eval(!(LEFT));


    if(BOTTOM && LEFT)
    {
        jQuery('.js_tooltipTop').removeClass("tooltipTopLeftArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomRightArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomLeftArrow");
        jQuery('.js_tooltipTop').addClass("tooltipTopRightArrow");
    }
    else if(BOTTOM && RIGHT)
    {
        jQuery('.js_tooltipTop').removeClass("tooltipTopRightArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomRightArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomLeftArrow");
        jQuery('.js_tooltipTop').addClass("tooltipTopLeftArrow");
    }
    else if(TOP && LEFT)
    {
        jQuery('.js_tooltipTop').removeClass("tooltipTopLeftArrow");
        jQuery('.js_tooltipTop').removeClass("tooltipTopRightArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomLeftArrow");
        jQuery('.js_tooltipBottom').addClass("tooltipBottomRightArrow");
    }
    else if(TOP && RIGHT)
    {
        jQuery('.js_tooltipTop').removeClass("tooltipTopLeftArrow");
        jQuery('.js_tooltipBottom').removeClass("tooltipBottomRightArrow");
        jQuery('.js_tooltipTop').removeClass("tooltipTopRightArrow");
        jQuery('.js_tooltipBottom').addClass("tooltipBottomLeftArrow");
    }

    if(LEFT)
    {
       LP = EX - eCommerceContentLeftPos -TTW + sl + EW;
    }
    else
    {
       LP = EX - eCommerceContentLeftPos + sl;
    }

    if(BOTTOM)
    {
        TP = (EY + st + EH);
    }
    else
    {
        TP = (EY- TTH + st);
    }
    jQuery(tooltipBox).css({ top: TP+'px' });
    jQuery(tooltipBox).css({ left: LP+'px' });
  }

  function hideTooltip()
  {
      document.getElementById('tooltip').style.display = "none";
  }


  function validateQtyMinMax(productId,productName,quantity) 
  {
    var lowerLimit = Number(getMinQty(productId));
      var upperLimit = Number(getMaxQty(productId));
    if(quantity != 0)
      {
        if(quantity < lowerLimit)
          {
            var pdpMinQtyErrorText = "The Quantity for Product _PRODUCT_NAME_ is less than the minimum allowed. The minimum allowed is _PDP_QTY_MIN_. Please retry.";
            pdpMinQtyErrorText = pdpMinQtyErrorText.replace('_PRODUCT_NAME_',productName);
            pdpMinQtyErrorText = pdpMinQtyErrorText.replace('_PDP_QTY_MIN_',lowerLimit);

              alert(pdpMinQtyErrorText);

              return false;
          }
          else if(upperLimit!= 0 && quantity > upperLimit)
          {
            var pdpMaxQtyErrorText = "The Quantity for Product _PRODUCT_NAME_ is greater than the maximum allowed. The maximum allowed is _PDP_QTY_MAX_. Please retry.";
            pdpMaxQtyErrorText = pdpMaxQtyErrorText.replace('_PRODUCT_NAME_',productName);
            pdpMaxQtyErrorText = pdpMaxQtyErrorText.replace('_PDP_QTY_MAX_',upperLimit);

              alert(pdpMaxQtyErrorText);

              return false;
          }
      }
      return true;
  }

  function getMaxQty(productId)
  {
    var upperLimit = Number(99);
      if(jQuery('#js_pdpQtyMaxAttributeValue_'+productId).length)
  {
    upperLimit = Number(jQuery('#js_pdpQtyMaxAttributeValue_'+productId).val());
  }
  return upperLimit;
  }

  function getMinQty(productId)
  {
    var lowerLimit = Number(1);
      if(jQuery('#js_pdpQtyMinAttributeValue_'+productId).length)
  {
    lowerLimit = Number(jQuery('#js_pdpQtyMinAttributeValue_'+productId).val());
  }
  return lowerLimit;
  }

  function isQtyWhole(quantity,productName) 
  {
    if(!isWhole(quantity))
    {
      var pdpMaxQtyErrorText = "The Quantity entered for Product _PRODUCT_NAME_ must be a whole number, decimals are not allowed, please retry.";
        pdpMaxQtyErrorText = pdpMaxQtyErrorText.replace('_PRODUCT_NAME_',productName);

          alert(pdpMaxQtyErrorText);
        return false;
    }
    return true;
  }

  function isQtyZero(quantity,productName,productId) 
  {
    var lowerLimit = Number(getMinQty(productId));
    if(quantity == 0)
      {
        var pdpMinQtyErrorText = "The Quantity for Product _PRODUCT_NAME_ is less than the minimum allowed. The minimum allowed is _PDP_QTY_MIN_. Please retry.";
        pdpMinQtyErrorText = pdpMinQtyErrorText.replace('_PRODUCT_NAME_',productName);
        pdpMinQtyErrorText = pdpMinQtyErrorText.replace('_PDP_QTY_MIN_',lowerLimit);

          alert(pdpMinQtyErrorText);

          return true;
      }
    return false;
  }

  function getQtyInCart(productId)
  {
    var qtyInCart = Number(0);
      return qtyInCart;
  }

  function getTotalQtyFromScreen(inputName,rowNum)
  {
    var quantity = Number(0);
    var quantityInputClassAttr = jQuery('#'+inputName+rowNum).attr("class");
      jQuery('.'+quantityInputClassAttr).each(function ()
    {
      if (jQuery(this).val() != '')
      {
          quantity = quantity + Number(jQuery(this).val());
        }
    });
    return quantity;
  }

  function isItemSelectedPdp() 
  {
     jQuery(".error_msg_display").remove();
    if (document.addform.add_product_id.value == 'NULL' || document.addform.add_product_id.value == '')
      {
         OPT = eval("getFormOption()");
         for (i = 0; i < OPT.length; i++)
         {
          var optionName = OPT[i];
          var indexSelected = document.forms["addform"].elements[optionName].selectedIndex;
          if(indexSelected <= 0)
          {
              var properName = OPT[i].substr(2);
              var parts = properName.split('_');
              parts.each(function(element,index){
                  parts[index] = element.capitalize();
              });
              properName = parts.join(" ");
              //document.getElementById('generic_size_error').style.display = 'block';

              break;
          }
         }
          jQuery('#LiFTSIZE').after("<div class='error_msg_display forgot-area' id='PDPSizeErrorMsg'>Please select a size</div>");
         return false;
      }
      return true;
  }

  function isItemSelectedPlp(selectFeatureDiv) 
  {
    if (!jQuery('#'+selectFeatureDiv+'_add_product_id').length || jQuery('#'+selectFeatureDiv+'_add_product_id').val() == 'NULL' || jQuery('#'+selectFeatureDiv+'_add_product_id').val() == '')
      {
         OPT = eval("getFormOption" + selectFeatureDiv + "()");
         for (i = 0; i < OPT.length; i++)
         {
          var optionName = OPT[i];
          var indexSelected = jQuery('div#'+selectFeatureDiv+' select.'+optionName).prop("selectedIndex");
          if(indexSelected <= 0 || !jQuery('#'+selectFeatureDiv+'_add_product_id').length)
          {
              var properName = OPT[i].substr(2);
              var properName = properName.replace("_"+selectFeatureDiv,"");
              var parts = properName.split('_');
              parts.each(function(element,index){
                  parts[index] = element.capitalize();
              });
              properName = parts.join(" ");
              alert("Please select a " + properName);
              break;
          }
         }
         return false;
      }
      return true;
  }

  function validateCart()
  {
    var cartIsValid = true;
    var productId = "";
      var productName = "";
      var quantity = "";

      return cartIsValid;
  }

  function submitMultiSearchForm(form)
  {
      var isValid = false;
      jQuery('form[name=entryForm] input[type="text"]').each(function()
      {
          if (jQuery.trim(jQuery(this).val()) != '')
          {
              isValid = true;
          }
      });
      if (isValid == false)
      {
          displayDialogBox('search_');
          return false;
      }
      else
      {
          form.submit();
      }
  }

  function addRow(elm, index)
  {
      var addRowElm = elm;
      var lastDivElm = jQuery('#searchItemDiv');
      var rowDiv = new Element('DIV');
      rowDiv.setAttribute("class", "entry");
      var innerText =  "<label>Find Item&#58;<\/label><div class=\"entryField\"><input type=\"text\" name=\"searchItem"+index+"\"\/><\/div>";
      jQuery(rowDiv).html(innerText);
      jQuery(rowDiv).insertAfter('#searchItemDiv');
      jQuery(lastDivElm).removeAttr("id");
      jQuery(rowDiv).attr("id","searchItemDiv");
      updateIndexPos(addRowElm, index);
  }

  function updateIndexPos(addRowElm, index)
  {
      index = index + 1;
      addRowElm.setAttribute("onClick", "javascript:addRow(this,"+index+");");
  }

  //nextRowNumberInputId: the next row number will be stored in a hidden field with this ID
  //rowClass: all rows will have a common class
  //placeholderDivId: added Div will go before this DivId
  //getRowAction: this is the controller action to retrieve the screen that is added as the next row
function addNewRow(nextRowNumberInputId, rowClass, placeholderDivId, getRowAction)
{
  //set the next row number as a hidden input on the screen
  var rowNum = Number(0);
  if (jQuery('.'+rowClass).length)
    {
      rowNum = Number(jQuery("#"+nextRowNumberInputId).val());
    }

  jQuery("#"+nextRowNumberInputId).val(Number(rowNum + 1));

  jQuery.get('/'+ getRowAction +'?addRowIndex='+rowNum+'&rnd='+String((new Date()).getTime()).replace(/\D/gi, "")+'', function(data) {
        jQuery(data).insertBefore("#" + placeholderDivId);
    });
}

function deleteExistingRow(addRemoveIndex,rowClass,nextRowNumberInputId)
{
  jQuery('.'+addRemoveIndex).remove();
  if (jQuery('.'+rowClass).length)
    {
      //do nothing
    }
    else
    {
      //set the hidden input rowNumber to 0
      jQuery("#"+nextRowNumberInputId).val("0");
    }
}

function elmIsEmpty(elm)
{
    return !jQuery.trim(elm.html())
  }

  function setTableColumnNumber()
  {

    jQuery('table.dataTable').each(function ()
    {
      var count = 1;
      var theadTrTh = jQuery(this).find('thead').find('tr').find('th');
      jQuery(theadTrTh).each(function ()
      {
        jQuery(this).addClass("column" + count);
        count++;
      });

      var tbodyTr = jQuery(this).find('tbody').find('tr');
      jQuery(tbodyTr).each(function ()
      {
        count = 1;
        jQuery(this).find('td').each(function ()
        {
          jQuery(this).addClass("column" + count);
          count++;
        });
      });

      count = 1;
      var tfootTrTd = jQuery(this).find('tfoot').find('tr').find('td');
      jQuery(tfootTrTd).each(function ()
      {
        jQuery(this).addClass("column" + count);
        count ++;
      });

    });
  }

  var slideDownCount = 0;
function showcartFlyOut () {
  if(jQuery(window).width() <= 1024){
    //jQuery("#header-container,#iconSearch").css("display","none");
     jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","none");
     jQuery("#iconSearch2").css("display","block");
      jQuery('.clearfixedsearch').removeClass('fixedsearch');
     //jQuery(".navigationBarIcns").css("display","none");
  }
}

  function plpStickyMenu(){
      if(jQuery(window).width() <= 1024){
        jQuery("#header-container,#iconSearch").css("display","none");
        jQuery("#iconSearch2").css("display","block");
         jQuery('.clearfixedsearch').removeClass('fixedsearch');
        jQuery(".navigationBarIcns").css("display","none");
          jQuery(".navigationbar li a").each(function() {
          if (jQuery(this).next().length > 0) {
            jQuery(this).addClass("parent");
          };
        })

          if (ww < 1024) {
            jQuery(".Menu_toggle").css("display", "inline-block");
              if (!jQuery(".Menu_toggle").hasClass("active")) {
                jQuery(".navigationbar").hide();
              }else{
                jQuery(".navigationbar").show();
              }
              jQuery(".navigationbar li").unbind('mouseenter mouseleave');
              jQuery(".navigationbar li a.parent").unbind('click').bind('click', function(e) {
             jQuery(this).parent("li").toggleClass("hover");
             jQuery(".navigationbar li.hover").unbind("mouseenter mouseleave mouseover mouseout");
              e.preventDefault();
            });
        }else if (ww >= 1024) {
          jQuery(".Menu_toggle").css("display", "none");
          jQuery(".navigationbar").show();
          jQuery(".navigationbar li").removeClass("hover");
          jQuery(".navigationbar li a").unbind('click');
          jQuery(".navigationbar li").unbind('mouseenter mouseleave').bind('mouseenter mouseleave', function() {
            // must be attached to li so that mouseleave is not triggered when hover over submenu
          jQuery(this).toggleClass('hover');
        });
      }
    }
  }


  function scroller(){
   if(jQuery(window).width() <= 1024){
                var y = jQuery(window).scrollTop();
              sticky_header = jQuery("#eCommerceNavBar");
              jQuery('.clearfixedsearch').removeClass('fixedsearch');
        jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","none");
          //jQuery(".navigationBarIcns").css("display","none");
                  if( y >= 190 ){
                 jQuery(".js_scrollToTop").slideDown(100);
                  jQuery('.clearfixedsearch').removeClass('fixedsearch');
                 sticky_header.addClass('fixed');
                 jQuery("#iconSearch").css("display","none");
             jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","none");
             //jQuery(".navigationBarIcns").css("display","none");
            //jQuery(".quick-access").css("display","none");

               }else{
                    jQuery('.js_scrollToTop').slideUp(100);
                     jQuery('.clearfixedsearch').removeClass('fixedsearch');
                    sticky_header.removeClass('fixed');
              jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","none");
              //jQuery(".navigationBarIcns").css("display","none");
              //jQuery("#header-container,#iconSearch").css("display","none");
                //jQuery(".quick-access").css("display","none");
               }

   }else{
          var y = jQuery(window).scrollTop();
          jQuery('.clearfixedsearch').addClass('fixedsearch');
          sticky_header = jQuery("#eCommerceNavBar");//#header-container,searchContainer
      jQuery(".navigationBarIcns").css("display","block");
             if( y >= 190 ){
                jQuery(".js_scrollToTop").slideDown(100);
                sticky_header.addClass('fixed');
                jQuery("#iconSearch2").css("display","none");
            jQuery("#addCart,#addWishlist2,#iconSearch,#signIn_signUp").css("display","block");
            jQuery(".navigationBarIcns").css("display","none");
                 jQuery("#stickylogo").css("display","block");
                  jQuery(".fixed-wishlist").css("display","block");

               }else{
                  jQuery('.js_scrollToTop').slideUp(100);
                  sticky_header.removeClass('fixed');
                  jQuery("#iconSearch").css("display","none");
            jQuery("#addCart,#addWishlist2,#signIn_signUp,#responcive_search").css("display","none");
            jQuery(".navigationBarIcns").css("display","block");
            jQuery(".quick-access").css("display","block");
           jQuery("#stickylogo").css("display","none");
              var path=jQuery(location).attr('pathname');
            var actualpath=path.split(";");
            if(actualpath[0]=='/eCommerceAccountDashboardInfo'){
            if(y >=128){
            jQuery(".js_scrollToTop").slideDown(100);
                  sticky_header.addClass('fixed');
                  jQuery("#iconSearch2").css("display","none");
              jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","block");
              //jQuery(".navigationBarIcns").css("display","none");
            }
            else{
              jQuery('.js_scrollToTop').slideUp(100);
                    sticky_header.removeClass('fixed');
                    jQuery("#iconSearch2").css("display","none");
              jQuery("#addCart,#addWishlist2,#signIn_signUp").css("display","none");
              jQuery(".navigationBarIcns").css("display","block");
            }
            }

         }
    }
}

function popitup(url) {
newwindow=window.open(url,'_self');
if (window.focus) {newwindow.focus()}
return false;
}
function render() {
 var additionalParams1 = {
   'callback': signinCallback
 };
 jQuery(".btn-google-plus").on('click', function() {
   gapi.auth.signIn(additionalParams1);
 });
}

function handleEmailResponse(resp) {
  var primaryEmail;
     for (var i=0; i < resp.emails.length; i++) {
       if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
  }
      var gusername=resp.name.givenName;
    var gusersurname=resp.name.familyName;
    var referrerMail="";
    var referredMail="";
    var x = document.URL;
    y=x.substring(0,x.lastIndexOf("/"));
    var actionUrl = x.substring(x.lastIndexOf("/"), x.length);
    var action = actionUrl.substring(0,actionUrl.lastIndexOf(";"));
    var param = "isFBLogin=connected&fbEmail=" + primaryEmail+"&USER_FIRST_NAME="+gusername+"&USER_LAST_NAME="+gusersurname+"&fbNextAction=" + x;
    console.log("param value="+param);
    var url;
  if(window.location.protocol == "https:"){
    url = "/eCommerceFacebookLoginSec?"
  }
  else{
  url = "/eCommerceFacebookLogin?"
  }
    if(jQuery(window).width() < 1024)
  {
    referrerMail=document.getElementById("referrerMail").value;
    if(referrerMail !=null && referrerMail != 'undefined' && referrerMail.length > 0)
    {
    referrerMail=referrerMail;
    }
    referredMail=document.getElementById("referredMail").value;
    if(referredMail !=null && referredMail != 'undefined' && referredMail.length > 0)
    {
    referredMail=referredMail;
    }
    }else{
    referrerMail=jQuery("#signInpopup").data('referrerMail');
    if(referrerMail !=null && referrerMail != 'undefined' && referrerMail.length > 0)
    {
    referrerMail=referrerMail;
    }
    referredMail=jQuery("#signInpopup").data('referredMail');
    if(referredMail !=null && referredMail != 'undefined' && referredMail.length > 0)
    {
    referredMail=referredMail;
    }
  }
    jQuery.ajax({
    url :"/createPersonAndUserLogin",
    type:"POST",
  data:{firstName:resp.displayName.split(" ")[0],
  USER_FIRST_NAME_MANDATORY:"Y",
  lastName:resp.displayName.split(" ")[1],
  USER_LAST_NAME_MANDATORY:"Y",
  userLoginId:primaryEmail,
  currentPassword:123456789,
  currentPasswordVerify:123456789,
  referrerMail:referrerMail,
  referredMail:referredMail
  },
  success:function(data, textStatus, jqXHR)
    {
    jQuery.each(data, function(property, value) {
  console.log("property value"+property);
if(property == "_ERROR_MESSAGE_"){
if(window.location.protocol == "https:"){
  url = "/eCommerceFacebookLoginSec"
}
else{
url = "/eCommerceFacebookLogin"
}
  jQuery.ajax({
url :url,
  type:"POST",
data: {isFBLogin: "connected", fbEmail: primaryEmail},
success :function (data){
var path=jQuery(location).attr('pathname');
if(path=='/coupons'){
jQuery('<form action="main"></form>').appendTo('body').submit().remove();
}
else{
if (window.location.href.indexOf("logout") > -1) {
  window.location.href="/"
}else{
if(wid>1024){
//added by veeraprasad.K
//addProdToWishlist();
checkMobDob(primaryEmail);
jQuery('<form action="main"></form>').appendTo('body').submit().remove();
}
else{
//addProdToWishlist();
jQuery('<form action="main"></form>').appendTo('body').submit().remove();
}
}
}
}
});
}
if(property == 0){
//addProdToWishlist();
jQuery('<form action="eCommerceEditCustomerInfo"></form>').appendTo('body').submit().remove();
 return false;
 }
if(action == "/eCommerceProductDetail" || actionUrl == "/eCommerceShowcart"){
 jQuery.getJSON(url+param,function(result){
 window.location.replace(y+"/eCommerceShowcart");
 });
 return false;
 }
 });
 }
});
}


function addProdToWishlist()
{

var linkvalue =jQuery("#dialog").data('linkvalue')

    if(linkvalue == "TrackOrder") {
      //alert("trackvalue");
      var form = document.getElementById('loginform');
      form.action = "https://182.72.231.54:8443/eCommerceOrderHistory;jsessionid=4351F6958042874F07F529F681A87274.jvm1"
      form.submit();
    }


    if(linkvalue == "addPlpItemToWishlist") {
      var form = document.getElementById('productListForm');
      addWishListProdFromPDP("/",form);
    }
    if(linkvalue == "addPdpItemToWishlist") {
      var form = document.getElementById('productDetailForm');
      addWishListProdFromPDP("/",form);
    }
}




function guestorlogin()
{
  var uidsuccess="useremailIdsuccess";
  var email=jQuery("#customerEmailid").val();
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(document.getElementById("customerEmailid").value =="")
  {
    document.getElementById("guestusrmessage").innerText = "Please Enter your Email";
    return false;
  }
  if (!filter.test(email))
  {
    document.getElementById("guestusrmessage").innerText = "Please enter a valid email address";
    return false;
  }
  if(document.getElementById("loginCheck").checked)
  {
    var usernameNew = document.getElementById("customerEmailid").value;
    document.getElementById("login").style.display="none";
    document.getElementById("USERNAME_GUEST").value=usernameNew;
    var form = document.getElementById("loginFormMultipage");
    form.action = "validateAnonCustomerEmail";
    form.submit();


  }
  else
  {
    if(document.getElementById("password3").value =="")
    {
    document.getElementById("guestusrmessage").innerText = "Please Enter your Password";
    return false;
    }
    document.getElementById("login").style.display="block";
    var pwd=document.getElementById("password3").value
    var validregister="/validateLogin?USERNAME="+email+"&PASSWORD="+pwd;
      jQuery.ajax({
      url :validregister,
        type:"POST",
      success:function(data, textStatus, jqXHR)
        {
      if(data._ERROR_MESSAGE_LIST_!= undefined)
      {
      }
      else
      {
        jQuery('<form action="multiPageCustomerAddress"></form>').appendTo('body').submit().remove();
        }
      jQuery.each(data, function(property, value)
      {
        if(property == "_ERROR_MESSAGE_LIST_")
        {
          status="true";
          jQuery.each( value, function( key, value )
          {
            document.getElementById("guestusrmessage").innerText=value;
            return false;
          });
        }
      });
        }
    });

  }
}

function guestorlogin1()
{
  if(document.getElementById("loginCheck").checked)
  {
    var usernameNew = document.getElementById("customerEmailid").value;
    document.getElementById("login").style.display="none";
    document.getElementById("USERNAME_GUEST").value=usernameNew;
    var form = document.getElementById("loginFormMultipage");
    form.action = "validateAnonCustomerEmail"
  }
  else
  {
    document.getElementById("login").style.display="block";
    document.getElementById("loginFormMultipage").action = "validateLogin" ;
  }
}


function mguestorlogin(){

var uidsuccess="useremailIdsuccess";
  var email=jQuery("#mcustomerEmailid").val();
     var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(document.getElementById("mcustomerEmailid").value ==""){
    document.getElementById("mguestusrmessage").innerText = "Please Enter your Email";
    return false;
  }
  if (!filter.test(email)) {
    document.getElementById("mguestusrmessage").innerText = "Please enter a valid email address";
    return false;
  }

if(document.getElementById("mloginCheck").checked){
  var usernameNew = document.getElementById("mcustomerEmailid").value;
  document.getElementById("mlogin").style.display="none";
  document.getElementById("mUSERNAME_GUEST").value=usernameNew;
  var form = document.getElementById("mloginFormMultipage");
  form.action = "validateAnonCustomerEmail";
  form.submit();
}else{
if(document.getElementById("mpassword3").value ==""){
    document.getElementById("mguestusrmessage").innerText = "Please Enter your Password";
    return false;
  }
  document.getElementById("mlogin").style.display="block";
  var pwd=document.getElementById("mpassword3").value
    var validregister="/validateLogin?USERNAME="+email+"&PASSWORD="+pwd;
      jQuery.ajax({
      url :validregister,
        type:"POST",
     success:function(data, textStatus, jqXHR)
          {
        if(data._ERROR_MESSAGE_LIST_!= undefined){
        console.log("control error is ture");
        }
        else{
          location.href="/validateCartQuantity";
            }
        jQuery.each(data, function(property, value) {
          if(property == "_ERROR_MESSAGE_LIST_"){
            status="true";
            jQuery.each( value, function( key, value ) {
              document.getElementById("mguestusrmessage").innerText=value;
              return false;
            });
          }
        });
          }
    });

  }
}



function setCheckoutFormAction(form, mode, value)
  {
      if (mode == "DN")
      {


      return signInCart();
      }
      else if (mode == "UC")
      {
          form.action="/";
      }
      else if (mode == "UWL")
      {
          form.action="/";
      }
      else if (mode == "APC")
      {
          if (jQuery('#js_manualOfferCode').length && jQuery('#js_manualOfferCode').val() != null)
          {
            promo = jQuery('#js_manualOfferCode').val().toUpperCase();
            promoCodeWithoutSpace = promo.replace(/^\s+|\s+$/g, "");
          }
          form.action="/?productPromoCodeId="+promoCodeWithoutSpace+"";
      }
      else if (mode == "ALP")
      {
          form.action="/";
      }
      else if (mode == "ULP")
      {
          form.action="/";
      }
  }
jQuery("#write-rivew").click(function(){
  jQuery( "#submitPageReview" ).click();
});

function freeDeliveryCheck(){
jQuery("#freeDeliveryChecker").slideToggle();
  return false;
}

function setGetParameter(paramName, paramValue)
{
  var url = window.location.href;
  if (url.indexOf(paramName + "=") >= 0)
  {
      var prefix = url.substring(0, url.indexOf(paramName));
      var suffix = url.substring(url.indexOf(paramName));
      suffix = suffix.substring(suffix.indexOf("=") + 1);
      suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
      url = prefix + paramName + "=" + paramValue + suffix;
  }
  else
  {
  if (url.indexOf("?") < 0)
      url += "?" + paramName + "=" + paramValue;
  else
      url += "&" + paramName + "=" + paramValue;
  }
  return  url;
}

function removeProduct(url)
{
jQuery.ajax({
      url: url,
      type: "POST",
      success: function(response) {
          var group1 = jQuery(response).find('.container.orderItems.showCartOrderItems');
          if(jQuery(group1).size() > 0){
        jQuery('.container.orderItems.showCartOrderItems').replaceWith(group1);
        var group2 = jQuery(response).find('.ShowCart.group.group2');
        jQuery('.ShowCart.group.group2').replaceWith(group2);
        var cartstatus = jQuery(response).find('#addCartlist').find(".list-count").html();
                  jQuery('#addCartlist').find(".list-count").html(cartstatus);
                  jQuery('#addCart').find(".list-count").html(cartstatus);
                  jQuery('#addCart2').find(".list-count").html(cartstatus);
                  
                   var lightCartDialog = jQuery(response).find('#lightCart_displayDialog');
                   jQuery('#lightCart_displayDialog').replaceWith(lightCartDialog);
                  
        if(jQuery("#addWishlist2").is(":visible"))
        {
          jQuery('#addCart').css("display","block");
        }
      }else
      {
        jQuery.ajax({
            url: "/eCommerceShowcart",
            type: "POST",
            data: {},
            success: function(response) {
               var emptyCart = jQuery(response).find('.ShowCart.group.group1');
              jQuery('.ShowCart.group.group1').replaceWith(emptyCart);
              jQuery('.ShowCart.group.group2').replaceWith("");
         var cartstatus = jQuery(response).find('#addCartlist').find(".list-count").html();
                  jQuery('#addCartlist').find(".list-count").html(cartstatus);
                  jQuery('#addCart').find(".list-count").html(cartstatus);
                  jQuery('#addCart2').find(".list-count").html(cartstatus);
            if(jQuery("#addWishlist2").is(":visible"))
              {
                jQuery('#addCart').css("display","block");
              }
              }
            });
      }
      plpStickyMenu();
      }
  });
}

var parseQueryString = function() {

  var str = window.location.search;
  var objURL = {};

  str.replace(
      new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
      function( $0, $1, $2, $3 ){
          objURL[ $1 ] = $3;
      }
  );
  return objURL;
}

function cancelOrderPopup()
{
cancelorderdialog.dialog("close");
jQuery('body').removeClass('stop-scrolling');
}
function confirmOrderPopup()
{
var targetUrl = jQuery(".confirmLink").attr("href");
jQuery.ajax({
      url: targetUrl,
      type: "POST",
      data: {},
      success: function(response) {
               var orderDetails = jQuery(response).find('#eCommerceMainPanel');
              jQuery('#eCommerceMainPanel').replaceWith(orderDetails);
     }
      });
      jQuery('body').removeClass('stop-scrolling');
      cancelorderdialog.dialog("close");
      return false;
}

function removeWishListProd(url)
{
jQuery.ajax({
      url: url,
      type: "POST",
      data: {},
      success: function(response) {
          var eCommerceShowWishList = jQuery(response).find('#eCommerceShowWishList');
      jQuery('#eCommerceShowWishList').replaceWith(eCommerceShowWishList);
      var wishListStatus=jQuery(response).find('#wishlistHeaderCount').find(".list-count");
          jQuery("#wishlistHeaderCount").find(".list-count").html(wishListStatus.html());
          jQuery("#wishlistCount").find(".list-count").html(wishListStatus.html());
          jQuery("#wishlistCountRes").find(".list-count").html(wishListStatus.html());
          if(jQuery("#emptyWishlist").hasClass("empty-wishlist") == true){
            jQuery(".showWishlistPreviousButton").css("display","none");
          }
     }
      });
     return false;
}

function createGuestUser(username,partyId){
var isValid=true;
var location=window.location.href;
jQuery.ajax({
          url : '/createGuestUser',
          type: "POST",
        data: {
                USERNAME : username,
                PASSWORD : 123456789
        },
        // beforeSend: function() {jQuery('body').append("<div class=facetLoyaltyAjaxImg></div>");},
          success: function(result, textStatus, jqXHR){
            jQuery.each(result, function(key, val){
            if(key == "_ERROR_MESSAGE_LIST_")
            {
                console.log("guest user already exists");
                isValid=false;
                return 1;
            }
              });//end of jQuery.each
            if(isValid) {
              jQuery.ajax({
                  url :"/createPersonAndUserLogin",
                  type:"POST",
                data:{
                    userLoginId: username,
                    currentPassword:123456789,
                    currentPasswordVerify:123456789,
                    partyId: partyId,
                    PHONE_MOBILE_CONTACT_OTHER:jQuery("input[name=phone]").val(),
                    dobLongMonthUs:10,
                    dobLongDayUs:31,
                    dobLongYearUs:1990
                },
                 success:function(data, textStatus, jqXHR)
                {
                 jQuery.each(data, function(property, value) {
                  if(property == "_ERROR_MESSAGE_"){
                    //document.getElementById("guestusrmessage").innerText=value;
                    console.log("guest user creation error : "+value);
                    isValid=false;
                    return 1;
                  }
                });
                if(isValid) {
                  //location.reload();
                  console.log("guest user created");
                  return 1;
                }
              }
              });
          }
        }
      });
      //jQuery('.facetLoyaltyAjaxImg').remove();
      return 1;
}
var mobile;
function signInCart()
   {
    jQuery("#guestusrmessage").empty();
    jQuery("#customerEmailid").val("");
    jQuery("#password3").val("");
    var wid=jQuery(window).width();
    //if(wid>1024){
      jQuery('body').addClass('stop-scrolling');
      jQuery("#signInGuestId").dialog(
      {modal: true,resizable:false,
        close: function(){
          jQuery('body').removeClass('stop-scrolling');
              }
      });
      document.getElementById("signInGuestId").style.display="block";
      var guest="guest";
      jQuery('<a  onclick="forgetPassword(guest);">Forgot Password?</a>').appendTo('#frgtPasswordId');
    /*}else{
      window.location.href="/signInGuestUser";
    }*/
    return false;
  }

  //Validating the mobile number and DOB
  function checkMobDob(primaryEmail){
  var url=window.location.href;
    var mobileChek = "/checkLoginInfoAvailable";
    jQuery.ajax({
      url :mobileChek,
      type:"POST",
      async:false,
      data: {
        email : primaryEmail
      },
      success:function(data, textStatus, jqXHR){
      if(!data.contactnumber || !data.dobDetails){
        window.location.href="/eCommerceEditCustomerInfo";
        return false;
      }
      if(jQuery("#loginStatusId").val()=='regular' ||jQuery("#loginStatusId").val()=='referral'){

        var isReferral =jQuery("#dialog").data('isReferral');
        if(isReferral== 'referral'){
          url=setGetParameter("isReferral","true");
        }
        var path=jQuery(location).attr('pathname');
        var actualpath=path.split(";");
        if(actualpath[0]=='/eCommerceOrderComplete'){
          window.location.href="/main?isReferral=true";
        }
        else{
          window.location.href=url;
        }
      }
      else{
        var path=jQuery(location).attr('pathname');
        var actualpath=path.split(";");
        if(actualpath[0]=='/eCommerceOrderComplete'){
          window.location.href="/main";
        }
        else{
          window.location.href="/eCommerceShowWishList";
        }
      }
    }
  });
  }

jQuery(document).ready(function(){
 jQuery(window).resize(function() {
    var pathName=jQuery(location).attr('pathname');
    if(pathName=='/eCommerceEditCustomerInfo'){
        var val=jQuery('#dobLongDayUs option:first-child').text();
        var l = /^[a-zA-Z]+$/;
          if (!l.test(val)) {
          jQuery('#dobLongDayUs, #dobLongMonthUs, #dobLongYearUs').bind('mousedown', function (event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                });
    jQuery('.dobDay').attr("readOnly", true);
    jQuery('.dobMonth').attr("readOnly", true);
    jQuery('.dobYear').attr("readOnly", true);
  }
  }

  try{
     if(window.location.href.indexOf("isReferral") > -1 )
     {
      openReferFrndDialog();
     }
    }catch(err){}


  try{
     if(window.location.href.indexOf("referredFrndSignup") > -1)
     {
       var referrerMail =getParameterByName('referrerMail');
       jQuery("#signInpopup").data('referrerMail',referrerMail);
       var referredMail =getParameterByName('referredMail');
       jQuery("#signInpopup").data('referredMail',referredMail);

       if(jQuery(window).width() > 1024)
       {
        jQuery("#signInpopup").dialog({
          modal : true,
          resizable : false,
          close : function() {
          }
        });
        document.getElementById("dialogSignUp").style.display = "block";
        document.getElementById("signup_pdp").style.display = "none";
        document.getElementById("signInpopup").style.display = "block";
        dateDropDownval()
       }else{
        jQuery('<form action="eCommerceNewCustomer"><input type="hidden" name="referralMail" value="'+referrerMail+'"/><input type="hidden" name="referredMail" value="'+referredMail+'"/></form>').appendTo("body")
        .submit().remove()
      }
      }
  }catch(err){}
}).resize();
});


function cartPromoPincodeEnter()
{
  jQuery(".cartPromoPincodeDiv").slideToggle('slow', function(){});
}

function cartPincodeSubmit(form,mode,value){
  jQuery("#pincodeMessageId").empty();
  var pincode = form.cartPincode.value;
  if (pincode == "") {
    jQuery(".cartPincodeMessageId").html("Please Enter the Pincode");
    return false;
  }else if (!jQuery.isNumeric(pincode)) {
    jQuery(".cartPincodeMessageId").html("Please enter Valid 6 digits Zipcode");
    return false;
  }else if (pincode.length != 6) {
      jQuery(".cartPincodeMessageId").html("Please Enter the Valid Pincode");
      return false;
    }else{
        var url = "/pincodeCheckSearch?pincode" + pincode;
        jQuery.ajax({
        url : url,
        type : "POST",
        data : {
          pincode : pincode
        },
        success : function(res, d, e) {
          if (res.COD == "Y") {
            jQuery(".cartPincodeMessageId").html("Pincode successfully applied.");
                        return false;
          } else {
            jQuery(".cartPincodeMessageId").html("Please Enter the Valid Pincode");
                        return false;
          }
        }
      });
    return false;
  }

}

function referFriend(){
      signInPopUp('referral');
      return false;
return false;
}

function openReferFrndDialog()
{   jQuery(".ReferMailsErrMsg").html("");
    jQuery("#referFrndMails").val("");
    if(jQuery(window).width() > 890){
      referFrndDialog = jQuery("#referFriendDialog").dialog({
      modal: true,
      resizable:false
      });
      referFrndDialog.dialog("open");
      }
}
function closeReferFrndDialog()
{
   if(jQuery(window).width() > 890){
  referFrndDialog.dialog("close");
  }else{

    referFrndDialog.dialog("close");
  }
}
function submitReferFrnd()
{ var emails=""
  var isvalidEmail=true;
 if(jQuery(window).width() > 890){
   jQuery(".mailsErrMsg").html("");
   var emails = jQuery("#referFrndMails").val();
   if(emails.length <= 0){
   jQuery(".ReferMailsErrMsg").html("Please enter a valid email address with comma seperated");
      isvalidEmail=false;
      return false;
   }
   var res = emails.split(",");
   var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   jQuery.each(res,function(index,mail){
    if (!filter.test(mail)) {
      jQuery(".ReferMailsErrMsg").html("Please enter a valid email address with comma seperated");
      isvalidEmail=false;
      return false;
    }
   });
   }else{
     jQuery(".ReferMailsErrMsgRes").html("");
     emails = jQuery("#referFrndMailRes").val();
     if(emails.length < 0){
     jQuery(".ReferMailsErrMsgRes").html("Please enter a valid email address with comma seperated");
        isvalidEmail=false;
        return false;
     }
     var res = emails.split(",");
     var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
     jQuery.each(res,function(index,mail){
      if (!filter.test(mail)) {
        jQuery(".ReferMailsErrMsgRes").html("Please enter a valid email address with comma seperated");
        isvalidEmail=false;
        return false;
      }
     });
   }
   var targetUrl = "/sendReferralInvite";
  var status=true;
  if(emails.length > 0 && isvalidEmail){
  jQuery.ajax({
        url: targetUrl,
        type: "POST",
        data: {userLoginId : userLoginId,mailIds:emails},
        success: function(response) {
            var referralStatus=response.mailIdStatus;
            if(referralStatus != 'undefined' && referralStatus != null && referralStatus.faildMails.length> 0){
            status=false;
             if(jQuery(window).width() > 1024){
            jQuery(".ReferMailsErrMsg").html(" Follwing Email ids are failed :" +referralStatus.faildMails);
            }else{
              jQuery(".ReferMailsErrMsgRes").html(" Follwing Email ids are failed :" +referralStatus.faildMails);
            }
            }
             if(status){
             if(jQuery(window).width() > 1024){
                referFrndDialog.dialog("close");
              }else{
               window.location.href="/";
              }
           }
       }
        });
        }
        return false;
}

function getParameterByName(name) {
    var url= window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

 function giftwrapMsgAll(cartLinedIndex){
    jQuery('body').addClass('stop-scrolling');
    jQuery("#giftwrapAllForCommon").dialog(
    {modal: true,resizable:false,
    close: function(){
        jQuery('body').removeClass('stop-scrolling');
              }
    });
    jQuery(".ui-dialog").addClass('giftmsgpopup');
    }


    function giftWrapSaveAll(v){
      var from=jQuery("#from_All").val();
      var to=jQuery("#to_All").val();
      var message = jQuery("#js_content_all").val();
      for(i = 0; i <= v; i++) {
      var index = jQuery("#cartLineIndexId" + i).val();
      var url = "/setGiftMessage?cartLineIndex=" + index + "&from_1=" + from + "&to_1="
      + to + "&giftMessageText_1=" + message;
    jQuery.ajax({
    url : url,
    type : "POST",
    success : function(i, g, h) {
      jQuery("#giftwrapIdxx123").dialog("close");
      jQuery("#giftMsgSpanId"+i).text("Edit Gift to Product");
    }
    })

    }
    location.reload();
  }


function unsubScribe(){
    jQuery("input[name='subscriptionType']:checkbox").prop('checked',false);
    document.forms["subscriptionForm"].submit();
}
var itemval;
  var postldetls;
  var citycode;
  var citydetls;
jQuery(document).ready(function() {
 /* SearchText();
  jQuery(".autosuggest").autocomplete({
    select:function(event, ui){
    console.log(event);
      itemval=ui.item.value;
      postldetls = itemval.split('-');
      if(isNaN( postldetls[0])){
      jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[3]);
    var stateISO=getStateValue(postldetls[2]);
    jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
    jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[1]);
    autoFill:false;
    return false;
}else{
    jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[0]);
    var stateISO=getStateValue(postldetls[3]);
    jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
    jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[2]);
    autoFill:false;
    return false;
}
    jQuery("#js_SHIPPING_POSTAL_CODE_NEW").removeClass();
          jQuery("#js_SHIPPING_POSTAL_CODE_NEW").addClass("autosuggest");
    }
  });*/

jQuery('.autosuggest').keypress(function (e) {
var key = e.which;
if(key == 13)
  {
    if(isNaN( postldetls[0])){
    jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[3]);
    var stateISO=getStateValue(postldetls[2]);
    jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
    jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[1]);
    autoFill:false;
    return false;
}else{
    jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[0]);
    var stateISO=getStateValue(postldetls[3]);
    jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
    jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[2]);
    autoFill:false;
    return false;
  }
  }
});


jQuery('.autosuggest').keydown(function(event){
  var keyCode = (event.keyCode ? event.keyCode : event.which);
    if(keyCode == 13){
        if(isNaN( postldetls[0])){
        jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[3]);
        var stateISO=getStateValue(postldetls[2]);
        jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
        jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[1]);
        autoFill:false;
        return false;
  }else{
      jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[0]);
      var stateISO=getStateValue(postldetls[3]);
      jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
      jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[2]);
      autoFill:false;
      return false;
    }
    }
});

});

/*(function SearchText() {
jQuery(".autosuggest").autocomplete({
  source: function(request, response) {
  var url;
  if(controlfocus=='pincode'){
    url="https://www.whizapi.com/api/v2/util/ui/in/indian-city-by-postal-code?pin="+ document.getElementById("js_SHIPPING_POSTAL_CODE_NEW").value + "&project-app-key=1uezklredknnej72z9n2ci7q";
  }
  if(controlfocus=='city'){
    url="https://www.whizapi.com/api/v2/util/ui/in/indian-postal-codes?search="+ document.getElementById('js_SHIPPING_CITY_NEW').value +"&project-app-key=1uezklredknnej72z9n2ci7q";
  }
jQuery.ajax({
  type: "POST",
  contentType: "application/json; charset=utf-8",
  url: url,
  dataType: "json",
  success: function(data) {
  console.log(data);
  var suggestions = [];
  jQuery.each(data, function (property, value){
        if(property == "Data"){
      var pincity;
      jQuery.each( value, function( key, value ) {
        if(controlfocus=='pincode'){
          pincity=value.Pincode+"-"+value.Address+"-"+value.City+"-"+value.State;
        }
        if(controlfocus=='city'){
          pincity=value.Address+"-"+value.City+"-"+value.State+"-"+value.Pincode;
        }
          suggestions.push(pincity);
      });
    }
  });
    response(suggestions);
  },
  error: function(result) {
  }
});
}
});
}*/

function pinFunction(){
var postlcode=jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val();
  var postldetls = postlcode.split('-');
  jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(postldetls[0]);
  var stateISO=getStateValue(postldetls[3]);
  jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
  jQuery("#js_SHIPPING_CITY_NEW").val(postldetls[2]);
}

function cityFunction(){
var citycode=jQuery("#js_SHIPPING_CITY_NEW").val();
  var citydetls = citycode.split('-');
  jQuery("#js_SHIPPING_POSTAL_CODE_NEW").val(citydetls[3]);
  var stateISO=getStateValue(citydetls[2]);
  jQuery("#js_SHIPPING_STATE_NEW").val(stateISO);
  jQuery("#js_SHIPPING_CITY_NEW").val(citydetls[1]);
}

function getStateValue(state){
var statecode;
    switch(state) {
        case "Andaman and Nicobar Islands":
            statecode = "IN-AN";
      break;
        case "Andhra Pradesh":
        statecode = "IN-AP";
      break;
        case "Arunachal Pradesh":
        statecode = "IN-AR";
      break;
        case "Assam":
        statecode = "IN-AS";
      break;
        case "Bihar":
        statecode = "IN-BR";
      break;
        case "Chandigarh":
        statecode = "IN-CH";
      break;
      case "Chhattisgarh":
        statecode = "IN-CT";
      break;
      case "Dadra and Nagar Haveli":
        statecode = "IN-DN";
      break;
      case "Daman and Diu":
        statecode = "IN-DD";
      break;
      case "Delhi":
        statecode = "IN-ND";
      break;
      case "Goa":
        statecode = "IN-GA";
      break;
        case "Gujarat":
        statecode = "IN-GJ";
      break;
      case "Haryana":
        statecode = "IN-HR";
      break;
      case "Himachal Pradesh":
        statecode = "IN-HP";
      break;
      case "Jammu and Kashmir":
        statecode = "IN-JK";
      break;
      case "Jharkhand":
        statecode = "IN-JH";
      break;
      case "Karnataka":
        statecode = "IN-KA";
      break;
      case "Kerala":
        statecode = "IN-KL";
      break;
      case "Lakshadweep":
        statecode = "IN-LD";
      break;
      case "Madhya Pradesh":
        statecode = "IN-MP";
      break;
      case "Maharashtra":
        statecode = "IN-MH";
      break;
    case "Manipur":
        statecode = "IN-MN";
      break;
      case "Meghalaya":
        statecode = "IN-ML";
      break;
      case "Mizoram":
        statecode = "IN-MZ";
      break;
      case "Nagaland":
        statecode = "IN-NL";
      break;
      case "Orissa":
        statecode = "IN-OR";
      break;
      case "Pondicherry":
        statecode = "IN-PY";
      break;
      case "Punjab":
        statecode = "IN-PB";
      break;
      case "Rajasthan":
        statecode = "IN-RJ";
      break;
      case "Sikkim":
        statecode = "IN-SK";
      break;
      case "Tamil Nadu":
        statecode = "IN-TN";
      break;
      case "Telangana":
        statecode = "IN-TG";
      break;
      case "Tripura":
        statecode = "IN-TR";
      break;
      case "Uttar Pradesh":
        statecode = "IN-UP";
      break;
      case "Uttarakhand":
        statecode = "IN-UT ";
      break;
      case "West Bengal":
        statecode = "IN-WB";
      break;
    }

return statecode;
}

var controlfocus;

function controlFocus(code){
controlfocus=code;
}
jQuery(document).on('click', '#pricefl', function(){
  var priceStatus=jQuery('#priceauto').val();
  if(priceStatus=='price-asc'){
    jQuery('#priceauto').val('price-desc');
    sortOrder('price-asc');
  }
  if(priceStatus=='price-desc'){
    jQuery('#priceauto').val('price-asc');
  sortOrder('price-desc');
  }
});

jQuery(document).on('click', '#disfl', function(){
    var discntStatus=jQuery('#discountauto').val();
    if(discntStatus=='dis-asc'){
      jQuery('#discountauto').val('dis-desc');
      sortOrder('leastDiscount-asc');
    }
    if(discntStatus=='dis-desc'){
      jQuery('#discountauto').val('dis-asc');
      sortOrder('highestDiscount-desc');
     }
});

jQuery(document).on('click', '#bstSelling', function(){
     sortOrder('totalQuantityOrdered-desc');
});

jQuery(document).on('click', '#newArrivals', function(){
    sortOrder('introductionDate-desc');
});



jQuery(window).on('resize', function(){

 if(jQuery(window).width() > 1024 ){

 jQuery(".referFrndInvite").css("display","none");
 jQuery("#friendHeader").css("display","none");
 jQuery("#referFrndMailRes").css("display","none");
 jQuery("#referbackbtn").css("display","none");
 jQuery("#refersendbtn").css("display","none")

 if(window.location.href.indexOf("referFriendInvite")> -1)
 {
  openReferFrndDialog();
 }

}





  var win = jQuery(this); //this = window
  if(win.width() > 1024)
  {
  jQuery("#ecommerceNavigationBar").css("display","block");
  jQuery("#iconSearch2").css("display","none");
   jQuery(".responseNavBar").css("display","none");
   jQuery("#stickylogo2").css("display","none");
  jQuery("#stickylogo").css("display","none");
  jQuery(".subCategoryNav").css("display","none");

  }
  else
  {
  jQuery("#ecommerceNavigationBar").css("display","none");
  jQuery("#iconSearch2").css("display","block");
   jQuery(".responseNavBar").css("display","block");
   jQuery("#stickylogo2").css("display","block");
  jQuery("#stickylogo").css("display","block");
  jQuery(".subCategoryNav").css("display","block");
    jQuery(".subCategoryNav").css("display","block");

  }

  if (win.width() >1024) {


    jQuery("#searchContainer").css("display","block");
  jQuery(".defaultDevice.logo").css("display","block");
  jQuery("#header-container").css("display","block");
  jQuery(".header-wrapper.navigationBarIcns").css("display","block");
  jQuery(".fixed-wishlist2").css("display","none");
  jQuery(".subCategoryNav").css("display","none");
  jQuery("#signIn_signUp2").css("display","none");
  jQuery("#addWishlist3").css("display","none");
  jQuery("#addCart2").css("display","none");



    scroller();
    var y = jQuery(window).scrollTop();
    if(y >=128){
  jQuery("#stickylogo").css("display","block");
    }
   }else{


    jQuery(".fixed-wishlist2").css("display","block");
    jQuery("#signIn_signUp2").css("display","block");
  jQuery("#addWishlist3").css("display","block");
  jQuery("#addCart2").css("display","block");
 //jQuery("#header-container").css("display","none");
  //jQuery("#searchContainer").css("display","none");
  //jQuery(".defaultDevice.logo").css("display","none");
  //jQuery(".header-wrapper.navigationBarIcns").css("display","none");
    console.log('below 1024 resolution');
    //jQuery(".quick-access").css("display","none");
    scroller();
  }
});

jQuery(window).on('resize', function(){


if((jQuery(window).width()<=560) && (jQuery(".user-pic").is(":visible")==true)) 
                { 
                        if(jQuery(window).width()<=500) 
                        { 
                                jQuery(".responsivelogo").css("left","37%"); 
                        } 
                        
                        if(jQuery(window).width()<=380) 
                        { 
                                jQuery(".responsivelogo").css("left","36%"); 
                        } 
        if(jQuery(window).width()<=340) 
                        { 
                                jQuery(".responsivelogo").css("left","34%"); 
                        } 
                }

    if((jQuery(window).width()>560) && (jQuery(window).width()<=570)){
        jQuery('.responsivelogo').css('left', '');
      }

  if(jQuery( window ).width() >768) {
    jQuery(".image.mainImage.pdpMainImage.thumb").css("display","block");
          jQuery(".PDP.group1 .pdpMainImage .bx-controls-direction").css("display","none");
          
  }
  else{
    jQuery(".image.mainImage.pdpMainImage.thumb").css("display","none");
          jQuery(".PDP.group1 .pdpMainImage .bx-controls-direction").css("display","block");
    }




});

function cancelOrderReturnPopup()
{
orderItemreturndialog.dialog("close");
jQuery('body').removeClass('stop-scrolling');
}

function confirmOrderReturnPopup(){
returnReason=jQuery("#returnteReason").val();
awbnumber=jQuery("#awbnumId").val();
if(awbnumber==""){    
   jQuery("#awbaError").html("Please Enter AWB Number");    
      
 }else{
orderItemreturndialog.dialog("close");
jQuery('body').removeClass('stop-scrolling');
  orderreItemturnsConfirm = jQuery("#orderreItemturnsConfirm").dialog({
  modal: true,
  resizable:false
  });
  orderreItemturnsConfirm.dialog("open");
}
}

function cancelReturnConfirm(){
orderreItemturnsConfirm.dialog("close");
jQuery('body').removeClass('stop-scrolling');
}
var orderreItemturnsConfirm;
var returnReason;
var awbnumber;
jQuery(document).ready(function (){
wishListContent=jQuery("#size-wrapper").html();
if(jQuery("#emptyWishlist").hasClass("empty-wishlist") == true){
jQuery(".showWishlistPreviousButton").css("display","none");
}
});
var wishListContent;
jQuery(document).ready(function(){
 jQuery(window).resize(function() {
if(wid>768){
jQuery(".standardBtn.addToCart.addCart_icon.inactiveAddToCart").css("display","none");
jQuery(".action.addToCart.plpAddToCart.plp_hover_addtocart").css("display","none");
jQuery(".standardBtn.addToWishlist.wList_icon.inactiveAddToWishlist").css("display","none");
jQuery(".plp_hover_addtowish.action.addToWishlist.plpAddToWishlist").css("display","none");

jQuery('.PLP').on( 'mouseover', function() {
jQuery(".standardBtn.addToCart.addCart_icon.inactiveAddToCart").css("display","block");
jQuery(".standardBtn.addToWishlist.wList_icon.inactiveAddToWishlist").css("display","block");
  var test=jQuery(this).find(".no-stock");
    if(test != undefined && test != null && !(test.length>0))
    {
     
     var currentEleId = jQuery(this).find('.image.thumbImage.plpThumbImage').attr('id');
     
    jQuery("#js_plpProductName_li_PLP_"+currentEleId).show();
      jQuery("#js_plpAddtoCart_licartbtn_PLP_"+currentEleId).show();
      jQuery("#js_addToWishlist_Wishlistbtn_PLP_"+currentEleId).show();
    }

  });

  jQuery('.PLP').on('mouseout',function(){
  var test=jQuery(this).find(".no-stock");
    if(test != undefined && test != null && !(test.length>0))
    {
     
     var currentEleId = jQuery(this).find('.image.thumbImage.plpThumbImage').attr('id');
    jQuery("#js_plpProductName_li_PLP_"+currentEleId).show();
      jQuery("#js_plpAddtoCart_licartbtn_PLP_"+currentEleId).hide();
      jQuery("#js_addToWishlist_Wishlistbtn_PLP_"+currentEleId).hide();

    }
    });


}
else{
jQuery(".standardBtn.addToCart.addCart_icon.inactiveAddToCart").css("display","block");
jQuery(".action.addToCart.plpAddToCart.plp_hover_addtocart").css("display","block");
jQuery(".standardBtn.addToWishlist.wList_icon.inactiveAddToWishlist").css("display","block");
jQuery(".plp_hover_addtowish.action.addToWishlist.plpAddToWishlist").css("display","block");
}

    jQuery("#mainLookBook").click(function(){
    // jQuery('body').html('<iframe src="http://www.globusstores.com/look-book-aw15/" width="100%" height="1024"></iframe>');
    //unloadScrollBars();
  window.location.href = 'http://localhost:8080/osafe_theme/lookbook/ethnic-wear.html';
    });
}).resize();
});




function unloadScrollBars() {
    document.documentElement.style.overflow = 'hidden';  // firefox, chrome
    document.body.scroll = "no"; // ie only
}


//check for Ajax login by Santhosh
  function popLogin(){
    jQuery( "#signupMessages").empty();
    jQuery( "#loginMessages").empty();
    jQuery( "#forgotAlert").empty();
    jQuery( "#emailErrorMsg").empty();
    jQuery( "#passwordErrorMsg").empty();

    var url;
    var email=jQuery("#returnCustomerEmail").val();
       var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var passwords=document.getElementById("password").value;

    if(document.getElementById("returnCustomerEmail").value ==""){
      document.getElementById("emailErrorMsg").innerText = "Please Enter your Email";
      return false;
    }
    if (!filter.test(email)) {
      document.getElementById("emailErrorMsg").innerText = "Please enter a valid email address";
      return false;
    }
    if(document.getElementById("password").value ==""){
      document.getElementById("passwordErrorMsg").innerText = "Please Enter your Password";
      return false;
    }
    if( passwords.length < 6){
      document.getElementById("passwordErrorMsg").innerText = "Password should be minimum 6 characters";
      return false;
    }
    if( passwords.length > 20){
      document.getElementById("passwordErrorMsg").innerText = "Password should be maximum 20 characters";
      return false;
    }
    var remmberMe="Y";
    var isRememberMe = document.getElementById("rememberMe").checked;
    if(!isRememberMe)
    {
    remmberMe="N";
    }
    var param = "USERNAME=" + document.getElementById("returnCustomerEmail").value + "&PASSWORD="+document.getElementById("password").value+"&rememberMe="+remmberMe;
    var isLogin = "True";
    //var x = document.URL;
    var x = encodeURIComponent(document.URL);
    var y = x.lastIndexOf("/");
    y=x.substring(0,x.lastIndexOf("/"));
    var requireChange;
    if(window.location.protocol == "https:"){
      url = "/AjaxLoginSec?"
    }
    else{
      url = "/AjaxLoginNonSec?"
    }

    jQuery.ajax({
          url : url,
          type: "POST",
        data: {
                USERNAME : document.getElementById("returnCustomerEmail").value,
                PASSWORD : document.getElementById("password").value,
                rememberMe: remmberMe
        },
          success: function(result, textStatus, jqXHR){
          jQuery.each(result, function(key, val){
            if(key == "_ERROR_MESSAGE_LIST_"){
              isLogin = "false";
              document.getElementById("loginMessages").innerHTML = val[0];
            }
            if(key == "requirePasswordChange"){
              isLogin = "false";
              requireChange = "Yes"
            }
            });//end of jQuery.each

      if(requireChange == "Yes"){
        //login object is created just reload page
        var form = document.getElementById('loginform');
        form.action = "/eCommerceRequirePasswordChange";
        //window.location=x.replace("#","")+"/eCommerceRequirePasswordChange?PASSWORD="+document.getElementById("password").value;
        form.submit();
      }

      var url = window.location.href;
      if(isLogin == "True"){
      var isReferral =jQuery("#dialog").data('isReferral');
      if(isReferral== 'referral'){
        url=setGetParameter("isReferral","true");
      }

      checkMobDob(email);
        if (window.location.href.indexOf("validateAnonCustomerEmail") > -1) {
           window.location.href="/eCommerceShowcart";
        }
        else{
          if (window.location.href.indexOf("/eCommerceOrderDetail") > -1) {
              location.href="/"
          }else{
              var path=jQuery(location).attr('pathname');
              if(path=='/coupons'){
              jQuery('<form action="main"></form>').appendTo('body').submit().remove();
              }
              else{

                try{
                  if(jQuery("#reviewSpanId").text().length>0){
                  url=setGetParameter("isReviewWindowShow","true");
                  }
                }catch(err){}

                /*if(jQuery("#loginStatusId").val()=='regular' ||jQuery("#loginStatusId").val()=='referral' ){
                  window.location.href=url;
                }else{
                  window.location.href=url;
                }*/
                window.location.href=url;

                }
              }
        }

      }
      var linkvalue =jQuery("#dialog").data('linkvalue');
      if(linkvalue == "TrackOrder") {
        //alert("trackvalue");
        var form = document.getElementById('loginform');
        form.action = "https://182.72.231.54:8443/eCommerceOrderHistory;jsessionid=4351F6958042874F07F529F681A87274.jvm1"
        form.submit();
      }

      if(linkvalue == "addPlpItemToWishlist") {
        var form = document.getElementById('productListForm');
        addWishListProdFromPDP("/",form);
      }
      if(linkvalue == "addPdpItemToWishlist") {
        var form = document.getElementById('productDetailForm');
        addWishListProdFromPDP("/",form);
      }
      }

    });
}

function addWishListProdFromPDP(url,form)
{
  jQuery.ajax({
        url: url,
        type: "POST",
        data: form.serialize(),
        success: function(response) {
       }
        });
       return false;
}

function writeAReview(event)
{

      jQuery("#subitReviewStatusId").css("display","none");
      document.getElementById('productReviewForm');
      jQuery("#writereviewtoggle").slideToggle('slow', function(){
         var status= jQuery("#writereviewtoggle").is(":visible");
       });
}


function clearAllReview(){


  jQuery("#subitReviewStatusId").css("display","none");
      document.getElementById('productReviewForm');
      jQuery("#writereviewtoggle").slideToggle('slow', function(){
         var status= jQuery("#writereviewtoggle").is(":visible");
       });
      jQuery(".error_msg_display").empty();
      jQuery(".ratingLegendValue").empty();
      jQuery(".ratingDisplayValue").empty();
      //jQuery("#overallRatingRow").empty();
      //ratingBar
      //jQuery(".bottom").empty();



}

function registeremail(){

  var form1 = document.getElementById('loginform1');

    form1.action = "/createPersonAndUserLogin"
        form1.submit();
}

function orderStatusTrack(){

     jQuery( "#trackorderMsg").empty();
     jQuery( "#trackorderEmailMsg").empty();
     var orderIdVal = document.getElementById("orderId").value;
     var emailIdVal = document.getElementById("emailId").value;
     var emailCheck = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

     if(orderIdVal ==""){
            document.getElementById("trackorderMsg").innerText = "Please enter your order id";
      return false;
     }else if(emailIdVal ==""){
            document.getElementById("trackorderEmailMsg").innerText = "Please enter your email id";
      return false;
     }else if(!emailCheck.test(emailIdVal)) {
      document.getElementById("trackorderEmailMsg").innerText = "Please enter a valid email address";
      return false;
   }else if(emailCheck.test(emailIdVal)){

        var trackOrderurl = "/eCommerceOrderDetail1";
       var status = "successurl";
          jQuery.ajax({
          url : trackOrderurl,
          type: "POST",
        data: {
                    orderId : orderIdVal,
                    emailId : emailIdVal
                },
            success: function(data, textStatus, jqXHR){
            if(data.response != "error"){
                  var form = document.getElementById('traid');
                form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
                form.method ="POST";
                form.submit();
                }else{
                    document.getElementById("trackorderMsg").innerText = "Email id or order id is invalid";
              return false;
                }
                if(erdata.indexOf(status) != -1){
            var form = document.getElementById('traid');
               form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
               form.method ="POST";
               form.submit();
                }else{
                  document.getElementById("trackorderMsg").innerText = "Email id or order id invalid";
              return false;
                }
          }
         });
   }else{
         var trackOrderurl = "/eCommerceOrderDetail?orderId="+orderIdVal;
         var status = "errormessagesucceful";
        jQuery.ajax({
        url : trackOrderurl,
        type: "POST",
        success: function(data, textStatus, jqXHR){
    var erdata=data;

    if(erdata.indexOf(status) != -1){
    var form = document.getElementById('traid');
       form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
       form.method ="POST";
       form.submit();
        }else{
        document.getElementById("trackorderMsg").innerText = "Please enter valid Order Id";
      return false;
        }
       }
    });
   }
 }


//check for Ajax login by Santhosh
  function popLogin(){
    jQuery( "#signupMessages").empty();
    jQuery( "#loginMessages").empty();
    jQuery( "#forgotAlert").empty();
    jQuery( "#emailErrorMsg").empty();
    jQuery( "#passwordErrorMsg").empty();

    var url;
    var email=jQuery("#returnCustomerEmail").val();
       var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var passwords=document.getElementById("password").value;

    if(document.getElementById("returnCustomerEmail").value ==""){
      document.getElementById("emailErrorMsg").innerText = "Please Enter your Email";
      return false;
    }
    if (!filter.test(email)) {
      document.getElementById("emailErrorMsg").innerText = "Please enter a valid email address";
      return false;
    }
    if(document.getElementById("password").value ==""){
      document.getElementById("passwordErrorMsg").innerText = "Please Enter your Password";
      return false;
    }
    if( passwords.length < 6){
      document.getElementById("passwordErrorMsg").innerText = "Password should be minimum 6 characters";
      return false;
    }
    if( passwords.length > 20){
      document.getElementById("passwordErrorMsg").innerText = "Password should be maximum 20 characters";
      return false;
    }
    var remmberMe="Y";
    var isRememberMe = document.getElementById("rememberMe").checked;
    if(!isRememberMe)
    {
    remmberMe="N";
    }
    var param = "USERNAME=" + document.getElementById("returnCustomerEmail").value + "&PASSWORD="+document.getElementById("password").value+"&rememberMe="+remmberMe;
    var isLogin = "True";
    //var x = document.URL;
    var x = encodeURIComponent(document.URL);
    var y = x.lastIndexOf("/");
    y=x.substring(0,x.lastIndexOf("/"));
    var requireChange;
    if(window.location.protocol == "https:"){
      url = "/AjaxLoginSec?"
    }
    else{
      url = "/AjaxLoginNonSec?"
    }

    jQuery.ajax({
          url : url,
          type: "POST",
        data: {
                USERNAME : document.getElementById("returnCustomerEmail").value,
                PASSWORD : document.getElementById("password").value,
                rememberMe: remmberMe
        },
          success: function(result, textStatus, jqXHR){
          jQuery.each(result, function(key, val){
            if(key == "_ERROR_MESSAGE_LIST_"){
              isLogin = "false";
              document.getElementById("loginMessages").innerHTML = val[0];
            }
            if(key == "requirePasswordChange"){
              isLogin = "false";
              requireChange = "Yes"
            }
            });//end of jQuery.each

      if(requireChange == "Yes"){
        //login object is created just reload page
        var form = document.getElementById('loginform');
        form.action = "/eCommerceRequirePasswordChange";
        //window.location=x.replace("#","")+"/eCommerceRequirePasswordChange?PASSWORD="+document.getElementById("password").value;
        form.submit();
      }

      var url = window.location.href;
      if(isLogin == "True"){
      var isReferral =jQuery("#dialog").data('isReferral');
      if(isReferral== 'referral'){
        url=setGetParameter("isReferral","true");
      }

      checkMobDob(email);
        if (window.location.href.indexOf("validateAnonCustomerEmail") > -1) {
           window.location.href="/eCommerceShowcart";
        }
        else{
          if (window.location.href.indexOf("/eCommerceOrderDetail") > -1) {
              location.href="/"
          }else{
              var path=jQuery(location).attr('pathname');
              if(path=='/coupons'){
              jQuery('<form action="main"></form>').appendTo('body').submit().remove();
              }
              else{

                try{
                  if(jQuery("#reviewSpanId").text().length>0){
                  url=setGetParameter("isReviewWindowShow","true");
                  }
                }catch(err){}

                /*if(jQuery("#loginStatusId").val()=='regular' ||jQuery("#loginStatusId").val()=='referral' ){
                  window.location.href=url;
                }else{
                  window.location.href=url;
                }*/
                window.location.href=url;

                }
              }
        }

      }
      var linkvalue =jQuery("#dialog").data('linkvalue');
      if(linkvalue == "TrackOrder") {
        //alert("trackvalue");
        var form = document.getElementById('loginform');
        form.action = "https://182.72.231.54:8443/eCommerceOrderHistory;jsessionid=4351F6958042874F07F529F681A87274.jvm1"
        form.submit();
      }

      if(linkvalue == "addPlpItemToWishlist") {
        var form = document.getElementById('productListForm');
        addWishListProdFromPDP("/",form);
      }
      if(linkvalue == "addPdpItemToWishlist") {
        var form = document.getElementById('productDetailForm');
        addWishListProdFromPDP("/",form);
      }
      }

    });
}

function addWishListProdFromPDP(url,form)
{
  jQuery.ajax({
        url: url,
        type: "POST",
        data: form.serialize(),
        success: function(response) {
       }
        });
       return false;
}

function writeAReview(event)
{

      jQuery("#subitReviewStatusId").css("display","none");
      document.getElementById('productReviewForm');
      jQuery("#writereviewtoggle").slideToggle('slow', function(){
         var status= jQuery("#writereviewtoggle").is(":visible");
       });
}


function clearAllReview(){


  jQuery("#subitReviewStatusId").css("display","none");
      document.getElementById('productReviewForm');
      jQuery("#writereviewtoggle").slideToggle('slow', function(){
         var status= jQuery("#writereviewtoggle").is(":visible");
       });
      jQuery(".error_msg_display").empty();
      jQuery(".ratingLegendValue").empty();
      jQuery(".ratingDisplayValue").empty();
      //jQuery("#overallRatingRow").empty();
      //ratingBar
      //jQuery(".bottom").empty();



}

function registeremail(){

  var form1 = document.getElementById('loginform1');

    form1.action = "/createPersonAndUserLogin"
        form1.submit();
}

function orderStatusTrack(){

     jQuery( "#trackorderMsg").empty();
     jQuery( "#trackorderEmailMsg").empty();
     var orderIdVal = document.getElementById("orderId").value;
     var emailIdVal = document.getElementById("emailId").value;
     var emailCheck = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

     if(orderIdVal ==""){
            document.getElementById("trackorderMsg").innerText = "Please enter your order id";
      return false;
     }else if(emailIdVal ==""){
            document.getElementById("trackorderEmailMsg").innerText = "Please enter your email id";
      return false;
     }else if(!emailCheck.test(emailIdVal)) {
      document.getElementById("trackorderEmailMsg").innerText = "Please enter a valid email address";
      return false;
   }else if(emailCheck.test(emailIdVal)){

        var trackOrderurl = "/eCommerceOrderDetail1";
       var status = "successurl";
          jQuery.ajax({
          url : trackOrderurl,
          type: "POST",
        data: {
                    orderId : orderIdVal,
                    emailId : emailIdVal
                },
            success: function(data, textStatus, jqXHR){
            if(data.response != "error"){
                  var form = document.getElementById('traid');
                form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
                form.method ="POST";
                form.submit();
                }else{
                    document.getElementById("trackorderMsg").innerText = "Email id or order id is invalid";
              return false;
                }
                if(erdata.indexOf(status) != -1){
            var form = document.getElementById('traid');
               form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
               form.method ="POST";
               form.submit();
                }else{
                  document.getElementById("trackorderMsg").innerText = "Email id or order id invalid";
              return false;
                }
          }
         });
   }else{
         var trackOrderurl = "/eCommerceOrderDetail?orderId="+orderIdVal;
         var status = "errormessagesucceful";
        jQuery.ajax({
        url : trackOrderurl,
        type: "POST",
        success: function(data, textStatus, jqXHR){
    var erdata=data;

    if(erdata.indexOf(status) != -1){
    var form = document.getElementById('traid');
       form.action = "https://182.72.231.54:8443/eCommerceOrderDetail;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
       form.method ="POST";
       form.submit();
        }else{
        document.getElementById("trackorderMsg").innerText = "Please enter valid Order Id";
      return false;
        }
       }
    });
   }
 }

jQuery(document).ready(function(){
 jQuery(window).resize(function() {
    dateDropDownval();
    }).resize();
  });

  function dateDropDownval()
  {
  jQuery('#dobLongMonthUs').empty();
  jQuery('#dobLongMonthUs').append(jQuery('<option />').val("").html("Month"));
  jQuery('#dobLongDayUs').empty();
  jQuery('#dobLongDayUs').append(jQuery('<option />').val("").html("Day"));
  jQuery('#dobLongYearUs').empty();
  jQuery('#dobLongYearUs').append(jQuery('<option />').val("").html("Year"));
  
  for (i = 1; i <=12; i++) {
      var tempStr = "";
      if(i<10){
        tempStr = "0"+i;
      } else{
        tempStr = ""+i;
      }
      jQuery('#dobLongMonthUs').append(jQuery('<option />').val(tempStr).html(tempStr));
    }

    for (i = 1; i <=31; i++) {
      var tempStr = "";
      if(i<10){
        tempStr = "0"+i;
      } else{
        tempStr = ""+i;
      }
      jQuery('#dobLongDayUs').append(jQuery('<option />').val(tempStr).html(tempStr ));
    }
    for (var currentYear = (new Date).getFullYear()-18; currentYear >=1920; currentYear--) {
      jQuery('#dobLongYearUs').append(jQuery('<option />').val(currentYear).html(currentYear));
    }
  }

function submitLightBoxCheckoutForm(form, mode, value) 
{
    if (mode == "VDN") {
                    if (validateCart()) {
            form.action="https://182.72.231.54:8443/checkout;jsessionid=4351F6958042874F07F529F681A87274.jvm1";
          form.submit();
        }
    }
}

function popupError(){

jQuery( "#emailErrorMsg").empty();
jQuery( "#passwordErrorMsg").empty();



}


jQuery(document).ready(function ()
    {

    if(jQuery(window).width() < 750){
      jQuery(".footer-links").css("display","none");
    }else{
      jQuery(".removeFooterLinks").each(function(){jQuery(this).css("display","none")});;
      jQuery(".footer-links").css("display","block");
    }

    jQuery(".topLevel.topCatalogLi").mouseover(function(){
        jQuery(this).find("ul").css("display","block");
      jQuery(this).find(".mainDiv").css("display","block");
      jQuery(this).find(".imgDivClass").remove();
      var subUlDiv=jQuery(this).find(".subUlDiv");
      var str='<div class="imgDivClass">'+jQuery(this).find(".menuimgDiv").html()+'</div>';
      // jQuery(str).insertAfter(subUlDiv);
    });
  jQuery(".topLevel.topCatalogLi").mouseout(function(){
    jQuery(this).find(".mainDiv").css("display","none");
    jQuery(this).find("ul").css("display","none");
    jQuery(this).find(".imgDivClass").remove();
    });

   jQuery(document).scroll(function() {
      jQuery("#searchAutoCompleteSticky").html("");
      jQuery("#searchTextSticky").val("");
    });

  var autoSuggestionList = [""];
        jQuery(function()
        {
           //  jQuery("#searchTextSticky").autocomplete({source: autoSuggestionList});
        });

        jQuery("#searchTextSticky").bind("keyup.autocomplete", function(e)
        {
            var keyCode = e.keyCode;
            if(keyCode != 40 && keyCode != 38)
            {
              var searchText = jQuery(this).attr('value');
              if(searchText.length >= 1){
               jQuery("#searchTextSticky").autocomplete({
                source: function(request, response) {
                        searchText = jQuery("#searchTextSticky").attr('value');
                    jQuery.ajax({
                        url: "/findAutoSuggestions?searchText="+searchText+"",
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                        jQuery("#searchAutoCompleteSticky").html("<ul>");
                        if(data.autoSuggestionList != null)
                        {
                              jQuery.each( data.autoSuggestionList, function(i,item ) {
                              var itemDtls=item.split("#");
                    var searchProd="<li class=''>"+
                  "<a href='/eCommerceProductDetail?productId="+itemDtls[1]+"&productCategoryId="+itemDtls[4]+"' class='table autolink'>"+
                  "<div class='table-cell pl-10'>"+
                  "<span class='autosuggest_prod_name'>"+itemDtls[2]+"</span><br/><span class='autosugges_price'> Rs "+itemDtls[3]+
                  "</span></div><div class='searchImg'><img width='100px' src='"+itemDtls[0]+"' alt='"+itemDtls[2]+"'/></div></a></li>";
                  jQuery("#searchAutoCompleteSticky ul").append(searchProd);
                  });
                        }
                        else
                        {
                            jQuery("#searchAutoCompleteSticky").html("");
                        }

                    }

                }); //end of jQuery AJAX
          }, //end of SOURCE
          minLength: 0
          });
         } else
                    {
                        jQuery("#searchAutoCompleteSticky").html("");
                    }
        }

    });
});




jQuery("#addWishlist2").click(function(){
 jQuery('<form action="eCommerceShowWishList"></form>').appendTo('body').submit().remove();

});
jQuery("#addWishlist3").click(function(){
 jQuery('<form action="eCommerceShowWishList"></form>').appendTo('body').submit().remove();

});




jQuery(window).on('resize', function(){
jQuery(".footer-links").css("display","block");


  if(jQuery(window).width() < 750){
  jQuery(".removeFooterLinks").each(function(){jQuery(this).css("display","block")});;
      jQuery(".footer-links").css("display","none");
    }else{
      // jQuery(".removeFooterLinks").each(function(){jQuery(this).css("display","none")});;
      jQuery(".footer-links").css("display","block");
    }
    jQuery(".topLevel.topCatalogLi").mouseover(function(){
        jQuery(this).find("ul").css("display","block");
      jQuery(this).find(".mainDiv").css("display","block");
      jQuery(this).find(".imgDivClass").remove();
      var subUlDiv=jQuery(this).find(".subUlDiv");
      var str='<div class="imgDivClass">'+jQuery(this).find(".menuimgDiv").html()+'</div>';
      // jQuery(str).insertAfter(subUlDiv);
    });
  jQuery(".topLevel.topCatalogLi").mouseout(function(){
    jQuery(this).find(".mainDiv").css("display","none");
    jQuery(this).find("ul").css("display","none");
    jQuery(this).find(".imgDivClass").remove();
    });

    jQuery(document).scroll(function() {
      jQuery("#searchAutoCompleteSticky").html("");
      jQuery("#searchTextSticky").val("");
    });

  var autoSuggestionList = [""];
        jQuery(function()
        {
           // jQuery("#searchTextSticky").autocomplete({source: autoSuggestionList});
        });

        jQuery("#searchTextSticky").bind("keyup.autocomplete", function(e)
        {
            var keyCode = e.keyCode;
            if(keyCode != 40 && keyCode != 38)
            {
              var searchText = jQuery(this).attr('value');
              if(searchText.length >= 1){
               jQuery("#searchTextSticky").autocomplete({
                source: function(request, response) {
                        searchText = jQuery("#searchTextSticky").attr('value');
                    jQuery.ajax({
                        url: "/findAutoSuggestions?searchText="+searchText+"",
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                        jQuery("#searchAutoCompleteSticky").html("<ul>");
                        if(data.autoSuggestionList != null)
                        {
                              jQuery.each( data.autoSuggestionList, function(i,item ) {
                              var itemDtls=item.split("#");
                    var searchProd="<li class=''>"+
                  "<a href='/eCommerceProductDetail?productId="+itemDtls[1]+"&productCategoryId="+itemDtls[4]+"' class='table autolink'>"+
                  "<div class='table-cell pl-10'>"+
                  "<span class='autosuggest_prod_name'>"+itemDtls[2]+"</span><br/><span class='autosugges_price'> Rs "+itemDtls[3]+
                  "</span></div><div class='searchImg'><img width='100px' src='"+itemDtls[0]+"' alt='"+itemDtls[2]+"'/></div></a></li>";
                  jQuery("#searchAutoCompleteSticky ul").append(searchProd);
                  });
                        }
                        else
                        {
                            jQuery("#searchAutoCompleteSticky").html("");
                        }

                    }

                }); //end of jQuery AJAX
          }, //end of SOURCE
          minLength: 0
          });
         } else
                    {
                        jQuery("#searchAutoCompleteSticky").html("");
                    }
        }

    });


if(jQuery(window).width() < 750){
    jQuery(".footer-links").css("display","none");
   var els = document.querySelectorAll('.footerSecMainDiv');
    for (var i=1; i <= els.length; i++) {
    jQuery("#footerSecDiv"+i).css("display","none");
      jQuery("#plusIcon"+i).css("display","block");
      var clickStr='javascript:toggleFilter("footerSecDiv'+i+'",'+'"plusIcon'+i+'")';
      els[i-1].setAttribute("onClick",clickStr );
    }
   }
   else{

   var els = document.querySelectorAll('.footerSecMainDiv');
    for (var i=1; i <= els.length; i++) {
    jQuery("#footerSecDiv"+i).css("display","block");
      jQuery("#plusIcon"+i).css("display","none");

    }
   jQuery(".footer-links").css("display","block");
   }

  function toggleFilter(id,plusIcon)
  {
    jQuery("#"+id).slideToggle('slow', function(){
      pricestatus= jQuery("#"+id).is(":visible");

     if(pricestatus==true){
     jQuery('#'+plusIcon).addClass('shpcatgryplus_off1');
     jQuery('#'+plusIcon).removeClass('shpcatgryplus_on1');
       }
     if(pricestatus==false){
     jQuery('#'+plusIcon).addClass('shpcatgryplus_on1');
     jQuery('#'+plusIcon).removeClass('shpcatgryplus_off1');
     }
     })
  }

});


  jQuery('body').bind('wheel mousewheel', function(e) {
    if(jQuery(".facetFilterAjaxImg").is(":visible")){
      return false;
    }
});


var width=jQuery(window).width();
/*function validateEmail(){
  jQuery("#errMsgI5").empty();
  var email=jQuery("#newsletter").val();
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(email == 'Enter your Email Address'){
            document.getElementById("errMsgI5").innerHTML = "Please enter your email id";
      return false;
    }else if(!filter.test(email)) {
      document.getElementById("errMsgI5").innerHTML = "Please enter a valid email address";
      return false;
  }
}*/
jQuery('#subscribeMail').on('click', function() {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var email=jQuery("#newsletter").val();
  if(email == 'Enter your Email Address'){
    if(width <= 414){
    jQuery("#errMsgForRes").html('Please enter your email id');
    }else{
    jQuery("#errMsgI5").html('Please enter your email id');
    }
    return;
  }else if(!filter.test(email)){
    if(width <= 414){
    jQuery("#errMsgForRes").html('Please enter your email id');
    }else{
    jQuery("#errMsgI5").html('Please enter your email id');
    }
    return;
  }else{
    jQuery.ajax({
       url: '/subscriberNew',
       data : {
        emailID : jQuery('#newsletter').val()
       },
       success: function(data) {
          jQuery("#errMsgI5").html('Thanks for subscribing.We shall update you about new offers etc');

       },
       error: function(data) {
         console.log(data);
         jQuery('#errMsgI5').html('<p>An error has occurred. Please subscribe once again</p>');
       },
      type: 'GET'
    });
  }
});
     <!-- added by venkat vazza for  footer copy right syear dynamic -->
jQuery(document).ready(function ()
    {
     jQuery('.current-year').html((new Date).getFullYear());
   
   var size=jQuery(window).width();
   if(size < 737){
   var els = document.querySelectorAll('.footerSecMainDiv');
    for (var i=1; i <= els.length; i++) {
    jQuery("#footerSecDiv"+i).css("display","none");
      jQuery("#plusIcon"+i).css("display","block");
      var clickStr='javascript:toggleFilter("footerSecDiv'+i+'",'+'"plusIcon'+i+'")';
      els[i-1].setAttribute("onClick",clickStr );
    }   
   }
    });
  
  
  function toggleFilter(id,plusIcon)
  {
    jQuery("#"+id).slideToggle('slow', function(){
      pricestatus= jQuery("#"+id).is(":visible");

     if(pricestatus==true){
     jQuery('#'+plusIcon).addClass('shpcatgryplus_off1');
     jQuery('#'+plusIcon).removeClass('shpcatgryplus_on1');
       }
     if(pricestatus==false){
     jQuery('#'+plusIcon).addClass('shpcatgryplus_on1');
     jQuery('#'+plusIcon).removeClass('shpcatgryplus_off1');
     }
     })
  }
    


    function replaceDetailImage(largeImageUrl, detailImageUrl)
    {
        if (!jQuery('#mainImages').length)
        {
            var mainImages = jQuery('#js_mainImageDiv').clone();
            jQuery(mainImages).find('img.js_productLargeImage').attr('id', 'js_mainImage');
            jQuery('#js_productDetailsImageContainer').html(mainImages.html());
            jQuery('#js_seeMainImage a').attr("href", "javascript:replaceDetailImage('"+largeImageUrl+"', '"+detailImageUrl+"');");
        }
            var mainImages = jQuery('#js_mainImageDiv').clone();
            jQuery(mainImages).find('img.js_productLargeImage').attr('id', 'js_mainImage');
            jQuery(mainImages).find('img.js_productLargeImage').attr('src', largeImageUrl+ "?" + new Date().getTime());
            jQuery(mainImages).find('a').attr('class', 'innerZoom');
            if(detailImageUrl != "")
            {
              jQuery(mainImages).find('a').attr('href', detailImageUrl);
            }
            else
            {
                jQuery(mainImages).find('a').attr('href', 'javaScript:void(0);');
            }
            jQuery('#js_productDetailsImageContainer').html(mainImages.html());
            activateZoom(detailImageUrl);

        if (document.images['js_mainImage'] != null)
        {
            var detailimagePath;
            document.getElementById("js_mainImage").setAttribute("src",largeImageUrl);
            if(document.getElementById('js_largeImage'))
            {
                setDetailImage(detailImageUrl);
            }
            document.getElementById("js_mainImage").setAttribute("class","js_productLargeImage");
            detailimagePath = "javascript:displayDialogBox('largeImage_')";
            if (jQuery('#js_mainImageLink').length)
            {
                jQuery('#js_mainImageLink').attr("href",detailimagePath);
            }
        }
    }

    function activateZoom(imgUrl)
    {
        if (typeof imgUrl == "undefined" || imgUrl == "NULL" || imgUrl == "")
        {
            return;
        }
        var image = new Image();
        image.src = imgUrl+ "?" + new Date().getTime();
        image.onerror = function ()
        {
            jQuery('.innerZoom').attr('href', 'javaScript:void(0);');
            return false;
        };
        image.onload = function ()
        {
            jQuery('.innerZoom').jqzoom(zoomOptions);
        };

    }

    function activateInitialZoom()
    {
        jQuery('.innerZoom').each(function()
        {
            var elm = this;
            var image = new Image();
            image.src = this.href+ "?" + new Date().getTime();
            image.onerror = function ()
            {
                jQuery(elm).attr('href', 'javaScript:void(0);');
                return false;
            };
            image.onload = function ()
            {
                jQuery('.innerZoom').jqzoom(zoomOptions);
            };
        });
    }

    var zoomOptions = {
        zoomType: 'innerzoom',
        lens:true,
        preloadImages: true,
        preloadText: ''
    };

    jQuery(document).ready(function() {
      jQuery('#mainAddImageLink').click();
    });


    function addCheckedClass(liId){
    if(jQuery("#"+liId).find('input[type=checkbox]:checked').is(':checked')){
                 jQuery("#"+liId).addClass("selected");
        }else{
                 jQuery("#"+liId).removeClass("selected");
        }
    
    }
    jQuery(document).ready(function (){ 
    if(wid>=736){
    jQuery('#responsiveslectResults').css("display", "none");
    jQuery('#sortId').css("display", "none");
    jQuery('#filtId').css("display", "none");
    
    }
    else{
    jQuery('#sortId').css("display", "block");
    jQuery('#filtId').css("display", "block");
    jQuery('#selectResultId').css("display", "none");
    jQuery('#filtersId').css("display", "none");
    jQuery('#eCommerceLeftPanel').css("display", "none");
    jQuery('#selectResultId').css("display", "none");
    jQuery('#sortByLable').css("display", "none");
    }
    
          jQuery("#filter_clear,#filter_clear2,#filter_clear_price,#filter_clear_tar_1, #filter_clear_tar_2, #filter_clear_tar_3, #filter_clear_tar_4, #filter_clear_tar_5, #filter_clear_tar_6").css("display", "none");
          jQuery("#js_toggle_tar_1 label").removeClass("selected");
        
       
        });
    
      <!-- clear filters added by venkat -->
    
      <!---unchecked check box for all-->
    
    function filters_clear(){
              if(jQuery('#js_toggle_tarwc_1').find('input[type=checkbox]:checked').is(':checked') || jQuery('#pricetarId').find('input[type=checkbox]:checked').is(':checked')
                     || jQuery('#js_toggle_tarwc_2').find('input[type=checkbox]:checked').is(':checked') || jQuery('#js_toggle_tarwc_3').find('input[type=checkbox]:checked').is(':checked')
                     || jQuery('#js_toggle_tarwc_4').find('input[type=checkbox]:checked').is(':checked') || jQuery('#js_toggle_tarwc_5').find('input[type=checkbox]:checked').is(':checked')
                     || jQuery('#js_toggle_tarwc_6').find('input[type=checkbox]:checked').is(':checked')){
    
                 jQuery("#filter_clear").css("display", "block");
                 jQuery("#filter_clear2").css("display", "block");
            }else{
                     jQuery("#filter_clear").css("display", "none");
                      jQuery("#filter_clear2").css("display", "none");
            }
    
        if(jQuery('#pricetarId').find('input[type=checkbox]:checked').is(':checked')){
                 jQuery("#filter_clear_price").css("display", "block");
        }else{
                 jQuery("#filter_clear_price").css("display", "none");
        }
        if(jQuery('#js_toggle_tarwc_1').find('input[type=checkbox]:checked').is(':checked')){
                 jQuery("#filter_clear_tar_1").css("display", "block");
                 jQuery('label:has(input:checked)').addClass('selected');
        }else{
                 jQuery("#filter_clear_tar_1").css("display", "none");
                 jQuery('label:has(input:checked)').removeClass('selected');
        }
        for (i = 2; i <=6; i++) {
          if(jQuery('#js_toggle_tarwc_'+i).find('input[type=checkbox]:checked').is(':checked')){
                   jQuery("#filter_clear_tar_"+i).css("display", "block");
          }else{
                   jQuery("#filter_clear_tar_"+i).css("display", "none");
          }
        }
        
        <!---clear div added by veeraprasad start--->
        
         if(jQuery("#topFiltersId").children().length <= 0){
              jQuery("#topFiltersId").hide();
          }
          
          <!---clear div added by veeraprasad ended--->
    }
    
    
    
    
    <!---clear filter added by venkat ended--->
    
    
    
    
    
    function toggleFilter(id,plusIcon)
    {
      jQuery("#"+id).slideToggle('slow', function(){
        pricestatus= jQuery("#"+id).is(":visible");
    
       if(pricestatus==true){
       jQuery('#'+plusIcon).addClass('shpcatgryplus_off');
       jQuery('#'+plusIcon).removeClass('shpcatgryplus_on');
         }
       if(pricestatus==false){
       jQuery('#'+plusIcon).addClass('shpcatgryplus_on');
       jQuery('#'+plusIcon).removeClass('shpcatgryplus_off');
       }
       })
    }
    
    
    jQuery(window).on('resize', function(){
    var winwidth=jQuery(window ).width();
          if(jQuery.support.mozilla)
          {
            winwidth=736;
          }
          else
          {
          winwidth=727;
          } 
    
    if(jQuery('#ecommerceNavigationBar').css("display") == "block"){
        jQuery('.responsivelogo').css("display", "none");
        jQuery('.togglemenu').css("display", "none");
      }else{
        jQuery('.responsivelogo').css("display", "block");
        jQuery('.togglemenu').css("display", "block");
      }
    
      if(jQuery(window ).width()>=winwidth){  
    jQuery("#eCommerceLeftPanel").css("display", "block");
    jQuery('#sortId').css("display", "none");
    jQuery('#sortByLable').css("display", "none");
    jQuery('#selectResultId').css("display", "block");
    jQuery('#filtId').css("display", "none");   
      if(jQuery(".ui-dialog").is(":visible") == true){ 
          jQuery("#eCommerceLeftPanel").dialog("close");
          jQuery("#eCommerceLeftPanel").css("width","");
      }   
    }
    else{
    
    jQuery("#eCommerceLeftPanel").hide();
       if(jQuery(".ui-dialog").is(":visible") == true){ 
        jQuery('#eCommerceLeftPanel').css("display", "block");
      }
    jQuery('#selectResultId').css("display", "none");
    jQuery('#filtId').css("display", "block");
    jQuery('#sortId').css("display", "block");
    
    }
    });
    
    function idToTopFilter(elm,id){
    var facetvalue=elm.id;
      var facetId=facetvalue.split("_");
      var id=facetId[1]+"_"+facetId[2]
    
    jQuery("#"+id).attr('checked', false).triggerHandler('click');
    
    if (!(jQuery('#topFiltersId').is(':empty'))){
    if(jQuery('#topFiltersId').children('p').size() == "0"){
    jQuery('#topFiltersId').css({ 'display': "none" });
    }else{
    jQuery("#"+id).css({ 'display': "none" });
    }
    }
    }

      var detailImageUrl = null;
      function setAddProductIdPlp(name, selectFeatureDiv)
      {
      jQuery('#'+selectFeatureDiv+"_add_product_id").val(name);
      if(jQuery('#js_plp_qty_'+selectFeatureDiv).val() == null) return;
      }
      function setProductStockPlp(name, selectFeatureDiv)
      {
      var elm = document.getElementById("js_plpAddtoCart_"+selectFeatureDiv);
      if(VARSTOCK[name]=="outOfStock")
      {
          elm.setAttribute("onClick","javascript:void(0)");
          jQuery('#js_plpAddtoCart_'+selectFeatureDiv).addClass("inactiveAddToCart");
      }
      else
      {
          jQuery('#js_plpAddtoCart_'+selectFeatureDiv).removeClass("inactiveAddToCart");
         // elm.setAttribute("onClick","javascript:addItemPlpToCart('"+ selectFeatureDiv+"')");
      }
      var elm = document.getElementById("js_addToWishlist_"+selectFeatureDiv);
      if (elm !=null )
      {
         // elm.setAttribute("onClick","javascript:addItemPlpToWishlist('"+ selectFeatureDiv+"')");
        //jQuery('#js_addToWishlist_'+selectFeatureDiv).removeClass("inactiveAddToWishlist");
      }
      
      checkProductInStorePlp(VARINSTORE[name], selectFeatureDiv);
      
      }
      
      function checkProductInStorePlp(value,selectFeatureDiv)
      {
      if(value !=null && value=="Y")
      {
          if (jQuery('#js_plpPdpInStoreOnlyLabel_'+selectFeatureDiv).length)
          {
              jQuery('#js_plpPdpInStoreOnlyLabel_'+selectFeatureDiv).show();
          }
          if (jQuery('#js_plp_div_qty_'+selectFeatureDiv).length)
          {
              jQuery('#js_plp_div_qty_'+selectFeatureDiv).hide();
          }
          if (jQuery('#js_plpAddtoCart_div_'+selectFeatureDiv).length)
          {
              jQuery('#js_plpAddtoCart_div_'+selectFeatureDiv).hide();
          }
          if (jQuery('#js_addToWishlist_div_'+selectFeatureDiv).length)
          {
              jQuery('#js_addToWishlist_div_'+selectFeatureDiv).hide();
          }
      }
      else
      {
          if (jQuery('#js_plpPdpInStoreOnlyLabel_'+selectFeatureDiv).length)
          {
              jQuery('#js_plpPdpInStoreOnlyLabel_'+selectFeatureDiv).hide();
          }
          if (jQuery('#js_plp_div_qty_'+selectFeatureDiv).length)
          {
              jQuery('#js_plp_div_qty_'+selectFeatureDiv).show();
          }
          if (jQuery('#js_plpAddtoCart_div_'+selectFeatureDiv).length)
          {
              jQuery('#js_plpAddtoCart_div_'+selectFeatureDiv).show();
          }
          if (jQuery('#js_addToWishlist_div_'+selectFeatureDiv).length)
          {
              jQuery('#js_addToWishlist_div_'+selectFeatureDiv).show();
          }
      }
      }
      
      function addItemPlpToCart(selectFeatureDiv)
      {
      var selectedValue;
      jQuery('#FTCOLOR_'+selectFeatureDiv+' option').each(function(){
      selectedValue=  jQuery(this).val();
      });
      if(selectedValue == undefined || selectedValue == null ||selectedValue.length<=0){
      selectedValue=selectedOptionValue;
      }
      jQuery('#'+selectFeatureDiv+'_add_product_id').val(selectedValue);
      
      if(isItemSelectedPlp(selectFeatureDiv))
      {
         var quantity = Number(1);
         if(jQuery('#js_plp_qty_'+selectFeatureDiv).length)
         {
            var quantitiyValue = jQuery('#js_plp_qty_'+selectFeatureDiv).val();
            if(quantitiyValue != "")
            {
              quantity = quantitiyValue;
            }
         }
         var add_product_id = jQuery('#'+selectFeatureDiv+"_add_product_id").val();
         var productName = jQuery('#'+selectFeatureDiv+"_add_product_name").val();
         var add_category_id = jQuery('#'+selectFeatureDiv+"_add_category_id").val();
      
         jQuery('#plp_add_product_id').val(add_product_id);
         jQuery('#plp_qty').val(quantity);
         jQuery('#plp_add_category_id').val(add_category_id);
      
      if(isQtyWhole(quantity,productName))
      {
        if(!(isQtyZero(quantity,productName,add_product_id)))
        {
            quantity = Number(quantity) + Number(getQtyInCart(add_product_id));
      
            if(validateQtyMinMax(add_product_id,productName,quantity))
            {
             recurrenceIsChecked = jQuery('#js_pdpPriceRecurrenceCB').is(":checked");
             if(recurrenceIsChecked)
             {  plpStickyMenu();
                    //document.productListForm.action="/";
                     var ifCarturl="/"+"?plp_add_product_id="+add_product_id+"&plp_qty="+jQuery('#plp_qty').val();
                     alert("ifCarturl...:"+ifCarturl);
                    jQuery.get(ifCarturl, function(data){
                    var cartstatus = jQuery(data).find('#siteShoppingCart');
                    jQuery('#siteShoppingCart').replaceWith(cartstatus);
                  });
             }
             else {
                    //document.productListForm.action="/addPlpItemToCart";
                    var elseCarturl="/addPlpItemToCart"+"?plp_add_product_id="+add_product_id+"&plp_qty="+jQuery('#plp_qty').val()+"&productCategoryId=520";
                      jQuery.get(elseCarturl, function(data)
              {
                   var cartstatus = jQuery(data).find('#addCartlist').find(".list-count").html();
                  jQuery('#addCartlist').find(".list-count").html(cartstatus);
                  jQuery('#addCart').find(".list-count").html(cartstatus);
                  jQuery('#addCart2').find(".list-count").html(cartstatus);
                  var lightCartDialog=jQuery(data).find('#lightCart_displayDialog');
            jQuery('#lightCart_displayDialog').replaceWith(lightCartDialog);
      
                  displayLightDialogBox('lightCart_');
                        var dialogHolder = jQuery('#lightCart_displayDialog').parent();
                        jQuery(dialogHolder).hide();
                        jQuery('.ui-dialog.ui-widget.globular-ui-widget-content.ui-corner-all.ui-draggable.lightCart_displayDialog').css('display', 'none');
      
                        plpStickyMenu();
      
            var offsets = jQuery('#addCartlist').offset();
                       if(jQuery('#addCart').is(":visible"))
                       {
                          offsets=jQuery('#addCart').offset();
                       }
                       if(jQuery('#addCart2').is(":visible"))
                       {
                          offsets=jQuery('#addCart2').offset();
                       }
            var leftVal = offsets.left;
            if(jQuery("#scrollToTop").is(":visible"))
                       {
                       scroller();
                       var scroll = jQuery(window).scrollTop();
                       jQuery(dialogHolder).css('left', (leftVal-280) + 'px');
                        jQuery(dialogHolder).css('top', scroll+40 + 'px');
                         jQuery(dialogHolder).css('z-index',14)
                       }
                       else{
                       jQuery(dialogHolder).css('left', (leftVal-280) + 'px');
                        jQuery(dialogHolder).css('top', 205 + 'px');
                       }
                        jQuery(dialogHolder).slideDown(20);
                        jQuery(dialogHolder).addClass('js_lightBoxCartContainer');
                        var titlebar = jQuery(dialogHolder).find(".ui-dialog-titlebar");
                        jQuery(titlebar).attr('id', 'js_lightBoxCartTitleBar');
                        jQuery('.js_lightBoxCartContainer').attr('id', 'js_lightBoxCartContainerId');
      
                        jQuery( ".showLightBoxCart" ).mouseover(function(e) {
                e.preventDefault();
                          displayLightDialogBox('lightCart_');
                          var dialogHolder = jQuery('#lightCart_displayDialog').parent();
                          jQuery(dialogHolder).hide();
                          if(jQuery("#scrollToTop").is(":visible"))
                       {
                       scroller();
                       var scroll = jQuery(window).scrollTop();
                       if(scroll==0){
                       jQuery(dialogHolder).css('left', (leftVal-280) + 'px');
                        jQuery(dialogHolder).css('top', 205 + 'px');
                       }
                       else{
                       jQuery(dialogHolder).css('left', (leftVal-280) + 'px');
                        jQuery(dialogHolder).css('top', scroll+40 + 'px');
                         jQuery(dialogHolder).css('z-index',40)
                       }
                       }
                       else{
                       jQuery(dialogHolder).css('left', (leftVal-280) + 'px');
                        jQuery(dialogHolder).css('top', 205 + 'px');
                       }
                          jQuery(dialogHolder).slideDown(450);
                          jQuery(dialogHolder).addClass('js_lightBoxCartContainer');
                          var titlebar = jQuery(dialogHolder).find(".ui-dialog-titlebar");
                          jQuery(titlebar).attr('id', 'js_lightBoxCartTitleBar');
                          jQuery('.js_lightBoxCartContainer').attr('id', 'js_lightBoxCartContainerId');
            });
                        showPlpSizeGuide(selectFeatureDiv);
              });
      
                 }
                 //document.productListForm.submit();
                 jQuery('.ui-dialog.globular-ui-widget.ui-widget-content.ui-corner-all.ui-draggable.lightCart_displayDialog').css('display', 'none');
            }
          }
      }
      }
      
      }
      
      
      function addItemPlpToWishlist(selectFeatureDiv)
      {
      var selectedValue;
      jQuery('#FTCOLOR_'+selectFeatureDiv+' option').each(function(){
      selectedValue=  jQuery(this).val();
      });
      if(selectedValue == undefined || selectedValue == null ||selectedValue.length<=0){
      selectedValue=selectedOptionValue;
      }
      jQuery('#'+selectFeatureDiv+'_add_product_id').val(selectedValue);
      if(isItemSelectedPlp(selectFeatureDiv))
      {
         var quantity = Number(1);
         if(jQuery('#js_plp_qty_'+selectFeatureDiv).length)
         {
            var quantitiyValue = jQuery('#js_plp_qty_'+selectFeatureDiv).val();
            if(quantitiyValue != "")
            {
              quantity = quantitiyValue;
            }
         }
         var add_product_id = jQuery('#'+selectFeatureDiv+"_add_product_id").val();
         var productName = jQuery('#detailLink_'+add_product_id).attr("title");
         var add_category_id = jQuery('#'+selectFeatureDiv+"_add_category_id").val();
      
         jQuery('#plp_add_product_id').val(add_product_id);
         jQuery('#plp_qty').val(quantity);
         jQuery('#plp_add_category_id').val(add_category_id);
      
      if(isQtyWhole(quantity,productName))
      {
        if(!(isQtyZero(quantity,productName,add_product_id)))
        {
                        // document.productListForm.action="/addPlpItemToWishlist";
                         //document.productListForm.submit();
                          var ifWishlisturl="/addPlpItemToWishlist"+"?plp_add_product_id="+add_product_id+"&plp_qty="+quantity;
                    jQuery.get(ifWishlisturl, function(data)
              {
              var wishListStatus=jQuery(data).find('#wishlistHeaderCount').find(".list-count");
          jQuery("#wishlistHeaderCount").find(".list-count").html(wishListStatus.html());
          jQuery("#wishlistCount").find(".list-count").html(wishListStatus.html());
          jQuery("#wishlistCountRes").find(".list-count").html(wishListStatus.html());
                showPlpSizeGuide1(selectFeatureDiv);
              });
              }
      }
      }
      }
      
      function findIndexPlp(name, selectFeatureDiv)
      {
      var ftSize="FTSIZE_"+selectFeatureDiv;
      var ftColor="FTCOLOR_"+selectFeatureDiv;
      OPT = [ftSize,ftColor];
      for (i = 0; i < OPT.length; i++)
      {
          if (OPT[i] == name)
          {
              return i;
          }
      }
      return -1;
      }
      
      
      
      
      jQuery(document).ready(function()
      {
      jQuery(window).resize(function() {
      
      jQuery('[id^="js_plp_qty_"]').keyup(function(){
      var changedQtyId = jQuery(this).attr("id");
      if(changedQtyId != "")
      {
      var changedQtyIdArray = changedQtyId.split("_");
      jQuery("#js_plp_qty_modified_" + changedQtyIdArray[3] + "_" + changedQtyIdArray[4]).val("Y");
      }
      });
      
      
         processPLPPageLoad();
         
          }).resize();
         
      });
      
      var selectedOptionValue;
      var firstNoSelection = "false";
      function getListPlp(name, index, src, selectFeatureDiv)
      {
      var ftSize="FTSIZE_"+selectFeatureDiv;
      var ftColor="FTCOLOR_"+selectFeatureDiv;
      OPT = [ftSize,ftColor];
      
      var noSelection = "false";
      currentFeatureIndex = findIndexPlp(name, selectFeatureDiv);
      if(firstNoSelection == "true")
      {
        noSelection ="false";
      }
      if(index != -1)
      {
        var liElm = jQuery('#Li'+name+" li").get(index);
      }
      else
      {
      var liElm = jQuery('#Li'+name+" li").get(0);
      noSelection ="true";
      }
      jQuery(liElm).siblings("li").removeClass("selected");
      // jQuery(liElm).addClass("selected");
      
      var selectElement = jQuery('div#'+selectFeatureDiv+' select.'+name);
      
      selectElement.selectedIndex = (index*1)+1;
      jQuery(selectElement).find('option').eq((index*1)+1).prop('selected', true);
      
      if (currentFeatureIndex < (OPT.length-1))
      {
      
          var selectedValue = jQuery(selectElement).find('option').eq((index*1)+1).val();
          var selectedText = jQuery(selectElement).find('option').eq((index*1)+1).text();
      
      
           if(selectedText === undefined || selectedText == null || selectedText.length <= 0){
           selectedText=jQuery("#Li"+name).find("li:eq("+index+")").attr("class");
      var mapKey = name.substring(0, name.indexOf(selectFeatureDiv))+selectedText;
      var varMapStr=jQuery("#span_"+selectFeatureDiv).attr(mapKey);
      selectedOptionValue=varMapStr;
      if(jQuery('#js_plp_qty_'+selectFeatureDiv).length && jQuery('#js_plp_qty_'+selectFeatureDiv).val() == "")
            {
              var productAttrPdpQtyDefault = "";
                if(jQuery('#js_pdpQtyDefaultAttributeValue_' + varMapStr).length)
              {
                productAttrPdpQtyDefault = jQuery('#js_pdpQtyDefaultAttributeValue_' + varMapStr).val();
              }
              else
              {
                productAttrPdpQtyDefault = Number('1');
              }
              var userModifiedQty = jQuery('#js_plp_qty_modified_'+selectFeatureDiv).val();
              if(productAttrPdpQtyDefault && userModifiedQty == "N")
              {
                jQuery('#js_plp_qty_'+selectFeatureDiv).val(productAttrPdpQtyDefault);
              }
            }
      }
      else{
      var mapKey = name+'_'+selectedText;
          var VARMAP = eval("getFormOptionVarMap"+ selectFeatureDiv + "()");
      
          if(VARMAP[mapKey])
          {
            if(jQuery('#js_plp_qty_'+selectFeatureDiv).length && jQuery('#js_plp_qty_'+selectFeatureDiv).val() == "")
            {
              var productAttrPdpQtyDefault = "";
                if(jQuery('#js_pdpQtyDefaultAttributeValue_' + VARMAP[mapKey]).length)
              {
                productAttrPdpQtyDefault = jQuery('#js_pdpQtyDefaultAttributeValue_' + VARMAP[mapKey]).val();
              }
              else
              {
                productAttrPdpQtyDefault = Number('1');
              }
              var userModifiedQty = jQuery('#js_plp_qty_modified_'+selectFeatureDiv).val();
              if(productAttrPdpQtyDefault && userModifiedQty == "N")
              {
                jQuery('#js_plp_qty_'+selectFeatureDiv).val(productAttrPdpQtyDefault);
              }
            }
            }
          }
          if (index == -1)
          {
             for (i = currentFeatureIndex; i < OPT.length; i++)
             {
                 var featureName = jQuery('div#'+selectFeatureDiv+' select.js_selectableFeature_'+(i+1)).attr("name");
      
                 if(i == 0)
                 {
                     var selFeaturName = featureName.substr(2,featureName.length);
                     var Variable1 = eval("list" + selFeaturName + "()");
                     jQuery('#js_plpAddtoCart_'+selectFeatureDiv).addClass("inactiveAddToCart");
                   jQuery('#js_addToWishlist_'+selectFeatureDiv).addClass("inactiveAddToWishlist");
                 }
                 else
                 {
                   if(i == currentFeatureIndex)
                   {
                       var Variable1 = eval("list" + featureName + jQuery('div#'+selectFeatureDiv+' select.js_selectableFeature_'+i).val() + "()");
                       var Variable1 = eval("listLi" + featureName + jQuery('div#'+selectFeatureDiv+' select.js_selectableFeature_'+i).val() + "()");
                       jQuery('div#'+selectFeatureDiv+' select.js_selectableFeature_'+(i+1)).children().removeAttr("disabled");
                   }
                   else
                   {
                       var Variable1 = eval("list" + featureName + "()");
                       var Variable1 = eval("listLi" + featureName + "()");
                   }
                 }
             }
      
      
            firstNoSelection = "true";
          }
          else
          {
              firstNoSelection = "false";
                if (selectedValue != null && selectedValue.length > 0 )
                {
                  var Variable1 = eval("list" + OPT[(currentFeatureIndex+1)] + selectedValue + "()");
                  var Variable2 = eval("listLi" + OPT[(currentFeatureIndex+1)] + selectedValue + "()");
                }
      
                var elmCart = document.getElementById("js_plpAddtoCart_"+selectFeatureDiv);
                if (elmCart !=null )
                {
                  elmCart.setAttribute("onClick","javascript:showPlpSizeGuide('"+ selectFeatureDiv+"')");
                }
                var elmWishlist = document.getElementById("js_addToWishlist_"+selectFeatureDiv);
                if (elmWishlist !=null )
                {
                  elmWishlist.setAttribute("onClick","javascript:showPlpSizeGuide1('"+ selectFeatureDiv+"')");
                }
                if (currentFeatureIndex+1 <= (OPT.length-1) )
                {
      
                    var nextFeatureLength = jQuery('div#'+selectFeatureDiv+' select.'+OPT[(currentFeatureIndex+1)]).find('option').size();
      
                    if(nextFeatureLength == 2)
                    {
                      getListPlp(OPT[(currentFeatureIndex+1)],'0',1, selectFeatureDiv);
                      jQuery('#js_plpAddtoCart_'+selectFeatureDiv).removeClass("inactiveAddToCart");
                      if (elmWishlist !=null )
                      {
                          jQuery('#js_addToWishlist_'+selectFeatureDiv).addClass("inactiveAddToWishlist");
                      }
                      return;
                    }
                    else
                    {
                      jQuery('#js_plpAddtoCart_'+selectFeatureDiv).addClass("inactiveAddToCart");
                      if (elmWishlist !=null )
                      {
                          jQuery('#js_addToWishlist_'+selectFeatureDiv).addClass("inactiveAddToWishlist");
                      }
                    }
                }
      
          }
          setAddProductIdPlp('NULL', selectFeatureDiv);
      
      }
      else
      {
      
          var indexSelected = selectElement.selectedIndex;
          var sku = jQuery(selectElement).find('option').eq(indexSelected).val();
      
          if(firstNoSelection == "false")
          {
            setAddProductIdPlp(sku, selectFeatureDiv);
          }
          else
          {
            setAddProductIdPlp("", selectFeatureDiv);
          }
      
          var varProductId = jQuery('#'+selectFeatureDiv+"_add_product_id").val();
      
          if(varProductId == "")
          {
            jQuery('#js_plpAddtoCart_'+selectFeatureDiv).addClass("inactiveAddToCart");
      jQuery('#js_addToWishlist_'+selectFeatureDiv).addClass("inactiveAddToWishlist");
      }
      else
      {
      setProductStockPlp(sku, selectFeatureDiv);
      }
      
      if(noSelection=="true" || varProductId == "")
      {
            var indexDisplayed = 1;
            varProductId = jQuery(selectElement).find('option').eq(indexDisplayed).val();
          }
          if(jQuery('#js_plp_qty_'+selectFeatureDiv).length)
          {
            var productAttrPdpQtyDefault="";
            if(jQuery('#js_pdpQtyDefaultAttributeValue_'+varProductId).length)
        {
          productAttrPdpQtyDefault = jQuery('#js_pdpQtyDefaultAttributeValue_'+varProductId).val();
        }
        else
        {
          productAttrPdpQtyDefault = Number('1');
        }
        var userModifiedQty = jQuery('#js_plp_qty_modified_'+selectFeatureDiv).val();
        if(productAttrPdpQtyDefault && userModifiedQty == "N")
        {
            jQuery('#js_plp_qty_'+selectFeatureDiv).val(productAttrPdpQtyDefault);
        }
      }
      }
      }
      
      
      
      
      function processPLPPageLoad() {
      jQuery("#tabs").css("display","none");
          jQuery("div.js_eCommerceThumbNailHolder div.js_plpQuicklook").find('img').show();
      
      jQuery('.js_facetValue.js_hideThem').hide();
      jQuery('.js_facetValue.js_showAllOfThem').hide();
      jQuery('.js_seeLessLink').hide();
      jQuery('.js_showAllLink').hide();
      
      jQuery('.js_plpFeatureSwatchImage').click(function() {
          var swatchVariant = jQuery(this).next('.js_swatchVariant').clone();
      
          var swatchVariantOnlinePrice = jQuery(this).nextAll('.js_swatchVariantOnlinePrice:first').clone().show();
          swatchVariantOnlinePrice.removeClass('js_swatchVariantOnlinePrice').addClass('js_plpPriceOnline');
      
          jQuery(this).parents('.productItem').find('.js_plpPriceOnline').replaceWith(swatchVariantOnlinePrice);
      
          var swatchVariantListPrice = jQuery(this).nextAll('.js_swatchVariantListPrice:first').clone().show();
          swatchVariantListPrice.removeClass('js_swatchVariantListPrice').addClass('js_plpPriceList');
          jQuery(this).parents('.productItem').find('.js_plpPriceList').replaceWith(swatchVariantListPrice);
      
          var swatchVariantSaveMoney = jQuery(this).nextAll('.js_swatchVariantSaveMoney:first').clone().show();
          swatchVariantSaveMoney.removeClass('js_swatchVariantSaveMoney').addClass('js_plpPriceSavingMoney');
          jQuery(this).parents('.productItem').find('.js_plpPriceSavingMoney').replaceWith(swatchVariantSaveMoney);
      
          var swatchVariantSavingPercent = jQuery(this).nextAll('.js_swatchVariantSavingPercent:first').clone().show();
          swatchVariantSavingPercent.removeClass('js_swatchVariantSavingPercent').addClass('js_plpPriceSavingPercent');
          jQuery(this).parents('.productItem').find('.js_plpPriceSavingPercent').replaceWith(swatchVariantSavingPercent);
      
          jQuery(this).parents('.productItem').find('.js_eCommerceThumbNailHolder').find('.js_swatchProduct').replaceWith(swatchVariant);
          jQuery('.js_eCommerceThumbNailHolder').find('.js_swatchVariant').show().attr("class", "js_swatchProduct");
          jQuery(this).siblings('.js_plpFeatureSwatchImage').removeClass("selected");
          jQuery(this).addClass("selected");
          makePDPUrl(this);
      
      
      });
      
      jQuery('.js_seeMoreLink').click(function() {
          jQuery(this).hide().parents('li').siblings('li.js_hideThem').show();
      
          if(jQuery(this).siblings('.js_showAllLink').length > 0)
          {
            jQuery(this).siblings('.js_showAllLink').show();
          }
          else
          {
            jQuery(this).siblings('.js_seeLessLink').show();
          }
      });
      
      jQuery('.js_showAllLink').click(function() {
          jQuery(this).hide().parents('li').siblings('li.js_hideThem').show();
          jQuery(this).hide().parents('li').siblings('li.js_showAllOfThem').show();
          jQuery(this).siblings('.js_seeLessLink').show();
          jQuery(this).siblings('.js_showAllLink').hide();
      });
      
      jQuery('.js_seeLessLink').click(function() {
          jQuery(this).hide().parents('li').siblings('li.js_hideThem').hide();
          jQuery(this).hide().parents('li').siblings('li.js_showAllOfThem').hide();
          jQuery(this).siblings('.js_seeMoreLink').show();
      });
      
      jQuery('.js_showHideFacetGroupLink').click(function()
      {
          jQuery(this).toggleClass("js_seeMoreFacetGroupLink");
          jQuery(this).toggleClass("js_seeLessFacetGroupLink");
      
          jQuery(this).siblings('ul').find('li.js_hideThem').slideToggle();
          jQuery(this).siblings('ul').find('li.js_showAllOfThem').hide();
          var seeLessLink = jQuery(this).siblings('ul').find('li').find('.js_seeLessLink');
          var seeMoreLink = jQuery(this).siblings('ul').find('li').find('.js_seeMoreLink');
          if(jQuery(seeLessLink).css('display') != 'none')
          {
            jQuery(seeLessLink).hide();
            jQuery(this).siblings('ul').find('li').find('.js_showAllLink').hide();
      
          }
          else if(jQuery(seeMoreLink).css('display') != 'none')
          {
            jQuery(seeMoreLink).hide();
            jQuery(this).siblings('ul').find('li').find('.js_showAllLink').hide();
            jQuery(this).siblings('ul').find('li.js_hideThem').hide();
      
          }
          else
          {
      
            if(jQuery(this).siblings('ul').find('li').find('.js_showAllLink').length > 0)
            {
              jQuery(this).siblings('ul').find('li').find('.js_showAllLink').slideToggle();
              jQuery(seeMoreLink).hide();
            }
            else
            {
              jQuery(this).siblings('ul').find('li').find('.js_seeLessLink').slideToggle();
              jQuery(seeMoreLink).hide();
            }
      
          }
      
      });
      
      }
      
      function changeSwatchImg(elm) {
      var swatchVariant = jQuery(elm).next('.js_swatchVariant').clone();
      var swatchVariantOnlinePrice = jQuery(elm).nextAll('.js_swatchVariantOnlinePrice:first').clone().show();
      swatchVariantOnlinePrice.removeClass('js_swatchVariantOnlinePrice').addClass('js_plpPriceOnline');
      jQuery(elm).parents('.productItem').find('.js_plpPriceOnline').replaceWith(swatchVariantOnlinePrice);
      
      var swatchVariantListPrice = jQuery(elm).nextAll('.js_swatchVariantListPrice:first').clone().show();
      swatchVariantListPrice.removeClass('js_swatchVariantListPrice').addClass('js_plpPriceList');
      jQuery(elm).parents('.productItem').find('.js_plpPriceList').replaceWith(swatchVariantListPrice);
      
      var swatchVariantSaveMoney = jQuery(elm).nextAll('.js_swatchVariantSaveMoney:first').clone().show();
      swatchVariantSaveMoney.removeClass('js_swatchVariantSaveMoney').addClass('js_plpPriceSavingMoney');
      jQuery(elm).parents('.productItem').find('.js_plpPriceSavingMoney').replaceWith(swatchVariantSaveMoney);
      
      var swatchVariantSavingPercent = jQuery(elm).nextAll('.js_swatchVariantSavingPercent:first').clone().show();
      swatchVariantSavingPercent.removeClass('js_swatchVariantSavingPercent').addClass('js_plpPriceSavingPercent');
      jQuery(elm).parents('.productItem').find('.js_plpPriceSavingPercent').replaceWith(swatchVariantSavingPercent);
      
      jQuery(elm).parents('.productItem').find('.js_eCommerceThumbNailHolder').find('.js_swatchProduct').replaceWith(swatchVariant);
      jQuery('.js_eCommerceThumbNailHolder').find('.js_swatchVariant').show().attr("class", "js_swatchProduct");
      jQuery(elm).siblings('.js_plpFeatureSwatchImage').removeClass("selected");
      jQuery(elm).addClass("selected");
      makePDPUrl(elm);
      }
      
      function makePDPUrl(elm) {
      var plpFeatureSwatchImageId = jQuery(elm).attr("id");
      var plpFeatureSwatchImageIdArr = plpFeatureSwatchImageId.split("|");
      var pdpUrlId = plpFeatureSwatchImageIdArr[1]+plpFeatureSwatchImageIdArr[0];
      var pdpUrl = document.getElementById(pdpUrlId).value;
      
      var productFeatureType = plpFeatureSwatchImageIdArr[0];
      
      jQuery('#'+plpFeatureSwatchImageIdArr[1]+'_productFeatureType').val(productFeatureType);
      jQuery(elm).parents('.productItem').find('a.pdpUrl').attr("href",pdpUrl);
      jQuery(elm).parents('.productItem').find('a.pdpUrl.review').attr("href",pdpUrl+"#productReviews");
      }
      
      function solrSearch(elm, searchURL, removeURL)
      {
      var ajaxUrl = "";
      jQuery('#eCommercePageBody').append("<div class=facetFilterAjaxImg></div>");
      if(jQuery(elm).is(":checked"))
      {
      
          ajaxUrl=searchURL;
      
      
      }
      else
      {
          ajaxUrl=removeURL;
      }
      if (ajaxUrl.indexOf("?") == -1)
      {
          ajaxUrl=ajaxUrl+'?rnd='+String((new Date()).getTime()).replace(/\D/gi, "");
      }
      else
      {
          ajaxUrl=ajaxUrl+'&rnd='+String((new Date()).getTime()).replace(/\D/gi, "");
      }
      jQuery.get(ajaxUrl, function(data)
      {
        var eCommercePageBody = jQuery(data).find('#eCommercePageBody');
          jQuery('#eCommercePageBody').replaceWith(eCommercePageBody);
          processPLPPageLoad();
          if(count>=1){
            jQuery('#eCommerceLeftPanel').append("<div id=clear_All onclick=myFunction()>Clear All</div>");
          }
      });
      }
      
      function solrSearchTopLevelFilter(elm, searchURL, removeURL) {
      var id=elm.id;
      var facetValue=id.split("_");
      var facetClass=facetValue[0];
      var name=elm.name;
      if(jQuery(elm).prop("checked") == true){
             jQuery( "#topFiltersId" ).append("<p id='top_"+id+"' class='"+facetClass+"' onclick='idToTopFilter(this);'><span class='"+facetClass+"'>"+facetClass+" : </span>"+name+" <span class='cancelFilter'></span></p>" );
             jQuery("#topFiltersId").show();
          }
          else if(jQuery(elm).prop("checked") == false){
          jQuery("#top_"+id).remove();
          }
      
      var ajaxUrl = "";
      if(jQuery(elm).is(":checked"))
      {
          ajaxUrl=searchURL;
      }
      else
      {
          ajaxUrl=removeURL;
      }
      plpFilters(ajaxUrl);
      }
      
      function plpFilters(ajaxUrl)
      {
      jQuery("#tabs").css("display","none");
      jQuery('#eCommerceProductListContainer').append("<div class=facetFilterAjaxImg></div>");
      if (ajaxUrl.indexOf("?") == -1)
        {
            ajaxUrl=ajaxUrl+'?rnd='+String((new Date()).getTime()).replace(/\D/gi, "");
        }
        else
        {
            ajaxUrl=ajaxUrl+'&rnd='+String((new Date()).getTime()).replace(/\D/gi, "");
        }
      var selectedTab = jQuery("#tabs .ui-tabs-panel:visible").attr("id");
      // var res = selectedTab.split("-");
      var res;
      if(selectedTab !== undefined &&  selectedTab !== null){
        res = selectedTab.split("-");
      }
      
      var sortOrder = jQuery("#sortResults").val();
      if (!(ajaxUrl.indexOf("sortResults") > -1)) {
      if (typeof sortOrder !== "undefined") {
      ajaxUrl= ajaxUrl + "&sortResults=" + sortOrder;
      }
      }
      
        jQuery.get(ajaxUrl, function(data)
        {
            var eCommerceProductListContainer = jQuery(data).find('#eCommerceProductListContainer');
            jQuery('#eCommerceProductListContainer').replaceWith(eCommerceProductListContainer);
      jQuery("#sortResults").val(sortOrder);
             var shopcategoryId = jQuery(data).find('#shopcategoryId');
             jQuery('#shopcategoryId').replaceWith(shopcategoryId);
      
             var tabs = jQuery(data).find('#tabs');
            jQuery('#tabs').replaceWith(tabs);
      
             var pricetarId = jQuery(data).find('#pricetarId');
             jQuery('#pricetarId').replaceWith(pricetarId);
      
              var js_toggle_tarwc_1 = jQuery(data).find('#js_toggle_tarwc_1');
             jQuery('#js_toggle_tarwc_1').replaceWith(js_toggle_tarwc_1);
      
            var js_toggle_tarwc_2 = jQuery(data).find('#js_toggle_tarwc_2');
             jQuery('#js_toggle_tarwc_2').replaceWith(js_toggle_tarwc_2);
      
             var js_toggle_tarwc_3 = jQuery(data).find('#js_toggle_tarwc_3');
             jQuery('#js_toggle_tarwc_3').replaceWith(js_toggle_tarwc_3);
      
             var js_toggle_tarwc_4 = jQuery(data).find('#js_toggle_tarwc_4');
             jQuery('#js_toggle_tarwc_4').replaceWith(js_toggle_tarwc_4);
      
             var js_toggle_tarwc_5 = jQuery(data).find('#js_toggle_tarwc_5');
             jQuery('#js_toggle_tarwc_5').replaceWith(js_toggle_tarwc_5);
      
             var js_toggle_tarwc_6 = jQuery(data).find('#js_toggle_tarwc_6');
             jQuery('#js_toggle_tarwc_6').replaceWith(js_toggle_tarwc_6);
      
             jQuery("body").scrollTop(190)
      
            processPLPPageLoad();
            //Todo added for PLP tab show by venkat and Krishna
           jQuery("#tabs").tabs();
       //jQuery( "#tabs" ).tabs({ active: res[1]-2 });
       if(res !== undefined &&  res !== null){
       jQuery( "#tabs" ).tabs({ active: res[1]-2 });
      }
      
       filters_clear();
      
      jQuery(".ui-dialog-content").dialog("close");
      
       jQuery(data).find('.variableMapForFilterAjax').each(function(i){
              jQuery('.hideAjaxResponse').append(jQuery(this).html());
         });
          if (jQuery('div').hasClass('PLP')) {
        jQuery(".wishList_social_share").css({ 'display': "block" });
      }
      
        });
      }
      
      function clearSelectedFilters(elm)
      {
      if(jQuery("#topFiltersId").children().length <= 1){
      jQuery("#topFiltersId").hide();
      }
      var selectedFilterGrp=jQuery(elm).prev().attr("id");
      var ajaxUrl=jQuery(elm).prev().find("li:first").find(".removeURLForFilter").text();
      if(selectedFilterGrp == undefined || selectedFilterGrp == null ||selectedFilterGrp.length<=0){
        selectedFilterGrp="color";
      }
      var topFilterClass=selectedFilterGrp.charAt(0).toUpperCase() + selectedFilterGrp.slice(1);
      ajaxUrl=ajaxUrl+"&clearFilterGroup="+selectedFilterGrp;
      jQuery('#topFiltersId').parent().find('.'+topFilterClass).remove();
      jQuery('#elm.id').empty();
      jQuery("#elm.id").hide();
      plpFilters(ajaxUrl);
      }
      
      function clearAllFilters()
      {
      var ajaxUrl=jQuery("#clearAllFilters").text();
      jQuery('#topFiltersId').empty();
      jQuery("#topFiltersId").hide();
      plpFilters(ajaxUrl);
      
      }
    function overlayfun(){
   jQuery(".ui-widget-overlay").css({"display":"block","height":"1000px","z-index":"999"});
  }

  function closeoverlay()
  {
    jQuery(".ui-widget-overlay").css("display","none");
  }
      function popcall()
      {
        jQuery(".ui-widget-overlay").css({"display":"block","height":"1000px","z-index":"999"});
      }

      function popupclose()
      {
        jQuery(".ui-widget-overlay").css("display","none");
      }
