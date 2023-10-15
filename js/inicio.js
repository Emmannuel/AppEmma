function per(){
window.location.href = 'perfil.php';
}
function crearPost() {
    var titulo = document.getElementById("titulo").value;
    var descripcion = document.getElementById("descripcion").value;
    var tema = document.getElementById("tema").value;

    // Validación básica de campos
    if (titulo.trim() === "" || descripcion.trim() === "") {
        alert("Por favor, complete todos los campos.");
        return;
    }

    // Crear un objeto que contenga los datos del nuevo post
    var nuevoPost = {
        titulo: titulo,
        descripcion: descripcion,
        tema: tema
    };

    // Realizar una solicitud AJAX para enviar los datos al servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./posts/guardar.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Respuesta exitosa del servidor, puedes hacer algo con la respuesta si es necesario
                alert("Post creado exitosamente.");
                limpiarFormulario();
            } else {
                // Manejar errores aquí
                alert("Error al crear el post.");
            }
        }
    };

    // Enviar el objeto como JSON
    xhr.send(JSON.stringify(nuevoPost));
}

// Función para limpiar el formulario después de la publicación
function limpiarFormulario() {
    document.getElementById("titulo").value = "";
    document.getElementById("descripcion").value = "";
    document.getElementById("tema").value = "Vida"; // Establecer el valor predeterminado
}

// Función para cargar los posts desde el servidor
function cargarPosts() {
    // Realizar una solicitud AJAX para obtener los datos de los posts
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "./posts/obtener.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                mostrarPosts(response.posts); // Llama a la función para mostrar los posts
            } else {
                // Manejar errores aquí
                alert("Error al cargar los posts.");
            }
        }
    };
    xhr.send();
}

// Función para mostrar los posts en el área designada
function mostrarPosts(posts) {
    var postsContainer = document.getElementById("posts-container");
    postsContainer.innerHTML = ""; // Limpiar el contenido actual

    // Recorre los posts y crea elementos HTML para cada uno
    for (var i = 0; i < posts.length; i++) {
        var post = posts[i];
        var postElement = document.createElement("div");
        postElement.className = "post";
        
        // Crea elementos para mostrar título, descripción y hora
        var tituloElement = document.createElement("h3");
        tituloElement.textContent = post.titulo;
        
        var descripcionElement = document.createElement("p");
        descripcionElement.textContent = post.descripccion;
        
        var timeElement = document.createElement("p");

        // Convierte la cadena de tiempo en un objeto Date
        var tiempoParts = post.time.split(":");
        var hora = parseInt(tiempoParts[0]);
        var minutos = parseInt(tiempoParts[1]);
        var segundos = parseInt(tiempoParts[2]);
        var fechaHora = new Date();
        fechaHora.setHours(hora, minutos, segundos);
        var id = post.id;
        // Formatea la hora en formato de 12 horas (AM/PM) y solo la hora y minutos
        var horaFormateada = fechaHora.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
        timeElement.textContent = "Hora de publicación: " + horaFormateada;
        // Crear elementos para mostrar los likes y dislikes de un post
var likesElement = document.createElement("p");
likesElement.innerHTML = `<i class="fas fa-thumbs-up" id="like-icon-${id}" onclick="darLike(${id})"></i> ${post.likes} Likes`;

var dislikesElement = document.createElement("p");
dislikesElement.innerHTML = `<i class="fas fa-thumbs-down" id="dislike-icon-${id}" onclick="darDislike(${id})"></i> ${post.dislikes} Dislikes`;
var likeButton = document.createElement("button");
likeButton.innerHTML = `<i class="fas fa-thumbs-up"></i>`;
likeButton.onclick = function() {
    darLike(post.id);
};

var dislikeButton = document.createElement("button");
dislikeButton.innerHTML = `<i class="fas fa-thumbs-down"></i>`;
dislikeButton.onclick = function() {
    darDislike(post.id);
};
        // Agrega los elementos al postElement
        postElement.appendChild(tituloElement);
        postElement.appendChild(descripcionElement);
        postElement.appendChild(timeElement);
        postElement.appendChild(likesElement);
        postElement.appendChild(dislikesElement);

        // Agrega el postElement al contenedor de posts
        postsContainer.appendChild(postElement);
    }
}




// Llama a la función para cargar los posts al cargar la página
window.addEventListener("load", cargarPosts);
// -- Postear un secreto -- //
// Función para mostrar el formulario modal
function mostrarFormulario() {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
}

// Función para cerrar el formulario modal
function cerrarFormulario() {
    var modal = document.getElementById("myModal");
    modal.style.display = "none";
}

// Cierra el modal si se hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById("myModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// -- Mostrar el usuario actual -- //
// Función para mostrar el perfil de usuario
function mostrarPerfil() {
    var usuarioModal = document.getElementById("perfilModal");
    usuarioModal.style.display = "block";
}

// Función para cerrar el perfil de usuario
function cerrarUsuario() {
    var usuarioModal = document.getElementById("perfilModal");
    usuarioModal.style.display = "none";
}

// Cierra el modal si se hace clic fuera de él
window.onclick = function(event) {
    var usuarioModal = document.getElementById("perfilModal");
    if (event.target == usuarioModal) {
        usuarioModal.style.display = "none";
    }
}

function darLike(postId) {
    enviarAccion(postId, "like");
}

function darDislike(postId) {
    enviarAccion(postId, "dislike");
}

function enviarAccion(postId, accion) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./posts/icons.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // Agrega esta línea para depuración
                var response = JSON.parse(xhr.responseText);
                document.getElementById("like-count-" + postId).textContent = response.likes;
                document.getElementById("dislike-count-" + postId).textContent = response.dislikes;
            } else {
                alert("Error al realizar la acción.");
            }
        }
    };

    var data = "postId=" + encodeURIComponent(postId) + "&accion=" + encodeURIComponent(accion);
    xhr.send(data);
}