<?php


add_action('wp_ajax_nopriv_myProductChoice', 'createOrder');
add_action('wp_ajax_myProductChoice', 'createOrder');

function createOrder()
{
    /*
    $nonce = $_REQUEST['nonce'];
    if ( !wp_verify_nonce( $nonce, "myCustomCartNonce")) {
        die("Get out, mf!");
    } */
    if (isset($_REQUEST["sku"])) {
        // insert the post and set the category
        $sku = $_REQUEST["sku"];
    }
    if (isset($_REQUEST["type"])) {
        // insert the post and set the category
        $type = $_REQUEST["type"];
    }
    if (isset($_REQUEST["totalPhotos"])) {
        // insert the post and set the category
        $totalPhotos = $_REQUEST["totalPhotos"];
    }
    if ($type == "C") {
        $proportion = 1.5;
    } else {
        $proportion = 0.75;
    }
    if ($sku) {
        $args = array(
            'post_type' => 'photopacks'
        );

        /*Setting up our custom query */
        //query_posts($args);
        $orderList = new WP_Query($args);
        $orderAux = wp_count_posts('photopacks');
        $orderCount = $orderAux->publish;
        $orderTitle = 'Orden ' . $orderCount;
        $tracker = $sku . "-" . ($orderCount);
        $orderContent = $sku;
        $orderArray = array(
            'post_type' => 'photopacks',
            'post_title' => $orderTitle,
            'post_content' => $orderContent,
            'post_status' => 'publish',
            'comment_status' => 'closed', // if you prefer
            'ping_status' => 'closed', // if you prefer
        );
        $orderId = wp_insert_post($orderArray);
        $home = get_home_url();

        if ($orderId) {

            $ordersUploadFolder = '/wp-content/uploads/ordersUploads/';
            $targetPathBase = $_SERVER['DOCUMENT_ROOT'] . $ordersUploadFolder;
            if (!file_exists($targetPathBase)) {
                mkdir($targetPathBase, 0755, true);
            }
            $targetFolder = $orderTitle . '/';
            $orderFolder =  $targetPathBase . $targetFolder;
            if (!file_exists($orderFolder)) {
                mkdir($orderFolder, 0755, true);
            }
            $uploadedFolder = $orderFolder . 'uploaded/';
            if (!file_exists($uploadedFolder)) {
                mkdir($uploadedFolder, 0755, true);
            }
            $editedFolder = $orderFolder . 'edited/';
            if (!file_exists($editedFolder)) {
                mkdir($editedFolder, 0755, true);
            }
            $resizedFolder = $orderFolder . 'resized/';
            if (!file_exists($resizedFolder)) {
                mkdir($resizedFolder, 0755, true);
            }

            $webPath = $home . $ordersUploadFolder . $targetFolder;

            // insert post meta
            $photoList = json_encode(array());
            $editedList = json_encode(array());
            add_post_meta($orderId, 'product', $sku, true);
            add_post_meta($orderId, 'totalPhotos', $totalPhotos, true);
            add_post_meta($orderId, 'photos_uploaded', 0, true);
            add_post_meta($orderId, 'editedPhotos', 0, true);
            add_post_meta($orderId, 'status', 'Cargando fotos', true);
            add_post_meta($orderId, 'tracker', $tracker, true);
            add_post_meta($orderId, 'photoList', $photoList, true);
            add_post_meta($orderId, 'editedList', $editedList, true);
            add_post_meta($orderId, 'next_photo_index', 0, true);
            add_post_meta($orderId, 'proportion', $proportion, true);
            add_post_meta($orderId, 'next_instagram_index', 0, true);
            add_post_meta($orderId, 'next_pc_index', 0, true);
            add_post_meta($orderId, 'next_facebook_index', 0, true);
            add_post_meta($orderId, 'orderFolder', $orderFolder, true);
            add_post_meta($orderId, 'webFolder', $webPath, true);
            add_post_meta($orderId, 'uploadedFolder', $uploadedFolder, true);
            add_post_meta($orderId, 'editedFolder', $editedFolder, true);
            add_post_meta($orderId, 'resizedFolder', $resizedFolder, true);
            add_post_meta($orderId, 'dedicatory', '', true);
        }
    }
    $urlCarga = $home . "/carga";

    wp_redirect($urlCarga . '?orderId=' . $orderId);
    wp_die();
}
