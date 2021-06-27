function removeCard(id) {
    document.getElementById("card-cat-" + id).style.display = 'none';
}

// create tags
function popUp(title, buttonOk, buttonCancel, hasTextArea) {
    let textarea;
    let shadow = document.createElement("div");
    let popUp = document.createElement("div");
    let entitled = document.createElement("h4");
    if (hasTextArea) {
        textarea = document.createElement("textarea");
    }
    let buttonContainer = document.createElement("div");
    let btnPrimary = document.createElement("button");
    let btnSecondary = document.createElement("button");


    // add shadow of pop up in body of page
    shadow = document.body.appendChild(shadow);
    // add CSS classes and click event listener

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
    btnPrimary.addEventListener("click", function () {
        buttonOk.fuct();
        // delete pop-up
        shadow.parentElement.removeChild(shadow);
    })
    btnSecondary.className = "btn btn-secondary ml-3"; btnSecondary.innerHTML = buttonCancel.text;

    btnSecondary.addEventListener("click", function () {
        buttonCancel.fuct();
        // delete pop-up
        shadow.parentElement.removeChild(shadow);
    })

    // add all element in page

    buttonContainer.appendChild(btnPrimary);
    buttonContainer.appendChild(btnSecondary);

    popUp.appendChild(entitled);

    if (hasTextArea) {
        popUp.appendChild(textarea);
    }
    popUp.appendChild(buttonContainer);
    shadow.appendChild(popUp);
}

function refuseBtn(id) {

    popUp("Veuillez saisir le motif du refus :", {
        text: "Refuser",
        className: "btn btn-danger",
        fuct: function () {
            const comment = document.getElementById("comment-area").value;
            if (comment != "") {
                const headers = new Headers();
                headers.append('Content-Type', 'application/json');
                // send request to the server
                fetch(`/review/cat/${id}`, {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        validated: false,
                        comment: comment
                    })
                }).then(removeCard(id))
            }
        }
    }, {
        text: "Annuler",
        fuct: function () {
            console.log("le button annuler est cliqué")
        }
    },
        true);
}


function acceptedBtn(id) {

    popUp("Êtes-vous sûr de vouloir approuver ce chat ?", {
        text: "Approuver",
        className: "btn btn-success",
        fuct: function () {
            const headers = new Headers();
            headers.append('Content-Type', 'application/json');
            // send request to the server
            fetch(`/review/cat/${id}`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    validated: true
                })
            }).then(removeCard(id))

        }
    }, {
        text: "Annuler",
        fuct: function () {
            console.log("le button annuler est cliqué")
        }
    }),
        true
}
