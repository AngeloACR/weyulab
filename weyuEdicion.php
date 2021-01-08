<?php
/* Template Name:weyuEdicio n */
/*
http://jsfiddle.net/ykns7ct3/
https://developer.mozilla.org/en-US/docs/Web/SVG/Tutorial/Clipping_and_masking
https://css-tricks.com/gooey-effect/
https://css-tricks.com/almanac/properties/f/filter/
https://stackoverflow.com/questions/3403421/how-to-apply-overlay-transparency-to-rgba-image
https://www.w3schools.com/jsref/prop_style_filter.asp
*/
//https://blog.bitsrc.io/image-manipulation-libraries-for-javascript-187fde1ad5af
if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
    $order = get_post($orderId);
    $orderProduct = get_post_meta($orderId, 'product', true);
    $orderUploadedPhotos = get_post_meta($orderId, 'photos_uploaded', true);
    $orderStatus = get_post_meta($orderId, 'status', true);
    $photoList = get_post_meta($orderId, 'photoList', true);
    $editedPhotos = get_post_meta($orderId, 'editedPhotos', true);
    $uploadedPhotos = get_post_meta($orderId, 'photos_uploaded', true);
    $proportion = get_post_meta($orderId, 'proportion', true);
}

$home = get_home_url();
$urlDedicatoria = $home . '/dedicatoria' . '?orderId=' . $orderId;

$editPhotoLink = $home . "/wp-admin/admin-ajax.php?action=editPhoto";
$finishEditionLink = $home . "/wp-admin/admin-ajax.php?action=finishEdition";

$nonce = wp_create_nonce("photoList");

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<div class="bigBox">
    <div class="stepBox">
        <a href="/carga?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-01.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/editor?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-02-1.png" alt="">
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
            <p>EDITAR FOTOS</p>
        </div>

        <div class="instructionsBox">
            <p>-Edita tus fotos, seleccionando la sección que quieres que imprimamos para ti dentro del recuadro blanco.</p>
            <p>-Puedes girar, acercar o alejar la foto como tu quieras.</p>
            <p>-Asegurate de editar todas las fotos que cargaste, porque las fotos que no edites no serán impresas.</p>
            <p>-Una vez editadas todas las fotos, procede a escribir la dedicatoria de tu pedido.</p>
        </div>
        <div class="counterBox">
            <p>Fotos editadas: <span id="numberOfPhotosEdited"></span></p>
            <p>Fotos restantes por editar: <span id="remainingPhotosToEdit"></span></p>
        </div>

        <div class="blackBox">
            <div class="sliderBox">

                <p>Fotos sin editar</p>
                <div id="photoSlider" class="imgSlider">
                </div>
            </div>
            <div class="contentBox">
                <div class="iconsBox">

                    <img id="cropPhoto" src="https://weyulab.com/wp-content/uploads/2020/09/ICON-01-EDICION.png" alt="">
                    <img id="rotatePhoto" src="https://weyulab.com/wp-content/uploads/2020/09/ICON-05-EDICION.png" alt="">
                    <img id="filterPhoto" src="https://weyulab.com/wp-content/uploads/2020/09/ICON-04-EDICION.png" alt="">
                    <div id="filterOptions" class="filterBox">
                        <div id="brillo" class="rangeInput">
                            <img style="width: 30px; margin: 0; margin-bottom: 10px;" src="https://weyulab.com/wp-content/uploads/2020/09/ICON-03-EDICION.png" alt="">
                            <input id="brilloInput" type="range" min="-100" max="100" value="0">
                        </div>
                        <div id="contraste" class="rangeInput">
                            <p style="margin: 0; margin-bottom: 10px;"> Contraste </p><input id="contrasteInput" type="range" min="-100" max="100" value="0">
                        </div>

                    </div>
                    <img id="colorPhoto" src="https://weyulab.com/wp-content/uploads/2020/09/ICON-02-EDICION.png" alt="">
                    <div id="pickerBox" style="z-index: 100;">
                    </div>

                </div>
                <div id="mainPhoto" class="mainImg">
                    <div id="cropBox">

                    </div>
                    <div id="filterBox">

                    </div>
                </div>
                <div class="buttonsBox">

                    <div class="buttonBox">
                        <button id="resetPhoto">RESETEAR FOTO</button>
                    </div>
                    <div class="buttonBox">
                        <button id="savePhoto">GUARDAR FOTO</button>
                    </div>
                    <div class="buttonBox">
                        <button id="finishEdition">IR A LA DEDICATORIA</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .rangeInput {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #cropBox {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    #filterBox {
        height: 0;
        width: 0;
    }

    #filterBox canvas {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .filterBox {
        height: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .cr-slider {
        background-color: #d91887;
        border-radius: 80px;
    }

    .moduleBox {
        height: 100%;
        width: 90%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .blackBox {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: space-evenly;
        background-color: black;
    }

    .contentBox {
        width: 100%;
        height: 90%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: center;
    }

    .mainImg {
        width: 60%;
        height: 80vh;
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        overflow: scroll;
    }

    .croppie-result {
        position: relative;
    }

    #photoOverlay,
    #photoOverlay2 {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
    }

    #photoContainer {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .mainImg::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        background-color: #F5F5F5;
    }

    .mainImg::-webkit-scrollbar {
        height: 6px;
        width: 6px;
        background-color: #F5F5F5;
    }

    .mainImg::-webkit-scrollbar-thumb {
        background-color: #d91887;
    }

    .mainImg img {
        height: 100%;
    }

    .sliderBox {

        display: flex;
        flex-direction: row;
        padding: 10px;
        flex-wrap: wrap;
        margin-bottom: 10px;
        width: 100%;
    }

    .imgSlider {
        display: flex;
        flex-direction: row;
        overflow-x: scroll;
        overflow-y: hidden;
        width: 100%;
        height: 20vh;
    }

    .sliderBox p {
        font-size: 20px;
        width: 100%;
        color: #a3065c;
        font-weight: bold;
        margin: 0;
        margin-bottom: 10px;
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
        height: 80%;
        margin-left: 10px;
        margin-right: 10px;
        cursor: pointer;
    }

    .iconsBox {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        width: 150px;
        z-index: 100;
    }

    .iconsBox img {
        margin-top: 10px;
        width: 40px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .buttonsBox {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
        width: 180px;

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

    .zoomText {
        font-size: 16px;
        font-weight: bolder;
        color: white;
    }

    .canvasOverlay {
        position: absolute;
    }

    @media only screen and (max-width: 800px) {}
</style>

<script src="https://unpkg.com/vanilla-picker@2"></script>
<script>
    //    let photoList = JSON.parse(localStorage.getItem("photoList"));
    let photoList = <?php echo $photoList; ?>;
    let orderId = <?php echo $orderId; ?>;
    let porportion = <?php echo $proportion; ?>;
    let uploadedPhotos = <?php echo $uploadedPhotos; ?>;
    let editedPhotosInit = <?php echo $editedPhotos; ?>;
    let editPhotoLink = "<?php echo $editPhotoLink; ?>";
    let finishEditionLink = "<?php echo $finishEditionLink; ?>";
    let urlDedicatoria = "<?php echo $urlDedicatoria; ?>";
    let photoSelected = 0;
    let mainPhoto = document.getElementById("mainPhoto");
    let finishEdition = document.getElementById("finishEdition");

    let cropPhoto = document.getElementById("cropPhoto");
    let rotatePhoto = document.getElementById("rotatePhoto");
    let savePhoto = document.getElementById("savePhoto");
    let resetPhoto = document.getElementById("resetPhoto");
    let filterPhoto = document.getElementById("filterPhoto");

    let photoToEdit = photoList[0];
    let croppie;
    let rotationCounter = 0;
    showSliderPhotos(photoList);
    changeEditedCounter(uploadedPhotos, editedPhotosInit)


    let colorPhoto = document.getElementById("colorPhoto");
    let pickerBox = document.getElementById("pickerBox");
    var picker = new Picker({
        parent: pickerBox,
        popup: false,
        color: 'black',
    });
    let pickerOpened = false;
    picker.closeHandler();
    colorPhoto.addEventListener("click", function() {
        if (!pickerOpened) {

            picker.openHandler();
        } else {
            picker.closeHandler();
        }
        pickerOpened = !pickerOpened
    })

    function appendOverlay() {
        let overlay = document.createElement("div");
        overlay.id = "photoOverlay";
        let cropOverlay = document.querySelector(".cr-viewport")
        cropOverlay.appendChild(overlay);
    }
    let selectedColor = [0, 0, 0, 0];
    // You can do what you want with the chosen color using two callbacks: onChange and onDone.
    picker.onChange = function(color) {
        /*         let overlay = document.getElementById("photoOverlay")
                overlay.style.backgroundColor = color.rgbaString; */
        let aux = color.rgbaString;
        aux = aux.replace('rgba(', '');
        aux = aux.replace(')', '');
        selectedColor = aux.split(',').map(function(data) {
            return parseFloat(data)
        });

        let oldContext = originalCanvas.getContext('2d');
        var oldData = oldContext.getImageData(0, 0, originalCanvas.width, originalCanvas.height);
        applyColor(oldData.data, selectedColor);

        let newContext = newCanvas.getContext('2d');
        newContext.putImageData(oldData, 0, 0);
    };



    function changeEditedCounter(uploaded, edited) {

        let editedBox = document.getElementById("numberOfPhotosEdited");
        let rem = document.getElementById("remainingPhotosToEdit");
        let aux = uploaded - edited;
        rem.innerText = aux;
        editedBox.innerText = edited;
    }

    function resetRotation() {
        rotationCounter = 0;
        initCroppie();
    }

    finishEdition.addEventListener("click", function(e) {
        let link = `${finishEditionLink}&orderId=${orderId}`;
        let ajax = new XMLHttpRequest();
        ajax.open("GET", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    console.log(response);
                    window.location.href = urlDedicatoria;
                } else
                    console.log("Error loading page\n");
            }
        };
        ajax.send();
    })

    function initCroppie() {
        removeCropChilds();
        filterOptions = false;
        let cropBox = document.getElementById("cropBox");
        let photoContainer = document.createElement("DIV");
        photoContainer.id = "photoContainer"
        cropBox.appendChild(photoContainer);
        let height = 150;
        let width = height * porportion;
        let maxZoom = 3;
        croppie = new Croppie(photoContainer, {

            viewport: {
                width: width,
                height: height
            },
            showZoomer: true,
            enableOrientation: true,
            enforceBoundary: false,
            maxZoom: maxZoom
        });
        croppie.setZoom(0.5);
        croppie.bind({
            url: photoToEdit,
        });
        let zoomBar = document.getElementsByClassName("cr-slider-wrap")[0];
        let zoomText = document.createElement("P");
        zoomText.innerText = "Zoom";
        zoomText.className = "zoomText";
        zoomBar.appendChild(zoomText);
        showCrop();
        /* 
                appendOverlay(); */

    }
    let originalCanvas;
    let newCanvas;

    async function getCroppedResult(size) {
        let canvas = await croppie.result({
            type: 'rawcanvas',
            size: size,
            format: 'jpeg',
            quality: '1'
        })
        return canvas;
        /* .then(function(canvas) {
                    originalCanvas = canvas;
                }); */
    }

    cropPhoto.addEventListener("click", function() {
        showCrop();
        /*         initCroppie();
                croppie.bind({
                    url: photoToEdit,
                });
                let zoomBar = document.getElementsByClassName("cr-slider-wrap")[0];
                let zoomText = document.createElement("P");
                zoomText.innerText = "Zoom";
                zoomText.className = "zoomText";
                zoomBar.appendChild(zoomText); */


    });

    initCroppie();

    rotatePhoto.addEventListener("click", function() {
        rotationCounter++;
        croppie.rotate(90);

    });

    function showCrop() {
        let cropBox = document.getElementById("cropBox");
        let filterBox = document.getElementById("filterBox");
        cropBox.style.height = "100%";
        cropBox.style.width = "100%";
        removeFilterChilds();
        filterBox.style.height = "0";
        filterBox.style.width = "0";
        hideFilterOptions();
    }

    function showFilter() {
        let cropBox = document.getElementById("cropBox");
        let filterBox = document.getElementById("filterBox");
        filterBox.style.height = "100%";
        filterBox.style.width = "100%";
        cropBox.style.height = "0";
        cropBox.style.width = "0";
    }

    let filterOpen = false;



    let brilloValue = 0;
    let contrasteValue = 0;
    let brillo = document.getElementById("brilloInput")
    brillo.addEventListener("change", function() {
        brilloValue = brillo.value

        var brightness = parseInt(brilloValue, 10);
        let oldContext = originalCanvas.getContext('2d');
        var oldData = oldContext.getImageData(0, 0, originalCanvas.width, originalCanvas.height);
        applyBrightness(oldData.data, brightness);

        let newContext = newCanvas.getContext('2d');
        newContext.putImageData(oldData, 0, 0);
        //photoCanvas.style.filter = getPhotoFilters();
    })

    let contraste = document.getElementById("contrasteInput")
    contraste.addEventListener("change", function() {
        contrasteValue = contraste.value

        let oldContext = originalCanvas.getContext('2d');
        var oldData = oldContext.getImageData(0, 0, originalCanvas.width, originalCanvas.height);

        var contrast = parseInt(contrasteValue, 10);
        applyContrast(oldData.data, contrast);
        let newContext = newCanvas.getContext('2d');
        newContext.putImageData(oldData, 0, 0);

        //photoCanvas.style.filter = getPhotoFilters();
    })

    filterPhoto.addEventListener("click", async function() {

        let filterOptions = document.getElementById("filterOptions");
        let filterBox = document.getElementById("filterBox");
        console.log(filterOpen)
        if (!filterOpen) {
            originalCanvas = await getCroppedResult("viewport");
            canvasResult = await getCroppedResult("original");
            originalCanvas.id = "originalCanvas";
            newCanvas = cloneCanvas(originalCanvas);
            newCanvas.id = "newCanvas";
            removeFilterChilds();
            resetFilters();
            filterBox.appendChild(newCanvas);
            filterOptions.style.height = "auto";
            showFilter();
        } else {
            filterOptions.style.height = "0";
            showCrop();

        }
        filterOpen = !filterOpen;
    })

    function hideFilterOptions() {
        let filterOptions = document.getElementById("filterOptions");
        filterOptions.style.height = "0";

    }

    function cloneCanvas(oldCanvas) {

        //create a new canvas
        var newCanvas = document.createElement('canvas');
        var context = newCanvas.getContext('2d');

        //set dimensions
        newCanvas.width = oldCanvas.width;
        newCanvas.height = oldCanvas.height;

        //apply the old canvas to the new one
        context.drawImage(oldCanvas, 0, 0);

        //return the new canvas
        return newCanvas;
    }

    resetPhoto.addEventListener("click", function() {
        resetRotation();
        resetFilters();
        showCrop();
    })

    let canvasResult;

    savePhoto.addEventListener("click", async function() {


        /* croppie.result({
            type: 'rawcanvas',
            size: 'original',
            format: 'jpeg',
            quality: '1'
        }).then(function(canvas) {
         */ // do something with cropped blob
        /*             let overlay = document.createElement("div");
                    overlay.id = "photoOverlay2";
                    overlay.style.backgroundColor = selectedColor; */
        //html.appendChild(overlay);

        /*                 let blob = new Blob(item, {
                            type: 'text/html'
                        }); // the blob */

        /*             canvas.className = "canvasOverlay";


        });
             */
        if (!filterOptions) {
            canvasResult = await getCroppedResult('original');
        }
        let oldContext = canvasResult.getContext('2d');
        var data = oldContext.getImageData(0, 0, canvasResult.width, canvasResult.height);

        brilloValue = brillo.value
        contrasteValue = contraste.value

        var brightness = parseInt(brilloValue, 10);
        var contrast = parseInt(contrasteValue, 10);

        applyBrightness(data.data, brightness);
        applyContrast(data.data, contrast);
        applyColor(data.data, selectedColor);

        let newCanvas = cloneCanvas(canvasResult);
        let newContext = newCanvas.getContext('2d');
        newContext.putImageData(data, 0, 0);

        newCanvas.toBlob(function(blob) {
            sendCroppedImage(blob);
        }, 'image/png');


    })


    function sendCroppedImage(blob) {
        console.log(photoSelected)
        let link = `${editPhotoLink}&orderId=${orderId}&photoSelected=${photoSelected}&contentType=false&processData=false`;
        console.log(blob)
        let fd = new FormData();
        fd.append('data', blob);
        let ajax = new XMLHttpRequest();
        ajax.open("POST", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    changeEditedCounter(uploadedPhotos, response.editedPhotos)
                    console.log(response);
                } else
                    console.log("Error loading page\n");
            }
        };
        ajax.send(fd);
    }

    function showSliderPhotos(photoList) {
        let photoSlider = document.getElementById("photoSlider");
        let i = 0;
        photoList.forEach(photo => {
            let photoImg = document.createElement("IMG");
            photoId = `foto${i}`
            photoImg.id = photoId;
            photoImg.src = photo;
            photoImg.addEventListener("click", editPhoto)
            photoSlider.appendChild(photoImg);
            i++;
        });
    }

    function removeFilterChilds() {
        let filterBox = document.getElementById("filterBox")
        while (filterBox.firstChild) {
            filterBox.removeChild(filterBox.lastChild);
        }
    }

    function removeCropChilds() {
        let cropBox = document.getElementById("cropBox")
        while (cropBox.firstChild) {
            cropBox.removeChild(cropBox.lastChild);
        }
    }

    function editPhoto(e) {
        photoToEdit = e.target.src;
        let id = e.target.id;
        photoSelected = id.replace('foto', '');
        console.log(photoSelected);
        resetFilters();
        //cropPhoto.click();
        initCroppie();
    }

    function resetFilters() {
        let brilloAux = document.getElementById("brilloInput")
        brilloAux.value = 0;
        let contrasteAux = document.getElementById("contrasteInput")
        contrasteAux.value = 0;
        /*         let opacidadAux = document.getElementById("opacidadInput")
                opacidadAux.value = 100;
                let saturacionAux = document.getElementById("saturacionInput")
                saturacionAux.value = 100;
                let sepiaAux = document.getElementById("sepiaInput")
                sepiaAux.value = 0;
         */
    }
    /* 
    let opacidadValue = 100
    let saturacionValue = 100
    let sepiaValue = 0
 */


    /* 

        let opacidad = document.getElementById("opacidad")
        opacidad.addEventListener("change", function() {
            let photoCanvas = document.querySelector("#photoContainer div canvas");
            opacidadValue = document.getElementById("opacidadInput").value
            photoCanvas.style.filter = getPhotoFilters();
        })

        let saturacion = document.getElementById("saturacion")
        saturacion.addEventListener("change", function() {
            let photoCanvas = document.querySelector("#photoContainer div canvas");
            saturacionValue = document.getElementById("saturacionInput").value
            photoCanvas.style.filter = getPhotoFilters();
        })

        let sepia = document.getElementById("sepia")
        sepia.addEventListener("change", function() {
            let photoCanvas = document.querySelector("#photoContainer div canvas");
            sepiaValue = document.getElementById("sepiaInput").value
            photoCanvas.style.filter = getPhotoFilters();
        }) */

    function applyBrightness(data, brightness) {
        for (var i = 0; i < data.length; i += 4) {
            data[i] += 255 * (brightness / 100);
            data[i + 1] += 255 * (brightness / 100);
            data[i + 2] += 255 * (brightness / 100);
        }
    }

    function applyColor(data, color) {
        for (var i = 0; i < data.length; i += 4) {
            data[i] = truncateColor((data[i] * data[i + 3] + color[0] * (255 - data[i + 3])) / 255);
            data[i + 1] = truncateColor((data[i + 1] * data[i + 3] + color[1] * (255 - data[i + 3])) / 255);
            data[i + 2] = truncateColor((data[i + 2] * data[i + 3] + color[2] * (255 - data[i + 3])) / 255);
            data[i + 3] = Math.min(data[i + 3] + color[3], 1);
        }
    }

    function truncateColor(value) {
        if (value < 0) {
            value = 0;
        } else if (value > 255) {
            value = 255;
        }

        return value;
    }

    function applyContrast(data, contrast) {
        var factor = (259.0 * (contrast + 255.0)) / (255.0 * (259.0 - contrast));

        for (var i = 0; i < data.length; i += 4) {
            data[i] = truncateColor(factor * (data[i] - 128.0) + 128.0);
            data[i + 1] = truncateColor(factor * (data[i + 1] - 128.0) + 128.0);
            data[i + 2] = truncateColor(factor * (data[i + 2] - 128.0) + 128.0);
        }
    }
</script>