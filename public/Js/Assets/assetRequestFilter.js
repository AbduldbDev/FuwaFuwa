document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const prioritySelect = document.getElementById("categoryFilter");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");

    let activeStatus = "all";
    let activePriority = "all priority";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper
                .querySelector(".request-status")
                .textContent.trim()
                .toLowerCase();

            const priority = wrapper
                .querySelector(".priority-badge")
                .textContent.trim()
                .toLowerCase();

            const statusMatch =
                activeStatus === "all" || status === activeStatus;

            const priorityMatch =
                activePriority === "all priority" ||
                priority.includes(activePriority);

            wrapper.style.display =
                statusMatch && priorityMatch ? "block" : "none";
        });
    }

    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            pill.classList.add("active");

            activeStatus = pill.textContent.trim().toLowerCase();
            applyFilters();
        });
    });

    prioritySelect.addEventListener("change", function () {
        activePriority = this.value.toLowerCase();
        applyFilters();
    });
});
