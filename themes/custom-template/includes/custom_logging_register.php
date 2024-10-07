<?php
function custom_add_scripts() {
    // Encolar jQuery si no está ya encolado
    wp_enqueue_script('jquery');

    // Pasar el estado de login al script de JavaScript
    wp_localize_script('jquery', 'wp_user_data', array(
        'is_logged_in' => is_user_logged_in() ? 'true' : 'false',
        'ajax_url'     => admin_url('admin-ajax.php'), // URL para las peticiones AJAX
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

            // Usar delegación de eventos para asegurar que el formulario pueda ser capturado
            $(document).on('submit', '#loginForm', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de manera normal
                var username = $('#username').val();
                var password = $('#password').val();

                // Realizar la petición AJAX para iniciar sesión
                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url, // URL de admin-ajax.php
                    data: {
                        action: 'custom_user_login', // Acción personalizada en PHP
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            // Si el login es exitoso, mostrar alerta y recargar la página
                            alert('Logueado correctamente');
                            location.reload(); // Recargar la página para reflejar el estado logueado
                        } else {
                            // Mostrar error
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostrar error en caso de que la petición AJAX falle
                        alert('Error en la solicitud: ' + error);
                    }
                });
            });
        })(jQuery); // Pasamos jQuery como alias $ para evitar conflictos
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
    // Verificar los parámetros
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        // Intentar iniciar sesión
        $user = wp_signon(array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => true,
        ));

        if (is_wp_error($user)) {
            // Devolver error si las credenciales son incorrectas
            wp_send_json_error(array('message' => 'Credenciales incorrectas'));
        } else {
            // Devolver éxito si el inicio de sesión fue correcto
            wp_send_json_success();
        }
    } else {
        wp_send_json_error(array('message' => 'Faltan datos'));
    }
}


/*** EVITAMOS VER CARRITO Y CHECKOUT SI NO ESTÁ LOGUEADO ***/
add_action('wp_ajax_custom_user_login', 'custom_user_login');
add_action('wp_ajax_nopriv_custom_user_login', 'custom_user_login'); // Permitir que los usuarios no logueados accedan
add_action('template_redirect', 'require_login_before_checkout');
function require_login_before_checkout() {
    if (!is_user_logged_in() && (is_checkout() || is_cart())) {
        wp_redirect('my-account');
        exit;
    }
}
/*** EVITAMOS VER CARRITO Y CHECKOUT SI NO ESTÁ LOGUEADO ***/

