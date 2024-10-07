<?php
function custom_add_scripts() {
    // Encolar jQuery si no está ya encolado
    wp_enqueue_script('jquery');

    // Pasar el estado de login al script de JavaScript
    wp_localize_script('jquery', 'wp_user_data', array(
        'is_logged_in' => is_user_logged_in() ? 'true' : 'false',
        'ajax_url'     => admin_url('admin-ajax.php') // URL para las peticiones AJAX
    ));

    // Agregar el script personalizado en el footer
    add_action('wp_footer', 'custom_js_code');
}
add_action('wp_enqueue_scripts', 'custom_add_scripts');

// Procesar la solicitud AJAX para iniciar sesión
function ajax_login() {
    // Verificar los datos recibidos
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    // Intentar iniciar sesión
    $user = wp_signon($info, false);

    if (is_wp_error($user)) {
        // Devolver un error si no se pudo iniciar sesión
        echo json_encode(array('loggedin' => false, 'message' => 'Error en el nombre de usuario o la contraseña.'));
    } else {
        // Devolver éxito si se inició sesión correctamente
        echo json_encode(array('loggedin' => true, 'message' => 'Inicio de sesión exitoso, redirigiendo...'));
    }
    wp_die(); // Detener el procesamiento
}
add_action('wp_ajax_nopriv_ajax_login', 'ajax_login'); // Permitir para usuarios no autenticados
add_action('wp_ajax_ajax_login', 'ajax_login'); // Manejar la acción AJAX para iniciar sesión

function custom_js_code() {
    ?>
    <script type="text/javascript">
        (function($) {
            function addLista() {
                // Verificar si el usuario está logueado
                if (wp_user_data.is_logged_in === 'true') {
                    console.log('Usuario logueado');
                } else {
                    // Mostrar modal de login
                    $('#loginModal').modal('show');
                }
            }

            // Asignar la función al botón
            $('button').on('click', function() {
                addLista();
            });

            // Función para manejar el inicio de sesión
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario

                var username = $('#username').val();
                var password = $('#password').val();

                // Realizar la petición AJAX al backend de WordPress
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: wp_user_data.ajax_url, // La URL para la solicitud AJAX
                    data: {
                        'action': 'ajax_login', // La acción definida en el PHP
                        'username': username,
                        'password': password
                    },
                    success: function(response) {
                        if (response.loggedin === true) {
                            alert(response.message);
                            location.reload(); // Recargar la página después de iniciar sesión
                        } else {
                            alert(response.message); // Mostrar el error
                        }
                    }
                });
            });
        })(jQuery);
    </script>

    <!-- Modal de Bootstrap -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" class="form-control" id="username" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo wp_lostpassword_url(); ?>">Olvidé mi contraseña</a>
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
