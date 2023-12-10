<?php $userId = $_SESSION['user_id'] ?? 0; ?>

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Cuchubales</h1>
    <button id="btnCrearCuchubal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cuchubalModal" style="display: none;">
      Crear Cuchubal
    </button>
  </div>
  <div id="userId" style="display: none;" data-userid="<?php echo htmlspecialchars($userId); ?>"></div>
  <div class="row mt-5" id="lista-cuchubales">
    <!-- Las tarjetas de cuchubales se cargarán aquí -->
  </div>
</div>


<!-- Modal para Crear/Editar Cuchubal -->
<div class="modal fade" id="cuchubalModal" tabindex="-1" aria-labelledby="cuchubalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cuchubalModalLabel">Crear/Editar Cuchubal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formCuchubal">
          <input type="hidden" id="cuchubalId">
          <div class="mb-3">
            <label for="nombreCuchubal" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreCuchubal" required>
          </div>
          <div class="mb-3">
            <label for="descripcionCuchubal" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcionCuchubal" required></textarea>
          </div>
          <div class="mb-3">
            <label for="montoCuchubal" class="form-label">Monto</label>
            <input type="number" class="form-control" id="montoCuchubal" required>
          </div>
          <div class="mb-3">
            <label for="fechaInicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fechaInicio" required>
          </div>
          <div class="mb-3">
            <label for="fechaFin" class="form-label">Fecha de Finalización</label>
            <input type="date" class="form-control" id="fechaFin" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarCuchubal()">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>


<script>
  function cargarCuchubales() {
    // var userId = $('#userId').data('userid');
    var userId = 2;
    $.ajax({
      url: 'http://localhost/cuchubal-app/backend/cuchubales',
      type: 'GET',
      data: {
        userId: userId
      },
      success: function(cuchubales) {
        $('#lista-cuchubales').empty();
        if (cuchubales.length === 0) {
          $('#lista-cuchubales').append(`
          <div class="empty-state">
            <p>Vaya, parece que no hay nada aquí.</p>
            <button id="crearCuchubal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cuchubalModal">Crear Cuchubal</button>
          </div>
        `);
          $('#btnCrearCuchubal').hide();
        } else {
          cuchubales.forEach(function(cuchubal) {
            var fechaInicio = dayjs(cuchubal.startDate).format('DD/MM/YYYY');
            var fechaFin = dayjs(cuchubal.deadline).format('DD/MM/YYYY');
            var disabledEdit = new Date() > new Date(cuchubal.startDate) ? 'disabled' : '';

            var tarjetaCuchubal = `
            <div class="col-md-4 mb-4">
              <div class="card cuchubal-card text-center">
                <img src="img/modulos/cuchubales.png" alt="${cuchubal.name}" class="card-image">
                <div class="card-body">
                  <h5 class="card-title">${cuchubal.name}</h5>
                  <p class="card-text">${cuchubal.description}</p>
                  <div class="card-info">
                    <span class="text-muted">Inicio: ${fechaInicio}</span><br>
                    <span class="text-muted">Fin: ${fechaFin}</span><br>
                    <span class="amount">Monto: ${formatToQuetzales(cuchubal.amount)}</span>
                  </div>
                  <div class="d-flex justify-content-center align-items-center mt-3">
                    <button class="btn btn-info m-1" data-id="${cuchubal.id}" data-toggle="tooltip" data-placement="top" title="Ver Detalles">
                      <i class="fas fa-info-circle"></i>
                    </button>
                    <button class="btn btn-success m-1 editarCuchubal" data-id="${cuchubal.id}" data-bs-toggle="modal" data-bs-target="#cuchubalModal" title="Editar">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger m-1" data-id="${cuchubal.id}" onclick="eliminarCuchubal(${cuchubal.id})" title="Eliminar">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          `;
            $('#lista-cuchubales').append(tarjetaCuchubal);
          });
          $('#btnCrearCuchubal').show();
        }
        $('[data-toggle="tooltip"]').tooltip();
      },
      error: function(error) {
        console.error('Error al cargar los cuchubales:', error);
      }
    });
  }

  function abrirModalCuchubal(id = 0) {
    if (id === 0) {
      $('#formCuchubal')[0].reset();
      $('#cuchubalId').val('');
      $('#cuchubalModalLabel').text('Crear Cuchubal');
    } else {
      // Cargar datos del cuchubal para editar
      $.ajax({
        url: `http://localhost/cuchubal-app/backend/cuchubales/${id}`,
        type: 'GET',
        success: function(data) {
          $('#nombreCuchubal').val(data.name);
          $('#descripcionCuchubal').val(data.description);
          $('#montoCuchubal').val(data.amount);
          $('#fechaInicio').val(data.startDate);
          $('#fechaFin').val(data.deadline);
          $('#cuchubalId').val(data.id);
          $('#cuchubalModalLabel').text('Editar Cuchubal');
        },
        error: function(error) {
          console.error('Error al cargar el cuchubal:', error);
        }
      });
    }
    $('#cuchubalModal').modal('show');
  }

  function guardarCuchubal() {
    var id = $('#cuchubalId').val();
    var nombre = $('#nombreCuchubal').val();
    var descripcion = $('#descripcionCuchubal').val();
    var monto = $('#montoCuchubal').val();
    var fechaInicio = $('#fechaInicio').val();
    var fechaFin = $('#fechaFin').val();

    var metodo = id ? 'PUT' : 'POST';
    var url = id ?
      `http://localhost/cuchubal-app/backend/cuchubales/${id}` :
      'http://localhost/cuchubal-app/backend/cuchubales';

    $.ajax({
      url: url,
      type: metodo,
      contentType: 'application/json',
      data: JSON.stringify({
        //userId: $('#userId').data('userid'),
        userId: 2,
        name: nombre,
        description: descripcion,
        amount: monto,
        startDate: fechaInicio,
        deadline: fechaFin
      }),
      success: function(response) {
        $('#cuchubalModal').modal('hide');
        cargarCuchubales();
      },
      error: function(error) {
        console.error('Error al guardar el cuchubal:', error);
      }
    });
  }

  function eliminarCuchubal(id) {
    Swal.fire({
      title: '¿Estás seguro de querer eliminar este cuchubal?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `http://localhost/cuchubal-app/backend/cuchubales/${id}`,
          type: 'DELETE',
          success: function() {
            cargarCuchubales();
          },
          error: function(error) {
            console.error('Error al eliminar el cuchubal:', error);
          }
        });
      }
    });
  }

  $(document).ready(function() {
    cargarCuchubales();
  });

  $('#btnCrearCuchubal').click(function() {
    abrirModalCuchubal(0);
  });

  $(document).on('click', '.editarCuchubal', function() {
    var cuchubalId = $(this).data('id');
    abrirModalCuchubal(cuchubalId);
  });
</script>

<style>
  .cuchubal-card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .cuchubal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }

  .card-title {
    color: #007bff;
  }

  .card-info {
    margin-top: 10px;
    font-size: 0.9em;
  }

  .amount {
    color: #28a745;
    font-weight: bold;
  }

  .card-link {
    display: inline-block;
    margin-top: 15px;
    color: #17a2b8;
  }

  .card-image {
    width: 100%;
    max-height: 200px;
    object-fit: cover;
  }

  .empty-state {
    text-align: center;
    margin-top: 50px;
  }

  .empty-state p {
    font-size: 1.5em;
    color: #6c757d;
  }

  .empty-state button {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 1em;
  }
</style>