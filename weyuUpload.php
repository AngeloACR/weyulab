<?php
/* Template Name:weyuUpload */

/*
https://developers.facebook.com/docs/instagram-basic-display-api/getting-started
https://developers.facebook.com/docs/instagram-basic-display-api/guides/getting-profiles-and-media
https://developers.facebook.com/docs/instagram-basic-display-api/guides/getting-access-tokens-and-permissions
https://developers.facebook.com/apps/353848015765495/instagram-basic-display/basic-display/
*/

?>


<?php
if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
    $order = get_post($orderId);
    $orderProduct = get_post_meta($orderId, 'product', true);
    $orderUploadedPhotos = get_post_meta($orderId, 'photos_uploaded', true);
    $orderStatus = get_post_meta($orderId, 'status', true);
    $photoList = get_post_meta($orderId, 'photoList', true);
    $totalPhotos = get_post_meta($orderId, 'totalPhotos', true);
}

$home = get_home_url();
$redirectURL = $home . '/instagramAuth/';
$igAppId = "623198801923091";
$igURL = "https://api.instagram.com/oauth/authorize?client_id=" . $igAppId . "&orderId=" . $orderId . "&redirect_uri=" . $redirectURL . "&scope=user_profile,user_media&response_type=code";
$fbURL = "https://weyulab.com/facebookauth?&orderId=" . $orderId;

$home = get_home_url();
$urlEditor = $home . '/editor' . '?orderId=' . $orderId;


$nonce = wp_create_nonce("photoList");
$src = $home;

?>

<div class="bigBox">
    <div class="stepBox">
        <a href="/carga?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-01-1.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/editor?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-02.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/dedicatoria?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-03.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/revision?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-04.png" alt="">
        </a>
    </div>
    <div class="moduleBox">
        <div class="titleBox">
            <p>CARGAR FOTOS</p>
        </div>
        <div class="instructionsBox">
            <p>-Carga tus fotos desde tu dispositivo, Instagram o Facebook.</p>
            <p>-Si cargarás fotos deste tu dispositivo, ten en cuenta que solo puedes subir 20 a la vez.</p>
            <p>-Puedes cargar hasta un máximo de <span style="font-weight: bold;"><?php echo $totalPhotos; ?></span> fotos.</p>
            <p>-Una vez cargadas todas las fotos, continua a la siguiente sección para editarlas.</p>
        </div>
        <div class="counterBox">
            <p>Fotos cargadas: <span id="numberOfPhotosUploaded"></span></p>
            <p>Fotos restantes: <span id="remainingPhotosToUpload"></span></p>
        </div>

        <div class="uploadIcons">
            <div class="pcUpload">
            </div>
            <form class="fileUpload" enctype="multipart/form-data">
                <div class="form-group">
                    <label>
                        <img id="pc" src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-SUBIR-FOTO.png" alt="">
                        <input type="file" name="clientFile" id="file" accept="image/*" multiple />
                    </label>
                </div>
            </form>
            <img id="instagram" src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-INSTAGRAM-1.png" alt="">
            <img id="facebook" src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-FACEBOOK-1.png" alt="">
        </div>

        <div id="photosBox" class="uploadedPhotos">
        </div>
        <div class="buttonBox">
            <a href="<?php echo $urlEditor; ?>">IR AL EDITOR</a>
        </div>
    </div>
</div>

<style>
    #file {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .moduleBox {
        height: 100%;
        width: 90%;
        overflow: scroll;
        overflow-x: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .moduleBox::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .moduleBox::-webkit-scrollbar {
        width: 6px;
        background-color: #F5F5F5;
    }

    .moduleBox::-webkit-scrollbar-thumb {
        background-color: #d91887;
    }

    .uploadIcons {
        display: flex;
        flex-direction: row;
        width: 100%;
        align-items: center;
        justify-content: center;
    }

    .uploadIcons img {
        height: 100px;
        margin-right: 15px;
        margin-left: 15px;
        cursor: pointer;
    }

    .uploadIcons img:first-child {
        height: 180px;
    }

    .uploadedPhotos {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
    }

    .uploadedPhoto {
        width: 14%;
        margin-left: 2%;
        margin-right: 2%;
        margin-bottom: 20px;
    }

    .uploadedPhoto img {
        width: 100%;
    }

    .buttonBox {
        width: 180px;
        margin-bottom: 30px;
        cursor: pointer;
    }

    .buttonBox a {
        padding: 10px;
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

    .buttonBox a:hover {
        background-color: white;
        color: #d91887;
    }

    @media only screen and (max-width: 800px) {}
</style>

<script>
    let orderId = "<?php echo $orderId; ?>";
    let photoList = <?php echo $photoList; ?>;
    let totalPhotos = <?php echo $totalPhotos; ?>;
    let uploadedPhotosInit = <?php echo $orderUploadedPhotos; ?>;


    localStorage.setItem("orderId", orderId);
    var pc = document.getElementById("pc");
    var pcUpload = document.getElementById("file");
    var facebook = document.getElementById("facebook");
    var instagram = document.getElementById("instagram");
    var close = document.getElementById("cBox")

    var nonce = "&nonce=<?php echo $nonce; ?>"

    let pcUploadLink = "<?php echo $src . "/wp-admin/admin-ajax.php?action=photoList"; ?>";
    let igUpload = "<?php echo $src . "/wp-admin/admin-ajax.php?action=igPhoto"; ?>";

    let igWindow;
    let fbWindow;
    let photoWindow;

    changeUploadedCounter(totalPhotos, uploadedPhotosInit)
    showPhotos(photoList);

    instagram.addEventListener("click", function() {
        let igURL = "<?php echo $igURL; ?>"
        igWindow = window.open(igURL, "igBox", "width=600,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes,left=100,top=50")

    });

    function openPhotoWindow(accessToken) {
        let url = "<?php echo $home; ?>"
        let igUrl = `${url}/instagramphotolist/?orderId=${orderId}&accessToken=${accessToken}`
        igWindow.location.href = igUrl;
    }

    function openFBWindow(accessToken, userId) {
        let url = "<?php echo $home; ?>"
        let fbUrl = `${url}/facebookphotolist/?orderId=${orderId}&accessToken=${accessToken}&userId=${userId}`
        fbWindow.location.href = fbUrl;
    }

    function closeIgWindow() {
        igWindow.close();
    }

    pcUpload.addEventListener("change", function() {
        var fileList = pcUpload.files; // The <input type="file" /> field
        let i = 0;
        // Loop through each data and create an array file[] containing our files data.
        // our AJAX identifier
        let link = getUploadLink();
        console.log(fileList);
        let fd = new FormData();
        for (let i = 0; i < fileList.length; i++) {
            name = "clientFile" + i;
            fd.append(name, fileList[i]);
        }
        let ajax = new XMLHttpRequest();
        ajax.open("POST", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    let newPhotoList = response.newPhotoList
                    showPhotos(newPhotoList);
                    changeUploadedCounter(totalPhotos, response.photos_uploaded)
                    setLocalStorage(response);
                    console.log(response);
                } else
                    console.log("Error loading page\n");
            }
        };
        ajax.send(fd);

    })

    function setLocalStorage(data) {
        localStorage.setItem("photoList", JSON.stringify(data.photoList));
        localStorage.setItem("uploadedPhotos", data.photos_uploaded);
    }

    function showPhotos(photoList) {
        let photosBox = document.getElementById("photosBox");
        photoList.forEach(photo => {
            let photoBox = document.createElement("DIV");
            let photoImg = document.createElement("IMG");
            photoImg.src = photo;
            photoBox.appendChild(photoImg);
            photoBox.className = "uploadedPhoto";
            photosBox.appendChild(photoBox);
        });
    }

    function showNewIgPhotos(photoList, uploadedPhotos) {
        showPhotos(photoList);
        changeUploadedCounter(totalPhotos, uploadedPhotos)
        igWindow.close();
    }

    function showNewFbPhotos(photoList, uploadedPhotos) {
        showPhotos(photoList);
        changeUploadedCounter(totalPhotos, uploadedPhotos)
        fbWindow.close();
    }

    function getUploadLink() {
        let link = `${pcUploadLink}&orderId=${orderId}&contentType=false&processData=false`;
        return link
    }

    facebook.addEventListener("click", function() {
        console.log("Uploading photo from Facebook");
        let fbURL = "<?php echo $fbURL; ?>"
        fbWindow = window.open(fbURL, "igBox", "width=600,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes,left=100,top=50")
    })

    function changeUploadedCounter(totalPhotos, uploadedPhotos) {
        let cargadas = document.getElementById("numberOfPhotosUploaded")
        let restantes = document.getElementById("remainingPhotosToUpload")

        let auxCargadas = uploadedPhotos;
        let auxRestantes = totalPhotos - auxCargadas;
        cargadas.innerText = auxCargadas;
        restantes.innerText = auxRestantes;
    }



    /* close.addEventListener("click", function() {
        box.style.display = "none";
        modal.style.display = "none";

        box.style.height = "0%";
        modal.style.height = "0%";
    })
     */
</script>