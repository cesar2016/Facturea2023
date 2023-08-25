
$(function () {

    //** CONSTANTES DE ENTORNO */
    //var URI_API = 'http://127.0.0.1:8000/api/' //LOCAL
    //var TOKEN = '4|RZJvGqIbrlfNUMqSp95uCmWR5YHwodt4ZB27B3aW' // Token Local

    var URI_API = 'http://44.204.35.177/api/'; // AWS Remoto
    var TOKEN = '4|6LMImgFqw0Cfv6QoznsxxOPjwE2fAq8ivtfXAW5P' // AWS Remoto

    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/


    var data = {

        URI_API_AFIP: URI_API,
        token_api_afip: TOKEN,

        date_emition: '2023-04-24',
        date_init: '2023-04-01',
        date_end: '2023-04-15',
        date_expired: '2023-05-01',
        type_concept: 3,
        currencies_types: 'PES',

        id_tax: 3,
        type_doc: 99,
        indetification_client: 26435789,
        firstname: 'Augusto',
        lastname: 'Catedral',
        address_comerce: 'Gral Dorrego 3082, Andaluz, CABA',
        condition_sale: 1,
        iva_front_condition_client: 'Consumidor final',

        details: 'Producto o servicio comprado',
        total_amount: 1500


    }


    // # ENVIO DIRECTO A LA API DE AFIP MIA
    $.ajax({
        type: "get",
        //url : URI_API+`myDatesFisco/find/${1}`,
        url : URI_API+`prueba`,
        data: data,
        dataType: "JSON",
        //Añade un header:
        headers: header,
        //El resto del código
        success : function(data) {

            console.log(data)

        }

    });


    // ## Esta va a mi controlador de app
   /* $.ajax({
        type: "post",
        //url : URI_API+`myDatesFisco/find/${1}`,
        //url : URI_API+`proforma_c`,
        url: '/create_invoice_c',

        data: data,
        dataType: "JSON",
        // Añade un header:
        //headers: header,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        // El resto del código
        success : function(data) {

            console.log(data)

        }

    });*/


 /*   CUITes, Personas Fisicas:
20002307554
20002460123
20188192514
20221062583
20200083394
20220707513
20221124643
20221064233
20201731594
20201797064

CUILes, Personas Fisicas:
20203032723
20168598204
20188153853
20002195624
20002400783
20187850143
20187908303
20187986843
20188027963
20187387443

CUITes, Personas Juridicas:
30202020204
30558515305
30558521135
30558525025
30558525645
30558529535
30558535365
30558535985
30558539565
30558564675
    */







});
