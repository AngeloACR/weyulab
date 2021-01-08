<?php
/* Template Name:facebookPhotoList */

if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
}
if (isset($_REQUEST["accessToken"])) {
    // insert the post and set the category
    $accessToken = $_REQUEST["accessToken"];
}
if (isset($_REQUEST["userId"])) {
    // insert the post and set the category
    $userId = $_REQUEST["userId"];
}
$home = get_home_url();
?>

<div class="fbPhotosBigBox">
    <p class="titleText">Selecciona las fotos que quieres agregar a tu pedido</p>
    <div id="myFbPhotos">

    </div>
    <div id="selectFBButton" class="buttonBox">
        <button>SELECCIONAR</button>
    </div>
</div>

<style>
    #myFbPhotos {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    .fbPhoto {
        height: 30%;
        margin-right: 20px;
    }

    input[type="checkbox"][id^="fbPhoto"] {
        display: none;
    }

    label {
        border: 1px solid #fff;
        padding: 10px;
        display: block;
        position: relative;
        margin: 10px;
        cursor: pointer;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    label::before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -5px;
        left: -5px;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 28px;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    label img {
        height: 200px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }

    :checked+label {
        border-color: #a3065c;
    }

    :checked+label::before {
        content: "✓";
        background-color: #d91887;
        transform: scale(1);
    }

    :checked+label img {
        transform: scale(0.9);
        box-shadow: 0 0 5px #333;
        z-index: -1;
    }

    .buttonBox {
        width: 100%;
        height: 30px;
        margin-bottom: 30px;
        cursor: pointer;
    }

    .buttonBox button {
        width: 100%;
        height: 100%;
        text-align: center;
        background-color: #d91887;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        border-style: solid;
        border-width: 2px;
        border-radius: 23px;
        border-color: #d91887;
    }

    .buttonBox button:hover {
        background-color: white;
        color: #d91887;
    }
</style>

<script>
    let accessToken = "<?php echo $accessToken; ?>";
    let userId = "<?php echo $userId; ?>";
    let orderId = "<?php echo $orderId; ?>";

    let selectFBButton = document.getElementById("selectFBButton");

    selectFBButton.addEventListener("click", function() {
        var checkboxes = document.getElementsByName("photoFBCheckbox");
        var fbPhotoList = [];
        // loop over them all
        for (var i = 0; i < checkboxes.length; i++) {
            // And stick the checked ones onto an array...
            if (checkboxes[i].checked) {
                fbPhotoList.push(checkboxes[i].value);
            }
        }
        // Return the array if it is non-empty, or null
        console.log(fbPhotoList);
        let fbUploadLink = "<?php echo $home; ?>/wp-admin/admin-ajax.php?action=fbPhoto"
        let link = `${fbUploadLink}&orderId=${orderId}`
        let fd = new FormData();
        let j = 0;
        fbPhotoList.forEach(photo => {
            fd.append(`fbPhotoList${j}`, photo);
            j++;
        });
        var fbUpload = new XMLHttpRequest();
        fbUpload.open('POST', link, true);


        fbUpload.onreadystatechange = function() { //Call a function when the state changes.
            if (fbUpload.readyState == 4 && fbUpload.status == 200) {
                let response = JSON.parse(fbUpload.responseText);
                console.log(response);
                window.opener.showNewFbPhotos(response.newPhotoList, response.photos_uploaded)
            }
        }
        fbUpload.send(fd);

    })

    getFBPhotos(accessToken, userId);

    function getFBPhotos(accessToken, userId) {
        let link = `https://graph.facebook.com/${userId}/photos?fields=id,images,link&access_token=${accessToken}`
        var fbMedia = new XMLHttpRequest();
        fbMedia.open('GET', link, true);
        fbMedia.onreadystatechange = function() { //Call a function when the state changes.
            if (fbMedia.readyState == 4 && fbMedia.status == 200) {
                let response = JSON.parse(fbMedia.responseText);
                let photosURL = []
                console.log(response)
                response.data.forEach(media => {
                    photosURL.push(media.images[0].source);
                });
                printFBPhotosOnWindow(photosURL);
            }
        }
        fbMedia.send();

    }

    function printFBPhotosOnWindow(photosURL) {
        let fbPhotoBox = document.getElementById("myFbPhotos");
        let i = 0;
        photosURL.forEach(photo => {
            let div = document.createElement("DIV");
            let label = document.createElement("LABEL");
            let checkbox = document.createElement("INPUT");
            checkbox.type = "checkbox";
            checkbox.value = photo;
            checkbox.name = "photoFBCheckbox";
            checkbox.id = `fbPhoto${i}`;
            label.htmlFor = `fbPhoto${i}`;
            let img = document.createElement("IMG");
            img.src = photo;
            label.appendChild(img);
            div.appendChild(checkbox);
            div.appendChild(label);

            fbPhotoBox.appendChild(div);
            i++;
        });
    }
</script>