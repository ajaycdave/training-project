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
        var table = $('#salesDataTable');

        
         // begin first table
        table.DataTable({
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
