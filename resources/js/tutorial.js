let currentStep = 0;
let tutorialSteps = [
    { title: "Welcome to Mijn Planning", text: "This is a drag-and-drop interface where you can plan your workshops.", highlight: ".round.highlight" },
    { title: "Workshop Sections", text: "Drag workshops into the rounds to assign them.", highlight: ".workshops" },
    { title: "Save Button", text: "Click this button to save your planning.", highlight: ".button.save" }
];

document.addEventListener("DOMContentLoaded", () => {
    const workshops = document.querySelectorAll(".workshop");
    originalWorkshopOrder = Array.from(workshops).map(w => w.id);
});

document.addEventListener("DOMContentLoaded", () => {
    const visited = localStorage.getItem("tutorialCompleted");
    if (!visited) {
        startTutorial();
    }
});

function startTutorial() {
    currentStep= 0;
    
    const overlay = document.getElementById("tutorial-overlay");
    overlay.style.display = "flex";
    togglePointerEvents("disable");
    highlightElement(tutorialSteps[currentStep].highlight);
}

function navigateTutorial(direction) {
    unhighlightElement(tutorialSteps[currentStep].highlight);
    currentStep += direction;

    if (currentStep < tutorialSteps.length) {
        document.getElementById("tutorial-title").textContent = tutorialSteps[currentStep].title;
        document.getElementById("tutorial-text").textContent = tutorialSteps[currentStep].text;

        highlightElement(tutorialSteps[currentStep].highlight);

    
        document.getElementById("previous-btn").disabled = currentStep === 0;
        document.getElementById("next-btn").style.display = currentStep < tutorialSteps.length - 1 ? "inline-block" : "none";
        document.getElementById("finish-btn").style.display = currentStep === tutorialSteps.length - 1 ? "inline-block" : "none";
    } else {
        endTutorial();
    }
}

function endTutorial() {
    document.getElementById("tutorial-overlay").style.display = "none";
    togglePointerEvents("enable");
    localStorage.setItem("tutorialCompleted", "true");
}
