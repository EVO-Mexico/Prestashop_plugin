var cashier = com.myriadpayments.api.cashier();
cashier.init(
    {baseUrl: evomodule['baseUrl']}
);

function handleResult(data) {
    var status = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: evomodule['baseUri'] + "index.php?fc=module&module=evopayments&controller=ajax",
        data: "typerequest=payment&status=" + status + "&token=" + evomodule['evotoken'] + "&cart=" + evomodule['cartId'] + "&retry=" + evomodule['retry'] + "",
        cache: false,
        success: function (data) {
            if (data == 'error_status') {
                alert('Problem with status payment!');
            } else {
                if (data != '') {
                    $('#statusPayment').val(status.replace(/"/g, ""));
                    $('#evoPayment').val(data.replace(/"/g, ""));
                    $('#submitpayment').submit();
                } else {
                    alert('Error');
                }
            }
        },
        error: function () {
            alert('Error');
        }
    });
}

function pay() {
    var token = evomodule['token'];
    var merchantId = evomodule['merchantId'];
    cashier.show(
        {
            containerId: "payMethods",
            merchantId: merchantId,
            token: token,
            successCallback: handleResult,
            failureCallback: handleResult,
            cancelCallback: handleResult
        }
    );
}

$(document).ready(function () {
    if (typeof evomodule['paymentType'] != 'undefined' && evomodule['paymentType'] == '1') {
        pay();
    }
});