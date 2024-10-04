<?php
if( function_exists('acf_add_options_page') ) {
    
    // Registrar la página de opciones
    acf_add_options_page(array(
        'page_title'    => 'Opciones del Tema',
        'menu_title'    => 'Opciones del Tema',
        'menu_slug'     => 'theme-options',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
    
    // (Opcional) Registrar una subpágina de opciones (Estos son 2 ejemplos para agregar sub pestañas)
    acf_add_options_sub_page(array(
        'page_title'    => 'Opciones de Cabecera',
        'menu_title'    => 'Cabecera',
        'parent_slug'   => 'theme-options',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'    => 'Opciones de Pie de Página',
        'menu_title'    => 'Pie de Página',
        'parent_slug'   => 'theme-options',
    ));
}