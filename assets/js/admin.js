function getXMLHTTP() { //fuction to return the xml http object
	var xmlhttp = false;
	try {
		xmlhttp = new XMLHttpRequest();
	}
	catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e) {
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e1) {
				xmlhttp = false;
			}
		}
	}

	return xmlhttp;
}

	//*********************************************
	//           Get Base URL
	//*********************************************

	function getBaseURL() {
		return link = jQuery('body').data('baseurl');

	};


	//*******************************************************
	//*********************Get CSRF TOKEN********************
	//*******************************************************

	function getCookie(name) {

			var cookieValue = null;
			if (document.cookie && document.cookie != '') {
				var cookies = document.cookie.split(';');
				for (var i = 0; i < cookies.length; i++) {
					var cookie = jQuery.trim(cookies[i]);
					// Does this cookie string begin with the name we want?
					if (cookie.substring(0, name.length + 1) == (name + '=')) {
						cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
						break;
					}
				}
			}
			return cookieValue;

	}




	//==========================================================
	//  Save Product Category
	//==========================================================

	function save_category(){

		(function ($) {
			var postUrl     = $('#form-category').attr('action');
			var input = $("<input>")
					.attr("type", "hidden")
					.attr("name", "csrf_test_name").val( getCookie('csrf_cookie_name'));
			$('#form-category').append($(input));

			// now upload the file using $.ajax
			$.ajax({
				url: postUrl,
				type: "POST",
				data: $('#form-category').serialize(),
				cache: false,
				success: function(result) {
					$( "#p_category" ).val('');
					var result = $.parseJSON(result);
					msgBoxModal(result[0],result[1]);
				}
			});

		})(jQuery);

	}

	//==========================================================
	//  Ajax Form Submission
	//==========================================================

	function save_product(){

		(function ($) {
			var postUrl     = $('#from-product').attr('action');
			var formData = new FormData($('#from-product')[0]);
			$.ajax({
				url: postUrl,
				type: "POST",
				data: formData,
				async: false,
				success: function(result) {
					var result = $.parseJSON(result);
					if(result[0]=='danger'){
						msgBox(result[0],result[1]);
						return false;
					}
					msgBox(result[0],result[1]);
                    setTimeout(function () {// wait for 5 secs(2)
                        location.reload(); // then reload the page.(3)
                    }, 5000);
				},
				cache: false,
				contentType: false,
				processData: false
			});

		})(jQuery);

	}

	function msgBox(type, msg)
	{
		(function ($) {
			$("#msg").html('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ msg +'</div>');
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 5000);
		})(jQuery);

	}

	function msgBoxModal(type, msg)
	{
		(function ($) {
			$("#msgModal").html('<div class="alert alert-'+type+'"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+ msg +'</div>');
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove();
				});
			}, 5000);
		})(jQuery);

	}


	//==========================================================
	//  Save Product Category
	//==========================================================

	function deletePimage(str){

		(function ($) {
			var postUrl  = getBaseURL()+'admin/product/deletePimage' ;
			var id = str.id;
			// now upload the file using $.ajax
			$.ajax({
				url: postUrl,
				type: "POST",
                data: { id : id, csrf_test_name : getCookie('csrf_cookie_name') },
				cache: false,
				success: function(result) {
                    var result = $.parseJSON(result);
                    if(result[0] == 'success') { // if true (1)
                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }
				}
			});

		})(jQuery);

	}

	//==========================================================
	//  Select All Checkbox
	//==========================================================

	$(function() {

		$('#parent_present').on('change', function() {
			$('.child_present').prop('checked', $(this).prop('checked'));
		});
		$('.child_present').on('change', function() {
			$('#parent_present').prop($('.child_present:checked').length ? true : false);
		});
		$('#parent_absent').on('change', function() {
			$('.child_absent').prop('checked', $(this).prop('checked'));
		});
		$('.child_absent').on('change', function() {
			$('#parent_absent').prop($('.child_absent:checked').length ? true : false);
		});
	});


	//==========================================================
	//  Alert hide time set
	//==========================================================

	setTimeout(function() {
		$(".alert").fadeOut("slow", function() {
			$(".alert").remove();
		});

	}, 9000);

	//==========================================================
	//  Print Area Select
	//==========================================================
	function print_invoice(printableArea) {

		var table = $('#dataTables-example').DataTable();
		table.destroy();

		//$('#dataTables-example').attr('id','none');
		var printContents = document.getElementById(printableArea).innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		//$('table').attr('id','dataTables-example');
		location.reload(document.body.innerHTML = originalContents);
		//document.body.innerHTML = originalContents;
	}

	//*********************************************
	//     Get Salary Range
	//*********************************************
	function get_salaryRange(str){
		$('#resultSalaryRange').empty();
		var link = getBaseURL();
		$.ajax({
			type: "POST",
			url: link + 'admin/employee/get_salaryRange_by_id',
			data: { grade_id : str, csrf_test_name : getCookie('csrf_cookie_name') },
			cache: false,
			success: function(result){
				var result = $.parseJSON(result)
				$("#resultSalaryRange").append('Min: ' +result[0] + ' Max: ' + result[1]);
				$('#min_salary').val(result[0]);
				$('#max_salary').val(result[1]);
			}
		});
	}

	//*********************************************
	//     Get Employee by department
	//*********************************************

	function get_employee(str){

		var employeeId = $('#employeeId').val();
		if (str == '') {
			$("#employee").html("<option value=''>Please Select</option>");
		} else {
			$("#employee").html("<option value=''>Please Select</option>");

			var link = getBaseURL();
			$.ajax({
				type: "POST",
				url: link + 'admin/employee/get_employee_by_department',
				data: { department_id : str, employeeId : employeeId ,csrf_test_name : getCookie('csrf_cookie_name') },
				cache: false,
				success: function(result){
					$("#employee").html("<option value=''>Please Select</option>");
					$("#employee").append(result);
				}
			});

		}
	}

	//*********************************************
	//     Get Employee+admin by department
	//*********************************************

	function get_employeeAdmin(str){


		if (str == '') {
			$("#employee").html("<option value=''>Please Select</option>");
		} else {
			$("#employee").html("<option value=''>Please Select</option>");

			var link = getBaseURL();
			$.ajax({
				type: "POST",
				url: link + 'admin/mail/get_employee_by_department',
				data: { department_id : str ,csrf_test_name : getCookie('csrf_cookie_name') },
				cache: false,
				success: function(result){
					$("#employee").select2("val", "");
					$("#employee").html("<option value=''>Please Select</option>");
					$("#employee").append(result);
				}
			});

		}
	}

	//*********************************************
	//    Transaction Type
	//*********************************************

	function transactionType(str)
	{
		var type = str.value;

		if (type == '') {
			$("#account").css({'display':'none'});
			$("#method").css({'display':'none'});
			$("#category").html("<option value=''>"+select+"...</option>");
			exit;
		}

		//if(type == 'AP' || type == 'AR'){
		//	$("#account").css({'display':'none'});
		//	$("#method").css({'display':'none'});
		//}else{
		//	$("#account").css({'display':'block'});
		//	$("#method").css({'display':'block'});
		//	$(".select2").css({'width':'100%'});
		//}


		if(type == 'AP' || type == 'AR'){
			$("#account").css({'display':'none'});
			$("#method").css({'display':'none'});
			$("#trn_category").css({'display':'block'});
			$("#transfer_account").css({'display':'none'});
		}else if(type == 'TR') {
			$("#trn_category").css({'display':'none'});
			$("#account").css({'display':'none'});
			$("#transfer_account").css({'display':'block'});
			$("#method").css({'display':'block'});
			$(".select2").css({'width':'100%'});
		}else{
			$("#account").css({'display':'block'});
			$("#method").css({'display':'block'});
			$("#trn_category").css({'display':'block'});
			$(".select2").css({'width':'100%'});
			$("#transfer_account").css({'display':'none'});
		}

		var link = getBaseURL();
		$.ajax({
			type: "POST",
			url: link + 'admin/transaction/get_transaction_category',
			data: { type : type ,csrf_test_name : getCookie('csrf_cookie_name') },
			cache: false,
			success: function(result){
				$("#category").html("<option value=''>"+select+"...</option>");
				$("#category").append(result);
			}
		});
	}

//*********************************************
//           active admin user
//*********************************************
function adminUserActivation(cb) {

	var userId = cb.id;
	var status = cb.checked;
	var postUrl     = getBaseURL() + 'admin/panel/change_status';
	var csrftoken = getCookie('csrf_cookie_name');

	// now upload the file using $.ajax
	$.ajax({
		url: postUrl,
		type: "POST",
		data: { userId : userId, status: status, 'csrf_test_name': csrftoken },
		cache: false,
		success: function(response) {
			//$(".subscription_success_msg").show();
			//$("#subscriptionMsg").html(response);
			//$( "#name" ).val('');
			//$( "#email" ).val('');
		}
	});
}

//*********************************************
//           active admin user
//*********************************************
function employeeActivation(cb) {

	var userId = cb.id;
	var status = cb.checked;
	var postUrl     = getBaseURL() + 'admin/employee/change_status';
	var csrftoken = getCookie('csrf_cookie_name');

	// now upload the file using $.ajax
	$.ajax({
		url: postUrl,
		type: "POST",
		data: { userId : userId, status: status, 'csrf_test_name': csrftoken },
		cache: false,
		success: function(response) {
			//$(".subscription_success_msg").show();
			//$("#subscriptionMsg").html(response);
			//$( "#name" ).val('');
			//$( "#email" ).val('');
		}
	});
}


//*******************************************************
//*****************Estimate Cart Ajax Start from here*************
//*******************************************************

function get_estimate_product_id(str) {
	var rowid = str.id;
	var productID = str.value;
	var link = getBaseURL();
	var rd = $('#renewaldate1').val();
	var rp = $('#renewalperiod1').children("option:selected").val();
	var tx = $('#tax').children("option:selected").val();
    var postUrl     = getBaseURL() + 'admin/estimates/add_to_cart';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
			product_id : productID,
			renewal_date: rd,
			renewal_period: rp,
			tax: tx,
            rowid: rowid,
			status: status, 'csrf_test_name': csrftoken
		},
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
            	//alert(cart);
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });

}

function estimate_updateItem(str) {
	var val = str.id;
    var rowid = val.slice(3);
    var type = val.slice(0,3);
	var o_val = str.value;
	var qty = $('#qty'+rowid).val();
    var price = $('#prc'+rowid).val();
	var p_id = $('#pid'+rowid).val();
	var tax = $('#tax'+rowid).val();
    var postUrl     = getBaseURL() + 'admin/estimates/update_cart_item';
    var csrftoken 	= getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            rowid: rowid,
			type: type,           
            o_val: o_val,
            qty: qty,
            price: price,
            p_id: p_id,
            tax: tax,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_estimate_gstTaxCalculate(str) {
	var gst =  str.value;
    var postUrl     = getBaseURL() + 'admin/estimates/taxGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            gst: gst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_estimate_cgstTaxCalculate(str) {
	var cgst =  str.value;
    var postUrl     = getBaseURL() + 'admin/estimates/taxCGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            cgst: cgst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_estimate_igstTaxCalculate(str) {
	var igst =  str.value;
    var postUrl     = getBaseURL() + 'admin/estimates/taxIGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            igst: igst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_estimate_sgstTaxCalculate(str) {
	var sgst =  str.value;
    var postUrl     = getBaseURL() + 'admin/estimates/taxSGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            sgst: sgst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}


function estimate_removeItem(str) {
    var rowid = str.id;
    var postUrl     = getBaseURL() + 'admin/estimates/remove_item';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            rowid: rowid,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function estimate_order_discount(str) {
	var discount =  str.value;
    var postUrl     = getBaseURL() + 'admin/estimates/order_discount';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            discount: discount,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/estimates/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}


//*******************************************************
//*****************Cart Ajax Start from here*************
//*******************************************************

function get_product_id(str) {
	var rowid = str.id;
	var productID = str.value;
	var link = getBaseURL();
	var rd = $('#renewaldate1').val();
	var rp = $('#renewalperiod1').children("option:selected").val();
	var tx = $('#tax').children("option:selected").val();
    var postUrl     = getBaseURL() + 'admin/sales/add_to_cart';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
			product_id : productID,
			renewal_date: rd,
			renewal_period: rp,
			tax: tx,
            rowid: rowid,
			status: status, 'csrf_test_name': csrftoken
		},
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
            	//alert(cart);
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });

}

function updateItem(str) {
	var val = str.id;
    var rowid = val.slice(3);
    var type = val.slice(0,3);
	var o_val = str.value;
	var qty = $('#qty'+rowid).val();
    var price = $('#prc'+rowid).val();
	var p_id = $('#pid'+rowid).val();
	var tax = $('#tax'+rowid).val();
    var postUrl     = getBaseURL() + 'admin/sales/update_cart_item';
    var csrftoken 	= getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            rowid: rowid,
			type: type,           
            o_val: o_val,
            qty: qty,
            price: price,
            p_id: p_id,
            tax: tax,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}



function get_gstTaxCalculate(str) {
	var gst =  str.value;
    var postUrl     = getBaseURL() + 'admin/sales/taxGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            gst: gst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_cgstTaxCalculate(str) {
	var cgst =  str.value;
    var postUrl     = getBaseURL() + 'admin/sales/taxCGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            cgst: cgst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_igstTaxCalculate(str) {
	var igst =  str.value;
    var postUrl     = getBaseURL() + 'admin/sales/taxIGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            igst: igst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_sgstTaxCalculate(str) {
	var sgst =  str.value;
    var postUrl     = getBaseURL() + 'admin/sales/taxSGSTCalculate';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            sgst: sgst,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}


function removeItem(str) {
    var rowid = str.id;
    var postUrl     = getBaseURL() + 'admin/sales/remove_item';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            rowid: rowid,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function order_discount(str) {
	var discount =  str.value;
    var postUrl     = getBaseURL() + 'admin/sales/order_discount';
    var csrftoken = getCookie('csrf_cookie_name');
	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            discount: discount,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            //location.reload(); // then reload the page.(3)
            $.get(link + "admin/sales/show_cart", function (cart) {
                $('#cart_view').html(cart);
                $('select').select2();
            });
            $('#overlay').remove();
        }
    });
}

function get_customer(str) {
	var customer_id = str.value;
    var postUrl     = getBaseURL() + 'admin/sales/select_customer_by_id';
    var csrftoken = getCookie('csrf_cookie_name');

	loader();
    $.ajax({
        url: postUrl,
        type: "POST",
        data: {
            customer_id: customer_id,
            status: status, 'csrf_test_name': csrftoken
        },
        cache: false,
        success: function(response) {
            var customer = $.parseJSON(response);
            $('[name="email"]').val(customer.email);
            $('[name="address"]').val(customer.address);
            $('[name="phone"]').val(customer.phone);
            $('[name="state"]').val(customer.state);
            $('[name="city"]').val(customer.city);
            $('[name="website"]').val(customer.website);
            $('[name="company_gst"]').val(customer.company_gst);
            $('#overlay').remove();
        }
    });
}

function loader() {
    var baseUrl = getBaseURL();
    var over = '<div id="overlay">' +
        '<img id="loading" src= "'+ baseUrl +'assets/img/balls.gif">' +
        '</div>';
    $(over).appendTo('body');
}

// get state 
jQuery(document).on('change', 'select#country-name', function (e) {
    e.preventDefault();
    var countryID = jQuery(this).val();
    getStatesList(countryID);
});

// get city
jQuery(document).on('change', 'select#state-name', function (e) {
    e.preventDefault();
    var stateID = jQuery(this).val();
    getCityList(stateID);

});

jQuery(document).on('change', 'select#city-name', function (e) {
	$(this).find("option:selected").each(function(){		
		if($(this).attr("value")!="Others"){
			$(".citybox").hide();
		}
		else{
			$(".citybox").not(".ref").hide();
			$(".city").show();
		}
	});
}).change();

// function get All States
function getStatesList(countryID) {
	var csrftoken = getCookie('csrf_cookie_name');
    $.ajax({
        url: getBaseURL() + "admin/location/getstates",
        type: 'post',
        data: {countryID: countryID,'csrf_test_name': csrftoken},
        dataType: 'json',
        beforeSend: function () {
            jQuery('select#state-name').find("option:eq(0)").html("Please wait..");
        },
        complete: function () {
            // code
        },
        success: function (json) {
            var options = '';
            options +='<option value="">Select State</option>';
            for (var i = 0; i < json.length; i++) {
                options += '<option value="' + json[i].state_id + '">' + json[i].state_name + '</option>';
            }
            jQuery("select#state-name").html(options);

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// function get All Cities
function getCityList(stateID) {
	var csrftoken = getCookie('csrf_cookie_name');
    $.ajax({
        url: getBaseURL()+ "admin/location/getcities",
        type: 'post',
        data: {stateID: stateID,'csrf_test_name': csrftoken},
        dataType: 'json',
        beforeSend: function () {
            jQuery('select#city-name').find("option:eq(0)").html("Please wait..");
        },
        complete: function () {
            // code
        },
        success: function (json) {
            var options = '';
            options +='<option value="">Select City</option>';
            for (var i = 0; i < json.length; i++) {
				options += '<option value="' + json[i].city_id + '">' + json[i].city_name + '</option>';		
			}
			options +='<option value="Others">Others</option>';
            jQuery("select#city-name").html(options);

        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}