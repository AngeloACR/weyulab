<?php


add_action('wp_ajax_nopriv_editPhoto', 'editPhoto');
add_action('wp_ajax_editPhoto', 'editPhoto');

function editPhoto()
{
    /*
    $nonce = $_REQUEST['nonce'];
    if ( !wp_verify_nonce( $nonce, "myCustomCartNonce")) {
        die("Get out, mf!");
    } */
    if (isset($_REQUEST["orderId"])) {
        $orderId = $_REQUEST["orderId"];
    }
    if (isset($_REQUEST["photoSelected"])) {
        $photoSelected = $_REQUEST["photoSelected"];
    }
    $order = get_post($orderId);
    $editedFolder = get_post_meta($orderId, 'editedFolder', true);
    $editedPhotos = (int) get_post_meta($orderId, 'editedPhotos', true);
    $editedList = json_decode(get_post_meta($orderId, 'editedList', true));

    $webPath = get_post_meta($orderId, 'webFolder', true);
    $webFolder = $webPath . 'edited/';
    $files = scandir($editedFolder);
    if (isset($_REQUEST) && isset($_FILES)) {
        foreach ($_FILES as $f => $file) {
            if ($orderId) {
                $filename = "edited" . $photoSelected . ".jpg";
                //$filename = basename($file['name']);
                $targetFile = $editedFolder . $filename;
                $webFile = $webFolder . $filename;
                $aux = in_array($filename, $files);
                if (!$aux) {
                    $newCounter = $editedPhotos + 1;
                    $data = update_post_meta($orderId, 'editedPhotos', $newCounter);
                    array_push($editedList, $webFile);
                    $editedJSON = json_encode($editedList);
                    update_post_meta($orderId, "editedList", $editedJSON);
                } else {
                    $newCounter = $editedPhotos;
                    unlink($targetFile);
                }

                move_uploaded_file($file["tmp_name"], $targetFile);
                $metaName = "Foto-editada-" . $photoSelected;
                $metaValue = $webFile;
                add_post_meta($orderId, $metaName, $metaValue, true);
                $uploadOk = 1;
            }
        }
    }



    $response = array(
        'targetFile' => $targetFile,
        'filename' => $filename,
        'aux' => $aux,
        'editedFolder' => $editedFolder,
        'editedPhotos' => $newCounter,
        'editedList' => $editedList,
    );

    echo json_encode($response);

    /* 
    $home = get_home_url();
    $urlCarga = $home . "/dedicatoria";

    wp_redirect($urlCarga . '?orderId=' . $orderId);*/
    wp_die();
}
