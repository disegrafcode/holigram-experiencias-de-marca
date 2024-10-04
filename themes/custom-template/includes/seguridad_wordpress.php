<?php
/*
Hecho por C.A.E - ISIL
*/
/* DESHABILITA EL XML-RPC */
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
add_action('init', function() {
    if (preg_match('/xmlrpc\.php/', $_SERVER['REQUEST_URI'])) {
        wp_die('XML-RPC está deshabilitado en este sitio.', 'XML-RPC Deshabilitado', array('response' => 403));
    }
});
/* DESHABILITA EL XML-RPC */

/* EVITA VER DATOS DE USUARIOS REGISTRADOS */
function redirect_author_pages() {
    if (is_author()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'redirect_author_pages');

/* EVITA VER DATOS DE USUARIOS REGISTRADOS */

/* DESHABILITAR EL ENDPOINT DE USUARIOS DE LA API REST DE WORDPRESS */
//tusitio.com/wp-json/wp/v2/users --> para comprobar si funciona bien
add_filter('rest_endpoints', function($endpoints) {
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
    return $endpoints;
});
/* DESHABILITAR EL ENDPOINT DE USUARIOS DE LA API REST DE WORDPRESS */

/* DESHABILITAR ENDPOINT DE EMBED */
//probar tusitio.com/wp-json/oembed/1.0/embed/
add_filter('rest_pre_dispatch', function ($result, $wp_rest_server, $request) {
    $route = $request->get_route();
    if (strpos($route, '/oembed/1.0/embed') !== false) {
        return new WP_Error('rest_forbidden', __('Access to this endpoint is restricted.'), array('status' => 403));
    }
    return $result;
}, 10, 3);
/* DESHABILITAR ENDPOINT DE EMBED */

/* DESHABILITAR EL SITE MAP DE USUARIOS */
//probar tusitio.com/wp-sitemap.xml --> Aqui no debe aparecer el sitemap de usuarios
add_action('template_redirect', function() {
    if (is_user_logged_in()) {
        return;
    }
    
    if (strpos($_SERVER['REQUEST_URI'], '/wp-sitemap-users-') !== false) {
        wp_redirect(home_url());
        exit;
    }
});

// Deshabilitar el sitemap de usuarios
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}, 10, 2 );
/* DESHABILITAR EL SITE MAP DE USUARIOS */

/* ELIMINAR INFORMACIÓN DE LOS USUARIOS DEL FEED */
//probar en tusitio.com/?feed=rss2&post_type=user
function replace_author_in_feed($content) {
    if (is_feed()) {
        $content = preg_replace('/<dc:creator>.*?<\/dc:creator>/', '<dc:creator>Anonymous</dc:creator>', $content);
        $content = preg_replace('/<author>.*?<\/author>/', '<author>Anonymous</author>', $content);
    }
    return $content;
}
add_filter('the_content_feed', 'replace_author_in_feed');
add_filter('the_excerpt_rss', 'replace_author_in_feed');
add_filter('the_content', 'replace_author_in_feed');

// Eliminar la información del autor del contenido del feed
function remove_author_from_feed($content) {
    if (is_feed()) {
        $content = preg_replace('/<dc:creator>.*?<\/dc:creator>/', '', $content);
        $content = preg_replace('/<author>.*?<\/author>/', '', $content);
    }
    return $content;
}
add_filter('the_content_feed', 'remove_author_from_feed');
add_filter('the_excerpt_rss', 'remove_author_from_feed');
add_filter('the_content', 'remove_author_from_feed');

// Eliminar la información del autor de los elementos del feed
function remove_author_from_feed_item($author) {
    if (is_feed()) {
        return '';
    }
    return $author;
}
add_filter('the_author', 'remove_author_from_feed_item');
add_filter('author_link', 'remove_author_from_feed_item');

// Eliminar etiquetas <author> del feed RSS2
function remove_author_rss2() {
    echo '';
}
add_action('rss2_item', 'remove_author_rss2', 9);

// Eliminar etiquetas <dc:creator> del feed RDF
function remove_author_rdf() {
    echo '';
}
add_action('rdf_item', 'remove_author_rdf', 9);

// Eliminar etiquetas <author> del feed Atom
function remove_author_atom() {
    echo '';
}
add_action('atom_entry', 'remove_author_atom', 9);
/* ELIMINAR INFORMACIÓN DE LOS USUARIOS DEL FEED */

/* DESHABILITAR LOS METODOS DELETE Y OPTIONS */
add_action('init', 'disable_options_and_delete_methods');
function disable_options_and_delete_methods() {
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'OPTIONS' || $method == 'DELETE') {
        header('HTTP/1.1 405 Method Not Allowed');
        exit;
    }
}
/* DESHABILITAR LOS METODOS DELETE Y OPTIONS */