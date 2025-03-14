function toggleAccordion(button) {
    let content = button.nextElementSibling;
    let isOpen = content.style.display === "block";

    document.querySelectorAll('.accordion-content').forEach(div => div.style.display = 'none');
    document.querySelectorAll('.accordion-btn span:last-child').forEach(span => span.textContent = '+');
    document.querySelectorAll('.accordion-btn').forEach(btn => {
        btn.classList.remove('bg-orange-600', 'text-white');
        btn.classList.add('bg-blue-600', 'text-white');
    });

    if (!isOpen) {
        content.style.display = "block";
        button.querySelector('span:last-child').textContent = '-';
        button.classList.remove('bg-blue-600');
        button.classList.add('bg-orange-600', 'text-white');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accordion-content').forEach(div => div.style.display = 'none');
    document.querySelectorAll('.accordion-btn span:last-child').forEach(span => span.textContent = '+');
    document.querySelectorAll('.accordion-btn').forEach(btn => btn.classList.add('bg-blue-600', 'text-white'));
});
