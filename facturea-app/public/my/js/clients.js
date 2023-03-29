
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    // # Funcion para cambiar propiedades del form
    function properties_form(valor){

        if(valor == 'new'){

            $('#card card-primary').removeClass('card-warning')
            $('#card-form').attr('class', 'card card-primary')
            $('#text-head-form').html('Agregar Cliente')

            $('#btn-form').html(

                `<button id="btn-form-new-client" type="submit" class="btn btn-primary">Agregar cliente</button>`
            )

        }else{

            $('#card card-primary').removeClass('card-primary')
            $('#card-form').attr('class', 'card card-warning')
            $('#text-head-form').html('Actualizar Cliente')

            $('#btn-form').html(

                `<button id="btn-form-update-client" type="submit" class="btn btn-warning">Actualizar cliente</button>`
            )
        }
    }

    // # Funcion para ver si el form esta abierto o cerrado
    function opene() {

        console.log($('#view-new-client').is(':visible'))
        return $('#view-new-client').is(':visible')
        }

        $(document).on('click','#close-form',function(e){

        e.preventDefault();
        $('#view-new-client').toggle(1000)


    })

    // # Mostrar y Ocultar form
    $('#view-new-client').hide();
    $('#btn-new-client').click(function (e) {
        e.preventDefault();

        if( opene() == false ){
            $('#view-new-client').toggle(1000)
        };

        properties_form('new')
        $("#form-new-client")[0].reset();

    });

    ////////////////////// End/ Manejo apertura y cierre del Form ////////////////////


    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|

    // # NUEVO INSERT --
    $(document).on('click','#btn-form-new-client',function(e){

        e.preventDefault();

        const datos_products = $("#form-new-client").serialize();

        $.ajax({
            type: "POST",
            url: URI_API+'clients',
            data: datos_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#clients').append(

                    `
                    <tbody class='text-danger'>
                        <tr>
                            <td> `+data.name+` `+data.lastname+` </td>
                            <td> `+data.dni+` </td>
                            <td> `+data.address+` </td>
                            <td> `+data.city+` </td>
                            <td> `+data.phone+` </td>
                            <td> `+data.email+` </td>
                            <td>
                                <button id='btn_update' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-pen text-info'> </i>
                                </button>
                                <button id='btn_delete' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-trash text-danger '></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    `
                )


            },

            error:function (response){
                $.each(response.responseJSON.errors,function(field_name, error){
                    $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
                })

                alert_error('No se pudo guardar este cliente, revisa los errores','Ups...!')

            }

        }).done(function(){
            alert_add_success('Cliente ingresado con exito!', 'Good...!')

        });

    })

    // # BTN -UPDATE  --
    // Con el value del boton update hace get al metodo
    $(document).on('click','#btn_update',function(e){
        e.preventDefault();

        const idClient = $(this).val()

        $("#form-new-client")[0].reset();
        properties_form('update')

        if( opene() == false ){
            $('#view-new-client').toggle(1000)
        };

        $.ajax({
            type: "GET",
            url : URI_API+`clients/${idClient}`,
            data: idClient,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                $('#idClient').val(idClient)

                $('#name').val(data.name)
                $('#lastname').val(data.lastname)
                $('#dni').val(data.dni)
                $('#email').val(data.email)
                $('#address').val(data.address)
                $('#city').val(data.city)
                $('#phone').val(data.phone)

            }

        });


    })

    // # UPDATE --
    // Toma y envio del formulario de Update
    $(document).on('click','#btn-form-update-client',function(e){

        const datos_update_products = $("#form-new-client").serialize();

        e.preventDefault();

        const idClient = $('#idClient').val();

        $.ajax({
            type: "PUT",
            url : URI_API+`clients/${idClient}`,
            data: datos_update_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+data.id).hide();
                $('#row'+data.id).empty();
                $('#row'+data.id).toggle(1000);

                $('#row'+idClient).append(

                    `
                        <td class=''> `+data.name+` `+data.lastname+` </td>
                        <td class=''> `+data.dni+` </td>
                        <td class=''> `+data.address+` </td>
                        <td class=''> `+data.city+` </td>
                        <td class=''> `+data.phone+` </td>
                        <td class=''> `+data.email+` </td>
                        <td class=''>
                            <button id='btn_update' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-pen text-info'> </i>
                            </button>
                            <button id='btn_delete' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-trash text-danger '></i>
                            </button>
                        </td>

                    `
                )


            },

            error:function (response){
                $.each(response.responseJSON.errors,function(field_name, error){
                    $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
                })

                alert_error('No se pudo modificar este cliente, revisa los errores','Ups...!')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            alert_update_success('Cliente actualizado con exito!', 'Good...!')

        });
    })

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete',function(e){

        var idClient = $(this).val()
        toastr.warning(`Quiere eliminar este cliente? <br /><br /><button type='button' value="`+idClient+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
        {
            closeButton: true,
            allowHtml: true,
            progressBar: true,
            onShown: function (toast) {
                $("#confirmationButtonYes").click(function(){
                    delete_client($(this).val())
                });
            }
        });

    })


    // # DELETE --
    // Si se confirma, esta fnction recibe un parametro id para delete
    function delete_client(idClient){
        $.ajax({
            type: "DELETE",
            url : URI_API+`clients/${idClient}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+idClient).toggle(1000)

            },

            error:function (response){
                $.each(response.responseJSON.errors,function(field_name, error){
                    $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
                })

                alert('Ups!, encontramos algunos errores')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            //console.log('termino la ejecucion')

        });
    }

    // -------------------------------------------------------------------|
    // ## ---------------- End/ MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|


    // ### PRESENTACION DE LAS ALETAS DE PAGO - VENCIMIENTOS ###

    function deyPased(date_payment){
        var dateCurrent = new Date();
        var dateFuture = new Date(date_payment);
        var result = Math.abs(dateFuture - dateCurrent)/1000;
        var days = Math.floor(result/86400);
        return days;
    }



    $.ajax({
        type: "GET",
        url : URI_API+`last_pay`,
        //data: datos_update_products,
        headers: header,
        dataType: "JSON",
        success: function(data)
        {

            console.log(data)
            $.each(data, function(index, value){

                let num = deyPased(value.date_payment);
                let color = num < 25 ? "success" : num > 25 && num < 30 ? "warning" : num >= 30 ? "danger" : ""

                $('#date_expired'+value.client_id).append(

                    `   <h4>
                            <a href='client_acount/`+value.client_id+`' ><small title='Su ultimo pago fue hace ` +num+ ` dias ' class="badge badge-` +color+ `">
                                <i class="far fa-clock"><b> ` +num+ ` </b></i></small>
                            </small></a>
                        </h4>
                    `

                )


            });

        }

    });



});
