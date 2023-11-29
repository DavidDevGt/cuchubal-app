<div class="container mt-4">
    <div class="btn-group mb-3" role="group" aria-label="Filtro de Estado">
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Todos')">Todos</button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('No pagado')">No pagado</button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Parcial')">Parcial</button>
        <button type="button" class="btn btn-outline-primary" onclick="filtrarEstado('Completado')">Completado</button>
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

<script src="script.js"></script>
<link rel="stylesheet" href="styles.css">