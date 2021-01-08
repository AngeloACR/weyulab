<?php


add_action('wp_ajax_nopriv_finishOrder', 'finishOrder');
add_action('wp_ajax_finishOrder', 'finishOrder');

function finishOrder()
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
    $sku = get_post_meta($orderId, 'product', true);
    $orderFolder = get_post_meta($orderId, 'orderFolder', true);
    $editedFolder = get_post_meta($orderId, 'editedFolder', true);
    $resizedFolder = get_post_meta($orderId, 'resizedFolder', true);
    $webPath = get_post_meta($orderId, 'webFolder', true);
    $photoList = json_decode(get_post_meta($orderId, 'photoList', true));
    $proportion = json_decode(get_post_meta($orderId, 'proportion', true));
    $dedicatory = json_decode(get_post_meta($orderId, 'dedicatory', true));
    $webFolder = $webPath . 'resized/';
    if (isset($_REQUEST)) {
        $i = 0;
        foreach ($photoList as $photo) {
            $resizedFilename = "resized" . $i . ".jpg";
            $editedFilename = "edited" . $i . ".jpg";
            //$filename = basename($file['name']);
            $sourceFile = $editedFolder . $editedFilename;
            $targetFile = $resizedFolder . $resizedFilename;
            $webFile = $webFolder . $resizedFilename;
            $maxHeight = 1200;
            $maxWidth = $maxHeight * $proportion;

            resizeImage($sourceFile, $targetFile, $maxWidth, $maxHeight, 100);
            $metaName = "Foto-redimensionada-" . $i;
            $metaValue = $webFile;
            add_post_meta($orderId, $metaName, $metaValue, true);
            $uploadOk = 1;
            $i = $i + 1;
        }
    }

    $title = $order->post_title;
    $zipFolder = $title . '/';
    $compressionFile = $title . '-imagenes.zip';

    compressPhotos($resizedFolder, $orderFolder, $compressionFile, $zipFolder, $dedicatory);
    $message = 'Adjunto se encuentran las fotos de la orden, redimensionadas al tamaño adecuado';
    $fileToSend = $orderFolder . $compressionFile;

    $response = array(
        'compressionFile' => $compressionFile,
        'maxWidth'  => $maxWidth,
        'maxHeight'  => $maxHeight,
        'fileToSend'  => $fileToSend,
    );
    echo json_encode($response);

    /* 
    $home = get_home_url();
    $urlCarga = $home . "/dedicatoria";

    wp_redirect($urlCarga . '?orderId=' . $orderId);*/

    $productId = wc_get_product_id_by_sku($sku);
    $added_to_cart = WC()->cart->add_to_cart($productId, 1);
    wp_mail('ordenes@weyulab.com', $title, $message, '', $fileToSend);
    wp_die();
}


function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 80)
{
    // Obtain image from given source file.
    if (!$image = @imagecreatefromjpeg($sourceImage)) {
        return false;
    }

    // Get dimensions of source image.
    list($origWidth, $origHeight) = getimagesize($sourceImage);

    if ($maxWidth == 0) {
        $maxWidth  = $origWidth;
    }

    if ($maxHeight == 0) {
        $maxHeight = $origHeight;
    }

    // Calculate ratio of desired maximum sizes and original sizes.
    $widthRatio = $maxWidth / $origWidth;
    $heightRatio = $maxHeight / $origHeight;

    // Ratio used for calculating new image dimensions.
    $ratio = min($widthRatio, $heightRatio);

    // Calculate new image dimensions.
    $newWidth  = (int) $origWidth  * $ratio;
    $newHeight = (int) $origHeight * $ratio;

    // Create final image with new dimensions.
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
    imagejpeg($newImage, $targetImage, $quality);

    // Free up the memory.
    imagedestroy($image);
    imagedestroy($newImage);

    return true;
}

function compressPhotos($sourceFolder, $targetFolder, $targetFile, $zipFolder, $dedicatory)
{
    $zip = new ZipArchive();

    $filePath = $targetFolder . $targetFile;
    //$filePath = $targetFile;
    /*     if ($zip->open($targetFile, ZIPARCHIVE::CREATE) !== TRUE) {
        die("Unable to open Zip Archive ");
    }
 */
    if ($zip->open($filePath, ZIPARCHIVE::CREATE) !== TRUE) {
        die("Unable to open Zip Archive ");
    }

    if ($handle = opendir($sourceFolder)) {
        // Add all files inside the directory
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && !is_dir($sourceFolder . $entry)) {
                $zip->addFile($sourceFolder . $entry, $zipFolder . $entry);
            }
        }
        closedir($handle);
    }
    $zip->addFromString($zipFolder . 'dedicatoria.txt', $dedicatory);
    $zip->close();
}
