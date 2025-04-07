var rounds = document.querySelectorAll('.rounds .round')
var workshopsContainer = document.querySelector('.main .workshops');

var workshops = document.querySelectorAll('.workshops .workshop');

var clickedWorkshop = document.querySelector('.clickedWorkshop');

document.addEventListener("DOMContentLoaded", () => {
    clickedRound()
});

async function roundClick(round) {
    if (!round) return;
    var roundNumber = round.getAttribute('id')
    roundNumber = Number(roundNumber)

    const popup = document.getElementById("workshopsPopup");
    popup.style.display = "flex";
    if(!popup) return;
    var loader = popup.querySelector('.loader');
    loader.style.display = "inline-block";
    
    try {
        var data = await fetchUserData();
        console.log(data);
        loader.style.display = "none";
        
        const filtered = data
        .map(workshop => {
          const moment = workshop.moments.find(m => m.ronde === roundNumber);
          if (moment) {
            return {
              workshop_name: workshop.workshop_name,
              ...moment
            };
          }
          return null;
        })
        .filter(Boolean);

        console.log(`Workshops for round ${roundNumber}:`, filtered);
        return filtered;
    } catch {
        return;
    }
}

function clickedRound() {
    rounds.forEach(round => {
        if (window.innerWidth < 800) {
            round.addEventListener("click", () => roundClick(round));
        } else {
            round.removeEventListener("click", () => roundClick(round));
        }
    })
}

async function fetchUserData() {
    var response = await fetch("/Capacity")
    const data = await response.json();

    if (data.status === "success") {
        return data.data;
    }
    return;
}

async function insertIntoElements() {
    var workshops = await fetchUserData();

        
}