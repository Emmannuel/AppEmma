function editUsers() {
    // Función para crear un campo de entrada
    function createInput(value) {
        const inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.value = value;
        return inputField;
    }

    // Obtener los elementos de los campos de entrada
    const usernameField = createInput(nomUsuario);
    const emailField = createInput(correo);
    const ageField = createInput(edad);
    const nameField = createInput(nombre);

    // Crear los botones "Guardar" y "Cancelar"
    const saveButton = document.createElement('button');
    saveButton.textContent = "Guardar";
    saveButton.className = "custom-button-p"; // Agregar la clase "custom-button-p" al botón "Guardar"
    saveButton.onclick = function() {
        // Aquí puedes agregar la lógica para guardar los cambios
        // Por ejemplo, puedes actualizar los valores y luego llamar a una función para cancelar.
        // Después de guardar los cambios, puedes llamar a la función "cancelar" para revertir la vista.
        guardar();
    };

    const cancelButton = document.createElement('button');
    cancelButton.textContent = "Cancelar";
    cancelButton.className = "custom-button-p"; // Agregar la clase "custom-button-p" al botón "Cancelar"
    cancelButton.onclick = function() {
        // Llama a la función "cancelar" para revertir la vista
        cancelar();
    };

    // Reemplazar los elementos existentes con los campos de entrada y los botones
    const usernameParagraph = document.getElementById('username');
    usernameParagraph.innerHTML = 'Nombre de Usuario:';
    usernameParagraph.appendChild(usernameField);

    const emailParagraph = document.getElementById('email');
    emailParagraph.innerHTML = 'Correo Electrónico:';
    emailParagraph.appendChild(emailField);

    const ageParagraph = document.getElementById('age');
    ageParagraph.innerHTML = 'Edad:';
    ageParagraph.appendChild(ageField);

    const nameParagraph = document.getElementById('name');
    nameParagraph.innerHTML = 'Nombre:';
    nameParagraph.appendChild(nameField);

    // Agregar los botones "Guardar" y "Cancelar" al div "botones"
    const botonesDiv = document.getElementById('botones');
    botonesDiv.innerHTML = '';
    botonesDiv.appendChild(saveButton);
    botonesDiv.appendChild(cancelButton);
}



function cancelar() {
    // Obtener los elementos de los campos de entrada
    const usernameParagraph = document.getElementById('username');
    const emailParagraph = document.getElementById('email');
    const ageParagraph = document.getElementById('age');
    const nameParagraph = document.getElementById('name');

    // Restaurar los párrafos originales
    usernameParagraph.innerHTML = 'Nombre de usuario: ' + nomUsuario;
    emailParagraph.innerHTML = 'Correo electrónico: ' + correo;
    ageParagraph.innerHTML = 'Edad: ' + edad;
    nameParagraph.innerHTML = 'Nombre: ' + nombre;
    
    // Eliminar botones
    const botonesDiv = document.getElementById('botones');
    botonesDiv.innerHTML = '';
}

function guardar() {
    try {
        // Obtener los valores de los campos de entrada editados
        const nuevoNomUsuario = document.getElementById('username').querySelector('input').value;
        const nuevoCorreo = document.getElementById('email').querySelector('input').value;
        const nuevaEdad = document.getElementById('age').querySelector('input').value;
        const nuevoNombre = document.getElementById('name').querySelector('input').value;

        // Realizar una solicitud AJAX para enviar los datos al servidor PHP
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './usuarios/usuario.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = xhr.responseText;
                if (response === 'success') {
                    cancelar();
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                } else {
                    alert('Error al guardar los datos. Inténtalo de nuevo.');
                }
            }
        };
        const data = 'nom_usuario=' + nuevoNomUsuario + '&correo=' + nuevoCorreo + '&edad=' + nuevaEdad + '&nombre=' + nuevoNombre;
        xhr.send(data);
    } catch (error) {
        console.error('Error en guardar:', error);
    }
}


/// buscar usuarios ///

document.getElementById('formBusqueda').addEventListener('submit', function (event) {
    event.preventDefault();

    const searchTerm = document.getElementById('busqueda').value;

    // Realiza una solicitud al servidor para buscar usuarios
    fetch('./usuarios/usuarios.php', {
        method: 'POST',
        body: JSON.stringify({ searchTerm }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Procesa y muestra los resultados
        const resultadosDiv = document.getElementById('resultados');
        resultadosDiv.innerHTML = '';

        if (data.length === 0) {
            resultadosDiv.innerHTML = 'No se encontraron usuarios.';
        } else {
            data.forEach(usuario => {
                document.getElementById('busqueda').value = "";
                const usuarioDiv = document.createElement('div');
                usuarioDiv.textContent = `Nombre de usuario: ${usuario.nom_usuario}, Correo: ${usuario.correo}, Edad: ${usuario.edad}`;
                resultadosDiv.appendChild(usuarioDiv);
            });
        }
    })
    .catch(error => {
        console.error('Error al buscar usuarios', error);
    });
});

