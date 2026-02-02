document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const prioritySelect = document.getElementById("categoryFilter");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");

    let activeStatus = "all";
    let activePriority = "all priority";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper.dataset.status;
            const priority = wrapper.dataset.priority;

            const statusMatch =
                activeStatus === "all" || status === activeStatus;

            const priorityMatch =
                activePriority === "all priority" ||
                priority === activePriority;

            wrapper.closest(".col-lg-4").style.display =
                statusMatch && priorityMatch ? "block" : "none";
        });
    }

    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeStatus = this.textContent.trim().toLowerCase();
            applyFilters();
        });
    });

    prioritySelect.addEventListener("change", function () {
        activePriority = this.value.toLowerCase();
        applyFilters();
    });
});
