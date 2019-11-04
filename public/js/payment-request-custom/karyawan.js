
var general_el;
var validate_form = false;
var calculate_amount  = function(){
    var total = 0;
    $('.amount').each(function(){
        if($(this).val() != ""){
            total += parseInt($(this).val());
        }
    });

    $('.total_amount').html(numberWithComma(total));
}

var calculate_estimation  = function(){
    var total = 0;
    $('.estimation').each(function(){
        if($(this).val() != ""){
            total += parseInt($(this).val());
        }
    });

    $('.total_estimation').html(numberWithComma(total));
}

$("#add_overtime").click(function(){

    var el = "";

    $("input[name=overtime_item]:checked").each(function(){
        el += '<input type="hidden" name="overtime[]" value="'+ $(this).val() +'" />';
    });

    general_el.parent().parent().find('.content_overtime').html(el);

    $("#modal_overtime").modal('hide');
});

$("#add_modal_bensin").click(function(){

    var cost = $('.modal-cost').val();

    general_el.parent().find("input[name='amount[]']").val(cost);

    var tanggal     = $('.modal_tanggal_struk_bensin').val();
    var odo_from    = $('.modal_odo_from').val();
    var odo_to      = $('.modal_odo_to').val();
    var liter       = $('.modal_liter').val();
    var cost        = $('.modal_cost').val();

    var el = '<div class="bensin"><a class="btn btn-info btn-xs" onclick="info_bensin(this)"><i class="fa fa-info"></i></a><input type="hidden" name="bensin[tanggal][]" value="'+ tanggal +'" />';
        el += '<input type="hidden" name="bensin[odo_from][]" value="'+ odo_from +'" />';
        el += '<input type="hidden" name="bensin[odo_to][]" value="'+ odo_to +'" />';
        el += '<input type="hidden" name="bensin[liter][]" value="'+ liter +'" />';
        el += '<input type="hidden" name="bensin[cost][]" value="'+ cost +'" /></div>';

    general_el.parent().parent().find('.content_bensin').html(el);
    general_el.parent().parent().parent().find("input[name='description[]']").val('Bensin');
    general_el.parent().parent().parent().find("input[name='quantity[]']").val(liter);
    general_el.parent().parent().parent().find("input[name='amount[]']").val(cost);

    $("#form_modal_bensin").trigger('reset');
    $("#modal_bensin").modal("hide");

    calculate_amount();
});


function info_bensin(el)
{
    $("#modal_bensin").modal('show');

    var el = $(el).parent();

    var tanggal = el.find("input[name='bensin[tanggal][]']").val();
    var odo_from = el.find("input[name='bensin[odo_from][]']").val();
    var odo_to = el.find("input[name='bensin[odo_to][]']").val();
    var liter = el.find("input[name='bensin[liter][]']").val();
    var cost = el.find("input[name='bensin[cost][]']").val();

    $('.modal_tanggal_struk_bensin').val(tanggal);
    $('.modal_odo_from').val(odo_from);
    $('.modal_odo_to').val(odo_to);
    $('.modal_liter').val(liter);
    $('.modal_cost').val(cost);

    general_el = el.parent().parent().parent().find("select[name='type[]']");
}

$('#submit_payment').click(function(){
    var tujuan          = $("textarea[name='tujuan']").val();
    var payment_method  = $("input[name='payment_method']:checked").val();

    // validate form 
    if(!tujuan || !payment_method || !validate_form)
    {
        bootbox.alert('Form must be completed!');
        return false;
    }

    bootbox.confirm("Do you want process this Payment Request?", function(result) {
        if(result)
        {
            $("#form_payment").submit();
        }
    });
});

show_hide_add();
cek_button_add();

function show_hide_add()
{       
    validate_form = true;
    
    $('.input').each(function(){
     
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_add()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_add();
        })
        $(this).on('change',function(){
            show_hide_add();
        })
    });
}

$("#btn_cancel_bensin, #btn_cancel_overtime").click(function(){

    $(general_el).val(""); // set default value
});

function select_type_(el)
{
  if($(el).val() == 'Transport(Overtime)')
  {
      $("#modal_overtime").modal("show");
  }else if($(el).val() == 'Gasoline')
  {
      $("#modal_bensin").modal("show");
  }else {
      $(el).parent().parent().find('.bensin').remove();
  }

  $(".estimation").on('input', function(){
      calculate_estimation();
  });

  $(".amount").on('input', function(){
      calculate_amount();
  });

  general_el = $(el);
}

$("#add").click(function(){
    var no = $('.table-content-lembur tr').length;
    var html = '<tr>';
        html += '<td>'+ (no+1) +'</td>';
        html += '<td><div class="col-md-10" style="padding-left:0;">\
                        <select name="type[]" class="form-control input" onchange="select_type_(this)">\
                        <option value=""> - none - </option>\
                        <option>Parking</option>\
                        <option>Gasoline</option>\
                        <option>Toll</option>\
                        <option>Transportation</option>\
                        <option>Transport(Overtime)</option>\
                        <option>Others</option></select></div>';

        html += '<div class="content_bensin"></div><div class="content_overtime"></div></td>';
        html += '<td class="description_td"><input type="text" class="form-control input" name="description[]"></td>';
        html += '<td><input type="number" name="quantity[]" value="1" class="form-control input" /></td>';
        //html += '<td><input type="number" name="estimation_cost[]" class="form-control estimation" /></td>';
        html += '<td><input type="number" name="amount[]" class="form-control amount" /></td>';
        html += '<td><input type="number" name="amount_approved[]" class="form-control" readonly="true" /></td>';
        html += '<td><input type="file" name="file_struk[]" class="form-control input" /></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_item(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-lembur').append(html);

    $('.estimation').on('input', function(){

        var total = 0;

        $('.estimation').each(function(){

            if($(this).val() != "")
            {
                total += parseInt($(this).val());
            }
        });

        $('.total').html('Rp. '+ numberWithComma(total));
    });

    show_hide_add();
    cek_button_add();
});

function delete_item(el)
{
    if(confirm('Hapus data ini?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();

            setTimeout(function(){
                show_hide_add();
                cek_button_add();
            });
        });

        
    }
}
