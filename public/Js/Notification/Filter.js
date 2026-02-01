document.addEventListener("DOMContentLoaded", function () {
    const notifRows = document.querySelectorAll(".notif-row");
    const filterPills = document.querySelectorAll(".filter-pill");
    const typeSelect = document.getElementById("notificationType");
    const timeSelect = document.getElementById("timeRangeFilter");

    let currentFilter = "all";

    let currentType = "all";

    let currentTime = "all";

    filterPills.forEach((pill) => {
        pill.addEventListener("click", function () {
            filterPills.forEach((p) => p.classList.remove("active"));
            this.classList.add("active");

            currentFilter = this.textContent.trim().toLowerCase();
            console.log("Filter changed to:", currentFilter);
            filterNotifications();
        });
    });

    typeSelect.addEventListener("change", function () {
        currentType = this.value.toLowerCase();
        if (currentType === "notification type") {
            currentType = "all";
        }
        console.log("Type changed to:", currentType);
        filterNotifications();
    });

    timeSelect.addEventListener("change", function () {
        currentTime = this.value;
        console.log("Time changed to:", currentTime);
        filterNotifications();
    });

    function filterNotifications() {
        console.log("Filtering with:", {
            filter: currentFilter,
            type: currentType,
            time: currentTime,
        });

        const now = new Date();
        let visibleCount = 0;

        notifRows.forEach((row) => {
            const readStatus = row.dataset.read;

            const moduleType = row.dataset.module
                ? row.dataset.module.toLowerCase()
                : "";
            const notifDate = new Date(row.dataset.created);

            const filterMatch =
                currentFilter === "all" ||
                (currentFilter === "read" && readStatus === "read") ||
                (currentFilter === "unread" && readStatus === "unread");

            const typeMatch =
                currentType === "all" || moduleType.includes(currentType);

            let timeMatch = true;
            if (currentTime !== "all") {
                const diffDays = Math.floor(
                    (now - notifDate) / (1000 * 60 * 60 * 24),
                );

                switch (currentTime) {
                    case "today":
                        timeMatch = diffDays === 0;

                        break;
                    case "7days":
                        timeMatch = diffDays <= 7 && diffDays >= 0;
                        break;
                    case "30days":
                        timeMatch = diffDays <= 30 && diffDays >= 0;
                        break;
                    default:
                        timeMatch = true;
                }
            }

            const shouldShow = filterMatch && typeMatch && timeMatch;
            row.style.display = shouldShow ? "" : "none";

            if (shouldShow) visibleCount++;
        });

        console.log("Visible notifications:", visibleCount);
    }

    filterNotifications();
});
