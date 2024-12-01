
let skuProductoSeleccionado = null;

//FUNCION PARA SELECCIONAR UN PRODUCTO AL HACER CLICK EN UNA FILA DE LA TABLA
function productoSeleccionado(event, sku) {
  //Si ya hay una fila seleccionada, elimina la clase 'selected' de ella
  const previousSelectedRow = document.querySelector('.selected');

  if (previousSelectedRow) {
    //Captura el SKU de la fila previamente seleccionada
    const previousSku = previousSelectedRow.getAttribute('data-id');

    //Muestra el SKU deseleccionado en el alert
    //alert("Sku deseleccionado: " + previousSku);

    //Elimina la clase 'selected' de la fila previamente seleccionada
    previousSelectedRow.classList.remove('selected');
  }

  //Actualiza el SKU del producto seleccionado
  skuProductoSeleccionado = sku;

  //Muestra el nuevo SKU seleccionado en el alert
  //alert("Nuevo Sku seleccionado: " + skuProductoSeleccionado);

  //Guarda el SKU seleccionado en el almacenamiento local
  localStorage.setItem('selectedSku', skuProductoSeleccionado);

  //Habilita el botón de eliminar si hay una fila seleccionada
  document.getElementById('eliminarProductoBtn').disabled = false;

  //Agrega la clase 'selected' a la fila clickeada
  event.currentTarget.classList.add('selected');
}


//FUNCION PARA MOSTRAR EL MODAL DE CONFIRMACIÓN AL DAR CLICK EN EL BOTÓN DE ELIMINAR
document.getElementById('eliminarProductoBtn').onclick = function() {

  if (skuProductoSeleccionado) {
    const modalDeConfirmacion = new bootstrap.Modal(document.getElementById('confirmModal'));
    modalDeConfirmacion.show();
  }
};

//FUNCION PARA MANEJAR LA CONFIRMACIÓN EN EL MODAL
document.getElementById('confirmDeleteBtn').onclick = function() {

  if (skuProductoSeleccionado) {

    //Envia la solicitud para eliminar el producto
    fetch('../../producto/eliminarProducto.php', {
      //Envia la solicitud con el método POST
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'sku=' + skuProductoSeleccionado //Envia el SKU del producto a eliminar
    })
    //Recibe la respuesta en formato JSON
    .then(response => response.json())
    //Procesa la respuesta
    .then(data => {
      const modalBody = document.querySelector('#confirmModal .modal-body');

      //Muestra un mensaje de éxito o error en el modal
      if (data.success) {
        modalBody.innerHTML = "<p class='text-success'>Producto eliminado con éxito.</p>";
        //Elimina la fila de la tabla sin recargar la página
        const row = document.querySelector(`tr[data-id='${skuProductoSeleccionado}']`);
        if (row) {
          row.remove(); //Elimina la fila de la tabla
        }

        //Recarga la página después de un breve retraso
        setTimeout(() => { 
          location.reload();
        }, 2000);

      //Muestra un mensaje de error en el modal
      } else {
        modalBody.innerHTML = "<p class='text-danger'>Hubo un error al eliminar el producto.</p>";
      }

      //Deshabilita el botón de confirmación después de la acción
      document.getElementById('confirmDeleteBtn').disabled = true;

      //Oculta el modal después de unos segundos
      setTimeout(() => {
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        confirmModal.hide();

        //Resetea el contenido y habilita el botón de confirmación
        modalBody.innerHTML = "¿Estás seguro de que deseas eliminar este producto?";
        document.getElementById('confirmDeleteBtn').disabled = false;
      }, 2000);
    })

    .catch(error => {
      const modalBody = document.querySelector('#confirmModal .modal-body');
      modalBody.innerHTML = "<p class='text-danger'>Error al procesar la solicitud.</p>";
      console.error(error);

      //Oculta el modal después de unos segundos
      setTimeout(() => {
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        confirmModal.hide();

        //Resetea el contenido y habilita el botón de confirmación
        modalBody.innerHTML = "¿Estás seguro de que deseas eliminar este producto?";
        document.getElementById('confirmDeleteBtn').disabled = false;
      }, 2000);
    });
  }
};

//FUNCION PARA REDIRIGIR A LA PÁGINA DE ACTUALIZACIÓN DE PRODUCTOS
document.getElementById('updateBtn').addEventListener('click', function() {
    var sku = localStorage.getItem('selectedSku');

    if (sku) {
      
        //Redirige a la página de actualización con el SKU
        window.location.href = '../../producto/actualizarProductos.php?sku=' + sku;
    } else {
        alert('Por favor selecciona un producto primero.');
    }
});
