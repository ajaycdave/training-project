"use strict";
var KTValidationControls = function () {

    var container_no=[];
    var item_net_weight=0;
    //Subject Select2
    var getSubject = function () {

       /* $('.standardSelect2').on('change', function () {

            var subjectSelect2 = $(this).parent().next().find(".subjectSelect2");
           
            var id = this.value;
            if (id == "") {
                $(subjectSelect2).html('');
            } else {
                $(subjectSelect2).html('');
                $(subjectSelect2).prepend($('<option></option>').html('Loading...'));
            }
            if (id != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#subjectlist').attr('data-subjectlist'),
                    method: "POST",
                    data: {
                        id: id,
                    },
                    success: function (result) {
                        if (result.errors) {
                            $('.alert-danger').html('');
                        } else {
                            $(subjectSelect2).html(result);
                        }
                    }
                });
            }
        });
*/

    };

    var getCitybyState = function () {

        var countrySelect2 = $('#countriesID');
        var stateSelect2 = $('#statesID');
        var citySelect2 = $('#citiesID');

        countrySelect2.select2({

            ajax: {
                url: countrySelect2.data('url'),
                data: function (params) {
                    return {
                        search: params.term,
                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
                //cache: true,
                delay: 250
            },
            placeholder: 'Search Country',
            minimumInputLength: 2,
            allowClear: true
            // templateResult: getfName,
            // templateSelection: formatRepoSelection
            //multiple: true
        });

        stateSelect2.select2({

            allowClear: true,
            ajax: {
                url: stateSelect2.data('url'),
                data: function (params) {
                    return {

                        search: params.term,
                        id: $(stateSelect2.data('target')).val(),

                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
                //cache: true,
                delay: 250
            },
            placeholder: 'Search State',
            minimumInputLength: 2,
        });

        citySelect2.select2({
            allowClear: true,
            ajax: {
                url: citySelect2.data('url'),
                data: function (params) {

                    return {
                        search: params.term,
                        id: $(citySelect2.data('target')).val(),

                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name,
                                otherfield: item,
                            };
                        }),
                    }
                },
                //cache: true,
                delay: 250
            },
            placeholder: 'Search City',
            minimumInputLength: 2,
        });


    };

    // date
    var date = function () {

        $('.datepicker').datepicker({
            format: $('.commonDateFormat').attr('data-commondate'),
            autoclose: true,
            changeYear: true,
            todayHighlight: true
        });
    };

    // Standard Select2
    var standardSelect = function () {

        $('.standardSelect2').select2({
            placeholder: 'Select a option',
        });
        $('.Select2').select2({
            placeholder: 'Select a option',
        });
        
    };

  var setContainer=function (){

          var shipment_id=$('#shipment_id').val();
          if(shipment_id!=""){

         $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#getcontainer').attr('data-url'),
                    method: "POST",
                    data: {
                        shipment_id:shipment_id,
                    },
                    success: function (result) {
                        container_no=result.container_no;
                      

                    }
                });
          }
                

  }
  /*var getContainerProduct=function(){
    $('.containerID :selected').each(function(id,item){
        var container_id=$(this).val();
        var container_row='containerID-group_a-'+id;
        console.log(container_row);
      
        getProductByContainer(container_id,container_row);

    });
  }*/

    //Subject Select2
    var subjectSelect = function () {

        $('.select').select2({
            placeholder: 'Select a option',

        });
        $('#shipment_id').on('select2:select', function (e) { 
            
                var shipment_id=$('#shipment_id').val();
                 getContainer(shipment_id);
             });

        $('#shipment_id').on('select2:unselect', function (e) { 
            
                var shipment_id=$('#shipment_id').val();
               
                 getContainer(shipment_id);

            });
        $('.containerID').on('select2:select', function (e) { 
            
                var container_id=$(this).val();
                var container_row=$(this).attr("id");
                  getProductByContainer(container_id,container_row);
             });
        $('.productID').on('select2:select', function (e) { 
            
                var container_product_id=$(this).val();
                var container_item_id=$(this).attr('id');
            var containerno= $('#'+container_item_id).closest('.row').find('.containerID').val();
            
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#getproductdetail').attr('data-url'),
                    method: "POST",
                    data: {
                        container_no:containerno,
                        container_item_id:container_product_id,
                        sales_id:$("#id").val(),
                    },
                    success: function (result) {

                     if(result.status=="false")
                     {
                        message.fire({
                                         type: 'error',
                                         title: 'Error',
                                         text: "Your Goods Qty is not available"
                                    });
                        $('#'+container_item_id).closest('.row').find('.productID').val('').change();
                            return false;
                     }

                        var duplicat_flag=0;
                        var  con_array=[];
                      
                    $('#'+container_item_id).closest('.row').find('.net_weight').val(result.net_weight);   
                    $('#'+container_item_id).closest('.row').find('.remain_net_weight').val(result.net_remain_weight);
                     $('#'+container_item_id).closest('.row').find('.container_id').val(result.id);
                    setTimeout(function(){

                    $('input[type="hidden"].container_id').each(function (key,val){
                        var container_id_available=$(this).val();
                        
                        if(jQuery.inArray(container_id_available,con_array) !== -1)
                        {
                            message.fire({
                                         type: 'error',
                                         title: 'Error',
                                         text: "Your Goods name already available"
                                    });
                           duplicat_flag=1;
    $('#'+container_item_id).closest('.row').find('.productID').val('').change();
                           
                        }
                        else
                        {
                         con_array.push(container_id_available);   
                        }
                    });
                   
                    if(duplicat_flag==0){
                        //$('#'+container_item_id).closest('.row').find('.container_id').val(result.id);
                    $('#'+container_item_id).closest('.row').find('.quantity').val(result.net_remain_weight);     
                     } 
                        
                    },500);
                        
                   //  $('#'+container_item_id).closest('.row').find('.container_id').val(result.id);         
                      

                   
                    }
                });

            });

         $('.quantity').on('keyup',function(){
            var row_id=$(this).attr('id');
            var row_qty=$('#'+row_id).closest('.row').find('.quantity').val();
            var remain_net_weight=$('#'+row_id).closest('.row').find('.remain_net_weight').val();    
            var item_net_weight=$('#'+row_id).closest('.row').find('.net_weight').val();    
            remain_net_weight=parseFloat(remain_net_weight)+parseFloat((item_net_weight*20)/100);
            console.log(remain_net_weight);
           if(parseFloat(row_qty)>remain_net_weight)
           {
                 message.fire({
                                         type: 'error',
                                         title: 'Error',
                                         text: "Your Goods Qty is  more then available"
                                    });
                 $(this).val('');

           }

         });
         $('.container_cal').on('keyup',function(){
        var row_id=$(this).attr('id');
        var quantity=$('#'+row_id).closest('.row').find('.quantity').val();
        var item_rate=$('#'+row_id).closest('.row').find('.item_rate').val();
        var amount=$('#'+row_id).closest('.row').find('.amount').val();
        var gst_rate=$('#'+row_id).closest('.row').find('.gst_rate').val();
        var tcs_rate=$('#'+row_id).closest('.row').find('.tcs_rate').val();
        var sales_invoice_total=0;
        var tcs_amount=0;
       
       if(quantity!="" && item_rate!=""){
       var amount=parseFloat(quantity)* parseFloat(item_rate);
       $('#'+row_id).closest('.row').find('.amount').val(amount.toFixed(2)); 
       }
       if(gst_rate!=""){
        var gst_amount=amount * parseFloat(gst_rate)/100;
        amount+=parseFloat(gst_amount);
        $('#'+row_id).closest('.row').find('.gst_amount').val(gst_amount.toFixed(2)); 
       }

       if(tcs_rate!="")
       {
        
          tcs_amount=amount * parseFloat(tcs_rate)/100;

    $('#'+row_id).closest('.row').find('.tcs_amount').val(tcs_amount.toFixed(2)); 
       }

       var item_total_amount=amount+tcs_amount;
     
       $('#'+row_id).closest('.row').find('.item_total_amount').val(item_total_amount.toFixed()); 
        $('.item_total_amount').each(function(key,val){
                sales_invoice_total+=parseFloat(this.value);
          });
         $('#net_total_amount').val(sales_invoice_total.toFixed());

         

        }); 
    };
   
   
    var getProductByContainer=function(container_id,container_row){
         $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#getproduct').attr('data-url'),
                    method: "POST",
                    data: {
                        container_id:container_id,
                    },
                    success: function (result) {
                    var productCollection=result.product;
                    var item_option="<option value=''>Select Option</option>";
                    $.each(productCollection,function(key,val){
                        item_option+="<option value='"+key+"'>"+val+"</option>";
                    });
            $('#'+container_row).closest('.row').find('.productID').html(item_option);

              resetItemrow(container_row);
                //    console.log(item_option);


                    }
                });

         var resetItemrow=function (row_id){
            var sales_invoice_total=0;    
            $('#'+row_id).closest('.row').find('.quantity').val('');
            $('#'+row_id).closest('.row').find('.item_rate').val('');
            $('#'+row_id).closest('.row').find('.amount').val('');
            $('#'+row_id).closest('.row').find('.gst_rate').val('');
             $('#'+row_id).closest('.row').find('.gst_amount').val('');
            $('#'+row_id).closest('.row').find('.tcs_rate').val('');
            $('#'+row_id).closest('.row').find('.tcs_amount').val('');
            $('#'+row_id).closest('.row').find('.item_total_amount').val('');

            $('.item_total_amount').each(function(key,val){
                if(this.value!="")
                    sales_invoice_total+=parseFloat(this.value);
            });
             $('#net_total_amount').val(sales_invoice_total.toFixed(2));

         }      

          

    }
    var getContainer=function(shipment_id){
         $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#getcontainer').attr('data-url'),
                    method: "POST",
                    data: {
                        shipment_id:shipment_id,
                    },
                    success: function (result) {
                        container_no=result.container_no;
                        getContaineroption();
                    }
                });
    }
    var getContaineroption=function(){
            
                        var container_option='<option value="">Select Option</option>';
                        $.each(container_no,function(key,val){
                            container_option+="<option value="+key+">"+val+"</option>";
                        });
             $('.containerID').html(container_option);
    }
    var checkContainerQty=function(container_item){
             var con_flag=0;
            if(typeof container_item!="undefined")
            {
                   

                 $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    url: $('#getcontainerqtystatus').attr('data-url'),
                    method: "POST",
                    data: {
                        container_item:container_item,
                        sales_id:$('#id').val(),
                    },
                    success: function (result) {
                        if(result.status=="false")
                        {

                            return false;
                        }
                        else
                        {
                            return true;
                        }
                        
                        
                    }
                });

                 }
            } 

    var validationForm = function () {


        //passwork check rule
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });

        var btn = $("form :submit");

        $("#articleForm").validate({

            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            // define validation rules
            rules: {
                title:
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
                    required: "Please enter title",
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


        $('.repeater').repeater({

            initEmpty: false,



            show: function (id) {
                var repeaterItems = $("div[data-repeater-item]");
                var repeater_row=repeaterItems.length-1;
                 // containerID-group_a-1  
               if(repeaterItems.length<=10)
                 $(this).slideDown();
                  


                 $('.standardSelect2').select2({
                      placeholder: 'Select a option',
                 });
                $('.Select2').select2({
                      placeholder: 'Select a option',
                 });
                 subjectSelect();

                 var container_option='<option value="1">Select Option</option>';
                        $.each(container_no,function(key,val){
                            container_option+="<option value="+key+">"+val+"</option>";
                        });
                    
                
                 $("#containerID-group_a-"+repeater_row).html(container_option);

              },
            hide: function (deleteElement) {

                message.fire({
                    title: 'Are you sure you want to delete this?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-success shadow-sm mr-2',
                        cancelButton: 'btn btn-danger shadow-sm'
                    },
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.value) {
                        $(this).slideUp(deleteElement);
                            setTimeout(function(){ 
                                var sales_invoice_total=0;
             $('.item_total_amount').each(function(key,val){

                if(this.value!="")
                    sales_invoice_total+=parseFloat(this.value);
            });
             $('#net_total_amount').val(sales_invoice_total.toFixed(2));
                             },500);


                         
                    }

                });

            },
            ready: function (setIndexes) {
                
            },
            

            isFirstItemUndeletable: false,
            maxItems:2,
            
        });


    };

      return {

        //main function to initiate the module
        init: function () {
            validationForm();
            standardSelect();
            subjectSelect();
            getCitybyState();
            date();
            getSubject();
            setContainer();
            checkContainerQty();
          //  getContainerProduct();

        },

    };

}();

jQuery(document).ready(function () {
    KTValidationControls.init();

    /* Form  store action with multiple */
     $(".save-exit-btn").click(function () {
        $("#schoolForm").submit();
    });

    $(".save-add-new").click(function () {
        $('#form_type').val("add_new");
        $("#schoolForm").submit();

    });
    /* Form  store action with multiple */
});
