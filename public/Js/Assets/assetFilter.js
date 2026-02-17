document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const complianceFilter = document.getElementById("complianceFilter");

    function normalize(text) {
        return text.replace(/\s+/g, " ").trim().toLowerCase();
    }

    function filterTable() {
        const searchValue = normalize(searchInput.value);
        const categoryValue = normalize(categoryFilter.value);
        const statusValue = normalize(statusFilter.value);
        const complianceValue = normalize(complianceFilter.value);

        const rows = document.querySelectorAll("#assetTable tbody tr");

        rows.forEach((row) => {
            const rowText = normalize(row.innerText);

            const rowCategory = normalize(row.children[2]?.innerText || "");
            const rowStatus = normalize(row.children[4]?.innerText || "");
            const rowCompliance = normalize(row.children[5]?.innerText || "");

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

    searchInput.addEventListener("input", filterTable);
    categoryFilter.addEventListener("change", filterTable);
    statusFilter.addEventListener("change", filterTable);
    complianceFilter.addEventListener("change", filterTable);
});
