"use strict";
var KTDatatablesDataSourceHtml = function() {
    var initWidgets = function() {
        // select2
        /*$('.select').select2({
            placeholder: 'Select a option',
        });*/
    }
  var initSearchDataTable=function()
  {
                $('#btn_clear').on("click",function(){
                    $('#categoryID').val("").change();
                    $('#search_thread').val('');

                $('#threadDataTable').DataTable().destroy();
                   initSubjectTable();
     });

    $("#btn_search").on("click", function(){


                  $('#threadDataTable').DataTable().destroy();
                   initSubjectTable();
            });
  }
     
    var initSubjectTable = function() {
        var table = $('#threadDataTable');

        
         // begin first table
         table.DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#threadDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": {
                        categoryID: $('#categoryID').val(),
                        searchText:$('#search_thread').val(),
                        
                    }
                /*"data": function (d) {
                    return $.extend({}, d, {});
                }*/
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [
                {
                    "data": "name"
                },
                {
                  "data":"description"
                },
                {
                  "data":"category_name"
                },
                
               
                
            ],
            'columnDefs': [ {
              'targets': [0,1], 
              'orderable': false, 
             }],
            "drawCallback": function( settings, start, end, max, total, pre ) {  
            //console.log(this.fnSettings().json); /* for json response you can use it also*/ 
             //alert(this.fnSettings().fnRecordsTotal()); // total number of rows
             $('#kt_subheader_total').html(this.fnSettings().fnRecordsTotal()+' Total');
    }
        });

    };

    return {
       //main function to initiate the module
        init: function() {
            initWidgets();
            initSubjectTable();
            initSearchDataTable();
         
            //initSearchDataTable();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesDataSourceHtml.init();
   

});
