$.ajaxSetup({cache: false})

function ajax(url, params, callback) {
    $.ajax({
        type: "POST",
        url: url,
        dataType: "json",
        data: params,
        async: true,
    }).done(function(response) {
        callback(response);
    });
}