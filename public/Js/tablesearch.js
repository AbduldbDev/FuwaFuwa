const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const rows = document.querySelectorAll("#assetTable tbody tr");

function filterTable() {
    const searchValue = searchInput.value.toLowerCase();
    const categoryValue = categoryFilter.value;

    rows.forEach((row) => {
        const rowText = row.innerText.toLowerCase();
        const rowCategory =
            row.querySelector("[data-category]").dataset.category;

        const matchesSearch = rowText.includes(searchValue);
        const matchesCategory =
            categoryValue === "all" || rowCategory === categoryValue;

        row.style.display = matchesSearch && matchesCategory ? "" : "none";
    });
}

searchInput.addEventListener("keyup", filterTable);
categoryFilter.addEventListener("change", filterTable);
