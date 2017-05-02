
function popLoginsign() {
	var j = jQuery("#msignInCustomerEmail").val();
	var p = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var m = document.getElementById("mpasswordsign").value;
	if (document.getElementById("msignInCustomerEmail").value == "") {
		document.getElementById("errMsgId").innerHTML = "Please Enter Your Email";
		return false
	}
	if (!p.test(j)) {
		document.getElementById("errMsgId").innerHTML = "Please enter a valid email address";
		return false
	}
	if (document.getElementById("mpasswordsign").value == "") {
		document.getElementById("errMsgId").innerHTML = "Please Enter your Password";
		return false
	}
	if (m.length < 6) {
		document.getElementById("errMsgId").innerHTML = "Password should be minimum 6 characters";
		return false
	}
	if (m.length > 20) {
		document.getElementById("errMsgId").innerHTML = "Password should be maximum 20 characters";
		return false
	}
	var remmberMe="Y";
	var isRememberMe = document.getElementById("rememberMe").checked;
	if(!isRememberMe)
	{
	remmberMe="N";
	}


	if (window.location.protocol == "https:") {
		url = "/AjaxLoginSec?"
	} else {
		url = "/AjaxLoginNonSec?"
	}
	var requireChange=false;
	var status=false;
	jQuery.ajax({
        url: url,
        type: "POST",
        data: { USERNAME: document.getElementById("msignInCustomerEmail").value,
        		PASSWORD:document.getElementById("mpasswordsign").value,
        	    rememberMe:remmberMe},
        success: function(data) {
        	jQuery.each(data, function(key, value) {
    			if (key == "_ERROR_MESSAGE_LIST_") {
    				document.getElementById("errMsgId").innerHTML = value;
    				status = false;
    				return false;
    			}
    			if(key == "requirePasswordChange"){
    				requireChange = true;
    				
    			}
    			status=true;
    			
    		});
    		if(requireChange){
    			var form = document.getElementById('loginform');
    			form.action = "/eCommerceRequirePasswordChange";
    			form.submit();
    		}

    		if (status) {
    			window.location.href="/";
    		}
        }
        });
}

function addProductToWishlistResponive()
{
	var isReferFrnd = document.getElementById("referFrnd").value;
	var wishlistLoc= jQuery("#loginforWishlistUrl").val();
	if(wishlistLoc == "addPlpItemToWishlist") {
		var form = document.getElementById('productListForm');
	    //addWishListProdFromPDP('/addPlpItemToWishlist',form);
	    jQuery.ajax({
	        url: '/addPlpItemToWishlist',
	        data: form.serialize(),
	        success: function(response) {
	        	 window.location.href="/";
			   }
	        });




	}else if(wishlistLoc == "addPdpItemToWishlist") {
		var form = document.getElementById('productDetailForm');
		//addWishListProdFromPDP('/addItemToWishList',form);
		jQuery.ajax({
	        url: '/addItemToWishList',
	        type: "POST",
	        data: form.serialize(),
	        success: function(response) {
				window.location.href="/";
			   }
	        });
	}
	else{
		if(null !=isReferFrnd && isReferFrnd != 'undefined' && isReferFrnd.length > 0 && isReferFrnd == 'referral'){
			var url=window.location.href;
			url="/referFriendInvite";
			window.location.href=url;
		}else{

			window.location.href="/";
		}
	}
}

function mSignup() {
	jQuery("#signuperrId").empty();
	var N;
	var C = jQuery("#mcustomerEmail").val();
	var K = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var S = document.getElementById("mpassword1").value;
	var E = document.getElementById("mpassword2").value;
	var R = document.getElementById("mdobLongMonthUs").value;
	var T = document.getElementById("mdobLongDayUs").value;
	var B = document.getElementById("mdobLongYearUs").value;
	var I = document.getElementById("mfirstName").value;
	var G = document.getElementById("mlastName").value;
	var F = /^[a-zA-Z]+$/;
	var J = /^[789]\d{9}$/;
	var Q = document.getElementById("mPHONE_MOBILE_CONTACT_OTHER").value;
	var H = document.getElementById("mfirstName").value;
	var y = document.getElementById("mlastName").value;
	var O = new Date();
	O.setFullYear(B, R, T);
	var M = new Date();
	var x = M.getFullYear();
	var z = M.getMonth();
	var L = M.getDate();
	age = x - B;
	if (z < R - 1) {
		age--
	}
	if (R - 1 == z && L < T) {
		age--
	}
	if (document.getElementById("mfirstName").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please enter your first name";
		return false
	}
	if (!F.test(H)) {
		document.getElementById("signuperrId").innerHTML = "Please enter valid first name";
		return false
	}
	if (document.getElementById("mlastName").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please enter your last name";
		return false
	}
	if (!F.test(y)) {
		document.getElementById("signuperrId").innerHTML = "Please enter valid last name";
		return false
	}
	if (document.getElementById("mPHONE_MOBILE_CONTACT_OTHER").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please enter your mobile number";
		return false
	}
	if (!J.test(Q)) {
		document.getElementById("signuperrId").innerHTML = "Please enter valid mobile number";
		return false
	}
	if (document.getElementById("mdobLongMonthUs").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please select month";
		return false
	}
	if (document.getElementById("mdobLongDayUs").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please select day";
		return false
	}
	if (document.getElementById("mdobLongYearUs").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please select year";
		return false
	}
	if (age < 18) {
		document.getElementById("signuperrId").innerHTML = "Please enter valid DOB";
		return false
	}
	if (document.getElementById("M_USER_GENDER").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please select a gender";
		return false
	}
	if (document.getElementById("mcustomerEmail").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please Enter your Email";
		return false
	}
	if (!K.test(C)) {
		document.getElementById("signuperrId").innerHTML = "Please enter a valid email address";
		return false
	}
	if (document.getElementById("mpassword1").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please Enter your Password";
		return false
	}
	if (document.getElementById("mpassword2").value == "") {
		document.getElementById("signuperrId").innerHTML = "Please Re-Enter your Password";
		return false
	}
	if (S != E) {
		document.getElementById("signuperrId").innerHTML = "Password Mismatch";
		return false
	}
	if (S.length < 6) {
		document.getElementById("signuperrId").innerHTML = "Password should be minimum 6 characters";
		return false
	}
	if (S.length > 20) {
		document.getElementById("signuperrId").innerHTML = "Password should be maximum 20 characters";
		return false
	}
	if (E.length < 6) {
		document.getElementById("signuperrId").innerHTML = "Password should be minimum 6 characters";
		return false
	}
	if (E.length > 20) {
		document.getElementById("signuperrId").innerHTML = "Password should be maximum 20 characters";
		return false
	}
	var url = "/createPersonAndUserLogin?firstName="
			+ I
			+ "&USER_FIRST_NAME_MANDATORY=Y&lastName="
			+ G
			+ "&USER_LAST_NAME_MANDATORY=Y&PHONE_MOBILE_CONTACT_OTHER="
			+ Q
			+ "&PHONE_MOBILE_CONTACT_OTHER_MANDATORY=Y&mainAction=CREATE&dobLongMonthUs="
			+ R + "&dobLongDayUs=" + T + "&dobLongYearUs=" + B
			+ "&DOB_MMDDYYYY_MANDATORY=N&userLoginId=" + C
			+ "&currentPassword=" + S + "&currentPasswordVerify=" + E
			+ "&USER_GENDER=" + document.getElementById("M_USER_GENDER").value;

	var referrerMail=document.getElementById("referrerMail").value;
	if(referrerMail !=null && referrerMail != 'undefined' && referrerMail.length > 0)
		{
		url=url+"&referrerMail="+referrerMail;
		}
	var referredMail=document.getElementById("referredMail").value;
	if(referredMail !=null && referredMail != 'undefined' && referredMail.length > 0)
		{
		url=url+"&referredMail="+referredMail;
		}
		
	var A = "false";
	var D = document.getElementById("mcustomerEmail").value;
	jQuery.ajax({
		url : url,
		type : "POST",
		success : function(a, c, b) {
			jQuery.each(a, function(d, e) {
				console.log("property.." + d);
				console.log("value.." + e);
				if (d == "_ERROR_MESSAGE_") {
					A = "true";
					console.log("put error message");
					document.getElementById("signuperrId").innerHTML = "User with ID "+D+" already exists.";
					return false
				}
				if (d == "targetRequestUri") {
					A = "true"
				}
				if (d == "_CONTEXT_ROOT_") {
					A = "true"
				}
				if (d == "_CONTROL_PATH_") {
					A = "true"
				}
				if (d == "_FORWARDED_FROM_SERVLET_") {
					A = "true"
				}
				if (d == "_SERVER_ROOT_URL_") {
					A = "true"
				}
				if (d == "thisRequestUri") {
					A = "true"
				}
				if (d == 0) {
					addProductToWishlistResponive();
					return false
				}
			})
		}
	})
};

