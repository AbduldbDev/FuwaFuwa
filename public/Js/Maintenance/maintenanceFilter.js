document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");
    const categoryFilter = document.getElementById("categoryFilter");

    let activeStatus = "all";
    let activePriority = "all";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper.dataset.status.toLowerCase(); // use dataset
            const priority = wrapper.dataset.priority.toLowerCase();

            const statusMatch =
                activeStatus === "all" || status === activeStatus;
            const priorityMatch =
                activePriority === "all" || priority === activePriority;

            wrapper.style.display =
                statusMatch && priorityMatch ? "block" : "none";
        });
    }

    // Filter pills (status)
    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeStatus = this.dataset.status.toLowerCase();
            applyFilters();
        });
    });

    // Category filter (priority)
    categoryFilter.addEventListener("change", function () {
        const val = this.value.toLowerCase();
        activePriority = val === "all priority" ? "all" : val;
        applyFilters();
    });

    // Initial filter
    applyFilters();
});
