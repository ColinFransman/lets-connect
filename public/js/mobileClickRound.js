var rounds = document.querySelectorAll('.rounds .round')
var workshopsContainer = document.querySelector('.main .workshops');

var workshops = document.querySelectorAll('.workshops .workshop');

document.addEventListener("DOMContentLoaded", () => {    
    clickHandlers()
});

function roundClick(round) {
    if (!round) return;

    workshop = workshopClick();

    console.log("end result: ", workshop, "and", round);
    
    
}

function workshopClick(workshop) {
    if (!workshop) return;

    return workshop;
}

function clickHandlers() {
    rounds.forEach(round => {
        if (window.innerWidth < 800) {
            round.addEventListener("click", () => roundClick(round));
        } else {
            round.removeEventListener("click", () => roundClick(round));
        }
    })

    workshops.forEach(workshop => {
        if (window.innerWidth < 800) {
            workshop.addEventListener("click", () => workshopClick(workshop));
        } else {
            workshop.removeEventListener("click", () => workshopClick(workshop));
        }
    })
}