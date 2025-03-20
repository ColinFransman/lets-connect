let originalWorkshopOrder = [];

// Event listener for enabling drops on a valid target
function allowDrop(ev) {
    ev.preventDefault();
}

// Event listener for dragging
function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    customDrag(ev);
}

// Event listener for dropping
function drop(ev) {
    ev.preventDefault();
    const data = ev.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const targetRound = ev.target.closest(".round");

    if (!targetRound) return;

    // if (draggedElement.id === "workshop0" && targetRound.id !== "1") {
    //     showErrorPopup("Theaterworkshop 1 kan alleen in Ronde 1 geplaatst worden.");
    //     return;
    // }

    // if (draggedElement.id === "workshop1" && targetRound.id !== "2") {
    //     showErrorPopup("Theaterworkshop 2 kan alleen in Ronde 2 geplaatst worden.");
    //     return;
    // }

    // if (draggedElement.id === "workshop2" && targetRound.id !== "3") {
    //     showErrorPopup("Theaterworkshop 3 kan alleen in Ronde 3 geplaatst worden.");
    //     return;
    // }

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


// Custom drag element style and ghost image
function customDrag(event) {
    let ghostEl;
    let dragImage;

    // Get the dragged element
    const draggedElement = event.target;

    console.log('dragging', draggedElement);

    // Clone only the title element
    const title = draggedElement.querySelector('.title'); // Get the title element

    if (!title) return; // If no title is found, return early

    // Clone only the title element (you could clone the entire content if you wish)
    ghostEl = title.cloneNode(true);  // Clone the title element only
    ghostEl.classList.remove('hiddenText');  // Remove the 'hiddenText' class to make the title visible
    ghostEl.classList.add('showText');  // Add the 'showText' class

    // Ensure the title element in the ghost is visible
    ghostEl.classList.add("ghost");

    // Style the cloned title as needed, like size, width, height, etc.
    ghostEl.style.width = draggedElement.offsetWidth + 'px';
    ghostEl.style.height = draggedElement.offsetHeight + 'px';
    ghostEl.style.position = "absolute";  // Position it absolutely to follow the mouse cursor

    // Clone another version for the actual drag image
    dragImage = ghostEl.cloneNode(true);
    dragImage.style.opacity = 1;  // Ensure drag image is fully visible
    document.body.appendChild(ghostEl);  // Append ghost element for the drag image
    document.body.appendChild(dragImage);  // Append drag image element

    // Set the drag image to be the cloned ghost element
    event.dataTransfer.setDragImage(dragImage, dragImage.offsetWidth / 2, dragImage.offsetHeight / 2);

    // When drag ends
    draggedElement.addEventListener("dragend", () => {
        // Make sure the ghost element is still in the DOM before removing
        if (ghostEl && document.body.contains(ghostEl)) {
            console.log('removing ghost:', ghostEl);
            document.body.removeChild(ghostEl);  // Remove the ghost element after the drag operation is finished
        }

        // Clean up drag image
        if (dragImage && document.body.contains(dragImage)) {
            console.log('removing drag image:', dragImage);
            document.body.removeChild(dragImage);  // Remove the drag image element after the drag ends
        }
    });

    // Update the position of the drag image during the drag
    document.addEventListener("drag", (event) => {
        dragImage.style.left = event.pageX + "px";
        dragImage.style.top = event.pageY + "px";
    });
}

// Initialize custom drag behavior for all draggable elements
document.querySelectorAll(".draggable").forEach((element) => {
    element.setAttribute("draggable", true);
    element.addEventListener("dragstart", customDrag);
});

