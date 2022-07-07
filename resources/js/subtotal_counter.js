const multiply = function () {
    let val1 = parseInt($('#floatingSelectAmount').find(":selected").text()) || 0;
    console.log(val1)
    let val2 = val1 * 39

    $("#subTotal").html('Subtotal: ' + val2 + ' EUR')
};

$("#floatingSelectAmount").click(function() { multiply() })
