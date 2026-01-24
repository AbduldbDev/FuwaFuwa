document.addEventListener("DOMContentLoaded", function () {
    const departmentFilter = document.getElementById("departmentFilter");
    const roleFilter = document.getElementById("roleFilter");
    const statusFilter = document.getElementById("accountStatusFilter");

    const userCards = document.querySelectorAll(".user-card");

    function applyDropdownFilters() {
        const department = departmentFilter.value;
        const role = roleFilter.value;
        const status = statusFilter.value;

        userCards.forEach((card) => {
            const cardDepartment = card.dataset.department;
            const cardRole = card.dataset.role;
            const cardStatus = card.dataset.status;

            const matchDepartment =
                department === "all" || cardDepartment === department;

            const matchRole = role === "all" || cardRole === role;

            const matchStatus = status === "all" || cardStatus === status;

            card.style.display =
                matchDepartment && matchRole && matchStatus ? "" : "none";
        });
    }

    departmentFilter.addEventListener("change", applyDropdownFilters);
    roleFilter.addEventListener("change", applyDropdownFilters);
    statusFilter.addEventListener("change", applyDropdownFilters);
});
