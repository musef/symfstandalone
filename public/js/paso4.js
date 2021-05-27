$(document).ready(function () {


    $('.progress').css('width','68%');
    // restauramos carritoprice
    readStoredCart();    
    // quitamos los items de borrado
    $('[id^=product_delete]').remove();

    $('#continuar-a-datos').click(
        (event)=>{           
            if ($('#check_legal').prop('checked') != true) {
                event.preventDefault();
                console.log("Check legal no pulsado");
                alert ('Debe pulsar el check de aceptación de condiciones legales');
            } else {
                console.log("finalizar pulsado");
                $('#std_carrito').val(sessionStorage.getItem('std_carrito'));
                $('#std_enviocarrito').val(sessionStorage.getItem('std_enviocarrito'));
                $('#std_importecarrito').val(sessionStorage.getItem('std_importecarrito'));
            }

        }
    );
    $('#continuar-a-datos').prop('disabled','disabled');
});

$('#check_legal').click(
    () => {
        $('#continuar-a-datos').prop('disabled','');
    }
);

/**
 * Esta funcion lee los datos del carritoprice almacenado en el sesionStorage
 * y lo muestra en el carritoprice en el DOM 
 */
 function readStoredCart() {

	let carrito = sessionStorage.getItem('std_carrito');
    if (carrito == null || typeof carrito == "undefined"
        || carrito == "") {

        carrito = new Array;

    } else {

        carrito = JSON.parse(carrito);

    }

    if (Array.isArray(carrito)) {
    	carrito.forEach((item)=>{
    		addProductInCart(item.id,item.name,item.price);        
    	});
    }

    
    let carritoprice = sessionStorage.getItem('std_importecarrito');
    if (carritoprice == null || typeof carritoprice == "undefined"
        || carritoprice == "") {

        carritoprice = 0.00;

    } else {

        carritoprice = parseFloat(carritoprice);

    }
    $('#importe_total_carrito').html(carritoprice);

	

    let carritoenvio = sessionStorage.getItem('std_enviocarrito');
    if (carritoenvio == null || typeof carritoenvio == "undefined"
        || carritoenvio == "") {

        carritoenvio = 0.00;

    } else {

        carritoenvio = parseFloat(carritoenvio);

    }    
	$('#gastos_envio_carrito').html(carritoenvio + '€');

}

/**
 * Esta funcion inyecta un template del producto dentro del carrito
 * y lo rellena con datos
 * Adicionamiente, modifica valores de carrito 
 * @param {*} id 
 * @param {*} name 
 * @param {*} price 
 */
function addProductInCart(id, name, price) {

    fetch('http://localhost/stdalone/resources/views/templates/producto_carrito.blade.php')
        .then(function (response) {
            if (response.ok) {
                let resp = response.text().then(function (data) {

                    $('#listaproductos').append(data);
                    $('#templ_id').attr('id', 'product_id' + id);
                    $('#templ_name').attr('id', 'product_name' + id);
                    $('#templ_price').attr('id', 'product_price' + id);
                    $('#templ_delete').attr('id', 'product_delete' + id);

                    $('#product_name' + id).html(name);
                    $('#product_price' + id).html(price);

                })
                console.log("response OK");
            } else {
                console.log('Respuesta de red OK pero respuesta HTTP no OK');
            }
        }).then(data => console.log(data))
        .catch(function (error) {
            console.log('Hubo un problema con la petición Fetch:' + error.message);
        });


}


/**
 * Funcion para grabar los datos en la DDBB tabla pedidos, y 
 * pasar al siguiente paso del carrito
 */

 function finalizarPedido() {

    let _token = $("input[name='_token']").val();
    let datos = {
        _token: _token,
        id_cliente: $("#id_cliente").val(),
        datos_direccion: $("#verificarDireccion").val(),
        datos_cliente: $("#datosPersonales").val(),
        datos_banco: $("#bank").val(),
        datos_pedido: {
            precio: sessionStorage.getItem('std_importecarrito'),
            envio: sessionStorage.getItem('std_enviocarrito'),
            carrito: sessionStorage.getItem('std_carrito')
        }
    }

    const urlc = "http://localhost/symfstandalone/public/recordOrder";

    $.post(
        urlc,
        datos,
        function (result) {

            console.log("Pedido efectuado: ");
        },
        "html"
    ).fail(
        () => {
            console.log('error en pedido');
        }
    ).done(
        () => {
            console.log('order done');
        }
    );

 
}

