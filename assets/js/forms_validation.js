//==========================================================
//  Employee Personal Details
//==========================================================
$("#savePersonal").click(function () {

    $("#personalForm").validate({
        excluded: ':disabled',
        rules: {

            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            date_of_birth: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },

        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});



//==========================================================
//  Employee Contact Validation
//==========================================================
$("#saveContact").click(function () {
    $("#ContactForm").validate({
        excluded: ':disabled',
        rules: {
            address_1: {
                required: true
            },
            city: {
                required: true
            },
            postal: {
                required: true
            },
            home_telephone: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});

$("#saveFranchise").click(function () {
    $("#FranchiseForm").validate({
        excluded: ':disabled',
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            address: {
                required: true
            },
            city: {
                required: true
            },
            postal: {
                required: true
            },
            home_telephone: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },
            joined_date: {
                required: true
            },
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});

$("#saveCustomer").click(function () {
    $("#CustomerForm").validate({
        excluded: ':disabled',
        rules: {
            name: {
                required: true
            },
            phone_1: {
                required: true
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            country: {
                required: true
            },
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});

//==========================================================
//  Create Invoice
//==========================================================
$("#saveInvoice").click(function () {
    $("#from-invoice").validate({
        excluded: ':disabled',
        rules: {
            company_id: {
                required: true
            },
            customer_id: {
                required: true
            },
            invoice_date: {
                required: true
            },
            due_date: {
                required: true
            },
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});


$("#saveEstimate").click(function () {
    $("#from-estimates").validate({
        excluded: ':disabled',
        rules: {
            company_id: {
                required: true
            },
            customer_id: {
                required: true
            },
            expired_date: {
                required: true
            },
            valid_until: {
                required: true
            },
        },

        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block animated fadeInDown',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    })
});