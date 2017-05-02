var wid = jQuery(window).width();
var linkvalue;
function signInPopUp1(a) {
	linkvalue = a
}
jQuery("#dialog").dialog({
	modal : true,
	resizable : false
});

jQuery(document)
		.ready(
				function() {
					cname = "JSESSIONID";
					var d = new Date();
					d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
					var expires = "expires=" + d.toUTCString();
					document.cookie = cname + "=" + getCookie("JSESSIONID")
							+ "; " + expires;
					jQuery(".LoginNames")
							.on(
									"change",
									"#dobLongMonthUs",
									function() {
										var c = jQuery(
												"#dobLongMonthUs :selected")
												.val();
										if (c == 2) {
											jQuery(
													"#dobLongDayUs option[value=30]")
													.remove();
											jQuery(
													"#dobLongDayUs option[value=31]")
													.remove();
										} else {
											if (jQuery(
													"#dobLongDayUs option[value=30]")
													.val() != 30) {
												jQuery("<option>")
														.val("30")
														.text("30")
														.appendTo(
																"#dobLongDayUs");
												jQuery("<option>")
														.val("31")
														.text("31")
														.appendTo(
																"#dobLongDayUs");
											}
										}
									});
					var b = jQuery(location).attr("pathname");
					if (b == "/coupons") {
						jQuery("#couponId").dialog({
							modal : true,
							resizable : false
						})
					}
					var a = true;
					jQuery("#submitPageReview").click(function() {
						writeAReview()
					});
					if (wid > 768) {
					} else {
						jQuery("#loginsign").empty();
						jQuery(
								'<a name="continueBtn"  href="eCommerceNewCustomer">Login / Sign Up</a>')
								.appendTo("#loginsign");
						jQuery("#mcheckcod").empty();
						jQuery('<a href="eCommerceCheckCod">CHECK COD</a>')
								.appendTo("#mcheckcod")
					}

				});
function logemail() {
	document.getElementById("logema").style.display = "none";
	document.getElementById("orema").style.display = "none";
	alert(em.value)
}
function sizeGuidePopUp(a) {
	jQuery(".ui-dialog-content").dialog("close");
	jQuery("body").addClass("stop-scrolling");
	jQuery("#sizechart_Container").dialog({
		modal : true,
		resizable : false
	})
	jQuery(".ui-dialog").addClass('sizeguidepopup');
}
function addToBag() {
	jQuery("#outOfStockText").dialog({
		modal : true,
		resizable : false
	})
}
function trackOrderStatus() {
	 jQuery( "#trackorderMsg").empty();
     jQuery("#trackorderEmailMsg").empty();
	if (wid > 768) {
		jQuery("body").addClass("stop-scrolling");
		jQuery("#trackerIdx").dialog({
			modal : true,
			resizable : false,
			close : function() {
				jQuery("body").removeClass("stop-scrolling")
			}
		});
		document.getElementById("trackerIdxx").style.display = "block";
		jQuery(".textclear input").each(function() {
			this.value = ""
		})
	} else {
		jQuery('<form action="eCommerceTrackOrder"></form>').appendTo("body")
				.submit().remove()
	}
}
function getCookieValue(b) {
	var c = document.cookie.split("; ");
	for (var a = 0, d; (d = c[a] && c[a].split("=")); a++) {
		if (decode(d.shift()) === b) {
			return decode(d.join("="))
		}
	}
	return null
}
function decode(a) {
	return decodeURIComponent(a.replace(/"/g, ""))
}
function signInPopUp(checklogin) {
	jQuery("#loginStatusId").val(checklogin);
	jQuery("#dialog").data('isReferral', checklogin);
	jQuery("#loginMessages").empty();
	var userName = getCookieValue("OFBiz.Username");
	if (userName != undefined && userName != null && userName.length > 0) {
		jQuery("#returnCustomerEmail").attr("value", userName)
	}
	// if (wid > 768) {
	jQuery("body").addClass("stop-scrolling");
	jQuery("#dialog").dialog({
		modal : true,
		resizable : false,
		draggable : false,
		close : function() {
			jQuery("body").removeClass("stop-scrolling")
		}
	})
	if (wid <= 1030) {
		jQuery(".ui-dialog").addClass('login-Popup');
		jQuery(".ui-draggable").removeClass('login-Popup');
	}
	jQuery("#signInpopup").dialog("close");
	jQuery("body").addClass("stop-scrolling");
	jQuery("#signupMessages").empty();
	jQuery("#forgotAlert").empty();
	jQuery("#loginMessages").empty();
	jQuery(".loginRow input").each(function() {
		this.value = ""
	});
	document.getElementById("dialog").style.display = "block";
	document.getElementById("dialog").style.display = "block"
	/*
	 * } else { jQuery('<form action="eCommerceNewCustomer"><input
	 * type="hidden" name="isReferral" value="'+checklogin+'"/></form>').appendTo("body")
	 * .submit().remove() }
	 */
}
function signInPopUpAddItemToWishlist(linkValue) {
	if (wid >= 768) {
		jQuery("#loginStatusId").val('regular');
		jQuery("#dialog").data('linkvalue', linkValue);
		var userName = getCookieValue("OFBiz.Username");
		if (userName != undefined && userName != null && userName.length > 0) {
			jQuery("#returnCustomerEmail").attr("value", userName)
		}
		jQuery("#dialog").dialog({
			modal : true,
			resizable : false
		})
	} else {

		jQuery
				.ajax({
					url : "/eCommerceNewCustomer",
					type : "POST",
					data : {},
					success : function(response) {
						jQuery(
								"#eCommerceTopPanel,#eCommerceLeftPanel,#eCommerceMainPanel")
								.css("display", "none");
						jQuery("#eCommercePageBody").append(
								'<div id="wishListLogindiv"></div>');
						jQuery("#wishListLogindiv").append(
								jQuery(response).find('#eCommerceMainPanel'));
						jQuery("#loginforWishlistUrl").val(linkValue);
						window.scrollTo(0, 0);
						jQuery(
								'<a href="<@ofbizUrl>forgotPassword</@ofbizUrl>">Forgot Password?</a>')
								.appendTo("#mfrgtPasswordId");
						var userNameCookie = getCookieValue("OFBiz.Username");
						if (userNameCookie != undefined
								&& userNameCookie != null
								&& userNameCookie.length > 0) {
							jQuery("#msignInCustomerEmail").attr("value",
									userNameCookie);
						}

					}
				});
		return false;
	}
}

function createNewAccount() {
	var a = document.getElementById("loginform");
	a.action = "/eCommerceNewCustomer";
	a.submit()
}
/*jQuery(function() {
	jQuery("#LoginTabs").tabs()
});*/
function isLeapYear(a) {
	return ((a % 4 == 0) && (a % 100 != 0)) || (a % 400 == 0)
}
function popSignup() {
	jQuery(".Error").empty();
	jQuery("#signupMessages").empty();
	var g;
	var r = jQuery("#customerEmail").val();
	var j = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var b = document.getElementById("password1").value;
	var m = document.getElementById("password2").value;
	var c = document.getElementById("dobLongMonthUs").value;
	var a = document.getElementById("dobLongDayUs").value;
	var p = document.getElementById("dobLongYearUs").value;
	var w = document.getElementById("firstName").value;
	var o = document.getElementById("lastName").value;
	var errorFlag = true;
	var l = /^[a-zA-Z]+$/;
	var k = /^[789]\d{9}$/;
	var d = document.getElementById("PHONE_MOBILE_CONTACT_OTHER").value;
	var v = document.getElementById("firstName").value;
	var u = document.getElementById("lastName").value;
	var f = new Date();
	        f.setFullYear(p, c, a);
	var h = new Date();
	var t = h.getFullYear();
	var q = h.getMonth();
	var i = h.getDate();
	age = t - p;
	if (q < c - 1) {
		age--
	}
	if (c - 1 == q && i < a) {
		age--
	}
	var flag=false;
	if (document.getElementById("firstName").value == "") {
		document.getElementById("nameError").innerHTML = "Please enter your first name";
		flag=true;
		errorFlag = false;
	}else if (!l.test(v)) {	
			flag=true;
			document.getElementById("nameError").innerHTML = "Please enter only characters for first name";				
			errorFlag = false;
	}
	
	//for last name
	if (document.getElementById("lastName").value == "") {
		if(flag){
		jQuery("#nameError").append(" & Please enter your last name");
		errorFlag = false;
		}else{
			document.getElementById("nameError").innerHTML = "Please enter your last name";
			errorFlag = false;
		}
	}else if (!l.test(u)) {	
		if(flag){
			jQuery("#nameError").append(" & Please enter only characters for last name");
			errorFlag = false;
			}else{
				document.getElementById("nameError").innerHTML = "Please enter only characters for last name";
				errorFlag = false;
			}
						
		}
	
	
	//For mobile number
	if (document.getElementById("PHONE_MOBILE_CONTACT_OTHER").value == "") {
		document.getElementById("mobileNumberError").innerHTML = "Please enter your mobile number";
		errorFlag = false;
	} else if (!k.test(d)) {
		document.getElementById("mobileNumberError").innerHTML = "Please enter valid mobile number";
		errorFlag = false;

	}
	if (document.getElementById("dobLongDayUs").value == "") {
		document.getElementById("dobError").innerHTML = "Please select day";
		errorFlag = false;

	} else if (document.getElementById("dobLongMonthUs").value == "") {
		document.getElementById("dobError").innerHTML = "Please select month";
		errorFlag = false;
	} else if (document.getElementById("dobLongYearUs").value == "") {
		document.getElementById("dobError").innerHTML = "Please select year";
		errorFlag = false;

	} else {
		if (c == 2) {
			if (isLeapYear(p)) {
				if (!(a >= 1 && a <= 29)) {
					document.getElementById("dobError").innerHTML = "Please select valid day";
					errorFlag = false;

				}
			} else {
				if (!(a >= 1 && a <= 28)) {
					document.getElementById("dobError").innerHTML = "Please select valid day";
					errorFlag = false;
				}
			}
		}
	}
	if (age < 18) {
		document.getElementById("dobError").innerHTML = "Age must be above 18 years";
		errorFlag = false;
	}
	if (document.getElementById("USER_GENDER").value == "") {
		document.getElementById("userGenderError").innerHTML = "Please select a gender";
		errorFlag = false;
	}
	if (document.getElementById("customerEmail").value == "") {
		document.getElementById("customerEmailError").innerHTML = "Please Enter your Email";
		errorFlag = false;
	} else if (!j.test(r)) {
		document.getElementById("customerEmailError").innerHTML = "Please enter a valid email address";
		errorFlag = false;
	}
	if (document.getElementById("password1").value == "") {
		document.getElementById("passwordError").innerHTML = "Please Enter your Password";
		errorFlag = false;
	} else if (b.length < 6) {
		document.getElementById("passwordError").innerHTML = "Password should be minimum 6 characters";
		errorFlag = false;

	} else if (b.length > 20) {
		document.getElementById("passwordError").innerHTML = "Password should be maximum 20 characters";
		errorFlag = false;
	}

	if (document.getElementById("password2").value == "") {
		document.getElementById("rePasswordError").innerHTML = "Please re-enter your Password";
		errorFlag = false;
	} else if (m.length < 6) {
		document.getElementById("rePasswordError").innerHTML = "Password should be minimum 6 characters";
		errorFlag = false;
	} else if (m.length > 20) {
		document.getElementById("rePasswordError").innerHTML = "Password should be maximum 20 characters";
		errorFlag = false;
	} else if (b != m) {
		document.getElementById("rePasswordError").innerHTML = "Password Mismatch";
		errorFlag = false;
	}

	var url = "/createPersonAndUserLogin?firstName="
			+ w
			+ "&USER_FIRST_NAME_MANDATORY=Y&lastName="
			+ o
			+ "&USER_LAST_NAME_MANDATORY=Y&PHONE_MOBILE_CONTACT_OTHER="
			+ d
			+ "&PHONE_MOBILE_CONTACT_OTHER_MANDATORY=Y&mainAction=CREATE&dobLongMonthUs="
			+ c + "&dobLongDayUs=" + a + "&dobLongYearUs=" + p
			+ "&DOB_MMDDYYYY_MANDATORY=N&userLoginId=" + r
			+ "&currentPassword=" + b + "&currentPasswordVerify=" + m
			+ "&USER_GENDER=" + document.getElementById("USER_GENDER").value;
	var referrerMail = jQuery("#signInpopup").data('referrerMail');
	if (referrerMail != null && referrerMail != 'undefined'
			&& referrerMail.length > 0) {
		url = url + "&referrerMail=" + referrerMail;
	}
	var referredMail = jQuery("#signInpopup").data('referredMail');
	if (referredMail != null && referredMail != 'undefined'
			&& referredMail.length > 0) {
		url = url + "&referredMail=" + referredMail;
	}
	var s = "false";
	jQuery("#forgotAlert").empty();
	var n = document.getElementById("customerEmail").value;
	if(errorFlag){
	jQuery.ajax({
				url : url,
				type : "POST",
				success : function(y, z, x) {
					jQuery
							.each(
									y,
									function(B, A) {
										console.log("property.." + B);
										console.log("value.." + A);
										if (B == "_ERROR_MESSAGE_") {
											s = "true";
											console.log("put error message");
											document
													.getElementById("signupMessages").innerHTML = "User with ID "
													+ document
															.getElementById("customerEmail").value
													+ " already exists.";
                                                 return errorFlag;
										}
										if (B == "targetRequestUri") {
											s = "true"
										}
										if (B == "_CONTEXT_ROOT_") {
											s = "true"
										}
										if (B == "_CONTROL_PATH_") {
											s = "true"
										}
										if (B == "_FORWARDED_FROM_SERVLET_") {
											s = "true"
										}
										if (B == "_SERVER_ROOT_URL_") {
											s = "true"
										}
										if (B == "thisRequestUri") {
											s = "true"
										}
										if (B == 0) {
											var C = jQuery(location).attr(
													"pathname");
											if (C == "/coupons") {
												jQuery(
														'<form action="main"></form>')
														.appendTo("body")
														.submit().remove()
											} else {
												addProdToWishlist();
												if (window.location.href
														.indexOf("referredFrndSignup") > -1) {
													window.location.href = "/main";
												} else {
													location.reload();
												}
												return errorFlag;

											}
										}
									})
				}
			})
	}
}
function signupPdp() {

	jQuery(".Error").empty();
	
	jQuery("#dialog").dialog("close");
	jQuery("body").addClass("stop-scrolling");
	jQuery("#signInpopup").dialog({
		modal : true,
		resizable : false,
		close : function() {
			jQuery("body").removeClass("stop-scrolling")
		}
	})
	if (wid <= 1030) {
		jQuery(".ui-draggable").addClass('newUser-Signup');
	}
	jQuery("#forgotAlert").empty();
	document.getElementById("dialogSignUp").style.display = "block";
	document.getElementById("signup_pdp").style.display = "none";
	document.getElementById("signInpopup").style.display = "block";
	jQuery("#signInpopup").parent(".ui-corner-all").addClass("signupparentpopup");  // added class name
	dateDropDownval()
}
function loginPdp() {
	jQuery("#dialog").dialog({
		modal : true,
		resizable : false
	});
	jQuery("#forgotAlert").empty();
	jQuery("#signupMessages").empty();

	jQuery("#loginMessages").empty();
	document.getElementById("dialogSignUp").style.display = "none";
	document.getElementById("dialoglogin").style.display = "block";
	document.getElementById("removeLogin").style.display = "block";
	document.getElementById("signup_pdp").style.display = "none";
	document.getElementById("signInpopup").style.display = "none";
	document.getElementById("login_pdp").style.display = "none"
}
function entereEmail(a) {
	if (a.keyCode === 13) {
		checkEmail()
	}
}
function forgetPassword(user) {
	jQuery("#forgotAlertsucess").hide();
	jQuery("body").addClass("stop-scrolling");
	var path = jQuery(location).attr('pathname');
	if (user == "guest") {
		jQuery("#signInGuestId").dialog("close");
	} else {
		jQuery("#dialog").dialog("close");
	}
	jQuery("body").addClass("stop-scrolling");
	jQuery("#fpId").dialog({
		modal : true,
		resizable : false,
		close : function() {
			jQuery("body").removeClass("stop-scrolling")
		}
	});
	jQuery("#forgotAlert").empty();
	jQuery("#loginMessages").empty();
	jQuery("#signupMessages").empty();
	jQuery(".forgot-inputarea input").each(function() {
		this.value = "";
		768
	});
	document.getElementById("dialogforpass").style.display = "block";
	document.getElementById("fpId").style.display = "block"
}
function checkEmail() {
	document.getElementById("forgotAlertsucess").style.display = "none";
	var a = "false";
	jQuery("#forgotAlert").empty();
	var b = jQuery("#unameEmailId").val();
	var d = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (document.getElementById("unameEmailId").value == "") {
		document.getElementById("forgotAlert").innerHTML = "Please Enter your Email";
		return false
	}
	if (!d.test(b)) {
		document.getElementById("forgotAlert").innerHTML = "Please enter a valid email address";
		return false
	}
	var c = document.getElementById("unameEmailId").value;
	jQuery
			.ajax({
				url : "validateForgotPassword?USERNAME=" + c
						+ "&EMAIL_PASSWORD=Y",
				type : "POST",
				success : function(f, g, e) {
					jQuery
							.each(
									f,
									function(i, h) {
										console.log("property.." + i);
										console.log("value.." + h);
										if (i == "_ERROR_MESSAGE_LIST_") {
											a = "true";
											jQuery
													.each(
															h,
															function(j, k) {
																document
																		.getElementById("forgotAlert").innerHTML = k.message;
																return false
															})
										}
										if (i == "targetRequestUri") {
											a = "true"
										}
										if (i == "_CONTEXT_ROOT_") {
											a = "true"
										}
										if (i == "_FORWARDED_FROM_SERVLET_") {
											a = "true"
										}
										if (i == "_SERVER_ROOT_URL_") {
											a = "true"
										}
										if (i == "_CONTROL_PATH_") {
											a = "true"
										}
										if (i == "thisRequestUri") {
											a = "true"
										}
										if (a == "false") {
											jQuery("#unameEmailId").val("");
											emailSuccess();
											return false
										}
									})
				}
			})
}
function emailSuccess() {
	document.getElementById("forgotAlertsucess").style.display = "block"
}
function getCoupon() {
	var a = "/getcoupon";
	jQuery
			.ajax({
				url : a + "?promoType=" + b("promoType"),
				type : "POST",
				success : function(d, e, c) {
					document.getElementById("courponMsg").style.display = "inline-block";
					jQuery("#courponMsg").text(d.couponcode);
					jQuery("#couponTxt").text(d.couponText);
					document.getElementById("coupbtn").style.display = "none"
				}
			});
	function b(c) {
		var f = decodeURIComponent(window.location.search.substring(1)), e = f
				.split("&"), g, d;
		for (d = 0; d < e.length; d++) {
			g = e[d].split("=");
			if (g[0] === c) {
				return g[1] === undefined ? true : g[1]
			}
		}
	}
}
function validateDOB(n) {
	jQuery(".fieldErrorMessage").remove();
	var f = jQuery("#js_USER_FIRST_NAME").val();
	var a = jQuery("#js_USER_LAST_NAME").val();
	var h = n.dobLongMonthUs.value;
	var k = n.dobLongDayUs.value;
	var j = n.dobLongYearUs.value;
	var d = n.PHONE_MOBILE_CONTACT_OTHER.value;
	var l = n.USER_GENDER.value;
	var c = /^[a-zA-Z]+$/;
	var m = /^[789]\d{9}$/;
	var b = new Date();
	var e = b.getFullYear();
	var i = b.getMonth();
	var g = b.getDate();
	age = e - j;
	if (i < h - 1) {
		age--
	}
	if (h - 1 == i && g < k) {
		age--
	}
	if (f == "") {
		jQuery("#js_USER_FIRST_NAME")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter your First Name</li></ul>");
		return false
	}
	if (a == "") {
		jQuery("#js_USER_LAST_NAME")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter your Last Name</li></ul>");
		return false
	}
	if (!c.test(f)) {
		jQuery("#js_USER_FIRST_NAME")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter valid First Name</li></ul>");
		return false
	}
	if (!c.test(a)) {
		jQuery("#js_USER_LAST_NAME")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter valid Last Name</li></ul>");
		return false
	}
	if (h == "") {
		jQuery(".dateoFBirthValiadtion")
				.append(
						"<ul class='fieldErrorMessage'><li>Please select month</li></ul>");
		return false
	}
	if (k == "") {
		jQuery(".dateoFBirthValiadtion")
				.append(
						"<ul class='fieldErrorMessage'><li>Please select day</li></ul>");
		return false
	}
	if (j == "") {
		jQuery(".dateoFBirthValiadtion")
				.append(
						"<ul class='fieldErrorMessage'><li>Please select year</li></ul>");
		return false
	} else {
		if (h == 2) {
			if (isLeapYear(j)) {
				if (!(k >= 1 && k <= 29)) {
					jQuery(".dateoFBirthValiadtion")
							.append(
									"<ul class='fieldErrorMessage'><li>Please select valid day</li></ul>");
					return false
				}
			} else {
				if (!(k >= 1 && k <= 28)) {
					jQuery(".dateoFBirthValiadtion")
							.append(
									"<ul class='fieldErrorMessage'><li>Please select valid day</li></ul>");
					return false
				}
			}
		}
		if (age < 18) {
			jQuery(".dateoFBirthValiadtion")
					.append(
							"<ul class='fieldErrorMessage'><li>Age must be above 18 years</li></ul>");
			return false
		}
	}
	if (d == "") {
		jQuery("#PHONE_MOBILE_CONTACT_OTHER")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter valid mobile number</li></ul>");
		return false
	}
	if (!m.test(d)) {
		jQuery("#PHONE_MOBILE_CONTACT_OTHER")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter valid mobile number</li></ul>");
		return false
	}
	if (l == "") {
		jQuery(".genderValidation")
				.append(
						"<ul class='fieldErrorMessage'><li>Please select an option from the list</li></ul>");
		return false
	}
	n.submit()
}
function changePassword(d) {
	jQuery(".fieldErrorMessage").remove();
	var c = jQuery("#OLD_PASSWORD").val();
	var a = jQuery("#PASSWORD").val();
	var b = jQuery("#CONFIRM_PASSWORD").val();
	if (c == "") {
		jQuery("#OLD_PASSWORD")
				.after(
						"<ul class='fieldErrorMessage'><li>Please enter current password</li></ul>");
		return false
	} else {
		if (a == "") {
			jQuery("#PASSWORD")
					.after(
							"<ul class='fieldErrorMessage'><li>New Password is Missing</li></ul>");
			return false
		} else {
			if (b == "") {
				jQuery("#CONFIRM_PASSWORD")
						.after(
								"<ul class='fieldErrorMessage'><li>Confirm Password is Missing</li></ul>");
				return false
			} else {
				d.submit()
			}
		}
	}
	return true
}
function logout(host) {
	jQuery.ajax({
		url : "/storelogout/",
		type : "GET",
		success : function(b, c, a) {
			window.location.href = host;
		}
	})
};




