let originalWorkshopOrder = [];

// Event listener for enabling drops on a valid target
function allowDrop(ev) {
    ev.preventDefault();
}

// Event listener for dragging
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    customDrag(ev)
}

// Event listener for dropping
function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const targetRound = ev.target.closest(".round");

    if (!targetRound) return;

    // If no children are present, append the dragged element
    if (!targetRound.hasChildNodes()) {
        targetRound.appendChild(draggedElement);
        let title = draggedElement.querySelector(".title");
        let xpath = `//input[@value="` + title.getAttribute('workshop') + `"]`;
        let matchingElement = document.evaluate(xpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
        if (matchingElement !== null) {
            matchingElement.value = "";
        }
        document.getElementById("save" + targetRound.id).value = title.getAttribute('workshop');
        planningChanged = true;
        addCloseButton(draggedElement, targetRound);
        workshopsInRounds.add(draggedElement.id);
        checkWorkshopsInRounds();
    } else {
        // Handle swapping if there's an existing workshop in the target round
        oldWorkshop = targetRound.firstChild; 
        oldRound = draggedElement.parentNode; 
        
        if (targetRound.firstChild.id !== "workshop0" && targetRound.firstChild.id !== "workshop1" && targetRound.firstChild.id !== "workshop2") {
            let draggedTitle = draggedElement.querySelector(".title"); 
            let oldTitle = oldWorkshop.querySelector(".title"); 
            let draggedXpath = `//input[@value="` + oldTitle.getAttribute('workshop') + `"]`;
            let draggedMatchingElement = document.evaluate(draggedXpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
            let oldXpath = `//input[@value="` + draggedTitle.getAttribute('workshop') + `"]`;
            let oldMatchingElement = document.evaluate(oldXpath, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
            draggedMatchingElement.value = draggedTitle.getAttribute('workshop');
            oldMatchingElement.value = oldTitle.getAttribute('workshop'); 
            targetRound.replaceChild(draggedElement, oldWorkshop);
            oldRound.appendChild(oldWorkshop);
        }
    }
    updateSaveButton();    
}

function customDrag(event) {
    let ghostEl;

    const draggedElement = event.target;
    
    const title = draggedElement.querySelector('.title');

    ghostEl = event.target.cloneNode(true);

    ghostEl.classList.add("ghost");    

    ghostEl.style.width = draggedElement.offsetWidth + 'px';
    ghostEl.style.height = draggedElement.offsetHeight + 'px';
    ghostEl.style.position = "absolute";  

    var i = ghostEl.querySelector('.locationWorkshop')
    i.style.textAlign = "center";

    document.body.appendChild(ghostEl);

    event.dataTransfer.setDragImage(ghostEl, ghostEl.offsetWidth / 2, ghostEl.offsetHeight / 2);

    // When drag ends
    draggedElement.addEventListener("dragend", () => {
        if (ghostEl && document.body.contains(ghostEl)) {
            document.body.removeChild(ghostEl);
        }
    });
}