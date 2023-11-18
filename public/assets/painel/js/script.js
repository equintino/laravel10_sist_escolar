goBack = function(back) {
    window.history.go(back)
};

$("select[name='turma']").on("change", function() {
    descricao = $(this).find(":selected").text();
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'JSON',
        data: {
            descricao: descricao
        },
        beforeSend: function() {
        },
        success: function(response) {
            $("select[name=turno]").find("option").remove();
            let html = "<option value=''></option>";
            for(let i in response) {
                let value = response[i].substr(0,1).toUpperCase();
                html += "<option value='" + value + "'>" + response[i] + "</option>";
            }
            $("select[name=turno]").append(html);
        },
        error: function(error) {
            console.log(error);
        },
        complete: function() {
        }
    });
});
