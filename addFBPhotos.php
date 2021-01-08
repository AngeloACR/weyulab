<?php


add_action('wp_ajax_nopriv_fbPhoto', 'addFbPhotos');
add_action('wp_ajax_fbPhoto', 'addFbPhotos');

function addFbPhotos()
{
    /*
    $nonce = $_REQUEST['nonce'];
    if ( !wp_verify_nonce( $nonce, "myCustomCartNonce")) {
        die("Get out, mf!");
    } */
    if (isset($_REQUEST["orderId"])) {
        $orderId = $_REQUEST["orderId"];
    }
    if (isset($_POST)) {
        $fbPhotoList = $_POST;
    }

    $order = get_post($orderId);
    $title = $order->post_title;
    $photoList = json_decode(get_post_meta($orderId, 'photoList', true));
    $i = 0;
    $newPhotoList = array();
    $photosUploaded = get_post_meta($orderId, 'photos_uploaded', true);
    $nextPhotoIndex = get_post_meta($orderId, 'next_photo_index', true);
    $facebookNextIndex = get_post_meta($orderId, 'next_facebook_index', true);

    $orderFolder = get_post_meta($orderId, 'uploadedFolder', true);
    $webPath = get_post_meta($orderId, 'webFolder', true);
    $webFolder = $webPath . 'uploaded/';

    $newNextPhotoIndex = 0;
    $newFacebookIndex = 0;
    $home = get_home_url();

    /*     $ordersUploadFolder = '/wp-content/uploads/ordersUploads/';
    $targetPathBase = $_SERVER['DOCUMENT_ROOT'] . $ordersUploadFolder;

    if (!file_exists($targetPathBase)) {
        mkdir($targetPathBase, 0755, true);
    }
    $targetFolder = $title . '/';
    $targetPathOrder =  $targetPathBase . $targetFolder;
    if (!file_exists($targetPathOrder)) {
        mkdir($targetPathOrder, 0755, true);
    }
    $webPath = $home . $ordersUploadFolder . $targetFolder;

 */
    if (isset($_POST)) {
        $i = 0;
        foreach ($_POST as $p => $photo) {
            $facebookIndex = $i + $facebookNextIndex;
            $filename = "facebook" . $facebookIndex . ".jpg";
            //            $targetFile = $targetPathOrder . $filename;
            $targetFile = $orderFolder . $filename;
            $webFile = $webFolder . $filename;
            array_push($photoList, $webFile);
            array_push($newPhotoList, $webFile);

            $ch = curl_init($photo);
            $fp = fopen($targetFile, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            //            move_uploaded_file($photo, $targetFile);
            $photoIndex = $i + $nextPhotoIndex;

            $metaName = "Foto-" . $photoIndex;
            $metaValue = $targetFile;

            add_post_meta($orderId, $metaName, $metaValue, true);
            $uploadOk = 1;
            $i += 1;
            $newNextPhotoIndex =  $i + $nextPhotoIndex;
            $newFacebookIndex =  $i + $facebookNextIndex;
        }
        update_post_meta($orderId, "next_photo_index", $newNextPhotoIndex);
        update_post_meta($orderId, "next_facebook_index", $newFacebookIndex);

        $totalPhotos = $i + $photosUploaded;
        update_post_meta($orderId, "photos_uploaded", $totalPhotos);

        $newList = json_encode($photoList);
        $data = update_post_meta($orderId, 'photoList', $newList);


        $postContent = array();

        foreach ($photoList as $key => $value) {
            array_push($postContent, $value);
        }
        $jsonContent = json_encode($postContent);
        $args = array(
            'ID' => $orderId,
            'post_content' => $jsonContent,
        );

        /*Setting up our custom query */
        $data = wp_update_post($args);
    }
    $response = array(
        'orderId' => $orderId,
        'post_content' => $jsonContent,
        'photos_uploaded' => $totalPhotos,
        'photoList' => $photoList,
        'newPhotoList' => $newPhotoList,
        'next_photo_index' => $newNextPhotoIndex,
    );

    echo json_encode($response);

    /*Setting up our custom query *//* 
    $data = wp_update_post($args); */

    /* 
    $home = get_home_url();
    $urlCarga = $home . "/editor";

    wp_redirect($urlCarga . '?orderId=' . $orderId);*/
    wp_die();
}
