
$(function () {

    //** CONSTANTES DE ENTORNO */
    var URI_API = env().URI_API
    var TOKEN = env().TOKEN
    var header = { 'Authorization': 'Bearer ' + TOKEN }

    // console.log(URI_API)
    // console.log(TOKEN)

    // *********End/ Variables de entorno **********/

    //alert('recives')

    var contador = 0;
    $("#add_input").click(function(){
      contador++;
      $("#inputBoxes").append(

        `
            <div style="width: 100%; height: 100%; padding: 0; margin: 0;" class='row'>

                <div class="form-group col-md-1">

                    <input type="number" class="form-control cant" id="cant-`+contador+`" name="cant-`+contador+`"
                        value="1">
                    <input hidden type="text" class="form-control product_id" id="product_id-`+contador+`" name="product_id-`+contador+`" >

                </div>

                <div class="form-group col-md-6">

                    <input type="search" class="form-control detail" id="detail-`+contador+`" name="detail-`+contador+`"
                        placeholder="Detalle de la compra">
                </div>
                <div class="form-group col-md-2">

                    <input type="number" class="form-control" id="price_unit-`+contador+`" name="price_unit-`+contador+`"
                        placeholder="Precio U">
                </div>

                <div class="form-group col-md-2">

                    <input type="number" class="form-control sub_total" id="sub_total-`+contador+`" name="sub_total-`+contador+`" readonly
                        placeholder="Precio T">
                </div>

                    <a href="#" id="btn-send-recive" class="mt-1 delete" name="btn_delete-`+contador+`"
                        role="button" aria-pressed="true"> <i class='text-danger fa fa-trash'> </i></a>

            </div>

        `

        );

    });


    // # FUNCIONALIDAD DE LOS RADIO BUTONS


    $(document).on("click",".radius", function(){

        if ($('#type_sale_cred').is(':checked')) {
            $('.div_delivery').attr('hidden', false)
        }
        if ($('#type_sale_cont').is(':checked')) {
            $('.div_delivery').attr('hidden', true)
        }

    })


    //buscador de clientes
    $(function() {
        $.ajax({
            type: "GET",
            url : URI_API+`clients`,
            headers: header,
            dataType: "JSON",
            success: function(data) {
                //console.log(data)
                var availableTags = [];
                $.each(data, function(index, value) {
                availableTags.push(value.id+ ' - ' +value.name + ' - ' + value.dni);
                });
                $( "#tags" ).autocomplete({
                source: availableTags,
                select: function( event, ui ){
                            var label = ui.item.label.split(" - ");
                            $(this).val(label[1]);
                            $('#client_id').val(label[0])
                            $('#body_recive').prop('hidden', false);
                            console.log(ui.item.label)
                            return false;
                        },
                focus: function( event, ui ) {
                    var label = ui.item.label.split(" - ");
                    $(this).val(label[1]);
                    return false;
                },
                open: function (e, ui) {
                    var acData = $(this).data('ui-autocomplete');
                    acData
                    .menu
                    .element
                    .find('li')
                    .each(function () {
                        var me = $(this);
                        var keywords = acData.term.split(' ').join('|');
                        me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<span style="margin:2px; background-color: #F9E79F; padding: 5px;">$1</span>'));
                    });
                }
                });
            }
        });
    });



    //buscador de Product
    $(function() {

        var count_input = [0]
        var mid_intput = 0;

        // Delete de inputs
        $(document).on("click",".delete", function(){

        // Esto elimina en id del input ingresado anteriormente
        var id_btn_delete = $(this).attr("name").split("-");

        let index = count_input.indexOf( parseInt(id_btn_delete[1]));

        // Borrar el elemento
        if (index > -1) {
            count_input.splice(index, 1);
        }
          suma_total()
          // Esto elimina en input del DOM
          $(this).parent('div').remove();


        });

        // Contador de inputs
        $(document).on('click', '#add_input', function() {
           count_input.push(  mid_intput += 1 )
           suma_total()
        })


        // funcionalidad de las cantidades
        $(document).on('click', '.cant', function() {
            // Obtener el nombre del input
            var selection = $(this).attr('name');
            sum_cant_subtotal(selection)
        })


        // Calculo del TOTAL
        function suma_total() {
            var count = 0;
            $.each(count_input, function(i, value) {
                count += parseInt( $("#sub_total-"+value).val() )
            });

            //console.log(count_input)

            if (isNaN(count)) {
                $('#total').val('Calculando ...')
            } else {
                $('#total').val(count)
            }

            // mandamos siempre la cantidad de inputs que hay
            $('#cant_input').val(count_input.length)
        }
        // Funcion para sumar precio u + cant
        function sum_cant_subtotal(id_input_cant){

            var id_selector = id_input_cant.split("-");
            $("#product_id-"+id_selector[1]).val()
            $("#price_unit-"+id_selector[1]).val()
            $("#sub_total-"+id_selector[1]).val($("#cant-"+id_selector[1]).val() * $("#price_unit-"+id_selector[1]).val())

            suma_total()

        }

        $(document).on('click', '.detail', function() {
            // Obtener el nombre del input
            var selection = $(this).attr('name');

            $.ajax({
                type: "GET",
                url : URI_API+`products`,
                headers: header,
                dataType: "JSON",
                success: function(data) {
                    //console.log(data)
                    var availableTags = [];

                    $.each(data, function(index, value) {
                    availableTags.push(value.id+ ' - ' +value.name + ' - COD.' + value.code+ ' - ' + value.price_sale);

                    });
                    $( "#"+selection ).autocomplete({
                    source: availableTags,
                    select: function( event, ui ){
                                var label = ui.item.label.split(" - ");
                                var id_in = selection.split("-");
                                $(this).val(label[1]);


                                $("#product_id-"+id_in[1]).val(label[0])
                                $("#price_unit-"+id_in[1]).val(label[3])
                                $("#sub_total-"+id_in[1]).val($("#cant-"+id_in[1]).val() * label[3])


                                sum_cant_subtotal(selection)
                                suma_total()


                                return false;
                            },
                    focus: function( event, ui ) {
                        var label = ui.item.label.split(" - ");
                        $(this).val(label[1]);
                        return false;
                    },
                    open: function (e, ui) {
                        var acData = $(this).data('ui-autocomplete');
                        acData
                        .menu
                        .element
                        .find('li')
                        .each(function () {
                            var me = $(this);
                            var keywords = acData.term.split(' ').join('|');
                            me.html(me.text().replace(new RegExp("(" + keywords + ")", "gi"), '<span background-color: #F9E79F; padding: 2px;">$1</span>'));
                        });
                    }
                    });
                }
            });
        });
    });

    function redirect(){
        window.open('/sale')
    }


    // # NUEVO INSERT --
    $(document).on('click','#btn_genenerate_recive',function(e){

        e.preventDefault();

        const data_recive = $("#form-dates-recive").serialize();

        $.ajax({
            type: "POST",
            url: URI_API+'sales',
            data: data_recive,
            headers: header,
            dataType: "JSON",
            success: function(data)
            {

                console.log(data)

            },

            error:function (response){
                // $.each(response.responseJSON.errors,function(field_name, error){
                //   $(document).find('[name='+field_name+']').after('<small class="text-sm text-danger">' +error+ '</small>')
                // })
            }

        }).done(function(){

            redirect();

            $('#form-dates-recive').submit();

        });

    })


});
