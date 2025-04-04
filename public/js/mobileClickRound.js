function onPageResize() {
    var rounds = document.querySelectorAll('.rounds .round')

    console.log(window.innerWidth);

    console.log(window.innerWidth < 500)
    rounds.forEach(round => {
        const handleClick = () => {
            console.log("er is geklikt in: ", round);
        }

        if (window.innerWidth < 500) {
            round.addEventListener("click", handleClick);
        } else {
            console.log("remove");
            
            round.removeEventListener("click", handleClick);
        }
    })
}

//  moonPageResize()
window.addEventListener("resize", onPageResize);