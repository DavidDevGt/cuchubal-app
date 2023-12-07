<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-1">
    <h1>Usuarios</h1>
    <button class="btn btn-sm btn-success mb-1" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">Agregar Usuario</button>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr class="text-center">
          <th>ID</th>
          <th>Nombre de Usuario</th>
          <th>Activo</th>
          <th>Fecha de Creación</th>
          <th>Fecha de Actualización</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tabla-usuarios">
        <!-- Las filas de usuarios se llenarán aquí -->
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Agregar Usuario -->
<div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearUsuarioModalLabel">Agregar Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formCrearUsuario">
          <div class="mb-3">
            <label for="crearNombreUsuario" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="crearNombreUsuario" required>
          </div>
          <div class="mb-3">
            <label for="crearPasswordUsuario" class="form-label">Contraseña</label>
            <input type="text" class="form-control" id="crearPasswordUsuario" required>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-success mt-1">Crear Usuario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarUsuario">
          <input type="hidden" id="editarIdUsuario">
          <div class="mb-3">
            <label for="editarNombreUsuario" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="editarNombreUsuario">
          </div>
          <div class="mb-3" id="passwordField">
            <label for="editarPasswordUsuario" class="form-label">Contraseña</label>
            <div class="input-group">
              <input type="password" class="form-control" id="editarPasswordUsuario">
              <button id="togglePassword" class="btn btn-outline-secondary" type="button">
                <i class="fa-solid fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="editarEstadoUsuario">
            <label class="form-check-label" for="editarEstadoUsuario">Activo</label>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    cargarUsuarios();

    // Cargar usuarios desde el backend y mostrarlos en la tabla
    function cargarUsuarios() {
      $.ajax({
        url: 'http://localhost/cuchubal-app/backend/users',
        type: 'GET',
        success: function(usuarios) {
          $('#tabla-usuarios').empty(); // Limpiar la tabla antes de añadir nuevos datos
          usuarios.forEach(crearFilaUsuario);
        },
        error: function(error) {
          console.error('Error al cargar los usuarios:', error);
        }
      });
    }

    function crearFilaUsuario(usuario) {
      var fechaCreacion = dayjs(usuario.created_at).format('DD/MM/YYYY');
      var fechaActualizacion = dayjs(usuario.updated_at).format('DD/MM/YYYY');
      var estadoActivo = usuario.active == 1 ? '<i class="fa-solid fa-check-circle"></i>' : '<i class="fa-solid fa-circle-xmark"></i>';

      var fila = `
        <tr class="text-center">
          <td>${usuario.id}</td>
          <td>${usuario.username}</td>
          <td>${estadoActivo}</td>
          <td>${fechaCreacion}</td>
          <td>${fechaActualizacion}</td>
          <td>
            <button class="btn btn-primary btn-sm btn-editar" data-id="${usuario.id}" data-username="${usuario.username}" data-active="${usuario.active}"><i class="fa-solid fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btn-eliminar" data-id="${usuario.id}"><i class="fa-solid fa-trash-alt"></i></button>
          </td>
        </tr>
      `;
      $('#tabla-usuarios').append(fila);
    }

    // Alternar la visibilidad de la contraseña
    $('#togglePassword').click(function() {
      var passwordInput = $('#editarPasswordUsuario');
      var passwordIcon = $(this).find('i');
      if (passwordInput.attr('type') === 'password') {
        passwordInput.attr('type', 'text');
        passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        passwordInput.attr('type', 'password');
        passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });

    // Para limpiar los modales al cerrarlos
    $('#crearUsuarioModal, #editarUsuarioModal').on('hidden.bs.modal', function() {
      $(this).find('form').trigger('reset');
    });


    // Evento para enviar el formulario de creación
    $('#formCrearUsuario').on('submit', function(e) {
      e.preventDefault();
      var nombreUsuario = $('#crearNombreUsuario').val();
      var passwordUsuario = $('#crearPasswordUsuario').val();

      crearUsuario(nombreUsuario, passwordUsuario);
    });

    // Función para crear el usuario en el backend
    function crearUsuario(username, password) {
      $.ajax({
        url: 'http://localhost/cuchubal-app/backend/users',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          username,
          password
        }),
        success: function(response) {
          console.log(response);
          $('#crearUsuarioModal').modal('hide');
          cargarUsuarios(); // Recargar la lista de usuarios
          $('#formCrearUsuario')[0].reset(); // Limpiar el formulario
        },
        error: function(error) {
          console.error('Error al crear el usuario:', error);
        }
      });
    }

    // Evento para abrir el modal de editar con la información del usuario
    $('#tabla-usuarios').on('click', '.btn-editar', function() {
      var id = $(this).data('id');
      var username = $(this).data('username');
      var active = $(this).data('active');

      $('#editarIdUsuario').val(id);
      $('#editarNombreUsuario').val(username);
      $('#editarEstadoUsuario').prop('checked', active);
      $('#editarUsuarioModal').modal('show');
    });

    // Evento para enviar el formulario de edición
    $('#formEditarUsuario').on('submit', function(e) {
      e.preventDefault();
      var idUsuario = $('#editarIdUsuario').val();
      var nombreUsuario = $('#editarNombreUsuario').val();
      var passwordUsuario = $('#editarPasswordUsuario').val();
      var estadoUsuario = $('#editarEstadoUsuario').is(':checked') ? 1 : 0;

      actualizarUsuario(idUsuario, nombreUsuario, passwordUsuario, estadoUsuario);
    });

    // Función para actualizar el usuario en el backend
    function actualizarUsuario(id, username, password, active) {
      $.ajax({
        url: `http://localhost/cuchubal-app/backend/users/${id}`,
        type: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({
          username,
          password,
          active
        }),
        success: function(response) {
          console.log(response);
          $('#editarUsuarioModal').modal('hide');
          cargarUsuarios(); // Recargar la lista de usuarios
        },
        error: function(error) {
          console.error('Error al actualizar el usuario:', error);
        }
      });
    }

    // Evento para eliminar usuario
    $('#tabla-usuarios').on('click', '.btn-eliminar', function() {
      var id = $(this).data('id');
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción desactiva al usuario seleccionado.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, desactivar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          eliminarUsuario(id);
        }
      });
    });

    // Función para eliminar el usuario en el backend
    function eliminarUsuario(id) {
      $.ajax({
        url: `http://localhost/cuchubal-app/backend/users/${id}`,
        type: 'DELETE',
        success: function(response) {
          console.log(response);
          cargarUsuarios(); // Recargar la lista de usuarios
        },
        error: function(error) {
          console.error('Error al eliminar el usuario:', error);
        }
      });
    }
  });
</script>

<style>
  .fa-check-circle {
    transform: scale(1.5);
    color: green;
  }

  .fa-circle-xmark {
    transform: scale(1.5);
    color: red;
  }

  .fa-eye,
  .fa-eye-slash {
    cursor: pointer;
  }
</style>