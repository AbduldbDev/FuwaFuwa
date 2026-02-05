document.addEventListener("DOMContentLoaded", function () {
    const filterPills = document.querySelectorAll(".filter-pill");
    const requestWrappers = document.querySelectorAll(".request-card-wrapper");

    let activeStatus = "all";

    function applyFilters() {
        requestWrappers.forEach((wrapper) => {
            const status = wrapper
                .querySelector(".request-status")
                .textContent.trim()
                .toLowerCase();

            const statusMatch =
                activeStatus === "all" || status === activeStatus;

            wrapper.style.display = statusMatch ? "block" : "none";
        });
    }

    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            activeStatus = this.dataset.status;
            applyFilters();
        });
    });
});
