document.addEventListener("DOMContentLoaded", (event) => {
    console.log("DOM fully loaded and parsed");
    fetchData()
    const containers = document.querySelectorAll('.workshops .workshop');
    containers.forEach(f => f.addEventListener('mouseenter', function () {
        containers.forEach(e => {
            var div = e.querySelector('div');
            if (div) {
                div.classList.add('showText');
                div.classList.remove('hiddenText');
            }
        })
        // Only show the div for the hovered container
        var hoveredDiv = f.querySelector('div');
        if (hoveredDiv) {
            hoveredDiv.classList.remove('showText');
            hoveredDiv.classList.add('hiddenText');
        }
    }));
}); 


async function fetchData() {
    var response = await fetch("/Group-Projects/lets-connect/public/viewCapacity")
    const data = await response.json();

    if (data.status === "success") {

    }
}
