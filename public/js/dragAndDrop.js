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
    } else {
        oldWorkshop = (targetRound.firstChild); //workshopelement waarmee je wil swappen, draggedElement is het te swappen workshopelement
        oldRound = draggedElement.parentNode; //ronde-element waar de workshop terecht komt waarmee je wil swappen, targetRound is het element waar de te swappen workshop terecht komt
        if (targetRound.firstChild.id != "workshop0" && targetRound.firstChild.id != "workshop1" && targetRound.firstChild.id != "workshop2") { //disable swap-acties met theaterworkshops 
            let draggedTitle = draggedElement.querySelector(".title"); //get title element van de te swappen workshop
            let oldTitle = oldWorkshop.querySelector(".title"); //get title element van de workshop waarmee je wil swappen
            let draggedXpath = `//input[@value="` + oldTitle.getAttribute('workshop') + `"]`;
            let draggedMatchingElement = document.evaluate(draggedXpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue; //get hidden input van bovenstaand element
            let oldXpath = `//input[@value="` + draggedTitle.getAttribute('workshop') + `"]`;
            let oldMatchingElement = document.evaluate(oldXpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
            draggedMatchingElement.value = draggedTitle.getAttribute('workshop'); //set oude input van de te swappen workshop naar value van de workshop waarmee je wil swappen
            if (oldMatchingElement) {
                oldMatchingElement.value = oldTitle.getAttribute('workshop'); 
            }
            targetRound.replaceChild(draggedElement, oldWorkshop);
            oldRound.appendChild(oldWorkshop);
        }
    }
    updateSaveButton();
}