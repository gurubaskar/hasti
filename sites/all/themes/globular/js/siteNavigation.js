
var ww = 0;
var isMenuToggled = false;
jQuery(document).ready(function() {
    ww = document.body.clientWidth;

    jQuery(".navigationbar li a").each(function() {
        if (jQuery(this).next().length > 0) {
            jQuery(this).addClass("parent")
        }
    });
    jQuery(document).scroll(function() {
        jQuery("#searchAutoCompleteSticky").html("");
        jQuery("#searchAutoComplete").html("");
        jQuery("#searchText").val("")
    });
    jQuery(".Menu_toggle").click(function(b) {
        b.preventDefault();
        if (isSearchBoxVisible) {
            // Hide Search Box if it's already visible.
            searchBox();
        }
        jQuery('.responseNavBar .removeFooterLinks').show();
        jQuery(this).toggleClass("active");
        var a = jQuery(".navigationbar").is(":visible");
        if (a == false) {
            isMenuToggled = true;
            jQuery(".bgoverlay").css("display", "block")
            jQuery('body').css('overflow-y', 'hidden');
        } else {
            isMenuToggled = false;
            jQuery(".bgoverlay").css("display", "none")
            jQuery('body').css('overflow-y', 'scroll');
        }
        jQuery(".navigationbar").toggle();
        if (jQuery(".menulistwrapper").is(":visible")) {
        	jQuery(".menulistwrapper").css("display","none");
        } else {
        	jQuery(".menulistwrapper").css("display","block");
        }
        jQuery(".navigationbar li").unbind("mouseenter mouseleave");
    });
    adjustMenu();
    jQuery(".navigationbar li").unbind("mouseenter mouseleave");

});
jQuery(window).bind("resize orientationchange", function() {
    ww = document.body.clientWidth;
    adjustMenu()
});
var adjustMenu = function() {
    if (ww < 1030) {
        jQuery(".Menu_toggle").css("display", "inline-block");
        if (!jQuery(".Menu_toggle").hasClass("active")) {
            jQuery(".navigationbar").hide()
        } else {
            jQuery(".navigationbar").show()
        }
        jQuery(".navigationbar li").unbind("mouseenter mouseleave");
        jQuery(".navigationbar li span.resp-li-arrow").unbind("click").bind("click",
           function(a) {

                  jQuery(this).parent().parent("li").toggleClass("hover");
                  if(jQuery(this).parent().parent("li").hasClass("hover")){
                	  jQuery(this).html('<img src="../images/arrow_down.png" alt="down"/>');
                  }else{
                	  jQuery(this).html('<img src="../images/arrow_up.png" alt="up"/>');
                  }
               jQuery(this).parent().parent("li").find(".subCategoryNav").each(function(){
            	   var size=jQuery(this).find("li").find(".subCategoryNav li").size();
            	   if(size==0){
            		   jQuery(this).find("li").find(".resp-li-arrow").css("display","none");
            	   }
                 });
				 jQuery(".navigationbar li.hover").unbind("mouseenter mouseleave mouseover mouseout");
				  a.preventDefault();
				  var wh=jQuery(window).height();
				  if(jQuery(".navigationbar").height() > wh){
					  jQuery(".navigationbar").css("overflow","auto");
				  }else{
					  jQuery(".navigationbar").css("overflow","hidden");
				  }

			})

			  jQuery(".navigationbar li>a.respFooterLink").unbind("click").bind("click",
           function(a) {
                  jQuery(this).parent("li").toggleClass("hover");
			})


    } else {
        if (ww > 1024) {
            jQuery(".Menu_toggle").css("display", "none");
            jQuery(".navigationbar").show();
            jQuery(".navigationbar li").removeClass("hover");
            jQuery(".navigationbar li a").unbind("click");
            jQuery(".navigationbar li").bind("mouseenter", function() {
                jQuery(this).addClass("hover")
            });
            jQuery(".navigationbar li").bind("mouseleave", function() {
                jQuery(this).removeClass("hover")
            })
        }
    }
};
function clearIt(a) {
    if (a.value == a.defaultValue) {
        a.value = ""
    }
}
function setIt(a) {
    if (a.value == "") {
        a.value = a.defaultValue
    }
}

var isSearchBoxVisible = false;
function searchBox() {
    if (jQuery(".navigationbar").is(":visible")) {
        // Hide the Menu if it's open
        jQuery('.Menu_toggle').click();
    }
    if (jQuery("#iconSearch2") != 0) {
        jQuery("#responcive_search").toggle();
        isSearchBoxVisible = !isSearchBoxVisible;
    }
}
var count = 0;
function testing(a) {
    if (a == true) {
        count = count + 1
    }
    if (a == false) {
        count = count - 1;
        if (count == 0) {
            document.getElementById("clear_All").style.display = "none"
        }
    }
}
function addCheckedClass(a) {
    jQuery("#" + a).addClass("selected")
}
jQuery(document)
        .ready(
                function() {
                    if (jQuery(window).width() <= 1024) {
                       // jQuery("#header-container").css("display", "none");
                        jQuery("#addCart,#addWishlist2,#iconSearch2,#signIn_signUp,#stickylogo").css("display", "none")
                         jQuery("#addCart2,#addWishlist3,#iconSearch2,#signIn_signUp2,#stickylogo2").css("display", "block")
                    }
                    if (count >= 1) {
                        document.getElementById("clear_All").style.display = "block"
                    }
                });
function myFunction() {
    jQuery("#eCommercePageBody").append("<div class=facetFilterAjaxImg></div>");
    location.reload()
};


