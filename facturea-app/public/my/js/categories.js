
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // # Function que maneja los status
    // function check_stus(status){


    //     if(status == 1){
    //         return `<span class="right badge badge-success">Activo</span>`
    //     }else{
    //         return `<span class="right badge badge-danger">Inactivo</span>`
    //     }

    // }


    // *********End/ Variables de entorno **********/
    //$('.miSelect_catyegory').select2(); // Selectores con intput search

    // # Funcion para cambiar propiedades del form
    function properties_form_category(valor){


        if(valor == 'new'){

            $('#card card-primary').removeClass('card-warning')
            $('#card-form').attr('class', 'card card-primary')
            $('#text-head-form').html('Agregar Categoria')

            $('#btn-form_category').html(

                `<button id="btn-form-new-category" type="submit" class="btn btn-primary">Agregar Categoria</button>`
            )

        }else{

            $('#card card-primary').removeClass('card-primary')
            $('#card-form').attr('class', 'card card-warning')
            $('#text-head-form').html('Actualizar Categoria')

            $('#btn-form_category').html(

                `<button id="btn-form-update-category" type="submit" class="btn btn-warning">Actualizar Categoria</button>`
            )
        }
    }

    // # Funcion para ver si el form esta abierto o cerrado
    function opene() {

        return $('#view-new-category').is(':visible')
        }

        $(document).on('click','#close-form_category',function(e){

        e.preventDefault();
        $('#view-new-category').toggle(1000)


    })

    // # Mostrar y Ocultar form
    $('#view-new-category').hide();
    $('#btn-new-category').click(function (e) {
        e.preventDefault();

        if( opene() == false ){
            $('#view-new-category').toggle(1000)
        };

        properties_form_category('new')
        $("#name_category").val('');

    });

    ////////////////////// End/ Manejo apertura y ciero del Form ////////////////////


    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|

    // # NUEVO INSERT --
    $(document).on('click','#btn-form-new-category',function(e){

        e.preventDefault();

         const datos_category = {

            name: $('#name_category').val().toUpperCase(),
            status: $('#status_category').val()

         }

        $.ajax({
            type: "POST",
            url: URI_API+'categories',
            data: datos_category,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#category').append(

                    `
                    <tbody class='text-danger'>
                        <tr>
                            <td> `+data.name+`</td>
                            <td>
                                <button id='btn_update_category' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-pen text-info'> </i>
                                </button>
                                <button id='btn_delete_category' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
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

                alert_error('No se pudo guardar este Categoria, revisa los errores','Ups...!')

            }

        }).done(function(){
            //alert_add_success('Categoria ingresado con exito!', 'Good...!')
            alert_add_success('Categoria ingresado con exito!', 'Good...!')

        });

    })

    // # BTN -UPDATE  --
    // Con el value del boton update hace get al metodo
    $(document).on('click','#btn_update_category_category',function(e){
        e.preventDefault();

        const idCategory = $(this).val()

        $("#name_category").val('');

        properties_form_category('update')

        if( opene() == false ){
            $('#view-new-category').toggle(1000)
        };

        $.ajax({
            type: "GET",
            url : URI_API+`categories/${idCategory}`,
            //data: brandProduct,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                console.log(data)

                $('#idCategory').val(idCategory)
                $('#name_category').val(data.name)
                // $('#status_category').val(data.status)

                var $option = $('<option>', {
                    value: 10,
                    text: 'TEXTO'
                });

                //$('.miSelect_catyegory').select2();
                //$(".miSelect_catyegory option[value="+data.provider_id+"]").remove();

                //$('.miSelect_catyegory').append("<option value="+data.provider_id+" selected >"+data.provider.name+"</option>");

            }

        });


    })

    // # UPDATE --
    // Toma y envio del formulario de Update
    $(document).on('click','#btn-form-update-category',function(e){

        const datos_update_category = {

            name: $('#name_category').val().toUpperCase(),
            status: $('#status_category').val()

         }

        e.preventDefault();

        const idCategory = $('#idCategory').val();

        $.ajax({
            type: "PUT",
            url : URI_API+`categories/${idCategory}`,
            data: datos_update_category,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row_category'+data.id).hide();
                $('#row_category'+data.id).empty();
                $('#row_category'+data.id).toggle(1000);


                $('#row_category'+idCategory).append(

                    `
                    <td class=''> `+data.name+` </td>
                        <td class=''>
                            <button id='btn_update_category' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
                                data-target="#updateModal">
                                <i class='fa fa-pen text-info'> </i>
                            </button>
                            <button id='btn_delete_category' value="`+data.id+`" class='btn' type="button" data-toggle="modal"
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

                alert_error('No se pudo modificar este Categoria, revisa los errores','Ups...!')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            alert_update_success('Categoria actualizado con exito!', 'Good...!')

        });
    })

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete_category',function(e){

        var idCategory = $(this).val()
        toastr.warning(`Quiere eliminar este Categoria? <br /><br /><button type='button' value="`+idCategory+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
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
    function delete_client(idCategory){
        $.ajax({
            type: "DELETE",
            url : URI_API+`categories/${idCategory}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row_category'+idCategory).toggle(1000)

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
