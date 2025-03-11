document.addEventListener("DOMContentLoaded", (event) => {

    insertData()

    const containers = document.querySelectorAll('.workshops .workshop');
    const container = document.querySelector('.main .workshops');

    containers.forEach(f => f.addEventListener('mouseover', function () {
        containers.forEach(e => {
            var hoveredDiv = e.querySelector('.title');
            var hoverCapText = e.querySelector('.capacityText')
            
            if (hoveredDiv) {
                hoveredDiv.classList.remove('hiddenText');
                hoveredDiv.classList.add('showText');
            }

            if (hoverCapText) {
                hoverCapText.classList.remove('showText');
                hoverCapText.classList.add('hiddenText');
            }
        })
        // Only show the div for the hovered container.
        var unHoveredDiv = f.querySelector('.title');
        var unHoverCapText = f.querySelector('.capacityText');

        if (unHoveredDiv) {
            unHoveredDiv.classList.remove('showText');
            unHoveredDiv.classList.add('hiddenText');
        }

        if (unHoverCapText) {
            unHoverCapText.classList.remove('hiddenText');
            unHoverCapText.classList.add('showText');
        }

        if (container) {  // Check if container exists
            container.addEventListener('mouseout', function () { // shows the text if hovered out of the container.
                var titles = container.querySelectorAll('.title'); // Get all matching elements
                titles.forEach(title => {
                    title.classList.add('showText');
                    title.classList.remove('hiddenText');
                });
                
                var capTexts = container.querySelectorAll('.capacityText');
                capTexts.forEach(capText => {
                    capText.classList.add('hiddenText');
                    capText.classList.remove('showText');
                })
            });
        }
    }));
});


async function fetchData() {
    var response = await fetch("/Group-Projects/lets-connect/public/viewCapacity")
    const data = await response.json();

    if (data.status === "success") {
        return data;
    }
    return;
}

async function insertData() {
    var data = await fetchData();
    var capacityText = document.querySelectorAll('.capacityText');
    
    for (let i = 0; i < capacityText.length; i++) {
        let matched = false;
    
        for (let j = 0; j < data.data.length; j++) {
            if (data.data[j].workshop_id === i) {
                matched = true;
                // console.log(`Workshop ID ${data.data[j].workshop_id} at index ${i}, with moment: ${data.data[j].moment_id}`);


                capacityText[i].innerText = "Ronde 1: " + data.data[j].capacity + " plekken over";
                // capacityText
                console.log(data.data[j].capacity);

                // for (let k = 0; k < data.data.length; k++) {
                    
                //     console.log("rounds: ", k);
                    
                // }
            }
        }
    
        if (!matched) {
            // console.log(`Index ${i}: undefined`);
        }
    }
}
