document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const table = document.getElementById("assetTable");
    const rows = table.querySelectorAll("tbody tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedType = typeFilter.value.toLowerCase();

        rows.forEach((row) => {
            const type = row.children[1]?.textContent.toLowerCase() || "";
            const category = row.children[2]?.textContent.toLowerCase() || "";
            const user = row.children[3]?.textContent.toLowerCase() || "";

            const matchesSearch =
                type.includes(searchValue) ||
                category.includes(searchValue) ||
                user.includes(searchValue);

            const matchesType = selectedType === "all" || type === selectedType;

            if (matchesSearch && matchesType) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Events
    searchInput.addEventListener("keyup", filterTable);
    typeFilter.addEventListener("change", filterTable);
});
