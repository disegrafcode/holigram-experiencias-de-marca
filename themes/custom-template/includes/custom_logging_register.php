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

            // Mostrar modal de registro al hacer click en 'Registrarme'
            $('#registerBtn').on('click', function() {
                $('#loginModal').modal('hide'); // Cerrar modal de login
                $('#registerModal').modal('show'); // Abrir modal de registro
            });

            // Procesar registro de usuario
            $(document).on('submit', '#registerForm', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de manera normal
                var formData = {
                    action: 'custom_user_register',
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    email: $('#email').val(),
                    password: $('#password').val(),
                    repeat_password: $('#repeat_password').val(),
                    tipo_usuario: $('input[name="tipo_usuario"]:checked').val(),
                    razon_social: $('#razon_social').val(),
                    ruc: $('#ruc').val()
                };

                // Validar que las contraseñas coincidan
                if (formData.password !== formData.repeat_password) {
                    alert('Las contraseñas no coinciden.');
                    return;
                }

                // Realizar la petición AJAX para registrar al usuario
                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Registrado correctamente. Ahora puedes iniciar sesión.');
                            $('#registerModal').modal('hide');
                            $('#loginModal').modal('show'); // Abrir modal de login después de registrarse
                        } else {
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en la solicitud: ' + error);
                    }
                });
            });
        })(jQuery);
    </script>

    <!-- Modal de Bootstrap para Iniciar Sesión -->
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
                        <button type="button" class="btn btn-secondary" id="registerBtn">Registrarme</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Bootstrap para Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registrarse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" id="nombres" placeholder="Nombres" required>
                        </div>
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" placeholder="Apellidos" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="repeat_password">Repite la Contraseña</label>
                            <input type="password" class="form-control" id="repeat_password" placeholder="Repite la Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo de Usuario</label>
                            <div>
                                <input type="radio" name="tipo_usuario" value="cliente_final" checked> Cliente Final
                                <input type="radio" name="tipo_usuario" value="agencia"> Agencia Tercerizadora de Servicios
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="razon_social">Razón Social</label>
                            <input type="text" class="form-control" id="razon_social" placeholder="Razón Social">
                        </div>
                        <div class="form-group">
                            <label for="ruc">RUC</label>
                            <input type="text" class="form-control" id="ruc" placeholder="RUC">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Procesar la solicitud AJAX para el registro
function custom_user_register() {
    // Verificar los parámetros del formulario
    if (isset($_POST['nombres'], $_POST['apellidos'], $_POST['email'], $_POST['password'], $_POST['tipo_usuario'])) {
        $nombres = sanitize_text_field($_POST['nombres']);
        $apellidos = sanitize_text_field($_POST['apellidos']);
        $email = sanitize_email($_POST['email']);
        $password = sanitize_text_field($_POST['password']);
        $tipo_usuario = sanitize_text_field($_POST['tipo_usuario']);
        $razon_social = isset($_POST['razon_social']) ? sanitize_text_field($_POST['razon_social']) : '';
        $ruc = isset($_POST['ruc']) ? sanitize_text_field($_POST['ruc']) : '';

        // Crear usuario de WordPress
        $user_id = wp_create_user($email, $password, $email);
        if (is_wp_error($user_id)) {
            wp_send_json_error(array('message' => 'Error al registrar al usuario.'));
        } else {
            // Guardar los metadatos personalizados
            update_user_meta($user_id, 'first_name', $nombres);
            update_user_meta($user_id, 'last_name', $apellidos);
            update_user_meta($user_id, 'tipo_usuario', $tipo_usuario);
            if ($razon_social) {
                update_user_meta($user_id, 'razon_social', $razon_social);
            }
            if ($ruc) {
                update_user_meta($user_id, 'ruc', $ruc);
            }
            wp_send_json_success();
        }
    } else {
        wp_send_json_error(array('message' => 'Faltan campos obligatorios.'));
    }
}
add_action('wp_ajax_custom_user_register', 'custom_user_register');
add_action('wp_ajax_nopriv_custom_user_register', 'custom_user_register');


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

