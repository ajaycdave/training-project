"use strict";
var KTValidationControls = function() {
var initWidgets = function () {
        // select2

         
    }
    var validationForm = function() {


         var btn = $( "form :submit" );

        $("#categoryForm").validate({
          ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
          // define validation rules
            rules: {
                name: {
                     required: true,
                },
                
              
                
            },
            messages:{
                name:{
                       required: "Name is required"
                },
            },
             errorPlacement: function (error, element) {
             // var data = element.data('selectric');
             error.appendTo(element.parent()).addClass('text-danger');
          

            
             },
            invalidHandler: function(e, r) {

               $('#producttypeForm').scrollTop(0);
            },
            submitHandler: function(e) {

            $("#cl").removeClass('ik ik-check-circle').addClass('fa fa-spinner fa-spin');
            return true;
            }
        });


    };



    return {

        //main function to initiate the module
        init: function() {
            initWidgets();
            validationForm();
           ;
        },

    };

}();

jQuery(document).ready(function() {
    KTValidationControls.init();
});