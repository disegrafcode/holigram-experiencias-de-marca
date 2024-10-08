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
            // Función para agregar lista
            window.addLista = function() {
                // Verificar si el usuario está logueado
                if (wp_user_data.is_logged_in === 'true') {
                    console.log('Usuario logueado');
                } else {
                    // Mostrar modal de login
                    $('#loginModal').modal('show');
                }
            };

            // Función para abrir modal de registro y cerrar el de login
            window.registrarme = function() {
                // Cerrar el modal de login si está abierto
                $('#loginModal').modal('hide');
                
                // Mostrar el modal de registro
                $('#registerModal').modal('show');
            };

            // Delegar el submit del formulario de registro (puedes añadir aquí la lógica AJAX para registrar)
            $(document).on('submit', '#registerForm', function(e) {
                e.preventDefault();
                // Aquí puedes manejar el registro con AJAX si lo deseas
                // Recoger los datos del formulario
                var nombres = $('#nombres').val();
                var apellidos = $('#apellidos').val();
                var correo = $('#correo').val();
                var contrasena = $('#password').val();
                var repite_contrasena = $('#password_confirm').val();
                var tipo_usuario = $('input[name="tipo_usuario"]:checked').val();
                var razon_social = $('#razon_social').val();
                var ruc = $('#ruc').val();

                // Lógica para el envío de la información de registro mediante AJAX
                // Puedes implementar wp_ajax para manejar el registro en el servidor
            });

            // Mostrar/ocultar campos "Razón Social" y "RUC" en función del tipo de usuario
            $('input[name="tipo_usuario"]').on('change', function() {
                if ($(this).val() === 'Agencia tercerizadora de servicios') {
                    $('#razon_social_group, #ruc_group').show();  // Mostrar
                } else {
                    $('#razon_social_group, #ruc_group').hide();  // Ocultar
                }
            });
        })(jQuery); // Pasamos jQuery como alias $ para evitar conflictos
    </script>

    <!-- Modal de Iniciar Sesión -->
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

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro</h5>
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
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" placeholder="Correo" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Repite Contraseña</label>
                            <input type="password" class="form-control" id="password_confirm" placeholder="Repite Contraseña" required>
                        </div>
                        <div class="form-group">
                            <label>Tipo de Usuario</label><br>
                            <input type="radio" name="tipo_usuario" value="cliente final" checked> Cliente Final<br>
                            <input type="radio" name="tipo_usuario" value="Agencia tercerizadora de servicios"> Agencia tercerizadora de servicios
                        </div>
                        <div class="form-group" id="razon_social_group" style="display:none;">
                            <label for="razon_social">Razón Social</label>
                            <input type="text" class="form-control" id="razon_social" placeholder="Razón Social">
                        </div>
                        <div class="form-group" id="ruc_group" style="display:none;">
                            <label for="ruc">RUC</label>
                            <input type="text" class="form-control" id="ruc" placeholder="RUC">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
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

