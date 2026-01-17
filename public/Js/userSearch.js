document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-box input");
    const columns = document.querySelectorAll(".col-lg-3.col-md-6");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim().toLowerCase();

        columns.forEach((col) => {
            const card = col.querySelector(".profile-card");
            const text = card.innerText.toLowerCase();

            col.style.display = text.includes(query) ? "" : "none";
        });
    });
});
