
function env(){

    //Obtenemos la url de la API Seteada en el .env
    var data;
    $.ajax({
        type: "GET",
        url: "env_js",
        async: false,
        success: function(response) { data = response; }
    });

    return data
    //  ****************************************************


}




