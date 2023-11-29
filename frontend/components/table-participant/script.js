$(document).ready(function () {
  // Aquí puedes cargar la data inicial
  cargarDatosParticipantes();

  // Función para filtrar por estado
  window.filtrarEstado = function (estado) {
    // Lógica para filtrar los datos según el estado
    console.log("Filtrar por estado:", estado);
    // Aquí deberás actualizar la tabla según el filtro
  };

  // Función para cargar datos en la tabla
  function cargarDatosParticipantes() {
    // Aquí haces una solicitud AJAX para obtener los datos de los participantes
    // y luego llenas la tabla.
    // Esto es un ejemplo de cómo podrías añadir una fila:
    $("#tablaParticipantes").append(`
            <tr>
                <td>Nombre Ejemplo</td>
                <td>Contacto Ejemplo</td>
                <td>Dirección Ejemplo</td>
                <td>Método de Pago Ejemplo</td>
                <td><span class="badge bg-success">Completado</span></td>
                <td>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Nombre Ejemplo</td>
                <td>Contacto Ejemplo</td>
                <td>Dirección Ejemplo</td>
                <td>Método de Pago Ejemplo</td>
                <td><span class="badge bg-warning">Parcial</span></td>
                <td>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td>Nombre Ejemplo</td>
                <td>Contacto Ejemplo</td>
                <td>Dirección Ejemplo</td>
                <td>Método de Pago Ejemplo</td>
                <td><span class="badge bg-danger">No pagado</span></td>
                <td>
                    <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `);
  }
});
