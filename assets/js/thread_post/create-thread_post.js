"use strict";
var KTValidationControls = function () {

    var container_no=[];
    var item_net_weight=0;
    //Subject Select2
    var Selectoption = function () {

       
        $('.select2').select2({
            placeholder: 'Select a option',
        });
        
    };
    var validationForm = function () {
          //passwork check rule
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });

        var btn = $("form :submit");

        $("#threadpostForm").validate({

            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                
                description:
                {
                    required:true
                },
                
               
            },
            messages: {
                description: {
                    required: "Please enter description",
                },
               
            },
            errorPlacement: function (error, element) {

                // var placement = $(element).attr('id');

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
        //Repeater create School Form
    };

      return {

        //main function to initiate the module
        init: function () {
              Selectoption();
             validationForm();
          
          //  getContainerProduct();

        },

    };

}();

jQuery(document).ready(function () {
    KTValidationControls.init();

   
    /* Form  store action with multiple */
});
