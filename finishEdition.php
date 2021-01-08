<?php


add_action('wp_ajax_nopriv_finishEdition', 'finishEdition');
add_action('wp_ajax_finishEdition', 'finishEdition');

function finishEdition()
{
    /*
    $nonce = $_REQUEST['nonce'];
    if ( !wp_verify_nonce( $nonce, "myCustomCartNonce")) {
        die("Get out, mf!");
    } */
    if (isset($_REQUEST["orderId"])) {
        $orderId = $_REQUEST["orderId"];
    }



    $order = get_post($orderId);
    $editedFolder = get_post_meta($orderId, 'editedFolder', true);
    $webPath = get_post_meta($orderId, 'webFolder', true);
    $webFolder = $webPath . 'edited/';

    /*     $editedList = array();
    if (isset($_REQUEST)) {
        $files = scandir($editedFolder);
        $files = array_diff($files, array('..', '.'));
        foreach ($files as $file) {
            if ($file != '.' || $file != '..') {
                $filePath = $webFolder . $file;
                array_push($editedList, $filePath);
            }
        }
    }

    $newList = json_encode($editedList);

    $data = update_post_meta($orderId, 'editedList', $newList); */


    /*     $home = get_home_url();
    $urlCarga = $home . "/dedicatoria";

    wp_redirect($urlCarga . '?orderId=' . $orderId); */

    $response = array(/* 
        'editedList' => $editedList, */
        'request' => $_REQUEST

    );
    echo json_encode($response);

    wp_die();
}
