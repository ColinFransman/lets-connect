function togglePointerEvents(state) {
    const mainContent = document.querySelector(".main");
    mainContent.style.pointerEvents = state === "disable" ? "none" : "auto";
}

function highlightElement(selector) {
    const element = document.querySelector(selector);
    if (element) element.classList.add("highlight");
}

function unhighlightElement(selector) {
    const element = document.querySelector(selector);
    if (element) element.classList.remove("highlight");
}

// Toon de foutmelding popup
function showErrorPopup(message) {
    const popup = document.getElementById("error-popup");
    const errorMessage = document.getElementById("error-message");
    const errorTitle = document.getElementById("error-title");

    errorMessage.textContent = message;
    errorTitle.textContent = "Foutmelding"; // Je kunt hier de titel aanpassen indien nodig

    popup.style.display = "flex"; // Toon de popup
}

// Sluit de foutmelding popup
function closeErrorPopup() {
    const popup = document.getElementById("error-popup");
    popup.style.display = "none"; // Verberg de popup
}

function checkWorkshopsInRounds() {
    if (workshopsInRounds.size === 3) {
        showSavePopup();
    }
}