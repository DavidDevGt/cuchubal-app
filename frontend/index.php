<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cuchubal App</title>
  <?php require 'includes/libs.php'; ?>
</head>

<body>
  <?php require 'includes/navbar/navbar.php'; ?>
  <div class="container-fluid">
    <?php require 'router.php'; ?>
  </div>
  <?php require 'includes/footer/footer.php'; ?>
  <script>
    // Funciones globales útiles

    // Validar un monto ingresado si es mayor a cero
    function validarMontoPositivo(monto) {
      return parseFloat(monto) > 0;
    }

    // Función para formatear valores en Quetzales
    function formatToQuetzales(amount) {
      const formattedAmount = parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
      return `Q${formattedAmount}`;
    }

    // Convertir texto a mayúsculas
    function upperText(texto) {
      return texto.toUpperCase();
    }

    // Validar que la fecha de inicio sea menor a la fecha de fin
    function validarFechasInicioFin(fechaInicio, fechaFin) {
      const fechaInicioObj = new Date(fechaInicio);
      const fechaFinObj = new Date(fechaFin);

      return fechaInicioObj < fechaFinObj;
    }

    // Obtener fecha actual en formato YYYY-MM-DD
    function obtenerFechaActual() {
      const fechaActual = new Date();
      const año = fechaActual.getFullYear();
      const mes = String(fechaActual.getMonth() + 1).padStart(2, '0');
      const dia = String(fechaActual.getDate()).padStart(2, '0');
      return `${año}-${mes}-${dia}`;
    }
  </script>
</body>

</html>