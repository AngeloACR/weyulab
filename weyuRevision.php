<?php
/* Template Name:weyuRevision */

//https://blog.bitsrc.io/image-manipulation-libraries-for-javascript-187fde1ad5af
if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
    $order = get_post($orderId);
    $photoList = get_post_meta($orderId, 'photoList', true);
    $editedList = get_post_meta($orderId, 'editedList', true);
    $uploadedPhotos = get_post_meta($orderId, 'photos_uploaded', true);
    $editedPhotos = get_post_meta($orderId, 'editedPhotos', true);
    $dedicatory = get_post_meta($orderId, 'dedicatory', true);
    $totalPhotos = get_post_meta($orderId, 'totalPhotos', true);
}

$home = get_home_url();
$urlCarrito = $home . '/carrito';

$finishLink = $home . "/wp-admin/admin-ajax.php?action=finishOrder";

$nonce = wp_create_nonce("weyuCarrito");

?>

<div class="bigBox">
    <div class="stepBox">
        <a href="/carga?orderId=<?php echo $orderId; ?>">

            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-01.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/editor?orderId=<?php echo $orderId; ?>">

            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-04.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/dedicatoria?orderId=<?php echo $orderId; ?>">

            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-03.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/revision?orderId=<?php echo $orderId; ?>">

            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-04-1.png" alt="">
        </a>
    </div>
    <div class="moduleBox">
        <div class="titleBox">
            <p>REVISAR PEDIDO</p>
        </div>
        <div class="instructionsBox">
            <p>-Aquí se muestra un resumen de lo que incluye tu pedido.</p>
            <p>-Verifica que todo está bien, y si ves algo fuera de lugar, dirígete a la vista correspondiente y corrígelo.</p>
            <p>-Cuando hayas verificado toda la información, procede al carrito para empezar con el pago.</p>
        </div>

        <div class="reviewContainer">
            <div class="reviewTitle">
                <p>Fotos cargadas: <?php echo $uploadedPhotos; ?>/<?php echo $totalPhotos; ?></p>
            </div>
            <div id="uploadedSlider" class="imgSlider">
            </div>
            <div class="reviewButtonBox">
                <button id="reviewUploadButton">IR A CARGAR FOTOS</button>
            </div>
        </div>

        <div class="reviewContainer">
            <div class="reviewTitle">
                <p>Fotos editadas: <?php echo $editedPhotos; ?>/<?php echo $uploadedPhotos; ?></p>
            </div>
            <div id="editedSlider" class="imgSlider">
            </div>
            <div class="reviewButtonBox">
                <button id="reviewEditButton">IR A EDITAR FOTOS</button>
            </div>
        </div>

        <div class="reviewContainer">
            <div class="reviewTitle">
                <p>Dedicatoria: </p>
            </div>
            <div class="dedicatoriaContent">
                <p><?php echo $dedicatory; ?></p>
            </div>
            <div class="reviewButtonBox">
                <button id="reviewDedicatoryButton">IR A DEDICATORIA</button>
            </div>
        </div>

        <div class="buttonBox">
            <button id="cartButton">AGREGAR PEDIDO AL CARRITO</button>
        </div>
    </div>
</div>

<style>
    .moduleBox {
        height: 100%;
        width: 90%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .dedicatoriaContent {
        width: 100%;
    }

    .reviewContainer {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 15px;
        margin-top: 15px;
        padding-bottom: 15px;
        border-bottom-style: solid;
        border-bottom-width: 3px;
        border-bottom-color: #d91887;
    }

    .reviewTitle {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: left;
        width: 100%;
        display: flex;
        align-items: flex-end
    }

    .imgSlider {
        overflow-x: scroll;
        overflow-y: hidden;
        width: 100%;
        height: 20vh;
        display: flex;
        flex-direction: row;
    }

    .imgSlider::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .imgSlider::-webkit-scrollbar {
        height: 6px;
        background-color: #F5F5F5;
    }

    .imgSlider::-webkit-scrollbar-thumb {
        background-color: #d91887;
    }

    .imgSlider img {
        height: 100%;
        margin-left: 10px;
        margin-right: 10px;
        cursor: pointer;
    }

    .imgSlider img:first-child {
        margin-left: 0;
    }

    .imgSlider img:last-child {
        margin-right: 0;
    }

    .iconsBox {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    .buttonBox {
        width: 180px;
        padding: 10px;
        margin-top: 30px;
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

    .reviewButtonBox {
        width: 50%;
        padding: 10px;
        margin: auto;
        cursor: pointer;
        margin-top: 30px;
    }

    .reviewButtonBox button {
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

    .reviewButtonBox button:hover {
        background-color: white;
        color: #d91887;
    }


    @media only screen and (max-width: 800px) {}
</style>


<script>
    //    let photoList = JSON.parse(localStorage.getItem("photoList"));
    let orderId = <?php echo $orderId; ?>;
    let home = "<?php echo $home; ?>";
    let urlCarrito = "<?php echo $urlCarrito; ?>";
    let finishOrderLink = "<?php echo $finishLink; ?>";
    let cartButton = document.getElementById("cartButton");
    let photoList = <?php echo $photoList; ?>;
    let editedList = <?php echo $editedList; ?>;
    let uploadedPhotos = <?php echo $uploadedPhotos; ?>;
    let editedPhotos = <?php echo $editedPhotos; ?>;
    let reviewDedicatoryButton = document.getElementById("reviewDedicatoryButton");
    let reviewEditButton = document.getElementById("reviewEditButton");
    let reviewUploadButton = document.getElementById("reviewUploadButton");

    reviewEditButton.addEventListener("click", function(e) {
        let url = `${home}/editor?orderId=${orderId}`;
        window.location.href = url;
    })

    reviewDedicatoryButton.addEventListener("click", function(e) {
        let url = `${home}/dedicatoria?orderId=${orderId}`;
        window.location.href = url;
    })

    reviewUploadButton.addEventListener("click", function(e) {
        let url = `${home}/carga?orderId=${orderId}`;
        window.location.href = url;
    })

    cartButton.addEventListener("click", function() {
        let link = `${finishOrderLink}&orderId=${orderId}`;
        let ajax = new XMLHttpRequest();
        ajax.open("GET", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    console.log(response);
                    window.location.href = urlCarrito;
                } else
                    console.log("Error loading page\n");
            }
        };
        ajax.send();

    });
    showReviewPhotos();

    function showReviewPhotos() {
        let uploadedSlider = document.getElementById("uploadedSlider");
        let editedSlider = document.getElementById("editedSlider");
        let i = 0;
        photoList.forEach(photo => {
            let photoImg = document.createElement("IMG");
            photoId = `foto${i}`
            photoImg.id = photoId;
            photoImg.src = photo;
            uploadedSlider.appendChild(photoImg);
            i++;
        });

        i = 0;
        editedList.forEach(photo => {
            let photoImg = document.createElement("IMG");
            photoId = `edited${i}`
            photoImg.id = photoId;
            let time = new Date().getTime()
            photoImg.src = `${photo}`;
            editedSlider.appendChild(photoImg);
            i++;
        });
    }
</script>