let currentStepIndex = 0;
// for buttons styling.
let prevButton = document.getElementById('prevButton');
let nextButton = document.getElementById('nextButton');
let tutButtons = document.querySelector('.tutorial-buttons');

// overlay
let tutOverlay = document.querySelector('.tutorial-overlay');

// first round
let roundOne = document.querySelector('#round1 .round:nth-child(2)');

const tutorialSteps = [
    { text: "Welkom op het dashboard! Laten we leren hoe je deze pagina gebruikt.", highlight: ".round:nth-child(1)" },
    { text: "Klik op het 'i' tje om meer info te krijgen over een workshop zelf.", highlight: ".round:nth-child(1)" },
    { text: "Dit is Ronde 1. Sleep een workshop hierheen om het toe te wijzen aan deze ronde.", highlight: ".round:nth-child(1)" },
    { text: "Hier is een workshop. Klik en sleep het naar een ronde.", highlight: ".workshop:nth-child(1)" },
    { text: "Je kunt ook de workshop weer verwijderen met de 'x'.", highlight: ".round:nth-child(1)" },
    { text: "Goed gedaan! Laat de workshop vallen in een ronde om je planning te voltooien.", highlight: ".round:nth-child(1)" }
];
let tutorialLength = tutorialSteps.length - 1;

document.addEventListener("DOMContentLoaded", () => {
    startTutorial();
});

function startTutorial() {
    const overlay = document.getElementById("tutorial-overlay"); // if ID exists, the popup becomes visible
    overlay.style.display = "flex";
    document.getElementById('tutorial-text').textContent = tutorialSteps[currentStepIndex].text;
    
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
        firstStep();
        // nextButton.disabled = true; // disabling button.
    } else if (currentStepIndex === 2) {
        secondStep();
    } else if (currentStepIndex === 3) {
        thirdStep();
    } else if (currentStepIndex === 4) {
        fourthStep();
    } else {
        defaultStyling();
        // nextButton.disabled = false; // enabling button on other steps.
    }
}

function prevStep() {
    let currentStepIndex = showNextOverlay();
    document.getElementById('tutorial-text').textContent = tutorialSteps[currentStepIndex].text;

    // styling buttons
    if (currentStepIndex === 0) { // styling on the first tutorial step.
        prevButton.style.display = "none";
        tutButtons.style.justifyContent = "center";
    } else { // styling other steps.
        prevButton.style.display = "flex";
        tutButtons.style.justifyContent = "space-between";
    }

    // on tutorial round 1.
    if (currentStepIndex === 1) {
        firstStep();
        // nextButton.disabled = true;
    } else if (currentStepIndex === 2) {
        secondStep();
    } else if (currentStepIndex === 3) {
        thirdStep();
    } else if (currentStepIndex === 4) {
        fourthStep();
    } else {
        defaultStyling();
        // nextButton.disabled = false;
    }
}

// returning steo indexes
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

function sendWorkshop() {
    // first workshop
    let workshopOne = document.getElementById('workshop0')
    return workshopOne;
}

function sendInfoIcon() {
    // first icon
    let iconOne = document.getElementById('info0');
    return iconOne;
}

function sendRoundX() {
    let roundOneX;
    if (currentStepIndex === 3) {
        roundOneX = document.querySelector('#round1 .round .workshop .close-button')
    }
    console.log(roundOneX)
    return roundOneX;
}

function defaultStyling() {
    // rounds style
    tutOverlay.style.alignItems = "center";
    roundOne.style.zIndex = "unset";

    // imported div.
    let workshopOne = sendWorkshop();
    // workshop style.
    workshopOne.style.zIndex = "unset";

    let iconOne = sendInfoIcon();
    iconOne.style.zIndex = "unset";

    let roundOneX = sendRoundX();
    roundOneX.style.color = "white";

    if (roundOne.classList.contains("tutorial-highlight")) {
        roundOne.classList.remove("tutorial-highlight");
    }
    if (workshopOne.classList.contains("tutorial-highlight")) {
        workshopOne.classList.remove("tutorial-highlight");
    }
}

function firstStep() {
    defaultStyling() // resets previous styling.

    let iconOne = sendInfoIcon();

    iconOne.style.zIndex = "1001";
}

// each step with styling.
function secondStep() {
    defaultStyling() // resets previous styling.

    // rounds style
    tutOverlay.style.alignItems = "end";
    roundOne.style.zIndex = "1001";
    
    roundOne.classList.add("tutorial-highlight")
}

function thirdStep() {
    defaultStyling() // resets previous styling.

    // imported div.
    let workshopOne = sendWorkshop();

    // rounds style.
    tutOverlay.style.alignItems = "end";
    roundOne.style.zIndex = "1001";

    // workshop style.
    workshopOne.style.zIndex = "1001";
    workshopOne.classList.add("tutorial-highlight")
}

function fourthStep() {
    defaultStyling() // resets previous styling.

    let roundOneX = sendRoundX();

    roundOneX.style.color = "red";
}