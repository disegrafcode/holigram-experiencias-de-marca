<?php
function personalizar_formulario_busqueda($form)
{
    $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '" class="d-flex">';
    $form .= '<label class="screen-reader-text" for="s">' . __('Buscar por:') . '</label>';
    $form .= '<input type="search" value="'. get_search_query() .'" name="s" id="s" placeholder="' . __('Buscar...') . '"class="form-control me-2"/>';
    $form .= '<button type="submit" id="searchsubmit" class="btn btn-secondary">' . __('Buscar') . '</button>';
    $form .= '</form>';

    return $form;
}

add_filter('get_search_form', 'personalizar_formulario_busqueda');