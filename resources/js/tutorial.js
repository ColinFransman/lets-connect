let currentStepIndex = 0;

// for buttons styling.
let prevButton = document.getElementById('prevButton');
let nextButton = document.getElementById('nextButton');
let tutButtons = document.querySelector('.tutorial-buttons');

// overlay
let tutOverlay = document.querySelector('.tutorial-overlay');

let tutStep = document.getElementById('tutorial-step')

// first round
let roundOne = document.querySelector('#round1 .round:nth-child(2)');

const tutorialSteps = [
    { text: "Welkom op het dashboard! Laten we leren hoe je deze pagina gebruikt.", highlight: ".round:nth-child(1)" },
    { text: "Klik op het 'i' tje om meer info te krijgen over een workshop zelf.", highlight: ".round:nth-child(1)" },
    { text: "Dit is Ronde 1. Sleep een workshop hierheen om het toe te wijzen aan deze ronde.", highlight: ".round:nth-child(1)" },
    { text: "Hier is een workshop. Klik en sleep het naar een ronde.", highlight: ".workshop:nth-child(1)" },
    { text: "Je kunt ook de workshop weer verwijderen met de 'x'.", highlight: ".round:nth-child(1)" },
    { text: "Goed gedaan! Laat de workshop vallen in een ronde om je planning te voltooien.", highlight: ".round:nth-child(1)" },
    { text: "", highlight: ".round:nth-child(1)" }
];
let tutorialLength = tutorialSteps.length - 1;

document.addEventListener("DOMContentLoaded", () => {
    var cookieSatus = cookieState();
    
    if(!cookieSatus) {
        startTutorial();
        document.cookie = "render=loaded"
    }
});

// observers for the extra steps like 'i', drag step or 'x' since defining these have issues globally.
const observerI = new MutationObserver((mutationsList, observer) => {
    let iconOne = sendInfoIcon();
    if (iconOne) {
        // clicked on 'i' does things.
        iconOne.addEventListener('click', function () {
            nextButton.disabled = false;
            nextStep();
        });
        observer.disconnect(); // Stop observing once we find it
    }
});
observerI.observe(document.body, { childList: true, subtree: true });

// dragged workshop.
const observerDrag = new MutationObserver((mutationsList, observer) => {
    let roundOneX = sendRoundX();
    let workshopOne = sendWorkshop();
    if(roundOneX) {
        // roundOneX.addEventListener('click', function () {
        if(roundOne.contains(workshopOne)) {
            nextButton.disabled = false;
            nextStep();
        }
        // })
        observer.disconnect();
    }
});
observerDrag.observe(document.body, { childList: true, subtree: true });

// remove workshop.
const observerX = new MutationObserver((mutationsList, observer) => {
    let roundOneX = sendRoundX();
    if (roundOneX) {
        // clicked on 'i' does things.
        roundOneX.addEventListener('click', function () {
            nextButton.disabled = false;
            nextStep();
        });
        observer.disconnect(); // Stop observing once we find it
    }
});
observerX.observe(document.body, { childList: true, subtree: true });

function startTutorial() {
    // if ID exists, the popup becomes visible
    tutOverlay.style.display = "flex";
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
    switch (currentStepIndex) {
        case 1:
            firstStep();
            break;
        case 2:
            secondStep();
            break;
        case 3:
            thirdStep();
            break;
        case 4:
            fourthStep();
            break;
        case 5:
            fifthStep();
            break;
        default:
            defaultStyling();
            break;
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
    switch (currentStepIndex) {
        case 1:
            firstStep();
            break;
        case 2:
            secondStep();
            break;
        case 3:
            thirdStep()
            break;
        case 4:
            fourthStep()
            break;
        case 5:
            fifthStep()
            break;
        default:
            defaultStyling();
            break;
    }
}

// returning steo indexes
function hidePreviousOverlay() {
    // if index is lower than array length and is '0', the number increases.
    if (currentStepIndex < tutorialLength || currentStepIndex === 0) {
        currentStepIndex++;
    }
    // returning the index to other functions.
    return currentStepIndex;
}

function showNextOverlay() {
    // if the index is lower than array length and is higher than '0', the number decreases.
    if (currentStepIndex < tutorialLength && currentStepIndex > 0 || currentStepIndex === tutorialLength) {
        currentStepIndex--;
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
    // let roundX = document.querySelector('#round1 .round .workshop .close-button')

    let workshopOne = sendWorkshop();

    let roundOneX;
    if (currentStepIndex && roundOne.contains(workshopOne)) {
        roundOneX = document.querySelector('#round1 .round .workshop .close-button');
    }
    return roundOneX;
}

function defaultStyling() {

    nextButton.disabled = false;

    // rounds style
    roundOne.style.zIndex = "unset";

    // imported div.
    let workshopOne = sendWorkshop();
    // workshop style.
    workshopOne.style.zIndex = "unset";

    let iconOne = sendInfoIcon();
    iconOne.style.zIndex = "unset";

    let roundOneX = sendRoundX();
    if (roundOneX && currentStepIndex !== 4) {
        roundOneX.style.zIndex = "unset";
    }
    if (roundOne.contains(workshopOne) && currentStepIndex !== 4) {
        roundOneX.click();
    }

    if (roundOne.classList.contains("tutorial-highlight")) {
        roundOne.classList.remove("tutorial-highlight");
    }
    if (workshopOne.classList.contains("tutorial-highlight")) {
        workshopOne.classList.remove("tutorial-highlight");
    }

    tutStep.style.position = "unset";
    tutStep.style.top = "unset";
}

function firstStep() {
    defaultStyling() // resets previous styling.

    nextButton.disabled = true; // disables next button

    let iconOne = sendInfoIcon();

    iconOne.style.zIndex = "1001";

    tutStep.style.position = "relative";
    tutStep.style.top = "25%";
}

// each step with styling.
function secondStep() {
    defaultStyling() // resets previous styling.

    // rounds style
    roundOne.style.zIndex = "1001";

    roundOne.classList.add("tutorial-highlight")

    tutStep.style.position = "relative";
    tutStep.style.top = "25%";
}

function thirdStep() {
    defaultStyling() // resets previous styling.

    nextButton.disabled = true;

    // imported div.
    let workshopOne = sendWorkshop();

    // rounds style.
    roundOne.style.zIndex = "1001";

    // workshop style.
    workshopOne.style.zIndex = "1001";
    workshopOne.classList.add("tutorial-highlight")

    tutStep.style.position = "relative";
    tutStep.style.top = "25%";
}

function fourthStep() {
    defaultStyling() // resets previous styling.

    nextButton.disabled = true;

    let roundOneX = sendRoundX();

    if (roundOneX) { // Ensure it's not undefined
        roundOneX.style.zIndex = "1001";
    }

    tutStep.style.position = "relative";
    tutStep.style.top = "25%";
}

function fifthStep() {
    defaultStyling();

    // hides the overlay.
}

function cookieState() {
    var cookieSatus = false; // renderLoaded runs on first load, making status false on second load.
    if(document.cookie.match("render=loaded")) {
        cookieSatus = true;
    } else {
        cookieSatus = false;
    }
    return cookieSatus;
}