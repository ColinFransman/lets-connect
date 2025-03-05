let planningChanged = false;
let workshopsInRounds = new Set(); 

// function confirmSave() {
//     const rounds = [...document.querySelectorAll(".round")].map(round => ({
//         roundId: round.id,
//         workshops: [...round.children].map(workshop => workshop.id)
//     }));
//     console.log("Op te slaan data:", rounds);
//     fetch("/save-planning", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
//         },
//         body: JSON.stringify(rounds)
//     })
//         .then(response => response.json())
//         .then(data => console.log("Planning opgeslagen:", data))
//         .catch(error => console.error("Opslaan mislukt:", error));
//     planningChanged = false; 
//     closeSavePopup();
// }

function confirmSave() {
    const rounds = [...document.querySelectorAll(".round")].map(round => ({
        roundId: round.id,
        workshops: [...round.children].map(workshop => workshop.id)
    }));
}

function cancelSave() {
    closeSavePopup();
    document.getElementById("save-button-container").style.display = "block";
}

// function cancelSave() {
//     closeSavePopup();
// }

function showSavePopup() {
    const popup = document.getElementById("confirmation-popup");
    popup.style.display = "flex";
}

function closeSavePopup() {
 const popup = document.getElementById("confirmation-popup");
    popup.style.display = "none"; 

   
    const saveButton = document.getElementById("save-button");
    saveButton.style.display = "block"; 
}
function updateSaveButton() {
    const saveButton = document.getElementById("save-button");
    const popup = document.getElementById("confirmation-popup");
    const totalWorkshops = document.querySelectorAll(".round .workshop").length;

    let  save1 = document.getElementById('save1').value;
    let save2 = document.getElementById('save2').value;
    let save3 = document.getElementById('save3').value;

    if (save1 == "" || save2 == "" || save3 == "") {
        popup.style.display = "none"; 
        saveButton.style.display = "none"; 
    } else {
        console.log(popup)
        console.log(saveButton)
        popup.style.display = "flex";
        saveButton.style.display = "flex"; 
    }
}

