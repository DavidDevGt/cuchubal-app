<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg">
        <div class="row no-gutters">
          <div class="col-lg-12">
            <div class="card-body p-5">
              <h3 class="card-title text-center text-gray-900 mb-4">Iniciar Sesión</h3>
              <form class="user" id="loginForm">
                <div class="form-group">
                  <label class="txt-lbl" for="username">Nombre de Usuario</label>
                  <input type="text" class="form-control form-control-user mt-2" id="username" placeholder="Ingresa tu nombre de usuario" />
                </div>
                <div class="form-group mt-3">
                  <label class="txt-lbl" for="password">Contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control form-control-user mt-2" id="password" placeholder="Ingresa tu contraseña" />
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary mt-2" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block mt-4">Iniciar sesión</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  /* Estilos para la tarjeta de login */
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  }

  /* Estilo para el título del formulario */
  .card-title {
    color: #4a5568;
    margin-bottom: 1rem;
  }

  /* Estilos para los campos del formulario */
  .form-control {
    margin-top: 0.25rem;
  }

  /* Estilos para el botón de envío */
  .btn-primary {
    background-color: #3490dc;
    border: none;
  }

  .txt-lbl {
    font-size: 15px;
  }

  /* Estilos para el checkbox */
  .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
    background-color: #3490dc;
  }
</style>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previene el envío por defecto

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    if (username === '' || password === '') {
      alert('Por favor, rellene todos los campos.');
    } else {
      console.log('Formulario enviado:', username, password);
    }
  });

  // Manejar la visualización de la contraseña
  document.getElementById('togglePassword').addEventListener('click', function(e) {
    const password = document.getElementById('password');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.children[0].classList.toggle('fas fa-eye');
    this.children[0].classList.toggle('fas fa-eye-slash');
  });
</script>