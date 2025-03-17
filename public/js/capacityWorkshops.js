const workshopContainers = document.querySelectorAll('.workshops .workshop');

const workshopContainer = document.querySelector('.main .workshops');

const inRoundContainers = document.querySelectorAll('.rounds .round');
document.addEventListener("DOMContentLoaded", (event) => {

    insertData()

    inRoundContainers.forEach(roundContainer => { // disables the element from changing inside the main rounds.
        roundContainer.addEventListener('mouseover', function () {
            var text = roundContainer.querySelector('.title');
            if (text) {
                text.classList.add('showText');
            }
        })
    })

    waitUntilApi()
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

    data.data.forEach(entry => {
        if (!workshopMap[entry.workshop_id]) {
            workshopMap[entry.workshop_id] = [];
        }
        workshopMap[entry.workshop_id].push(entry);
    });

    // Iterate over capacityText elements
    for (let i = 0; i < capacityText.length; i++) {
        if (workshopMap[i]) {
            let rounds = workshopMap[i];

            let text = rounds
                .map((round) => `Ronde ${round.wm_id}: ${round.capacity} plekken over`)
                .join("\n");

            capacityText[i].innerText = text;
        }
    }
}

async function waitUntilApi() {
    var data = await fetchData();
    if (data.status === "success") {
        handleMouseOver()
    }
}

function handleMouseOver() {

    workshopContainers.forEach(container => {
        container.addEventListener("mouseleave", () => {
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
        });

        container.addEventListener("mouseenter", () => {
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
        });
    });
}