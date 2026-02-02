document.addEventListener("DOMContentLoaded", function () {
    // const complianceFilter = document.getElementById("departmentFilter");
    const statusFilter = document.getElementById("accountStatusFilter");

    const vendorCards = document.querySelectorAll(".vendor-card");

    function applyFilters() {
        const status = statusFilter.value;

        vendorCards.forEach((card) => {
            // const cardCompliance = card.dataset.compliance;
            const cardStatus = card.dataset.status;

            // const matchCompliance =
            //     compliance === "all" || cardCompliance === compliance;

            const matchStatus = status === "all" || cardStatus === status;

            // card.style.display = matchCompliance && matchStatus ? "" : "none";

            card.style.display = matchStatus ? "" : "none";
        });
    }

    // complianceFilter.addEventListener("change", applyFilters);
    statusFilter.addEventListener("change", applyFilters);
});
