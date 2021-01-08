<?php


add_action('wp_ajax_nopriv_saveDedicatory', 'saveDedicatory');
add_action('wp_ajax_saveDedicatory', 'saveDedicatory');

function saveDedicatory()
{
    /*
    $nonce = $_REQUEST['nonce'];
    if ( !wp_verify_nonce( $nonce, "myCustomCartNonce")) {
        die("Get out, mf!");
    } */
    if (isset($_REQUEST["orderId"])) {
        $orderId = $_REQUEST["orderId"];
    }
    if (isset($_REQUEST["dedicatory"])) {
        $dedicatory = $_REQUEST["dedicatory"];
    }
    $order = get_post($orderId);

    update_post_meta($orderId, "dedicatory", $dedicatory);


    $response = array(
        'request' => $_REQUEST,
    );

    echo json_encode($response);


    /*     $home = get_home_url();
    $urlCarga = $home . "/revision";

    wp_redirect($urlCarga . '?orderId=' . $orderId); */
    wp_die();
}
