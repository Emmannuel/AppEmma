// Función para activar el modo oscuro
function enableDarkMode() {
    document.body.classList.add('dark-mode'); // Aplica una clase CSS para el modo oscuro
    saveDarkModePreference(true); // Comunicar la preferencia al servidor
}

// Función para desactivar el modo oscuro
function disableDarkMode() {
    document.body.classList.remove('dark-mode'); // Elimina la clase CSS para el modo oscuro
    saveDarkModePreference(false); // Comunicar la preferencia al servidor
}

// Función para alternar entre el modo oscuro y claro
function toggleDarkMode() {
    if (document.body.classList.contains('dark-mode')) {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
}

// Escuchar el clic en el botón y alternar el modo oscuro
document.getElementById('darkModeButton').addEventListener('click', toggleDarkMode);

// Función para guardar la preferencia de modo oscuro en el servidor (usando AJAX)
function saveDarkModePreference(isDarkModeEnabled) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './usuarios/oscuro.php?dark_mode=' + (isDarkModeEnabled ? '1' : '0'), true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = xhr.responseText;
            console.log(response); // Puedes mostrar la respuesta en la consola para depuración.
        }
    };

    xhr.send();
}

// Aplicar el modo oscuro si está habilitado
if (localStorage.getItem('darkMode') === 'enabled') {
    enableDarkMode();
}
