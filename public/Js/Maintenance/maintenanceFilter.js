document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");
    const categoryFilter = document.getElementById("categoryFilter");
    const searchInput = document.getElementById("searchFilter");

    let activeType = "all";
    let activePriority = "all";
    let searchText = "";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const type = wrapper.dataset.type;
            const status = wrapper.dataset.status;
            const priority = wrapper.dataset.priority;
            const search = wrapper.dataset.search;

            // Type filter
            let typeMatch = true;
            if (activeType === "completed") {
                typeMatch = status === "completed";
            } else if (activeType !== "all") {
                typeMatch = type === activeType && status !== "completed";
            }

            // Priority filter
            const priorityMatch =
                activePriority === "all" || priority === activePriority;

            // Search filter
            const searchMatch =
                searchText === "" || search.includes(searchText);

            const column = wrapper.closest(".col-lg-4");

            column.style.display =
                typeMatch && priorityMatch && searchMatch ? "" : "none";
        });
    }

    // Status pills
    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeType = this.dataset.type;
            applyFilters();
        });
    });

    // Priority dropdown
    categoryFilter.addEventListener("change", function () {
        const val = this.value.toLowerCase();
        activePriority = val === "all priority" ? "all" : val;
        applyFilters();
    });

    // Search input
    searchInput.addEventListener("input", function () {
        searchText = this.value.toLowerCase().trim();
        applyFilters();
    });

    applyFilters();
});
