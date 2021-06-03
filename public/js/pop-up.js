/* <div class="pop-up-shadow">
    <div class="pop-up p-3">
        <h4 class="pop-up-title">
            Veuillez saisir le motif du refus :
                </h4>
        <textarea name="" id="" cols="65" rows="5" class="form-control" placeholder="Motif"></textarea>
        <div class="btn-container mt-3">
            <button class="btn btn-danger">
                Refuser
                    </button>
            <button class="btn btn-secondary ml-3">
                Annuler
                    </button>
        </div>
    </div> 
</div>*/

/**
 * buttonOk {text, fuct}
 */

/*
Création de toutes les balises
*/
function popUp(title, buttonOk, buttonCancel) {
    let shadow = document.createElement("div");
    let popUp = document.createElement("div");
    let entitled = document.createElement("h4");
    let textarea = document.createElement("textarea");
    let buttonContainer = document.createElement("div");
    let btnDanger = document.createElement("button");
    let btnSecondary = document.createElement("button");


    /*
     Ajout de shadow dans le body.
     */
    shadow = document.body.appendChild(shadow);
    /*
    Ajout les class et text de ces balises. Ajouter les écouteurs d'évenement sur les click des boutons.
    */

    shadow.className = "pop-up-shadow";
    popUp.className = "pop-up p-3";
    entitled.className = "pop-up-title";
    entitled.innerHTML = title;
    textarea.id = "comment-area";
    textarea.className = "form-control";
    buttonContainer.className = "btn-container mt-3";
    btnDanger.className = "btn btn-danger";
    btnDanger.innerHTML = buttonOk.text;
    btnDanger.addEventListener("click", function () {
        buttonOk.fuct();
        // suppression de la pop-up
        shadow.parentElement.removeChild(shadow);
    })
    btnSecondary.className = "btn btn-secondary ml-3"; btnSecondary.innerHTML = buttonCancel.text;

    btnSecondary.addEventListener("click", function () {
        buttonCancel.fuct();
        // suppression de la pop-up
        shadow.parentElement.removeChild(shadow);
    })

    /*
    Construction de l'arborescence des balises. 
    */

    buttonContainer.appendChild(btnDanger);
    buttonContainer.appendChild(btnSecondary);

    popUp.appendChild(entitled);
    popUp.appendChild(textarea);
    popUp.appendChild(buttonContainer);
    shadow.appendChild(popUp);


}

function refuseBtn(id) {

    popUp("Veuillez saisir le motif du refus :", {
        text: "Refuser",
        fuct: function () {
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');
            // envoi la requète au serveur
            fetch(`/review/cat/${id}`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    validated: false,
                    comment: document.getElementById("comment-area").value
                })
            })
        }
    }, {
        text: "Annuler",
        fuct: function () {
            console.log("le button annuler est cliqué")
        }
    })
}
