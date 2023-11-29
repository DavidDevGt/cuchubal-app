$(document).ready(function () {
    cargarDatosParticipantes();
  
    window.filtrarEstado = function (estado) {
      // Implementar la lógica de filtrado aquí
      cargarDatosParticipantes(estado);
    };
  
    function cargarDatosParticipantes(estado = 'Todos') {
      $.ajax({
        url: `/cuchubal-app/backend/participants/cuchubal/1`, // Reemplaza el 1 con el ID del cuchubal real
        type: 'GET',
        dataType: 'json',
        success: function (participantes) {
          let filtrados = estado === 'Todos' ? participantes : participantes.filter(p => p.estado === estado);
          actualizarTabla(filtrados);
        },
        error: function (error) {
          console.error("Error al cargar los participantes", error);
        }
      });
    }
  
    function actualizarTabla(participantes) {
      let html = '';
      participantes.forEach(participante => {
        html += `<tr>
                    <td>${participante.nombre}</td>
                    <td>${participante.contacto}</td>
                    <td>${participante.direccion}</td>
                    <td>${participante.metodoPago}</td>
                    <td><span class="badge ${obtenerClaseBadge(participante.estado)}">${participante.estado}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
      });
      $('#tablaParticipantes').html(html);
    }
  
    function obtenerClaseBadge(estado) {
      switch (estado) {
        case 'Completado':
          return 'bg-success';
        case 'Parcial':
          return 'bg-warning';
        case 'No pagado':
          return 'bg-danger';
        default:
          return 'bg-secondary';
      }
    }
  });
  