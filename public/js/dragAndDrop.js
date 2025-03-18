let originalWorkshopOrder = [];

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const targetRound = ev.target.closest(".round");

    if (!targetRound) return;

    if (draggedElement.id === "workshop0" && targetRound.id !== "1") {
        showErrorPopup("Theaterworkshop 1 kan alleen in Ronde 1 geplaatst worden.");
        return;
    }

    if (draggedElement.id === "workshop1" && targetRound.id !== "2") {
        showErrorPopup("Theaterworkshop 2 kan alleen in Ronde 2 geplaatst worden.");
        return;
    }

    if (draggedElement.id === "workshop2" && targetRound.id !== "3") {
        showErrorPopup("Theaterworkshop 3 kan alleen in Ronde 3 geplaatst worden.");
        return;
    }

    if (!targetRound.hasChildNodes()) {
        targetRound.appendChild(draggedElement);
        let title = draggedElement.querySelector(".title");
        let xpath = `//input[@value="` + title.getAttribute('workshop') + `"]`;
        let matchingElement = document.evaluate(xpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
        if(matchingElement !== null) {
            matchingElement.value = "";
        }
        document.getElementById("save" + targetRound.id).value = title.getAttribute('workshop');
        planningChanged = true;
        addCloseButton(draggedElement, targetRound);
        workshopsInRounds.add(draggedElement.id);
        checkWorkshopsInRounds();
    }
    updateSaveButton();
}