function removeCard(id) {
    document.getElementById("card-cat-" + id).style.display = 'none';
}
// function de création des pop up
// title - le titre de la pop up
// buttonOk - l'objet de définition du bouton principal
// buttonCancel - l'objet de définition du bouton secondaire
// hasTextArea - demander l'affichage d'une zone de saisie 
function popUp(title, buttonOk, buttonCancel, hasTextArea) {
    // on créer les différents élements HTML
    // la textarea pour le commentaire
    let textarea;
    // l'ombre pour bloquer l'accès à la page quand la pop up sera affiché
    let shadow = document.createElement("div");
    // la div qui sera le corps de la po-up
    let popUp = document.createElement("div");
    // le titre de la pop-up
    let entitled = document.createElement("h4");
    if (hasTextArea) {
        textarea = document.createElement("textarea");
    }
    // la zone basse de la pop-up qui va contenir les boutons
    let buttonContainer = document.createElement("div");
    // le bouton d'action principal
    let btnPrimary = document.createElement("button");
    // le bouton d'action secondaire
    let btnSecondary = document.createElement("button");

    // On ajoute l'ombre dans le body
    shadow = document.body.appendChild(shadow);
    
    // on ajoute les classes des différents élements
    shadow.className = "pop-up-shadow";
    popUp.className = "pop-up p-3";
    entitled.className = "pop-up-title";
    entitled.innerHTML = title;

    if (hasTextArea) {
        textarea.id = "comment-area";
        textarea.className = "form-control";
    }
    buttonContainer.className = "btn-container mt-3";
    btnPrimary.className = buttonOk.className;
    btnPrimary.innerHTML = buttonOk.text;
    // on déclare l'action à effectuer sur le clic du bouton principal de la pop up
    btnPrimary.addEventListener("click", function () {
        // si la popUp contient une text area elle doit avoir une valeur non vide
        if (
            !hasTextArea ||
            (hasTextArea && document.getElementById("comment-area").value != "")
        ) {
            buttonOk.fuct();
            // suppression de la pop up
            shadow.parentElement.removeChild(shadow);
        }
    });
    // on ajoute la classe sur le bouton secondaire
    btnSecondary.className = "btn btn-secondary ml-3";
    btnSecondary.innerHTML = buttonCancel.text;

    // on déclare l'action à effectuer sur le clic du bouton secondaire de la pop up
    btnSecondary.addEventListener("click", function () {
        buttonCancel.fuct();
        // suppression de la pop up
        shadow.parentElement.removeChild(shadow);
    });

    // on ajoute tous les éléments dans la page HTML
    buttonContainer.appendChild(btnPrimary);
    buttonContainer.appendChild(btnSecondary);

    popUp.appendChild(entitled);

    if (hasTextArea) {
        popUp.appendChild(textarea);
    }
    popUp.appendChild(buttonContainer);
    shadow.appendChild(popUp);
}

// fonction de création de la pop-up de refus d'un chat
// id - l’id du chat à refuser
function refuseBtn(id) {
    popUp(
        // le titre de la pop up
        "Veuillez saisir le motif du refus :",
        {
            // le bouton refuser est rouge
            text: "Refuser",
            className: "btn btn-danger",
            fuct: function () {
                // on récupère la valeur de la text area du commentaire de l'inspection
                const comment = document.getElementById("comment-area").value;
                // on créer un en-tête de requête
                const headers = new Headers();
                headers.append("Content-Type", "application/json");
                // envoi de la requête POST au server sur la page http://les-aristoscratch/review/cat/${id}
                fetch(`/review/cat/${id}`, {
                    method: "POST",
                    headers: headers,
                    // on envoi le refus au serveur
                    body: JSON.stringify({
                        validated: false,
                        comment: comment,
                    }),
                }).then(removeCard(id));
            },
        },
        {
            text: "Annuler",
            fuct: function () {
                // aucune action n'est définit sur le bouton annuler
            },
        },
        true
    );
}

// fonction de création de la pop-up d'approbation d'un chat
// id - l’id du chat à approuver
function acceptedBtn(id) {
    popUp(
        // le titre de la pop up
        "Êtes-vous sûr de vouloir approuver ce chat ?",
        {
            // le bouton approuver est vert
            text: "Approuver",
            className: "btn btn-success",
            fuct: function () {
                // on créer un en-tête de requête
                const headers = new Headers();
                headers.append("Content-Type", "application/json");
                // envoi de la requête POST au server sur la page http://les-aristoscratch/review/cat/${id}
                fetch(`/review/cat/${id}`, {
                    method: "POST",
                    headers: headers,
                    body: JSON.stringify({
                        // dans le cas d'une approbation il n'y a pas de commentaire
                        validated: true,
                    }),
                }).then(removeCard(id));
            },
        },
        {
            text: "Annuler",
            fuct: function () {
                // aucune action n'est définit sur le bouton annuler
            },
        }
    )
}
