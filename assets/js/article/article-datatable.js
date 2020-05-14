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
                    $('#standardID').val("").change();
                    $('#subjectID').val("").change();
                    $('#chapterID').val("").change();
                    $('#addquestionType').val("").change();

                $('#questionDataTable').DataTable().destroy();
                   initSubjectTable();
     });

    $("#btn_search").on("click", function(){
                  $('#questionDataTable').DataTable().destroy();
                   initSubjectTable();
            });
  }
     
    var initSubjectTable = function() {
        var table = $('#articleDataTable');

        
         // begin first table
         table.DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#articleDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "status"
                },
                {
                    "data": "action"
                }
            ],
            'columnDefs': [ {
              'targets': [2,3], 
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
         
            //initSearchDataTable();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesDataSourceHtml.init();
    $('#standardID').on('change', function (e) {
        $('#subjectID').val('').trigger('change');
        $('#chapterID').val('').trigger('change');
    });
    $('#subjectID').on('change', function (e) {
        $('#chapterID').val('').trigger('change');
    });

});
