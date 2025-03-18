const workshopContainers = document.querySelectorAll('.workshops .workshop');

const workshopContainer = document.querySelector('.main .workshops');

const inRoundContainers = document.querySelectorAll('.rounds .round');
document.addEventListener("DOMContentLoaded", (event) => {

    insertData()

    waitUntilApi()

    whenWorkshopIsFull()
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

            let text = rounds
                .map((round, i) => {
                    let spotsLeft = round.capacity - round.bookings;
                    return `Ronde ${i + 1}: ${spotsLeft > 0 ? spotsLeft + " plekken over" : "workshop zit vol!"}`;
                })
                .join("\n");

            element.innerText = text;
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

function whenWorkshopIsFull() {
    const observer = new MutationObserver((mutationsList, observer) => {
        if (inRoundContainers) {
            console.log(inRoundContainers);
            
            console.log(inRoundContainers.contains('workshop'));
            // if (inRoundContainers.contains('.workshop')) {
            //     console.log("true2");
            // }
            console.log("true");

            observer.disconnect();
        }
    });
    observer.observe(document.body, { childList: true, subtree: true });
}