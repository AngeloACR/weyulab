<?php
/* Template Name:weyuConfirmPayment */


$home = get_home_url();

?>
<div class="bigConfirmBox">

    <div class="instructionsBox">
        <p class="instructionTitle">Instrucciones: </p>
        <p>-Escribe la referencia de orden asociada a tu pedido.</p>
        <p>-Carga la confimación (o confirmaciones) de pago de tu pedido, en formato pdf, jpg o png.</p>
        <p>-Envía las confirmaciones de pago, y apenas las revisemos, procesaremos y despacharemos tu pedido.</p>
    </div>
    <div class="confirmUploadBox">
        <div class="orderInputBox">
            <label for="clientOrder">Referencia: </label>
            <input type="text" name="clientOrder" id="clientOrder" />
        </div>

        <form class="fileUpload" enctype="multipart/form-data">
            <div class="form-group">
                <label>
                    <img id="confirmIcon" src="https://weyulab.com/wp-content/uploads/2020/09/ICONO-SUBIR.png" alt="">
                    <input type="file" name="clientFile" id="confirmFiles" accept="application/pdf,image/*" multiple />
                    <p>Subir archivos de confirmación</p>
                </label>
            </div>
        </form>
    </div>
</div>

<style>
    .bigConfirmBox {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    .instructionsBox {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .instructionsBox .instructionTitle {
        width: 100%;
        color: #a3065c;
        font-weight: bold;
        font-size: 20px;
    }

    .instructionsBox p {
        width: 100%;
        color: #a3065c;
        font-size: 16px;
        font-weight: bold;
    }

    #confirmFiles {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .orderInputBox {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        margin: auto;
        margin-bottom: 30px;
    }

    .orderInputBox label {
        margin-right: 10px;
        color: #a3065c;
        font-size: 16px;
        font-weight: bold;
    }

    .orderInputBox input {
        width: 100%;
    }

    .confirmUploadBox {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 60%;
        margin: auto;
        margin-top: 30px;
    }

    .confirmUploadBox form div label {
        display: flex;
        flex-direction: column;
        align-items: center;
        cursor: pointer;
        width: 60%;
        border-style: solid;
        border-width: 2px;
        border-color: #a3065c;
        margin: auto;
    }

    .confirmUploadBox form div label img {
        width: 100%;
    }

    .confirmUploadBox form div label p {
        font-size: 16px;
        font-weight: bold;
        color: #a3065c;
        text-align: center;
    }


    @media only screen and (max-width: 800px) {
        .instructionsBox .instructionTitle {
            font-size: 16px;
        }

        .instructionsBox p {
            font-size: 12px;
        }

        .orderInputBox label {
            font-size: 12px;
        }

        .confirmUploadBox {
            width: 90%;
        }

        .confirmUploadBox form div label {
            width: 80%;
        }


        .confirmUploadBox form div label p {
            font-size: 12px;
        }
    }
</style>


<script>
    var confirmUpload = document.getElementById("confirmFiles");
    var clientOrder = document.getElementById("clientOrder");

    let confirmUploadLink = "<?php echo $src . "/wp-admin/admin-ajax.php?action=confirmPayment"; ?>";

    confirmUpload.addEventListener("change", function() {
        var fileList = confirmUpload.files; // The <input type="file" /> field
        let i = 0;
        // Loop through each data and create an array file[] containing our files data.
        // our AJAX identifier
        let link = getConfirmUploadLink();
        console.log(fileList);
        let fd = new FormData();
        for (let i = 0; i < fileList.length; i++) {
            let name = "clientFile" + i;
            fd.append(name, fileList[i]);
        }
        let ajax = new XMLHttpRequest();
        ajax.open("POST", link, true);
        ajax.onreadystatechange = function(aEvt) {
            console.log(ajax)
            if (ajax.readyState == 4) {
                if (ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    console.log(response);
                } else
                    console.log("Error loading page\n");
            }
        };
        ajax.send(fd);

    })

    function getConfirmUploadLink() {
        let orderReference = clientOrder.value;
        let link = `${confirmUploadLink}&orderReference=${orderReference}&contentType=false&processData=false`;
        return link
    }
</script>