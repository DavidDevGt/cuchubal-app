<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Template - Cuchubal App</title>

  <?php require 'includes/libs.php'; ?>

</head>

<body>

<?php require 'includes/navbar/navbar.php'; ?>

  <!-- INICIA EL CONTENIDO DE LA PÁGINA -->
  <div class="container">
    <div class="container mt-4">
      <div class="btn-group mb-3" role="group" aria-label="Filtro de Estado">
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Todos')">
          Todos
        </button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('No pagado')">
          No pagado
        </button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Parcial')">
          Parcial
        </button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Completado')">
          Completado
        </button>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Contacto</th>
            <th>Dirección</th>
            <th>Método de Pago</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaParticipantes">
          <!-- Las filas de la tabla se llenarán dinámicamente aquí -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- FINALIZA EL CONTENIDO DE LA PÁGINA -->

</body>

</html>