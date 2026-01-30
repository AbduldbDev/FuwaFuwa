const tabs = document.querySelectorAll(".tab");
const contents = document.querySelectorAll(".tab-content");
const indicator = document.querySelector(".tab-indicator");

/* Set default indicator */
window.onload = () => {
    moveIndicator(document.querySelector(".tab.active"));
};

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");

        contents.forEach((c) => c.classList.remove("active"));
        document.getElementById(tab.dataset.tab).classList.add("active");

        moveIndicator(tab);
    });
});

function moveIndicator(tab) {
    const tabRect = tab.getBoundingClientRect();
    const parentRect = tab.parentElement.getBoundingClientRect();

    const extraWidth = 20; // pixels (8px on each side)

    indicator.style.width = `${tabRect.width + extraWidth}px`;
    indicator.style.transform = `translateX(${
        tabRect.left - parentRect.left - extraWidth / 2
    }px)`;
}

/* Collapsible sections */
function toggleSection(header) {
    const card = header.closest(".section-card");
    card.classList.toggle("collapsed");
}
