
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = { 'Authorization': 'Bearer ' + TOKEN }

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    //alert('recives')

    //buscador de clientes
    var client_id = $('#client_id').val();
    view_debt(client_id)

    $('.miSelect1').select2(); // Selectores con intput search

    function view_debt(client_id) {

        $.ajax({
            type: "GET",
            //url : URI_API+`payments/${client_id}`,
            url : URI_API+`calculator_totals/${client_id}`,
            data: client_id,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                console.log(data)
                if(data.total_debt == 0){

                    var total_debt = 'El cliente esta al dia ...'
                }
                if(data.total_debt < 0){

                    var total_debt = 'saldo a favor del cliente: $'+data.total_debt
                }
                if(data.total_debt > 0){

                    var total_debt = 'El cliente debe: $'+data.total_debt
                }

                $('#view_total_debt').toggle(1000)
                $('#view_total_debt').show(total_debt)
                $('#view_total_debt').html(total_debt)


            }

        });

    }





     // # NUEVO INSERT  PAY--
     $(document).on('click','#btn-form-new-pay',function(e){

        e.preventDefault();

        const form_insert_pay = $("#form_insert_pay").serialize();

        $.ajax({
            type: "POST",
            url: URI_API+'store_pay_account',
            data: form_insert_pay,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {
                console.log(data)

                view_debt(data.client_id)

                $('#payments').prepend(

                    `
                    <tbody class='text-danger'>
                        <tr>

                            <td class="text-success"> <i class="fa fa-check"></i> </td>
                            <td> - </td>
                            <td> $ `+data.payment+` </td>
                            <td> - </td>
                            <td> `+formatDate(data.date_payment)+` </td>
                            <td>
                            <button id='btn_update' value="`+data.id+`" class='btn btn-sm' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-file-invoice'> </i>
                                </button>
                                <button id='btn_delete' value="`+data.id+`" class='btn btn-sm' type="button" data-toggle="modal"
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
            alert_add_success('PAGO ingresado con exito!', 'Good...!')

        });

    })

    // # Modal para ver detalle de la compra--
    $(document).on('click','#btn_view_buy',function(e){

        view_buy( $(this).val() )

    });

    function view_buy(id_buy){

        $('#number_buy').html( id_buy )

        $.ajax({
            type: "GET",
            url: URI_API+`sales/${id_buy}`,
            //data: form_insert_pay,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $.each(data, function( i, value ) {
                   //console.log( value );
                    $('#buy').append(
                        `
                        <tr>
                            <td> `+value.date_sale+` </td>
                            <td> `+value.cuantity+`  </td>
                            <td> `+value.product.name+` </td>
                            <td> $ `+value.unit_price+` </td>
                            <td> $ `+value.total_price+` </td>
                            <td>
                                <button id='btn_update' value="`+value.id+`" class='btn btn-sm' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-pen text-default '></i>
                                </button>
                                <button id='btn_delete' value="`+value.id+`" class='btn btn-sm' type="button" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class='fa fa-trash text-danger '></i>
                                </button>
                            </td>
                        </tr>

                        `
                    )
                });

        },

        error:function (response){
            $.each(response.responseJSON.errors,function(field_name, error){
                $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
            })

            alert_error('No se pudo guardar este producto, revisa los errores','Ups...!')

        }

        }).done(function(){
            //alert_add_success('PAGO ingresado con exito!', 'Good...!')

        });

    }


    // # Modal para ver detalle de la compra--
    $(document).on('click','.close',function(e){ $('#buy').empty() })


    // # UPDATE del detalle

    $('#capa-form-update').hide();
    function removeDollarSign(number) { // Function para eliminar el signo de $
        return Number(number.replace('$', ''));
    }



    $(document).on('click','#btn-form-update-detail',function(e){


    });

    $(document).on('click','#btn_update',function(e){


        $('#form-update-sale').trigger("reset");


        e.preventDefault();
        $('#capa-form-update').toggle(1000);

        var idSale = $(this).val();

        $.ajax({
            type: "GET",
            url : URI_API+`show_for_id/${idSale}`,
            data: idSale,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                console.log(data)

                $('#date').val(data[0].date_sale)
                $('#cuantity').val(data[0].cuantity)
                $('#detail').val(data[0].product.name)
                $('#unit_price').val(data[0].unit_price)
                $('#total_price').val(data[0].total_price)
                $('#btn-form-update-sale').val(idSale)


                var $option = $('<option>', {
                    value: 10,
                    text: 'TEXTO'
                });

                $(".miSelect1 option[value="+data[0].product_id+"]").remove();
                $('.miSelect1').append("<option value="+data[0].product_id+" selected >"+data[0].product.name+"</option>");

            }

        });
    });

    // ## Recepcion del form de Update
    $(document).on('click','#btn-form-update-sale',function(e){

        e.preventDefault();
        const datos_sale = $("#form-update-sale").serialize();

        const idSale =  $(this).val()

        $.ajax({
            type: "PUT",
            url : URI_API+`sales/${idSale}`,
            data: datos_sale,
            dataType: "JSON",
            // Añade un header:
            headers: header,
            // El resto del código
            success : function(data) {

                console.log(data)

                $('#buy').hide();
                $('#buy').empty();
                $('#buy').toggle(1000);

                view_buy(idSale)

            },

            error:function (response){
                $.each(response.responseJSON.errors,function(field_name, error){
                    $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
                })

                alert_error('No se pudo modificar esta venta, revisa los errores','Ups...!')

            }

        }).done(function(){
            alert_add_success('venta modificada con exito!', 'Good...!')

        });

    });

    // # BTN -DELETE --
    // Funcion que le levanta el alert confirm delete
    $(document).on('click','#btn_delete',function(e){

        var idSale = $(this).val()

        toastr.warning(`Quiere eliminar este registro? <br /><br /><button type='button' value="`+idSale+`" id='confirmationButtonYes' class='btn btn-warning'>Si</button>`, "Atencion",
        {
            closeButton: true,
            allowHtml: true,
            progressBar: true,
            onShown: function (toast) {
                $("#confirmationButtonYes").click(function(){
                    delete_sale($(this).val())
                });
            }
        });

    })

    // # DELETE --
    // Si se confirma, esta fnction recibe un parametro id para delete
    function delete_sale(idSale){
        $.ajax({
            type: "PUT",
            url : URI_API+`sales/${idSale}`,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                $('#buy').hide();
                $('#buy').empty();
                $('#buy').toggle(1000);


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


    // $(document).on('dblclick','#table_detail td',function(e){

    //     var field = $(this).attr("id");
    //     var back_value = $(this).text();
    //     var id_sale = $(this).attr('value');

    //     var valorInput = "<input type='text' id='valor_editable' value='"+removeDollarSign(back_value)+"'>";
    //     $(this).html(valorInput);

    //     var inputEdit = $("#valor_editable");

    //     console.log(id_sale)

    //     inputEdit.focus();
    //     inputEdit.blur(function(){
    //         var new_value = inputEdit.val();
    //         if(new_value != ""){
    //             $(this).parent().html(new_value);
    //             $.ajax({
    //                 url: URI_API+`sales/${id_sale}`,
    //                 headers: header,
    //                 dataType: "JSON",
    //                 method:"PUT",
    //                 data:{id_sale: id_sale, field:field, value: new_value},
    //                 success:function(data){
    //                     //aqui puedes mostrar un mensaje de confirmacion
    //                 }
    //             });
    //         }else{
    //             $(this).parent().html(back_value);
    //         }
    //     });
    // });




});
