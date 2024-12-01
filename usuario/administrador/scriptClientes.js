
let idUsuarioSeleccionado = null;

//FUNCION PARA SELECCIONAR UN USUARIO AL HACER CLICK EN UNA FILA DE LA TABLA
function usuarioSeleccionado(event, id) {
  //Si ya hay una fila seleccionada, elimina la clase 'selected' de ella
  const previousSelectedRow = document.querySelector('.selected');

  if (previousSelectedRow) {
    //Captura el ID de la fila previamente seleccionada
    const previousId = previousSelectedRow.getAttribute('data-id');

    //Muestra el ID deseleccionado en el alert
    //alert("ID deseleccionado: " + previousId);

    //Elimina la clase 'selected' de la fila previamente seleccionada
    previousSelectedRow.classList.remove('selected');
  }

  //Actualiza el id del usuario seleccionado
  idUsuarioSeleccionado = id;

  //Muestra el nuevo ID seleccionado en el alert
  //alert("Nuevo ID seleccionado: " + idUsuarioSeleccionado);

  //Habilita el botón de eliminar si hay una fila seleccionada
  document.getElementById('eliminarClienteBtn').disabled = false;

  //Agrega la clase 'selected' a la fila clickeada
  event.currentTarget.classList.add('selected');
}

//FUNCION PARA MOSTRAR EL MODAL AL HACER CLIC EN EL BOTÓN DE ELIMINAR
document.getElementById('eliminarClienteBtn').onclick = function() {

  if (idUsuarioSeleccionado) {
    //Muestra el modal de confirmación
    const modalDeConfirmacion = new bootstrap.Modal(document.getElementById('confirmModal'));
    modalDeConfirmacion.show();
  }
};

//FUNCION PARA MANEJAR LA CONFIRMACIÓN EN EL MODAL
document.getElementById('confirmDeleteBtn').onclick = function() {

  if (idUsuarioSeleccionado) {
    //Envia la solicitud para eliminar el usuario
    fetch('eliminarUsuario.php', {
      //Envia la solicitud con el método POST
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'id=' + idUsuarioSeleccionado //Envia el ID del usuario a eliminar
    })
    //Recibe la respuesta en formato JSON
    .then(response => response.json())
    //Procesa la respuesta
    .then(data => {
      const modalBody = document.querySelector('#confirmModal .modal-body');

      //Muestra un mensaje de éxito o error en el modal
      if (data.success) {
        modalBody.innerHTML = "<p class='text-success'>Usuario eliminado con éxito.</p>";
        //Elimina la fila de la tabla sin recargar la página
        const row = document.querySelector(`tr[data-id='${idUsuarioSeleccionado}']`);
        if (row) {
          row.remove(); //Elimina la fila de la tabla
        }

        //Recarga la página después de un breve retraso
        setTimeout(() => { 
          location.reload();
        }, 2000);

      //Muestra un mensaje de error en el modal
      } else {
        modalBody.innerHTML = "<p class='text-danger'>Hubo un error al eliminar el usuario.</p>";
      }

      //Deshabilita el botón de confirmación después de la acción
      document.getElementById('confirmDeleteBtn').disabled = true;

      //Oculta el modal después de unos segundos
      setTimeout(() => {
        const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        confirmModal.hide();

        //Resetea el contenido y habilita el botón de confirmación
        modalBody.innerHTML = "¿Estás seguro de que deseas eliminar este usuario?";
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
        modalBody.innerHTML = "¿Estás seguro de que deseas eliminar este usuario?";
        document.getElementById('confirmDeleteBtn').disabled = false;
      }, 2000);
    });
  }
};
