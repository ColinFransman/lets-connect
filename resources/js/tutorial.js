let currentStepIndex = 0;
// for buttons styling.
let prevButton = document.getElementById('prevButton');
let tutButtons = document.querySelector('.tutorial-buttons');

// overlay
let tutOverlay = document.querySelector('.tutorial-overlay');

// first round
let roundOne = document.querySelector('#round1 .round')

const tutorialSteps = [
    { text: "Welkom op het dashboard! Laten we leren hoe je deze pagina gebruikt.", highlight: ".round:nth-child(1)" },
    { text: "Dit is Ronde 1. Sleep een workshop hierheen om het toe te wijzen aan deze ronde.", highlight: ".round:nth-child(1)" },
    { text: "Hier is een workshop. Klik en sleep het naar een ronde.", highlight: ".workshop:nth-child(1)" },
    { text: "Goed gedaan! Laat de workshop vallen in een ronde om je planning te voltooien.", highlight: ".round:nth-child(1)" }
];
let tutorialLength = tutorialSteps.length - 1;

document.addEventListener("DOMContentLoaded", () => {
    startTutorial();
});

function startTutorial() {
    const overlay = document.getElementById("tutorial-overlay"); // if ID exists, the popup becomes visible
    overlay.style.display = "flex";
    document.getElementById('tutorial-text').textContent = tutorialSteps[currentStepIndex].text
    console.log(currentStepIndex)
    
    // styling buttons onload.
    if (currentStepIndex === 0) {
        prevButton.style.display = "none";
        tutButtons.style.justifyContent = "center";
    }
}

function nextStep() {
    // gets the index out of a function and displays the right json on the index number.
    let currentStepIndex = hidePreviousOverlay();
    document.getElementById('tutorial-text').textContent = tutorialSteps[currentStepIndex].text;

    // styling buttons
    if (currentStepIndex) { // if index is not zero. (true - false if value < 0), 
        prevButton.style.display = "flex";
        tutButtons.style.justifyContent = "space-between";
    }

    // on tutorial round 1.
    if (currentStepIndex === 1) {
        secondStep()
    } else {
        defaultStyling()
    }
}

function prevStep() {
    let currentStepIndex = showNextOverlay();
    document.getElementById('tutorial-text').textContent = tutorialSteps[currentStepIndex].text;

    // styling buttons
    if (currentStepIndex === 0) { // styling on the first tutorial step and the other steps. 
        prevButton.style.display = "none";
        tutButtons.style.justifyContent = "center";
    } else {
        prevButton.style.display = "flex";
        tutButtons.style.justifyContent = "space-between";
    }

    // on tutorial round 1.
    if (currentStepIndex === 1) {
        secondStep()
    } else {
        defaultStyling()
    }
}

function hidePreviousOverlay() {
    // if index is lower than array length and is '0', the number increases.
    if(currentStepIndex < tutorialLength || currentStepIndex === 0) {
        currentStepIndex++
    }
    // returning the index to other functions.
    return currentStepIndex;
}

function showNextOverlay() {
    // if the index is lower than array length and is higher than '0', the number decreases.
    if(currentStepIndex < tutorialLength && currentStepIndex > 0 || currentStepIndex === tutorialLength) {
        currentStepIndex--
    }
    return currentStepIndex;
}

async function sendWorkshop() {
    // first workshop
    let workshopOne = document.getElementById('workshop0')
    console.log(workshopOne)

    return workshopOne;
}

function defaultStyling() {
    workshopOne = sendWorkshop();
    // rounds
    tutOverlay.style.alignItems = "center";
    roundOne.style.zIndex = "1  ";

    workshopOne.style.zIndex = "1";
}

function secondStep() {
    workshopOne = sendWorkshop();
    // rounds
    tutOverlay.style.alignItems = "end";
    roundOne.style.zIndex = "1001";

    workshopOne.style.zIndex = "1001";

}