/**
 * [numberWithComma description]
 * @param  {[type]} x [description]
 * @return {[type]}   [description]
 */
function numberWithComma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('.price_format').priceFormat({
    prefix: '',
    centsSeparator: '.',
    thousandsSeparator: ',',
    clearOnEmpty: true,
    centsLimit : 0
});

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

function confirm_delete(msg, el)
{
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "No, cancel!",
                value: null,
                visible: true,
                className: "btn-warning",
                closeModal: true,
            },
            confirm: {
                text: "Yes, delete it!",
                value: true,
                visible: true,
                className: "",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            $(el).parent().submit();
        }
    });
}

function _confirm(msg)
{
    swal({
        title: "Are you sure?",
        text: msg,
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "No, cancel!",
                value: null,
                visible: true,
                className: "btn-warning",
                closeModal: true,
            },
            confirm: {
                text: "Yes, publish it!",
                value: true,
                visible: true,
                className: "",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {
            document.location = url;
        }
    });

    return false;
}