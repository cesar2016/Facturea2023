
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = {'Authorization': 'Bearer '+TOKEN}

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    $('.miSelect1').select2(); // Selectores con intput search
    $('.miSelect2').select2(); // Selectores con intput search


    // # Funcion para cambiar propiedades del form
    function properties_form(valor){

        if(valor == 'new'){

            $('#card card-primary').removeClass('card-warning')
            $('#card-form').attr('class', 'card card-primary')
            $('#text-head-form').html('Agregar Producto')


            $('#btn-form').html(

                `<button id="btn-form-new-product" type="submit" class="btn btn-primary">Agregar producto</button>`
            )

        }else{

            $('#card card-primary').removeClass('card-primary')
            $('#card-form').attr('class', 'card card-warning')
            $('#text-head-form').html('Actualizar Producto')

            $('#btn-form').html(

                `<button id="btn-form-update-product" type="submit" class="btn btn-warning">Actualizar prolducto</button>`
            )
        }
    }

    // # Funcion para ver si el form esta abierto o cerrado
    function opene() {

        console.log($('#view-new-product').is(':visible'))
        return $('#view-new-product').is(':visible')
        }

        $(document).on('click','#close-form',function(e){

        e.preventDefault();
        $('#view-new-product').toggle(1000)


    })

    // # Mostrar y Ocultar form
    $('#view-new-product').hide();
    $('#btn-new-product').click(function (e) {
        e.preventDefault();

        if( opene() == false ){
            $('#view-new-product').toggle(1000)
        };

        properties_form('new')
        $("#form-new-product")[0].reset();

    });

    ////////////////////// End/ Manejo apertura y ciero del Form ////////////////////


    // -------------------------------------------------------------------|
    // ## ---------------- MANEJO DEL CRUD -------------------------------|
    //--------------------------------------------------------------------|

    // # NUEVO INSERT --
    $(document).on('click','#btn-form-new-product',function(e){

        e.preventDefault();

        const datos_products = $("#form-new-product").serialize();

        $.ajax({
            type: "POST",
            url: URI_API+'products',
            data: datos_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {
                console.log(data.category.name)
                $('#products').append(

                    `
                    <tbody class='text-danger'>
                        <tr>
                            <td> `+data.code+` </td>
                            <td> `+data.name+` </td>
                            <td> `+data.stock+` </td>
                            <td> `+data.price_purchase+` </td>
                            <td> `+data.price_sale+` </td>
                            <td> `+data.date_purchase+` </td>
                            <td> `+data.category.name+` </td>
                            <td> `+data.brand_product.name+` </td>

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

                alert_error('No se pudo guardar este producto, revisa los errores','Ups...!')

            }

        }).done(function(){
            alert_add_success('producto ingresado con exito!', 'Good...!')

        });

    })

    // # BTN -UPDATE  --
    // Con el value del boton update hace get al metodo
    $(document).on('click','#btn_update',function(e){
        e.preventDefault();

        const idproduct = $(this).val()

        $("#form-new-product")[0].reset();
        properties_form('update')

        if( opene() == false ){
            $('#view-new-product').toggle(1000)
        };

        $('#opCategori_id').remove()

        $.ajax({
            type: "GET",
            url : URI_API+`products/${idproduct}`,
            data: idproduct,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                $('#idproduct').val(idproduct)

                $('#code').val(data.code)
                $('#name').val(data.name)
                $('#stock').val(data.stock)
                $('#price_purchase').val(data.price_purchase)
                $('#price_sale').val(data.price_sale)
                $('#status').val(data.status)
                $('#date_purchase').val(data.date_purchase)
                // $('#category_id').val(data.category_id)
                // $('#brand_product_id').val(data.brand_product_id)

                var $option = $('<option>', {
                    value: 10,
                    text: 'TEXTO'
                });

                //$('.miSelect').select2();
                $(".miSelect1 option[value="+data.category_id+"]").remove();
                $(".miSelect2 option[value="+data.brand_product_id+"]").remove();

                $('.miSelect1').append("<option value="+data.category_id+" selected >"+data.category.name+"</option>");
                $('.miSelect2').append("<option value="+data.brand_product_id+" selected >"+data.brand_product.name+"</option>");


            }

        });


    })

    // # UPDATE --
    // Toma y envio del formulario de Update
    $(document).on('click','#btn-form-update-product',function(e){

        const datos_update_products = $("#form-new-product").serialize();

        e.preventDefault();

        const idproduct = $('#idproduct').val();

        $.ajax({
            type: "PUT",
            url : URI_API+`products/${idproduct}`,
            data: datos_update_products,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+data.id).hide();
                $('#row'+data.id).empty();
                $('#row'+data.id).toggle(1000);

                $('#row'+idproduct).append(

                    `
                        <td class=''> `+data.code+`</td>
                        <td class=''> `+data.name+`</td>
                        <td class=''> `+data.stock+` </td>
                        <td class=''> `+data.price_purchase+` </td>
                        <td class=''> `+data.price_sale+` </td>
                        <td class=''> `+data.date_purchase+` </td>
                        <td class=''> `+data.category.name+` </td>
                        <td class=''> `+data.brand_product.name+` </td>
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

                alert_error('No se pudo modificar este producto, revisa los errores','Ups...!')

            }

        }).done(function(){
            //Cuando se completa la actual llamada, cambia el valor a true
            alert_update_success('producto actualizado con exito!', 'Good...!')

        });
    })

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete',function(e){

        var idproduct = $(this).val()
        toastr.warning(`Quiere eliminar este producto? <br /><br /><button type='button' value="`+idproduct+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
        {
            closeButton: true,
            allowHtml: true,
            progressBar: true,
            onShown: function (toast) {
                $("#confirmationButtonYes").click(function(){
                    delete_product($(this).val())
                });
            }
        });

    })


    // # DELETE --
    // Si se confirma, esta fnction recibe un parametro id para delete
    function delete_product(idproduct){
        $.ajax({
            type: "DELETE",
            url : URI_API+`products/${idproduct}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#row'+idproduct).toggle(1000)

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
