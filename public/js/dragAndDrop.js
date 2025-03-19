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
        let oldTitle = oldWorkshop.querySelector(".title");
        
        if (targetRound.firstChild.id != "workshop0" && targetRound.firstChild.id != "workshop1" && targetRound.firstChild.id != "workshop2") {
            let draggedtitle = draggedElement.querySelector(".title");
            
            // Ensure draggedtitle has the 'workshop' attribute and log its value
            let workshopValue = draggedtitle.getAttribute('workshop');
            console.log("workshop value:", workshopValue);
            
            if (!workshopValue) {
                console.error("Workshop value is missing or invalid.");
                return; // Exit early if the workshop value is missing.
            }
        
            let draggedXpath = `//input[@value="${workshopValue}"]`;
            console.log("Generated XPath:", draggedXpath);
            
            // Try using querySelector as an alternative to XPath if needed
            let draggedMatchingElement = document.querySelector(`input[value="${workshopValue}"]`);
            if (!draggedMatchingElement) {
                console.error("No matching element found for input with value:", workshopValue);
                return;
            }
        
            console.log("Found matching input element:", draggedMatchingElement);
        
            // Update the input value with the value of the 'oldWorkshop' element
            draggedMatchingElement.value = oldWorkshop.getAttribute('workshop');
            console.log("Updated value of the input:", draggedMatchingElement.value);
            
            // If oldWorkshop has an updated value
            console.log("Old workshop element:", oldWorkshop);
            console.log("Old workshop value:", oldTitle.getAttribute('workshop'));
        
            // Proceed to replace and append elements
            targetRound.replaceChild(draggedElement, oldWorkshop);
            oldRound.appendChild(oldWorkshop);
        }
        
        
        
    }
}