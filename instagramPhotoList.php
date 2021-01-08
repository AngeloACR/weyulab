<?php
/* Template Name:instagramPhotoList */

if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
}
if (isset($_REQUEST["accessToken"])) {
    // insert the post and set the category
    $accessToken = $_REQUEST["accessToken"];
}
$home = get_home_url();
?>

<div class="igPhotosBigBox">
    <p class="titleText">Selecciona las fotos que quieres agregar a tu pedido</p>
    <div id="myIgPhotos">

    </div>
    <div id="selectButton" class="buttonBox">
        <button>SELECCIONAR</button>
    </div>
</div>

<style>
    #myIgPhotos {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    .igPhoto {
        height: 30%;
        margin-right: 20px;
    }

    input[type="checkbox"][id^="igPhoto"] {
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
    let orderId = "<?php echo $orderId; ?>";

    let selectButton = document.getElementById("selectButton");

    selectButton.addEventListener("click", function() {
        var checkboxes = document.getElementsByName("photoCheckbox");
        var igPhotoList = [];
        // loop over them all
        for (var i = 0; i < checkboxes.length; i++) {
            // And stick the checked ones onto an array...
            if (checkboxes[i].checked) {
                igPhotoList.push(checkboxes[i].value);
            }
        }
        // Return the array if it is non-empty, or null
        console.log(igPhotoList);
        let igUploadLink = "<?php echo $home; ?>/wp-admin/admin-ajax.php?action=igPhoto"
        let link = `${igUploadLink}&orderId=${orderId}`
        let fd = new FormData();
        let j = 0;
        igPhotoList.forEach(photo => {
            fd.append(`igPhotoList${j}`, photo);
            j++;
        });
        var igUpload = new XMLHttpRequest();
        igUpload.open('POST', link, true);


        igUpload.onreadystatechange = function() { //Call a function when the state changes.
            if (igUpload.readyState == 4 && igUpload.status == 200) {
                let response = JSON.parse(igUpload.responseText);
                console.log(response);
                window.opener.showNewIgPhotos(response.newPhotoList, response.photos_uploaded)
            }
        }
        igUpload.send(fd);

    })

    getIGPhotos(accessToken);

    function getIGPhotos(accessToken, userId) {
        let link = `https://graph.instagram.com/me/media?fields=media_type,media_url&access_token=${accessToken}`
        var igMedia = new XMLHttpRequest();
        igMedia.open('GET', link, true);
        igMedia.onreadystatechange = function() { //Call a function when the state changes.
            if (igMedia.readyState == 4 && igMedia.status == 200) {
                let response = JSON.parse(igMedia.responseText);
                let photosURL = []
                response.data.forEach(media => {
                    if (media.media_type == "IMAGE") {
                        photosURL.push(media.media_url);
                    }
                });
                printPhotosOnWindow(photosURL);
            }
        }
        igMedia.send();

    }

    function printPhotosOnWindow(photosURL) {
        let igPhotoBox = document.getElementById("myIgPhotos");
        let i = 0;
        photosURL.forEach(photo => {
            let div = document.createElement("DIV");
            let label = document.createElement("LABEL");
            let checkbox = document.createElement("INPUT");
            checkbox.type = "checkbox";
            checkbox.value = photo;
            checkbox.name = "photoCheckbox";
            checkbox.id = `igPhoto${i}`;
            label.htmlFor = `igPhoto${i}`;
            let img = document.createElement("IMG");
            img.src = photo;
            label.appendChild(img);
            div.appendChild(checkbox);
            div.appendChild(label);

            igPhotoBox.appendChild(div);
            i++;
        });
    }
</script>