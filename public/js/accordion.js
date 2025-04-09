function toggleAccordion(button) {
    let content = button.nextElementSibling;
    let isOpen = content.style.display === "block";
    console.log(button)
    button.parentNode.querySelector('.accordion-content').style.display = 'none';
    button.parentNode.querySelector('.accordion-btn span:last-child').textContent = '+';
    button.parentNode.querySelector('.accordion-btn').classList.remove('bg-orange-600');
    button.parentNode.querySelector('.accordion-btn').classList.add('bg-blue-600');

    if (!isOpen) {
        content.style.display = "block";
        button.querySelector('span:last-child').textContent = '-';
        button.classList.remove('bg-blue-600');
        button.classList.add('bg-orange-600');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accordion-content').forEach(div => div.style.display = 'block');
    document.querySelectorAll('.accordion-btn span:last-child').forEach(span => span.textContent = '-');
    document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.add('bg-orange-600', 'text-white'));
});

let collapsed = true;

function toggleAccordionAll(elem) {
    if (collapsed) {
        document.querySelectorAll('.accordion-content').forEach(div => div.style.display = 'none');
        document.querySelectorAll('.accordion-btn span:last-child').forEach(span => span.textContent = '+');
        document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.remove('bg-orange-600'));
        document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.add('bg-blue-600'));
        elem.innerText = "Alles Uitklappen";
        collapsed = false;
    } else {
        document.querySelectorAll('.accordion-content').forEach(div => div.style.display = 'block');
        document.querySelectorAll('.accordion-btn span:last-child').forEach(span => span.textContent = '-');
        document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.remove('bg-blue-600'));
        document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.add('bg-orange-600'));
        elem.innerText = "Alles Inklappen";
        collapsed = true;
    }
}