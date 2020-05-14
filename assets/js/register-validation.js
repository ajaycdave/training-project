"use strict";
var KTValidationControls = function() {

    var validationForm = function() {

            //passwork check rule
         $.validator.addMethod("pwcheck", function(value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });
         var btn = $( "form :submit" );

        $("#registerForm").validate({
          ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
          // define validation rules
            rules: {
                full_name: {
                     required: true,
   
                },
                email:{
                     required: true,
                     email:true,
                },
                password:{
                        required: true,
                        pwcheck: true,
                        minlength: 8
                },
                password_confirmation: {
                        required: true,
                        minlength: 8,
                        equalTo: "#password"
                    }
              
                
            },
            messages:{
                full_name: {
                     required: "Full name is required",
   
                },
                email:{
                         required: "Emial is required"
                },
                password:{
                        required: "Please enter password.",
                        pwcheck: 'Password must be minimum 8 characters.password must contain at least 1 lowercase, 1 Uppercase, 1 numeric and 1 special character.',
                        minlength: "Please enter atleast 8 digit."
                },
                password_confirmation: {
                        required: "Please enter confirm password.",
                        minlength: "Confirm password must be at least 8 characters long.",
                        equalTo: "Confirm password does not match to password."

                }
                
             
               

            },
             errorPlacement: function (error, element) {
             // var data = element.data('selectric');
             error.appendTo(element.parent()).addClass('text-danger');
          

            
             },
            invalidHandler: function(e, r) {

               $('#registerForm').scrollTop(0);
            },
            submitHandler: function(e) {

                //btn.addClass('k-loader k-loader--right k-loader--light').attr('disabled', true);
                return true;
            }
        });


    };



    return {

        //main function to initiate the module
        init: function() {
            validationForm();
           ;
        },

    };

}();

jQuery(document).ready(function() {
    KTValidationControls.init();
});