$(document).ready(function () {

    // limpiamos carrito
    startingCart();

    let dt = $('.esc-producto');
    for (var j = 0; j < dt.length; j++) {
        if (dt[j].dataset.sel == "sel") {
            let id = dt[j].id;
            if ($('#' + id).hasClass('color-darkgrey')) {
                $('#' + id).removeClass('color-darkgrey');
                $('#' + id).addClass('color-black');
                $('#' + id).addClass('bg-orange');
            }
        }
    }

    $('.progress').css('width','17%');
    $('.step.1 div.step-number').css('background-color','orange');

});

$('[id^="prd_"]').click(
    function () {
        // extraemos el id
        let id = this.id.replace('prd_', '');
        let name = $('#name_prd_' + id).html();
        let price = $('#prd_' + id).attr('data-price');
        if ($('#prd_' + id).hasClass('color-darkgrey')) {
            $('#prd_' + id).removeClass('color-darkgrey');
            $('#prd_' + id).addClass('color-black');
            $('#prd_' + id).addClass('bg-orange');
            $('#prd_' + id).attr('data-sel', 'sel');
            checkProduct(id, name, price);
        } else if ($('#prd_' + id).hasClass('color-black')) {
            $('#prd_' + id).addClass('color-darkgrey');
            $('#prd_' + id).removeClass('color-black');
            $('#prd_' + id).removeClass('bg-orange');
            $('#prd_' + id).attr('data-sel', '');
            uncheckProduct(id, price);
        }
    }
);


/**
 * Esta funcion inicializa las variables del carrito, cuando se
 * entra por primera vez
 */
function startingCart() {

	let carrito = sessionStorage.getItem('std_carrito');
    if (carrito == null || typeof carrito == "undefined"
        || carrito == "") {

            sessionStorage.setItem('std_importecarrito', "5.00");
            sessionStorage.setItem('std_enviocarrito', "5.00");
            sessionStorage.setItem('std_carrito', "");
        
            $('#gastos_envio_carrito').html(sessionStorage.getItem('std_enviocarrito') + '€');
            $('#importe_total_carrito').html(sessionStorage.getItem('std_importecarrito') + '€');

    } else {

        carrito = JSON.parse(carrito);
        if (Array.isArray(carrito)) {
            carrito.forEach((item)=>{
                addProductInCart(item.id,item.name,item.price);    
                $('#prd_' + item.id).removeClass('color-darkgrey');
                $('#prd_' + item.id).addClass('color-black');
                $('#prd_' + item.id).addClass('bg-orange');
                $('#prd_' + item.id).attr('data-sel', 'sel');                    
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



}


/**
 * Guarda el producto seleccionado en sessionStorage de
 * variables carrito
 * @param {*} id - id del producto seleccionado
 * @param {*} name - nombre del producto
 * @param {*} price - precio promocionado
 */
function checkProduct(id, name, price) {

    let carritoids = sessionStorage.getItem('std_carrito');
    price = price.replace(',', '.');
    const carritonew = {
        id: id,
        name: name,
        price: price
    };

    if (carritoids == null || typeof carritoids == "undefined"
        || carritoids == "") {

        carritoids = new Array;

    } else {

        carritoids = JSON.parse(carritoids);

    }

    // añadimos el producto al carrito en DOM
    addProductInCart(id, name, price);

    carritoids.push(carritonew);
    sessionStorage.setItem('std_carrito', JSON.stringify(carritoids));

    let carritoprice = parseFloat(sessionStorage.getItem('std_importecarrito'));
    carritoprice += parseFloat(price);
    sessionStorage.setItem('std_importecarrito', carritoprice);

    $('#importe_total_carrito').html(carritoprice);

}


/**
 * Elimina el producto seleccionado en las variables de carrito de
 * la sesionStorage
 * 
 * @param {*} id - id del producto a deseleccionar
 */
function uncheckProduct(id, price = 0) {

    if (typeof price == "string") {
        price = price.replace(',', '.');
    }


    // para recalculo del carrito
    let carritoprice = parseFloat(sessionStorage.getItem('std_enviocarrito'));


    let carritosave = new Array;

    let carritoids = sessionStorage.getItem('std_carrito');

    if (carritoids == null || typeof carritoids == "undefined"
        || carritoids == "") {

        carritoids = new Array;

    } else {

        carritoids = JSON.parse(carritoids);
        if (Array.isArray(carritoids)) {
            carritoids.forEach(
                (carrito) => {
                    if (carrito.id != id) {
                        carritosave.push({
                            id: carrito.id,
                            name: carrito.name,
                            price: carrito.price
                        });
                        // acumulamos el valor del producto
                        carritoprice += parseFloat(carrito.price);
                    }
                }
            );
        }

    }
    // borramos el producto en el DOM
    deleteProductInCart(id);

    // guardamos carrito 
    sessionStorage.setItem('std_carrito', JSON.stringify(carritosave));

    carritoprice = parseFloat(carritoprice).toFixed(2)

    // precio del carrito
    sessionStorage.setItem('std_importecarrito', carritoprice);
    $('#importe_total_carrito').html(carritoprice);
}


/**
 * Esta funcion oculta el producto en el carrito del DOM 
 * cuando es eliminado
 * @param {*} id 
 */
function deleteProductInCart(id = 0) {
    $('#product_id' + id).remove();
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

function deleteBasket(idDel) {

    // extraemos el id
    let id = idDel.replace('product_delete', '');    

    // modificamos colores en selector del DOM
    if ($('#prd_' + id).hasClass('color-black')) {
        $('#prd_' + id).addClass('color-darkgrey');
        $('#prd_' + id).removeClass('color-black');
        $('#prd_' + id).removeClass('bg-orange');
        $('#prd_' + id).attr('data-sel', '');
        uncheckProduct(id, "0");
    }

}

/**
 * Funcion para grabar los datos en la DDBB tabla pedidos, y 
 * pasar al siguiente paso del carrito
 */

function continuar() {

    let _token = $("input[name='_token']").val();
    let datos = {
        _token: _token,
        precio: sessionStorage.getItem('std_importecarrito'),
        envio: sessionStorage.getItem('std_enviocarrito'),
        carrito: sessionStorage.getItem('std_carrito')
    }

    const urlc = "http://localhost/symfstandalone/public/recordOrder";
    
    const url_continuar = "http://localhost/symfstandalone/public/paso2";

    $.post(
        urlc,
        datos,
        function (result) {
            let resp=JSON.parse(result);

            if (resp.status == "OK") {
                document.location = url_continuar;
            } else {
                console.log("Error grabando el pedido: "+resp.message);
            }
        },
        "text");
}