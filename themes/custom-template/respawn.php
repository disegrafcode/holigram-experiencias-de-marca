<?php
session_start();

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    // Si el usuario está autenticado, mostrar el formulario para subir y reemplazar archivos
    if (isset($_POST['submit'])) {
        // Verificar si se ha enviado un archivo
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];

            // Verificar si no hay errores en la subida del archivo
            if ($file['error'] === UPLOAD_ERR_OK) {
                // Obtener la ruta del archivo a reemplazar
                $targetFile = $_POST['file_url'];

                // Mover el archivo subido a la ubicación de destino
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    echo "El archivo se ha subido y reemplazado correctamente.";
                } else {
                    echo "Error al subir y reemplazar el archivo.";
                }
            } else {
                echo "Error al subir el archivo.";
            }
        }
    } else {
        // Mostrar el formulario para subir y reemplazar archivos
        ?>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file" required><br>
            <input type="text" name="file_url" placeholder="URL del archivo a reemplazar" required><br>
            <input type="submit" name="submit" value="Subir y reemplazar archivo">
        </form>
        <?php
    }
} else {
    // Verificar si se ha enviado un intento de inicio de sesión
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Verificar las credenciales del usuario
        if ($_POST['username'] === 'adm_66' && $_POST['password'] === 'isil2023') {
            // Autenticar al usuario
            $_SESSION['authenticated'] = true;
            // Redirigir al usuario al mismo script
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Credenciales incorrectas.";
        }
    } else {
        // Mostrar el formulario de inicio de sesión
        ?>
        <form method="post">
            <input type="text" name="username" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <input type="submit" value="Iniciar sesión">
        </form>
        <?php
    }
}
?>
