
function env(){

    //Obtenemos la url de la API Seteada en el .env
    var data;
    $.ajax({
        type: "GET",
        url: "/env_js",
        async: false,
        success: function(response) { data = response; }
    });

    return data
    //  ****************************************************


}

// const formatDate = (date) => {
//     const [year, month, day, hour] = date.split("-");
//     return `${day}-${month}-${year} ${hour}`;
// };

function formatDate(date) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hour = d.getHours(),
        minute = d.getMinutes(),
        second = d.getSeconds();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [day, month, year].join('-') + ' ' + [hour, minute, second].join(':');
}







