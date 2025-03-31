var mainPopup = document.getElementById('dataPopup');
var popupText = document.getElementById('userData');

// buttons
var buttonYes = document.querySelector('.popupButtonYes');
var buttonNo = document.querySelector('.popupButtonNo');

document.addEventListener("DOMContentLoaded", function() {

    const form = document.querySelector(".register-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Stop form from submitting immediately
        
        const name = form.querySelector('input[name="name"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const select = form.querySelector('select[name="opleiding"]');
        const course = select.options[select.selectedIndex].text;
        const klas = form.querySelector('select[name="klas"]').value;

        const text = `Naam: ${name}\nEmail: ${email}\nOpleiding: ${course}\nKlas: ${klas}`;

        mainPopup.style.display = "flex";

        popupText.innerText = text;
        
        buttonYes.addEventListener("click", function () {
            form.submit();
        })

        buttonNo.addEventListener("click", function () {
            mainPopup.style.display = "none";
        })
    });
});