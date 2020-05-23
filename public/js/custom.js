$(document).ready(function() {
    var wrapper = $(".add-items");
    var add_button = $(".add-item-to-invoice");

    $('.invoice-item-input').off('input', calculateTotalRow);
    $('.invoice-item-input').on('input', calculateTotalRow);
    
    var x = 1;
    $(add_button).on('click', function(e) {
        e.preventDefault();
        x++;
        $(wrapper).append(`<div class="form-row">
                            <div class="col">
                                <input class="form-control" type="text" name="itemname[]" placeholder="Nombre"/>
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" name="itemdescription[]" placeholder="Descripción"/>
                            </div>
                            <div class="col">
                                <input id="qty`+x+`" class="form-control invoice-item-input" line="`+x+`" type="number" min="1" step="1" name="itemqty[]" placeholder="Cantidad"/>
                            </div>
                            <div class="col">
                                <input id="price`+x+`" class="form-control invoice-item-input" line="`+x+`" type="number" step="0.01" name="itemprice[]" placeholder="Precio"/>
                            </div>
                            <div class="col">
                                <input id="taxrate`+x+`" class="form-control invoice-item-input" line="`+x+`" type="number" step="0.01" name="taxrate[]" value="21"/>
                            </div>
                            <div class="col">
                                %
                            </div>
                            <div class="col">
                                <input class="form-control total" id="total`+x+`" type="text" placeholder="total" readonly/>
                            </div>
                            <input id="subtotal`+x+`" type="hidden">
                            <input id="iva`+x+`" type="hidden">
                            <a href="#" class="delete">
                                <i class="material-icons">delete</i>
                            </a>
                            </div>`); //add input box
        $('.invoice-item-input').off('input', calculateTotalRow);
        $('.invoice-item-input').on('input', calculateTotalRow);
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        calculateInvoiceTotals();
        //x--;
    });

    $('.alert-success').fadeIn().delay(5000).fadeOut();
    $('.alert-danger').fadeIn().delay(5000).fadeOut();

    $('.change-invoice-select').on('change', function (e) {
        $('#invoice-status').submit();
    });

    // Client autocomplete code in create invoice view
    $('input.typeahead').keyup(function(){
        var query = $(this).val();
        console.log(query);
        if(query != '') {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            //url:"/admin/public/client/search", // URL Producción
            url:"/client/search", // URL Local
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data) {
                $('#clientList').html(data);
                $('#clientList').fadeIn();
            }
            });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#client').val($(this).text());  
        $('#clientList').fadeOut();  
    });  
    //

    function calculateTotalRow(e){
        var row = $(this).attr('line');
        if ( $('#qty'+row).val() === '') { var qty = 0; } else { var qty = $('#qty'+row).val(); }
        if ( $('#price'+row).val() === '') { var price = 0; } else { var price = $('#price'+row).val(); }
        if ( $('#taxrate'+row).val() === '') { var taxrate = 0; } else { var taxrate = $('#taxrate'+row).val(); }
        var total = qty * price; 
        $('#subtotal'+row).val(total.toFixed(2));
        $('#iva'+row).val((total * (taxrate/100)).toFixed(2));
        var totalWIva = total + (total * (taxrate/100));
        $('#total'+row).val(totalWIva.toFixed(2));

        calculateInvoiceTotals();
    }

    function calculateInvoiceTotals() {
        var subtotal = 0;
        var iva = 0;
        var total = 0;
        for (var i = 0; i <= x; i++) {
            if ($('#subtotal'+i).length) {
            subtotal = parseFloat(subtotal) + parseFloat($('#subtotal'+i).val());
            iva = parseFloat(iva) + parseFloat($('#iva'+i).val());
            total = parseFloat(total) + parseFloat($('#total'+i).val());
            }
        }
        $('#grandSubTotal').val(subtotal.toFixed(2));
        $('#grandIva').val(iva.toFixed(2));
        $('#grandTotal').val(total.toFixed(2));
    }

    // PUT YOUR CUSTOM CODE HERE
});