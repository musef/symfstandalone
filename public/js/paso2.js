$(document).ready(function () {


    $('.progress').css('width','34%');

    readStoredCart();

});


/**
 * Esta funcion lee los datos del carrito almacenado en el sesionStorage
 * y lo muestra en el carrito en el DOM 
 */
function readStoredCart() {

	addProductInCart(1,"Producto Fake","88.88");
	addProductInCart(2,"Producto Fake 2","123.45");

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


