document.addEventListener("DOMContentLoaded", function () {
    const assetTypeSelect = document.querySelector('select[name="asset_type"]');
    const assetCategorySelect = document.querySelector(
        'select[name="asset_category"]',
    );

    assetTypeSelect.addEventListener("change", function () {
        const selectedType = this.value;

        // Clear dropdown
        assetCategorySelect.innerHTML =
            '<option value="" selected disabled>Choose asset category</option>';

        // Filter categories based on type
        const filtered = categories.filter((cat) => cat.type === selectedType);

        // Append filtered options
        filtered.forEach((cat) => {
            const option = document.createElement("option");
            option.value = cat.name;
            option.textContent = cat.name;
            assetCategorySelect.appendChild(option);
        });
    });
});
