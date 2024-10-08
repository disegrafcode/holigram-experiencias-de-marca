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
                // Cerrar el modal de login si está abierto
                $('#loginModal').modal('hide');
                
                // Mostrar el modal de registro
                $('#registerModal').modal('show');
            };

            // Función de validación del formulario de registro
            function validateRegisterForm() {
                var nombres = $('#nombres').val().trim();
                var apellidos = $('#apellidos').val().trim();
                var correo = $('#correo').val().trim();
                var contrasena = $('#password').val().trim();
                var repite_contrasena = $('#password_confirm').val().trim();
                var tipo_usuario = $('input[name="tipo_usuario"]:checked').val();
                var razon_social = $('#razon_social').val().trim();
                var ruc = $('#ruc').val().trim();

                // Validaciones
                if (nombres === '' || apellidos === '' || correo === '' || contrasena === '' || repite_contrasena === '') {
                    alert('Todos los campos son obligatorios.');
                    return false;
                }

                // Validar que las contraseñas coincidan
                if (contrasena !== repite_contrasena) {
                    alert('Las contraseñas no coinciden.');
                    return false;
                }

                // Validar el tipo de usuario
                if (tipo_usuario === 'Agencia tercerizadora de servicios') {
                    if (razon_social === '' || ruc === '') {
                        alert('Razón social y RUC son obligatorios para Agencias tercerizadoras.');
                        return false;
                    }
                }

                // Validar el formato de correo
                var emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
                if (!emailPattern.test(correo)) {
                    alert('Formato de correo inválido.');
                    return false;
                }

                return true;
            }

            // Manejar el envío del formulario de registro
            $(document).on('submit', '#registerForm', function(e) {
                e.preventDefault();

                // Validar el formulario antes de enviarlo
                if (!validateRegisterForm()) {
                    return;
                }

                // Recoger los datos del formulario
                var formData = {
                    action: 'custom_user_register', // Acción personalizada en PHP
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    correo: $('#correo').val(),
                    password: $('#password').val(),
                    tipo_usuario: $('input[name="tipo_usuario"]:checked').val(),
                    razon_social: $('#razon_social').val(),
                    ruc: $('#ruc').val(),
                };

                // Realizar la solicitud AJAX
                $.ajax({
                    type: 'POST',
                    url: wp_user_data.ajax_url, // URL de admin-ajax.php
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Registro exitoso
                            alert('Registrado correctamente');
                            location.reload(); // Recargar la página
                        } else {
                            // Mostrar mensaje de error si el correo ya está registrado
                            if (response.data.message === 'email_exists') {
                                alert('El correo ya está registrado.');
                            } else {
                                alert('Error: ' + response.data.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostrar error en caso de que la petición AJAX falle
                        alert('Error en la solicitud: ' + error);
                    }
                });
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

// Función para procesar el registro vía AJAX
function custom_user_register() {
    if (isset($_POST['correo'])) {
        $email = sanitize_email($_POST['correo']);

        // Verificar si el correo ya está registrado
        if (email_exists($email)) {
            wp_send_json_error(array('message' => 'email_exists'));
        }

        // Crear el nuevo usuario
        $userdata = array(
            'user_login'    => $email,
            'user_email'    => $email,
            'first_name'    => sanitize_text_field($_POST['nombres']),
            'last_name'     => sanitize_text_field($_POST['apellidos']),
            'user_pass'     => sanitize_text_field($_POST['password']),
        );

        $user_id = wp_insert_user($userdata);

        if (!is_wp_error($user_id)) {
            // Guardar los campos personalizados
            update_user_meta($user_id, 'tipo_usuario', sanitize_text_field($_POST['tipo_usuario']));
            update_user_meta($user_id, 'razon_social', sanitize_text_field($_POST['razon_social']));
            update_user_meta($user_id, 'ruc', sanitize_text_field($_POST['ruc']));

            // Respuesta exitosa
            wp_send_json_success();
        } else {
            wp_send_json_error(array('message' => $user_id->get_error_message()));
        }
    }

    wp_die();
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

