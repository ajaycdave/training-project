"use strict";
var KTValidationControls = function () {

    var validationForm = function () {

        //passwork check rule
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });
        var btn = $("form :submit");

        $("#resetPasswordForm").validate({
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                email: {
                    required: true,
                    email: true,
                },


            },
            messages: {
                email: {
                    required: "Emial is required"
                },

            },
            errorPlacement: function (error, element) {
                // var data = element.data('selectric');
                error.appendTo(element.parent()).addClass('text-danger');


            },
            invalidHandler: function (e, r) {

                $('#resetPasswordForm').scrollTop(0);
            },
            submitHandler: function (e) {

                //btn.addClass('k-loader k-loader--right k-loader--light').attr('disabled', true);
                return true;
            }
        });


    };


    return {

        //main function to initiate the module
        init: function () {
            validationForm();
            ;
        },

    };

}();

jQuery(document).ready(function () {
    KTValidationControls.init();
});
