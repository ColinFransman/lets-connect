let workshops;

function loadWorkshops_fetch() {
    let url = "http://127.0.1.3:4001/getData";
    fetch(url)
        .then(data => {
            return data.json();
        })
        .then(json => {
            fJson2Html(json);
        });
}

function fJson2Html(json) {
    workshops = "";
    for (let i = 0; i < json.Titles.length; i++) {
        workshops += 
        "<div class='workshop' id='workshop" + i + "' draggable='true' ondragstart='drag(event)'>" + 
            "<div class='info' onclick='info(event)' id='info" + i + "' tabindex='0'>i</div>" + 
            "<div class='popup' id='popup" + i + "'>" + 
                "<button class='close' onclick='closePopup(" + i + ")'>x</button>" + 
                //"<p>Lokaal: " + i + "</p>"
                "<div class='description'>" +
                    "<div class='descriptionText'>";
                    for (let d = 0; d < json.Descriptions.length; d++) {
                        if (json.Descriptions[i].description[d] !== undefined) {
                            workshops += 
                            "<p>" + json.Descriptions[i].description[d] + "</p>";
                        }
                    }
                    workshops +=
                    "</div>" +
                    "<div class='descriptionImage'><img src='" + json.Images[i].image[1] + "'></div>" + 
                "</div>" + 
            "</div>" + 
            "<div class='title' id='title" + i + "'>" + json.Titles[i] + "</div>" + 
        "</div>";
    }
    document.getElementById(4).innerHTML = workshops;
    }

loadWorkshops_fetch();