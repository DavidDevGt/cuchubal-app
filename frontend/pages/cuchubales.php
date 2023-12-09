<?php $userId = $_SESSION['user_id'] ?? 0; ?>

<div class="container mt-5">
  <h1>Cuchubales</h1>
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
        <!-- Formulario para Crear/Editar Cuchubal -->
        <!-- ... -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>


<script>
  function cargarCuchubales() {
    // var userId = $('#userId').data('userid');
    var userId = 1;
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
            <button id="crearCuchubal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cuchubalModal">Crear Cuchubal</button>
          </div>
        `);
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
                    <span class="amount">Monto: Q${cuchubal.amount}</span>
                  </div>
                  <div class="d-flex justify-content-center align-items-center mt-3">
                    <button class="btn btn-info m-1" data-id="${cuchubal.id}" data-toggle="tooltip" data-placement="top" title="Ver Detalles">
                      <i class="fas fa-info-circle"></i>
                    </button>
                    <button class="btn btn-success m-1" ${disabledEdit} data-id="${cuchubal.id}" data-bs-toggle="modal" data-bs-target="#cuchubalModal" data-toggle="tooltip" data-placement="top" title="Editar">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger m-1" data-id="${cuchubal.id}" data-toggle="tooltip" data-placement="top" title="Eliminar">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          `;
            $('#lista-cuchubales').append(tarjetaCuchubal);
          });
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
        userId: $('#userId').data('userid'),
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

  $(document).ready(function() {
    cargarCuchubales();
  });

  $('#crearCuchubal').click(function() {
    // Implementar la lógica para llevar al usuario a la pantalla de creación de un nuevo cuchubal.
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