<div class="container mt-5">
    <h2>Usuarios</h2>
    <table class="table table-striped">
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

<script>
    $(document).ready(function() {
        $.ajax({
            url: 'http://localhost/cuchubal-app/backend/users',
            type: 'GET',
            success: function(usuarios) {
                console.table(usuarios);
                usuarios.forEach(function(usuario) {
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
                                <button class="btn btn-primary btn-sm"><i class="fa-solid fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    `;
                    $('#tabla-usuarios').append(fila);
                });
            },
            error: function(error) {
                console.log('Error al cargar los usuarios:', error);
            }
        });
    });
</script>