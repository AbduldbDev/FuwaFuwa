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

            let typeMatch = true;

            if (activeType === "completed") {
                typeMatch = status === "completed";
            } else if (activeType !== "all") {
                typeMatch = status === activeType;
            }

            const priorityMatch =
                activePriority === "all" || priority === activePriority;

            const searchMatch =
                searchText === "" || search.includes(searchText);

            const column = wrapper.parentElement;

            column.style.display =
                typeMatch && priorityMatch && searchMatch ? "" : "none";
        });
    }

    // ✅ FIXED HERE
    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeType = this.dataset.status.toLowerCase(); // updated line
            applyFilters();
        });
    });

    categoryFilter.addEventListener("change", function () {
        const val = this.value.toLowerCase();
        activePriority = val === "all priority" ? "all" : val;
        applyFilters();
    });

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            searchText = this.value.toLowerCase().trim();
            applyFilters();
        });
    }

    applyFilters();
});
