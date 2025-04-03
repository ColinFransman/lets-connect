const workshopContainers = document.querySelectorAll('.workshops .workshop');

const workshopContainer = document.querySelector('.main .workshops');

const inRoundContainers = document.querySelectorAll('.rounds .round:nth-child(2)');

var roundAmountIds = [];
inRoundContainers.forEach(container => {
    var id = container.getAttribute('id');
    roundAmountIds.push(id)
})

document.addEventListener("DOMContentLoaded", (event) => {
    insertData()

    waitUntilApi()

    workshopCheckRules()
});


async function fetchData() {
    var response = await fetch("/viewCapacity")
    const data = await response.json();

    if (data.status === "success") {
        return data;
    }
    return;
}

async function insertData() {
    var data = await fetchData();

    var capacityText = document.querySelectorAll('.capacityText');

    // Create a map to store workshops by ID
    let workshopMap = {};

    // Populate the workshopMap
    data.data.forEach(workshop => {
        workshop.moments.forEach(entry => {
            if (!workshopMap[entry.workshop_id]) {
                workshopMap[entry.workshop_id] = [];
            }
            workshopMap[entry.workshop_id].push(entry);
        });
    });

    // Iterate over capacityText elements
    capacityText.forEach((element, index) => {
        let workshopId = index + 1; // Assuming workshop IDs start from 1 and align sequentially
        if (workshopMap[workshopId]) {
            let rounds = workshopMap[workshopId];

            // Sort rounds by wm_id to ensure correct ordering
            rounds.sort((a, b) => a.wm_id - b.wm_id);

            let text = rounds
                .map(round => {
                    let spotsLeft = round.capacity - round.bookings;
                    var roundCount = round.wm_id % 3;
                    if (roundCount == 0) {
                        roundCount = roundCount + 3;
                    }
                    return `<p> Ronde ${roundCount}: ${spotsLeft > 0 ? spotsLeft + " plek(ken) over" : "workshop zit vol!"} </p>`;
                })
                .join("\n");

            element.innerHTML = text;
        }
    });

}

async function waitUntilApi() {
    var data = await fetchData();
    if (data.status === "success") {
        handleMouseOver()
    }
}

function handleMouseOver() {
    var hoverState = true;
    inRoundContainers.forEach(roundContainer => { // disables the element from changing inside the main rounds.
        roundContainer.addEventListener('mouseenter', function () {

            var text = roundContainer.querySelector('.title');
            if (text) {
                hoverState = false;
                text.classList.remove('hiddenText');
                text.classList.add('showText');
            }
        })
    })

    workshopContainers.forEach(container => {
        container.addEventListener("mouseleave", () => {

            if (hoverState) {
                const hoveredDiv = container.querySelector('.title');
                const hoverCapText = container.querySelector('.capacityText');

                if (hoveredDiv) {
                    hoveredDiv.classList.remove('hiddenText');
                    hoveredDiv.classList.add('showText');
                }

                if (hoverCapText) {
                    hoverCapText.classList.remove('showText');
                    hoverCapText.classList.add('hiddenText');
                }
            } else {
                hoverState = true;
            }
        });

        container.addEventListener("mouseenter", () => {
            if (hoverState) {
                const hoveredDiv = container.querySelector('.title');
                const hoverCapText = container.querySelector('.capacityText');

                if (hoveredDiv) {
                    hoveredDiv.classList.remove('showText');
                    hoveredDiv.classList.add('hiddenText');
                }

                if (hoverCapText) {
                    hoverCapText.classList.remove('hiddenText');
                    hoverCapText.classList.add('showText');
                }
            } else {
                hoverState = true;
            }
        });
    });
}

function workshopCheckRules() {
    const observer = new MutationObserver((mutationsList, observer) => {

        if (!document.cookie.match("workshopWhile=removed")) return;
        if (!inRoundContainers) return;

        ifFullWorkshop()

        ifEmptyRound()
    });

    observer.observe(document.body, { childList: true, subtree: true });
}

function ifFullWorkshop() {
    inRoundContainers.forEach(container => {

        let workshopElement = container.querySelector('.workshop'); // foreach container grabs the workshop.

        if (!workshopElement) return; // if any workshop exists
        var capacityElement = workshopElement.querySelectorAll('.capacityText p');

        if (!capacityElement) return; // if cap text exists inside workshop.

        var closeIcon = container.querySelector('.close-button');
        var disabledRounds = [];

        capacityElement.forEach(text => {
            if (!text.textContent) return;

            var numbersText = text.textContent.replace(/\D/g, "");

            if (numbersText.length === 1) {
                disabledRounds.push(numbersText)
            }
        })

        var roundID = container.getAttribute('id')

        for (let i = 0; i < disabledRounds.length; i++) {
            if (disabledRounds[i] === roundID) { // disables the round based on 
                showErrorPopup("Deze ronde zit vol!")
                var closeIcon = container.querySelector('.close-button');
                closeIcon.click()
                return;
            }
        }
    });
}

function ifEmptyRound() {
    inRoundContainers.forEach(container => {
        let workshopElement = container.querySelector('.workshop'); // foreach container grabs the workshop.
        
        if (!workshopElement) return; // if any workshop exists
        var capacityElement = workshopElement.querySelectorAll('.capacityText p');

        var disabledRounds = [];
        capacityElement.forEach(text => {
            if (!text.textContent) return;

            var numbersText = text.textContent.replace(/\D/g, "");

            console.log(numbersText);

            disabledRounds.push(numbersText)
        })

        console.log(disabledRounds);
        
    });
    
}