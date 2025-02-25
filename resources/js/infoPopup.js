let currentZIndex = 1000; 

function addCloseButton(workshop, targetRound) {
    if (workshop.querySelector(".close-button")) {
        return; 
    }

    const closeButton = document.createElement("button");
    closeButton.classList.add("close-button");
    closeButton.textContent = "X";

    closeButton.addEventListener("click", function () {
        const workshopList = document.getElementById("4");

        let index = originalWorkshopOrder.indexOf(workshop.id);

        if (index !== -1) {
            let referenceNode = workshopList.children[index] || null;
            workshopList.insertBefore(workshop, referenceNode);
        } else {
            workshopList.appendChild(workshop);
        }

        workshopsInRounds.delete(workshop.id); 
        document.getElementById("save" + targetRound.id).value = "";
        updateSaveButton();
        closeButton.remove();
    });

    workshop.appendChild(closeButton);
}

function checkRoundsFilled() {
    const rounds = document.querySelectorAll(".round");
    const isFilled = [...rounds].every(round => round.children.length > 0);

    if (isFilled && planningChanged) {
        showSavePopup();
    }
}

function info(event) {
    const buttonId = event.target.id;
    const popupId = "popup" + buttonId.match(/\d+/)[0];
    const popup = document.getElementById(popupId);


    const allPopups = document.querySelectorAll(".popup");
    allPopups.forEach(p => {
        if (p !== popup) {
            p.style.display = "none";
        }
    });

    if (popup.style.display === "flex") {
        popup.style.display = "none";
    } else {
        currentZIndex++;
        popup.style.zIndex = currentZIndex;
        popup.style.display = "flex";
    }
}

function closePopup(workshopId) {
    const popup = document.getElementById("popup" + workshopId);
    popup.style.display = "none";
}

document.addEventListener("click", function (event) {
    const isInfoButton = event.target.classList.contains("info");
    const isPopup = event.target.closest(".popup");
    if (!isInfoButton && !isPopup) {
        const allPopups = document.querySelectorAll(".popup");
        allPopups.forEach((popup) => {
            popup.style.display = "none";
        });
    }
});