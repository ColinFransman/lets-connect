let planningChanged = false;
let workshopsInRounds = new Set(); 

function confirmSave() {
    const rounds = [...document.querySelectorAll(".round")].map(round => ({
        roundId: round.id,
        workshops: [...round.children].map(workshop => workshop.id)
    }));

    console.log("Op te slaan data:", rounds);

    fetch("/save-planning", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        },
        body: JSON.stringify(rounds)
    })
        .then(response => response.json())
        .then(data => console.log("Planning opgeslagen:", data))
        .catch(error => console.error("Opslaan mislukt:", error));

    planningChanged = false; 
    closeSavePopup();
}

function cancelSave() {
    closeSavePopup();
    document.getElementById("save-button-container").style.display = "block";
}

function cancelSave() {
    closeSavePopup();
}
function showSavePopup() {
    const popup = document.getElementById("confirmation-popup");
    popup.style.display = "flex";
}

function closeSavePopup() {
    const popup = document.getElementById("confirmation-popup");
    popup.style.display = "none"; 
}
