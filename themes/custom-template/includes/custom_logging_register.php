<?php
function custom_add_scripts() {
    // Encolar jQuery si no está ya encolado
    wp_enqueue_script('jquery');

    // Pasar el estado de login al script de JavaScript
    wp_localize_script('jquery', 'wp_user_data', array(
        'is_logged_in' => is_user_logged_in() ? 'true' : 'false',
        'ajax_url' => admin_url('admin-ajax.php'), // URL para las solicitudes Ajax
    ));

    // Agregar el script personalizado en el footer
    add_action('wp_footer', 'custom_js_code');
}
add_action('wp_enqueue_scripts', 'custom_add_scripts');

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

            // Asignar la función al botón de agregar lista
            $('button').on('click', function() {
                addLista();
            });

            // Manejar el login con AJAX
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url,
                    data: {
                        action: 'custom_user_login', // Acción para wp_ajax
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Login exitoso');
                            $('#loginModal').modal('hide');
                            location.reload(); // Recargar la página para reflejar el login
                        } else {
                            alert('Error de inicio de sesión: ' + response.data.message);
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

// Función para manejar la solicitud de login vía Ajax
function custom_user_login() {
    // Recibir datos del formulario
    $username = isset($_POST['username']) ? sanitize_text_field($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Intentar iniciar sesión con los datos proporcionados
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    );
    $user = wp_signon($creds, false);

    // Verificar si el login fue exitoso
    if (is_wp_error($user)) {
        wp_send_json_error(array('message' => $user->get_error_message()));
    } else {
        wp_send_json_success();
    }
}
add_action('wp_ajax_custom_user_login', 'custom_user_login');
add_action('wp_ajax_nopriv_custom_user_login', 'custom_user_login');
