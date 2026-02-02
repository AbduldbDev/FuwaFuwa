document.addEventListener("DOMContentLoaded", function () {
    const assetTypeSelect = document.querySelector('select[name="asset_type"]');
    const assetCategorySelect = document.querySelector(
        'select[name="asset_category"]',
    );

    // Store original options
    const allOptions = Array.from(assetCategorySelect.options);

    // Mapping for each asset type
    const categoryMap = {
        "Physical Asset": [
            "PC",
            "Laptop",
            "Router",
            "Firewall",
            "Switch",
            "Modem",
            "Communication Cabinet",
            "Server Cabinet",
        ],
        "Digital Asset": ["License"], // Only license for digital
    };

    assetTypeSelect.addEventListener("change", function () {
        const selectedType = this.value;

        // Clear current options
        assetCategorySelect.innerHTML = "";

        // Get allowed categories
        const allowed = categoryMap[selectedType] || [];

        // Add a default placeholder
        assetCategorySelect.innerHTML =
            '<option value="" selected disabled>Choose asset category</option>';

        // Add only allowed options
        allOptions.forEach((opt) => {
            if (allowed.includes(opt.value)) {
                assetCategorySelect.appendChild(opt);
            }
        });
    });
});
