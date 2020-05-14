"use strict";
var KTValidationControls = function () {

   var validationForm = function () {


        //passwork check rule
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });

        var btn = $("form :submit");

        $("#registrationForm").validate({

            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                first_name:
                {
                    required:true
                },
                last_name:
                {
                    required:true  
                },
                email_address:
                {
                    required:true,
                    email:true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                conf_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: {
                    required: "Please enter first name",
                },
                last_name: {
                    required: "Please enter last name",
                },
                email_address: {
                    required: "Please enter email address",

                },
            },
            errorPlacement: function (error, element) {
              error.appendTo(element.parent()).addClass('text-danger');


            },
            invalidHandler: function (e, r) {

                $('#schoolForm').scrollTop(0);
            },
            submitHandler: function (e) {
                $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
                return true;
              }


        });
        $("#forgotpasswordForm").validate({

            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                
                email_address:
                {
                    required:true,
                    email:true
                },
                
            },
            messages: {
                
                email_address: {
                    required: "Please enter email address",

                },
            },
            errorPlacement: function (error, element) {
              error.appendTo(element.parent()).addClass('text-danger');


            },
            invalidHandler: function (e, r) {

                $('#schoolForm').scrollTop(0);
            },
            submitHandler: function (e) {
                $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
                return true;
              }


        });

    };

      return {

        //main function to initiate the module
        init: function () {
            validationForm();
        },

    };

}();

jQuery(document).ready(function () {
    KTValidationControls.init();
});
