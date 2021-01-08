<?php
// Add custom Theme Functions her


// Our custom post type function
function weyulabOrder()
{

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x('Paquetes de fotos', 'Post Type General Name', 'divi'),
        'singular_name'       => _x('Paquete de fotos', 'Post Type Singular Name', 'divi'),
        'menu_name'           => __('Paquetes de fotos', 'divi'),
        'parent_item_colon'   => __('Padre', 'divi'),
        'all_items'           => __('Todos los paquetes', 'divi'),
        'view_item'           => __('Ver paquete', 'divi'),
        'add_new_item'        => __('Agregar nuevo paquete', 'divi'),
        'add_new'             => __('Agregar nuevo', 'divi'),
        'edit_item'           => __('Editar paquete', 'divi'),
        'update_item'         => __('Actualizar paquete', 'divi'),
        'search_items'        => __('Buscar paquete', 'divi'),
        'not_found'           => __('No encontrado', 'divi'),
        'not_found_in_trash'  => __('No encontrado en la basura', 'divi'),
    );

    // Set other options for Custom Post Type

    $args = array(
        'label'               => __('photoPacks', 'divi'),
        'description'         => __('Información del paquete de fotos, fotos cargadas, fotos editadas, fotos redimensionadas, dedicatoria y status del pedido', 'divi'),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields', 'page'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array('genres'),
        /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-images-alt2',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,

    );

    // Registering your Custom Post Type
    unregister_post_type('photopacks');
    register_post_type('photopacks', $args);
}

add_action('init', 'weyulabOrder');
