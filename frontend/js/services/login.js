$(document).ready(function () {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    var email = $("#email").val();
    var password = $("#password").val();
    // Aquí puedes agregar la lógica para verificar el inicio de sesión
    console.log("Iniciando sesión con:", email, password);
    // Haz la solicitud AJAX al backend aquí
  });
});
