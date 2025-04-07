// var rounds = document.querySelectorAll('.rounds .round')
// var workshopsContainer = document.querySelector('.main .workshops');

// var workshops = document.querySelectorAll('.workshops .workshop');

// var clickedWorkshop = document.querySelector('.clickedWorkshop');

// document.addEventListener("DOMContentLoaded", () => {
//     clickHandlers()
// });

// const onClickOutside = (element, callback) => {
//     // if (!clickedWorkshop) return;
//     document.addEventListener('click', e => {
//         if (!element.contains(e.target) && !workshops.contains(e.target)) callback();
//     });
// };

// onClickOutside(workshopsContainer, () => console.log('Hello'));

// function roundClick(round) {
//     if (!round) return;

//     console.log("end result: ", "and", round);
// }

// function workshopClick(workshop) {
//     if (!workshop) return;

//     workshop.classList.add('clickedWorkshop');
// }

// function clickHandlers() {
//     rounds.forEach(round => {
//         if (window.innerWidth < 800) {
//             round.addEventListener("click", () => roundClick(round));
//         } else {
//             round.removeEventListener("click", () => roundClick(round));
//         }
//     })

//     workshops.forEach(workshop => {
//         if (window.innerWidth < 800) {
//             workshop.addEventListener("click", () => workshopClick(workshop));
//         } else {
//             workshop.removeEventListener("click", () => workshopClick(workshop));
//         }
//     })
// }