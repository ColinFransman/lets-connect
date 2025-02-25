let currentStep = 0;
const tutorialSteps = [
    { text: "Welkom op het dashboard! Laten we leren hoe je deze pagina gebruikt.", highlight: ".round:nth-child(1)" },
    { text: "Dit is Ronde 1. Sleep een workshop hierheen om het toe te wijzen aan deze ronde.", highlight: ".round:nth-child(1)" },
    { text: "Hier is een workshop. Klik en sleep het naar een ronde.", highlight: ".workshop:nth-child(1)" },
    { text: "Goed gedaan! Laat de workshop vallen in een ronde om je planning te voltooien.", highlight: ".round:nth-child(1)" }
];

document.addEventListener("DOMContentLoaded", () => {
    // const workshops = document.querySelectorAll(".workshop");
    startTutorial();
});

function startTutorial() {
    const overlay = document.getElementById("tutorial-overlay");
    overlay.style.display = "flex";
    console.log(overlay)
    console.log(currentStep)

}

function nextStep() {
    currentStep = hidePreviousOverlay();
    console.log(currentStep)
}

function prevStep() {
    currentStep = showNextOverlay();
    console.log(currentStep)
}

function hidePreviousOverlay() {
    currentStep;
    if(currentStep < 0) {
        currentStep++
    }
    return currentStep;
}

function showNextOverlay() {
    currentStep;
    if(currentStep < 0) {
        currentStep--
    }
    return currentStep;
}