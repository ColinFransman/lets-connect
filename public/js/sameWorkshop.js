
const observer = new MutationObserver((mutationsList, observer) => {
    var dupes = checkDupe();
    console.log(dupes);
    


    console.log("Duplicates found")
});

observer.observe(document.body, { childList: true, subtree: true });

function checkDupe() {
    var rounds = document.querySelector('.main .rounds');
    var workshops = rounds.querySelectorAll('.workshop')

    if (!workshops) return;

    var allTitles = []
    workshops.forEach(workshop => {
        var text = workshop.querySelector('.title').innerHTML;

        if (!text) return;

        var truncatedText = text.substring(0, 13); // Removes the second element

        allTitles.push(truncatedText)
    })
    const hasDuplicates = allTitles.some((item, index) => allTitles.indexOf(item) !== index);

    if (!hasDuplicates) return;

    return hasDuplicates;
}