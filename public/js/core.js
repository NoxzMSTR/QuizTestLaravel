function ajaxSendData(url, type, data, element, dataType = 'json') {
    return new Promise(function(resolve, reject) {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            beforeSend: function() {
                $('.showLoader').show()
            },
            success: function(data) {
                resolve(data)
                $('.showLoader').hide()
            },
            error: function(xhr) { // if error occured
                reject(xhr)
                $('.showLoader').hide()
            },
            complete: function() {
                $('.showLoader').hide()
            },
            dataType: dataType
        });
    });
}