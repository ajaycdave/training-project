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

        $("#threadForm").validate({

            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                title:
                {
                    required:true
                },
                category_id:
                {
                    required:true
                },
                description:
                {
                    required:true
                },
                
               /* vehicle_no:
                {
                    required:true    
                },
                lr_no:
                {
                    required:true    
                }*/
            },
            messages: {
                title: {
                    required: "Please enter name",
                },
                category_id: {
                    required: "Please select category",
                },
                description: {
                    required: "Please enter description",
                },
                
               /* vehicle_no: {
                    required: "Please enter vehicle no",
                },
                lr_no: {
                    required: "Please enter LR no",
                },*/



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
