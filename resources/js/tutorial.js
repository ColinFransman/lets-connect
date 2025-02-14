let currentStep = 0;
const tutorialSteps = [
    { text: "Dit is Ronde 1. Sleep een workshop hierheen om het toe te wijzen aan deze ronde.", highlight: ".round:nth-child(1)" },
    { text: "Hier is een workshop. Klik en sleep het naar een ronde.", highlight: ".workshop:nth-child(1)" },
    { text: "Goed gedaan! Laat de workshop vallen in een ronde om je planning te voltooien.", highlight: ".round:nth-child(1)" }
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

function showStep(stepIndex) {
    const overlay = document.getElementById("tutorial-overlay");
    const textElement = document.getElementById("tutorial-text");
    const step = tutorialSteps[stepIndex];
    textElement.textContent = step.text;
    // Vorige markeringen verwijderen
    document.querySelectorAll(".tutorial-highlight").forEach(el => {
        el.classList.remove("tutorial-highlight");
    });
    // Markeer het huidige element
    const highlightElement = document.querySelector(step.highlight);
    if (highlightElement) {
        highlightElement.classList.add("tutorial-highlight");
    }
    // Toon overlay
    overlay.style.display = "flex";
}

function nextStep() {
    // Verberg de tutorial-overlay en het tekstvak tijdelijk bij volgende stap
    hideTutorialOverlay();
    if (currentStep < tutorialSteps.length - 1) {
        currentStep++;
        showStep(currentStep);
    } else {
        endTutorial();
    }
}

// function endTutorial() {
//     document.getElementById("tutorial-overlay").style.display = "none";
//     togglePointerEvents("enable");
//     localStorage.setItem("tutorialCompleted", "true");
// }

function endTutorial() {
    const overlay = document.getElementById("tutorial-overlay");
    overlay.style.display = "none";
    document.querySelectorAll(".tutorial-highlight").forEach(el => {
        el.classList.remove("tutorial-highlight");
    });
}
function hideTutorialOverlay() {
    const overlay = document.getElementById("tutorial-overlay");
    overlay.style.display = "none"; // Verberg tutorial-overlay volledig
}
function showTutorialOverlay() {
    const overlay = document.getElementById("tutorial-overlay");
    overlay.style.display = "flex"; // Toon tutorial-overlay opnieuw
}
document.addEventListener("DOMContentLoaded", () => {
    showStep(currentStep);
});