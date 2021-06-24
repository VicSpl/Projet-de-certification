
// create tags
function popUp(title, buttonOk, buttonCancel) {
    let shadow = document.createElement("div");
    let popUp = document.createElement("div");
    let entitled = document.createElement("h4");
    let textarea = document.createElement("textarea");
    let buttonContainer = document.createElement("div");
    let btnDanger = document.createElement("button");
    let btnSecondary = document.createElement("button");


    // add shadow of pop up in body of page
    shadow = document.body.appendChild(shadow);
    // add CSS classes and click event listener

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
            // send request to the server
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
