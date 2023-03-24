$('#button').click(function () {

    var Umobile_number = $('#mobile_number').val();
    var Uamount = $('#amount').val();
    var Upayment_code = $('#payment_code').val();

    $.ajax({
        method: "POST",
        url: 'AjaxView.php',
        data: {mobile_number: Umobile_number, amount: Uamount, payment_code: Upayment_code},
        success: function (data) {
            $('#feedback').html(data)
        }
    });
});