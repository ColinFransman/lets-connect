var rounds = document.querySelectorAll('.rounds .round')
var workshopsContainer = document.querySelector('.main .workshops');

var workshops = document.querySelectorAll('.workshops .workshop');

var clickedWorkshop = document.querySelector('.clickedWorkshop');

document.addEventListener("DOMContentLoaded", () => {
    clickedRound()
});

async function roundClick(round) {
    if (!round) return;

    const popup = document.getElementById("workshopsPopup");
    popup.style.display = "flex";
    if(!popup) return;
    var loader = popup.querySelector('.loader');
    loader.style.display = "inline-block";
    
    try {
        var data = await fetchData();
        console.log(data);
        loader.style.display = "none";
    } catch {

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

async function fetchData() {
    var response = await fetch("/Capacity")
    const data = await response.json();

    if (data.status === "success") {
        return data;
    }
    return;
}