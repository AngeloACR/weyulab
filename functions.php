<?php
// Add custom Theme Functions here

// https://developers.facebook.com/docs/instagram-basic-display-api/getting-started

// https://developers.facebook.com/apps/353848015765495/instagram-basic-display/basic-display/

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles', 11);
function my_theme_enqueue_styles()
{

    $parent_style = 'parent-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts()
{
?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<?php
}




function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');
// Hooking up our function to theme setup


include_once('weyushorts.php');

include_once('createWeyuOrder.php');
include_once('editPhoto.php');
include_once('addPCPhotos.php');
include_once('addIGPhotos.php');
include_once('addFBPhotos.php');
include_once('finishOrder.php');
include_once('saveDedicatory.php');
include_once('finishEdition.php');
include_once('confirmOrderCPT.php');
include_once('photoPackCPT.php');
include_once('confirmPayment.php');
