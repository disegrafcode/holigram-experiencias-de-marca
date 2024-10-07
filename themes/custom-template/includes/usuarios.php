<?php
// Agregar los nuevos campos en la página de edición de usuarios
function agregar_campos_personalizados_perfil($user) {
    // Obtener los valores actuales de los campos personalizados
    $tipo_usuario = get_user_meta($user->ID, 'tipo_usuario', true);
    $razon_social = get_user_meta($user->ID, 'razon_social', true);
    $ruc = get_user_meta($user->ID, 'ruc', true);
    $verificado = get_user_meta($user->ID, 'verificado', true);
    ?>
    <h3>Información Personalizada</h3>
    <table class="form-table">
        <tr>
            <th><label for="tipo_usuario">Tipo de Usuario</label></th>
            <td>
                <select name="tipo_usuario" id="tipo_usuario">
                    <option value="cliente_final" <?php selected($tipo_usuario, 'cliente_final'); ?>>Cliente Final</option>
                    <option value="agencia_tercerizadora" <?php selected($tipo_usuario, 'agencia_tercerizadora'); ?>>Agencia Tercerizadora de Servicios</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="razon_social">Razón Social</label></th>
            <td>
                <input type="text" name="razon_social" id="razon_social" value="<?php echo esc_attr($razon_social); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="ruc">RUC</label></th>
            <td>
                <input type="text" name="ruc" id="ruc" value="<?php echo esc_attr($ruc); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="verificado">Verificado</label></th>
            <td>
                <input type="checkbox" name="verificado" id="verificado" value="1" <?php checked($verificado, '1'); ?> />
                <label for="verificado">¿Verificado?</label>
            </td>
        </tr>
    </table>
    <?php
}

// Guardar los campos personalizados cuando se guarda el perfil del usuario
function guardar_campos_personalizados_perfil($user_id) {
    // Verificar permisos
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Guardar o actualizar los metadatos del usuario
    update_user_meta($user_id, 'tipo_usuario', $_POST['tipo_usuario']);
    update_user_meta($user_id, 'razon_social', sanitize_text_field($_POST['razon_social']));
    update_user_meta($user_id, 'ruc', sanitize_text_field($_POST['ruc']));
    update_user_meta($user_id, 'verificado', isset($_POST['verificado']) ? '1' : '0');
}

// Hooks para mostrar y guardar los campos
add_action('show_user_profile', 'agregar_campos_personalizados_perfil');
add_action('edit_user_profile', 'agregar_campos_personalizados_perfil');
add_action('personal_options_update', 'guardar_campos_personalizados_perfil');
add_action('edit_user_profile_update', 'guardar_campos_personalizados_perfil');
