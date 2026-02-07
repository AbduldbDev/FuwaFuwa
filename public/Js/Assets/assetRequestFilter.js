document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");
    const searchInput = document.getElementById("requestSearch");

    let activeStatus = "all";
    let searchTerm = "";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper.dataset.status;
            const searchableText = wrapper.dataset.search;

            const statusMatch =
                activeStatus === "all" || status === activeStatus;

            const searchMatch = searchableText.includes(searchTerm);

            wrapper.style.display =
                statusMatch && searchMatch ? "block" : "none";
        });
    }

    // Status filter
    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeStatus = this.dataset.status;
            applyFilters();
        });
    });

    // Search filter
    searchInput.addEventListener("input", function () {
        searchTerm = this.value.toLowerCase().trim();
        applyFilters();
    });
});
