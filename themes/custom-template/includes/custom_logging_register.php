<?php
function custom_add_scripts() {
    // Encolar jQuery si no está ya encolado
    wp_enqueue_script('jquery');

    // Pasar el estado de login al script de JavaScript
    wp_localize_script('jquery', 'wp_user_data', array(
        'is_logged_in' => is_user_logged_in() ? 'true' : 'false',
        'ajax_url'     => admin_url('admin-ajax.php'), // URL para las peticiones AJAX
        'nonce'        => wp_create_nonce('ajax-login-nonce') // Nonce de seguridad
    ));

    // Agregar el script personalizado en el footer
    add_action('wp_footer', 'custom_js_code');
}
add_action('wp_enqueue_scripts', 'custom_add_scripts');

function custom_js_code() {
    ?>
    <script type="text/javascript">
        (function($) {
            // Definir la función 'addLista' en el ámbito global
            window.addLista = function() {
                // Verificar si el usuario está logueado
                if (wp_user_data.is_logged_in === 'true') {
                    console.log('Usuario logueado');
                } else {
                    // Mostrar modal de login
                    $('#loginModal').modal('show');
                }
            };

            // Enviar formulario de login al hacer click en "Iniciar Sesión"
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de manera normal
                var username = $('#username').val();
                var password = $('#password').val();

                // Verificar que ambos campos estén llenos
                if (username === '' || password === '') {
                    alert('Por favor, complete todos los campos.');
                    return;
                }

                // Realizar la petición AJAX para iniciar sesión
                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url, // URL de admin-ajax.php
                    data: {
                        action: 'custom_user_login', // Acción personalizada en PHP
                        username: username,
                        password: password,
                        security: wp_user_data.nonce // Nonce de seguridad
                    },
                    success: function(response) {
                        if (response.success) {
                            // Si el login es exitoso, recargar la página
                            location.reload(); // O puedes redirigir a otra página si lo deseas
                        } else {
                            // Mostrar error
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en el servidor: ' + error);
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

// Procesar la solicitud AJAX para el login
function custom_user_login() {
    // Verificar el nonce de seguridad
    check_ajax_referer('ajax-login-nonce', 'security');

    // Verificar los parámetros
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        // Intentar iniciar sesión
        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        );
        $user = wp_signon($credentials, false);

        if (is_wp_error($user)) {
            // Devolver error si las credenciales son incorrectas
            wp_send_json_error(array('message' => $user->get_error_message()));
        } else {
            // Devolver éxito si el inicio de sesión fue correcto
            wp_send_json_success();
        }
    } else {
        wp_send_json_error(array('message' => 'Faltan datos.'));
    }
}
add_action('wp_ajax_custom_user_login', 'custom_user_login');
add_action('wp_ajax_nopriv_custom_user_login', 'custom_user_login'); // Permitir que los usuarios no logueados accedan