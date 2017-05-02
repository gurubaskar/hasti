function pincodeValidation() {
	jQuery("#pincodeMessageId").empty();
	jQuery("#pincodeSuccessMessageId").empty();
	var b = document.getElementById("pincode").value;
	jQuery(".textclear pincodeChecker").each(function() {
		this.value = ""
	});
	if (document.getElementById("pincode").value == "") {
		document.getElementById("pincodeSuccessMessageId").style.display="none";
		document.getElementById("pincodeMessageId").innerHTML = "Please Enter the Pincode";
		return false
	} else {
		if (!jQuery.isNumeric(document.getElementById("pincode").value)) {
			document.getElementById("pincodeSuccessMessageId").style.display="none";
			document.getElementById("pincodeMessageId").innerHTML = "Please enter Valid 6 digits Zipcode";
			return false
		} else {
			if (document.getElementById("pincode").value.length != 6) {
				document.getElementById("pincodeSuccessMessageId").style.display="none";
				document.getElementById("pincodeMessageId").innerHTML = "Please Enter the Valid Pincode";
				return false
			} else {
				if (document.getElementById("pincode").value.length == 6) {
					var a = "/pincodeCheckSearch?pincode" + pincode;
					jQuery
							.ajax({
								url : a,
								type : "POST",
								data : {
									pincode : b
								},
								success : function(c, d, e) {
									console.log(c);
									if (c.COD == "Y") {
										document.getElementById("pincodeSuccessMessageId").style.display="block";
										document.getElementById("pincodeSuccessMessageId").innerHTML = "Cash on Delivery is available for your PIN Code.";
										return false
									} else {
										document.getElementById("pincodeSuccessMessageId").style.display="none";
										document.getElementById("pincodeMessageId").innerHTML = "We're sorry Cash on Delivery Currently not available in your area. You may Place Order by making online payment.";
										return false
									}
								}
							});
					return false
				}
			}
		}
	}
	return true
}
function validatePincode() {
	jQuery("#pincodeMessageId").empty();
	jQuery("#pincodeSuccessMessageId").empty();
	jQuery("#successMessage").empty();
	jQuery("#errorMessage").empty()
};