
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    // # Function que maneja los status
    function check_stus(status){


        if(status == 1){
            return `<span class="right badge badge-success">Activo</span>`
        }else{
            return `<span class="right badge badge-danger">Inactivo</span>`
        }

    }


    // # Funcion para cambiar propiedades del form
    function properties_form(valor){

        if(valor == 'new'){

            $('#card card-primary').removeClass('card-warning')
            $('#card-form').attr('class', 'card card-primary')
            $('#text-head-form').html('Agregar Proveedor')

            $('#btn-form').html(

                `<button id="btn-form-new-provider" type="submit" class="btn btn-primary">Agregar proveedor</button>`
            )

        }else{

            $('#card card-primary').removeClass('card-primary')
            $('#card-form').attr('class', 'card card-warning')
            $('#text-head-form').html('Actualizar Proveedor')

            $('#btn-form').html(

                `<button id="btn-form-update-provider" type="submit" class="btn btn-warning">Actualizar proveedor</button>`
            )
        }
    }

    // # Funcion para ver si el form esta abierto o cerrado
    function opene() {

        console.log($('#view-new-provider').is(':visible'))
        $('#percent').prop('hidden', true) // Input del aumento por %
        return $('#view-new-provider').is(':visible')
        }

        $(document).on('click','#close-form',function(e){

        e.preventDefault();
        $('#view-new-provider').toggle(1000)


    })

    // # Mostrar y Ocultar form
    $('#view-new-provider').hide();
    $('#percent').prop('hidden', true) // Input del aumento por %

    $('#btn-new-provider').click(function (e) {
        e.preventDefault();

        if( opene() == false ){
            $('#view-new-provider').toggle(1000)
        };

        properties_form('new')
        $("#form-new-provider")[0].reset();

    });

    // # Manejo de la seleccion de los radioButtons
    function status_select(){
        if($('#status_a').is(':checked')) {

            $('#status').val(1)
         }

         if($('#status_i').is(':checked')) {

            $('#status').val(0)
         }
    }
    $(document).on('click','#checkes_select',function(e){

        status_select()
    })




    ////////////////////// End/ Manejo apertura y ciero del Form ////////////////////


    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|

    // # NUEVO INSERT --
    $(document).on('click','#btn-form-new-provider',function(e){

        e.preventDefault();

        const datos_provider = $("#form-new-provider").serialize();
        $.ajax({
            type: "POST",
            url: URI_API+'providers',
            data: datos_provider,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#providers').append(

                    `
                    <tbody class='text-danger'>
                        <tr>
                            <td> `+data.name+` </td>
                            <td> `+data.cuit+` </td>
                            <td> `+data.address+` </td>
                            <td> `+data.city+` </td>
                            <td> `+data.phone+` </td>
                            <td> `+data.email+` </td>
                            <td> `+check_stus(data.status)+` </td>
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

                alert_error('No se pudo guardar este proveedor, revisa los errores','Ups...!')

            }

        }).done(function(){
            alert_add_success('Proveedor ingresado con exito!', 'Good...!')

        });

    })

    // # BTN -UPDATE  --
    // Con el value del boton update hace get al metodo
    $(document).on('click','#btn_update',function(e){
        e.preventDefault();
        status_select()
        const idProvider = $(this).val()

        $("#form-new-provider")[0].reset();
        properties_form('update')

        if( opene() == false ){
            $('#view-new-provider').toggle(1000)
        };

        $.ajax({
            type: "GET",
            url : URI_API+`providers/${idProvider}`,
            data: idProvider,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {


                if(data.status == 0){

                    $('#status_a').prop('checked', false)
                    $('#status_i').prop('checked', true)
                    $('#status').val(0)

                }

                $('#idProvider').val(idProvider)
                $('#name').val(data.name)
                $('#cuit').val(data.cuit)
                $('#address').val(data.address)
                $('#city').val(data.city)
                $('#phone').val(data.phone)
                $('#email').val(data.email)
                $('#percent').attr('hidden', false)
                $('#status').val(data.status)


            }

        });


    })

    // # UPDATE --
    // Toma y envio del formulario de Update
    $(document).on('click','#btn-form-update-provider',function(e){

        const datos_update_provider = $("#form-new-provider").serialize();

        e.preventDefault();

        const idProvider = $('#idProvider').val();

        $.ajax({
            type: "PUT",
            url : URI_API+`providers/${idProvider}`,
            data: datos_update_provider,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {
                $('#row'+data.id).hide();
                $('#row'+data.id).empty();
                $('#row'+data.id).toggle(1000);

                $('#row'+idProvider).append(

                    `
                        <td> `+data.name+` </td>
                        <td> `+data.cuit+` </td>
                        <td> `+data.address+` </td>
                        <td> `+data.city+` </td>
                        <td> `+data.phone+` </td>
                        <td> `+data.email+` </td>
                        <td> `+check_stus(data.status)+` </td>
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

                alert_error('No se pudo modificar este proveedor, revisa los errores','Ups...!')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            alert_update_success('Proveedor actualizado con exito!', 'Good...!')

        });
    })

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete',function(e){

        var idProvider = $(this).val()
        toastr.warning(`Quiere eliminar este Proveedor? <br /><br /><button type='button' value="`+idProvider+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
        {
            closeButton: true,
            allowHtml: true,
            progressBar: true,
            onShown: function (toast) {
                $("#confirmationButtonYes").click(function(){
                    delete_provider($(this).val())
                });
            }
        });

    })


    // # DELETE --
    // Si se confirma, esta fnction recibe un parametro id para delete
    function delete_provider(idProvider){
        $.ajax({
            type: "DELETE",
            url : URI_API+`providers/${idProvider}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+idProvider).toggle(1000)

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








});
