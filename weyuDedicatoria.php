<?php
/* Template Name:weyuDedicatoria */

if (isset($_REQUEST["orderId"])) {
    // insert the post and set the category
    $orderId = $_REQUEST["orderId"];
    $order = get_post($orderId);
    $dedicatory = get_post_meta($orderId, 'dedicatory', true);
}

$home = get_home_url();
$urlReview = $home . '/revision' . '?orderId=' . $orderId;

$dedicatoryLink = $home . "/wp-admin/admin-ajax.php?action=saveDedicatory";

$nonce = wp_create_nonce("photoList");

?>
<div class="bigBox">
    <div class="stepBox">
        <a href="/carga?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-01.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/editor?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-02.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/dedicatoria?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-03-1.png" alt="">
        </a>
        <div class="stepBar"></div>
        <a href="/revision?orderId=<?php echo $orderId; ?>">
            <img src="https://weyulab.com/wp-content/uploads/2020/09/BOTON-04.png" alt="">
        </a>
    </div>
    <div class="moduleBox">
        <div class="titleBox">
            <p>DEDICATORIA</p>
        </div>
        <div class="instructionsBox">
            <p>-Escribe la dedicatoria que se entregará en conjunto con tu pedido.</p>
            <p>-La dedicatoria debe contener hasta un máximo de 200 caracteres.</p>
            <p>-Una vez escrita la dedicatoria, procede a revisar tu pedido.</p>
        </div>
        <div class="counterBox">
            <p>Caracteres restantes: <span id="remainingCharacters"></span></p>
        </div>
        <div class="blackBox">
            <div class="contentBox">
                <div class="inputBox">
                    <textarea id="dedicatory" name="" id="" cols="10" rows="5" maxlength="200"></textarea>
                </div>

            </div>

            <div class="buttonBox">
                <button id="reviewButton">REVISAR PEDIDO</button>
            </div>
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

    .blackBox {
        width: 100%;
        height: 60vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: black;
    }

    .contentBox {
        width: 95%;
        height: 70%;
        display: flex;
        margin-top: 30px;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    .inputBox {
        width: 60%;
        height: 60%;
    }

    .inputBox textarea {
        width: 100%;
        height: 100%;
        resize: none;
    }

    .iconsBox {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-around;
    }

    .iconsBox img {
        margin-top: 10px;
        width: 40px;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .buttonBox {
        width: 180px;
        height: 30px;
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



    @media only screen and (max-width: 800px) {}
</style>


<script>
    var reviewButton = document.getElementById("reviewButton");
    let dedicatoryLink = "<?php echo $dedicatoryLink; ?>";
    let urlReview = "<?php echo $urlReview; ?>";
    let orderId = "<?php echo $orderId; ?>";
    let initDedicatory = "<?php echo $dedicatory; ?>";

    let dedicatoryBox = document.getElementById("dedicatory");
    dedicatoryBox.value = initDedicatory
    let auxCounter = dedicatoryBox.value.length
    changeRemainingCharacters(auxCounter);

    dedicatoryBox.addEventListener("keyup", function() {
        let auxCounter = dedicatoryBox.value.length
        changeRemainingCharacters(auxCounter);
    })

    function changeRemainingCharacters(length) {
        let rem = document.getElementById("remainingCharacters");
        let aux = 200 - length
        rem.innerText = aux;
    }

    reviewButton.addEventListener("click", function() {
        let dedicatoryBox = document.getElementById("dedicatory");
        let dedicatory = dedicatoryBox.value
        let link = `${dedicatoryLink}&orderId=${orderId}&dedicatory=${dedicatory}`;
        let ajax = new XMLHttpRequest();
        ajax.open("GET", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    console.log(response);
                    window.location.href = urlReview;
                } else
                    console.log("Error\n");
            }
        };
        ajax.send();

    })
</script>