// -- index php -- //
document.getElementById('show-register').addEventListener('click', function() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
});

document.getElementById('show-login').addEventListener('click', function() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
});
// -- Registro php -- //
function crearUsuario() {
    var usuario = document.getElementById("users").value;
    var nombre = document.getElementById("nombre").value;
    var contrasena = document.getElementById("contras").value;
    var edad = document.getElementById("edad").value;
    var correo = document.getElementById("correo").value;
    // Realiza una solicitud AJAX para enviar los datos al servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./usuarios/registro.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var respuesta = xhr.responseText;
                document.getElementById('mensaje').innerHTML = respuesta;
                document.getElementById('mensaje').style.display = "block";
            } else {
                // Manejar errores aquí
            }
        }
    };

    var data = "nombre=" + encodeURIComponent(nombre) + "&nom_usuario=" + encodeURIComponent(usuario) + "&contra=" + encodeURIComponent(contrasena) + "&edad=" + encodeURIComponent(edad) + "&correo=" + encodeURIComponent(correo);
xhr.send(data);
}
function login() {
    var nom_usuario = document.getElementById("user").value;
    var contraseña = document.getElementById("contra").value;

    // Realiza una solicitud AJAX para enviar los datos al servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./usuarios/login.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = "inicio.php"; // Redirigir si el inicio de sesión es exitoso
                } else {
                    alert(response.message); // Mostrar mensaje de error
                }
            } else {
                alert("Error en la solicitud: " + xhr.status + " " + xhr.statusText); // Mostrar error HTTP
            }
        }
    };

    // Enviar los datos del formulario al servidor
    var data = "nom_usuario=" + encodeURIComponent(nom_usuario) + "&contra=" + encodeURIComponent(contraseña);
    xhr.send(data);
}
