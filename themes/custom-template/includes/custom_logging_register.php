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
            // Función para abrir modal de registro y cerrar el de login
            window.registrarme = function() {
                $('#loginModal').modal('hide');
                $('#registerModal').modal('show');
            };

            // Validar el formulario antes de enviarlo
            function validarFormulario() {
                var nombres = $('#nombres').val();
                var apellidos = $('#apellidos').val();
                var correo = $('#correo').val();
                var contrasena = $('#password').val();
                var repite_contrasena = $('#password_confirm').val();
                var tipo_usuario = $('input[name="tipo_usuario"]:checked').val();
                var razon_social = $('#razon_social').val();
                var ruc = $('#ruc').val();
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                // Validar que los campos obligatorios no estén vacíos
                if (!nombres || !apellidos || !correo || !contrasena || !repite_contrasena) {
                    alert('Todos los campos son obligatorios.');
                    return false;
                }

                // Validar que el correo tenga un formato válido
                if (!emailRegex.test(correo)) {
                    alert('Por favor ingresa un correo válido.');
                    return false;
                }

                // Validar que las contraseñas coincidan
                if (contrasena !== repite_contrasena) {
                    alert('Las contraseñas no coinciden.');
                    return false;
                }

                // Validar que si es "Agencia tercerizadora de servicios", los campos "Razón Social" y "RUC" no estén vacíos
                if (tipo_usuario === 'Agencia tercerizadora de servicios') {
                    if (!razon_social || !ruc) {
                        alert('Por favor completa los campos Razón Social y RUC.');
                        return false;
                    }
                }

                return true;
            }

            // Manejar el submit del formulario de registro con AJAX
            $(document).on('submit', '#registerForm', function(e) {
                e.preventDefault();
                
                // Validar antes de enviar
                if (!validarFormulario()) {
                    return;
                }

                // Recoger los datos del formulario
                var formData = {
                    action: 'custom_user_registration',
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    correo: $('#correo').val(),
                    password: $('#password').val(),
                    tipo_usuario: $('input[name="tipo_usuario"]:checked').val(),
                    razon_social: $('#razon_social').val(),
                    ruc: $('#ruc').val(),
                };

                // Enviar el registro mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Registrado correctamente');
                            $('#registerModal').modal('hide'); // Cerrar modal
                        } else {
                            alert('Error: ' + response.data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en la solicitud: ' + error);
                    }
                });
            });

            // Mostrar/ocultar campos "Razón Social" y "RUC" según el tipo de usuario
            $('input[name="tipo_usuario"]').on('change', function() {
                if ($(this).val() === 'Agencia tercerizadora de servicios') {
                    $('#razon_social_group, #ruc_group').show();
                } else {
                    $('#razon_social_group, #ruc_group').hide();
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

