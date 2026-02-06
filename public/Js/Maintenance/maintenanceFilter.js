document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");
    const categoryFilter = document.getElementById("categoryFilter");

    let activeStatus = "all";
    let activePriority = "all";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper.dataset.status.toLowerCase();
            const priority = wrapper.dataset.priority.toLowerCase();

            const statusMatch =
                activeStatus === "all" || status === activeStatus;
            const priorityMatch =
                activePriority === "all" || priority === activePriority;

            // IMPORTANT: hide the column, not just the card
            const column = wrapper.closest(".col-lg-4");

            if (statusMatch && priorityMatch) {
                column.style.display = ""; // show
            } else {
                column.style.display = "none"; // remove from layout
            }
        });
    }

    // Status pills
    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeStatus = this.dataset.status.toLowerCase();
            applyFilters();
        });
    });

    // Priority dropdown
    categoryFilter.addEventListener("change", function () {
        const val = this.value.toLowerCase();
        activePriority = val === "all priority" ? "all" : val;
        applyFilters();
    });

    applyFilters();
});
