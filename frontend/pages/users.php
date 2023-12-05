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

    <!--Container Main start-->
    
    <div class="row">
     
      <div class="col-sm-4">
        <div class="card h-100 card-center">
          <img src="https://www.trecebits.com/wp-content/uploads/2011/09/IMAGEN-DE-PERFIL-FACEBOOK.jpg" class="card-img-top imagen-perfil" alt="...">
          <div class="card-body card-center">
            <h5 class="card-title"><b>Juan Luis Guerra</b></h5>
            <p class="card-text"> <span class="gray">Puesto:</span>  Sistemas <br>
              <span class="gray">Empresa:</span>  Tubagua S.A. </p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Información<button class="btn btn-outline-danger float-end">Editar</button></h5>
            
            <hr>
            <p class="card-text">
              <span class="gray">Nombre:</span> Juan Luis <br>
              <span class="gray">Apellido:</span> Guerra Paz <br>
              <span class="gray">Edad:</span> 44 <br>
              <span class="gray">Puesto:</span> Sistemas <br>
              <span class="gray">Empresa:</span> Tubagua S.A. <br>
              <span class="gray">Ciudad:</span> Mixco <br>
              <span class="gray">Dirección:</span> 15 Calle B Cayala Zona 5 Guatemala <br>
              <span class="gray">Celular: </span> +502 45488454 <br>
              <span class="gray">Teléfono:</span> +502 54548154 <br> 
              <span class="gray">Correo Electrónico:</span> marcapatitogt@gmail.com
            </p>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card h-75">
          <div class="card-body">
            <h5 class="card-title">Contactos<button class="btn btn-outline-danger float-end">Editar</button></h5>
            <hr>
            <p class="card-text"><span class="gray">Esposa: </span> Maria Juana - +502 54656484 <br><br>
              <span class="gray">Esposa: </span> Maria Juana - +502 54656484 <br><br>
              <span class="gray">Esposa: </span> Maria Juana - +502 54656484 <br><br>
            </p>
          </div>
        </div>
      </div>
    </div>
    <br><br>
    <div class="row">
      <div class="col-sm-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Informacion</h5>
            <p class="card-text"></p>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Informacion</h5>
            <p class="card-text"></p>
          </div>
        </div>
      </div>
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