$(document).ready(function() {
    var wrapper = $(".add-items");
    var add_button = $(".add-item-to-invoice");

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
                                <input class="form-control" type="number" min="1" step="1" name="itemqty[]" placeholder="Cantidad"/>
                            </div>
                            <div class="col">
                                <input class="form-control" type="number" step="0.01" name="itemprice[]" placeholder="Precio"/>
                            </div>
                            <a href="#" class="delete">
                                <i class="material-icons">delete</i>
                            </a>
                            </div>`); //add input box
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    $(document).ready(function(){
        $('.alert-success').fadeIn().delay(5000).fadeOut();
        $('.alert-danger').fadeIn().delay(5000).fadeOut();
    });

    // PUT YOUR CUSTOM CODE HERE
});