<?php

function weyuVitrina()
{
    ob_start();
    get_template_part('weyuVitrina');
    return ob_get_clean();
}
add_shortcode('weyu_vitrina', 'weyuVitrina');

function weyuUpload()
{
    ob_start();
    get_template_part('weyuUpload');
    return ob_get_clean();
}
add_shortcode('weyu_upload', 'weyuUpload');

function weyuEdicion()
{
    ob_start();
    get_template_part('weyuEdicion');
    return ob_get_clean();
}
add_shortcode('weyu_edicion', 'weyuEdicion');

function weyuDedicatoria()
{
    ob_start();
    get_template_part('weyuDedicatoria');
    return ob_get_clean();
}
add_shortcode('weyu_dedicatoria', 'weyuDedicatoria');

function weyuContacto()
{
    ob_start();
    get_template_part('weyuContacto');
    return ob_get_clean();
}
add_shortcode('weyu_contacto', 'weyuContacto');

function weyuBlog()
{
    ob_start();
    get_template_part('weyuBlog');
    return ob_get_clean();
}
add_shortcode('weyu_blog', 'weyuBlog');

function weyuRevision()
{
    ob_start();
    get_template_part('weyuRevision');
    return ob_get_clean();
}
add_shortcode('weyu_review', 'weyuRevision');

function weyuConfirmPayment()
{
    ob_start();
    get_template_part('weyuConfirmPayment');
    return ob_get_clean();
}
add_shortcode('weyu_confirmacion', 'weyuConfirmPayment');
