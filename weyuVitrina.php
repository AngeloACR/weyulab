<?php
/* Template Name:weyuVitrina */

?>
<?php
$sku = "";
$nonce = wp_create_nonce("myProductChoice");
$home = get_home_url();
$src = $home . "/wp-admin/admin-ajax.php?action=myProductChoice";

?>
<div class="mainContainer">
    <div class="innerHeader">
        Una forma diferente de guardar y compartir fotos
    </div>

    <div class="innerContainer">
        <div id="boxIntroBox" class="cardBox">
            <div class="cardHeader">
                <p>
                    FOTOBOX
            </div>
            </p>
            <div class="cardContent">

                <img src="https://weyulab.com/wp-content/uploads/2020/09/HOME-FOTOBOX.png" alt="">
            </div>
            <div class="cardBottom">
                <a id="vintageFBox" class="cardButton">VINTAGE 7x10</a>
                <a id="clasicoFBox" class="cardButton">CLÁSICO 15x10</a>
            </div>
        </div>
        <div id="boxProductsBox" class="cardBox">
            <div class="cardHeader">
                <p>
                    FOTOBOX
            </div>
            <div class="cardProducts">

                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBox1" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">10 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBox2" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">20 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBox3" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">30 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBox4" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">40 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBox5" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">50 fotos / $5</span>
                    </label>
                </div>
            </div>
            <div class="cardBottom">
                <a id="comprarBox" class="cardButton">COMPRAR</a>
            </div>
        </div>
    </div>

    <div class="innerContainer">
        <div id="bagIntroBox" class="cardBox">
            <div class="cardHeader">
                <p>
                    FOTOBAG
                </p>
            </div>
            <div class="cardContent">
                <img src="https://weyulab.com/wp-content/uploads/2020/09/HOME-FOTOBAG.png" alt="">
            </div>
            <div class="cardBottom">
                <a id="vintageFBag" class="cardButton">VINTAGE 7x10</a>
                <a id="clasicoFBag" class="cardButton">CLÁSICO 15x10</a>
            </div>
        </div>
        <div id="bagProductsBox" class="cardBox">
            <div class="cardHeader">
                <p>
                    FOTOBAG
                </p>
            </div>
            <div class="cardProducts">
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBag1" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">10 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBag2" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">20 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBag3" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">30 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBag4" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">40 fotos / $5</span>
                    </label>
                </div>
                <div class="cardProduct">

                    <label class="radio">
                        <span class="radioInput">
                            <input type="radio" id="fBag5" name="quantity">
                            <span class="radioControl"></span>
                        </span>
                        <span class="radioLabel">50 fotos / $5</span>
                    </label>
                </div>
            </div>
            <div class="cardBottom">
                <a id="comprarBag" class="cardButton">COMPRAR</a>
            </div>
        </div>
    </div>

</div>

<style>
    .mainContainer {
        margin: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .innerHeader {
        width: 100%;
        text-align: center;
        font-size: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
        color: #101011;
        font-weight: bold;
    }

    .innerContainer {
        width: 45%;
        height: 100%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .cardBox {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: hidden;
    }

    #boxIntroBox {
        height: 100%;
    }

    #bagIntroBox {
        height: 100%;
    }

    #boxProductsBox {
        height: 0;
    }

    #bagProductsBox {
        height: 0;
    }

    .cardHeader {
        width: 100%;
        background-color: #d91887;
        height: 50px;
        display: flex;
        align-items: center;
    }

    .cardHeader p {
        color: white;
        width: 100%;
        font-size: 24px;
        text-align: center;
    }

    .cardContent {
        height: 250px;
        background-color: white;
        padding-top: 20px;
        padding-bottom: 20px;
        display: flex;
        justify-content: center;
    }

    .cardContent img {
        height: 100%;
    }

    .cardBottom {
        height: 50px;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

    .cardProduct:nth-child(even) {
        background-color: #afa7af;
    }

    .cardProduct:nth-child(odd) {
        background-color: #dcd6dd;
    }

    .cardProduct {
        height: 50px;
        max-height: 250px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0 30px;
    }

    .radio {
        display: grid;
        grid-template-columns: min-content auto;
        grid-gap: 0.5em;
        align-items: center;
    }

    .radioInput input {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        opacity: 0;
        width: 0;
        height: 0;

    }

    .radioInput input:checked+.radioControl {
        background-color: #d91887;
    }

    .radioLabel {
        font-size: 16px;
        font-weight: bold;
        color: #101011;
    }

    .radioControl {
        display: block;
        width: 1.5em;
        height: 1.5em;
        margin-right: 10px;
        border-radius: 50%;
        border: 0.2em solid #d91887;
        cursor: pointer;
    }

    .cardButton {
        width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        border-radius: 23px;
        background-color: #d91887;
        color: white;
        border-style: solid;
        border-width: 2px;
        border-color: #d91887;
        font-weight: bold;
        font-size: 12px;
    }

    .cardButton:hover {
        color: #d91887;
        background-color: white;
    }

    @media only screen and (max-width: 800px) {}
</style>

<script>
    var vintageFBox = document.getElementById("vintageFBox");
    var clasicoFBox = document.getElementById("clasicoFBox");

    var vintageFBag = document.getElementById("vintageFBag");
    var clasicoFBag = document.getElementById("clasicoFBag");

    var boxIntroBox = document.getElementById("boxIntroBox");
    var boxProductsBox = document.getElementById("boxProductsBox");

    var bagIntroBox = document.getElementById("bagIntroBox");
    var bagProductsBox = document.getElementById("bagProductsBox");

    var fBox1 = document.getElementById('fBox1')
    var fBox2 = document.getElementById('fBox2')
    var fBox3 = document.getElementById('fBox3')
    var fBox4 = document.getElementById('fBox4')
    var fBox5 = document.getElementById('fBox5')

    var fBox = [{
        radio: fBox1,
        value: "10"
    }, {
        radio: fBox2,
        value: "20"
    }, {
        radio: fBox3,
        value: "30"
    }, {
        radio: fBox4,
        value: "40"
    }, {
        radio: fBox5,
        value: "50"
    }]

    var fBag1 = document.getElementById('fBag1')
    var fBag2 = document.getElementById('fBag2')
    var fBag3 = document.getElementById('fBag3')
    var fBag4 = document.getElementById('fBag4')
    var fBag5 = document.getElementById('fBag5')

    var fBag = [{
        radio: fBag1,
        value: "10"
    }, {
        radio: fBag2,
        value: "20"
    }, {
        radio: fBag3,
        value: "30"
    }, {
        radio: fBag4,
        value: "40"
    }, {
        radio: fBag5,
        value: "50"
    }]

    var comprarBag = document.getElementById("comprarBag");
    var comprarBox = document.getElementById("comprarBox");

    var nonce = "&nonce=<?php echo $nonce; ?>"

    let address = "<?php echo $src; ?>"

    let product = "";
    let type = "";
    let qty = "";

    function getQuantity(photoType) {
        let photoQuantity;
        switch (photoType) {
            case "box":
                fBox.forEach(element => {
                    if (element.radio.checked) {
                        photoQuantity = element.value
                    }
                });
                break;

            default:
                fBag.forEach(element => {
                    if (element.radio.checked) {
                        photoQuantity = element.value
                    }
                });
                break;
        }
        return photoQuantity;
    }

    function dismissBox() {
        boxIntroBox.style.height = "100%";
        boxProductsBox.style.height = "0";
    }

    function dismissBag() {
        bagIntroBox.style.height = "100%";
        bagProductsBox.style.height = "0";
    }


    vintageFBox.addEventListener("click", function() {
        dismissBag();
        product = "FBOX";
        type = "V"
        console.log(product)
        boxIntroBox.style.height = "0";
        boxProductsBox.style.height = "100%";

    });

    vintageFBag.addEventListener("click", function() {
        dismissBox();
        product = "FBAG";
        type = "V"
        console.log(product)
        bagIntroBox.style.height = "0";
        bagProductsBox.style.height = "100%";
    })

    clasicoFBox.addEventListener("click", function() {
        dismissBag();
        product = "FBOX";
        type = "C"
        console.log(product)
        boxIntroBox.style.height = "0";
        boxProductsBox.style.height = "100%";
    })
    clasicoFBag.addEventListener("click", function() {
        dismissBox();
        product = "FBAG";
        type = "C"
        console.log(product)
        bagIntroBox.style.height = "0";
        bagProductsBox.style.height = "100%";
    })

    function getLink() {
        let sku = `${product}-${type}-${qty}`
        let link = `${address}&sku=${sku}${nonce}&type=${type}&totalPhotos=${qty}`;
        localStorage.setItem("sku", sku);
        localStorage.setItem("product", product);
        localStorage.setItem("type", type);
        localStorage.setItem("qty", qty);
        localStorage.setItem("uploadedPhotos", 0);
        console.log(sku);
        console.log(link);
        return link
    }

    comprarBox.addEventListener("click", function() {
        qty = getQuantity("box");
        let link = getLink();
        window.open(link, "_top");
    })

    comprarBag.addEventListener("click", function() {
        qty = getQuantity("bag");
        let link = getLink();
        window.open(link, "_top");
    })
</script>