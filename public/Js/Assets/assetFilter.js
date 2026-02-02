document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const complianceFilter = document.getElementById("complianceFilter");

    const rows = document.querySelectorAll("#assetTable tbody tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const complianceValue = complianceFilter.value.toLowerCase();

        rows.forEach((row) => {
            const rowText = row.innerText.toLowerCase();

            const rowCategory = row.children[2].innerText.toLowerCase();
            const rowStatus = row.children[4].innerText.toLowerCase();
            const rowCompliance = row.children[5].innerText.toLowerCase();

            const matchesSearch = rowText.includes(searchValue);
            const matchesCategory =
                categoryValue === "all" || rowCategory === categoryValue;
            const matchesStatus =
                statusValue === "all" || rowStatus === statusValue;
            const matchesCompliance =
                complianceValue === "all" || rowCompliance === complianceValue;

            row.style.display =
                matchesSearch &&
                matchesCategory &&
                matchesStatus &&
                matchesCompliance
                    ? ""
                    : "none";
        });
    }

    searchInput.addEventListener("keyup", filterTable);
    categoryFilter.addEventListener("change", filterTable);
    statusFilter.addEventListener("change", filterTable);
    complianceFilter.addEventListener("change", filterTable);
});
