// init
price_format();


jQuery('.datepicker').datepicker({
    dateFormat: 'yy/mm/dd',
    changeMonth: true,
    changeYear: true
});

$('#data_table_no_copy').DataTable({
    dom: 'Bfrtip',
     buttons: []
});

$('#data_table_no_copy2').DataTable({
    dom: 'Bfrtip',
     buttons: []
});

$('#data_table_no_copy3').DataTable({
    dom: 'Bfrtip',
     buttons: []
});


$('#data_table').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ],
    pageLength: 100
});

$('#data_table2').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$('#data_table2_no_search').DataTable({
    dom: 'Bfrtip',
    searching: false,
    pageLength: 30,
    buttons: [
        
    ]
});

$('#data_table3').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$('.data_table').each(function(){

    $(this).DataTable({
        dom: 'Bfrtip',
        searching: false,
        pageLength: 30,
        bPaginate: false,
        bInfo: false,
        buttons: [
            
        ]
    });
});

/**
 * [numberWithComma description]
 * @param  {[type]} x [description]
 * @return {[type]}   [description]
 */
function numberWithComma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function numberWithDot(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function price_format()
{
  $('.price_format').priceFormat({
      prefix: '',
      centsSeparator: '.',
      thousandsSeparator: '.',
      clearOnEmpty: true,
      centsLimit : 0
  });
}

$("#data_table_no_search").DataTable({
    dom: 'Bfrtip',
    searching: false,
    pageLength: 30,
    buttons: [
        
    ]
});

$("#data_table_no_pagging").DataTable({
    dom: 'Bfrtip',
    searching: false,
    pageLength: 30,
    bPaginate: false,
    bInfo: false,
    buttons: [
        
    ]
});

$(".data_table_no_pagging").each(function(){
    $(this).DataTable({
      dom: 'Bfrtip',
      searching: false,
      pageLength: 30,
      bPaginate: false,
      bInfo: false,
      buttons: [
          
      ]
  });
});

function _confirm(msg, url)
{
  if(msg == "") return false;

  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> EMPORE SYSTEM",
    message: msg,
    closeButton: false,
    backdrop: true,
    buttons: {
        confirm: {
            label: '<i class="fa fa-trash"></i> Yes',
            className: 'btn btn-sm btn-danger'
        },
        cancel: {
            label: '<i class="fa fa-close"></i> No',
            className: 'btn btn-sm btn-default btn-outline'
        }
    },
    callback: function (result) {
      if(result)
      { 
        document.location = url;
      }
    }
  });

  return false;
}

function _confirm_submit(msg, form)
{
  if(msg == "") return false;

  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> EMPORE SYSTEM",
    message: msg,
    closeButton: false,
    backdrop: true,
    buttons: {
        confirm: {
            label: '<i class="fa fa-check"></i> Yes',
            className: 'btn btn-sm btn-success'
        },
        cancel: {
            label: '<i class="fa fa-close"></i> No',
            className: 'btn btn-sm btn-default btn-outline'
        }
    },
    callback: function (result) {
      if(result)
      { 
        form.trigger('submit');
      }
    }
  });

  return false;
}




/**
 * [alert_ description]
 * @param  {[type]} msg [description]
 * @return {[type]}     [description]
 */
function _alert(msg)
{
  if(msg == "") return false;

  bootbox.alert({
    title : "<i class=\"fa fa-check-square text-success\"></i> EMPORE SYSTEM",
    closeButton: false,
    message: msg,
    backdrop: true,
     buttons: {
        ok: {
            label: 'OK',
            className: 'btn btn-sm btn-success'
        },
    },
  })
}

function _alert_error(msg)
{
  if(msg == "") return false;

  bootbox.alert({
    title : "<i class=\"fa fa-exclamation-triangle text-danger\"></i> EMPORE SYSTEM",
    closeButton: false,
    message: msg,
    backdrop: true,
     buttons: {
        ok: {
            label: 'OK',
            className: 'btn btn-sm btn-success'
        },
    },
  })
}

/**
 * [_confirm description]
 * @param  {[type]} msg [description]
 * @return {[type]}     [description]
 */
function confirm_delete(msg, el)
{
  if(msg == "") return false;

  bootbox.confirm({
    title : "<i class=\"fa fa-warning\"></i> EMPORE SYSTEM",
    message: msg,
    closeButton: false,
    backdrop: true,
    buttons: {
        confirm: {
            label: 'Yes',
            className: 'btn btn-sm btn-success'
        },
        cancel: {
            label: 'No',
            className: 'btn btn-sm btn-danger'
        }
    },
    callback: function (result) {
      if(result)
      { 
           $(el).parent().submit();
      }
      
    }
  });

  return false;
}