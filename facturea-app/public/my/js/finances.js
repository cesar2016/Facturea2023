
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DE FINANZAS -------------------|
    //--------------------------------------------------------------------|

    $('#content-daily-finance').hide()
    $('.close').on('click', function(){
        toggle_daily_cash()

    })



    function toggle_daily_cash(){
        $('#content-daily-finance').toggle(1000)
    }
    // # NUEVO INSERT --
    $(document).on('click','#btn-daily-cash',function(e){

        e.preventDefault();
        toggle_daily_cash()
        clear_elemnts()

        $.ajax({
            type: "GET",
            url : URI_API+`daily_cash`,
            //data: datos_update_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                console.log(data.sum_debt)


                $('#sum_debt').html('$ '+data.sum_debt)
                $('#sum_payment').html('$ '+(data.sum_payment - data.sum_countdown))
                $('#sum_countdown').html('$ '+data.sum_countdown)
                $('#date_report').html(data.date_format)
                $('#street_cash').html('$ '+data.street_cash)


                $.each(data['report'], function( i, value ) {

                    $('#table-finance').append(

                        `<tr>
                            <td class=''> `+data.date_format+` </td>
                            <td class=''> `+value.name+` `+value.lastname+` </td>
                            <td class=''> `+value.identificator_sale+`</td>
                            <td class=''> `+value.debt+`</td>
                            <td class=''> `+value.payment+`</td>
                            <td class=''> - `+value.countdown+`</td>
                        </tr>
                        `
                    )


                })



            }

        });

    })

    $(document).on('submit','#form-frame-cahs',function(e){

        e.preventDefault();
        toggle_daily_cash()
        clear_elemnts()

        var data = $('#form-frame-cahs').serialize();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            type: "POST",
            url : URI_API+`frame_cash`,
            data: data,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                console.log(data.sum_debt)


                $('#sum_debt').html('$ '+data.sum_debt)
                $('#sum_payment').html('$ '+(data.sum_payment - data.sum_countdown))
                $('#sum_countdown').html('$ '+data.sum_countdown)
                $('#date_report').html( 'desde '+formatearFecha($('#from').val())+' hasta '+formatearFecha($('#until').val()) )
                $('#street_cash').html('$ '+data.street_cash)

                $.each(data['report'], function( i, value ) {

                    $('#table-finance').append(

                        `<tr>
                            <td class=''> `+formatearFecha(value.date_payment)+` </td>
                            <td class=''> `+value.name+` `+value.lastname+` </td>
                            <td class=''> `+value.identificator_sale+`</td>
                            <td class=''> `+value.debt+`</td>
                            <td class=''> `+value.payment+`</td>
                            <td class=''> - `+value.countdown+`</td>
                        </tr>
                        `
                    )


                })



            }

        });

    })

    function clear_elemnts(){

        $('#sum_debt').empty()
        $('#sum_payment').empty()
        $('#sum_countdown').empty()
        $('#date_report').empty()
        $('#street_cash').empty()
        $('#table-finance').empty()
    }


    function formatearFecha(fecha) {
        // Extraer la fecha del string
        const date = new Date(fecha);

        // Formatear la fecha
        const fechaFormateada = date.toLocaleDateString("es-ES", {
          format: "dd-MM-yyyy",
        });

        // Devolver la fecha formateada
        return fechaFormateada;
      }





});
