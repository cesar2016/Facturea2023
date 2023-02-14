
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // # Function que maneja los status
    function check_stus(status){


        if(status == 1){
            return `<span class="right badge badge-success">Activo</span>`
        }else{
            return `<span class="right badge badge-danger">Inactivo</span>`
        }

    }


    // *********End/ Variables de entorno **********/
    $('.miSelect1').select2(); // Selectores con intput search

    // # Funcion para cambiar propiedades del form
    function properties_form(valor){

        if(valor == 'new'){

            $('#card card-primary').removeClass('card-warning')
            $('#card-form').attr('class', 'card card-primary')
            $('#text-head-form').html('Agregar Marca')

            $('#btn-form').html(

                `<button id="btn-form-new-brandProducts" type="submit" class="btn btn-primary">Agregar Marca</button>`
            )

        }else{

            $('#card card-primary').removeClass('card-primary')
            $('#card-form').attr('class', 'card card-warning')
            $('#text-head-form').html('Actualizar Marca')

            $('#btn-form').html(

                `<button id="btn-form-update-brandProducts" type="submit" class="btn btn-warning">Actualizar Marca</button>`
            )
        }
    }

    // # Funcion para ver si el form esta abierto o cerrado
    function opene() {

        console.log($('#view-new-brandProducts').is(':visible'))
        return $('#view-new-brandProducts').is(':visible')
        }

        $(document).on('click','#close-form',function(e){

        e.preventDefault();
        $('#view-new-brandProducts').toggle(1000)


    })

    // # Mostrar y Ocultar form
    $('#view-new-brandProducts').hide();
    $('#btn-new-brandProducts').click(function (e) {
        e.preventDefault();

        if( opene() == false ){
            $('#view-new-brandProducts').toggle(1000)
        };

        properties_form('new')
        $("#form-new-brandProducts")[0].reset();

    });

    ////////////////////// End/ Manejo apertura y ciero del Form ////////////////////


    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|

    // # NUEVO INSERT --
    $(document).on('click','#btn-form-new-brandProducts',function(e){

        e.preventDefault();

        const datos_products = $("#form-new-brandProducts").serialize();

        $.ajax({
            type: "POST",
            url: URI_API+'brandProducts',
            data: datos_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#brandProducts').append(

                    `
                    <tbody class='text-danger'>
                        <tr>
                            <td> `+data.name+`</td>
                            <td> `+data.provider.name+` </td>
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

                alert_error('No se pudo guardar este Marca, revisa los errores','Ups...!')

            }

        }).done(function(){
            //alert_add_success('Marca ingresado con exito!', 'Good...!')
            alert_add_success('Marca ingresado con exito!', 'Good...!')

        });

    })

    // # BTN -UPDATE  --
    // Con el value del boton update hace get al metodo
    $(document).on('click','#btn_update',function(e){
        e.preventDefault();

        const idBrandProduct = $(this).val()

        $("#form-new-brandProducts")[0].reset();
        properties_form('update')

        if( opene() == false ){
            $('#view-new-brandProducts').toggle(1000)
        };

        $.ajax({
            type: "GET",
            url : URI_API+`brandProducts/${idBrandProduct}`,
            //data: brandProduct,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                console.log(data)

                $('#idBrandProduct').val(idBrandProduct)

                $('#name').val(data.name)
                $('#status').val(data.status)

                var $option = $('<option>', {
                    value: 10,
                    text: 'TEXTO'
                });

                //$('.miSelect1').select2();
                $(".miSelect1 option[value="+data.provider_id+"]").remove();

                $('.miSelect1').append("<option value="+data.provider_id+" selected >"+data.provider.name+"</option>");

            }

        });


    })

    // # UPDATE --
    // Toma y envio del formulario de Update
    $(document).on('click','#btn-form-update-brandProducts',function(e){

        const datos_update_products = $("#form-new-brandProducts").serialize();

        e.preventDefault();

        const idBrandProduct = $('#idBrandProduct').val();

        $.ajax({
            type: "PUT",
            url : URI_API+`brandProducts/${idBrandProduct}`,
            data: datos_update_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+data.id).hide();
                $('#row'+data.id).empty();
                $('#row'+data.id).toggle(1000);

                $('#row'+idBrandProduct).append(

                    `
                    <td class=''> `+data.name+` </td>
                        <td class=''> `+data.provider.name+` </td>
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

                alert_error('No se pudo modificar este Marca, revisa los errores','Ups...!')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            alert_update_success('Marca actualizado con exito!', 'Good...!')

        });
    })

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete',function(e){

        var idBrandProduct = $(this).val()
        toastr.warning(`Quiere eliminar este Marca? <br /><br /><button type='button' value="`+idBrandProduct+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
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
    function delete_client(idBrandProduct){
        $.ajax({
            type: "DELETE",
            url : URI_API+`brandProducts/${idBrandProduct}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+idBrandProduct).toggle(1000)

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
